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
  } else {
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
          
          <div class="content">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box">


                                    <div class="table-responsive">
                                        <table class="table table-colored table-centered table-inverse m-0">
                                            <thead>
                                                <tr>

                                                    <th>Title</th>
                                                    <th>Category</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Image</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                Show_Product_oder_user();
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div> <!-- container -->

                </div>
           </div>
       </div>
</div>
</div>


    <?php include("footer.php") ?>


