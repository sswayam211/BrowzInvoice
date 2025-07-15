<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    header('location: /Office/Browz%20Invoice/auth-login.php');
    exit();
}

echo 'updateing salesman<br>';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include 'db-conn.php';

    $salesmanCode = $_POST['sm-code'];
    $fname = $_POST['fname'];
    $mname = (!empty($_POST['mname']) ? $_POST['mname'] : '');
    $lname = $_POST['lname'];
    $fullName = (!empty($_POST['mname']) ? $fname . ' ' . $mname . ' ' . $lname : $fname . ' ' . $lname);
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $pincode = $_POST['pincode'];
    $address1 = $_POST['address1'];
    $address2 = (!empty($_POST['address2']) ? $_POST['address2'] : '');
    $joiningDate = $_POST['joiningDate'];
    $status = $_POST['status'];
    $remark = $_POST['remark'];


    // ADDING DATA TO DATABASE
    $sql = "UPDATE `salesman` SET `SM_FULL_NAME`='$fullName',
                                `SM_EMAIL`='$email',
                                `SM_PHONE_NO`='$phone',
                                `SM_COUNTRY`='$country',
                                `SM_STATE`='$state',
                                `SM_CITY`='$city',
                                `SM_POSTAL_CODE`='$pincode',
                                `SM_ADDRESS_1`='$address1',
                                `SM_ADDRESS_2`='$address2',
                                `SM_JOINING_DATE`='$joiningDate',
                                `SM_STATUS`='$status',
                                `SM_REMARK`='$remark'
                                WHERE `SM_CODE`='$salesmanCode'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header('location: \Office\Browz Invoice\pages\salesman-page.php?u=1&update=' . $salesmanCode);
        exit();
    } else {
        header('location: \Office\Browz Invoice\pages\update-salesman.php?u=0&update=' . $salesmanCode);
        exit();
    }
}
