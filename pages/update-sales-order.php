<!-- including side nav bar  -->
<?php include 'side-nav.php'; ?>

<style>
    .checkbox input {
        width: fit-content;
    }

    .checkbox label {
        position: relative;
        top: 0;
        left: 0;
        margin: 0px 10px;
    }

    .checkbox input:focus+label,
    .checkbox input:not(:placeholder-shown)+label {
        top: 0px;
        left: 0px;
        font-size: 11px;
    }

    table input,
    table select {
        border-radius: 0;
        box-shadow: none;
        border: none;
        /* background-color: black; */
    }

    .form-group {
        margin: 0;
    }

    #grand-total-1,
    #grand-total-2 {
        display: inline;
        width: 15%;
        border: none;
        box-shadow: none;
    }


    table td {
        position: relative;
        z-index: 5;
        background-color: transparent;
    }

    table td input {
        position: relative;
        z-index: -1;
    }

    .discount {
        z-index: 5;
    }

    .table>:not(caption)>*>* {
        padding: 7px 0px;
    }

    th {
        padding: .5rem .7rem;
    }

    .border-right {
        border-right: 1px solid #dee2e6 !important;
    }
</style>


<?php

// fetching currency options from database 

include 'db-conn.php';
$getCurrSql = "SELECT * FROM `currency`";
$getCurrResult = mysqli_query($conn, $getCurrSql);
$CurrArry = array();
if ($getCurrResult && $getCurrResult->num_rows > 0) {
    while ($CurrData = $getCurrResult->fetch_assoc()) {
        $CurrArry[] = '<option value="' . $CurrData['CURRENCY_CODE'] . '" ' . ($CurrData['STATUE'] == 'Inactive' ? 'disabled' : '') . '>' . $CurrData['CURRENCY'] . '(' . $CurrData['CURRENCY_SYMBOL'] . ')<span class="text-danger fw-bold">' . ($CurrData['STATUE'] == 'Inactive' ? '(Not available)' : '') . '</span></option>';
    }
}

$CurrOptionsHtml = '';
foreach ($CurrArry as $optionHtml) {
    $CurrOptionsHtml .= $optionHtml;
}

$conn->close();

// echo $CurrOptionsHtml;
?>

<?php

// fetching product options from dababase
include 'db-conn.php';
$getProSql = "SELECT PRO_NAME, PRO_CODE FROM `product`";
$getProResult = mysqli_query($conn, $getProSql);
$proArry = array();
if ($getProResult && $getProResult->num_rows > 0) {
    while ($proData = $getProResult->fetch_assoc()) {
        $proArry[] = '<option value="' . $proData['PRO_CODE'] . '">' . $proData['PRO_NAME'] . '</option>';
    }
}

$proOptionsHtml = '';
foreach ($proArry as $optionHtml) {
    $proOptionsHtml .= $optionHtml;
}

$conn->close();

// echo $proOptionsHtml;
?>


<?php
// fetching invoice details from database 
include 'db-conn.php';

// needed variables 
$SOCode = '';
$customerCode = '';
$billCode = '';
$shipCode = '';
$gstin = '';
$grandTotalPrice = '';
$currency = '';
$curName = '';
$curSymbol = '';
$todayDate = '';


//fetching so code from get request
$SOCode = (isset($_GET['inv']) ? $_GET['inv'] : '');


// fetching customer data
$custSql = "SELECT * FROM `sales_order` WHERE `SO_CODE`='$SOCode'";
$custResult = mysqli_query($conn, $custSql);
if ($custResult && $custResult->num_rows > 0) {
    $custData = $custResult->fetch_assoc();
    $customerCode = $custData['SO_CUST_CODE'];
    $grandTotalPrice = $custData['SO_TOTAL'];
    $todayDate = $custData['SO_DATE'];
    $currency = $custData['SO_CURRENCY'];
}


// fetching billing and shipping code from db
$fetchSql = "SELECT * FROM `customer` WHERE `CUST_CODE`='$customerCode'";
$fetchResult = mysqli_query($conn, $fetchSql);
if ($fetchResult && $fetchResult->num_rows > 0) {
    $fetchData = $fetchResult->fetch_assoc();
    $billCode = $fetchData['CUST_BILLING_ADD'];
    $shipCode = $fetchData['CUST_SHIPPING_ADD'];
    $gstin = $fetchData['CUST_GSTIN'];
}


// fetching currency data 
$curSql = "SELECT * FROM `currency` WHERE `CURRENCY_CODE`='$currency'";
$curResult = mysqli_query($conn, $curSql);
if ($curResult && $curResult->num_rows > 0) {
    $data = $curResult->fetch_assoc();
    $curSymbol = $data['CURRENCY_SYMBOL'];
    $curName = $data['CURRENCY'];
    // echo $curName;
}


$conn->close();


?>



