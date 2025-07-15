<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    header('location: /Office/Browz%20Invoice/auth-login.php');
    exit();
}

echo 'adding product<br>';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image']['tmp_name'])) {

    include 'db-conn.php';

    // $productCode = $_POST['pro-code'];

    $curYear = date('Y');
    // echo $curYear;

    // // AUTO GENERATING product CODE BY FINDING THE LAST product CODE
    // include 'db-conn.php';

    $result = mysqli_query($conn, "SELECT PRO_CODE FROM product ORDER BY PRO_CODE DESC LIMIT 1");
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Extracting number and increment
        $lastCode = $row['PRO_CODE'];
        // echo $lastCode;
        $number = (int)substr($lastCode, -4); // Geting numeric part after 'CUST'
        $newNumber = $number + 1;
    } else {
        // No products yet
        $newNumber = 1;
    }

    // echo $newNumber;

    $productCode = 'P' . (string)$curYear . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    // echo $productCode;

    $name = $_POST['name'];
    $hsnno = $_POST['hsnno'];
    $price = $_POST['price'];
    $maxDiscount = $_POST['max-discount'];
    $category = $_POST['category'];
    $uom = $_POST['uom'];
    $desc = $_POST['desc'];

    //image data
    $image = $_FILES['image']['tmp_name'];
    $imageName = $_FILES['image']['name'];
    $imageType = $_FILES['image']['type'];
    $imageData = (!empty($imageType) ? base64_encode(file_get_contents($image)) : '');

    $imageDetailsArray = array(
        'imageName' => $imageName,
        'imageType' => $imageType,
        'imageData' => $imageData
    );

    $imageDetails = json_encode($imageDetailsArray, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);


    // $inStock = ($quantity > 0 ? 'y' : 'n');

    // checking if the hsn no already exixt 
    $checkHSNSql = "SELECT * FROM `product` WHERE `PRO_HSNNO`='$hsnno'";
    $checkHSNRes = mysqli_query($conn, $checkHSNSql);
    if ($checkHSNRes && $checkHSNRes->num_rows > 0) {
        header('location: \Office\Browz Invoice\pages\add-product.php?s=3');
        exit();
    }

    $sql = "SELECT * FROM `product` WHERE `PRO_CODE`='$productCode'";
    $result = mysqli_query($conn, $sql);
    if ($result && $result->num_rows > 0) {
        header('location: \Office\Browz Invoice\pages\add-product.php?s=3');
        exit();
    } else {
        // ADDING DATA TO DATABASE
        $sql = "INSERT INTO `product` (`PRO_CODE`,`PRO_NAME`,`PRO_DESC`,`PRO_HSNNO`,`PRO_PRICE`,`PRO_MAX_DISCOUNT`,`PRO_CATEGORY`,`PRO_UOM`,`PRO_IMAGE`) 
                                VALUES ('$productCode','$name','$desc','$hsnno','$price','$maxDiscount','$category','$uom','$imageDetails')";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            header('location: \Office\Browz Invoice\pages\add-product.php?s=1');
            exit();
        } else {
            header('location: \Office\Browz Invoice\pages\add-product.php?s=0');
            exit();
        }
    }

    $conn->close();
}
