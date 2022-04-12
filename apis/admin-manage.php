<?php
include('./config.php');
if (isset($_POST['delete'])) {
    $seller_id = $_POST['seller_id'];
    $inactive_seller = "UPDATE users SET active = '0' WHERE `uid` = '$seller_id' ";
    $response = mysqli_query($conn, $inactive_seller) or die(mysqli_error($conn));

    $set_seller_products_outstock = "UPDATE products SET stock = '0' WHERE `sid` = '$seller_id'";
    $response = mysqli_query($conn, $set_seller_products_outstock) or die(mysqli_error($conn));

    $set_orders_not_deliverable = "UPDATE user_orders SET `status` = 'not deliverable' WHERE `sid` = '$seller_id'";
    $response = mysqli_query($conn, $set_orders_not_deliverable) or die(mysqli_error($conn));

    echo "seller successfully suspended.";
}

if (isset($_POST['send_replies'])) {
    $query_ids = $_POST['query_ids'];
    $replies = $_POST['replies'];

    for ($i = 0; $i < sizeof($query_ids); $i++) {
        if ($replies[$i] != "") {
            $update_reply = "UPDATE queries SET reply = '$replies[$i]' WHERE qid = '$query_ids[$i]' ";
            $response = mysqli_query($conn, $update_reply) or die(mysqli_error($conn));
        }
    }
    echo "successfully sent replies...";
}

if (isset($_POST["add_category"])) {
    $name = $_POST['name'];
    $tagline = $_POST['tagline'];
    $create_category = "INSERT INTO product_categories (category_name,category_tagline) VALUES ('$name','$tagline')";
    $response = mysqli_query($conn, $create_category) or die(mysqli_error($conn));
    echo "successfully created a new category with name '$name'";
}

if (isset($_POST["update_category"])) {
    $pcid = $_POST['pcid'];
    $name = $_POST['name'];
    $tagline = $_POST['tagline'];
    $update_category = "UPDATE product_categories SET category_name = '$name',category_tagline = '$tagline' WHERE category_id = '$pcid'";
    $response = mysqli_query($conn, $update_category) or die(mysqli_error($conn));
    echo "successfully updated the category with name '$name'";
}
