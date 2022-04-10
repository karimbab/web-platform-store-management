<?php
include('config.php');

if (isset($_POST["signup"])) {
    $name = strtolower($_POST["name"]);
    $email = $_POST["email"];
    $category = strtolower($_POST["category"]);
    $gender = strtolower($_POST["gender"]);
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $password1 = $_POST["password1"];
    $password2 = $_POST["password2"];


    $read_users = "SELECT * FROM users WHERE email = '$email' ";
    $response = mysqli_query($conn, $read_users) or die(mysqli_error($conn));
    if (mysqli_num_rows($response) == 1) {
        echo "Email already registered with us., try logging in.";
    } else {
        if ($password1 != $password2) {
            echo "Passwords didn't match...";
        } else {
            $password = md5($password1);
            $insert_user = "INSERT INTO users (`name`,email,category,gender,`address`,phone,`password`) VALUES ('$name','$email','$category','$gender','$address','$phone','$password') ";
            $response = mysqli_query($conn, $insert_user) or die(mysqli_error($conn));
            header('Location: ../login.php');
        }
    }
}

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $read_user = "SELECT * FROM users WHERE email = '$email' ";
    $response = mysqli_query($conn, $read_user) or die(mysqli_error($conn));
    if (mysqli_num_rows($response) == 0) {
        echo "Email not registered with us., sign up required.";
    } else {
        if ($email == "info.admin@gmail.com") {  /* email for admin is fixed */
            $verify_admin = "SELECT * FROM users WHERE email = '$email' and `password` = '$password'";
            $response = mysqli_query($conn, $verify_admin);
            if (mysqli_num_rows($response)) {
                $_SESSION["category"] = "admin";
                // header('Location: ../admin.php');
            } else {
                echo "Password was incorrect, please reach to database administrator for password recovery.";
            }
        } else {
            $password = md5($password);
            $validate_user_credentials = "SELECT * FROM users WHERE email = '$email' and `password` = '$password' ";
            $response = mysqli_query($conn, $validate_user_credentials);
            if (mysqli_num_rows($response) == 0) {
                echo "Credentials Invalid..., check your password.";
            } else {
                $user_row = mysqli_fetch_row($response);
                $_SESSION["uid"] = $user_row[0];
                $_SESSION["name"] = $user_row[1];
                $_SESSION["email"] = $user_row[2];
                $_SESSION["category"] = $user_row[3];
                $_SESSION["address"] = $user_row[5];
                $_SESSION["phone"] = $user_row[6];
                header('Location: ../index.php');
            }
        }
    }
}

if (isset($_POST['update'])) {
    $uid = $_SESSION['uid'];
    $name = strtolower($_POST['name']);
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    if ($password1 == $password2) {
        if ($password1 != "") {
            $password = md5($password1);
            $update = "UPDATE users SET `name` = '$name',email = '$email',gender = '$gender',`password` = '$password',`address` = '$address',`phone` = '$phone' WHERE `uid` = '$uid' ";
        } else {
            $update = "UPDATE users SET `name` = '$name',email = '$email',gender = '$gender',`address` = '$address',`phone` = '$phone' WHERE `uid` = '$uid' ";
        }
        $response = mysqli_query($conn, $update) or die(mysqli_error($conn));
        echo "
            <script type='text/javascript'>
                window.location = '../logout.php';
            </script>
        ";
    } else {
        echo "Passwords didn't match.";
    }
}
