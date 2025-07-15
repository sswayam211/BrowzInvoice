<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    header('location: /Office/Browz%20Invoice/auth-login.php');
    exit();
}

echo 'updateing bill to address<br>';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include 'db-conn.php';

    $shipCode = $_POST['ship-code'];
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
    $sql = "UPDATE `ship_to_address` SET `SHIP_NAME`='$name',
                                `SHIP_EMAIL`='$email',
                                `SHIP_PHONE_NO`='$phone',
                                `SHIP_ADDRESS_1`='$address1',
                                `SHIP_ADDRESS_2`='$address2',
                                `SHIP_COUNTRY`='$country',
                                `SHIP_STATE`='$state',
                                `SHIP_CITY`='$city',
                                `SHIP_POSTAL_CODE`='$pincode',
                                `GSTIN_NO`='$gstin'
                                WHERE `SHIP_CODE`='$shipCode'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header('location: \Office\Browz Invoice\pages\ship-to-address-page.php?u=1&update=' . $shipCode);
        exit();
    } else {
        header('location: \Office\Browz Invoice\pages\update-ship-to.php?u=0&update=' . $shipCode);
        exit();
    }
}
