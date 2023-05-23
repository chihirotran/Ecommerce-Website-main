<?php
function set_message($message)
{
	if (!empty($message)) {
		$_SESSION['message'] = $message;
	} else {
		$message = "";
	}
}

function display_message()
{

	if (isset($_SESSION['message'])) {
		echo $_SESSION['message'];
		unset($_SESSION['message']);
	}
}

function redirect($location)
{
	return header("Location: $location");
}

function query($sql)
{
	global $connection;
	return mysqli_query($connection, $sql);
}

function confirm($result)
{
	global $connection;

	if (!$result) {
		die("QUERY FAILED " . mysqli_error($connection));
	}
}

function escape_string($string)
{
	global $connection;
	return mysqli_real_escape_string($connection, $string);
}

function fetch_array($result)
{
	return mysqli_fetch_array($result);
}

function get_four_products()
{
	$query = query("SELECT * FROM `products` ORDER BY `products`.`product_id` DESC");
	$count = 0;
	confirm($query);

	while ($row = fetch_array($query)) {

		if ($count < 8) {
			$price_format = number_format($row['product_price'], 0, '.', ',');
			$product = <<<DELIMETER
		    <div class="col-4">
		    	<a href="product_detail.php?id={$row['product_id']}"><img src="admin/postimages/{$row['product_image']}"></a>
		    	<h4><a href="product_detail.php?id={$row['product_id']}">{$row['product_title']}</a></h4>
		    	<p style="color: red;">{$price_format}VND</p>
		    	<p>{$row['product_short_desc']}</p>
		        <a class="btn" href="cart.php?add={$row['product_id']}" style="font-family: sans-serif;">Thêm vào Giỏ Hàng</a>
		    </div>
		DELIMETER;

			echo $product;
			$count = $count + 1;
		}
	}
}
function get_four_cate()
{
	$query = query("SELECT product_image , cat_title, categories.cat_id FROM `categories` , `products` WHERE products.product_category_id = categories.cat_id GROUP BY categories.cat_id;");
	$count = 0;
	confirm($query);

	while ($row = fetch_array($query)) {

		if ($count < 4) {
			
			$product = <<<DELIMETER
		    <div class="col-4" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(admin/postimages/{$row['product_image']}) center center no-repeat; ; background-size: cover;display: flex;justify-content: center;align-items: center;">
				
		    	<h4><a href="category_page.php?id={$row['cat_id']}" style="color: #f9f9f9;">{$row['cat_title']}</a></h4>
		    	
		    </div>
		DELIMETER;

			echo $product;
			$count = $count + 1;
		}
	}
}

function get_products()
{
	$query = query("SELECT * FROM products");
	confirm($query);

	while ($row = fetch_array($query)) {

		$product = <<<DELIMETER
		    <div class="col-4">
		    	<a href="product_detail.php?id={$row['product_id']}"><img width='100' src="admin/postimages/{$row['product_image']}"></a>
		    	<h4><a href="product_detail.php?id={$row['product_id']}">{$row['product_title']}</a></h4>
		    	<p style="color: red;">{$row['product_price']}VND</p>
		    	<p>{$row['product_short_desc']}</p>
		        <a class="btn" href="cart.php?add={$row['product_id']}" style="font-family: sans-serif;">Thêm vào Giỏ Hàng</a>
		    </div>
		DELIMETER;

		echo $product;
	}
}


function login_user()
{

	if (isset($_POST['submit'])) {
		$username = escape_string($_POST['username']);
		$password = escape_string($_POST['password']);
		$query = query("SELECT * FROM users WHERE username = '{$username}'");
		confirm($query);

		if (mysqli_num_rows($query) > 0) {
			while ($row = fetch_array($query)) {
				$password_hash = $row['password'];
				if (password_verify($password, $password_hash)) {
					$user_id = escape_string($row['user_id']);

					$gmail_authentication = escape_string($row['gmail_authentication']);
					$email = escape_string($row['email']);
					if ($gmail_authentication == 1) {
						$_SESSION['user_id'] = $user_id;
						$_SESSION['username'] = $username;
						redirect("homepage.php");
					} else {
						redirect("gmail_authentication.php?email=$email&username=$username");
					}
				} else {
					set_message("Mật Khẩu Không Đúng");
					redirect("login_page.php");
				}
			}
		} else {
			while ($row = fetch_array($query)) {
			}


			if ($username == 'admin' && $password == '1234') {
				redirect("admin_index.php");
			} else {
				redirect("homepage.php");
			}
		}
	}
}
function add_user_google($email, $name)
{


	$query = query("INSERT INTO `logingg`(`email`, `name`) VALUES ('{$email}','{$name}')");
	confirm($query);

	set_message("USER CREATED");
	$_SESSION['user_id'] = 'GG' . get_id_user_google($email, $name);
	$_SESSION['username'] = $name;
	redirect("homepage.php");
}
function get_id_user_google($email, $name)
{

	$query = query("SELECT ID FROM `logingg` WHERE `email`='{$email}' and `name`='{$name}'");
	confirm($query);
	while ($row = fetch_array($query)) {
		$id_google = $row['ID'];
	}
	return $id_google;
}
function get_count_user_google($email, $name)
{

	$query = query("SELECT * FROM `logingg` WHERE `email`='{$email}' and `name`='{$name}'");
	confirm($query);
	$count = 0;
	while ($row = fetch_array($query)) {
		$count++;
	}
	return $count;
}
function login_with_google()
{
	require_once 'vendor/autoload.php';
	require_once("config.php");
	// init configuration 
	$clientID = '479994957114-08vqe42eo7ad9vggfnm2u89irne57s4b.apps.googleusercontent.com';
	$clientSecret = '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';
	$redirectUri = 'http://localhost/Ecommerce-Website-main/redirect-login.php';

	// create Client Request to access Google API 
	$client = new Google_Client();
	$client->setClientId($clientID);
	$client->setClientSecret($clientSecret);
	$client->setRedirectUri($redirectUri);
	$client->addScope("email");
	$client->addScope("profile");

	// authenticate code from Google OAuth Flow 
	if (isset($_GET['code'])) {
		$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
		$client->setAccessToken($token['access_token']);
		$oauth = new Google_Service_Oauth2($client);
		$userInfo = $oauth->userinfo->get();
		$email = $userInfo->email;
		$name = $userInfo->name;
		echo $name;
		$row = get_count_user_google($email, $name);
		echo $row;
		echo $email;
		if ($row == 0) {
			add_user_google($email, $name);
		}
		if ($row > 0) {
			$_SESSION['user_id'] = $user_id;
			$_SESSION['username'] = $username;
			header('location:homepage.php');
		}
	} else {
		echo "<a href='" . $client->createAuthUrl() . "'>Google Login</a> ";
	}
}

