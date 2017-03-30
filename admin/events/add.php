<?php
	$page_title = 'Add an Event';
	include_once('../../includes/header_navbar.php');

	# Show List of Venues
	$sql_venue = "SELECT venueID, venueName FROM venues ORDER BY venueName";
	$result_venue = $con->query($sql_venue);

	$list_venue = "";
	while($row = mysqli_fetch_array($result_venue))
	{
		$venueID = $row['venueID'];
		$venueName = $row['venueName'];
		$list_venue .= "<option value='$venueID'>$venueName</option>";
	}



	# Add Events, Borrower, Venuedetails
	if(isset($_POST['add']))
	{
		#borrowers
		$bid = mysqli_real_escape_string($con, $_POST['bid']);
		$fn = mysqli_real_escape_string($con, $_POST['fn']);
		$mi = mysqli_real_escape_string($con, $_POST['mi']);
		$ln = mysqli_real_escape_string($con, $_POST['ln']);
		$email = mysqli_real_escape_string($con, $_POST['email']);

		$sql_add_borrowers = "INSERT INTO borrowers VALUES ('$bid', '$fn', '$mi', '$ln', 
			'Student', '$email', NULL, 'Active', NOW(), NULL)";
		$con -> query($sql_add_borrowers) or die(mysqli_error($con));

		#events
		$eventname = mysqli_real_escape_string($con, $_POST['name']);
		$organization = mysqli_real_escape_string($con, $_POST['org']);
		$c_person = mysqli_real_escape_string($con, $_POST['contactperson']);
		$c_number = mysqli_real_escape_string($con, $_POST['contactnumber']);
		$a_type = mysqli_real_escape_string($con, $_POST['activitytype']);
		$no_participants = mysqli_real_escape_string($con, $_POST['participants']);
		$datereserved = mysqli_real_escape_string($con, $_POST['reservation']);

		$sql_add_events = "INSERT INTO events VALUES ('', 1, '$bid', '$eventname',
			'$organization', '$c_person', '$c_number', '$a_type', '$no_participants',
			'$datereserved', 'Pending', NOW(), NULL)";
	
		$con -> query($sql_add_events) or die(mysqli_error($con));

		#getEventNo
		$sql_eventID = "SELECT eventNo FROM events WHERE
			dateReserved = '$datereserved' AND eventname = '$eventname'";
		$result_eventNo = $con->query($sql_eventID);

		if(mysqli_num_rows($result_eventNo) > 0)
		{
			while($row = mysqli_fetch_array($result_eventNo))
			{
				$_SESSION['eventno'] = $row['eventNo'];
			}
		}

		#venues

		$eventNo = $_SESSION['eventno'];
		$venueID = mysqli_real_escape_string($con, $_POST['venue']);
		$remarks = mysqli_real_escape_string($con, $_POST['remarks']);
		$reserve = mysqli_real_escape_string($con, $_POST['venuedate']);
		$borrow = mysqli_real_escape_string($con, $_POST['venueborrow']);
		$return = mysqli_real_escape_string($con, $_POST['venuereturn']);

		$sql_add_venue_details = "INSERT INTO venuedetails VALUES ('', '$eventNo',
			'$venueID', '$remarks', '$reserve', '$borrow', '$return')";

		$con -> query($sql_add_venue_details) or die(mysqli_error($con));

		header('location: addequip.php');
	}
?>

<form method="POST" class="form-horizontal" enctype="multipart/form-data">
	<div class="col-lg-10">
		<h2 class="text-center">Event Information</h2>
		<div class="form-group">	
			<label class="control-label col-lg-4">Event Name</label>
			<div class="col-lg-7">
				<input name="name" type="text" class="form-control" required />
			</div>
		</div>
		<div class="form-group">	
			<label class="control-label col-lg-4">Organization</label>
			<div class="col-lg-7">
				<input name="org" type="text" class="form-control" required />
			</div>
		</div>
		<div class="form-group">	
			<label class="control-label col-lg-4">Contact Person</label>
			<div class="col-lg-7">
				<input name="contactperson" type="text" class="form-control" required />
			</div>
		</div>
		<div class="form-group">	
			<label class="control-label col-lg-4">Contact Number</label>
			<div class="col-lg-7">
				<input name="contactnumber" type="text" class="form-control" required />
			</div>
		</div>
		<div class="form-group">	
			<label class="control-label col-lg-4">Activity Type</label>
			<div class="col-lg-7">
				<input name="activitytype" type="text" class="form-control" required />
			</div>
		</div>
		<div class="form-group">	
			<label class="control-label col-lg-4">No. of Participants</label>
			<div class="col-lg-7">
				<input name="participants" type="number" class="form-control" required 
					min="10"/>
			</div>
		</div><div class="form-group">	
			<label class="control-label col-lg-4">Date of Reservation</label>
			<div class="col-lg-7">
				<input name="reservation" type="date" class="form-control" required />
			</div>
		</div>

		
		<br />
		<h2 class="text-center">Reservee</h2>
		<div class="form-group">	
			<label class="control-label col-lg-4">School ID</label>
			<div class="col-lg-7">
				<input name="bid" type="text" class="form-control" required />
			</div>
		</div>
		<div class="form-group">	
			<label class="control-label col-lg-4">First Name</label>
			<div class="col-lg-7">
				<input name="fn" type="text" class="form-control" required />
			</div>
		</div>
		<div class="form-group">	
			<label class="control-label col-lg-4">Middle Initial</label>
			<div class="col-lg-7">
				<input name="mi" type="text" class="form-control" required />
			</div>
		</div>
		<div class="form-group">	
			<label class="control-label col-lg-4">Last Name</label>
			<div class="col-lg-7">
				<input name="ln" type="text" class="form-control" required />
			</div>
		</div>
		<div class="form-group">	
			<label class="control-label col-lg-4">Email</label>
			<div class="col-lg-7">
				<input name="email" type="email" class="form-control" required />
			</div>
		</div>

		<br/>
		<h2 class="text-center">Venue Information</h2>
		<div class="form-group">
			<label class="control-label col-lg-4">Venue</label>
			<div class="col-lg-7">
				<select name="venue" class="form-control" required>
					<option value="">Select one...</option>
					<?php echo $list_venue; ?>
				</select>
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
		<div class="form-group">
			<label class="control-label col-lg-4">Reserved Date</label>
			<div class="col-lg-7">
				<input name="venuedate" type="date" class="form-control" required />
			</div>
		</div>
		<div class="form-group">	
			<label class="control-label col-lg-4">Time Borrowed</label>
			<div class="col-lg-7">
				<input name="venueborrow" type="time" class="form-control" required />
			</div>
		</div>
		<div class="form-group">	
			<label class="control-label col-lg-4">Time Returned</label>
			<div class="col-lg-7">
				<input name="venuereturn" type="time" class="form-control" required />
			</div>
		</div>

		<br />
		<div class="form-group">
			<div class="col-lg-offset-4 col-lg-8">
				<button name="add" type="submit" class="btn btn-success">
					Add
				</button>
			</div>
		</div>
	</div>
</form>

<?php
	include_once('../../includes/footer.php');
?>