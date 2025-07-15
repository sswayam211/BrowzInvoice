<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    header('location: /Office/Browz%20Invoice/auth-login.php');
    exit();
}


// echo 'adding invoice data to db <br>';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include 'db-conn.php';

    // sales order code variable
    // $SOCode = $_POST['so-code-1'];

    $curYear = date('Y');
    // echo $curYear;

    // // AUTO GENERATING CUSTOMER CODE BY FINDING THE LAST CUSTOMER CODE
    // include 'db-conn.php';

    $result = mysqli_query($conn, "SELECT SO_CODE FROM sales_order ORDER BY SO_CODE DESC LIMIT 1");
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Extracting number and increment
        $lastCode = $row['SO_CODE'];
        // echo $lastCode;
        $number = (int)substr($lastCode, -4); // Geting numeric part after 'CUST'
        $newNumber = $number + 1;
    } else {
        // No customers yet
        $newNumber = 1;
    }

    // echo $newNumber;

    $SOCode = 'INV' . (string)$curYear . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    // echo $customerCode;


    // checking if the code already exixt
    $checkSql = "SELECT * FROM `sales_order` WHERE `SO_CODE`='$SOCode'";
    $checkResult = mysqli_query($conn, $checkSql);
    if ($checkResult && $checkResult->num_rows > 0) {
        header('location: \Office\Browz Invoice\pages\sales-order.php?s=3&inv=' . $SOCode);
        exit();
    } else {
        $invoicedate = date("d-m-Y");

        // will set it when authantication process is complete
        $salesManCode = (isset($_SESSION['userID']) ? $_SESSION['userID'] : '');

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



        // adding cutomer details to customer table if new customer 
        $checkCustSql = "SELECT * FROM `customer` WHERE `CUST_CODE`='$customerCode'";
        $checkCustResult = mysqli_query($conn, $checkCustSql);
        if ($checkCustResult && !($checkCustResult->num_rows > 0)) {

            $addCustSql = "INSERT INTO `customer` (`CUST_CODE`,`CUST_FULL_NAME`,`CUST_EMAIL`,`CUST_PHONE_NO`,`CUST_ADDRESS_1`,`CUST_ADDRESS_2`,`CUST_COUNTRY`,`CUST_STATE`,`CUST_CITY`,`CUST_POSTAL_CODE`,`CUST_GSTIN`,`CUST_BILLING_ADD`,`CUST_SHIPPING_ADD`) 
                                                VALUES ('$customerCode','$fullName','$email','$phone','$address1','$address2','$country','$state','$city','$pincode','$gstin','$billCode','$shipCode')";

            $addBillSql = "INSERT INTO `bill_to_address` (`BILL_CODE`,`BILL_NAME`,`BILL_EMAIL`,`BILL_PHONE_NO`,`BILL_ADDRESS_1`,`BILL_ADDRESS_2`,`BILL_COUNTRY`,`BILL_STATE`,`BILL_CITY`,`BILL_POSTAL_CODE`,`GSTIN_NO`) 
                                        VALUES ('$billCode','$fullName2','$email2','$phone2','$address12','$address22','$country2','$state2','$city2','$pincode2','$gstin')";

            $addShipSql = "INSERT INTO `ship_to_address` (`SHIP_CODE`,`SHIP_NAME`,`SHIP_EMAIL`,`SHIP_PHONE_NO`,`SHIP_ADDRESS_1`,`SHIP_ADDRESS_2`,`SHIP_COUNTRY`,`SHIP_STATE`,`SHIP_CITY`,`SHIP_POSTAL_CODE`,`GSTIN_NO`) 
                                        VALUES ('$shipCode','$fullName3','$email3','$phone3','$address13','$address23','$country3','$state3','$city3','$pincode3','$gstin')";

            $addCustResult = mysqli_query($conn, $addCustSql);
            $addBillResult = mysqli_query($conn, $addBillSql);
            $addShipResult = mysqli_query($conn, $addShipSql);
        }



        // product details variable 
        // total product
        $totalProducts = $_POST['total-products'];

        // product details for each product


        // assigning value to product variable
        for ($i = 1; $i <= $totalProducts; $i++) {
            $productVar = 'productname' . $i;
            $descVar = 'productdesc' . $i;
            $priceVar = 'productprice' . $i;
            $uomVar = 'productuom' . $i;
            $hsnVar = 'producthsn' . $i;
            $qtyVar = 'productqty' . $i;
            $disVar = 'productdis' . $i;
            $totalWOGSTVar = 'producttotalwogst' . $i;
            $gstVar = 'productgst' . $i;
            $gstValVar = 'productgstval' . $i;
            $tpriceVar = 'producttprice' . $i;

            // Assign values from POST to variables
            $$productVar = $_POST["product-name-$i"];
            $$descVar = $_POST["pro-desc-$i"];
            $$priceVar = $_POST["pro-price-$i"];
            $$uomVar = $_POST["pro-uom-$i"];
            $$hsnVar = $_POST["pro-hsn-$i"];
            $$qtyVar = $_POST["pro-quantity-$i"];
            $$disVar = $_POST["pro-discount-$i"];
            $$totalWOGSTVar = $_POST["pro-total-without-gst-$i"];
            $$gstVar = $_POST["pro-gst-$i"];
            $$gstValVar = $_POST["pro-gst-val-$i"];
            $$tpriceVar = $_POST["pro-t-price-$i"];
        }
        $grandTotalPrice = $_POST['grand-total-1'];

        // sqls
        // invoice sql
        $invoiceSql = "INSERT INTO `sales_order` (`SO_CODE`,`SO_CUST_CODE`,`SO_SM_CODE`,`SO_CURRENCY`,`SO_TOTAL`,`SO_DATE`) 
                                                VALUES ('$SOCode','$customerCode','$salesManCode','$currency','$grandTotalPrice','$invoicedate')";

        $invoiceResult =  mysqli_query($conn, $invoiceSql);

        //invoice bill add sql
        $billSql = "INSERT INTO `sales_order_bill_add` (`SOB_SO_CODE`,`SOB_CODE`,`SOB_NAME`,`SOB_EMAIL`,`SOB_PHONE_NO`,`SOB_COUNTRY`,`SOB_STATE`,`SOB_CITY`,`SOB_PINCODE`,`SOB_ADDRESS_1`,`SOB_ADDRESS_2`) 
                                                VALUES ('$SOCode','$billCode','$fullName2','$email2','$phone2','$country2','$state2','$city2','$pincode2','$address12','$address22')";

        $billResult =  mysqli_query($conn, $billSql);

        //invoice ship add sql 
        $shipSql = "INSERT INTO `sales_order_ship_add` (`SOS_SO_CODE`,`SOS_CODE`,`SOS_NAME`,`SOS_EMAIL`,`SOS_PHONE_NO`,`SOS_COUNTRY`,`SOS_STATE`,`SOS_CITY`,`SOS_PINCODE`,`SOS_ADDRESS_1`,`SOS_ADDRESS_2`) 
                                                VALUES ('$SOCode','$shipCode','$fullName3','$email3','$phone3','$country3','$state3','$city3','$pincode3','$address13','$address23')";

        $shipResult =  mysqli_query($conn, $shipSql);

        // invoice items sql
        $itemResult;
        for ($i = 1; $i <= $totalProducts; $i++) {
            $productCode = ${"productname$i"};
            $productDesc = ${"productdesc$i"};
            $productPrice = ${"productprice$i"};
            $productUOM = ${"productuom$i"};
            $productHSN = ${"producthsn$i"};
            $productQty = ${"productqty$i"};
            $productDis = ${"productdis$i"};
            $productTotalWOGST = ${"producttotalwogst$i"};
            $productGST = ${"productgst$i"};
            $productGSTVal = ${"productgstval$i"};
            $productTotal = ${"producttprice$i"};


            $itemSql = "INSERT INTO `sales_order_item` (
                                                        `SOI_SO_CODE`, 
                                                        `SOI_PRO_CODE`, 
                                                        `SOI_PRO_DESC`,
                                                        `SOI_PRO_HSNNO`,
                                                        `SOI_PRO_PRICE`,
                                                        `SOI_PRO_UOM`, 
                                                        `SOI_PRO_QUANTITY`, 
                                                        `SOI_DISCOUNT`,
                                                        `SOI_TOTAL_WITHOUT_GST`, 
                                                        `SOI_GST`,
                                                        `SOI_GST_VAL`,
                                                        `SOI_TOTAL_WITH_GST`
                                                    ) VALUES (
                                                        '$SOCode', 
                                                        '$productCode',
                                                        '$productDesc', 
                                                        '$productHSN',
                                                        '$productPrice', 
                                                        '$productUOM',
                                                        '$productQty', 
                                                        '$productDis',
                                                        '$productTotalWOGST',
                                                        '$productGST',
                                                        '$productGSTVal',
                                                        '$productTotal'
                                                    )";

            $itemResult =  mysqli_query($conn, $itemSql);
        }


        // checking if the product is added succesully or not
        if ($invoiceResult && $billResult && $shipResult && $itemResult) {
            header('location: \Office\Browz Invoice\pages\invoice-preview.php?s=1&inv=' . $SOCode);
            exit();
        } else {
            header('location: \Office\Browz Invoice\pages\sales-order.php?s=0&inv=' . $SOCode);
            exit();
        }
    }


    $conn->close();
    exit();
}