function add_user()
{

	if (isset($_POST['add_user'])) {



		$username = escape_string($_POST['username']);
		$email = escape_string($_POST['email']);
		$password = escape_string($_POST['password']);
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		$code = escape_string($_POST['code']);
		$query = query("INSERT INTO users(username,email,password) VALUES('{$username}','{$email}','{$hashed_password}')");
		confirm($query);

		set_message("USER CREATED");
		email_verification($email);
		redirect("gmail_authentication.php?email=$email&username=$username");
	}
}
function code_verification($email, $username)
{
	$query = query("UPDATE users SET gmail_authentication=1 WHERE email='{$email}' AND username='{$username}'");
	confirm($query);
	redirect("homepage.php");
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function email_verification($email)
{


	if (isset($_POST['email_verification']))


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
	$mail->Password = 'rfxdwcdufncndzmf'; // Thay đổi mật khẩu của bạn
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
	$_SESSION['code'] = $codeRDX;
	// Gửi email và kiểm tra kết quả
	if ($mail->send()) {
		echo 'Email đã được gửi thành công!';
	} else {
		echo 'Đã có lỗi xảy ra khi gửi email: ' . $mail->ErrorInfo;
	}
}




function show_product_category_title($product_category_id)
{

	$category_query = query("SELECT * FROM categories WHERE cat_id = {$product_category_id} ");
	confirm($category_query);

	while ($category_row = fetch_array($category_query)) {
		return $category_row['cat_title'];
	}
}
function show_category_title()
{
	$category_query = query("SELECT * FROM categories");
	confirm($category_query);
	$cnt = 1;
	while ($row = fetch_array($category_query)) {
		$category = <<<DELIMETER
		<tr>
		<th scope="row">{$cnt}</th>
		<td>{$row['cat_title']};</td>
		<td><a href="edit-category.php?cid={$row['cat_id']}"><i class="fa fa-pencil" style="color: #29b6f6;"></i></a> 
			&nbsp;<a href="manage-categories.php?rid={$row['cat_id']}&&action=del"> <i class="fa fa-trash-o" style="color: #f05050"></i></a> </td>
		</tr>
		
		DELIMETER;
		$cnt++;
		echo $category;
	}
}
function show_category_title_select()
{
	$category_query = query("SELECT * FROM categories");
	confirm($category_query);
	$cnt = 1;
	while ($row = fetch_array($category_query)) {
		$category = <<<DELIMETER
		<option value="{$row['cat_id']}">{$row['cat_title']}</option>
		DELIMETER;
		$cnt++;
		echo $category;
	}
}
function show_product_title_select()
{
	$category_query = query("SELECT product_id,product_title  FROM products");
	confirm($category_query);
	$cnt = 1;
	while ($row = fetch_array($category_query)) {
		$category = <<<DELIMETER
		<option value="{$row['product_id']}">{$row['product_title']}</option>
		DELIMETER;
		$cnt++;
		echo $category;
	}
}
function show_event_title_select()
{
	$category_query = query("SELECT * FROM saleevent ORDER BY id DESC;");
	confirm($category_query);
	$cnt = 1;
	while ($row = fetch_array($category_query)) {
		$category = <<<DELIMETER
		<option value="{$row['ID']}">{$row['Name']}</option>
		DELIMETER;
		$cnt++;
		echo $category;
	}
}
function del_category($id)
{
	$category_query = query("DELETE FROM categories WHERE cat_id='{$id}';");
	confirm($category_query);
	redirect("manage-categories.php");
}
function update_category($id, $cat_title)
{

	$category_query = query("UPDATE categories SET  cat_title='{$cat_title}' WHERE cat_id='{$id}';");
	confirm($category_query);
	set_message("successful update ");
	redirect("manage-categories.php");
}
function edit_category_title($cid)
{
	$category_query = query("SELECT * FROM categories where cat_id='{$cid}';");
	confirm($category_query);
	while ($row = fetch_array($category_query)) {
		$category = <<<DELIMETER
		<div class="row">
			<div class="col-md-6">
				<form class="form-horizontal" name="category" method="post">
					<div class="form-group">
						<label class="col-md-2 control-label">Category</label>
						<div class="col-md-10">
							<input type="text" class="form-control" value={$row['cat_title']} name="category" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label">&nbsp;</label>
						<div class="col-md-10">

							<button type="submit" class="btn btn-custom waves-effect waves-light btn-md" name="submit">
								Update
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		DELIMETER;
		echo $category;
	}
}
function edit_product_title($cid)
{
	$category_query = query("SELECT *,categories.cat_title FROM products, categories where products.product_category_id=categories.cat_id AND products.product_id='{$cid}';");
	confirm($category_query);
	while ($row = fetch_array($category_query)) {
		$category = <<<DELIMETER
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="p-6">
					<div class="">
						<form name="addpost" method="post" enctype="multipart/form-data">
							<div class="form-group m-b-20">
								<label for="exampleInputEmail1">Post Title</label>
								<input type="text" class="form-control" id="posttitle" name="posttitle" value={$row['product_title']} required>
							</div>



							<div class="form-group m-b-20">
								<label for="exampleInputEmail1">Category</label>
								<select class="form-control" name="category" id="category" onChange="getSubCat(this.value);" required>
									<option value="{$row['cat_title']}">{$row['cat_title']}</option>
									<?php
									show_category_title_select();
									?>

								</select>
							</div>

							<div class="form-group m-b-20">
								<label for="exampleInputEmail1">Price</label>
								<input type="text" class="form-control" id="Price" name="Price" value={$row['product_price']} required>
							</div>
							<div class="form-group m-b-20">
								<label for="exampleInputEmail1">Số Lượng</label>
								<input type="text" class="form-control" id="quantity" name="quantity" value={$row['product_quantity']} required>
							</div>
							<div class="form-group m-b-20">
								<label for="exampleInputEmail1">Mô Tả Ngắn</label>
								<input type="text" class="form-control" id="MTShort" name="MTShort" value={$row['product_short_desc']} required>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="card-box">
										<h4 class="m-b-30 m-t-0 header-title"><b>Details</b></h4>
										<textarea class="summernote" name="postdescription" value={$row['product_description']} required></textarea>
									</div>
								</div>
							</div>


							<div class="row">
								<div class="col-sm-12">
									<div class="card-box">
										<h4 class="m-b-30 m-t-0 header-title"><b>Feature Image</b></h4>
										<input type="file" class="form-control" id="postimage" name="postimage" required>
									</div>
								</div>
							</div>


							<button type="submit" name="submit" class="btn btn-success waves-effect waves-light">Save and Post</button>
							<button type="button" class="btn btn-danger waves-effect waves-light">Discard</button>
						</form>
					</div>
				</div> <!-- end p-20 -->
			</div> <!-- end col -->
		</div>
		DELIMETER;
		echo $category;
	}
}

function delete_product_1($id)
{
	$product_query = query("DELETE FROM products WHERE product_id='{$id}';");
	confirm($product_query);
	redirect("manage-posts.php");
}
function get_products_update_page()
{

	$query = query("SELECT * FROM products");
	confirm($query);

	while ($row = fetch_array($query)) {

		$category = show_product_category_title($row['product_category_id']);

		$product = <<<DELIMETER
		<tr>
		    <td>{$row['product_id']}</td>
		    <td><a href="product_detail.php?id={$row['product_id']}"><img src="admin/postimages/{$row['product_image']}" width=100></td></a>
		    <td><a href="update_product.php?id={$row['product_id']}">{$row['product_title']}</a><br>
		    </td>
		    <td>{$category}</td>
		    <td>{$row['product_price']}VND</td>
		    <td>{$row['product_quantity']}</td>
		    <td><a class="btn" href="delete_product.php?id={$row['product_id']}">Remove</a></td>
		</tr>
		DELIMETER;

		echo $product;
	}
}

function time_sale()
{
	$query = query("SELECT * FROM `saleevent` WHERE 1;");
	confirm($query);

	while ($row = fetch_array($query)) {

		$product = <<<DELIMETER
		
		

		    	<div class="wrapper">
				
				<div class="box-time">
					
					<span id="days">day</span>
				</div>
				<div class="box-time">
					
					<span id="hours">hours</span>
				</div>
				<div class="box-time">
					
					<span id="minutes">minutes</span>
				</div>
				<div class="box-time">
					
					<span id="seconds">seconds</span>
				</div>
				</div>
		
			
		DELIMETER;

		echo $product;
	}
}
function time_sale_products()
{
	$query = query("SELECT products.*,saleevent.* FROM `saleevent`, `products`,`products_sale` WHERE saleevent.ID=products_sale.saleevent_id AND products_sale.product_id = products.product_id AND saleevent.date>NOW() ORDER BY saleevent.ID DESC;");
	$count = 0;
	confirm($query);

	while ($row = fetch_array($query)) {
		
		if ($count < 8) {
			$price_sale = $row['product_price']*(100-$row['percent'])/100;
			$price_format = number_format($price_sale, 0, '.', ',');
			$product = <<<DELIMETER
		    <div class="col-4">
		    	<a href="product_detail.php?id={$row['product_id']}"><img src="admin/postimages/{$row['product_image']}"></a>
		    	<h4><a href="product_detail.php?id={$row['product_id']}">{$row['product_title']}</a></h4>
		    	<p style="color: red;">{$price_format}VND</p>
		    	<p>{$row['product_short_desc']}</p>
		        <a class="btn" href="cart.php?add={$row['product_id']}" style="font-family: sans-serif;">Thêm vào Giỏ Hàng</a>
		    </div>
		DELIMETER;

			echo $product;
			$count = $count + 1;
		}
	}
}
function get_category_products()
{
	$query = query("SELECT * FROM products WHERE product_category_id = " . escape_string($_GET['id']) . " ");
	confirm($query);

	while ($row = fetch_array($query)) {

		$product = <<<DELIMETER
	 <div class="col-4">
	 	    	<a href="product_detail.php?id={$row['product_id']}"><img width='100' src="admin/postimages/{$row['product_image']}"></a>
	 	    	<h4><a href="product_detail.php?id={$row['product_id']}">{$row['product_title']}</a></h4>
	 	    	<p style="color: red;">{$row['product_price']}VND</p>
	 	    	<p>{$row['product_short_desc']}</p>
	 	        <a class="btn btn-primary" target="_blank" href="cart.php?add={$row['product_id']}" style="font-family: sans-serif;">Thêm vào Giỏ Hàng</a>
	 	    </div>
	DELIMETER;

		echo $product;
	}
}

function update_product()
{

	if (isset($_POST['update'])) {


		$product_title = escape_string($_POST['product_title']);
		$product_category_id = escape_string($_POST['product_category_id']);
		$product_price = escape_string($_POST['product_price']);
		$product_description = escape_string($_POST['product_description']);
		$product_short_desc = escape_string($_POST['product_short_desc']);
		$product_quantity = escape_string($_POST['product_quantity']);
		$product_image = escape_string($_FILES['file']['name']);
		$image_temp_location = escape_string($_FILES['file']['tmp_name']);

		if (empty($product_image)) {

			$get_pic = query("SELECT product_image FROM products WHERE product_id =" . escape_string($_GET['id']) . " ");
			confirm($get_pic);

			while ($pic = fetch_array($get_pic)) {

				$product_image = $pic['product_image'];
			}
		}


		move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $product_image);

		$query = "UPDATE products SET ";
		$query .= "product_title = '{$product_title}', ";
		$query .= "product_category_id = '{$product_category_id}', ";
		$query .= "product_price = '{$product_price}', ";
		$query .= "product_description = '{$product_description}', ";
		$query .= "product_short_desc = '{$product_short_desc}', ";
		$query .= "product_quantity = '{$product_quantity}', ";
		$query .= "product_image = '{$product_image}'";
		$query .= "WHERE product_id=" . escape_string($_GET['id']);

		$send_update_query = query($query);
		confirm($send_update_query);
		set_message("Product has been updated");
		redirect("update_product_page.php");
	}

	if (isset($_POST['back'])) {
		redirect("update_product_page.php");
	}
}

