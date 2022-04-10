<?php include("./apis/config.php") ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | ICT Commercial</title>
    <?php include("./includes/core-styles.html") ?>
</head>

<body>
    <div class="container-fluid">
        <?php include("./includes/navigation.php") ?>
        <?php
        if ($_SESSION["category"] == "admin") {
            echo "
                <div class='admin mt-4 text-center'>
                    <div class='row'>
                        <div class='col-md-6'>
                            <div class='card custom-shadow p-5'>
                                <a href='admin_manage.php?query=users'>
                                    <i class='fas fa-users' style='font-size:100px;'></i>
                                </a>
                                <h2>Sellers</h2>
                                <h6>Lorem ipsum dolor sit amet consectetur adipisicing elit. In nam eligendi odio dolores numquam assumenda quam provident mollitia, aut neque.</h6>
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class='card custom-shadow p-5'>
                                <a href='admin_manage.php?query=queries'>
                                    <i class='fab fa-quora' style='font-size:100px;'></i>
                                </a>
                                <h2>Queries</h2>
                                <h6>Lorem ipsum dolor sit amet consectetur adipisicing elit. In nam eligendi odio dolores numquam assumenda quam provident mollitia, aut neque.</h6>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class='row'>
                        <div class='col-md-6'>
                            <div class='card custom-shadow p-5'>
                                <a href='admin_manage.php?query=categories&sub_query=add'>
                                    <i class='fab fa-cuttlefish' style='font-size:100px;'></i>
                                </a>
                                <h2>Categories</h2>
                                <h6>Lorem ipsum dolor sit amet consectetur adipisicing elit. In nam eligendi odio dolores numquam assumenda quam provident mollitia, aut neque.</h6>
                            </div>
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