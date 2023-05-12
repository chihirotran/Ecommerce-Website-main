<div class="navbar">
        <link rel="stylesheet" href="style2.css">
    <div class="logo">
        <a href="homepage.php"><img src="images/Logo2.png" width="40px"></a>
    </div>
    <nav>
     <ul id="MenuItems">
        <li><i class="fa fa-home" aria-hidden="true"></i><a href="homepage.php"> Trang Chủ</a></li>
        <li><i class="fa fa-bars" aria-hidden="true"></i><a href="products.php"> Sản Phẩm</a></li>
        <li><i class="fa fa-shopping-cart" aria-hidden="true"></i><a href="shopping_cart.php"> Giỏ Hàng</a></li>
        <li><i class="fa fa-user" aria-hidden="true"></i><a href="<?php echo isset($_SESSION['username']) ? "profile.php?id={$_SESSION['user_id']}" : "login_page.php"?>"> <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : "Đăng Nhập"?></a></li>
        <li><a href="logout.php"><i class="fa fa-fw fa-power-off"></i> <?php echo isset($_SESSION['username']) ? "Logout" : "" ?></a></li>
        <li><a href="admin_index.php"><?php if(isset($_SESSION['username']) &&  ($_SESSION['username'] == 'admin') ) {
            echo "Panel";
        } else {
            echo ""; 
        } ?></a></li>


     </ul>
    </nav>
    <img src="images/menu.png" onclick="menutoggle()" class="menu-icon">
</div>