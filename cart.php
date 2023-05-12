<?php require_once("config.php"); ?>

<?php

    if (isset($_GET['add'])) {

        $query = query("SELECT * FROM products WHERE product_id=" . escape_string($_GET['add']) . " ");

        confirm($query);

        while ($row = fetch_array($query)) {
            
              if($row['product_quantity'] != $_SESSION['product_' . $_GET['add']]) {

                $_SESSION['product_' . $_GET['add']] += 1;
                redirect("shopping_cart.php");

              } else {

                set_message("We only have " . $row['product_quantity'] . " " . "{$row['product_title']}" ." available");
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

                        $product = <<<DELIMETER
                        <tr>
                            <td><img width='100' src="admin/postimages/{$row['product_image']}"></td>
                            <td>
                                <div class="cart-info">
                                        <div>
                                        <p><a href="product_detail.php?id={$row['product_id']}">{$row['product_title']}</a></p>
                                        <small>Price: {$row['product_price']}VND</small><br>
                                        <a href="cart.php?add={$row['product_id']}">Thêm &emsp;</a>
                                        <a href="cart.php?remove={$row['product_id']}">Bớt &emsp;</a>
                                        <a href="cart.php?delete={$row['product_id']}">Xoá</a>

                                        </div>
                                </div>
                            </td>
                            <td><p>$value</p></td>
                            <td>$sub VND</td>
                        </tr>
                        DELIMETER;

                        echo $product;

                        // total price
                        $_SESSION['total_price'] = $total += $sub;

                        // total item number
                        $_SESSION['total_number'] = $item_number;

                    }

                }

            }

        }

    }

?>