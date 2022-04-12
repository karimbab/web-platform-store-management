<?php
include('./apis/config.php');
$read_sellers = "SELECT * FROM users WHERE category = 'seller' AND active = '1'";
$response = mysqli_query($conn, $read_sellers) or die(mysqli_error($conn));
if (mysqli_num_rows($response)) {
    $seller_rows = mysqli_fetch_all($response, MYSQLI_ASSOC);
    echo "
        <div class='card manage custom-shadow p-2'>
            <div class='text-center'>
                <h3>Manage Sellers</h3>
                <h6>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Numquam, beatae.</h6>
            </div>
            <hr>
            <form class='row card-body' action='./apis/admin-manage.php' method='POST'>
                <div class='col-md-6'>
                    <select name='seller_id' class='form-control' required>
    ";
    for ($i = 0; $i < sizeof($seller_rows); $i++) {
        $seller_email = $seller_rows[$i]["email"];
        $seller_id = $seller_rows[$i]["uid"];
        echo "<option value=$seller_id>$seller_email</option>";
    }
    echo "
                    </select>
                </div>
                <div class='col-md-6'>
                    <button type='submit' class='btn btn-outline-danger w-100' name='delete'>Suspend account</a>
                </div>
            </form>
        </div>
    ";
} else {
    echo "
        <div class='text-center'>
            <h2>No sellers registered yet.</h2>
        </div>
    ";
}
