<?php

	$page_title = "Choose Manpower Services";
	include_once('../../includes/header_navbar.php');

	if (isset($_POST['search']))
    {
    	$keyword = mysqli_real_escape_string($con, $_POST['keyword']);
    	header('location: vehicle.php?s=' . $keyword);
    }

    # Get Campus
    if (isset($_REQUEST['c']))
    {
    	if (ctype_digit($_REQUEST['c']))
		{
			$catid = $_REQUEST['c'];
			# displays list of venues based from campuses

		    $sql_support = "SELECT m.serviceID, c.categoryName, m.serviceName, 
		    	m.serviceDescription, m.status, m.dateAdded, m.dateModified 
		    	FROM manpowers m INNER JOIN manpowercategory c ON 
		    	m.catID = c.catID WHERE m.catID = $catid";
		}
		else
		{
			header('location: vehicle.php');
		}
    }

    else if (isset($_REQUEST['s']))
    {
    	$filter = "'%" . $_REQUEST['s'] . "%'";
    	# displays list of products based from keyword
		
		$sql_support = "SELECT m.serviceID, c.categoryName, m.serviceName, 
		    	m.serviceDescription, m.status, m.dateAdded, m.dateModified 
		    	FROM manpowers m INNER JOIN manpowercategory c ON 
		    	m.catID = c.catID 
		    	WHERE (c.categoryName LIKE $filter OR 
		    		m.serviceName LIKE $filter OR 
		    		m.serviceDescription LIKE $filter)";
		
    }

    else
    {

		$sql_support = "SELECT m.serviceID, c.categoryName, m.serviceName, 
		    	m.serviceDescription, m.status, m.dateAdded, m.dateModified 
		    	FROM manpowers m INNER JOIN manpowercategory c ON 
		    	m.catID = c.catID";
    }

    #Display Venues
    $result_support = $con->query($sql_support) or die(mysqli_error($con));

    # Display Campuses

    $sql_category = "SELECT c.catID, c.categoryName as catName,
    	(SELECT COUNT(serviceID) FROM manpowers 
    	WHERE catID = c.catID) AS totalCount FROM manpowercategory c 
		ORDER BY c.categoryName";

    $result_category = $con->query($sql_category) or die(mysqli_error($con));

    # Get Total Data
    $sql_count = "SELECT COUNT(venueID) AS Total FROM 'venues'";
	$result_total = $con->query($sql_count);
	//$data = mysqli_fetch_assoc($result_total);

	# UPDATE equipmentdetails refNo
	if(isset($_POST['add']))
	{
		session_start();
		$eventNo = $_SESSION['eventno'];

		$sql_update = "UPDATE manpowerdetails SET status = 'Pending'
			WHERE eventNo = '$eventNo'";
		$con -> query($sql_update) or die(mysqli_error($con));
		header('location: vehicle.php');
	}
	else if(isset($_POST['skip']))
	{
		session_start();
		$eventNo = $_SESSION['eventno'];

		$sql_skip = "INSERT INTO manpowerdetails VALUES ('', $eventNo, NULL, 
			NULL, NULL, 'N/A', 'N/A')";
		$con -> query($sql_skip) or die(mysqli_error($con));
		header('location: vehicle.php');
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
			<a href='vehicle.php' class='list-group-item'>
				<span class='badge'><?php //echo $data; ?></span>
				All Categories
			</a>
			<?php
				while ($row = mysqli_fetch_array($result_category))
				{
					$cid = $row['catID'];
					$catname = $row['catName'];
					$total = $row['totalCount'];

					echo "
						<a href='vehicle.php?c=$cid' class='list-group-item'>
							<span class='badge'>$total</span>
							$catname
						</a>
					";
				}
			?>
		</div>
		<div class="col-lg-offset-2 col-lg-10">
			<button name="add" type="submit" class="btn btn-success">
				<strong>Confirm</strong>
			</button>
			<button name="skip" type="submit" class="btn btn-info">
				<strong>Skip</strong>
			</button>
		</div>
	</div>

	<div class="col-lg-9">
		<?php
			if (mysqli_num_rows($result_support) > 0)
			{
				while ($row = mysqli_fetch_array($result_support))
				{
					$sid = $row['serviceID'];
					$catname = $row['categoryName'];
					$servicename = $row['serviceName'];
					$desc = $row['serviceDescription'];

					echo "
						<a href='addvehicle.php?id=$sid' class='venues'>
							<div class='col-lg-4'>
								<div class='thumbnail'>
									


									<div class='caption'>
										<h4><strong>$servicename</strong></h4>
										<small>$catname</small><br/>
										$desc <br />
										<hr/>
										<a href='addvehicle.php?id=$sid' class='btn btn-success 
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