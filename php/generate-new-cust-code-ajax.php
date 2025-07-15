<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    header('location: /Office/Browz%20Invoice/auth-login.php');
    exit();
}

$curYear = date('Y');
// echo $curYear;
$customerCode;
$billCode;
$shipCode;


// AUTO GENERATING CUSTOMER CODE BY FINDING THE LAST CUSTOMER CODE
include 'db-conn.php'; {
    $result = mysqli_query($conn, "SELECT CUST_CODE FROM customer ORDER BY CUST_CODE DESC LIMIT 1");
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Extracting number and increment
        $lastCode = $row['CUST_CODE'];
        $number = (int)substr($lastCode, -4); // Geting numeric part after 'CUST'
        $newNumber = $number + 1;
    } else {
        // No customers yet
        $newNumber = 1;
    }

    // new custonmer code 
    $customerCode = 'C' . (string)$curYear . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    // echo $customerCode;
} {

    // new bill code
    $result = mysqli_query($conn, "SELECT BILL_CODE FROM bill_to_address ORDER BY BILL_CODE DESC LIMIT 1");
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Extracting number and increment
        $lastCode = $row['BILL_CODE'];
        // echo $lastCode;
        $number = (int)substr($lastCode, -4); // Geting numeric part after 'CUST'
        $newNumber = $number + 1;
    } else {
        // No bills yet
        $newNumber = 1;
    }

    // echo $newNumber;

    $billCode = 'B' . (string)$curYear . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    // echo $billCode;FF
} {

    // new ship code 

    $result = mysqli_query($conn, "SELECT SHIP_CODE FROM ship_to_address ORDER BY SHIP_CODE DESC LIMIT 1");
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Extracting number and increment
        $lastCode = $row['SHIP_CODE'];
        // echo $lastCode;
        $number = (int)substr($lastCode, -4); // Geting numeric part after 'CUST'
        $newNumber = $number + 1;
    } else {
        // No bills yet
        $newNumber = 1;
    }

    // echo $newNumber;

    $shipCode = 'S' . (string)$curYear . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    // echo $shipCode;

}

$code = array(
    'custCode' => $customerCode,
    'billCode' => $billCode,
    'shipCode' => $shipCode
);

header('Content-Type: application/json');
echo json_encode($code);
// exit;


$conn->close();
