<?php
// Kết nối đến cơ sở dữ liệu MySQL
$conn = mysqli_connect("localhost", "root", "", "website_db");

// Lấy giá trị ngày từ cột 'date'
$result = mysqli_query($conn, "SELECT date FROM saleevent WHERE date>NOW();");

// Lấy giá trị ngày dưới dạng chuỗi từ kết quả truy vấn
$row = mysqli_fetch_assoc($result);
$date_str = $row['date'];

// Trả về dữ liệu JSON chứa giá trị ngày
header('Content-Type: application/json');
echo json_encode(array('date' => $date_str));
?>
