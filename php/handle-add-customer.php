<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    header('location: /Office/Browz%20Invoice/auth-login.php');
    exit();
}

echo 'adding customer<br>';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include 'db-conn.php';

    // customer details to save in customer table 
    $curYear = date('Y');
    // echo $curYear;

    // // AUTO GENERATING CUSTOMER CODE BY FINDING THE LAST CUSTOMER CODE
    // include 'db-conn.php';

    $result = mysqli_query($conn, "SELECT CUST_CODE FROM customer ORDER BY CUST_CODE DESC LIMIT 1");
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Extracting number and increment
        $lastCode = $row['CUST_CODE'];
        // echo $lastCode;
        $number = (int)substr($lastCode, -4); // Geting numeric part after 'CUST'
        $newNumber = $number + 1;
    } else {
        // No customers yet
        $newNumber = 1;
    }

    // echo $newNumber;

    $customerCode = 'C' . (string)$curYear . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    // echo $customerCode;


    $fname = $_POST['fname'];
    $mname = (!empty($_POST['mname']) ? $_POST['mname'] : '');
    $lname = $_POST['lname'];
    $fullName = (!empty($_POST['mname']) ? $fname . ' ' . $mname . ' ' . $lname : $fname . ' ' . $lname);
    $gstin = $_POST['gstin'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $pincode = $_POST['pincode'];
    $address1 = $_POST['address1'];
    $address2 = (!empty($_POST['address2']) ? $_POST['address2'] : '');

    // billing address details 
    // $billCode = $_POST['bill-code'];

    $curYear = date('Y');
    // echo $curYear;

    // AUTO GENERATING bill CODE BY FINDING THE LAST bill CODE
    // include 'db-conn.php';

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
    // echo $billCode;


    $fullName2 = $_POST['bill-name'];
    $email2 = $_POST['bill-email'];
    $phone2 = $_POST['bill-phone'];
    $country2 = $_POST['bill-country'];
    $state2 = $_POST['bill-state'];
    $city2 = $_POST['bill-city'];
    $pincode2 = $_POST['bill-pincode'];
    $address12 = $_POST['bill-address1'];
    $address22 = (!empty($_POST['bill-address2']) ? $_POST['bill-address2'] : '');

    // shipping address details 
    // $shipCode = $_POST['ship-code'];
    $curYear = date('Y');
    // echo $curYear;

    // // AUTO GENERATING bill CODE BY FINDING THE LAST bill CODE
    // include 'db-conn.php';

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

    $fullName3 = $_POST['ship-name'];
    $email3 = $_POST['ship-email'];
    $phone3 = $_POST['ship-phone'];
    $country3 = $_POST['ship-country'];
    $state3 = $_POST['ship-state'];
    $city3 = $_POST['ship-city'];
    $pincode3 = $_POST['ship-pincode'];
    $address13 = $_POST['ship-address1'];
    $address23 = (!empty($_POST['ship-address2']) ? $_POST['ship-address2'] : '');


    // checking if the codes already exist
    $checkCustSql = "SELECT CUST_FULL_NAME FROM `customer` WHERE `CUST_CODE`='$customerCode'";
    $checkBillSql = "SELECT BILL_NAME FROM `bill_to_address` WHERE `BILL_CODE`='$billCode'";
    $checkShipSql = "SELECT SHIP_NAME FROM `ship_to_address` WHERE `SHIP_CODE`='$shipCode'";

    $custResult = mysqli_query($conn, $checkCustSql);
    $billResult = mysqli_query($conn, $checkBillSql);
    $shipResult = mysqli_query($conn, $checkShipSql);

    if ($custResult && $billResult && $shipResult && $custResult->num_rows > 0 && $billResult->num_rows > 0 && $shipResult->num_rows > 0) {
        header('location: \Office\Browz Invoice\pages\add-customer.php?s=3');
        exit();
    } else {
        $addCustSql = "INSERT INTO `customer` (`CUST_CODE`,`CUST_FULL_NAME`,`CUST_EMAIL`,`CUST_PHONE_NO`,`CUST_ADDRESS_1`,`CUST_ADDRESS_2`,`CUST_COUNTRY`,`CUST_STATE`,`CUST_CITY`,`CUST_POSTAL_CODE`,`CUST_GSTIN`,`CUST_BILLING_ADD`,`CUST_SHIPPING_ADD`) 
                                        VALUES ('$customerCode','$fullName','$email','$phone','$address1','$address2','$country','$state','$city','$pincode','$gstin','$billCode','$shipCode')";

        $addBillSql = "INSERT INTO `bill_to_address` (`BILL_CODE`,`BILL_NAME`,`BILL_EMAIL`,`BILL_PHONE_NO`,`BILL_ADDRESS_1`,`BILL_ADDRESS_2`,`BILL_COUNTRY`,`BILL_STATE`,`BILL_CITY`,`BILL_POSTAL_CODE`,`GSTIN_NO`) 
                                VALUES ('$billCode','$fullName2','$email2','$phone2','$address12','$address22','$country2','$state2','$city2','$pincode2','$gstin')";

        $addShipSql = "INSERT INTO `ship_to_address` (`SHIP_CODE`,`SHIP_NAME`,`SHIP_EMAIL`,`SHIP_PHONE_NO`,`SHIP_ADDRESS_1`,`SHIP_ADDRESS_2`,`SHIP_COUNTRY`,`SHIP_STATE`,`SHIP_CITY`,`SHIP_POSTAL_CODE`,`GSTIN_NO`) 
                                VALUES ('$shipCode','$fullName3','$email3','$phone3','$address13','$address23','$country3','$state3','$city3','$pincode3','$gstin')";

        $addCustResult = mysqli_query($conn, $addCustSql);
        $addBillResult = mysqli_query($conn, $addBillSql);
        $addShipResult = mysqli_query($conn, $addShipSql);

        if ($addCustResult && $addBillResult && $addShipResult) {
            header('location: \Office\Browz Invoice\pages\add-customer.php?s=1');
            exit();
        } else {
            header('location: \Office\Browz Invoice\pages\add-customer.php?s=0');
            exit();
        }
    }

    $conn->close();
}
