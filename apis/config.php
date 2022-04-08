<?php
$conn = mysqli_connect("localhost", "root", "", "b2b_store_db") or die(mysqli_connect_error());
if ($conn) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
        $_SESSION["login"] = false;
        $_SESSION["category"] = "guest";
    }
} else {
    echo "There was some problem connecting to organization database, report here at info@org.com ...";
}
