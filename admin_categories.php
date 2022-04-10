<?php
include('./apis/config.php');
$requested_sub_query = ucfirst($_GET['sub_query']);

echo "
    <div class='card manage custom-shadow p-3'>
        <div class='text-center'>
            <h3>$requested_sub_query Category</h3>
            <h6>We strictly recommed you to read admin guidelines.</h6>
        </div>
        <hr>
        <form action='./api/admin-manage.php' method='POST'>
";

if ($requested_sub_query == "Add") {
    echo "
        <div class='form-group'>
            <label for='name'>Name:</label>
            <input type='text' class='form-control' maxlength='30' name='name' placeholder='category name' required>
        </div>

        <div class='form-group'>
            <label for='name'>Tagline:</label>
            <textarea type='text' name='tagline' class='form-control' id='' maxlength='200' cols='30' rows='3'  placeholder='category tagline' required></textarea>
        </div>
        <div class='d-flex'>
            <button type='submit' class='btn btn-info w-50 mr-2' name='add_category'>Add category</button>
            <a href='../admin-manage.php?query=categories&sub_query=update&edit_access=0' class='btn btn-info w-50 ml-2'>Update category</a>
        </div>
    ";
}

if ($requested_sub_query == "Update") {
    $read_categories = "SELECT * FROM product_categories";
    $response = mysqli_query($conn, $read_categories) or die(mysqli_error($conn));
    $available_categories = mysqli_fetch_all($response, MYSQLI_ASSOC);

    if (sizeof($available_categories) == 0) {
        echo "
            <div class='text-center'>
                <h2>No categories found <a href='../admin-manage.php?query=categories&sub_query=add'>Add a category</a></h2>
            </div>
        ";
    } else {
        $edit_access = $_GET['edit_access'];
        if ($edit_access == 0) {
            echo "
            <div class='row'>
                <div class='col-md-6'>
                    <select class='form-control' id='selected_product_category' required>
            ";

            for ($i = 0; $i < sizeof($available_categories); $i++) {
                $category_id = $available_categories[$i]["category_id"];
                $category_name = $available_categories[$i]["category_name"];
                echo "<option value=$category_id>$category_name</option>";
            }

            echo "
                    </select>
                </div>
                <div class='col-md-6'>
                    <a href='' class='btn btn-danger w-100' id='request_edit_access_btn' onclick='request_edit_access()'>Edit</a>
                </div>
            </div>
            ";
        } else {
            $pcid = $_GET['pcid'];

            $read_category = "SELECT * FROM product_categories WHERE category_id = '$pcid'";
            $response = mysqli_query($conn, $read_category) or die(mysqli_error($conn));
            if (mysqli_num_rows($response)) {
                $category = mysqli_fetch_row($response);
                $category_name = $category[1];
                echo "
                    <div class='form-group'>
                        <label for='name'>Name:</label>
                        <input type='text' class='form-control' maxlength='30' name='name' placeholder='category name' value='$category_name' required>
                    </div>
                    <input type='hidden' name='pcid' value='$category[0]'>
                    <div class='form-group'>
                        <label for='name'>Tagline:</label>
                        <textarea type='text' name='tagline' class='form-control' id='' maxlength='200' cols='30' rows='3' placeholder='category tagline' required>$category[2]</textarea>
                    </div>
                    <div class='text-center'>
                        <button name='update_category' class='btn btn-danger w-50'>Update</button>
                    </div>
                ";
            } else {
                include('page_not_found.php');
            }
        }
    }
}

echo "
        </form>
    </div>
";
