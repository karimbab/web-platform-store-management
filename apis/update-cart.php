<?php

include('config.php');
$query = $_GET['query'];
$cid = $_SESSION['uid'];

if ($query == "add") {
    $pid = $_GET['pid'];
    $sid = $_GET['sid'];
    $date = date("Y-m-d");
    $expected_delivery_date = date("Y-m-d", strtotime($date . "+7 day"));

    $read_product = "SELECT * FROM products WHERE pid = '$pid' and `sid` = '$sid' ";
    $response = mysqli_query($conn, $read_product) or die(mysqli_error($conn));
    $encoded_product_color_ids = mysqli_fetch_row($response)[4];
    $decoded_product_color_ids = unserialize(base64_decode($encoded_product_color_ids));

    $select_product_color = "SELECT * FROM product_color WHERE color_id = '$decoded_product_color_ids[0]' ";
    $response = mysqli_query($conn, $select_product_color) or die(mysqli_error($conn));
    $selected_product_color = mysqli_fetch_row($response)[1];

    $add_product = "INSERT INTO user_cart (cid,pid,`sid`,quantity,color,delivery_by) VALUES ('$cid','$pid','$sid','1','$selected_product_color','$expected_delivery_date')";
    $response = mysqli_query($conn, $add_product) or die(mysqli_error($conn));
    echo "Product successfully added to your cart.";
}

if ($query == "remove") {
    $pid = $_GET['pid'];
    $sid = $_GET['sid'];

    $remove_product = "DELETE FROM user_cart WHERE cid = '$cid' and pid = '$pid' and `sid` = '$sid' ";
    $response = mysqli_query($conn, $remove_product) or die(mysqli_error($conn));
    echo "Product successfully removed from your cart.";
}

if ($query == "update") {
    if (isset($_POST['update'])) {
        $pid = $_POST['pid'];
        $sid = $_POST['sid'];
        $quantity = $_POST['quantity'];
        $colors = $_POST['color'];
        for ($i = 0; $i < sizeof($pid); $i++) {
            $color = strtolower($colors[$i]);
            $update_req = "UPDATE user_cart SET quantity = '$quantity[$i]', color = '$color' WHERE pid = '$pid[$i]' and cid = '$cid' and `sid` = '$sid[$i]' ";
            $response = mysqli_query($conn, $update_req) or die(mysqli_error($conn));
        }
    }
    echo "Cart successfully updated.";
}
