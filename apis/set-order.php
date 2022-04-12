<?php

/**
 * if flag = 1, truncate the user's cart and add selected products orders.
 * else 
 */
include('config.php');
$cid = $_SESSION["uid"];
$flag = $_GET["flag"];
$incart = $_GET["incart"];

if ($flag == 1) {
    $req = "SELECT * FROM user_cart WHERE cid = '$cid' ";
    $res = mysqli_query($conn, $req) or die(mysqli_error($conn));
    $cart = mysqli_fetch_all($res, MYSQLI_ASSOC);

    for ($i = 0; $i < sizeof($cart); $i++) {
        $pid = $cart[$i]["pid"];
        $sid = $cart[$i]["sid"];

        $search_product_stock_status = "SELECT * FROM products WHERE pid = '$pid' and `sid` = '$sid' ";
        $response = mysqli_query($conn, $search_product_stock_status) or die(mysqli_error($conn));
        $stock_status = mysqli_fetch_row($response)[6];
        if ($stock_status == 1) {
            $quantity = $cart[$i]["quantity"];
            $color = $cart[$i]["color"];
            $delivery_by = $cart[$i]["delivery_by"];
            $insert_req = "INSERT INTO user_orders (cid,pid,`sid`,quantity,selected_color,delivery_by,`status`) VALUES ('$cid','$pid','$sid','$quantity','$color','$delivery_by','ordered')";
            $res = mysqli_query($conn, $insert_req) or die(mysqli_error($conn));
            if ($res) {
                $delete_req = "DELETE FROM user_cart WHERE cid = '$cid' and pid = '$pid' and sid = '$sid' ";
                $response = mysqli_query($conn, $delete_req) or die(mysqli_error($conn));
            }
        }
    }
} else {
    $pid = $_GET["pid"];
    $sid = $_GET["sid"];
    $date = date("Y-m-d");
    $expected_delivery_date = date("Y-m-d", strtotime($date . "+7 day"));

    if ($incart == 0) {
        if (isset($_POST['set'])) {
            $color = strtolower($_POST['color']);
            $quantity = $_POST['quantity'];
        }
    } else {
        $search = "SELECT * FROM user_cart WHERE cid = '$cid' and pid = '$pid' and `sid` = '$sid' ";
        $response = mysqli_query($conn, $search) or die(mysqli_error($conn));
        $product_details = mysqli_fetch_row($response);

        $quantity = $product_details[3];
        $color = strtolower($product_details[4]);
        $expected_delivery_date = $product_details[5];
        $delete = "DELETE FROM user_cart WHERE cid = '$cid' and pid = '$pid' and `sid` = '$sid' ";
        $response = mysqli_query($conn, $delete) or die(mysqli_error($conn));
    }
    $insert = "INSERT INTO user_orders (cid,pid,`sid`,quantity,selected_color,delivery_by,`status`) VALUES ('$cid','$pid','$sid','$quantity','$color','$expected_delivery_date','ordered')";
    $response = mysqli_query($conn, $insert) or die(mysqli_error($conn));
}
header('Location: ../orders.php');
