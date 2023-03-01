<?php require_once("config.php"); ?>

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
                <div class="col-2">

                    <h1>Give Your Music<br>A New Style!</h1>
                    <p>Music is what feelings sound like. Let your music sound magical with our products.</p>
                    <a href="products.php" class="btn">Explore Now &#8594;</a>
                </div>
                <div class="col-2">
                    <img src="images/image1.png">
                </div>
               
           </div>
           
       </div>
       </div>
       <div class="small-container" id="TimeSale">
        <h2 class="title">Time Sale</h2>
             <div class="row">
             	<?php time_sale(); ?>
                 <?php time_sale_products(); ?>
           </div>
           
       </div>
       <div class="small-container">
        <h2 class="title">Cate</h2>
             <div class="row">
             	<?php get_four_cate(); ?>
           </div>
           
       </div>
  
  <div class="small-container">
        <h2 class="title">Latest Products</h2>
             <div class="row">
             	<?php get_four_products(); ?>
           </div>
           
       </div>
         
   <div class="offer">
       <div class="small-container">
           <div class="row">
           <div class="col-2">
               <img src="images/exclusive.png" class="offer-img">
           </div>
           <div class="col-2">
               <p>Exclusively Available on Music Store</p>
               <h1>Launchkey 61 MK3</h1>
               <small>61 velocity sensitive keys, 16x RGB pads, pitch and mod wheels and bus powered.</small>
               <br>
               <a href="product_detail.php?id=13" class="btn">Buy Now &#8594;</a>
           </div>
       </div>
       </div>
       
   </div>  

   <br>
   <br>


    <?php include("footer.php") ?>


   