function update_user()
{

	if (isset($_POST['update_user'])) {

		$username = escape_string($_POST['username']);
		$email = escape_string($_POST['email']);
		$password = escape_string($_POST['password']);

		$_SESSION['username'] = $username;

		$query = "UPDATE users SET ";
		$query .= "username = '{$username}', ";
		$query .= "email = '{$email}', ";
		$query .= "password = '{$password}' ";
		$query .= "WHERE user_id=" . escape_string($_GET['id']);

		$send_update_query = query($query);
		confirm($send_update_query);
		set_message("User has been updated");
		redirect("homepage.php");
	}
}
function update_user_GG($id_new)
{

	if (isset($_POST['update_user'])) {

		$username = escape_string($_POST['username']);
		$email = escape_string($_POST['email']);
		

		$_SESSION['username'] = $username;

		$query = "UPDATE logingg SET name = '{$username}' WHERE ID='{$id_new}' ";

		$send_update_query = query($query);
		confirm($send_update_query);
		set_message("User has been updated");
		redirect("homepage.php");
	}
}


function get_categories()
{

	$query = query("SELECT * FROM categories");
	confirm($query);

	while ($row = fetch_array($query)) {

		$category_links = <<<DELIMETER
		  
		  <a href="category_page.php?id={$row['cat_id']}">{$row['cat_title']}</a>

		DELIMETER;

		echo $category_links;
	}
}


