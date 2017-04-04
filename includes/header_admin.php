<?php

	ob_start();

	$protocol  = empty($_SERVER['HTTPS']) ? 'http' : 'https';
    $port      = $_SERVER['SERVER_PORT'];
    $disp_port = ($protocol == 'http' && $port == 80 || $protocol == 'https' && $port == 443) ? '' : ":$port";
    $domain    = $_SERVER['SERVER_NAME'];

    define('app_path', "${protocol}://${domain}${disp_port}" . '/gasd/');

    require($_SERVER['DOCUMENT_ROOT'] . '/gasd/config.php');
    # Additional Code for nav
?>

<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $page_title ?></title>
		<link href="<?php echo app_path ?>css/bootstrap.css" rel="stylesheet" />
	    <link href="<?php echo app_path ?>css/custom.css" rel="stylesheet" />
	    <link href="<?php echo app_path ?>css/font-awesome.min.css" rel="stylesheet" />
	    <link href="<?php echo app_path ?>css/calendar.css" rel="stylesheet" />
	    <link href="<?php echo app_path ?>css/jasny-bootstrap.min.css" rel="stylesheet" />
	    <link href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" rel="stylesheet" />
	    <script type="text/javascript" src='<?php echo app_path ?>js/jquery-3.2.0.min.js'></script>
	    <script type="text/javascript" src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
	    <script type="text/javascript" src='<?php echo app_path ?>ckeditor/ckeditor.js'></script>
	    <script type="text/javascript" src='<?php echo app_path ?>js/jquery.min.js'></script>
	</head>

	<body>
		<div class="container-fluid">
			<div class="col-lg-2 col-md-2 col-sm-3 sidebar">
				<ul class="nav nav-sidebar">
					<li class="nav nav-inverse nav-colapse"><a href="#">My Account</a>
		            	<ul><a href="#">Update Account</a></ul>
		            	<ul><a href="#">Logout</a></ul>
		            </li>
		            <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
		            <li class="nav nav-inverse nav-colapse"><a href="#">Events</a>
		            	<ul><a href="#">View Events</a></ul>
		            	<ul><a href="<?php echo app_path ?>admin/events/add2.php">Add Event</a></ul>
		            </li>
		            <li><a href="#">Venues</a>
		            	<ul><a href="#">View Venues</a></ul>
		            	<ul><a href="#">Add Venues</a></ul>
		            </li>
		            <li><a href="#">Equipments</a>
		            	<ul><a href="#">View Equipments</a></ul>
		            	<ul><a href="#">Add Equipment</a></ul>
		            </li>
		            <li><a href="#">Manpower Supports</a>
		            	<ul><a href="#">View Manpower</a></ul>
		            	<ul><a href="#">Add Manpower</a></ul>
		            </li>
		            <li><a href="#">Vehicles</a>
		            	<ul><a href="#">View Vehicles</a></ul>
		            	<ul><a href="#">Add Vehicle</a></ul>
		            </li>
		            <li><a href="#">Reports</a>
		            	<ul><a href="#">Event Reports</a></ul>
		            	<ul><a href="#">Add Event</a></ul>
		            </li>
		        </ul>
		    </div>
		    <div class="col-lg-10 col-md-10 col-sm-9">
		        <div class="clearfix">
		           	<div class="page-header">
		               	<div class="row">
		                   	<div class="col-lg-12">
		                       	<h1><?php echo $page_title; ?></h1>
		                   	</div>
		                </div>
		            </div>
		        	<div class="col-lg-12">