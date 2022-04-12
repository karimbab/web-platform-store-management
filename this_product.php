<!-- Interface of particular product -->
<?php
/**
 * fetch the details of seller for this particular product.
 */
include('./apis/config.php');
$sid = $_GET['sid'];
$search_seller = "SELECT * FROM users WHERE `uid` = '$sid' ";
$response = mysqli_query($conn, $search_seller) or die(mysqli_error($conn));
$seller_name = ucwords(mysqli_fetch_row($response)[1]);
?>

<?php
/**
 * fetch details of the product.
 */
$pid = $_GET['pid'];
$read_product = "SELECT * FROM products WHERE pid = '$pid' and `sid` = '$sid' ";
$response = mysqli_query($conn, $read_product) or die(mysqli_error($conn));
$product_profile = mysqli_fetch_row($response);
?>

<?php
/**
 * check whether the product is added to cart or not.
 */
$category = $_SESSION['category'];
if ($category == 'customer') {
    $cid = $_SESSION["uid"];
    $search_product_incart = "SELECT * FROM user_cart WHERE cid = '$cid' and pid = '$pid' and `sid` = '$sid' ";
    $response = mysqli_query($conn, $search_product_incart) or die(mysqli_error($conn));
    $incart = mysqli_num_rows($response);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucwords($product[1]) ?> | ICT Commercial</title>
    <?php include "./includes/core-styles.html"; ?>
</head>

<body>
    <div class="container-fluid">
        <?php include('./includes/navigation.php') ?>
        <?php
        if ($category == "customer" || $category == "guest") {
            $name = ucwords($product_profile[1]);
            $descr = ucfirst($product_profile[5]);
            $price = $product_profile[3];
            echo "
                <div class='this-product custom-shadow p-3'>
                    <div class='row p-3'>
                        <div class='col-md-6'>
                            <img src='./assets/$name.png' alt='' class='img-responsive' width='100%' height='400px'>
                        </div>
                        <div class='col-md-6'>
                            <h3>$name</h3>
                            <p class='text-muted'>$descr</p>
                            <p>Owner : $seller_name </p>
                            <p class='mt-3'> Best Price : <span class='text-primary'> ₹ $price </span> </p>
            ";

            if ($category == 'customer') {
                if ($product_profile[6] == '1') {
                    echo "
                        <p class='text-success'>In Stock</p>
                        <a href='./checkout.php?flag=0&incart=$incart&pid=$pid&sid=$sid&cid=$cid' class='btn btn-outline-primary 
                        w-100 mb-2'>BUY NOW</a> 
                    ";
                } else {
                    echo "
                        <p class='text-danger'>Out of Stock</p>
                        <a href='#!' class='btn btn-secondary w-100 disabled mb-2'>BUY NOW</a>
                    ";
                }

                if ($incart == 0) {
                    echo "
                        <div class='text-center d-flex flex-row mt-2'>
                            <a href='./apis/update-cart.php?query=add&pid=$pid&sid=$sid' class='btn btn-info mr-2 w-50'>ADD</a> 
                            <a href='./apis/update-cart.php?query=remove&pid=$pid&sid=$sid' class='btn btn-secondary w-50 disabled'>REMOVE</a>
                        </div>
                    ";
                } else {
                    echo "
                        <div class='d-flex flex-row mt-2'>  
                            <a href='cart.php' class='btn btn-info mr-2 w-50'>GO TO CART</a> 
                            <a href='./apis/update-cart.php?query=remove&pid=$pid&sid=$sid' class='btn btn-secondary w-50'>REMOVE</a>
                        </div>
                    ";
                }
            }

            if ($category == "guest") {
                echo "
                    <a href='signup.php' class='btn btn-outline-primary w-100 mb-2'>BUY NOW</a>
                        <div class='text-center d-flex flex-row mt-2'>
                            <a href='signup.php' class='btn btn-info mr-2 w-50'>ADD</a> 
                            <a href='signup.php' class='btn btn-secondary w-50 disabled'>REMOVE</a>
                        </div>
                ";
            }

            echo "
                        </div>
                    </div>
                </div>
            ";
        } else {
            include('./page_not_found.php');
        }
        ?>
    </div>
</body>

</html>