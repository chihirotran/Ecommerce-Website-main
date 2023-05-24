<?php require_once("config.php"); ?>
<?php 

  if(isset($_GET['id'])) {
    $id = $_GET['id'];
    if (strpos($id, "GG.") !== false) {
      $id_new = str_replace("GG.", "", $id);
      $query = query("SELECT * FROM logingg WHERE ID  =   {$id_new} ");
    confirm($query);

    while($row = fetch_array($query)) {

      $username = escape_string($row['name']);
      $email = escape_string($row['email']);
      $password = "";  
    }
    
    update_user_GG($id_new);
  }else if (isset($_POST['oder'])){
    redirect('profile_oder.php');
  }
   else {
    $query = query("SELECT * FROM users WHERE user_id = " . escape_string($_GET['id']) . " ");
    confirm($query);

    while($row = fetch_array($query)) {

      $username = escape_string($row['username']);
      $email = escape_string($row['email']);
      $password = escape_string($row['password']);   
    }
    
    update_user();
  }
    
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
       <div class="container">
          
          <?php include("navbar.php") ?>
          
       </div>
       
       
<div class="accout-page">
    <div class="container">
  
       <div class="row">
         
          <div class="col-2">
             <img src="images/acc.png" width="50%" style="margin-left: 250px;">
          </div>
          
           <div class="col-2">
              <div class="form-container">
                 <div class="form-btn">
                     <p>Account</p>
                 </div>

               <form action="" method="post" enctype="multipart/form-data">
                          <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control"  value="<?php echo isset($username)? $username : ""; ?>">
                               
                           </div>
                               
                           <div class="form-group">
                                <label for="email">E-mail address</label>
                            <input type="text" name="email" class="form-control" value="<?php echo isset($email) ? $email : ""; ?>">
                               
                           </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" value="<?php echo isset($password) ? $password : ""; ?>">
                               
                           </div>

                            <div class="form-group">

                            <input type="submit" name="update_user" class="btn btn-primary pull-right" value="Update" >
                            <input type="submit" name="oder" class="btn btn-primary pull-right" value="Oder" >
                               
                           </div>
               </form>
              </div>
           </div>
       </div>
</div>
</div>


    <?php include("footer.php") ?>


