<?php
// Kết nối đến cơ sở dữ liệu ở đây
include("config.php");
$keyword = $_POST['keyword'];

// Tìm kiếm sản phẩm theo từ khóa
$sql = "SELECT * FROM products WHERE product_title LIKE '%$keyword%'";
$result = mysqli_query($conn, $sql);

// Hiển thị kết quả tìm kiếm
while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id'];
    $name = $row['name'];
    $price = $row['price'];

    echo "<div><a href='product_detail.php?id=$id'>$name - $price</a></div>";
}
?>
