<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    header('location: /Office/Browz%20Invoice/auth-login.php');
    exit();
}

$deleteCustomer = (isset($_GET['delete']) ? $_GET['delete'] : '');
$billCode;
$shipCode;

include 'db-conn.php';

// fetching customer bill and ship address
$fetchSql = "SELECT CUST_BILLING_ADD,CUST_SHIPPING_ADD FROM `customer` WHERE `CUST_CODE`='$deleteCustomer' LIMIT 1";
$fetchResult = mysqli_query($conn, $fetchSql);
if ($fetchResult && $fetchResult->num_rows > 0) {
    while ($data = $fetchResult->fetch_assoc()) {
        $billCode = $data['CUST_BILLING_ADD'];
        $shipCode = $data['CUST_SHIPPING_ADD'];
    }

    $deleteBillSql = "DELETE FROM `bill_to_address` WHERE `BILL_CODE`='$billCode'";
    $deleteShipSql = "DELETE FROM `ship_to_address` WHERE `SHIP_CODE`='$shipCode'";
    $deleteCustSql = "DELETE FROM `customer` WHERE `CUST_CODE`='$deleteCustomer'";

    $delBillResult = mysqli_query($conn, $deleteBillSql);
    $delShipResult = mysqli_query($conn, $deleteShipSql);
    $delCustResult = mysqli_query($conn, $deleteCustSql);

    if ($delBillResult && $delShipResult && $deleteCustSql) {
        header('location: \Office\Browz Invoice\pages\customer-page.php?d=1');
        exit();
    } else {
        header('location: \Office\Browz Invoice\pages\customer-page.php?d=0');
        exit();
    }
}

$conn->close();
