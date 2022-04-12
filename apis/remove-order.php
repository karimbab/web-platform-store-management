<?php
    /**
     * remove item from orders if customer wishes to cancel the product
     */
    include('config.php');
    $cid = $_GET['cid'];
    $pid = $_GET['pid'];
    $sid = $_GET['sid'];

    $delete_req = "DELETE FROM user_orders WHERE cid = '$cid' and pid = '$pid' and `sid`='$sid' ";
    $res = mysqli_query($conn,$delete_req) or die(mysqli_error($conn));
    echo "Product successfully removed from ordered list, if you receive this product please don't accept it.";