<!-- <a href="customer-page.php"><button class="back" type="button"><i class="fa-solid fa-arrow-left me-1"></i>Back</button></a> -->
<div class="add-form py-5">
    <form action="\Office\Browz Invoice\php\handle-update-sales-order.php" method="post" class="shadow p-sm-5 py-5 p-3 mx-sm-5 bg-white" autocomplete="off" style="background-color: white;">
        <div class="alert-box">
            <?php
            $message = false;
            $error = false;

            if (isset($_GET['s']) && $_GET['s'] == '1') {
                $message = 'Invoice details added successfully!';
            } else if (isset($_GET['s']) && $_GET['s'] == '0') {
                $error = 'Fail to add invoice details, please try again';
            } else if (isset($_GET['s']) && $_GET['s'] == '3') {
                $error = 'This invoice code already exist.';
            }

            if ($message) {
                echo '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success! </strong> ' . $message . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ';
            }

            if ($error) {
                echo '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error! </strong> ' . $error . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                ';
            }

            ?>
        </div>


        <div class="row">
            <div class="col-md-6">
                <div class="form-heading mb-4">
                    <h3 class="m-0">Update Invoice</h3>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group col-md-6 ms-auto mb-4">
                    <div class="col-md-12 pe-3">
                        <input type="hidden" name="so-code-1" id="so-code-1" placeholder="" value="<?php echo $SOCode; ?>">
                        <input type="text" name="so-code-2" id="so-code-2" placeholder="" value="<?php echo $SOCode; ?>" disabled>
                        <label for="so-code">Transaction Code<span class="required">*</span></label>
                    </div>
                </div>
            </div>
        </div>

        <hr class="m-0">

        <div class="row">
            <div class="form-group col-md-12 mb-4 mt-2">
                <p class="m-0 fw-bold">Customer Details :</p>
            </div>

            <div class="cust-details col-12">
                <div class="row">
                    <div class="form-group col-md-3 mb-4">
                        <input type="hidden" name="cust-code-1" id="cust-code-1" placeholder="" value="<?php echo $customerCode; ?>" required>
                        <input type="text" name="cust-code-2" id="cust-code-2" placeholder="" value="<?php echo $customerCode; ?>" disabled required>
                        <label for="cust-code">Customer Code<span class="required">*</span></label>
                    </div>


                    <?php
                    // fetching customer data 
                    include 'db-conn.php';
                    $fetchCustSql = "SELECT * FROM `customer` WHERE `CUST_CODE`='$customerCode'";
                    $fetchCustRes = mysqli_query($conn, $fetchCustSql);
                    if ($fetchCustRes && $fetchCustRes->num_rows > 0) {
                        $data = $fetchCustRes->fetch_assoc();

                        $name = trim($data['CUST_FULL_NAME']);
                        $name = preg_replace('/\s+/u', ' ', $name);
                        $namaArray = explode(' ', $name);
                        $fname = isset($namaArray[0]) ? $namaArray[0] : '';
                        $lname = count($namaArray) > 1 ? $namaArray[count($namaArray) - 1] : '';
                        $mname = '';
                        if (count($namaArray) > 2) {
                            $mname = implode(' ', array_slice($namaArray, 1, -1));
                        }

                        echo '
                            <div class="form-group col-md-3 mb-4">
                                <input type="text" name="fname" id="fname" placeholder="" value="' . htmlspecialchars($fname) . '" required>
                                <label for="fname">First Name<span class="required">*</span></label>
                            </div>
                            <div class="form-group col-md-3 mb-4">
                                <input type="text" name="mname" id="mname" placeholder="" value="' . htmlspecialchars($mname) . '">
                                <label for="mname">Middle Name</label>
                            </div>
                            <div class="form-group col-md-3 mb-4">
                                <input type="text" name="lname" id="lname" placeholder=""  value="' . htmlspecialchars($lname) . '" required>
                                <label for="lname">Last Name<span class="required">*</span></label>
                            </div>
                            <div class="form-group col-md-3 mb-4">
                                <input type="text" name="gstin" id="gstin" placeholder="" value="' . htmlspecialchars($data['CUST_GSTIN']) . '">
                                <label for="gstin">GSTIN No</label>
                            </div>
                            <div class="form-group col-md-3 mb-4">
                                <input type="email" name="email" id="email" placeholder="" value="' . htmlspecialchars($data['CUST_EMAIL']) . '" required>
                                <label for="email">Email<span class="required">*</span></label>
                            </div>
                            <div class="form-group col-md-3 mb-4">
                                <input type="tel" name="phone" id="phone" placeholder="" value="' . htmlspecialchars($data['CUST_PHONE_NO']) . '" required>
                                <label for="phone">Phone No<span class="required">*</span></label>
                            </div>
                            <div class="form-group col-md-3 mb-4">
                                <select id="country" name="country" required>
                                    <option value="' . htmlspecialchars($data['CUST_COUNTRY']) . '" selected>' . htmlspecialchars($data['CUST_COUNTRY']) . '</option> 
                                    <option value="India">India</option>
                                </select>
                                <label for="country">
                                    Country<span class="required">*</span>
                                </label>
                            </div>
                            <div class="form-group col-md-3 mb-4">
                                <select id="state" name="state" oninput="populateCities()" required>
                                    <option value="' . htmlspecialchars($data['CUST_STATE']) . '" selected>' . htmlspecialchars($data['CUST_STATE']) . '</option>
                                    <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                    <option value="Andhra Pradesh">Andhra Pradesh</option>
                                    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                    <option value="Assam">Assam</option>
                                    <option value="Bihar">Bihar</option>
                                    <option value="Chandigarh">Chandigarh</option>
                                    <option value="Chhattisgarh">Chhattisgarh</option>
                                    <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                                    <option value="Delhi">Delhi</option>
                                    <option value="Goa">Goa</option>
                                    <option value="Gujarat">Gujarat</option>
                                    <option value="Haryana">Haryana</option>
                                    <option value="Himachal Pradesh">Himachal Pradesh</option>
                                    <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                    <option value="Jharkhand">Jharkhand</option>
                                    <option value="Karnataka">Karnataka</option>
                                    <option value="Kerala">Kerala</option>
                                    <option value="Ladakh">Ladakh</option>
                                    <option value="Lakshadweep">Lakshadweep</option>
                                    <option value="Madhya Pradesh">Madhya Pradesh</option>
                                    <option value="Maharashtra">Maharashtra</option>
                                    <option value="Manipur">Manipur</option>
                                    <option value="Meghalaya">Meghalaya</option>
                                    <option value="Mizoram">Mizoram</option>
                                    <option value="Nagaland">Nagaland</option>
                                    <option value="Odisha">Odisha</option>
                                    <option value="Puducherry">Puducherry</option>
                                    <option value="Punjab">Punjab</option>
                                    <option value="Rajasthan">Rajasthan</option>
                                    <option value="Sikkim">Sikkim</option>
                                    <option value="Tamil Nadu">Tamil Nadu</option>
                                    <option value="Telangana">Telangana</option>
                                    <option value="Tripura">Tripura</option>
                                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                                    <option value="Uttarakhand">Uttarakhand</option>
                                    <option value="West Bengal">West Bengal</option>
                                </select>
                                <label for="country">
                                    State<span class="required">*</span>
                                </label>
                            </div>
                            <div class="form-group col-md-3 mb-4">
                                <input type="text" name="city" id="city" value="' . htmlspecialchars($data['CUST_CITY']) . '" placeholder="">
                                <label for="phone">City<span class="required">*</span></label>
                            </div>
                            <div class="form-group col-md-3 mb-4">
                                <input type="number" name="pincode" id="pincode" placeholder="" value="' . htmlspecialchars($data['CUST_POSTAL_CODE']) . '" required>
                                <label for="phone">Postal Code<span class="required">*</span></label>
                            </div>
                            <div class="form-group col-md-6 mb-4">
                                <input type="text" name="address1" id="address1" placeholder="" value="' . htmlspecialchars($data['CUST_ADDRESS_1']) . '" required>
                                <label for="address1">Address line 1<span class="required">*</span></label>
                            </div>
                            <div class="form-group col-md-6 mb-4">
                                <input type="text" name="address2" id="address2" placeholder="" value="' . htmlspecialchars($data['CUST_ADDRESS_2']) . '">
                                <label for="address2">Address line 2</label>
                            </div>
                        ';
                    }

                    $conn->close();
                    ?>

                </div>
                <hr class="m-0">

                <div class="row">
                    <div class="col-md-6 border-right p-md-3">
                        <div class="form-group d-flex align-items-center justify-content-between col-md-12 mb-4 mt-2">
                            <p class="m-0 fw-bold">Billing Details :</p>
                            <div class="checkbox d-flex align-items-center">
                                <input type="checkbox" name="same-as-permanent" id="same-as-perm">
                                <label for="same-as-perm">Same as permanent address</label>
                            </div>
                        </div>
                        <div class="row">

                            <div class="form-group col-md-4 mb-4">
                                <input type="hidden" name="bill-code-1" id="bill-code-1" placeholder="" value="<?php echo $billCode; ?>" required>
                                <input type="text" name="bill-code-2" id="bill-code-2" placeholder="" value="<?php echo $billCode; ?>" disabled required>
                                <label for="bill-code">Bill Code<span class="required">*</span></label>
                            </div>

                            <?php
                            // fetching billing data 
                            include 'db-conn.php';
                            $fetchBillSql = "SELECT * FROM `sales_order_bill_add` WHERE `SOB_CODE`='$billCode' AND `SOB_SO_CODE`='$SOCode'";
                            $fetchBillRes = mysqli_query($conn, $fetchBillSql);
                            if ($fetchBillRes && $fetchBillRes->num_rows > 0) {
                                $billData = $fetchBillRes->fetch_assoc();

                                echo '
                                    <div class="form-group col-md-8 mb-4">
                                        <input type="text" name="bill-name" id="bill-name" placeholder="" value="' . $billData['SOB_NAME'] . '" required>
                                        <label for="bil-name">Name<span class="required">*</span></label>
                                    </div>
                                    <div class="form-group col-md-4 mb-4">
                                        <input type="email" name="bill-email" id="bill-email" placeholder="" value="' . $billData['SOB_EMAIL'] . '" required>
                                        <label for="bill-email">Email<span class="required">*</span></label>
                                    </div>
                                    <div class="form-group col-md-4 mb-4">
                                        <input type="number" class="number" class="number" name="bill-phone" id="bill-phone" placeholder="" value="' . $billData['SOB_PHONE_NO'] . '" required>
                                        <label for="bill-phone">Phone No<span class="required">*</span></label>
                                    </div>
                                    <div class="form-group col-md-4 mb-4">
                                        <select id="bill-country" name="bill-country" required>
                                            <option  value="' . $billData['SOB_COUNTRY'] . '" selected>' . $billData['SOB_COUNTRY'] . '</option>
                                            <option value="India">India</option>
                                        </select>
                                        <label for="bill-country">
                                            Country<span class="required">*</span>
                                        </label>
                                    </div>
                                    <div class="form-group col-md-4 mb-4">
                                        <select id="bill-state" name="bill-state" required>
                                            <option value="' . $billData['SOB_STATE'] . '" selected >' . $billData['SOB_STATE'] . ' </option>
                                            <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                            <option value="Andhra Pradesh">Andhra Pradesh</option>
                                            <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                            <option value="Assam">Assam</option>
                                            <option value="Bihar">Bihar</option>
                                            <option value="Chandigarh">Chandigarh</option>
                                            <option value="Chhattisgarh">Chhattisgarh</option>
                                            <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                                            <option value="Delhi">Delhi</option>
                                            <option value="Goa">Goa</option>
                                            <option value="Gujarat">Gujarat</option>
                                            <option value="Haryana">Haryana</option>
                                            <option value="Himachal Pradesh">Himachal Pradesh</option>
                                            <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                            <option value="Jharkhand">Jharkhand</option>
                                            <option value="Karnataka">Karnataka</option>
                                            <option value="Kerala">Kerala</option>
                                            <option value="Ladakh">Ladakh</option>
                                            <option value="Lakshadweep">Lakshadweep</option>
                                            <option value="Madhya Pradesh">Madhya Pradesh</option>
                                            <option value="Maharashtra">Maharashtra</option>
                                            <option value="Manipur">Manipur</option>
                                            <option value="Meghalaya">Meghalaya</option>
                                            <option value="Mizoram">Mizoram</option>
                                            <option value="Nagaland">Nagaland</option>
                                            <option value="Odisha">Odisha</option>
                                            <option value="Puducherry">Puducherry</option>
                                            <option value="Punjab">Punjab</option>
                                            <option value="Rajasthan">Rajasthan</option>
                                            <option value="Sikkim">Sikkim</option>
                                            <option value="Tamil Nadu">Tamil Nadu</option>
                                            <option value="Telangana">Telangana</option>
                                            <option value="Tripura">Tripura</option>
                                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                                            <option value="Uttarakhand">Uttarakhand</option>
                                            <option value="West Bengal">West Bengal</option>
                                        </select>
                                        <label for="bill-country">
                                            State<span class="required">*</span>
                                        </label>
                                    </div>
                                    <div class="form-group col-md-4 mb-4">
                                        <input type="text" name="bill-city" id="bill-city" placeholder="" value="' . $billData['SOB_CITY'] . '">
                                        <label for="bill-city">City<span class="required">*</span></label>
                                    </div>
                                    <div class="form-group col-md-4 mb-4">
                                        <input type="number" class="number" name="bill-pincode" id="bill-pincode" placeholder="" value="' . $billData['SOB_PINCODE'] . '" required>
                                        <label for="bill-pincode">Postal Code<span class="required">*</span></label>
                                    </div>
                                    <div class="form-group col-md-12 mb-4">
                                        <input type="text" name="bill-address1" id="bill-address1" placeholder="" value="' . $billData['SOB_ADDRESS_1'] . '" required>
                                        <label for="bill-address1">Address line 1<span class="required">*</span></label>
                                    </div>
                                    <div class="form-group col-md-12 mb-4">
                                        <input type="text" name="bill-address2" id="bill-address2" placeholder="" value="' . $billData['SOB_ADDRESS_2'] . '">
                                        <label for="bill-address2">Address line 2</label>
                                    </div>
                                ';
                            }
                            $conn->close();
                            ?>
                        </div>
                    </div>
                    <!-- <hr> -->

                    <div class="col-md-6 p-md-3">
                        <div class="form-group d-flex align-items-center justify-content-between col-md-12 mb-4 mt-2">
                            <p class="m-0 fw-bold">Shipping Details :</p>
                            <div class="checkbox d-flex align-items-center">
                                <input type="checkbox" name="same-as-billing" id="same-as-bill">
                                <label for="same-as-bill">Same as billing address</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4 mb-4">
                                <input type="hidden" name="ship-code-1" id="ship-code-1" placeholder="" value="<?php echo $shipCode; ?>" required>
                                <input type="text" name="ship-code-2" id="ship-code-2" placeholder="" value="<?php echo $shipCode; ?>" disabled required>
                                <label for="ship-code">Ship Code<span class="required">*</span></label>
                            </div>

                            <?php
                            // fetching shipping data 
                            include 'db-conn.php';
                            $fetchShipSql = "SELECT * FROM `sales_order_ship_add` WHERE `SOS_CODE`='$shipCode' AND `SOS_SO_CODE`='$SOCode'";
                            $fetchShipRes = mysqli_query($conn, $fetchShipSql);
                            if ($fetchShipRes && $fetchShipRes->num_rows > 0) {
                                $shipData = $fetchShipRes->fetch_assoc();
                                echo '
                                    <div class="form-group col-md-8 mb-4">
                                        <input type="text" name="ship-name" id="ship-name" placeholder="" value="' . $shipData['SOS_NAME'] . '" required>
                                        <label for="name">Name<span class="required">*</span></label>
                                    </div>
                                    <div class="form-group col-md-4 mb-4">
                                        <input type="email" name="ship-email" id="ship-email" placeholder="" value="' . $shipData['SOS_EMAIL'] . '" required>
                                        <label for="email">Email<span class="required">*</span></label>
                                    </div>
                                    <div class="form-group col-md-4 mb-4">
                                        <input type="number" class="number" class="number" name="ship-phone" id="ship-phone" placeholder="" value="' . $shipData['SOS_PHONE_NO'] . '" required>
                                        <label for="phone">Phone No<span class="required">*</span></label>
                                    </div>
                                    <div class="form-group col-md-4 mb-4">
                                        <select id="ship-country" name="ship-country" required>
                                            <option  value="' . $shipData['SOS_STATE'] . '" selected>' . $shipData['SOS_STATE'] . '</option>
                                            <option value="India" selected>India</option>
                                        </select>
                                        <label for="country">
                                            Country<span class="required">*</span>
                                        </label>
                                    </div>
                                    <div class="form-group col-md-4 mb-4">
                                        <select id="ship-state" name="ship-state" required>
                                            <option  value="' . $shipData['SOS_STATE'] . '"  selected>' . $shipData['SOS_STATE'] . '</option>
                                            <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                            <option value="Andhra Pradesh">Andhra Pradesh</option>
                                            <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                            <option value="Assam">Assam</option>
                                            <option value="Bihar">Bihar</option>
                                            <option value="Chandigarh">Chandigarh</option>
                                            <option value="Chhattisgarh">Chhattisgarh</option>
                                            <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                                            <option value="Delhi">Delhi</option>
                                            <option value="Goa">Goa</option>
                                            <option value="Gujarat">Gujarat</option>
                                            <option value="Haryana">Haryana</option>
                                            <option value="Himachal Pradesh">Himachal Pradesh</option>
                                            <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                            <option value="Jharkhand">Jharkhand</option>
                                            <option value="Karnataka">Karnataka</option>
                                            <option value="Kerala">Kerala</option>
                                            <option value="Ladakh">Ladakh</option>
                                            <option value="Lakshadweep">Lakshadweep</option>
                                            <option value="Madhya Pradesh">Madhya Pradesh</option>
                                            <option value="Maharashtra">Maharashtra</option>
                                            <option value="Manipur">Manipur</option>
                                            <option value="Meghalaya">Meghalaya</option>
                                            <option value="Mizoram">Mizoram</option>
                                            <option value="Nagaland">Nagaland</option>
                                            <option value="Odisha">Odisha</option>
                                            <option value="Puducherry">Puducherry</option>
                                            <option value="Punjab">Punjab</option>
                                            <option value="Rajasthan">Rajasthan</option>
                                            <option value="Sikkim">Sikkim</option>
                                            <option value="Tamil Nadu">Tamil Nadu</option>
                                            <option value="Telangana">Telangana</option>
                                            <option value="Tripura">Tripura</option>
                                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                                            <option value="Uttarakhand">Uttarakhand</option>
                                            <option value="West Bengal">West Bengal</option>
                                        </select>
                                        <label for="ship-country">
                                            State<span class="required">*</span>
                                        </label>
                                    </div>
                                    <div class="form-group col-md-4 mb-4">
                                        <input type="text" name="ship-city" id="ship-city" placeholder="" value="' . $shipData['SOS_CITY'] . '">
                                        <label for="ship-city">City<span class="required">*</span></label>
                                    </div>
                                    <div class="form-group col-md-4 mb-4">
                                        <input type="number" class="number" name="ship-pincode" id="ship-pincode" placeholder="" value="' . $shipData['SOS_PINCODE'] . '" required>
                                        <label for="ship-pincode">Postal Code<span class="required">*</span></label>
                                    </div>
                                    <div class="form-group col-md-12 mb-4">
                                        <input type="text" name="ship-address1" id="ship-address1" placeholder="" value="' . $shipData['SOS_ADDRESS_1'] . '" required>
                                        <label for="ship-address1">Address line 1<span class="required">*</span></label>
                                    </div>
                                    <div class="form-group col-md-12 mb-4">
                                        <input type="text" name="ship-address2" id="ship-address2" placeholder="" value="' . $shipData['SOS_ADDRESS_2'] . '">
                                        <label for="ship-address2">Address line 2</label>
                                    </div>
                                ';
                            }



                            ?>
                        </div>
                    </div>
                </div>

                <hr class="m-0">
                <div class="form-group col-md-12 mb-4 mt-2">
                    <p class="m-0 fw-bold">Currency Details :</p>
                </div>
                <div class="row">
                    <div class="form-group col-md-5 mb-4">
                        <select id="currency" name="currency" required>
                            <option value="<?php echo $currency; ?>" selected><?php echo $curName . '(' . $curSymbol . ')'; ?></option>
                            <?php
                            echo $CurrOptionsHtml;
                            ?>
                        </select>
                        <label for="currency">
                            Currency<span class="required">*</span>
                        </label>
                    </div>
                </div>


                <hr>
                <div class="form-group col-md-12 mb-4 mt-2">
                    <p class="m-0 fw-bold">Product Details :</p>
                </div>
                <div class="form-group col-md-12 mb-4 mt-2 product-table">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">PRODUCT NAME</th>
                                <th scope="col">PRICE</th>
                                <th scope="col">UOM</th>
                                <th scope="col">QNT</th>
                                <th scope="col">DISC(VAL)</th>
                                <th scope="col">TOTAL</th>
                                <th scope="col">GST(%)</th>
                                <th scope="col">GST VAL</th>
                                <th scope="col">TOTAL + GST</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>

                        <?php
                        // fetching product data 
                        include 'db-conn.php';
                        $fetchProSql = "SELECT * FROM `sales_order_item` WHERE `SOI_SO_CODE`='$SOCode'";
                        $fetchProRes = mysqli_query($conn, $fetchProSql);

                        $totalProduct = $fetchProRes->num_rows;

                        echo '
                            <!-- input field for total product rows  -->
                            <input type="hidden" name="total-products" id="total-products" value="' . $totalProduct . '">
                        ';
                        ?>


                        <div class="select-options" style="visibility: hidden; opacity:0;display:none;">
                            <select id="select-options" name="select-options">
                                <?php

                                include 'db-conn.php';
                                $getProSql = "SELECT PRO_NAME, PRO_CODE FROM `product`";
                                $getProResult = mysqli_query($conn, $getProSql);
                                $proArry = array();
                                if ($getProResult && $getProResult->num_rows > 0) {
                                    while ($proData = $getProResult->fetch_assoc()) {
                                        $proArry[] = '<option value="' . $proData['PRO_CODE'] . '">' . $proData['PRO_NAME'] . '</option>';
                                    }
                                }

                                $proOptionsHtml = '';
                                foreach ($proArry as $optionHtml) {
                                    $proOptionsHtml .= $optionHtml;
                                }

                                $conn->close();

                                echo $proOptionsHtml;
                                ?>

                            </select>
                        </div>


                        <tbody class="product-table">

                            <?php

                            $proCount = 0;
                            // fetching product data 
                            include 'db-conn.php';
                            $fetchProSql = "SELECT * FROM `sales_order_item` WHERE `SOI_SO_CODE`='$SOCode'";
                            $fetchProRes = mysqli_query($conn, $fetchProSql);
                            if ($fetchProRes && $fetchProRes->num_rows > 0) {
                                while ($proData = $fetchProRes->fetch_assoc()) {
                                    $proCode = $proData['SOI_PRO_CODE'];
                                    $proName = '';
                                    $proUOM = '';

                                    $sql = "SELECT * FROM `product` WHERE `PRO_CODE`='$proCode'";
                                    $result = mysqli_query($conn, $sql);
                                    if ($result && $result->num_rows > 0) {
                                        while ($data = $result->fetch_assoc()) {
                                            $proName = $data['PRO_NAME'];
                                            $proUOM = $data['PRO_UOM'];
                                            $proMaxDisc = $data['PRO_MAX_DISCOUNT'];
                                        }
                                    }
                                    $proCount++;
                                    echo '
                                    <tr>
                                        <td class="">
                                            <div class="form-group">
                                                <select id="product-name-' . $proCount . '" name="product-name-' . $proCount . '" required onchange="productData(this)">
                                                    <option value="' . $proData['SOI_PRO_CODE'] . '" selected>' . $proName . '</option>
                                                    ' . $proOptionsHtml . '
                                                </select>
                                            </div>
                                        </td>
                                        <td class="">
                                            <div class="form-group">
                                                <input type="text" name="pro-price-' . $proCount . '" id="pro-price-' . $proCount . '" placeholder="" value="' . $proData['SOI_PRO_PRICE'] . '" required>
                                            </div>
                                        </td>
                                        <td class="">
                                            <div class="form-group">
                                                <input type="text" name="pro-uom-' . $proCount . '" id="pro-uom-' . $proCount . '" placeholder="" value="' . $proUOM . '" required>
                                            </div>
                                        </td>
                                        <td class="text-center d-flex justify-content-center align-content-center quantity">
                                            <button type="button" class="decrese">-</button>
                                            <span class="qtty">
                                                <div class="form-group">
                                                    <input class="number" type="number" name="pro-quantity-' . $proCount . '" id="pro-quantity-' . $proCount . '" placeholder="" value="' . $proData['SOI_PRO_QUANTITY'] . '" required>
                                                </div>
                                            </span>
                                            <button type="button" class="increse">+</button>
                                        </td>
                                        <td class="">
                                            <div class="form-group">
                                                <input class="number discount" type="hidden" name="pro-max-discount-' . $proCount . '" id="pro-max-discount-' . $proCount . '" placeholder="" value="' . $proMaxDisc . '">
                                                <input class="number discount" type="number" name="pro-discount-' . $proCount . '" id="pro-discount-' . $proCount . '" minlength="0" min="0" value="' . $proData['SOI_DISCOUNT'] . '" oninput="addDiscount(this)" placeholder="">
                                            </div>
                                        </td>
                                        <td class="">
                                            <div class="form-group">
                                                <input type="text" name="pro-total-without-gst-' . $proCount . '" id="pro-total-without-gst-' . $proCount . '" placeholder="" value="' . $proData['SOI_TOTAL_WITHOUT_GST'] . '" required>
                                            </div>
                                        </td>
                                        <td class="">
                                            <div class="form-group">
                                                <input type="text" name="pro-gst-' . $proCount . '" id="pro-gst-' . $proCount . '" placeholder="" value="' . $proData['SOI_GST'] . '" required>
                                            </div>
                                        </td>
                                        <td class="">
                                            <div class="form-group">
                                                <input class="number" type="text" name="pro-gst-val-' . $proCount . '" id="pro-gst-val-' . $proCount . '" placeholder="" value="' . $proData['SOI_GST_VAL'] . '" required>
                                            </div>
                                        </td>
                                        <td class="t-price">
                                            <div class="form-group">
                                                <input class="number" type="text" name="pro-t-price-' . $proCount . '" id="pro-t-price-' . $proCount . '" placeholder="" value="' . $proData['SOI_TOTAL_WITH_GST'] . '" required>
                                            </div>
                                        </td>
                                        <td class="p-2">
                                            <button type="button" class="delete" onclick="deleteRow(this)"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                    </tr>
                                ';
                                }
                            }
                            ?>
                            <tr>
                                <td colspan="10">
                                    <div class="text-lg-end ">
                                        <button type="button" class="add-row update ms-auto" onclick="addNewRow()">Add Row +</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="grand-total text-end">
                        <h5 class="mb-0">Total :
                            <input type="hidden" name="grand-total-1" id="grand-total-1" value="<?php echo $grandTotalPrice; ?>">
                            <input type="text" name="grand-total-2" id="grand-total-2" value="<?php echo $grandTotalPrice; ?>" disabled>
                        </h5>
                    </div>
                </div>

            </div>

            <div class="button mt-2">
                <button class="save" type="submit">Update & Preview Invoice</button>
            </div>
    </form>