function show_categories_add_product()
{

	$query = query("SELECT * FROM categories");
	confirm($query);

	while ($row = fetch_array($query)) {

		$category_options = <<<DELIMETER
		<option value="{$row['cat_id']}">{$row['cat_title']}</option>
		DELIMETER;

		echo $category_options;
	}
}
function add_login_google()
{

	$query = query("SELECT * FROM categories");
	confirm($query);

	while ($row = fetch_array($query)) {

		$category_options = <<<DELIMETER
		<option value="{$row['cat_id']}">{$row['cat_title']}</option>
		DELIMETER;

		echo $category_options;
	}
}
function search()
{
	if (isset($_POST['search_product'])) {
		$search = escape_string($_POST['search']);
		$_SESSION['product_name'] = $search;
		redirect("search.php?search=$search");
	}
}


function show_categories_in_admin()
{

	$category_query = query("SELECT * FROM categories");
	confirm($category_query);

	while ($row = fetch_array($category_query)) {

		$cat_id = $row['cat_id'];
		$cat_title = $row['cat_title'];

		$category = <<<DELIMETER
		<tr>
		    <td>{$cat_id}</td>
		    <td style="padding-left: 60px;">{$cat_title}</td>
		    <td style="padding-left: 60px;"><a style="color:red;" href="delete_category.php?id={$row['cat_id']}">Delete</a></td>
		</tr>
		DELIMETER;

		echo $category;
	}
}


