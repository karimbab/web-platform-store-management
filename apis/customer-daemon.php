<?php
include('config.php');
$subject = $_GET['subject'];

if ($subject == "cart") {
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
}

if ($subject == "order") {
    $query = $_GET['query'];
    $cid = $_SESSION["uid"];

    if ($query == "remove") {
        $pid = $_GET['pid'];
        $sid = $_GET['sid'];

        $delete_req = "DELETE FROM user_orders WHERE cid = '$cid' and pid = '$pid' and `sid`='$sid' ";
        $res = mysqli_query($conn, $delete_req) or die(mysqli_error($conn));
        echo "Product successfully removed from ordered list, if you receive this product please don't accept it.";
    }

    if ($query == "set") {
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
    }
}
