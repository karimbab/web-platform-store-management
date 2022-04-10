<?php
include('./apis/config.php');
$category = $_SESSION["category"];
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | ICT Commercial</title>
    <!-- Required styles -->
    <?php include('./includes/core-styles.html') ?>
</head>

<body>
    <div class="container-fluid">
        <?php include('./includes/navigation.php') ?>
        <?php
        if ($category == "customer" || $category == "seller") {
            $uid = $_SESSION['uid'];
            echo "
                <div class='card account custom-shadow p-2'>
                    <h3 class='text-center'>Your Profile</h3> 
                    <hr>
                    <form class='card-body' method='POST' action='./apis/account-daemon.php'>
            ";

            $read_user = "SELECT `name`,email,`address`,phone,gender FROM users WHERE uid ='$uid' ";
            $response = mysqli_query($conn, $read_user) or die(mysqli_error($conn));
            $user_profile = mysqli_fetch_row($response);

            $user_name = ucwords($user_profile[0]);
            $gender_select = "<select class='form-control' name='gender' required>";
            if ($user_profile[4] == "male") {
                $gender_select .= "<option selected>male</option>";
            } else {
                $gender_select .= "<option>male</option>";
            }

            if ($user_profile[4] == "female") {
                $gender_select .= "<option selected>female</option>";
            } else {
                $gender_select .= "<option>female</option>";
            }

            if ($user_profile[4] == "other") {
                $gender_select .= "<option selected>other</option>";
            } else {
                $gender_select .= "<option>other</option>";
            }
            $gender_select .= "</select>";

            echo "
                <div class='form-group'>
                    <label for='name'>Name:</label>
                    <input type='text' class='form-control' name='name' value='$user_name' required>
                </div>
            ";

            echo "
                <div class='form-group'>
                    <label for='email'>Email:</label>
                    <input type='email' class='form-control' name='email' value='$user_profile[1]' required>
                </div>
            ";

            echo "
                <div class='row'>
                    <div class='col'>
                        <div class='form-group'>
                            <label for='category'>Phone:</label> 
                            <input type='tel' class='form-control' name='phone' value='$user_profile[3]'>
                        </div>
                    </div>
                    <div class='col'>
                        <div class='form-group'>
                            <label for='gender'>Gender:</label> 
                            $gender_select
                        </div>
                    </div>
                </div>
            ";

            echo "
                <div class='form-group'>
                    <label for='address'>Address:</label>
                    <input type='text' class='form-control' name='address' value='$user_profile[2]' required>
                </div>
                <label for='password'>New Password:</label>
                <div class='row'>
                    <div class='col'>
                        <input type='password' class='form-control' placeholder='password' name='password1'>
                    </div>
                    <div class='col'>
                        <input type='password' class='form-control' placeholder='confirm password' name='password2'>
                    </div>
                </div>
                <br>
            ";

            echo "
                        <div class='text-center'>
                            <button type='submit' name='update' class='btn btn-outline-primary w-50'>UPDATE</button>
                        </div>
                    </form>
                </div>
            ";
        } else {
            include('page_not_found.php');
        }
        ?>
    </div>
</body>

</html>