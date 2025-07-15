<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    header('location: /Office/Browz%20Invoice/auth-login.php');
    exit();
}

echo 'updateing customer<br>';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include 'db-conn.php';

    $customerCode = $_POST['cust-code'];
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
    $billCode = $_POST['bill-code'];
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
    $shipCode = $_POST['ship-code'];
    $fullName3 = $_POST['ship-name'];
    $email3 = $_POST['ship-email'];
    $phone3 = $_POST['ship-phone'];
    $country3 = $_POST['ship-country'];
    $state3 = $_POST['ship-state'];
    $city3 = $_POST['ship-city'];
    $pincode3 = $_POST['ship-pincode'];
    $address13 = $_POST['ship-address1'];
    $address23 = (!empty($_POST['ship-address2']) ? $_POST['ship-address2'] : '');





    // updating billing address
    $updateBillSql = "UPDATE `bill_to_address` SET `BILL_NAME`='$fullName2',
                                `BILL_EMAIL`='$email2',
                                `BILL_PHONE_NO`='$phone2',
                                `BILL_ADDRESS_1`='$address12',
                                `BILL_ADDRESS_2`='$address22',
                                `BILL_COUNTRY`='$country2',
                                `BILL_STATE`='$state2',
                                `BILL_CITY`='$city2',
                                `BILL_POSTAL_CODE`='$pincode2',
                                `GSTIN_NO`='$gstin'
                                WHERE `BILL_CODE`='$billCode'";

    $updateBillResult = mysqli_query($conn, $updateBillSql);


    // updating shipping address
    // ADDING DATA TO DATABASE
    $updateShipSql = "UPDATE `ship_to_address` SET `SHIP_NAME`='$fullName3',
                                `SHIP_EMAIL`='$email3',
                                `SHIP_PHONE_NO`='$phone3',
                                `SHIP_ADDRESS_1`='$address13',
                                `SHIP_ADDRESS_2`='$address23',
                                `SHIP_COUNTRY`='$country3',
                                `SHIP_STATE`='$state3',
                                `SHIP_CITY`='$city3',
                                `SHIP_POSTAL_CODE`='$pincode3',
                                `GSTIN_NO`='$gstin'
                                WHERE `SHIP_CODE`='$shipCode'";

    $updateShipResult = mysqli_query($conn, $updateShipSql);


    // updating customer DATA in DATABASE
    $updateCustSql = "UPDATE `customer` SET `CUST_FULL_NAME`='$fullName',
                                `CUST_EMAIL`='$email',
                                `CUST_PHONE_NO`='$phone',
                                `CUST_ADDRESS_1`='$address1',
                                `CUST_ADDRESS_2`='$address2',
                                `CUST_COUNTRY`='$country',
                                `CUST_STATE`='$state',
                                `CUST_CITY`='$city',
                                `CUST_POSTAL_CODE`='$pincode',
                                `CUST_GSTIN`='$gstin'
                                WHERE `CUST_CODE`='$customerCode'";

    $updateCustResult = mysqli_query($conn, $updateCustSql);

    if ($updateBillResult && $updateShipResult && $updateCustResult) {
        header('location: \Office\Browz Invoice\pages\customer-page.php?u=1&update=' . $customerCode);
        exit();
    } else {
        header('location: \Office\Browz Invoice\pages\update-customer.php?u=0&update=' . $customerCode);
        exit();
    }
}
