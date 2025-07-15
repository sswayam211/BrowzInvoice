<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    header('location: /Office/Browz%20Invoice/auth-login.php');
    exit();
}

echo 'adding bill to address<br>';
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

    $sql = "SELECT * FROM `bill_to_address` WHERE `BILL_CODE`='$billCode'";
    $result = mysqli_query($conn, $sql);
    if ($result && $result->num_rows > 0) {
        header('location: \Office\Browz Invoice\pages\add-bill-to.php?s=3');
        exit();
    } else {
        // ADDING DATA TO DATABASE
        $sql = "INSERT INTO `bill_to_address` (`BILL_CODE`,`BILL_NAME`,`BILL_EMAIL`,`BILL_PHONE_NO`,`BILL_ADDRESS_1`,`BILL_ADDRESS_2`,`BILL_COUNTRY`,`BILL_STATE`,`BILL_CITY`,`BILL_POSTAL_CODE`,`GSTIN_NO`) 
                                VALUES ('$billCode','$name','$email','$phone','$address1','$address2','$country','$state','$city','$pincode','$gstin')";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            header('location: \Office\Browz Invoice\pages\add-bill-to.php?s=1');
            exit();
        } else {
            header('location: \Office\Browz Invoice\pages\add-bill-to.php?s=0');
            exit();
        }
    }

    $conn->close();
}