function add_category()
{

	if (isset($_POST['submit'])) {
		$cat_title = escape_string($_POST['category']);

		if (empty($cat_title) || $cat_title == " ") {

			echo "<p class='bg-danger'>THIS CANNOT BE EMPTY</p>";
		} else {

			$insert_cat = query("INSERT INTO categories(cat_title) VALUES('{$cat_title}') ");
			confirm($insert_cat);
			set_message("Category Created");
			redirect("manage-categories.php");
		}
	}
}
function add_event()
{

	if (isset($_POST['submit'])) {
		$Name = escape_string($_POST['Name']);
		$Date = escape_string($_POST['Date']);
		$percent = escape_string($_POST['percent']);
		
		if (empty($Name) || $Name == " ") {

			echo "<p class='bg-danger'>THIS CANNOT BE EMPTY</p>";
		} else {
			echo $Date;
			echo $percent;
			$insert_event = query("INSERT INTO `saleevent`( `Name`, `date`, `percent`) VALUES ('{$Name}','{$Date}','{$percent}') ");
			confirm($insert_event);
			set_message("Event Created");
			
			redirect("aboutus.php");
		}
	}
}



function get_products_admin_page()
{

	$query = query("SELECT * FROM products");
	confirm($query);

	while ($row = fetch_array($query)) {

		$category = show_product_category_title($row['product_category_id']);

		$product = <<<DELIMETER
		<tr>
		    <td>{$row['product_id']}</td>
		    <td><img src="admin/postimages/{$row['product_image']}" width=100></td>
		    <td><a href="edit-product.php?id={$row['product_id']}">{$row['product_title']}</a><br>
		    </td>
		    <td>{$category}</td>
		    <td>{$row['product_price']}VND</td>
		    <td>{$row['product_quantity']}</td>
		    <td><a class="btn" href="admin_delete_product.php?id={$row['product_id']}">Remove</a></td>
		</tr>
		DELIMETER;

		echo $product;
	}
}
function add_product_adminpage()
{
	if (isset($_POST['submit'])) {
		$posttitle = escape_string($_POST['product_title']);
		$catid = escape_string($_POST['product_category_id']);
		$Price2 = escape_string($_POST['product_price']);
		$quantity = escape_string($_POST['product_quantity']);
		$product_description = escape_string($_POST['product_description']);
		$MTShort = escape_string($_POST['product_short_desc']);
		$arr = explode(" ", $posttitle);
		$url = implode("-", $arr);
		$imgfile = escape_string($_FILES["postimage"]["name"]);
		// get the image extension
		$extension = substr($imgfile, strlen($imgfile) - 4, strlen($imgfile));
		// allowed extensions
		$allowed_extensions = array(".jpg", "jpeg", ".png", ".gif", ".JGP");
		// Validation for allowed extensions .in_array() function searches an array for a specific value.
		if (!in_array($extension, $allowed_extensions)) {
			echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
		} else {
			//rename the image file
			$imgnewfile = md5($imgfile) . $extension;
			// Code for move image into directory
			move_uploaded_file($_FILES["postimage"]["tmp_name"], "postimages/" . $imgnewfile);

			$status = 1;
			$query = query("INSERT INTO `products`(`product_title`, `product_category_id`, `product_price`, `product_quantity`, `product_description`, `product_short_desc`, `product_image`) VALUES ('{$posttitle}','{$catid}','{$Price2}','{$quantity}','{$product_description}','{$MTShort}','{$imgnewfile}')");
			confirm($query);
		}
	}
}
function add_product_event_adminpage()
{
	if (isset($_POST['submit'])) {
		$Name_product = escape_string($_POST['Products']);
		$Name_Event = escape_string($_POST['Event']);
		$status = 1;
		$query = query("INSERT INTO `products_sale`( `product_id`, `saleevent_id`) VALUES ('{$Name_product}','{$Name_Event}')");
		confirm($query);
		
	}
}
function Show_Product_admin()
{

	$query = query("SELECT *, categories.cat_title FROM `products`, categories WHERE products.product_category_id= categories.cat_id;");
	confirm($query);
	while ($row = fetch_array($query)) {
		$product = <<<DELIMETER
		<tr>
			<td><b>{$row['product_title']}</b></td>
			<td><b>{$row['cat_title']}</b></td>
			<td><b>{$row['product_price']}</b></td>
			<td><b>{$row['product_quantity']}</b></td>
			<td><b>{$row['product_description']}</b></td>
			<td><b>{$row['product_short_desc']}</b></td>
			<td><b><img src="postimages/{$row['product_image']}" width=100></b></td>
			<td><a href="edit-product.php?pid={$row['product_id']}"><i class="fa fa-pencil" style="color: #29b6f6;"></i></a>
				&nbsp;<a href="manage-posts.php?pid={$row['product_id']}&&action=del" onclick="return confirm('Do you reaaly want to delete ?')"> <i class="fa fa-trash-o" style="color: #f05050"></i></a> </td>
		</tr>
		DELIMETER;
		echo $product;
	}
}
function Show_Product_oder_user()
{

	$query = query("SELECT *, categories.cat_title FROM `products`, categories WHERE products.product_category_id= categories.cat_id;");
	confirm($query);
	while ($row = fetch_array($query)) {
		$product = <<<DELIMETER
		<tr>
			<td><b>{$row['product_title']}</b></td>
			<td><b>{$row['cat_title']}</b></td>
			<td><b>{$row['product_price']}</b></td>
			<td><b>{$row['product_quantity']}</b></td>
			<td><b><img src="postimages/{$row['product_image']}" width=100></b></td>
			<td><a href="edit-product.php?pid={$row['product_id']}"><i class="fa fa-pencil" style="color: #29b6f6;"></i></a>
				&nbsp;<a href="manage-posts.php?pid={$row['product_id']}&&action=del" onclick="return confirm('Do you reaaly want to delete ?')"> <i class="fa fa-trash-o" style="color: #f05050"></i></a> </td>
		</tr>
		DELIMETER;
		echo $product;
	}
}
function Show_Product_Sale_admin()
{

	$query = query("SELECT *, categories.cat_title FROM `products`, categories WHERE products.product_category_id= categories.cat_id;");
	confirm($query);
	while ($row = fetch_array($query)) {
		$product = <<<DELIMETER
		<tr>
			<td><b>{$row['product_title']}</b></td>
			<td><b>{$row['cat_title']}</b></td>
			<td><b>{$row['product_price']}</b></td>
			<td><b>{$row['product_quantity']}</b></td>
			<td><b>{$row['product_short_desc']}</b></td>
			<td><b><img src="postimages/{$row['product_image']}" width=100></b></td>
			<td><a href="edit-product.php?pid={$row['product_id']}"><i class="fa fa-pencil" style="color: #29b6f6;"></i></a>
				&nbsp;<a href="manage-posts.php?pid={$row['product_id']}&&action=del" onclick="return confirm('Do you reaaly want to delete ?')"> <i class="fa fa-trash-o" style="color: #f05050"></i></a> </td>
		</tr>
		DELIMETER;
		echo $product;
	}
}
function add_product_admin()
{

	if (isset($_POST['publish'])) {


		$product_title = escape_string($_POST['product_title']);
		$product_category_id = escape_string($_POST['product_category_id']);
		$product_price = escape_string($_POST['product_price']);
		$product_description = escape_string($_POST['product_description']);
		$product_short_desc = escape_string($_POST['product_short_desc']);
		$product_quantity = escape_string($_POST['product_quantity']);
		$product_image = escape_string($_FILES['file']['name']);
		$image_temp_location = escape_string($_FILES['file']['tmp_name']);

		move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $product_image);


		$query = query("INSERT INTO products(product_title, product_category_id, product_price, product_description, product_short_desc, product_quantity, product_image) VALUES('{$product_title}', {$product_category_id}, {$product_price}, '{$product_description}', '{$product_short_desc}', {$product_quantity}, '{$product_image}')");
		confirm($query);
		redirect("admin_products.php");
	}

	if (isset($_POST['back'])) {
		redirect("admin_index.php");
	}
}



