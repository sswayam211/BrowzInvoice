<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    header('location: /Office/Browz%20Invoice/auth-login.php');
    exit();
}

echo 'adding product<br>';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include 'db-conn.php';

    $currCode = $_POST['currency-code'];
    $country = $_POST['country'];
    $countryCode = $_POST['country-code'];
    $currencyName = $_POST['currency-name'];
    $currencySymbol = $_POST['currency-symbol'];
    $status = $_POST['status'];


    $sql = "SELECT * FROM `currency` WHERE `CURRENCY_CODE`='$currCode'";
    $result = mysqli_query($conn, $sql);
    if ($result && $result->num_rows > 0) {
        header('location: \Office\Browz Invoice\pages\add-currency.php?s=3');
        exit();
    } else {
        // ADDING DATA TO DATABASE
        $sql = "INSERT INTO `currency` (`COUNTRY_CODE`,`COUNTRY_NAME`,`CURRENCY_CODE`,`CURRENCY`,`CURRENCY_SYMBOL`,`STATUE`) 
                                VALUES ('$countryCode','$country','$currCode','$currencyName','$currencySymbol','$status')";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            header('location: \Office\Browz Invoice\pages\add-currency.php?s=1');
            exit();
        } else {
            header('location: \Office\Browz Invoice\pages\add-currency.php?s=0');
            exit();
        }
    }

    $conn->close();
}
