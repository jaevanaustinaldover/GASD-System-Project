<?php
	$page_title = "Choose a Venue";
    include_once('../../includes/header_navbar.php');

    # Search Bar Configuration
    if (isset($_POST['search']))
    {
    	$keyword = mysqli_real_escape_string($con, $_POST['keyword']);
    	header('location: choosevenue.php?s=' . $keyword);
    }

    # Get Campus
    if (isset($_REQUEST['c']))
    {
    	if (ctype_digit($_REQUEST['c']))
		{
			$campusid = $_REQUEST['c'];
			# displays list of venues based from campuses
		    $sql_venues = "SELECT v.venueID, v.venueName, v.floor, 
		    	c.campusName, v.image, v.dateAdded, v.dateModified FROM venues v 
		    	INNER JOIN venuecampus c ON v.campusID = c.campusID 
		    	WHERE v.campusID = $campusid";
		}
		else
		{
			header('location: choosevenue.php');
		}
    }

    else if (isset($_REQUEST['s']))
    {
    	$filter = "'%" . $_REQUEST['s'] . "%'";
    	# displays list of products based from keyword

		$sql_venues = "SELECT v.venueID, v.venueName, v.floor, c.campusName, 
			v.image, v.dateAdded, v.dateModified FROM venues v 
			INNER JOIN venuecampus c ON c.campusID = v.campusID 
			WHERE (c.campusName LIKE $filter OR 
			v.venueName LIKE $filter OR 
			v.floor LIKE $filter)";
		
    }

    else
    {
    	$sql_venues = "SELECT v.venueID, v.venueName, v.floor, 
		    	c.campusName, v.dateAdded, v.dateModified FROM venues v 
		    	INNER JOIN venuecampus c ON v.campusID = c.campusID";
    }

    #Display Venues
    $result_venues = $con->query($sql_venues);

    # Display Campuses
    $sql_campus = "SELECT c.campusID, c.campusName as Campus,
    	(SELECT COUNT(venueID) FROM venues 
    	WHERE campusID = c.campusID) AS totalCount 
    	FROM venuecampus c 
    	ORDER BY c.campusName";

    $result_campus = $con->query($sql_campus);

    # Get Total Data
    $sql_count = "SELECT COUNT(venueID) AS Total FROM 'venues'";
	$result_total = $con->query($sql_count);
	//$data = mysqli_fetch_assoc($result_total);

	# Skip
	if(isset($_POST['skip']))
	{
		session_start();
		$eventNo = $_SESSION['eventno'];

		$sql_skip = "INSERT INTO venuedetails VALUES ('', $eventNo, NULL, 
			NULL, NULL, NULL, NULL, 'N/A')";
		$con -> query($sql_skip) or die(mysqli_error($con));
		header('location: equip.php');
	}

?>

<form method="POST" class="form-horizontal">
	<div class="col-lg-3">
		<div class="input-group">
			<input name="keyword" class="form-control" placeholder="Keyword..." />
			<span class="input-group-btn">
				<button name="search" type="submit" class="btn">
					<i class="fa fa-search"></i>
				</button>
			</span>
		</div>
		<br/>
		<div class="list-group">
			<a href='choosevenue.php' class='list-group-item'>
				<span class='badge'><?php //echo $data; ?></span>
				All Categories
			</a>
			<?php
				while ($row = mysqli_fetch_array($result_campus))
				{
					$cid = $row['campusID'];
					$campus = $row['Campus'];
					$total = $row['totalCount'];

					echo "
						<a href='choosevenue.php?c=$cid' class='list-group-item'>
							<span class='badge'>$total</span>
							$campus
						</a>
					";
				}
			?>
		</div>
		<div class="col-lg-push-3 col-lg-12">
			<button name="skip" type="submit" class="btn btn-info btn-lg">
				<strong>Skip</strong>
			</button>
		</div>
	</div>

	<div class="col-lg-9">
		<?php
			if (mysqli_num_rows($result_venues) > 0)
			{
				while ($row = mysqli_fetch_array($result_venues))
				{
					$venueid = $row["venueID"];
					$venuename = $row["venueName"];
					$venuefloor = $row["floor"];
					$campusname = $row["campusName"];
					//Removed Image
					//$image = $row["image"];
					//<div class='ratio' style=\"background-image: url('images/venues/$image')\"></div>

					echo "
						<a href='addvenue.php?id=$venueid' class='venues'>
							<div class='col-lg-4'>
								<div class='thumbnail'>
									


									<div class='caption'>
										<h3>$venuename</h3>
										<small>$campusname</small><br/>
										$venuefloor
										<hr/>
										<a href='addvenue.php?id=$venueid' class='btn btn-success 
										btn-block'>
											<i class='fa fa-calendar'></i> View Schedule
										</a>
									</div>
								</div>
							</div>
						</a>
					";
				}
			}
			else
			{
				echo "
					<div class='col-lg-12'>
						<div class='thumbnail'>
							<br/>
							<br/>
							<h2 class='text-center'>No records found.</h2>
							<br/>
							<br/>
						</div>
					</div>
				";
			}
		?>
	</div>
</form>

<?php
	include_once('../../includes/footer.php');
?>