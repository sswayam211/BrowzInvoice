<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    header('location: /Office/Browz%20Invoice/auth-login.php');
    exit();
}

$deleteproduct = (isset($_GET['delete']) ? $_GET['delete'] : '');

include 'db-conn.php';

$sql = "DELETE FROM `product` WHERE `PRO_CODE`='$deleteproduct'";

$result = mysqli_query($conn, $sql);

if ($result) {
    header('location: \Office\Browz Invoice\pages\product-page.php?d=1');
    exit();
} else {
    header('location: \Office\Browz Invoice\pages\product-page.php?d=0');
    exit();
}

$conn->close();
