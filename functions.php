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
	$query = query("SELECT * FROM products");
	$count = 0;
	confirm($query);

	while ($row = fetch_array($query)) {

		if ($count < 8) {
			$product = <<<DELIMETER
		    <div class="col-4">
		    	<a href="product_detail.php?id={$row['product_id']}"><img src="uploads/{$row['product_image']}"></a>
		    	<h4><a href="product_detail.php?id={$row['product_id']}">{$row['product_title']}</a></h4>
		    	<p style="color: red;">&#36;{$row['product_price']}</p>
		    	<p>{$row['product_short_desc']}</p>
		        <a class="btn" href="cart.php?add={$row['product_id']}">Add to cart</a>
		    </div>
		DELIMETER;

			echo $product;
			$count = $count + 1;
		}

	}
}
function get_four_cate()
{
	$query = query("SELECT product_image , cat_title FROM `categories` , `products` WHERE products.product_category_id = categories.cat_id GROUP BY categories.cat_id;");
	$count = 0;
	confirm($query);

	while ($row = fetch_array($query)) {

		if ($count < 4) {
			$product = <<<DELIMETER
		    <div class="col-4" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(uploads/{$row['product_image']}) center center no-repeat; ; background-size: cover;display: flex;justify-content: center;align-items: center;">
				
		    	<h4><a style="color: #f9f9f9;">{$row['cat_title']}</a></h4>
		    	
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
		    	<a href="product_detail.php?id={$row['product_id']}"><img width='100' src="uploads/{$row['product_image']}"></a>
		    	<h4><a href="product_detail.php?id={$row['product_id']}">{$row['product_title']}</a></h4>
		    	<p style="color: red;">&#36;{$row['product_price']}</p>
		    	<p>{$row['product_short_desc']}</p>
		        <a class="btn" href="cart.php?add={$row['product_id']}">Add to cart</a>
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
			if(password_verify($password,$password_hash)){
			$user_id = escape_string($row['user_id']);
			
			$gmail_authentication = escape_string($row['gmail_authentication']);
			$email = escape_string($row['email']);
			if($gmail_authentication==1){
				$_SESSION['user_id'] = $user_id;
				$_SESSION['username'] = $username;
				redirect("homepage.php");
			}else{
				redirect("gmail_authentication.php?email=$email&username=$username");
			}
			}else{
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
function add_user_google($email,$name){
	
		
		$query = query("INSERT INTO `logingg`(`email`, `name`) VALUES ('{$email}','{$name}')");
		confirm($query);

		set_message("USER CREATED");

		redirect("homepage.php");

	
}
function get_count_user_google($email,$name){
		
		$query = query("SELECT * FROM `logingg` WHERE `email`='{$email}' and `name`='{$name}'");
		confirm($query);
		$count =0;
		while ($row = fetch_array($query)){
			$count++;
		}
		return $count;

	
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
function code_verification($email,$username){
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


function add_product_user()
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
		redirect("update_product_page.php");


	}

	if (isset($_POST['back'])) {
		redirect("products.php");
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
	$cnt=1;
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
	$cnt=1;
	while ($row = fetch_array($category_query)) {
		$category = <<<DELIMETER
		<option value="{$row['cat_id']}">{$row['cat_title']}</option>
		DELIMETER;
		$cnt++;
		echo $category;
	}

}
function del_category($id){
	$category_query = query("DELETE FROM categories WHERE cat_id='{$id}';");
	confirm($category_query);
}
function update_category($id,$cat_title){

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


function get_products_update_page()
{

	$query = query("SELECT * FROM products");
	confirm($query);

	while ($row = fetch_array($query)) {

		$category = show_product_category_title($row['product_category_id']);

		$product = <<<DELIMETER
		<tr>
		    <td>{$row['product_id']}</td>
		    <td><a href="product_detail.php?id={$row['product_id']}"><img src="uploads/{$row['product_image']}" width=100></td></a>
		    <td><a href="update_product.php?id={$row['product_id']}">{$row['product_title']}</a><br>
		    </td>
		    <td>{$category}</td>
		    <td>&#36;{$row['product_price']}</td>
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
	$query = query("SELECT products.* FROM `saleevent`, `products`,`products_sale` WHERE saleevent.ID=products_sale.saleevent_id AND products_sale.product_id = products.product_id;");
	$count = 0;
	confirm($query);

	while ($row = fetch_array($query)) {

		if ($count < 8) {
			$product = <<<DELIMETER
		    <div class="col-4">
		    	<a href="product_detail.php?id={$row['product_id']}"><img src="uploads/{$row['product_image']}"></a>
		    	<h4><a href="product_detail.php?id={$row['product_id']}">{$row['product_title']}</a></h4>
		    	<p style="color: red;">&#36;{$row['product_price']}</p>
		    	<p>{$row['product_short_desc']}</p>
		        <a class="btn" href="cart.php?add={$row['product_id']}">Add to cart</a>
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
	// <div class="col-4">
	// 	    	<a href="product_detail.php?id={$row['product_id']}"><img width='100' src="uploads/{$row['product_image']}"></a>
	// 	    	<h4><a href="product_detail.php?id={$row['product_id']}">{$row['product_title']}</a></h4>
	// 	    	<p style="color: red;">&#36;{$row['product_price']}</p>
	// 	    	<p>{$row['product_short_desc']}</p>
	// 	        <a class="btn btn-primary" target="_blank" href="cart.php?add={$row['product_id']}">Add to cart</a>
	// 	    </div>
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



function get_products_admin_page()
{

	$query = query("SELECT * FROM products");
	confirm($query);

	while ($row = fetch_array($query)) {

		$category = show_product_category_title($row['product_category_id']);

		$product = <<<DELIMETER
		<tr>
		    <td>{$row['product_id']}</td>
		    <td><img src="uploads/{$row['product_image']}" width=100></td>
		    <td><a href="admin_update_product.php?id={$row['product_id']}">{$row['product_title']}</a><br>
		    </td>
		    <td>{$category}</td>
		    <td>&#36;{$row['product_price']}</td>
		    <td>{$row['product_quantity']}</td>
		    <td><a class="btn" href="admin_delete_product.php?id={$row['product_id']}">Remove</a></td>
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
