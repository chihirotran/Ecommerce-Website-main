<?php require_once("config.php"); ?>

<?php

    if (isset($_GET['add'])) {

        $query = query("SELECT * FROM products WHERE product_id=" . escape_string($_GET['add']) . " ");

        confirm($query);

        while ($row = fetch_array($query)) {
            
              if($row['product_quantity'] > $_SESSION['product_' . $_GET['add']]) {

                $_SESSION['product_' . $_GET['add']] += 1;
                redirect("shopping_cart.php");

              } else {

                set_message("Chúng Tôi Chỉ Có " . $row['product_quantity'] . " Sản Phẩm " . "{$row['product_title']}" ." ");
                redirect("shopping_cart.php");

              }

        }

    }

    if (isset($_GET['remove'])) {
        
        $_SESSION['product_' . $_GET['remove']]--;

        if ($_SESSION['product_' . $_GET['remove']] < 1) {
            
            unset($_SESSION['total_number']);
            unset($_SESSION['total_price']);
            
            redirect("shopping_cart.php");

        } else {

            redirect("shopping_cart.php");


        }

    }


    if (isset($_GET['delete'])) { 

        $_SESSION['product_' . $_GET['delete']] = '0';

        unset($_SESSION['total_number']);
        unset($_SESSION['total_price']);

        redirect("shopping_cart.php");

    }


    function cart() {

        $total = 0;

        $item_number = 0;

        foreach ($_SESSION as $name => $value) {

            if($value > 0) {

                if (substr($name, 0, 8) == "product_") {

                    $length = strlen($name) - 8;

                    $id = substr($name, 8, $length);

                    $query = query("SELECT * FROM products WHERE product_id = " . escape_string($id) . " ");
                    confirm($query);


        
                    while($row = fetch_array($query)) {

                        $sub = $row['product_price'] * $value;

                        $item_number += $value;
                        $total_detail = $row['product_price'];
		                $product_price = number_format($total_detail, 0, '.', ',');
                        $sub_format = number_format($sub, 0, '.', ',');
                        
                        $product = <<<DELIMETER
                        <tr>
                            <td><img width='100' src="admin/postimages/{$row['product_image']}"></td>
                            <td>
                                <div class="cart-info">
                                        <div>
                                        <p><a href="product_detail.php?id={$row['product_id']}">{$row['product_title']}</a></p>
                                        <small>Price: {$product_price}VND</small><br>
                                        <a href="cart.php?add={$row['product_id']}">Thêm &emsp;</a>
                                        <a href="cart.php?remove={$row['product_id']}">Bớt &emsp;</a>
                                        <a href="cart.php?delete={$row['product_id']}">Xoá</a>
                                        

                                        </div>
                                </div>
                            </td>
                            <td><p>$value</p></td>
                            <td>$sub_format VND</td>
                        </tr>
                        DELIMETER;

                        echo $product;
                        $total_price =  $total += $sub;
                        $total_price_format = number_format($total_price, 0, '.', ',');
                        // total price
                        $_SESSION['total_price_no_format'] = $total_price;
                        if(isset($_SESSION['voucher']) && isset($_SESSION['Discount'])){
                            $Discount = intval($_SESSION['Discount']);
                            $total_voucher = $total_price * (100- $Discount) / 100;
                            $_SESSION['total_price'] = number_format($total_voucher, 0, '.', ',');
                        }else{
                        $_SESSION['total_price'] = $total_price_format;}
                        // total item number
                        $_SESSION['total_number'] = $item_number;

                    }

                }

            }

        }

    }

?>