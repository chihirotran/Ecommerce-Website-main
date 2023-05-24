<?php require_once("config.php");
if(isset($_GET['partnerCode'])){
    if(isset($_GET['orderId'])){
        // Update_Oder_Pay();
    }
}
?>

<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style2.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
   
   <div class="header">
       <div class="container">
            <?php include("navbar.php") ?>        
           <div class="row">
                <div class="col-2" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                    <h1>Trang Trí Nhà Nạn!<br>Với Vô Vàn Sắc Màu LED!</h1>
                    <p> Đâu ai muốn 1 căn nhà u ám vô vị không màu sắc đâu chứ, vậy bạn còn chờ gì nữa mà không xem ngay tại cửa hàng LEDMSTORE?</p>
                    <a href="products.php" class="btn" style="font-family:
                     'Trebuchet MS', 
                     'Lucida Sans Unicode', 
                     'Lucida Grande', 
                     'Lucida Sans', 
                     Arial, sans-serif; 
                     font-weight:900;
                     font-size:20px;
                     ">Khám Phá Ngay &#8594;</a>
                </div>
                <div class="col-2">
                    <img src="images/logo.png">
                </div>
               
           </div>
           
       </div>
       </div>
       <div class="small-container" id="TimeSale">
        <h2 class="title" style="font-family: sans-serif;">Thời Gian Ưu Đãi, Săn ngay kẻo hết!</h2>
             <div class="row">
             	<?php time_sale(); ?>
                 <?php time_sale_products(); ?>
           </div>
           
       </div>
       <div class="small-container">
        <h2 class="title">Sản Phẩm Bán Chạy</h2>
             <div class="row">
             	<?php get_four_top_products(); ?>
           </div>
           
       </div>
       <div class="small-container">
        <h2 class="title" style="font-family: sans-serif;">Phân Loại</h2>
             <div class="row">
             	<?php get_four_cate(); ?>
           </div>
           
       </div>
  
  <div class="small-container">
        <h2 class="title">Sản Phẩm Mới Nhất</h2>
             <div class="row">
             	<?php get_four_products(); ?>
           </div>
           
       </div>
         
   

   <br>
   <br>


    <?php include("footer.php") ?>


   
