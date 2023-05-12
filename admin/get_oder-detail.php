<?php
session_start();
include('../config.php');
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    Duyet_oder_manager();
    Delete_oder_manager();

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <title> LEDMDSTORE | Chi Tiết Đơn Hàng</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="../plugins/switchery/switchery.min.css">
        <script src="assets/js/modernizr.min.js"></script>

    </head>


    <body class="fixed-left">
        <div id="wrapper">
            <?php include('includes/topheader.php'); ?>
            <?php include('includes/leftsidebar.php'); ?>
            <div class="content-page">
                <div class="content">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Chi Tiết Đơn Hàng</h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        <li>
                                            <a href="#">Admin</a>
                                        </li>
                                        <li>
                                            <a href="#">Đơn Hàng </a>
                                        </li>
                                        <li class="active">
                                        Chi Tiết Đơn Hàng
                                        </li>
                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="demo-box m-t-20">
                                        <div class="m-b-30">

                                        <h4><i class="fa fa-file"></i> Chi Tiết Đơn Hàng</h4>

                                        </div>

                                        <div class="table-responsive">
                                            <table class="table m-0 table-colored-bordered table-bordered-danger">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Tên Sản Phẩm</th>
                                                        <th>Số Lươngj</th>
                                                        <th>Ảnh</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   <?php Get_oder_detail_admin();?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include('includes/footer.php'); ?>
                </div>

            </div>
            <script>
                var resizefunc = [];
            </script>
            <script src="assets/js/jquery.min.js"></script>
            <script src="assets/js/bootstrap.min.js"></script>
            <script src="assets/js/detect.js"></script>
            <script src="assets/js/fastclick.js"></script>
            <script src="assets/js/jquery.blockUI.js"></script>
            <script src="assets/js/waves.js"></script>
            <script src="assets/js/jquery.slimscroll.js"></script>
            <script src="assets/js/jquery.scrollTo.min.js"></script>
            <script src="../plugins/switchery/switchery.min.js"></script>
            <script src="assets/js/jquery.core.js"></script>
            <script src="assets/js/jquery.app.js"></script>
    </body>
    </html>
<?php } ?>