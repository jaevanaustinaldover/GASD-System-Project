<?php

	if(isset($_REQUEST['id']))
	{
		if(ctype_digit($_REQUEST['id']))
		{
			#Sessions
			session_start();
			$currentDate = $_SESSION['datereserved'];

			$id = $_REQUEST['id'];
			$page_title = "Service # $id";
			include_once('../../includes/header_navbar.php');

			$sql_details = "SELECT md.refNo, ev.eventName, mp.serviceName,
				md.setupDate, md.setupTime FROM manpowerdetails md
				INNER JOIN events ev ON ev.eventNo = md.eventNo 
				INNER JOIN manpowers mp ON mp.serviceID = md.serviceID 
				WHERE md.serviceID = '$id' AND md.setupDate = '$currentDate'";

			$result_details = $con->query($sql_details) or die(mysqli_error($con));

			# Insert VenueDetails Data
			if(isset($_POST['add']))
			{
				$eventNo = $_SESSION['eventno'];
				#INSERT Details
				$date = mysqli_real_escape_string($con, $_POST['setdate']);
				$settime = mysqli_real_escape_string($con, $_POST['settime']);
				$remark = mysqli_real_escape_string($con, $_POST['remarks']);

				$sql_add_support_details = "INSERT INTO manpowerdetails VALUES 
				('', '$eventNo','$id', '$date', '$settime', '$remark', 
					'Confirmation')";

				$con -> query($sql_add_support_details) or die(mysqli_error($con));

				header("location: support.php");
			}			
		}
		else
		{
			header('support.php');
		}
	}
	else
	{
		header('location: support.php');
	}
?>

<form method="POST" class="form-horizontal">
		<div class="col-lg-12">
			<div class="col-lg-push-1 col-lg-6">
				<h2 class="text-center">Reservation List</h2>
				<table id="tblDetails" class="table table-hover">
					<thead>
							
						<th>Event Name</th>
						<th>Service Name</th>
						<th>Setup Date</th>
						<th>Setup Time</th>
					</thead>
					<?php
						while($row = mysqli_fetch_array($result_details))
							{
								#remove due to low space
							//$ref = $row['refNo'];
							$event = $row['eventName'];
							$service = $row['serviceName'];
							$date = $row['setupDate'];
							$time = $row['setupTime'];

							echo "
								<tr>
								
									<td>$event</td>
									<td>$service</td>
									<td>$date</td>
									<td>$time</td>
								</tr>
							";
						}
					?>
				</table>
			</div>

			<div class="col-lg-push-2 col-lg-6">
				<h2 class="text-center">Service Reservation Details</h2>
				<hr>
				<div class="form-group">	
					<label class="control-label col-lg-4">Setup Date</label>
					<div class="col-lg-7">
						<input name="setdate" type="date" class="form-control" required value="00:00:00"/>
					</div>
				</div>
				<div class="form-group">	
					<label class="control-label col-lg-4">Setup Borrowed</label>
					<div class="col-lg-7">
						<input name="settime" type="time" class="form-control" required value="00:00:00"/>
					</div>
				</div>
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

				<br />
				<div class="form-group">
				<div class="col-lg-offset-4 col-lg-8">
					<button name="add" type="submit" class="btn btn-success">
						Add
					</button>
					<a href="support.php" class="btn btn-default">
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