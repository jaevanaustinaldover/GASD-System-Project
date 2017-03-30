<?php
	$page_title = "Choose Equipment/s";
    include_once('../../includes/header_navbar.php');

    # Search Bar Configuration
    if (isset($_POST['search']))
    {
    	$keyword = mysqli_real_escape_string($con, $_POST['keyword']);
    	header('location: equip.php?s=' . $keyword);
    }

    # Get Campus
    if (isset($_REQUEST['c']))
    {
    	if (ctype_digit($_REQUEST['c']))
		{
			$catid = $_REQUEST['c'];
			# displays list of venues based from campuses

		    $sql_equipments = "SELECT e.equipID, e.equipName, c.categoryName, 
		    	e.equipDescription, e.equipAvailable FROM equipments e
		    	INNER JOIN equipmentcategory c ON e.catID = c.catID 
		    	WHERE e.catID = $catid";
		}
		else
		{
			header('location: equip.php');
		}
    }

    else if (isset($_REQUEST['s']))
    {
    	$filter = "'%" . $_REQUEST['s'] . "%'";
    	# displays list of products based from keyword

		$sql_equipments = "SELECT e.equipID, e.equipName, c.categoryName, 
			e.equipDescription, e.equipAvailable , e.status, e.dateAdded, e.dateModified 
			FROM equipments e INNER JOIN equipmentcategory c ON
			e.catID = c.catID
			WHERE (c.categoryName LIKE $filter OR 
			e.equipName LIKE $filter OR 
			e.equipDescription LIKE $filter)";
		
    }

    else
    {

		$sql_equipments = "SELECT e.equipID, e.equipName, c.categoryName, 
			e.equipDescription, e.equipAvailable, e.status, e.dateAdded, e.dateModified 
			FROM equipments e INNER JOIN equipmentcategory c ON
			e.catID = c.catID";
    }

    #Display Venues
    $result_equip = $con->query($sql_equipments);

    # Display Campuses

    $sql_category = "SELECT c.catID, c.categoryName as catName,
    	(SELECT COUNT(equipID) FROM equipments 
    	WHERE catID = c.catID) AS totalCount FROM equipmentcategory c 
		ORDER BY c.categoryName";

    $result_category = $con->query($sql_category);

    # Get Total Data
    $sql_count = "SELECT COUNT(venueID) AS Total FROM 'venues'";
	$result_total = $con->query($sql_count);
	//$data = mysqli_fetch_assoc($result_total);

	# UPDATE equipmentdetails refNo
	if(isset($_POST['add']))
	{
		session_start();
		$eventNo = $_SESSION['eventno'];

		$sql_update = "UPDATE equipmentdetails SET status = 'Pending'
			WHERE eventNo = '$eventNo'";
		$con -> query($sql_update) or die(mysqli_error($con));
		header('location: support.php');
	}
	else if(isset($_POST['skip']))
	{
		session_start();
		$eventNo = $_SESSION['eventno'];

		$sql_skip = "INSERT INTO equipmentdetails VALUES ('', $eventNo, NULL, 
			NULL, NULL, NULL, NULL, 'N/A')";
		$con -> query($sql_skip) or die(mysqli_error($con));
		header('location: support.php');
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
			<a href='equip.php' class='list-group-item'>
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
						<a href='equip.php?c=$cid' class='list-group-item'>
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
			if (mysqli_num_rows($result_equip) > 0)
			{
				while ($row = mysqli_fetch_array($result_equip))
				{
					$equipid = $row['equipID'];
					$equipname = $row['equipName'];
					$catname = $row['categoryName'];
					$desc = $row['equipDescription'];
					$avail = $row['equipAvailable'];

					echo "
						<a href='addequip.php?id=$equipid' class='venues'>
							<div class='col-lg-4'>
								<div class='thumbnail'>
									


									<div class='caption'>
										<h4><strong>$equipname</strong></h4>
										<small>$catname</small><br/>
										$desc <br />
										Quantity: $avail
										<hr/>
										<a href='addequip.php?id=$equipid' class='btn btn-success 
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