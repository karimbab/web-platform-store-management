<?php
include('./apis/config.php');
$sid = $_SESSION['uid'];
$read_seller_products = "SELECT * FROM products WHERE `sid` = '$sid' ORDER BY last_updated_at DESC";
$response = mysqli_query($conn, $read_seller_products) or die(mysqli_error($conn));
$seller_products = mysqli_fetch_all($response, MYSQLI_ASSOC);

if (mysqli_num_rows($response) > 0) {
    $edit_access = $_GET['edit_access'];
    if ($edit_access == 0) {
        echo "
            <div class='row card-body'>
                <div class='col-md-6'>
                    <select class='form-control' id='selected_product' required>
            ";

        for ($i = 0; $i < mysqli_num_rows($response); $i++) {
            $product_id = $seller_products[$i]['pid'];
            $product_name = ucwords($seller_products[$i]['name']);
            echo "<option value=$product_id>$product_name</option>";
        }

        echo "
                        </select>
                    </div>
                <div class='col-md-6'>
                    <a href='' class='btn btn-outline-danger w-100' id='request_edit_access_btn' onclick='request_edit_access()'>Edit Product</a>
                </div>
            </div>
        ";
    } else {
        $pid = $_GET['pid'];
        $read_product_with_id = "SELECT * FROM products WHERE pid = '$pid' and `sid` = '$sid' ";
        $response = mysqli_query($conn, $read_product_with_id) or die(mysqli_error($conn));
        $product_details = mysqli_fetch_row($response);

        /**
         * unemuerate color ids with color values
         */
        $unserialized_colorIDs = unserialize(base64_decode($product_details[4]));
        $colors_field = "";
        for ($j = 0; $j < sizeof($unserialized_colorIDs); $j++) {
            $query = "SELECT * FROM product_color WHERE color_id = '$unserialized_colorIDs[$j]' ";
            $response = mysqli_query($conn, $query) or die(mysqli_error($conn));
            $item_color = mysqli_fetch_row($response);
            $color = ucwords($item_color[1]);
            $colors_field .= "$color";
            if ($j < sizeof($unserialized_colorIDs) - 1) {
                $colors_field .= ",";
            }
        }

        $product_name = ucwords($product_details[1]);
        echo "
            <form class='card-body' action='./apis/seller-daemon.php' method='POST'>
                <input type='hidden' class='form-control' name='pid' value='$pid'>
                <div class='row'>
                    <div class='col'>
                        <div class='form-group'>
                            <label for='name'>Name:</label>
                            <input type='text' class='form-control' readonly name='name' value='$product_name' required>
                        </div>
                    </div>
                    <div class='col'>
                        <div class='form-group'>
                            <label for='color'>Colors:</label>b
                            <input type='text' class='form-control' name='color' value='$colors_field' required>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class='col'>
                        <div class='form-group'>
                            <label for='price'>Price (in ₹):</label>
                            <input type='number' class='form-control' name='price' value=$product_details[3] required>
                        </div>
                    </div>
                    <div class='col'>
                        <div class='form-group'>
                            <label for='category'>Category:</label> 
                            <select class='form-control' name='category_id' required>
        ";

        $read_product_categories = "SELECT * FROM product_categories ";
        $response = mysqli_query($conn, $read_product_categories) or die(mysqli_error($conn));
        $available_categories = mysqli_fetch_all($response, MYSQLI_ASSOC);

        for ($i = 0; $i < mysqli_num_rows($response); $i++) {
            $category_id = $available_categories[$i]['category_id'];
            $category_name = ucwords($available_categories[$i]['category_name']);
            if ($category_id == $product_details[2]) {
                echo "<option value=$category_id selected>$category_name</option>";
            } else {
                echo "<option value=$category_id>$category_name</option>";
            }
        }

        echo "          </select>
                    </div>
                </div>
            </div> 
            <div class='row'>
                <div class='col'>
                    <div class='form-group'>
                        <label for='price'>Stock:</label>
                        <select class='form-control' name='stock' required>
        ";

        if ($product_details[6] == 1) {
            echo "
                            <option value='1' selected>In Stock</option>
                            <option value='0'>Out of Stock</option>
                        </select>
                    </div>
                ";
        } else {
            echo "
                            <option value='1'>In Stock</option>
                            <option value='0' selected>Out of Stock</option>
                        </select>
                    </div>
                ";
        }

        echo "
            </div>
            <div class='col'>
                <div class='form-group'>
                    <label for='quantity'>Quantity:</label>
                    <input class='form-control' type='number' name='quantity' value='$product_details[7]' required>
                </div>
            </div>
        </div>    
        ";

        echo "
                <div class='form-group'>
                    <label for='desc'>Description:</label> 
                    <textarea class='form-control' name='descr' rows='5' maxlength='250'>$product_details[5]</textarea>
                </div>
                <div class='text-center'>
                    <button type='submit' class='btn btn-outline-danger w-50' name='update'>UPDATE</button>
                </div>
            </form>
        ";
    }
} else {
    echo "
        <h4 class='text-center mb-3'>
            None of your product exists, <a href='../shop.php?query=add'>Add Product</a>.
        </h4>
    ";
}
