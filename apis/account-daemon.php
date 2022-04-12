<?php
include('config.php');

if (isset($_POST["signup"])) {
    $name = strtolower($_POST["name"]);
    $email = $_POST["email"];
    $category = strtolower($_POST["category"]);
    $gender = strtolower($_POST["gender"]);
    $address = strtolower($_POST["address"]);
    $phone = $_POST["phone"];
    $password1 = $_POST["password1"];
    $password2 = $_POST["password2"];


    $select_user = "SELECT * FROM users WHERE email = '$email' ";
    $response = mysqli_query($conn, $select_user) or die(mysqli_error($conn));
    if (mysqli_num_rows($response) >= 1) {
        echo "Email already registered with us., try logging in.";
    } else {
        if ($password1 != $password2) {
            echo "Passwords didn't match.,";
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

    $select_user = "SELECT * FROM users WHERE email = '$email' ";
    $response = mysqli_query($conn, $select_user) or die(mysqli_error($conn));
    if (mysqli_num_rows($response) == 0) {
        echo "Email not registered with us., sign up required.";
    } else {
        $password = md5($password);
        $validate_user = "SELECT * FROM users WHERE email = '$email' and `password` = '$password' ";
        $response = mysqli_query($conn, $validate_user);
        if (mysqli_num_rows($response) == 0) {
            echo "Credentials Invalid..., check your password.";
        } else {
            $user = mysqli_fetch_row($response);
            $_SESSION["uid"] = $user[0];
            $_SESSION["name"] = $user[1];
            $_SESSION["email"] = $user[2];
            $_SESSION["category"] = $user[3];
            $_SESSION["address"] = $user[5];
            $_SESSION["phone"] = $user[6];
            header('Location: ../index.php');
        }
    }
}

if (isset($_POST['update'])) {
    $uid = $_SESSION['uid'];
    $name = strtolower($_POST['name']);
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = strtolower($_POST['gender']);
    $address = strtolower($_POST['address']);
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
        echo "Passwords didn't match., try again...";
    }
}

if (isset($_POST["contact"])) {
    $name = strtolower($_POST["name"]);
    $email = $_POST["email"];
    $message = strtolower($_POST["message"]);
    $insert_user_query = "INSERT INTO queries (`name`,email,query) VALUES ('$name','$email','$message') ";
    $response = mysqli_query($conn, $insert_user_query) or die(mysqli_error($conn));
    echo "We have received your query, our team will reach you soon.";
}
