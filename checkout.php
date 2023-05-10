<?php require_once("config.php"); 
if(isset($_POST['submit'])){
    $type = $_POST['pay_type'];
    if($type=="redirect"){
        Inset_product_oder();
        redirect("VNPAY.php");
        
    }
    if($type=="MOMOQR"){
        Inset_product_oder();
        redirect("MOMO.php");
    }
    if($type=="MOMO"){
        Inset_product_oder();
        redirect("MOMONH.php");
    }
    if($type=="credit"){
        Inset_product_oder();
        redirect("momo.php");
    }
    if($type=="wire"){
        Inset_product_oder();
        redirect("homepage.php");
    }
    
}
?>


<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script  src="functions.js"></script>
</head>
<body>
    <?php include("navbar.php") ?>
    <h6 style="text-align: center;" class="text-center bg-warning"><?php display_message();?></h6>


       
<div class="add-product-page">
    <div class="container" style="padding-left: 500px;">
        <h3>Order Information</h3>

  
       <div class="row">

           <div class="col-2">
              <div class="">
                 <div class="form-btn">
                     <br>
                 </div>
                 
                 <form name="checkout" class="" action="" method="post" enctype="application/x-www-form-urlencoded">

                    <div class="col-md-8">
                        
                        

                        <div style="padding-bottom: 10px;"> <span id="card-inner">Country</span> 
                        </div>
                                <div class="custom-select" style="width:200px;">
                                <label for="city">Thành phố/Tỉnh:</label>
                                <select name="city" id="city">
                                    <option value="">-- Chọn thành phố/tỉnh --</option>
                                </select>
                                <label for="district">Quận/Huyện:</label>
                                <select name="district" id="district">
                                    <option value="">-- Chọn quận/huyện --</option>
                                </select>
                                <label for="ward">Xã/Phường:</label>
                                <select name="ward" id="ward">
                                    <option value="">-- Chọn xã/phường --</option>
                                </select>
                            </div>
                           <br>
                           <div class="form-group">
                          <label for="product-title">Address</label>
                          <div class="col-2">
                          	<input type="text" name="product_title" placeholder="">
                          </div>
                          </label>
                      </div>

                      <br>
                            <div class="nav">
                                 <span id="card-header">Payment Type</span>
                                <div class="row row-1" style="padding-bottom: 10px; padding-top: 10px;">
                                    <div class="col-7">
                                        <div class="custom-select" style="width:200px;">
                                              <select id = "pay_type" name="pay_type">
	                                                <option value="0">Choose Payment Type</option>
	                                                <option value="credit">Chuyển Khoản</option>
	                                                <option value="wire">Tiền Mặt</option>
                                                    <option value="redirect">VNPAY</option>
                                                    <option value="MOMOQR">MOMOQR</option>
                                                    <option value="MOMO">MOMO</option>
                                              </select>
                                        </div>
                                    </div>
                                </div>
                            
                            </div>

                        <div class="form-group">
                          <div class="row">
                            <div class="col-2">
                              <a class="btn" style="text-align: center;" href="shopping_cart.php">Back</a>
                            </div>
                        </div>
                          <div class="row">
                            <div class="col-2">
                            <button type="submit" name="submit" class="btn btn-success waves-effect waves-light">Purchase</button>
                              
                            </div>
                          </div>
                        </div>
                      </div>

                       </div>

            </form>
              </div>

           </div>

       </div>
       <br>
</div>
</div>


    <?php include("footer.php") ?>

