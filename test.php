<?php
session_start(); // Đảm bảo đã gọi session_start() trước khi truy cập vào $_SESSION

// In ra tất cả các biến $_SESSION
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

?>