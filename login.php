<!-- Login Page -->
<?php include('./apis/config.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In | Mart</title>
    <?php include("./includes/core-styles.html"); ?>
</head>

<body>
    <div class="container-fluid">
        <?php include('./includes/navigation.php') ?>
        <div class="card account custom-shadow p-2 mt-5">
            <h3 class="text-center">Get back to mart</h3>
            <hr>
            <form class="card-body" method="POST" action="./apis/account-daemon.php">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter registered email..." required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" name="password" placeholder="Enter your secret key..." required>
                </div>
                <div class="text-center">
                    <button type="submit" name="login" class="btn btn-outline-primary w-50">LOGIN</button>
                </div>
            </form>
            <div class="card-footer text-center">
                <h6>Not an account? <a href="./signup.php">SignUp</a> </h6>
            </div>
        </div>
    </div>
</body>

</html>