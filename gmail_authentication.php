<?php require_once("config.php"); ?>

<!DOCTYPE html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

  <?php include("navbar.php");?>
  <div class="accout-page">
    <div class="container">

      <div class="row">


        <div class="col-2" >
          <div class="form-container">
            <div class="form-btn">
              <span>Sign Up</span>
            </div>

            <form class="" action="" method="post" enctype="multipart/form-data">

              <?php
              if(isset($_POST['email_verification'])){
              
              $code = trim($_POST['code']);
              $codeRDX = $_SESSION['code'];
              $email = $_GET['email'];
              $username=$_GET['username'];
              echo $codeRDX;
              if ($code == $codeRDX) {
                code_verification($email,$username);
              } else {
                echo "Ma Khong Dung";
              }}
              ?>
              <h3>Vui Lòng Xác Thực Gmail</h3>
              <input type="code" name="code" placeholder="code"></label>
              <input type="submit" name="email_verification" id="code" class="btn btn-primary" value="Xac Thuc">
              

            </form>
          </div>

        </div>

      </div>
      <br>
      <h5 style="text-align: center;">If you already have an account <a href="login_page.php"> Login</a></h5>
    </div>
  </div>


  <?php include("footer.php") ?>