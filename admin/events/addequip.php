<?php

	if(isset($_REQUEST['id']))
	{
		if(ctype_digit($_REQUEST['id']))
		{
			$id = $_REQUEST['id'];
			$page_title = "Equipment # $id";
			include_once('../../includes/header_navbar.php');
			# Get Current Event's Reservation Date
			//$sql_date = "SELECT dateReserved from events WHERE eventNo=$eventNo";
			//$result_date = $con->query($sql_date);

			//$date = mysqli_fetch_assoc($result_date);
			//$date['dateReserved'];

			# Get Availalble Quantity
			//$sql_avail = "SELECT SUM(quantity) AS Available FROM equipmentdetails 
			//WHERE dateReserved = $date";
			//$result_avail = $con->query($sql_avail);

			//$avail = mysqli_fetch_assoc($result_avail);
			//$avail['Available'];

			# View Venue Reservations

			$sql_details = "SELECT ed.refNo, ev.eventName, ev.dateReserved,
			e.equipName, ed.quantity, ed.timeBorrowed FROM equipmentdetails ed 
				INNER JOIN events ev ON ev.eventNo = ed.eventNo 
				INNER JOIN equipments e ON ed.equipID = e.equipID 
				WHERE e.equipID = $id";

			$result_details = $con->query($sql_details);

			# Insert VenueDetails Data
			if(isset($_POST['add']))
			{
				session_start();
				$eventNo = $_SESSION['eventno'];
				#INSERT Details
				$quantity = mysqli_real_escape_string($con, $_POST['quantity']);
				$date = mysqli_real_escape_string($con, $_POST['reserve']);
				$borrow = mysqli_real_escape_string($con, $_POST['equipborrow']);

				$sql_add_equip_details = "INSERT INTO equipmentdetails VALUES 
				('', '$eventNo','$id', '$quantity', '$date', '$borrow', NULL, 'Confirmation')";

				$con -> query($sql_add_equip_details) or die(mysqli_error($con));

				header("location: equip.php");
			}			
		}
		else
		{
			header('equip.php');
		}
	}
	else
	{
		header('location: equip.php');
	}
?>

<form method="POST" class="form-horizontal">
		<div class="col-lg-12">
			<div class="col-lg-push-1 col-lg-7">
				<h2 class="text-center">Reservation List</h2>
				<table id="tblDetails" class="table table-hover">
					<thead>
						<th>Ref No</th>
						<th>Event Name</th>
						<th>Equipment</th>
						<th>Quantity</th>
						<th>Reserved Date</th>
						<th>Time Borrowed</th>
					</thead>
					<?php
						while($row = mysqli_fetch_array($result_details))
							{
							$ref = $row['refNo'];
							$event = $row['eventName'];
							$equip = $row['equipName'];
							$qty = $row['quantity'];
							$date = $row['dateReserved'];
							$borrow = $row['timeBorrowed'];

							echo "
								<tr>
									<td>$ref</td>
									<td>$event</td>
									<td>$equip</td>
									<td>$qty</td>
									<td>$date</td>
									<td>$borrow</td>
								</tr>
							";
						}
					?>
				</table>
			</div>

			<div class="col-lg-push-2 col-lg-5">
				<h2 class="text-center">Equipment Reservation Details</h2>
				<hr>
				<div class="form-group">
					<label class="control-label col-lg-4">Quantity</label>
					<div class="col-lg-7">
						<input name="quantity" type="number" class="form-control" required 
						min="1" value="1" max="99"/>
					</div>
				</div>
				<div class="form-group">	
					<label class="control-label col-lg-4">Reservation Date</label>
					<div class="col-lg-7">
						<input name="reserve" type="date" class="form-control" required value="00:00:00"/>
					</div>
				</div>
				<div class="form-group">	
					<label class="control-label col-lg-4">Time Borrowed</label>
					<div class="col-lg-7">
						<input name="equipborrow" type="time" class="form-control" required value="00:00:00"/>
					</div>
				</div>

				<br />
				<div class="form-group">
				<div class="col-lg-offset-4 col-lg-8">
					<button name="add" type="submit" class="btn btn-success">
						Add
					</button>
					<a href="equip.php" class="btn btn-default">
						Back
					</a>
				</div>
				</div>
			<script>
				$(document).ready(function(){
				    $('#tblDetails').DataTable();
				});
			</script>
			</div>
		</div>
	</form>