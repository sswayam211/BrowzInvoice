<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    header('location: /Office/Browz%20Invoice/auth-login.php');
    exit();
}

echo 'updateing bill to address<br>';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include 'db-conn.php';

    $billCode = $_POST['bill-code'];
    $name = $_POST['name'];
    $gstin = $_POST['gstin'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $pincode = $_POST['pincode'];
    $address1 = $_POST['address1'];
    $address2 = (!empty($_POST['address2']) ? $_POST['address2'] : '');


    // ADDING DATA TO DATABASE
    $sql = "UPDATE `bill_to_address` SET `BILL_NAME`='$name',
                                `BILL_EMAIL`='$email',
                                `BILL_PHONE_NO`='$phone',
                                `BILL_ADDRESS_1`='$address1',
                                `BILL_ADDRESS_2`='$address2',
                                `BILL_COUNTRY`='$country',
                                `BILL_STATE`='$state',
                                `BILL_CITY`='$city',
                                `BILL_POSTAL_CODE`='$pincode',
                                `GSTIN_NO`='$gstin'
                                WHERE `BILL_CODE`='$billCode'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header('location: \Office\Browz Invoice\pages\bill-to-address-page.php?u=1&update=' . $billCode);
        exit();
    } else {
        header('location: \Office\Browz Invoice\pages\update-bill-to.php?u=0&update=' . $billCode);
        exit();
    }
}
