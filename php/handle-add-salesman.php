<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    header('location: /Office/Browz%20Invoice/auth-login.php');
    exit();
}

echo 'adding salesman<br>';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include 'db-conn.php';

    // $salesmanCode = $_POST['sm-code'];
    $curYear = date('Y');
    // echo $curYear;

    // // AUTO GENERATING CUSTOMER CODE BY FINDING THE LAST CUSTOMER CODE
    // include 'db-conn.php';

    $result = mysqli_query($conn, "SELECT SM_CODE FROM salesman ORDER BY SM_CODE DESC LIMIT 1");
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Extracting number and increment
        $lastCode = $row['SM_CODE'];
        // echo $lastCode;
        $number = (int)substr($lastCode, -4); // Geting numeric part after 'CUST'
        $newNumber = $number + 1;
    } else {
        // No customers yet
        $newNumber = 1;
    }

    // echo $newNumber;

    $salesmanCode = 'SM' . (string)$curYear . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    // echo $customerCode;


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

    $sql = "SELECT * FROM `salesman` WHERE `SM_CODE`='$salesmanCode'";
    $result = mysqli_query($conn, $sql);
    if ($result && $result->num_rows > 0) {
        header('location: \Office\Browz Invoice\pages\add-salesman.php?s=3');
        exit();
    } else {
        // ADDING DATA TO DATABASE
        $sql = "INSERT INTO `salesman` (`SM_CODE`,`SM_FULL_NAME`,`SM_EMAIL`,`SM_PHONE_NO`,`SM_COUNTRY`,`SM_STATE`,`SM_CITY`,`SM_POSTAL_CODE`,`SM_ADDRESS_1`,`SM_ADDRESS_2`,`SM_JOINING_DATE`,`SM_STATUS`,`SM_REMARK`) 
                                VALUES ('$salesmanCode','$fullName','$email','$phone','$country','$state','$city','$pincode','$address1','$address2','$joiningDate','$status','$remark')";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            header('location: \Office\Browz Invoice\pages\add-salesman.php?s=1');
            exit();
        } else {
            header('location: \Office\Browz Invoice\pages\add-salesman.php?s=0');
            exit();
        }
    }

    $conn->close();
}
