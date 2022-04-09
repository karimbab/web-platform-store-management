<!-- Products page -->
<?php
include('./apis/config.php');
$category = $_SESSION['category'];
function createCard($pid, $sid, $name, $descr)
{
    echo "
        <div class='col-md-4'>
            <div class='card custom-shadow'>
                <a href='this_product.php?pid=$pid&sid=$sid'><img src='./assets/$name.png' class='card-img-top' width='100%' height='300px'></a>
                <div class='card-body'>
                    <h5>$name</h5>
                    <p class='text-muted'>$descr</p>
                    <a href='this_product.php?pid=$pid&sid=$sid' class='btn btn-outline-info w-100'>View</a>
                </div>
            </div>
        </div>
    ";
}

$get_products = "SELECT * FROM products";
$response = mysqli_query($conn, $get_products) or die(mysqli_error($conn));
$num_products = mysqli_num_rows($response);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products | ICT Commercial</title>
    <?php include "./includes/core-styles.html"; ?>
</head>

<body>
    <div class="container-fluid">
        <?php include('./includes/navigation.php'); ?>

        <?php
        if ($category == "customer" || $category == "guest") {
            if ($num_products > 0) {
                $get_product_categories = 'SELECT * FROM product_categories WHERE active = 1';
                $response_product_categories = mysqli_query($conn, $get_product_categories) or die(mysqli_error($conn));
                $product_categories = mysqli_fetch_all($response_product_categories, MYSQLI_ASSOC);

                for ($i = 0; $i < sizeof($product_categories); $i++) {
                    $category_id = $product_categories[$i]['category_id'];
                    $category_name = ucwords($product_categories[$i]['category_name']);
                    $category_tag = ucfirst($product_categories[$i]['category_tagline']);

                    $search_products_with_categoryID = "SELECT * FROM products WHERE `category_id` = '$category_id' ";
                    $res = mysqli_query($conn, $search_products_with_categoryID) or die(mysqli_error($conn));
                    $products_with_categoryID = mysqli_fetch_all($res, MYSQLI_ASSOC);

                    if (sizeof($products_with_categoryID) > 0) {
                        echo "
                            <div class='section'>
                                <div class='section-heading text-center'>
                                    <h2>$category_name</h2>
                                    <h6>$category_tag</h6>
                                </div>
                        ";

                        $break = 0;
                        echo "<div class='row m-4'>";
                        for ($j = 0; $j < sizeof($products_with_categoryID); $j++) {
                            if ($break == 3) {
                                $break = 1;
                                echo "</div> <div class='row m-4'>";
                            } else {
                                $break++;
                            }
                            echo createCard($products_with_categoryID[$j]["pid"], $products_with_categoryID[$j]["sid"], ucwords($products_with_categoryID[$j]["name"]), $products_with_categoryID[$j]["descr"]);
                        }
                        echo '</div></div>';
                    }
                }
            } else {
                echo "
                    <div class='text-center'>
                        <h2>We don't have any products registered yet, <a href='signup.php'>Add Product</a></h2>
                    </div>
                ";
            }
        } else {
            include('./page_not_found.php');
        }
        ?>
    </div>
</body>

</html>