<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    header('location: /Office/Browz%20Invoice/auth-login.php');
    exit();
}

// echo 'updating invoice data to db <br>';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include 'db-conn.php';

    // sales order code variable
    $SOCode = $_POST['so-code-1'];

    $updateDate = date("d-m-Y");

    // will set it when authantication process is complete
    $salesManCode = '';

    // currency details
    $currency = $_POST['currency'];

    // customer details variables
    // customer details to save in so tabel
    $customerCode = $_POST['cust-code-1'];
    $fname = $_POST['fname'];
    $mname = (!empty($_POST['mname']) ? $_POST['mname'] : '');
    $lname = $_POST['lname'];
    $fullName = (!empty($_POST['mname']) ? $fname . ' ' . $mname . ' ' . $lname : $fname . ' ' . $lname);
    $gstin = $_POST['gstin'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $pincode = $_POST['pincode'];
    $address1 = $_POST['address1'];
    $address2 = (!empty($_POST['address2']) ? $_POST['address2'] : '');

    // billing address details 
    $billCode = $_POST['bill-code-1'];
    $fullName2 = $_POST['bill-name'];
    $email2 = $_POST['bill-email'];
    $phone2 = $_POST['bill-phone'];
    $country2 = $_POST['bill-country'];
    $state2 = $_POST['bill-state'];
    $city2 = $_POST['bill-city'];
    $pincode2 = $_POST['bill-pincode'];
    $address12 = $_POST['bill-address1'];
    $address22 = (!empty($_POST['bill-address2']) ? $_POST['bill-address2'] : '');

    // shipping address details 
    $shipCode = $_POST['ship-code-1'];
    $fullName3 = $_POST['ship-name'];
    $email3 = $_POST['ship-email'];
    $phone3 = $_POST['ship-phone'];
    $country3 = $_POST['ship-country'];
    $state3 = $_POST['ship-state'];
    $city3 = $_POST['ship-city'];
    $pincode3 = $_POST['ship-pincode'];
    $address13 = $_POST['ship-address1'];
    $address23 = (!empty($_POST['ship-address2']) ? $_POST['ship-address2'] : '');


    // product details variable 
    // total product
    $totalProducts = $_POST['total-products'];

    // product details for each product


    // assigning value to product variable
    for ($i = 1; $i <= $totalProducts; $i++) {
        $productVar = 'productname' . $i;
        $priceVar = 'productprice' . $i;
        $uomVar = 'productuom' . $i;
        $qtyVar = 'productqty' . $i;
        $disVar = 'productdis' . $i;
        $totalWOGSTVar = 'producttotalwogst' . $i;
        $gstVar = 'productgst' . $i;
        $gstValVar = 'productgstval' . $i;
        $tpriceVar = 'producttprice' . $i;

        // Assign values from POST to variables
        $$productVar = $_POST["product-name-$i"];
        $$priceVar = $_POST["pro-price-$i"];
        $$uomVar = $_POST["pro-uom-$i"];
        $$qtyVar = $_POST["pro-quantity-$i"];
        $$disVar = $_POST["pro-discount-$i"];
        $$totalWOGSTVar = $_POST["pro-total-without-gst-$i"];
        $$gstVar = $_POST["pro-gst-$i"];
        $$gstValVar = $_POST["pro-gst-val-$i"];
        $$tpriceVar = $_POST["pro-t-price-$i"];

        // echo $$productVar . '<br><br>';
    }

    // // displaying product on screen 
    // for ($i = 1; $i <= $totalProducts; $i++) {
    //     echo "Product $i: ";
    //     echo "Name: " . ${"productname$i"} . ",<br> ";
    //     echo "Price: " . ${"productprice$i"} . ", <br>";
    //     echo "UOM: " . ${"productuom$i"} . ", <br>";
    //     echo "GST: " . ${"productgst$i"} . ", <br>";
    //     echo "Quantity: " . ${"productqty$i"} . ",<br> ";
    //     echo "Total Price: " . ${"producttprice$i"} . "<br><br>";
    // }

    $grandTotalPrice = $_POST['grand-total-1'];
    // echo $grandTotalPrice . '<br>';



    // sqls
    // invoice sql
    $invoiceUpdSql = "UPDATE `sales_order` SET `SO_SM_CODE`='$salesManCode',
                                                `SO_CURRENCY`='$currency',
                                                `SO_TOTAL`='$grandTotalPrice',
                                                `SO_UPDATE_DATE`='$updateDate'
                                                WHERE `SO_CODE`='$SOCode' AND `SO_CUST_CODE`='$customerCode'";

    $invoiceUpdResult =  mysqli_query($conn, $invoiceUpdSql);


    //invoice bill add sql
    $billUpdSql = "UPDATE `sales_order_bill_add` SET `SOB_NAME`='$fullName2',
                                                `SOB_EMAIL`='$email2',
                                                `SOB_PHONE_NO`='$phone2',
                                                `SOB_COUNTRY`='$country2',
                                                `SOB_STATE`='$state2',
                                                `SOB_CITY`='$city2',
                                                `SOB_PINCODE`='$pincode2',
                                                `SOB_ADDRESS_1`='$address12',
                                                `SOB_ADDRESS_2`='$address22'
                                                WHERE `SOB_SO_CODE`='$SOCode' AND `SOB_CODE`='$billCode'";

    $billUpdResult =  mysqli_query($conn, $billUpdSql);


    //invoice ship add sql 
    $shipUpdSql = "UPDATE `sales_order_ship_add` SET `SOS_NAME`='$fullName3',
                                                `SOS_EMAIL`='$email3',
                                                `SOS_PHONE_NO`='$phone3',
                                                `SOS_COUNTRY`='$country3',
                                                `SOS_STATE`='$state3',
                                                `SOS_CITY`='$city3',
                                                `SOS_PINCODE`='$pincode3',
                                                `SOS_ADDRESS_1`='$address13',
                                                `SOS_ADDRESS_2`='$address23'
                                                WHERE `SOS_SO_CODE`='$SOCode' AND `SOS_CODE`='$shipCode'";

    $shipUpdResult =  mysqli_query($conn, $shipUpdSql);


    // deleting all the prevoius items from the table and the re adding
    $delProSql = "DELETE FROM `sales_order_item` WHERE `SOI_SO_CODE`='$SOCode'";
    $delProResult = mysqli_query($conn, $delProSql);

    // invoice items sql
    $itemResult;
    for ($i = 1; $i <= $totalProducts; $i++) {
        $productCode = ${"productname$i"};
        $productPrice = ${"productprice$i"};
        $productQty = ${"productqty$i"};
        $productDis = ${"productdis$i"};
        $productTotalWOGST = ${"producttotalwogst$i"};
        $productGST = ${"productgst$i"};
        $productGSTVal = ${"productgstval$i"};
        $productTotal = ${"producttprice$i"};


        $itemUpdSql = "INSERT INTO `sales_order_item` (
                                                        `SOI_SO_CODE`, 
                                                        `SOI_PRO_CODE`, 
                                                        `SOI_PRO_PRICE`, 
                                                        `SOI_PRO_QUANTITY`, 
                                                        `SOI_DISCOUNT`,
                                                        `SOI_TOTAL_WITHOUT_GST`, 
                                                        `SOI_GST`,
                                                        `SOI_GST_VAL`,
                                                        `SOI_TOTAL_WITH_GST`
                                                    ) VALUES (
                                                        '$SOCode', 
                                                        '$productCode', 
                                                        '$productPrice', 
                                                        '$productQty', 
                                                        '$productDis',
                                                        '$productTotalWOGST',
                                                        '$productGST',
                                                        '$productGSTVal',
                                                        '$productTotal'
                                                    )";

        $itemUpdResult =  mysqli_query($conn, $itemUpdSql);
    }


    // checking if the product is updated succesully or not
    if ($invoiceUpdResult && $billUpdResult && $shipUpdResult && $itemUpdResult) {
        header('location: \Office\Browz Invoice\php\handle-sales-order.php?u=1&inv=' . $SOCode);
        exit();
    } else {
        header('location: \Office\Browz Invoice\pages\update-sales-order.php?s=0&inv=' . $SOCode);
        exit();
    }


    $conn->close();
}
