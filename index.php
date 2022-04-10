<!-- Home Page -->
<?php
include("./apis/config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucwords($_SESSION["category"]) ?> @ B2B Store</title>
    <?php include("./includes/core-styles.html"); ?>
</head>

<body>
    <div class="container-fluid">
        <?php include("./includes/navigation.php"); ?>

        <div class="row p-3">
            <div class="col-md-6 section">
                <h2>Welcome <?php echo ucwords($_SESSION["name"]) ?></h2>
                <p>Stay Home, Shop More</p>
                <h3 class='text-muted'>A fresh approach to shopping.</h3>
                <a class="btn btn-outline-primary mt-4" href="products.php">Let's Shop</a>
            </div>
            <div class="col-md-6">
                <img src="./assets/view/intro.png" class='landing-image'>
            </div>
        </div>

        <div class="our-products section">
            <?php
            $product_categories = 'SELECT * FROM product_categories WHERE active = 1 ORDER BY category_name DESC';
            $response = mysqli_query($conn, $product_categories) or die(mysqli_error($conn));
            $data = mysqli_fetch_all($response, MYSQLI_ASSOC);

            if (mysqli_num_rows($response)) {
                echo "
                    <div class='section-heading text-center'>
                        <h2>Product Categories</h2>
                        <h6>We provide accessibility to these categories of products. Have a look.</h6>
                    </div>
                ";

                $break = 0;
                echo "<div class='row m-4'>";
                for ($i = 0; $i < mysqli_num_rows($response); $i++) {
                    if ($break == 3) {
                        $break = 1;
                        echo "</div> <div class='row m-4'>";
                    } else {
                        $break += 1;
                    }
                    $category_id = $data[$i]['category_id'];
                    $category_name = $data[$i]['category_name'];
                    $category_tagline = $data[$i]['category_tagline'];

                    echo "
                        <div class='col-md-4'>
                            <div class='card custom-shadow'>
                                <a href='apple.com'><img src='./assets/view/$category_id.png' alt='' class='card-img-top' width='100%' height='400px'></a>
                                <div class='card-body'>
                                    <h3>$category_name</h3>
                                    <p>$category_tagline Hope y'd love it.</p>
                                    <a href='#!'><i class='fas fa-chevron-right'></i></a>
                                </div>
                            </div>
                        </div>
                    ";
                }
                echo "
                        </div>
                    </div>
                ";
            } else {
                echo "
                    <div class='section-heading text-center'>
                        <h2>No products are available, we are sorry for that.</h2>
                    </div>
                ";
            }
            ?>
        </div>

        <?php include("./includes/contact.php"); ?>
</body>

</html>