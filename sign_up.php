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

  <?php include("navbar.php");
  $codeRDX = 0;
  ?>
  <?php

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  if (isset($_POST['email_verification'])) {


    $email = trim($_POST['email']);



    require 'vendor/autoload.php';
    // bỏ phần code đi. tạo thêm 1 trang khi ấn đăng ký thì chuyển sang trang đấy.đồng thời insert vô SQL trạng thái xác thực là 0 khi xác thực rồi thì chuyển trạng thái sang 1
    // Lấy thông tin email từ yêu cầu POST
    if (isset($_POST['to'])) {
      $to = $_POST['to'];
    }

    if (isset($_POST['subject'])) {
      $subject = $_POST['subject'];
    }

    if (isset($_POST['message'])) {
      $message = $_POST['message'];
    }


    // Khởi tạo đối tượng PHPMailer
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'chihirotran@gmail.com'; // Thay đổi email của bạn
    $mail->Password = 'wcycfexkikrboage'; // Thay đổi mật khẩu của bạn
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    // Thiết lập thông tin email
    $mail->setFrom('chihirotran@gmail.com', 'LEDMDSTORE'); // Thay đổi email và tên của bạn   
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = "Code Verification ";
    $randomNumber = mt_rand(0, 99999);
    $codeRD = sprintf('%05d', $randomNumber);
    $mail->Body = "Code: .$codeRD.";
    $codeRDX = $codeRD;
    // Gửi email và kiểm tra kết quả
    if ($mail->send()) {
      echo 'Email đã được gửi thành công!';
    } else {
      echo 'Đã có lỗi xảy ra khi gửi email: ' . $mail->ErrorInfo;
    }
  }
  ?>
  <h6 style="text-align: center;" class="text-center bg-warning"><?php display_message(); ?></h6>



  <div class="accout-page">
    <div class="container">

      <div class="row">


        <div class="col-2" >
          <div class="form-container">
            <div class="form-btn">
              <span>Đăng Kí </span>
            </div>

            <form class="" action="" method="post" enctype="multipart/form-data">

              <?php
              
                add_user();
          
              ?>

              <input type="text" name="username" placeholder="Tên người dùng"></label>
              <input type="text" name="email" placeholder="e-mail"></label>
              <input type="password" name="password" placeholder="Mật khẩu"></label>
              
              
              <input type="submit" name="add_user" id="signup" class="btn btn-primary">

            </form>
          </div>

        </div>

      </div>
      <br>
      <h5 style="text-align: center; margin-left: 50px; font-family:Verdana, Geneva, Tahoma, sans-serif;">Đã có tài khoản rồi hả?<a href="login_page.php"> Đăng nhập thôi!</a></h5>
    </div>
  </div>


  <?php include("footer.php") ?>