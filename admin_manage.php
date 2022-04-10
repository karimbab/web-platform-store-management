<!-- Manage Website -->
<?php include("./apis/config.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage | ICT Commercial</title>
    <?php include("./includes/core-styles.html"); ?>
</head>

<body>
    <div class="container-fluid">
        <?php include('./includes/navigation.php') ?>
        <?php
        if ($_SESSION["category"] == "admin") {
            $requested_query = $_GET['query'];
            if ($requested_query != "users" && $requested_query != "queries" && $requested_query != "categories" && $requested_query != "performace") {
                include('page_not_found.php');
            } else {
                if ($requested_query == "users") {
                    include('./admin_users.php');
                }
                if ($requested_query == "queries") {
                    include('./admin_queries.php');
                }
                if ($requested_query == "categories") {
                    include('./admin_categories.php');
                }
            }
        } else {
            include('page_not_found.php');
        }
        ?>
    </div>
</body>
<script>
    function request_edit_access() {
        let category_id = document.getElementById('selected_product_category').value;
        let request_edit_access_btn = document.getElementById('request_edit_access_btn');
        request_edit_access_btn.setAttribute('href', `./admin_manage.php?query=categories&sub_query=update&edit_access=1&pcid=${category_id}`);
    }

    function check_seller_performace() {
        let seller_id = document.getElementById('select_seller_id').value;
        let performace_check_btn = document.getElementById('performace_check_btn');
        performace_check_btn.setAttribute('href', `./admin_manage.php?query=performace&validate=1&seller_id=${seller_id}`);
    }
</script>

</html>