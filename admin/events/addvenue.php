<?php
	

	if(isset($_REQUEST['id']))
	{
		if(ctype_digit($_REQUEST['id']))
		{
			session_start();
			$currentDate = $_SESSION['datereserved'];
			$id = $_REQUEST['id'];
			$page_title = "Venue # $id";
			include_once('../../includes/header_navbar.php');
			# View Venue Reservations
			$sql_details = "SELECT vd.refNo, e.eventName, v.venueName, 
				vd.reservationDate, vd.timeBorrowed 
				FROM venuedetails vd
				INNER JOIN events e ON e.eventNo = vd.eventNo 
				INNER JOIN venues v ON v.venueID = vd.venueID 
				WHERE vd.venueID = '$id' AND vd.reservationDate = '$currentDate'";

			$result_details = $con->query($sql_details);

			# Insert VenueDetails Data
			if(isset($_POST['add']))
			{
				#INSERT Details
				$eventNo = $_SESSION['eventno'];
				$remarks = mysqli_real_escape_string($con, $_POST['remarks']);
				$reserve = mysqli_real_escape_string($con, $_POST['venuedate']);
				$borrow = mysqli_real_escape_string($con, $_POST['venueborrow']);

				$sql_add_venue_details = "INSERT INTO venuedetails VALUES (0, '$eventNo',
				'$id', '$remarks', '$reserve', '$borrow', NULL, 'Pending')";

				$con -> query($sql_add_venue_details) or die(mysqli_error($con));

				header("location: equip.php");
			}

			
		}
		else
		{
			header('venue.php');
		}
	}
	else
	{
		header('location: venue.php');
	}
?>

	<form method="POST" class="form-horizontal">
		<div class="col-lg-12">
			<div class="col-lg-push-1 col-lg-6">
				<h2 class="text-center">Reservation Dates</h2>
				<table id="tblDetails" class="table table-hover">
					<thead>
						
						<th>Event Name</th>
						<th>Venue</th>
						<th>Reservation Date</th>
						<th>Time Reserved</th>
					</thead>
					<?php
						while($row = mysqli_fetch_array($result_details))
							{
							//$ref = $row['refNo'];
							$event = $row['eventName'];
							$venue = $row['venueName'];
							$date = $row['reservationDate'];
							$borrow = $row['timeBorrowed'];

							echo "
								<tr>
									
									<td>$event</td>
									<td>$venue</td>
									<td>$date</td>
									<td>$borrow</td>
								</tr>
							";
						}
					?>
				</table>
			</div>

			<div class="col-lg-push-1 col-lg-6">
				<h2 class="text-center">Reservation Details</h2>
				<div class="form-group">
					<label class="control-label col-lg-4">Remarks</label>
					<div class="col-lg-8">
						<textarea name="remarks" id="remark" rows="10" cols="80">

				        </textarea>
				        <script>
				            CKEDITOR.replace( 'remark' );
				        </script>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-4">Reserved Date</label>
					<div class="col-lg-7">
						<input name="venuedate" type="date" class="form-control" required />
					</div>
				</div>
				<div class="form-group">	
					<label class="control-label col-lg-4">Time Borrowed</label>
					<div class="col-lg-7">
						<input name="venueborrow" type="time" class="form-control" required 
						value='00:00:00'/>
					</div>
				</div>

				<br />
				<div class="form-group">
				<div class="col-lg-offset-4 col-lg-8">
					<button name="add" type="submit" class="btn btn-success">
						Add
					</button>
					<a href="venue.php" class="btn btn-default">
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
	</form>
