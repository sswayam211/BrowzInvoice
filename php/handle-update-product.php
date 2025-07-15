<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    header('location: /Office/Browz%20Invoice/auth-login.php');
    exit();
}

echo 'updateing product<br>';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include 'db-conn.php';

    $productCode = $_POST['pro-code'];
    $name = $_POST['name'];
    $hsnno = $_POST['hsnno'];
    $price = $_POST['price'];
    $maxDiscount = $_POST['max-discount'];
    $category = $_POST['category'];
    $uom = $_POST['uom'];
    $desc = $_POST['desc'];


    // Check if a new image is uploaded
    if (isset($_FILES['image']['tmp_name']) && !empty($_FILES['image']['tmp_name'])) {
        // New image uploaded
        $image = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];
        $imageType = $_FILES['image']['type'];
        $imageData = base64_encode(file_get_contents($image));

        $imageDetailsArray = array(
            'imageName' => $imageName,
            'imageType' => $imageType,
            'imageData' => $imageData
        );

        $imageDetails = json_encode($imageDetailsArray);
    } else {
        // No new image uploaded, retain the existing image details
        $sqlGetImage = "SELECT PRO_IMAGE FROM `product` WHERE `PRO_CODE` = '$productCode'";
        $resultGetImage = mysqli_query($conn, $sqlGetImage);
        if ($resultGetImage && mysqli_num_rows($resultGetImage) > 0) {
            $row = mysqli_fetch_assoc($resultGetImage);
            $imageDetails = $row['PRO_IMAGE'];
        } else {
            $error = "Failed to retrieve existing image details.";
            $imageDetails = null;
        }
    }

    // ADDING DATA TO DATABASE
    $sql = "UPDATE `product` SET `PRO_NAME`='$name',
                                `PRO_DESC`='$desc',
                                `PRO_HSNNO`='$hsnno',
                                `PRO_PRICE`='$price',
                                `PRO_MAX_DISCOUNT`='$maxDiscount',
                                `PRO_CATEGORY`='$category',
                                `PRO_UOM`='$uom',
                                `PRO_IMAGE`='$imageDetails'
                                WHERE `PRO_CODE`='$productCode'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header('location: \Office\Browz Invoice\pages\product-page.php?u=1&update=' . $productCode);
        exit();
    } else {
        header('location: \Office\Browz Invoice\pages\update-product.php?u=0&update=' . $productCode);
        exit();
    }
}
