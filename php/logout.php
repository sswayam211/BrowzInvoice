<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    header('location: /Office/Browz%20Invoice/auth-login.php');
    exit();
}

// session_start();
include 'db-conn.php';

$userID = $_SESSION['userID'];

session_unset();
session_destroy();

$sql = "UPDATE `login_details` SET `REMEMBER`=null WHERE `USER_ID`='$userID'";
$result = mysqli_query($conn, $sql);

if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    header('location: /Office/Browz%20Invoice/auth-login.php');
    exit();
}
