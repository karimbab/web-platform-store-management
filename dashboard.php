<?php
include('./apis/config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | ICT Commercial</title>
    <?php include("./includes/core-styles.html"); ?>
</head>

<body>
    <div class="container-fluid">
        <?php include('./includes/navigation.php'); ?>
        <?php
        if ($_SESSION["category"] == "seller") {
            $sid = $_SESSION['uid'];

            $products = "SELECT * FROM products WHERE `sid` = $sid and stock = '1'";
            $response = mysqli_query($conn, $products) or die(mysqli_error($conn));
            if (mysqli_num_rows($response)) {
                $read_product_categories = 'SELECT * FROM product_categories ';
                $response = mysqli_query($conn, $read_product_categories) or die(mysqli_error($conn));
                $available_categories = mysqli_fetch_all($response, MYSQLI_ASSOC);
                $details = "";
                for ($i = 0; $i < sizeof($available_categories); $i++) {
                    $category_id = $available_categories[$i]["category_id"];
                    $category_name = $available_categories[$i]["category_name"];
                    $products_catID = "SELECT * FROM products WHERE `sid` = $sid and `category_id` = '$category_id' ";
                    $response = mysqli_query($conn, $products_catID) or die(mysqli_error($conn));
                    $products = mysqli_fetch_all($response, MYSQLI_ASSOC);
                    for ($j = 0; $j < sizeof($products); $j++) {
                        $product_name = $products[$j]["name"];
                        $quantity = $products[$j]["quantity"];
                        $details .= "
                            <tr>
                                <td>$product_name</td>
                                <td>$category_name</td>
                                <td>$quantity</td>
                            </tr>
                        ";
                    }
                }
                echo "
                    <div class='section'>
                        <div class='section-heading text-center'>
                            <h2>Product by quantity</h2>
                            <h6>
                                Here is an account of categories of products versus number of products added with stock availability.
                            </h6>
                        </div>
                        <table class='table table-striped'>
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Quantity(in stock)</th>
                                </tr>
                            </thead>
                            <tbody>
                ";


                echo "
                                $details
                            </tbody>
                        </table>
                    </div>
                ";


                $read_pending_orders = "SELECT * FROM user_orders WHERE `sid` = '$sid' ORDER BY `status` ";
                $response = mysqli_query($conn, $read_pending_orders) or die(mysqli_error($conn));
                $active_orders = mysqli_fetch_all($response, MYSQLI_ASSOC);

                if (sizeof($active_orders)) {
                    echo "
                        <div class='section text-center'>
                            <div class='section-heading'>
                                <h2>Your Best Sellings</h2>
                                <h6>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae omnis nisi, sequi inventore dignissimos sunt? Cum reprehenderit eligendi eius blanditiis?</h6>
                            </div>
                    ";

                    echo "
                        <table class='table table-striped'>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Color</th>
                                    <th>Total</th>
                                    <th>Deadline</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                    ";

                    for ($i = 0; $i < sizeof($active_orders); $i++) {
                        $pid = $active_orders[$i]["pid"];
                        $color = ucwords($active_orders[$i]["selected_color"]);
                        $quantity = $active_orders[$i]["quantity"];
                        $delivery_by = $active_orders[$i]["delivery_by"];
                        $order_status = ucwords($active_orders[$i]["status"]);

                        $read_product_with_ID = "SELECT `name`,price FROM products WHERE pid = '$pid' and `sid` = '$sid' ";
                        $response = mysqli_query($conn, $read_product_with_ID) or die(mysqli_error($conn));
                        $product_arr_name_price = mysqli_fetch_row($response);
                        $product_name = $product_arr_name_price[0];
                        $total = $product_arr_name_price[1] * $quantity;

                        echo "
                            <tr>
                                <th>$product_name</th>
                                <th>₹ $product_arr_name_price[1]</th>
                                <th>$quantity</th>
                                <th>$color</th>
                                <th>$total</th>
                                <th>$delivery_by</th>
                                <th>$order_status</th>
                            </tr>
                        ";
                    }

                    echo "
                                </tbody>
                            </table>
                        </div>
                    ";
                }
            } else {
                echo "
                    <h2 class='text-center'>
                        You haven't added any products yet or all of your products are out of stock. <a href='shop.php?requested_query=add'>Add a new product</a> 
                    <h2>
                ";
            }
        } else {
            include('./page_not_found.php');
        }
        ?>
    </div>
</body>

</html>