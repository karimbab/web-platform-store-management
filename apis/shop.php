<?php
include('config.php');
$sid = $_SESSION['uid'];

if (isset($_POST['request'])) {
    $requested_query = $_POST['query'];
    header("Location: ../shop.php?query=" . $requested_query . "");
}

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $arr_colors = explode(',', $_POST['color']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $quantity = $_POST['quantity'];
    $descr = $_POST['descr'];
    $category_id = $_POST['category_id'];

    $duplicate_product = "SELECT * FROM products WHERE `name` = '$name' AND `sid` = '$sid' ";
    $response = mysqli_query($conn, $duplicate_product) or die(mysqli_error($conn));
    if (mysqli_num_rows($response)) {
        echo "Products already added, add a new product.";
    } else {
        /**
         * enumerate color values to color ids and add new colors
         */
        $color_ids = [];
        for ($i = 0; $i < sizeof($arr_colors); $i++) {
            $temp = strtolower(trim($arr_colors[$i]));
            $search_color = "SELECT * FROM product_color WHERE color_name = '$temp' ";
            $response = mysqli_query($conn, $search_color) or die(mysqli_error($conn));
            if (mysqli_num_rows($response) == 0) {
                $insert_unknown_color = "INSERT INTO product_color (color_name) VALUES ('$temp')";
                $response = mysqli_query($conn, $insert_unknown_color) or die(mysqli_error($conn));
                $search_that_color = "SELECT * FROM product_color WHERE color_name = '$temp' ";
                $response = mysqli_query($conn, $search_that_color) or die(mysqli_error($conn));
                array_push($color_ids, mysqli_fetch_row($response)[0]);
            } else {
                array_push($color_ids, mysqli_fetch_row($response)[0]);
            }
        }
        $color_ids = base64_encode(serialize($color_ids));
        $insert_product = "INSERT INTO products (`name`,category_id,price,color_id,descr,stock,quantity,`sid`) VALUES ('$name','$category_id','$price','$color_ids','$descr','$stock','$quantity','$sid')";
        $response = mysqli_query($conn, $insert_product) or die(mysqli_error($conn));
        echo "product added successfully.";
    }
}


if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $arr_colors = explode(',', $_POST['color']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $quantity = $_POST['quantity'];
    $descr = $_POST['descr'];
    $category_id = $_POST['category_id'];
    $pid = $_POST['pid'];

    /**
     * enumerate color values to color ids and add new colors
     */
    $color_ids = [];
    for ($i = 0; $i < sizeof($arr_colors); $i++) {
        $temp = strtolower(trim($arr_colors[$i]));
        $search_color = "SELECT * FROM product_color WHERE color_name = '$temp' ";
        $response = mysqli_query($conn, $search_color) or die(mysqli_error($conn));
        if (mysqli_num_rows($response) == 0) {
            $insert_unknown_color = "INSERT INTO product_color (color_name) VALUES ('$temp')";
            $response = mysqli_query($conn, $insert_unknown_color) or die(mysqli_error($conn));
            $search_that_color = "SELECT * FROM product_color WHERE color_name = '$temp' ";
            $response = mysqli_query($conn, $search_that_color) or die(mysqli_error($conn));
            array_push($color_ids, mysqli_fetch_row($response)[0]);
        } else {
            array_push($color_ids, mysqli_fetch_row($response)[0]);
        }
    }
    $color_ids = base64_encode(serialize($color_ids));

    $update_product = "UPDATE products SET `name` = '$name',category_id = '$category_id',price = '$price',color_id = '$color_ids',descr = '$descr',stock = '$stock',quantity = '$quantity' WHERE pid = '$pid' AND `sid` = '$sid'";
    $response = mysqli_query($conn, $update_product) or die(mysqli_error($conn));
    echo "product updated successfully.";
}

if (isset($_POST['delete'])) {
    $pid = $_POST['pid'];
    $delete_product = "DELETE FROM products WHERE `pid` = '$pid' and `sid` = '$sid' ";
    $response = mysqli_query($conn, $delete_product) or die(mysqli_error($conn));
    echo "Product deleted successfully.";
}
