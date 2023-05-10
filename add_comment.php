<?php
  include("config.php");
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = escape_string($_GET['pid']);
    $name = escape_string($_SESSION['username']);
    $comment = escape_string($_POST['comment']);
    $query = query("INSERT INTO `comment` (`product_id`, `NameUser`, `Text`) VALUES ('$product_id', '$name', '$comment')");
    confirm($query);
    redirect("product_detail.php?id=$product_id");
  }
?>
