              </div>
            </div>
            <!-- /#page-content-wrapper -->

        </div>
    </div>
    <script type="text/javascript" src='<?php echo app_path ?>js/bootstrap.min.js'></script>
    <script type="text/javascript" src='<?php echo app_path ?>js/jasny-bootstrap.min.js'></script>
    <script type="text/javascript" src='<?php echo app_path ?>js/jquery.min.js'></script>
    <script type="text/javascript" src='<?php echo app_path ?>js/jquery-3.2.0.min.js'></script>
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
</body>
</html>