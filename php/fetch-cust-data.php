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

$sql = "SELECT * FROM `customer` WHERE `CUST_CODE`='$query'";
$result = mysqli_query($conn, $sql);

if ($result && $result->num_rows > 0) {
    $custData = $result->fetch_assoc();


    $billCode = $custData['CUST_BILLING_ADD'];
    $shipCode = $custData['CUST_SHIPPING_ADD'];

    // fetching bill and ship address data 
    $billAddSQL = "SELECT * FROM `bill_to_address` WHERE `BILL_CODE`='$billCode'";
    $shipAddSQL = "SELECT * FROM `ship_to_address` WHERE `SHIP_CODE`='$shipCode'";
    $billResult = mysqli_query($conn, $billAddSQL);
    $shipResult = mysqli_query($conn, $shipAddSQL);

    if ($billResult && $shipResult && $billResult->num_rows > 0 && $shipResult->num_rows > 0) {
        $billData = $billResult->fetch_assoc();
        $shipData = $shipResult->fetch_assoc();
    }

    $data = array_merge($custData, $billData, $shipData);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

$conn->close();
