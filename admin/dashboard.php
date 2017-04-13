<!DOCTYPE HTML>
<head>
  <title>Dashboard</title>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <link href="css/bootstrap.css" rel="stylesheet" />
  <link href="css/custom.css" rel="stylesheet" />
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <link href="css/jasny-bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="css/simple-sidebar.css">
</head>
<body>
  
  <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                        UNITY System
                    </a>
                </li>
                <li>
                    <a href="dashboard.html">Dashboard</a>
                </li>
                <li>
                    <a href="Order/product.php">Job Order</a>
                </li>
                <li>
                    <a href="Purchase/view.php">Purchasing</a>
                </li>
                <li>
                    <a href="#">Inventory</a>
                </li>
                <li>
                    <a href="#">Transfer</a>
                </li>
                <li>
                    <a href="#">Delivery</a>
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
              <ul class="nav navbar-nav pull-right">
                <li id="user" class="dropdown" visible="true">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    Profile<span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                    <li><a href="admin/profile.php">View Profile</a></li>
                    <li class="divider"></li>
                    <li><a href="admin/logout.php">Logout</a></li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
          <!-- /#End of Nav Bar -->

          <!-- Content Files Header Side-->
          <div class="container">
            <div class="col-lg-12">

              <!-- Content Files Header Side-->
              <!-- End of Content Files Footer Side -->
            </div>
          </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>

      <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- jQuery -->
    <script src="js/jquery-3.2.0.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
</body>
</html>