<?php
	$page_title = 'Dashboard';

	include_once('../includes/header_admin.php');
	include_once('functions.php');
?>

<div id="calendar_div">
	<?php echo getCalender(); ?>
</div>

<?php
	include_once('../includes/footer.php');
?>