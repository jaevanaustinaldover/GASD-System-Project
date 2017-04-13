<?php

	ob_start();

	$protocol  = empty($_SERVER['HTTPS']) ? 'http' : 'https';
    $port      = $_SERVER['SERVER_PORT'];
    $disp_port = ($protocol == 'http' && $port == 80 || $protocol == 'https' && $port == 443) ? '' : ":$port";
    $domain    = $_SERVER['SERVER_NAME'];

    define('app_path', "${protocol}://${domain}${disp_port}" . '/gasd/');

    require($_SERVER['DOCUMENT_ROOT'] . '/gasd/config.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/gasd/function.php');
    # Additional Code for nav
?>

<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $page_title ?></title>
		<link href="<?php echo app_path ?>css/bootstrap.css" rel="stylesheet" />
	    <link href="<?php echo app_path ?>css/custom.css" rel="stylesheet" />
	    <link href="<?php echo app_path ?>css/font-awesome.min.css" rel="stylesheet" />
	    <link href="<?php echo app_path ?>css/jasny-bootstrap.min.css" rel="stylesheet" />
	    <link href="<?php echo app_path ?>admin/events/indeximage.css" rel="stylesheet" />
	    <link rel="stylesheet" type="text/css" href="<?php echo app_path ?>css/simple-sidebar.css">
	    <link href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" rel="stylesheet" />
	    <script type="text/javascript" src='<?php echo app_path ?>js/jquery-3.2.0.min.js'></script>
	    <script type="text/javascript" src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
	    <script type="text/javascript" src='<?php echo app_path ?>ckeditor/ckeditor.js'></script>
	</head>

	<body>
		<div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                        GASD System
                    </a>
                </li>
                <li>
                    <a href="<?php echo app_path ?>admin/index.php">Dashboard</a>
                </li>
                <li>
                    <a href="Order/product.php">Events</a>
                </li>
                <li>
                    <a href="Purchase/view.php">Venues</a>
                </li>
                <li>
                    <a href="#">Equipments</a>
                </li>
                <li>
                    <a href="#">Supports</a>
                </li>
                <li>
                    <a href="#">Vehicles</a>
                </li>
                <li>
                    <a href="#">Reports</a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
          <div class="navbar navbar-default">
            <div class="container-fluid">
              <ul class="nav navbar-nav">
                <li>
                  <a href="#menu-toggle" class="fa fa-bars fa-lg" id="menu-toggle"></a>
                </li>
              </ul>
              <div class="navbar-header">
                		<a id="home" href="<?php echo app_path ?>admin/index.php" runat="server" class="navbar-brand">GASD System</a>
		                <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#navbar-main">
                    	<span class="icon-bar"></span>
                    	<span class="icon-bar"></span>
                    	<span class="icon-bar"></span>
                		</button>
            		</div>
            		<div class="navbar-collapse collapse" id="navbar-main" style="height: 1px;">
		                <ul class="nav navbar-nav">
		                    <li><a id="A1" runat="server" href="<?php echo app_path ?>admin">Dashboard</a></li>
		                    <li class="dropdown">
		                        <a class="dropdown-toggle" data-toggle="dropdown" id="about" href="">Events <span class="caret"></span></a>
		                        <ul class="dropdown-menu">
		                            <li><a id="A2" runat="server" href="<?php echo app_path ?>admin/events/add.php">Add Event</a></li>
		                            <li><a id="A3" runat="server" href="<?php echo app_path ?>admin/events/index.php">View Events</a></li>
		                        </ul>
		                    </li>
		                    <li class="dropdown">
		                        <a class="dropdown-toggle" data-toggle="dropdown" id="products" href="#">Venues <span class="caret"></span></a>
		                        <ul class="dropdown-menu">
		                            <li><a id="A5" runat="server" href="~/Products.aspx?sort=name">Sort by Name</a></li>
		                            <li><a id="A6" runat="server" href="~/Products.aspx?sort=price">Sort by Price</a></li>
		                        </ul>
		                    </li>
		                    <li class="dropdown">
		                        <a class="dropdown-toggle" data-toggle="dropdown" id="products" href="#">Equipments <span class="caret"></span></a>
		                        <ul class="dropdown-menu">
		                            <li><a id="A5" runat="server" href="~/Products.aspx?sort=name">Sort by Name</a></li>
		                            <li><a id="A6" runat="server" href="~/Products.aspx?sort=price">Sort by Price</a></li>
		                        </ul>
		                    </li>
		                    <li class="dropdown">
		                        <a class="dropdown-toggle" data-toggle="dropdown" id="products" href="#">Supports <span class="caret"></span></a>
		                        <ul class="dropdown-menu">
		                            <li><a id="A5" runat="server" href="~/Products.aspx?sort=name">Sort by Name</a></li>
		                            <li><a id="A6" runat="server" href="~/Products.aspx?sort=price">Sort by Price</a></li>
		                        </ul>
		                    </li>
		                    <li><a id="A7" runat="server" href="~/Gallery.aspx">Reports</a></li>
		                </ul>
		                <ul class="nav navbar-nav pull-right">
		                    <li id="user" runat="server" class="dropdown" visible="true">
		                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
		                            <asp:Literal ID="ltUser" runat="server" Text="John Doe" />
		                            <span class="caret"></span>
		                        </a>
		                        <ul class="dropdown-menu">
		                            <li><a id="A10" runat="server" href="~/Account/Profile.aspx">View Profile</a></li>
		                            <li><a id="A11" runat="server" href="~/Account/Cart.aspx">View Cart</a></li>
		                            <li><a id="A12" runat="server" href="~/Account/Orders">View Orders</a></li>
		                            <li class="divider"></li>
		                            <li><a id="A13" runat="server" href="~/Account/Logout.aspx">Logout</a></li>
		                        </ul>
		                    </li>
		                </ul>
		            </div>
            </div>
          </div>
          <!-- /#End of Nav Bar -->

          <!-- Content Files Header Side-->
          	<div class="col-lg-12">

              <!-- Content Files Header Side-->