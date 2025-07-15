<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    header('location: /Office/Browz%20Invoice/auth-login.php');
    exit();
}

echo 'updateing gst<br>';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include 'db-conn.php';

    $gstCode = $_POST['gst-code'];
    $category = $_POST['category'];
    $sgst = $_POST['sgst'];
    $cgst = $_POST['cgst'];
    $igst = $_POST['igst'];

    // ADDING DATA TO DATABASE
    $sql = "UPDATE `gst` SET `GST_CATEGORY`='$category',
                                `SGST`='$sgst',
                                `CGST`='$cgst',
                                `IGST`='$igst'
                                WHERE `GST_CODE`='$gstCode'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header('location: \Office\Browz Invoice\pages\gst-page.php?u=1&update=' . $gstCode);
        exit();
    } else {
        header('location: \Office\Browz Invoice\pages\update-gst.php?u=0&update=' . $gstCode);
        exit();
    }
}