</div>

<!-- <script>
    // Function to auto update grand total
    function updateGrandTotal() {
        let total = 0;
        document.querySelectorAll('input[name^="pro-t-price-"]').forEach(input => {
            let val = parseFloat(input.value) || 0;
            total += val;
        });
        document.getElementById('grand-total-1').value = total.toFixed(2);
        document.getElementById('grand-total-2').value = total.toFixed(2);
    }

    // adding deleting and upating rows
    try {

        // updating row input and select when row is added or deleted
        function updateRow() {

            let tbody = document.querySelector('tbody.product-table');
            let rows = Array.from(tbody.querySelectorAll('tr')).filter((row, idx, arr) => idx < arr.length - 1);

            rows.forEach((row, idx) => {
                let rowNum = idx + 1;
                // document.getElementById('total-products').value = rowNum;

                // Update product select
                let select = row.querySelector('select[name^="product-name-"]');
                if (select) {
                    select.name = `product-name-${rowNum}`;
                    select.id = `product-name-${rowNum}`;
                }

                // Update price input
                let price = row.querySelector('input[name^="pro-price-"]');
                if (price) {
                    price.name = `pro-price-${rowNum}`;
                    price.id = `pro-price-${rowNum}`;
                }

                // Update uom input
                let uom = row.querySelector('input[name^="pro-uom-"]');
                if (uom) {
                    uom.name = `pro-uom-${rowNum}`;
                    uom.id = `pro-uom-${rowNum}`;
                }

                // Update gst input
                let gst = row.querySelector('input[name^="pro-gst-"]');
                if (gst) {
                    gst.name = `pro-gst-${rowNum}`;
                    gst.id = `pro-gst-${rowNum}`;
                }

                // Update quantity input
                let qty = row.querySelector('input[name^="pro-quantity-"]');
                if (qty) {
                    qty.name = `pro-quantity-${rowNum}`;
                    qty.id = `pro-quantity-${rowNum}`;
                }

                // Update discount input
                let dsc = row.querySelector('input[name^="pro-discount-"]');
                if (dsc) {
                    dsc.name = `pro-discount-${rowNum}`;
                    dsc.id = `pro-discount-${rowNum}`;
                }

                // Update total price input
                let tprice = row.querySelector('input[name^="pro-t-price-"]');
                if (tprice) {
                    tprice.name = `pro-t-price-${rowNum}`;
                    tprice.id = `pro-t-price-${rowNum}`;
                }

            });
            //seting total products input
            document.getElementById('total-products').value = rows.length;

            updateGrandTotal();
        }


        //adding new row when clicked 
        function addNewRow() {
            let tbody = document.querySelector('tbody.product-table');
            let rows = tbody.querySelectorAll('tr');

            // The next product number
            let nextProductNum = rows.length;

            // Getting the product options HTML from the first select 
            let firstSelect = document.querySelector('select[name^="product-name-"]');
            let optionsHtml = firstSelect ? firstSelect.innerHTML : '';

            // new row 
            let newRow = document.createElement('tr');
            newRow.innerHTML = `
                                    <td class="">
                                        <div class="form-group">
                                            <select id="product-name-${nextProductNum}" name="product-name-${nextProductNum}" required onchange="productData(this)">
                                                ${optionsHtml}
                                            </select>
                                        </div>
                                    </td>
                                    <td class="">
                                        <div class="form-group">
                                            <input type="text" name="pro-price-${nextProductNum}" id="pro-price-${nextProductNum}" placeholder="" required>
                                        </div>
                                    </td>
                                    <td class="">
                                        <div class="form-group">
                                            <input type="text" name="pro-uom-${nextProductNum}" id="pro-uom-${nextProductNum}" placeholder="" required>
                                        </div>
                                    </td>
                                    <td class="">
                                        <div class="form-group">
                                            <input type="text" name="pro-gst-${nextProductNum}" id="pro-gst-${nextProductNum}" placeholder="" required>
                                        </div>
                                    </td>
                                    <td class="">
                                        <div class="form-group">
                                            <input class="number discount" type="hidden" name="pro-max-discount-${nextProductNum}" id="pro-max-discount-${nextProductNum}" placeholder="">
                                            <input class="number discount" type="number" name="pro-discount-${nextProductNum}" id="pro-discount-${nextProductNum}" oninput="addDiscount(this)" placeholder="" >
                                        </div>
                                    </td>
                                    <td class="text-center d-flex justify-content-center align-content-center quantity">
                                        <button type="button" class="decrese">-</button>
                                        <span class="qtty">
                                            <div class="form-group">
                                                <input class="number" type="number" name="pro-quantity-${nextProductNum}" id="pro-quantity-${nextProductNum}" placeholder="" required>
                                            </div>
                                        </span>
                                        <button type="button" class="increse">+</button>
                                    </td>
                                    <td class="t-price">
                                        <div class="form-group">
                                            <input class="number" type="text" name="pro-t-price-${nextProductNum}" id="pro-t-price-${nextProductNum}" placeholder="" required>
                                        </div>
                                    </td>
                                    <td class="">
                                        <button type="button" class="delete" onclick="deleteRow(this)"><i class="fa-solid fa-trash"></i></button>
                                    </td>
            `;

            // adding new row 
            let allRows = tbody.querySelectorAll('tr');
            tbody.insertBefore(newRow, allRows[allRows.length - 1]);
            updateRow();

        }

        // deleting row when clicked
        function deleteRow(e) {
            const currRow = e.parentNode.parentNode;
            currRow.remove();
            // console.log(currRow);
            updateRow();
        }
    } catch (err) {
        console.log(err);
    }



    //displaying product delatils when prodduct is selected
    try {

        //displaying product data when selected
        function productData(e) {

            // console.log(e.value);
            // console.log(e.name.split('-').length);
            let productCode = e.value;
            let proNameLen = e.name.split('-').length;
            let proNo = Number(e.name.split('-')[proNameLen - 1]);

            {
                let result = new XMLHttpRequest();
                result.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Parse JSON response
                        let data = JSON.parse(this.responseText);
                        // console.log(data);
                        let totalPrice = Number(data.PRO_PRICE) + (Number(data.PRO_PRICE) * (Number(data.SGST) / 100));

                        document.getElementById(`pro-price-${proNo}`).value = data.PRO_PRICE || '';
                        document.getElementById(`pro-uom-${proNo}`).value = data.PRO_UOM || '';
                        document.getElementById(`pro-gst-${proNo}`).value = data.SGST + '%' || '';
                        document.getElementById(`pro-quantity-${proNo}`).value = 1;
                        document.getElementById(`pro-max-discount-${proNo}`).value = data.PRO_MAX_DISCOUNT;
                        document.getElementById(`pro-discount-${proNo}`).value = '';
                        document.getElementById(`pro-t-price-${proNo}`).value = totalPrice;


                        // updating grand total
                        updateGrandTotal();
                    }
                };
                result.open("GET", "/Office/Browz Invoice/php/fetch-pro-data.php?query=" + productCode, true);
                result.send();
            }


            // console.log(typeof (proNo));

        }

    } catch (err) {
        console.log(err);
    }

    // Helper function to calculate total with discount
    function calculateDiscountedTotal(row) {
        let priceInput = row.querySelector('input[name^="pro-price-"]');
        let qtyInput = row.querySelector('input[name^="pro-quantity-"]');
        let gstInput = row.querySelector('input[name^="pro-gst-"]');
        let disInput = parseFloat(row.querySelector('input[name^="pro-discount-"]').value) || 0;
        let tPriceInput = row.querySelector('input[name^="pro-t-price-"]');

        let price = parseFloat(priceInput.value) || 0;
        let qty = parseInt(qtyInput.value) || 0;
        let gst = parseFloat((gstInput.value || '0').replace('%', '')) || 0;
        let total = qty * price * (1 + gst / 100);
        let discountedTotal = total - (disInput * qty);
        if (discountedTotal < 0) discountedTotal = 0;
        tPriceInput.value = discountedTotal.toFixed(2);
    }

    try {
        // Delegate event to tbody for dynamic rows
        document.querySelector('tbody.product-table').addEventListener('click', function(e) {
            // Increase quantity
            if (e.target.classList.contains('increse')) {
                let row = e.target.closest('tr');
                let qtyInput = row.querySelector('input[name^="pro-quantity-"]');
                let qty = parseInt(qtyInput.value) || 0;
                qty++;
                qtyInput.value = qty;

                // Calculate total price with discount
                calculateDiscountedTotal(row);

                // updating grand total
                updateGrandTotal();
            }

            // Decrease quantity
            if (e.target.classList.contains('decrese')) {
                let row = e.target.closest('tr');
                let qtyInput = row.querySelector('input[name^="pro-quantity-"]');
                let qty = parseInt(qtyInput.value) || 0;
                if (qty > 1) {
                    qty--;
                    qtyInput.value = qty;

                    // Calculate total price with discount
                    calculateDiscountedTotal(row);

                    // updating grand total
                    updateGrandTotal();
                }
            }
        });
    } catch (err) {
        console.log(err);
    }

    // changing total price input for product discount
    try {
        function addDiscount(e) {
            let row = e.closest('tr');
            let maxDiscount = parseInt(row.querySelector('input[name^="pro-max-discount-"]').value);
            let discount = row.querySelector('input[name^="pro-discount-"]');
            let discountValue = discount.value.trim();
            let proNameInput = row.querySelector('select[name^="product-name-"]');

            if (proNameInput && proNameInput.value !== '') {
                // If empty or zero, treat as no discount
                if (discountValue === '' || Number(discountValue) === 0) {
                    discount.value = '';
                    calculateDiscountedTotal(row); // will use 0 as discount
                }
                // If valid positive number and within maxDiscount
                else if (!isNaN(discountValue) && Number(discountValue) > 0 && Number(discountValue) <= maxDiscount) {
                    calculateDiscountedTotal(row);
                }
                // If negative or above maxDiscount or not a number
                else {
                    alert('Discount must be a number between 0 and ' + maxDiscount);
                    discount.value = '';
                    calculateDiscountedTotal(row); // reset to original amount
                }
                updateGrandTotal();
            }
        }
    } catch (err) {
        console.log(err);
    }



    // making auto complete off for all the inputs
    try {
        let inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.autocomplete = 'off';
        });
    } catch (err) {
        console.log(err);
    }
</script> -->

<script src="sales-order.js"></script>

<?php include "footer.php"; ?>