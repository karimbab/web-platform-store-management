<!-- Trending Page -->
<?php
include('./apis/config.php');
/* function to create carousel item */
function createCarouselItem($i, $pid, $sid, $name)
{
    if ($i == 0) {
        echo "
            <div class='carousel-item active'>
                <a href='this_product.php?pid=$pid&sid=$sid'><img src='./assets/vendor/$name.png' class='card-img-top' width='600px' height='500px'></a>
            </div>
        ";
    } else {
        echo "
            <div class='carousel-item'>
                <a href='this_product.php?pid=$pid&sid=$sid'><img src='./assets/vendor/$name.png' class='card-img-top' width='600px' height='400px'></a>
            </div>
        ";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trending Month | ICT Commercial</title>
    <?php include "./includes/core-styles.html"; ?>
</head>

<body>
    <div class="container-fluid">
        <?php include('./includes/navigation.php'); ?>
        <?php
        if ($_SESSION["category"] == 'customer' || $_SESSION["category"] == 'guest') {
            $read_trending_products = "SELECT * FROM products WHERE trending = '1' and stock = '1'";
            $response = mysqli_query($conn, $read_trending_products) or die(mysqli_error($conn));
            $trending_products = mysqli_fetch_all($response, MYSQLI_ASSOC);

            if (mysqli_num_rows($response)) {
                echo "
                    <div class='p-4'>
                        <div class='section-heading text-center'>
                            <h2>Month's Trending</h2>
                            <h6>We shortlist some of the best selling of the month so you get the best available with us.</h6>
                        </div>
                ";

                echo "
                    <div id='myCarousel' class='carousel slide justify-content-center m-auto' data-ride='carousel' style='max-width:1000px;'>
                        <ul class='carousel-indicators'>
                            <li data-target='#myCarousel' data-slide-to='0' class='active'></li>
                            <li data-target='#myCarousel' data-slide-to='1'></li>
                            <li data-target='#myCarousel' data-slide-to='2'></li>
                        </ul>
                        <div class='carousel-inner'>
                ";
                for ($i = 0; $i < sizeof($trending_products); $i++) {
                    echo createCarouselItem($i, $trending_products[$i]['pid'], $trending_products[$i]['sid'], $trending_products[$i]['name']);
                }
                echo "
                        </div>
                        <a class='carousel-control-prev' href='#myCarousel' data-slide='prev'>
                            <i class='fas fa-chevron-left'></i>
                        </a>
                        <a class='carousel-control-next' href='#myCarousel' data-slide='next'>
                            <i class='fas fa-chevron-right'></i>
                        </a>
                    </div>
                ";
            } else {
                echo "
                    <div class='text-center'>
                        <h2>We are sorry as we don't have any featured products this month.</h2>
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