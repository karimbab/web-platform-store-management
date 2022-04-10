<!-- Manage Product -->
<?php
include('./apis/config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | ICT Commercial</title>
    <?php include("./includes/core-styles.html"); ?>
</head>

<body>
    <div class="container-fluid">
        <?php include('./includes/navigation.php') ?>
        <?php
        if ($_SESSION["category"] == "seller") {
            $requested_query = ucwords($_GET['query']);

            echo "
                <div class='card manage custom-shadow p-2'>
                    <div class='text-center'>
                        <h3>$requested_query Product</h3>
                        <h6>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Rerum, eum.</h6>
                    </div>
                    <hr>
            ";

            if ($requested_query == "Manage") {
                echo "
                    <form class='row card-body' action='./apis/shop.php' method='POST'>
                        <div class='col-md-6'>
                            <select name='query' class='form-control' required>
                                <option value='add'>Add new product</option>
                                <option value='update&edit_access=0'>Update existing product</option>
                                <option value='delete'>Delete existing product</option>
                            </select>
                        </div>
                        <div class='col-md-6'>
                            <button type='submit' class='btn btn-outline-primary w-100' name='request'>Request Query</a>
                        </div>
                    </from>
                ";
            } else {
                if ($requested_query == "Add") {
                    include('./seller_add_product.php');
                }
                if ($requested_query == "Delete") {
                    include('./seller_delete_product.php');
                }
                if ($requested_query == "Update") {
                    include('./seller_update_product.php');
                }
            }
            echo "
                </div>
            ";
        } else {
            include('page_not_found.php');
        }
        ?>
    </div>
</body>
<script>
    function request_edit_access() {
        let product_id = document.getElementById('selected_product').value;
        let request_edit_access_btn = document.getElementById('request_edit_access_btn');
        request_edit_access_btn.setAttribute('href', `./shop.php?query=update&edit_access=1&pid=${product_id}`);
    }
</script>

</html>