<!-- Checkout -->
<?php
include('./apis/config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | ICT Commercial</title>
    <?php include "./includes/core-styles.html"; ?>
</head>

<body>
    <div class="container-fluid">
        <?php include('./includes/navigation.php') ?>
        <?php
        if ($_SESSION["category"] == "customer") {
            /**
             * fetch billing address
             */
            $cid = $_SESSION["uid"];
            $userName = ucwords($_SESSION['name']);
            $userEmail = $_SESSION['email'];
            $userPhone = $_SESSION['phone'];
            $userAddress = $_SESSION['address'];

            $flag = $_GET['flag'];
            $incart = $_GET['incart'];

            if ($flag == 1) {
                $liked_products = "SELECT * FROM user_cart WHERE cid = '$cid' ";
                $response = mysqli_query($conn, $liked_products) or die(mysqli_error($conn));
                $user_cart = mysqli_fetch_all($response, MYSQLI_ASSOC);
            } else {
                $pid = $_GET['pid'];
                $sid = $_GET['sid'];
            }
            /**
             * function for billing address
             */
            function showBillingDetails($userName, $userEmail, $userPhone, $userAddress, $subtotal)
            {
                echo "
                    <div class='mt-5'>
                        <div class='row'>
                            <div class='col-md-6'>
                                <h4>Billing Address</h4>
                                <h6 class='text-muted'>$userName</h6>
                                <h6 class='text-muted'>$userEmail</h6>
                                <h6 class='text-muted'>$userPhone</h6>
                                <h6 class='text-muted'>$userAddress</h6>
                            </div>
                            <div class='col-md-6'>
                                <h4>Payment Mode</h4>
                                <h6 class='text-muted'>Cash On Delivery Available Only, Online Mode coming soon</h6>
                                <h6 class='text-muted'>Pay ₹$subtotal</h6>
                                <h6 class='text-muted'>We don't entertain any sort of bargain.</h6>
                                <h6 class='text-muted'>Follow covid guidelines and <q>Help Bezubaans</q></h6>
                            </div>
                        </div>
                    </div>
                    <div class='d-flex flex-row mt-4' style='max-width: 1000px;'>
                        <a href='profile.php' class='btn btn-info mr-4 w-50'>Update Billing Address</a>
                ";
            }

            echo "
                <div class='checkout custom-shadow mt-5 p-3'>
                    <div class='text-center'>
                        <h3>Checkout Product/s</h3> 
                        <h6>Products out of stock are dynamically removed.</h6>
                    </div>
            ";

            $subtotal = 0;
            if ($flag == 1) {
                $counter = 0;
                $str = '';
                for ($i = 0; $i < sizeof($user_cart); $i++) {
                    $pid = $user_cart[$i]["pid"];
                    $sid = $user_cart[$i]["sid"];
                    $color = ucwords($user_cart[$i]["color"]);
                    $quantity = $user_cart[$i]["quantity"];
                    $expected_delivery_by = $user_cart[$i]["delivery_by"];

                    $read_product_with_pid = "SELECT * FROM products WHERE pid = '$pid' and `sid` = '$sid' ";
                    $response = mysqli_query($conn, $read_product_with_pid) or die(mysqli_error($conn));
                    $product_profile = mysqli_fetch_row($response);

                    if ($product_profile[6] == 1) {
                        $total = $quantity * $product_profile[3];
                        $subtotal += $total;
                        $product_name = ucwords($product_profile[1]);
                        $str .= "
                                    <div class='row mt-4'>
                                        <div class='col'>$product_name</div>
                                        <div class='col'>$color</div>
                                        <div class='col'>$quantity</div>
                                        <div class='col'>₹$product_profile[3]</div>
                                        <div class='col'>$expected_delivery_by</div>
                                        <div class='col'>₹$total</div>
                                    </div>
                                ";
                    } else {
                        $counter += 1;
                    }
                }
                if ($counter == sizeof($user_cart)) {
                    echo "<h3 class='text-center m-4'> Product selected is out of stock.</h3>";
                } else {
                    echo "
                        <div class='row mt-3'>
                            <div class='col text-muted'>Item</div>
                            <div class='col text-muted'>Color</div>
                            <div class='col text-muted'>Quantity</div>
                            <div class='col text-muted'>Price</div>
                            <div class='col text-muted'>Delivery by</div>
                            <div class='col text-muted'>Total</div>
                        </div>
                        <hr>
                        $str
                    ";

                    echo showBillingDetails($userName, $userEmail, $userPhone, $userAddress, $subtotal);

                    echo "
                            <a href='./apis/set-order.php?flag=1&incart=1' class='btn btn-success ml-2 w-50'>ORDER</a>
                        </div>
                    ";
                }
            } else {
                echo "
                    <div class='row mt-3'>
                        <div class='col text-muted'>Item</div>
                        <div class='col text-muted'>Color</div>
                        <div class='col text-muted'>Quantity</div>
                        <div class='col text-muted'>Price</div>
                        <div class='col text-muted'>Delivery by</div>
                        <div class='col text-muted'>Total</div>
                    </div>
                    <hr>
                ";

                $read_product_with_pid = "SELECT * FROM products WHERE pid = '$pid' and `sid` = '$sid' ";
                $response = mysqli_query($conn, $read_product_with_pid) or die(mysqli_error($conn));
                $product_profile = mysqli_fetch_row($response);
                $product_name = ucwords($product_profile[1]);

                if ($incart == 1) {
                    $search_product = "SELECT * FROM user_cart WHERE pid = '$pid' and `sid` = '$sid' and cid = '$cid' ";
                    $response = mysqli_query($conn, $search_product) or die(mysqli_error($conn));
                    $searched_product = mysqli_fetch_row($response);

                    $selected_color = ucwords($searched_product[4]);
                    $quantity = $searched_product[3];
                    $expected_delivery_date = $searched_product[5];
                    $subtotal = $total = $quantity * $product_profile[3];
                } else {
                    $unserialized_colorIDs = unserialize(base64_decode($product_profile[4]));
                    $selected_color = "<select class='form-control' name='color' required>";

                    for ($j = 0; $j < sizeof($unserialized_colorIDs); $j++) {
                        $search = "SELECT * FROM product_color WHERE color_id = '$unserialized_colorIDs[$j]' ";
                        $response = mysqli_query($conn, $search) or die(mysqli_error($conn));
                        $color = ucwords(mysqli_fetch_row($response)[1]);

                        if ($j == 0) {
                            $selected_color .= "<option selected>$color</option>";
                        } else {
                            $selected_color .= "<option>$color</option>";
                        }
                    }
                    $selected_color .= "</select>";
                    $quantity = "<input type='number' class='form-control' min='1' max='100' value='1' name='quantity' style='max-width:100px;'>";
                    $subtotal = $total = $product_profile[3] . ' per item';

                    $date = date("Y-m-d");
                    $expected_delivery_date = date("Y-m-d", strtotime($date . "+7 day"));
                }

                if ($incart == 1) {
                    echo "
                        <div class='row mt-4'>
                            <div class='col'>$product_name</div>
                            <div class='col'>$selected_color</div>
                            <div class='col'>$quantity</div>
                            <div class='col'>₹$product_profile[3]</div>
                            <div class='col'>$expected_delivery_date</div>
                            <div class='col'>₹$total</div>
                        </div>
                    ";

                    echo showBillingDetails($userName, $userEmail, $userPhone, $userAddress, $subtotal);
                    echo "
                        <a href='./api/set_order.php?flag=0&incart=1&pid=$pid&sid=$sid' class='btn btn-success ml-2 w-50'>ORDER</a>
                    ";
                } else {
                    echo "
                        <form action = './api/set_order.php?flag=0&incart=0&pid=$pid&sid=$sid' method = 'POST'>
                            <div class='row mt-4'>
                                <div class='col'>$product_name</div>
                                <div class='col'>$selected_color</div>
                                <div class='col'>$quantity</div>
                                <div class='col'>₹$product_profile[3]</div>
                                <div class='col'>$expected_delivery_date</div>
                                <div class='col'>₹$total</div>
                            </div>
                    ";

                    echo showBillingDetails($userName, $userEmail, $userPhone, $userAddress, $subtotal);
                    echo "
                            <button type='submit' name='set' class='btn btn-success ml-2 w-50'>ORDER</button>
                        </form>
                    ";
                }
            }
        } else {
            include('page_not_found.php');
        }
        ?>
    </div>
    </div>
</body>

</html>