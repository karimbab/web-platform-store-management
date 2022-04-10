<?php
include('./apis/config.php');
session_unset();
session_destroy();
mysqli_close($conn);
header("location: index.php");
