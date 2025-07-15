<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    header('location: /Office/Browz%20Invoice/auth-login.php');
    exit();
}

echo 'adding gst<br>';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include 'db-conn.php';

    // $gstCode = $_POST['gst-code'];

    $curYear = date('Y');
    // echo $curYear;

    // // AUTO GENERATING gst CODE BY FINDING THE LAST gst CODE
    // include 'db-conn.php';

    $result = mysqli_query($conn, "SELECT GST_CODE FROM gst ORDER BY GST_CODE DESC LIMIT 1");
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Extracting number and increment
        $lastCode = $row['GST_CODE'];
        // echo $lastCode;
        $number = (int)substr($lastCode, -4); // Geting numeric part after 'CUST'
        $newNumber = $number + 1;
    } else {
        // No gsts yet
        $newNumber = 1;
    }

    // echo $newNumber;

    $gstCode = 'G' . (string)$curYear . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    // echo $gstCode;

    $category = $_POST['category'];
    $sgst = $_POST['sgst'];
    $cgst = $_POST['cgst'];
    $igst = $_POST['igst'];


    $sql = "SELECT * FROM `gst` WHERE `GST_CODE`='$gstCode'";
    $result = mysqli_query($conn, $sql);
    if ($result && $result->num_rows > 0) {
        header('location: \Office\Browz Invoice\pages\add-gst.php?s=3');
        exit();
    } else {
        // ADDING DATA TO DATABASE
        $sql = "INSERT INTO `gst` (`GST_CODE`,`GST_CATEGORY`,`SGST`,`CGST`,`IGST`) 
                                VALUES ('$gstCode','$category','$sgst','$cgst','$igst')";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            header('location: \Office\Browz Invoice\pages\add-gst.php?s=1');
            exit();
        } else {
            header('location: \Office\Browz Invoice\pages\add-gst.php?s=0');
            exit();
        }
    }

    $conn->close();
}