function update_product_admin()
{

	if (isset($_POST['publish'])) {


		$product_title = escape_string($_POST['product_title']);
		$product_category_id = escape_string($_POST['product_category_id']);
		$product_price = escape_string($_POST['product_price']);
		$product_description = escape_string($_POST['product_description']);
		$product_short_desc = escape_string($_POST['product_short_desc']);
		$product_quantity = escape_string($_POST['product_quantity']);
		$product_image = escape_string($_FILES['file']['name']);
		$image_temp_location = escape_string($_FILES['file']['tmp_name']);

		if (empty($product_image)) {

			$get_pic = query("SELECT product_image FROM products WHERE product_id =" . escape_string($_GET['id']) . " ");
			confirm($get_pic);

			while ($pic = fetch_array($get_pic)) {

				$product_image = $pic['product_image'];
			}
		}


		move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $product_image);

		$query = "UPDATE products SET ";
		$query .= "product_title = '{$product_title}', ";
		$query .= "product_category_id = '{$product_category_id}', ";
		$query .= "product_price = '{$product_price}', ";
		$query .= "product_description = '{$product_description}', ";
		$query .= "product_short_desc = '{$product_short_desc}', ";
		$query .= "product_quantity = '{$product_quantity}', ";
		$query .= "product_image = '{$product_image}'";
		$query .= "WHERE product_id=" . escape_string($_GET['id']);

		$send_update_query = query($query);
		confirm($send_update_query);
		set_message("Product has been updated");
		redirect("admin_products.php");
	}

	if (isset($_POST['back'])) {
		redirect("admin_index.php");
	}
}



function add_user_admin()
{

	if (isset($_POST['add_user'])) {

		$username = escape_string($_POST['username']);
		$email = escape_string($_POST['email']);
		$password = escape_string($_POST['password']);

		$query = query("INSERT INTO users(username,email,password) VALUES('{$username}','{$email}','{$password}')");
		confirm($query);

		set_message("USER CREATED");

		redirect("users.php");
	}
}


