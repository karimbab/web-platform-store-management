<!-- User Cart -->
<?php
include('./apis/config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart | ICT Commercial</title>
    <?php include "./includes/core-styles.html"; ?>
</head>

<body>
    <div class="container-fluid">
        <?php include('./includes/navigation.php') ?>
        <?php
        if ($_SESSION["category"] == "customer") {
            $cid = $_SESSION["uid"];
            $read_user_cart = "SELECT * FROM user_cart WHERE cid = '$cid' ";
            $response = mysqli_query($conn, $read_user_cart) or die(mysqli_error($conn));
            $user_cart = mysqli_fetch_all($response, MYSQLI_ASSOC);

            if (sizeof($user_cart) > 0) {
                echo "
                    <div class='section-heading text-center'>
                        <h2>My Cart</h2>
                        <h6>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nihil, itaque.</h6>
                    </div>
                    <form action='./api/update-cart.php?query=update' method='POST'>
                        <div class='cart custom-shadow text-center p-3 mb-4'>
                ";

                for ($i = 0; $i < sizeof($user_cart); $i++) {
                    $pid = $user_cart[$i]["pid"];
                    $sid = $user_cart[$i]["sid"];
                    $previous_quantity = $user_cart[$i]["quantity"];
                    $previous_color = $user_cart[$i]["color"];
                    $delivery_by = $user_cart[$i]["delivery_by"];

                    $read_product_with_pid = "SELECT * FROM products WHERE pid = '$pid' and `sid` = '$sid' ";
                    $response = mysqli_query($conn, $read_product_with_pid) or die(mysqli_error($conn));
                    $product_profile = mysqli_fetch_row($response);

                    /**
                     * unemuerate color IDs with color names
                     */
                    $unserialized_colorIDs = unserialize(base64_decode($product_profile[4]));
                    $colors_dropdown = "";
                    for ($j = 0; $j < sizeof($unserialized_colorIDs); $j++) {
                        $search_color = "SELECT * FROM product_color WHERE color_id = '$unserialized_colorIDs[$j]' ";
                        $response = mysqli_query($conn, $search_color) or die(mysqli_error($conn));
                        $item_color = mysqli_fetch_row($response);
                        $color = ucwords($item_color[1]);

                        if (ucwords($previous_color) == $color) {
                            $colors_dropdown .= "<option selected>$color</option>";
                        } else {
                            $colors_dropdown .= "<option>$color</option>";
                        }
                    }

                    $product_name = ucwords($product_profile[1]);
                    echo "
                        <div class='row'>
                            <div class='col-md-4'>
                                <a href='this_product.php?pid=$pid&sid=$sid'><img src='./assets/vendor/$product_name.png' alt='' srcset=''' width='200px' height='200px'></a>
                            </div>
                            <div class='col-md-4'>
                                <h5>$product_name</h5>
                                <h6>₹ $product_profile[3]</h6>
                                <input type='hidden' value='$pid' name='pid[]'>
                                <input type='hidden' value='$sid' name='sid[]'>
                                <select class='form-control' name='color[]'>
                                    $colors_dropdown
                                </select>
                                <div class='mt-3'>
                                    <input type='number' class='form-control' min='1' max='100' value='$previous_quantity' name='quantity[]'>
                                </div>
                    ";

                    if ($product_profile[6] == '1') {
                        echo "
                                <h6 class='mt-3'>Delivery by : <span class='text-success'>$delivery_by 9:30 PM IST</span></h6>
                            </div>  
                            <div class='col-md-4 my-auto'>
                                <a href='./checkout.php?flag=0&incart=1&pid=$pid&sid=$sid&cid=$cid' class='btn btn-outline-primary w-100 mb-2'>BUY NOW</a>
                        ";
                    } else {
                        echo "
                                <h6 class='text-danger mt-3'>Out of Stock</span></h6>
                            </div>  
                            <div class='col-md-4 my-auto'>
                                <a href='#!' class='btn btn-secondary w-100 mb-2 disabled'>BUY NOW</a>
                        ";
                    }
                    echo "

                                <a href='./api/update-cart.php?query=remove&pid=$pid&sid=$sid' class='btn btn-outline-danger w-100 mt-2'>REMOVE</a>
                            </div>
                        </div>
                        <hr>
                    ";
                }

                echo "    
                        </div>
                        <div class='d-flex flex-row text-center m-auto' style='max-width: 1000px;'>
                            <button class='btn btn-info w-50 mr-2' type='submit' name='update'>Update Cart</button>
                            <a href='checkout.php?flag=1&incart=1' class='btn btn-success w-50'>Proceed to Checkout</a>
                        </div>
                    </form>
                ";
            } else {
                echo "
                    <div class='text-center'>
                        <h2>Your cart looks empty.</h2>
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