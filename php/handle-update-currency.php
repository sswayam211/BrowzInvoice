<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    header('location: /Office/Browz%20Invoice/auth-login.php');
    exit();
}

echo 'updateing currency<br>';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include 'db-conn.php';

    $prevCurrCode = $_POST['prev-currency-code'];
    $updCurrCode = $_POST['upd-currency-code'];
    $country = $_POST['country'];
    $countryCode = $_POST['country-code'];
    $currencyName = $_POST['currency-name'];
    $currencySymbol = $_POST['currency-symbol'];
    $status = $_POST['status'];


    // ADDING DATA TO DATABASE
    $sql = "UPDATE `currency` SET `COUNTRY_CODE`='$countryCode',
                                `CURRENCY_CODE`='$updCurrCode',
                                `COUNTRY_NAME`='$country',
                                `CURRENCY`='$currencyName',
                                `CURRENCY_SYMBOL`='$currencySymbol',
                                `STATUE`='$status'
                                WHERE `CURRENCY_CODE`='$prevCurrCode'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header('location: \Office\Browz Invoice\pages\currency-page.php?u=1&update=' . $updCurrCode);
        exit();
    } else {
        header('location: \Office\Browz Invoice\pages\update-currency.php?u=0&update=' . $updCurrCode);
        exit();
    }
}