function display_users()
{

	$user_query = query("SELECT * FROM users");
	confirm($user_query);


	while ($row = fetch_array($user_query)) {

		$user_id = $row['user_id'];
		$username = $row['username'];
		$email = $row['email'];
		$password = $row['password'];

		$user = <<<DELIMETER
		<tr>
		    <td>{$user_id}</td>
		    <td style="padding-left: 50px;">{$username}</td>
		    <td style="padding-left: 50px;">{$email}</td>
		    <td><a style="color:red; padding-left: 30px;" class="btn btn-danger" href="delete_user.php?id={$row['user_id']}">Delete User</a>
		</tr>
		DELIMETER;

		echo $user;
	}
}
function Inset_product_oder(){


		$id_user = escape_string($_SESSION['user_id']);
		$Address = escape_string($_POST['product_title']);
		$Address1= escape_string($_POST['ward']);
		$Address2= escape_string($_POST['district']);
		$Address3= escape_string($_POST['city']);
		$url1 ="https://provinces.open-api.vn/api/d/{$Address2}";
		$url2 = "https://provinces.open-api.vn/api/p/{$Address3}";
		$url3 ="https://provinces.open-api.vn/api/w/{$Address1}";
		$data_d = file_get_contents($url1);
		$data_d = json_decode($data_d, true);
		$name1 = $data_d['name'];
		$data_p = file_get_contents($url2);
		$data_p = json_decode($data_p, true);
		$name2 = $data_p['name'];
		$data_w = file_get_contents($url3);
		$data_w = json_decode($data_w, true);
		$name3 = $data_w['name'];
		$Address4=$Address.$name3.$name1.$name2;
		$Payment_Type = escape_string($_POST['pay_type']);
		$price = escape_string($_SESSION['total_price']);
		$current_time = date('Y-m-d H:i:s');
		$query = query("INSERT INTO `oder`( `id_user`, `price`, `Address`, `Payment_Type`,`date_oder`) VALUES ('{$id_user}','{$price}','{$Address4}','{$Payment_Type}','{$current_time}')");
		confirm($query);
		$select = query("SELECT * FROM `oder`WHERE id_user ='{$id_user}' AND Address= '{$Address4}' AND Payment_Type='{$Payment_Type}' AND date_oder = '{$current_time}'"); 
		while($row = fetch_array($select)) {
			$id12 = $row['ID'];
			
            
		}
		$total = 0;

       	$item_number = 0;
		foreach ($_SESSION as $name => $value) {

            if($value > 0) {

                if (substr($name, 0, 8) == "product_") {

                    $length = strlen($name) - 8;

                    $id_oder = substr($name, 8, $length);

                    $query = query("SELECT * FROM products WHERE product_id = " . escape_string($id_oder) . " ");
                    confirm($query);


					
                    while($row = fetch_array($query)) {

                        $sub = $row['product_price'] * $value;

                        $item_number += $value;
						$product_quantity = $row['product_quantity'] - $item_number;
						if($product_quantity>0){
						$query_detail = query("INSERT INTO `oder_detail`( `products_id`, `price`, `quantity`, `oder_id`) VALUES ('{$row['product_id']}','{$sub}','{$item_number}','{$id12}')");
                   		confirm($query_detail);
						
						$update_product = query("UPDATE `products` SET `product_quantity` = {$product_quantity}");
						confirm($update_product);
						
					}
					else{

					}
                    }

                }

            }

        }
		
		foreach($_SESSION as $key => $value) {
			if(substr($key, 0, 8) == 'product_') {
			  unset($_SESSION[$key]);  
			}
		  } 
		  unset($_SESSION['total_price']);
		  unset($_SESSION['total_number']);

		// echo $id_user;
		// echo $Address;
		// echo $price;
		// echo $Payment_Type;
		// echo $current_time;

		// // echo "*cac*";
		// echo $id12;
		// // echo "2cac2";
		// echo $Address4;
		// redirect("homepage.php");
	

	// if (isset($_POST['back'])) {
	// 	redirect("admin_index.php");
	// }
}
// function Update_Oder_Pay(){
// 	$query = query("UPDATE oder SET gmail_authentication=1 WHERE email='{$email}' AND username='{$username}'");
// 	confirm($query);
// 	redirect("homepage.php");
// }

