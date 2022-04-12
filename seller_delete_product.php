<?php
include('./apis/config.php');
$sid = $_SESSION['uid'];
$read_seller_products = "SELECT * FROM products WHERE `sid` = '$sid' ORDER BY last_updated_at DESC";
$response = mysqli_query($conn, $read_seller_products) or die(mysqli_error($conn));
$seller_products = mysqli_fetch_all($response, MYSQLI_ASSOC);

if (mysqli_num_rows($response) > 0) {
    echo "
        <form class='row card-body' action='./apis/shop.php' method='POST'>
            <div class='col-md-6'>
                <select name='pid' class='form-control' required>
    ";

    for ($i = 0; $i < mysqli_num_rows($response); $i++) {
        $product_id = $seller_products[$i]['pid'];
        $product_name = ucwords($seller_products[$i]['name']);
        if ($i == 0) {
            echo "<option selected value=$product_id>$product_name</option>";
        } else {
            echo "<option value=$product_id>$product_name</option>";
        }
    }

    echo "
                    </select>
                </div>
            <div class='col-md-6'>
                <button type='submit' class='btn btn-outline-danger w-100' name='delete'>Delete product</a>
            </div>
        </form>
    ";
} else {
    echo "
        <h4 class='text-center mb-3'>
            None of your product exists, <a href='../shop.php?query=add'>Add Product</a>.
        </h4>
    ";
}
