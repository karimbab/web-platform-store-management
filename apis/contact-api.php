<?php
include('config.php');
if (isset($_POST["contact"])) {
    $name = strtolower($_POST["name"]);
    $email = $_POST["email"];
    $message = strtolower($_POST["message"]);
    $insert_user_query = "INSERT INTO queries (`name`,email,query) VALUES ('$name','$email','$message') ";
    $response = mysqli_query($conn, $insert_user_query) or die(mysqli_error($conn));
    echo "We have received your query, our team will reach you soon.";
}
