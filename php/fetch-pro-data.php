<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    header('location: /Office/Browz%20Invoice/auth-login.php');
    exit();
}

$data;

// Get the search query from the GET request
$query = isset($_GET['query']) ? trim($_GET['query']) : '';


// Include the database connection
include 'db-conn.php';

$sql = "SELECT * FROM `product` WHERE `PRO_CODE`='$query'";
$result = mysqli_query($conn, $sql);

if ($result && $result->num_rows > 0) {
    $proData = $result->fetch_assoc();

    $catagory = $proData['PRO_CATEGORY'];
    $gstSql = "SELECT * FROM `gst` WHERE `GST_CATEGORY`='$catagory'";
    $gstResult = mysqli_query($conn, $gstSql);
    if ($gstResult && $gstResult->num_rows > 0) {
        $gstData = $gstResult->fetch_assoc();

        $data = array_merge($proData, $gstData);
    }

    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

$conn->close();
