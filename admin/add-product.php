<?php
session_start();
include('../config.php');
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    add_product_adminpage();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">


        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <title>LEDMDSTORE | Thêm Sản Phẩm</title>


        <link href="../plugins/summernote/summernote.css" rel="stylesheet" />


        <link href="../plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />


        <link href="../plugins/jquery.filer/css/jquery.filer.css" rel="stylesheet" />
        <link href="../plugins/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css" rel="stylesheet" />
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="../plugins/switchery/switchery.min.css">
        <script src="assets/js/modernizr.min.js"></script>
        <script>
            function getSubCat(val) {
                $.ajax({
                    type: "POST",
                    url: "get_subcategory.php",
                    data: 'catid=' + val,
                    success: function(data) {
                        $("#subcategory").html(data);
                    }
                });
            }
        </script>
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
                                    <h4 class="page-title">Thêm Sản Phẩm </h4>
                                    <ol class="breadcrumb p-0 m-0">
                                        <li>
                                            <a href="#">Sản Phẩm</a>
                                        </li>
                                        <li>
                                            <a href="#">Thêm Sản Phẩm</a>
                                        </li>
                                        <li class="active">
                                            Thêm Sản Phẩm
                                        </li>
                                    </ol>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="p-6">
                                    <div class="">
                                        <form name="addpost" method="post" enctype="multipart/form-data">
                                            <div class="form-group m-b-20">
                                                <label for="exampleInputEmail1">Tên Sản Phẩm</label>
                                                <input type="text" class="form-control" id="product_title" name="product_title" placeholder="Enter title" required>
                                            </div>



                                            <div class="form-group m-b-20">
                                                <label for="exampleInputEmail1">Danh Mục</label>
                                                <select class="form-control" name="product_category_id" id="product_category_id" onChange="getSubCat(this.value);" required>
                                                    <option value="">Chọn Danh Mục</option>
                                                    <?php
                                                    show_category_title_select();
                                                    ?>

                                                </select>
                                            </div>

                                            <div class="form-group m-b-20">
                                                <label for="exampleInputEmail1">Giá</label>
                                                <input type="text" class="form-control" id="product_price" name="product_price" placeholder="Enter Price" required>
                                            </div>
                                            <div class="form-group m-b-20">
                                                <label for="exampleInputEmail1">Số Lượng</label>
                                                <input type="text" class="form-control" id="product_quantity" name="product_quantity" placeholder="Enter Quantity" required>
                                            </div>
                                            <div class="form-group m-b-20">
                                                <label for="exampleInputEmail1">Mô Tả Ngắn</label>
                                                <input type="text" class="form-control" id="product_short_desc" name="product_short_desc" placeholder="Nhập Mô Tả Ngắn" required>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="card-box">
                                                        <h4 class="m-b-30 m-t-0 header-title"><b>Mô Tả</b></h4>
                                                        <textarea class="summernote" name="product_description" required></textarea>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="card-box">
                                                        <h4 class="m-b-30 m-t-0 header-title"><b>Ảnh</b></h4>
                                                        <input type="file" class="form-control" id="postimage" name="postimage" required>
                                                    </div>
                                                </div>
                                            </div>


                                            <button type="submit" name="submit" class="btn btn-success waves-effect waves-light">Thêm</button>
                                            <button type="button" class="btn btn-danger waves-effect waves-light">Thoát</button>
                                        </form>
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
        <script src="../plugins/summernote/summernote.min.js"></script>
        <script src="../plugins/select2/js/select2.min.js"></script>
        <script src="../plugins/jquery.filer/js/jquery.filer.min.js"></script>
        <script src="assets/pages/jquery.blog-add.init.js"></script>
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
        <script>
            jQuery(document).ready(function() {

                $('.summernote').summernote({
                    height: 240,
                    minHeight: null,
                    maxHeight: null, 
                    focus: false 
                });
                $(".select2").select2();
                $(".select2-limiting").select2({
                    maximumSelectionLength: 2
                });
            });
        </script>
        <script src="../plugins/switchery/switchery.min.js"></script>
        <script src="../plugins/summernote/summernote.min.js"></script>
    </body>
    </html>
<?php } ?>