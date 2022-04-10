<!-- Order -->
<?php
include('./apis/config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders | ICT Commercial</title>
    <?php include "./includes/core-styles.html"; ?>
</head>

<body>
    <div class="container-fluid">
        <?php include('./includes/navigation.php') ?>
        <?php
        if ($_SESSION["category"] == "customer") {
            $cid = $_SESSION["uid"];
            $read_user_orders = "SELECT * FROM user_orders WHERE cid = '$cid' ";
            $response = mysqli_query($conn, $read_user_orders) or die(mysqli_error($conn));
            $user_orders = mysqli_fetch_all($response, MYSQLI_ASSOC);

            if (sizeof($user_orders) > 0) {
                echo "
                    <div class='section-heading text-center'>
                        <h2>My Orders</h2>
                        <h6>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nihil, itaque.</h6>
                    </div>
                    <div class='order custom-shadow p-3'>
                ";

                for ($i = 0; $i < sizeof($user_orders); $i++) {
                    $pid = $user_orders[$i]["pid"];
                    $sid = $user_orders[$i]["sid"];
                    $color = ucwords($user_orders[$i]["selected_color"]);
                    $quantity = $user_orders[$i]["quantity"];
                    $delivery_by = $user_orders[$i]["delivery_by"];
                    $status = $user_orders[$i]["status"];

                    $read_product_with_pid = "SELECT `name`,price FROM products WHERE pid = '$pid' and `sid` = '$sid' ";
                    $response = mysqli_query($conn, $read_product_with_pid) or die(mysqli_error($conn));
                    $product_arr_name_price = mysqli_fetch_row($response);

                    $name = ucwords($product_arr_name_price[0]);
                    echo "
                        <div class='row'>
                            <div class='col-md-4'>
                                <img src='./assets/vendor/$name.png' alt='' srcset='' width='200px' height='200px'>
                            </div>
                            <div class='col-md-4'>
                                <h5>$name</h5>
                                <h6>₹$product_arr_name_price[1]</h6>
                                <h6>$color</h6>
                                <h6>Set of $quantity</h6>
                    ";
                    if ($status == "not deliverable") {
                        echo "
                            <h6 class='mt-3'>
                                Status : <span class='text-danger'>$status</span>
                            </h6>
                        ";
                    } else {
                        echo "
                            <h6 class='mt-3'>
                                Status : <span class='text-success'>$status</span>
                            </h6>
                            <h6 class='mt-3'>
                                Arrives at : <span class='text-primary'>$delivery_by 9:30 PM</span>
                            </h6>
                        ";
                    }
                    echo "
                            </div>
                            <div class='col-md-4 my-auto'>
                                <a href='#!' class='btn btn-outline-primary w-100 mb-2'>TRACK</a>
                                <a href='./api/remove_order.php?cid=$cid&pid=$pid&sid=$sid' class='btn btn-outline-danger w-100 mt-2'>CANCEL</a>
                            </div>
                        </div>
                        <hr>
                    ";
                }
                echo "</div>";
            } else {
                echo "
                    <div class='text-center'>
                        <h2>It seems you haven't ordered products from quite a while.</h2>
                    </div>
                ";
            }
        } else {
            include('page_not_found.php');
        }
        ?>
    </div>
</body>

</html>