function Get_Manage_Comments(){
	$query = query("SELECT * FROM `comment`,products WHERE comment.product_id=products.product_id;");
	confirm($query);
	$cnt =0;
	while ($row = fetch_array($query)) {
		$st = $row['Start'];
		if ($st == 1) {
			$sta = 'Da Duyet';
		}
		else {
			$sta = 'Chua Duyet';
		}
		$comment = <<<DELIMETER
		<tr>                                                            
			<td>{$row['NameUser']}</td>
			<td>{$row['Text']}</td>
			
			<td>$sta</td>
			<td><a href="../product_detail.php?id={$row['product_id']}" ">{$row['product_title']}</a></td>
			<td>{$row['date_comment']}</td>
			<td>
				<a href="manage-comments.php?appid={$row['COM_ID']}" title="Duyet"><i class="ion-arrow-return-right" style="color: #29b6f6;"></i></a>
				&nbsp;<a href="manage-comments.php?rid={$row['COM_ID']}&&action=del"> <i class="fa fa-trash-o" style="color: #f05050"></i></a>
			</td>
		</tr>
		DELIMETER;
		$cnt ++;
		echo $comment;
	}
	
}
function Duyet_comment(){
	if ($_GET['appid']) {
        $id = escape_string($_GET['appid']);
        $query = query("update comment set Start='1' where COM_ID='$id'");
        confirm($query);
    }
}
function Delete_comment(){
	if ($_GET['action'] == 'del' && $_GET['rid']) {
        $id = escape_string($_GET['rid']);
        $query = query("delete from  comment  where COM_ID='$id'");
        confirm($query);
    }
}
function Get_mamage_oder_admin(){
	$query = query("SELECT * FROM `oder` ORDER BY `oder`.`date_oder` DESC");
	confirm($query);
	$cnt =0;
	while ($row = fetch_array($query)) {
		$st = $row['Pay'];
		if ($st == 1) {
			$sta = 'Da Duyet';
		}
		else {
			$sta = 'Chua Duyet';
		}	
		$comment = <<<DELIMETER
		<tr> 
			<td onclick="window.location.href='get_oder-detail.php?oid={$row['ID']}'">{$row['ID']}</td>                                                           
			<td onclick="window.location.href='get_oder-detail.php?oid={$row['ID']}'">{$row['id_user']}</td>
			<td onclick="window.location.href='get_oder-detail.php?oid={$row['ID']}'">{$row['price']}</td>
			<td onclick="window.location.href='get_oder-detail.php?oid={$row['ID']}'">{$row['date_oder']}</td>
			<td onclick="window.location.href='get_oder-detail.php?oid={$row['ID']}'">{$row['Address']}</td>
			<td onclick="window.location.href='get_oder-detail.php?oid={$row['ID']}'"> {$row['Payment_Type']}</td>
			<td>$sta</td>
			<td>
				<a href="manage-subcategories.php?appid={$row['ID']}" title="Duyet"><i class="ion-arrow-return-right" style="color: #29b6f6;"></i></a>
				&nbsp;<a href="manage-subcategories.php?rid={$row['COM_ID']}&&action=del"> <i class="fa fa-trash-o" style="color: #f05050"></i></a>
			</td>
		</tr>
		DELIMETER;
		$cnt ++;
		echo $comment;
	}
}
function Duyet_oder_manager(){
	if ($_GET['appid']) {
        $id = escape_string($_GET['appid']);
        $query = query("update oder set Pay='1' where ID='$id'");
        confirm($query);
    }
}
function Delete_oder_manager(){
	if ($_GET['action'] == 'del' && $_GET['rid']) {
        $id = escape_string($_GET['rid']);
        $query = query("delete from  oder  where ID='$id'");
        confirm($query);
    }
}
function Get_oder_detail_admin(){
	$oder_id = escape_string($_GET['oid']);
	$query = query("SELECT * FROM `oder_detail`,products WHERE products.product_id = oder_detail.products_id AND oder_detail.oder_id ={$oder_id};");
	confirm($query);
	$cnt =0;
	while ($row = fetch_array($query)) {	
		$comment = <<<DELIMETER
		<tr> 
			<td>{$row['oder_id']}</td>                                                           
			<td>{$row['product_title']}</td>
			<td>{$row['quantity']}</td>
			<td><b><img src="postimages/{$row['product_image']}" width=100></b></td>
		</tr>
		DELIMETER;
		$cnt ++;
		echo $comment;
	}
}
function Get_Tong_Thu_Nhap(){
	
	$query = query("SELECT SUM(price) AS total_price FROM oder;");
	confirm($query);
	$cnt =0;
	while ($row = fetch_array($query)) {	
		$total = $row['total_price'];
		$total_fomart = number_format($total, 0, '.', ',');
		echo $total_fomart;
		
	}
}
function Get_Tong_Thu_Nhap_Thang(){
	
	$query = query("SELECT SUM(price) AS total_price FROM oder WHERE month(date_oder)= month(NOW());");
	confirm($query);
	$cnt =0;
	while ($row = fetch_array($query)) {	
		$total = $row['total_price'];
		$total_fomart = number_format($total, 0, '.', ',');
		echo $total_fomart;
	}
}
function Get_Tong_San_Pham(){
	
	$query = query("SELECT COUNT(*) AS Tong FROM products;");
	confirm($query);
	$cnt =0;
	while ($row = fetch_array($query)) {	
		$total = $row['Tong'];
		echo $total;
	}
}
function Get_News_Comment(){
	
	$query = query("SELECT COUNT(*) AS tong FROM comment WHERE date_comment >= DATE_SUB(NOW(), INTERVAL 1 WEEK) AND Start=0;");
	confirm($query);
	$cnt =0;
	while ($row = fetch_array($query)) {	
		$total = $row['tong'];
		echo $total;
	}
}
function checkvoucher(){
	if (isset($_POST['submit'])) {
		
		$voucher = escape_string($_POST['code_voucher']);
		echo $voucher;
		$query = query("SELECT * FROM codevoucher WHERE Code='{$voucher}' and Amount>0");
		confirm($query);

		
		$total_price_no_format = $_SESSION['total_price_no_format'];
		while ($row = fetch_array($query)) {
			$_SESSION['voucher'] = $voucher;
			$_SESSION['Discount'] = $row['Discount'];
		}
	}

}