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
        padding: 5px 2px;
        min-width: 30px;
        /* max-width: 100px; */
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
        padding: 7px 2px;
    }

    table td input {
        position: relative;
        z-index: -1;
    }

    .discount,
    .desc,
    .quant {
        z-index: 5;
    }

    .table>:not(caption)>*>* {
        padding: 7px 0px;
    }

    .table:not(.table-borderless) thead th {
        padding: .5rem .7rem;
        font-size: 14px;
    }

    .border-right {
        border-right: 1px solid #dee2e6 !important;
    }

    @media (max-width:768px) {

        #grand-total-1,
        #grand-total-2 {
            width: 50%;
        }
    }
</style>

<!-- <a href="customer-page.php"><button class="back" type="button"><i class="fa-solid fa-arrow-left me-1"></i>Back</button></a> -->
<div class="add-form  text-capitalize">
    <form action="\Office\Browz Invoice\php\handle-sales-order.php" method="post" class="shadow p-sm-5 py-5 p-3 " autocomplete="off" style="background-color: white;">
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
                    <h3 class="m-0">Invoice</h3>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group col-md-6 ms-auto mb-4">
                    <?php

                    $curYear = date('Y');
                    // echo $curYear;

                    // AUTO GENERATING CUSTOMER CODE BY FINDING THE LAST CUSTOMER CODE
                    include 'db-conn.php';

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

                    $soCode = 'INV' . (string)$curYear . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
                    // echo $customerCode;

                    echo '
                        <div class="col-md-12 pe-3">
                            <input type="hidden" name="so-code-1" id="so-code-1" placeholder="" value="' . $soCode . '" >
                            <input type="text" name="so-code-2" id="so-code-2" placeholder="" value="' . $soCode . '" disabled >
                            <label for="so-code">Txn No.<span class="required">*</span></label>
                        </div>
                    ';

                    $conn->close();
                    ?>
                </div>
            </div>
        </div>

        <hr class="m-0">

        <div class="row">
            <div class="form-group col-md-12 mb-4 mt-2">
                <p class="m-0 fw-bold">Customer Details :</p>
            </div>
            <div class="search-cust form-group col-md-12 mb-4">
                <div class="row">
                    <div class="col-md-3 pe-3">
                        <input type="text" id="search-cust" placeholder="" value="">
                        <label for="search-cust"><i class="fa-solid fa-magnifying-glass me-2"></i>Search Customer</label>

                        <!-- displaying customer searchs  -->
                        <div id="searched-customers-table" class="searched-customers-table d-none p-3 bg-light"></div>
                    </div>
                    <div class="col-md-3">
                        <button id="show-add-new-cust-form" class="update" type="button" title="Click if new customer"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
            </div>
            <div class="cust-details d-none col-12">
                <div class="row">
                    <div class="form-group col-md-3 mb-4">
                        <input type="hidden" name="cust-code-1" id="cust-code-1" placeholder="" value="" required>
                        <input type="text" name="cust-code-2" id="cust-code-2" placeholder="" value="" disabled required>
                        <label for="cust-code">Customer Code<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-3 mb-4">
                        <input type="text" name="fname" id="fname" placeholder="">
                        <label for="fname">First Name<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-3 mb-4">
                        <input type="text" name="mname" id="mname" placeholder="">
                        <label for="mname">Middle Name</label>
                    </div>
                    <div class="form-group col-md-3 mb-4">
                        <input type="text" name="lname" id="lname" placeholder="">
                        <label for="lname">Last Name<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-3 mb-4">
                        <input type="text" class="number" name="gstin" id="gstin" placeholder="">
                        <label for="gstin">GSTIN No</label>
                    </div>
                    <div class="form-group col-md-3 mb-4">
                        <input type="email" name="email" id="email" placeholder="">
                        <label for="email">Email<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-3 mb-4">
                        <input type="number" class="number" class="number" name="phone" id="phone" placeholder="">
                        <label for="phone">Phone No<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-3 mb-4">
                        <select id="country" name="country">
                            <!-- <option value="" disabled selected hidden></option> -->
                            <option value="India" selected>India</option>
                        </select>
                        <label for="country">
                            Country<span class="required">*</span>
                        </label>
                    </div>
                    <div class="form-group col-md-3 mb-4">
                        <select id="state" name="state" required>
                            <option value="" disabled selected hidden> </option>
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
                        <input type="text" name="city" id="city" placeholder="">
                        <label for="city">City<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-3 mb-4">
                        <input type="number" class="number" name="pincode" id="pincode" placeholder="">
                        <label for="pincode">Postal Code<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-6 mb-4">
                        <input type="text" name="address1" id="address1" placeholder="">
                        <label for="address1">Address line 1<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-6 mb-4">
                        <input type="text" name="address2" id="address2" placeholder="">
                        <label for="address2">Address line 2</label>
                    </div>
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
                                <input type="hidden" name="bill-code-1" id="bill-code-1" placeholder="" required>
                                <input type="text" name="bill-code-2" id="bill-code-2" placeholder="" disabled required>
                                <label for="bill-code">Bill Code<span class="required">*</span></label>
                            </div>
                            <div class="form-group col-md-8 mb-4">
                                <input type="text" name="bill-name" id="bill-name" placeholder="" required>
                                <label for="bil-name">Name<span class="required">*</span></label>
                            </div>
                            <div class="form-group col-md-4 mb-4">
                                <input type="email" name="bill-email" id="bill-email" placeholder="" required>
                                <label for="bill-email">Email<span class="required">*</span></label>
                            </div>
                            <div class="form-group col-md-4 mb-4">
                                <input type="number" class="number" class="number" name="bill-phone" id="bill-phone" placeholder="" required>
                                <label for="bill-phone">Phone No<span class="required">*</span></label>
                            </div>
                            <div class="form-group col-md-4 mb-4">
                                <select id="bill-country" name="bill-country" required>
                                    <option value="India" selected>India</option>
                                </select>
                                <label for="bill-country">
                                    Country<span class="required">*</span>
                                </label>
                            </div>
                            <div class="form-group col-md-4 mb-4">
                                <select id="bill-state" name="bill-state" required>
                                    <option value="" disabled selected hidden> </option>
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
                                <input type="text" name="bill-city" id="bill-city" placeholder="">
                                <label for="bill-city">City<span class="required">*</span></label>
                            </div>
                            <div class="form-group col-md-4 mb-4">
                                <input type="number" class="number" name="bill-pincode" id="bill-pincode" placeholder="" required>
                                <label for="bill-pincode">Postal Code<span class="required">*</span></label>
                            </div>
                            <div class="form-group col-md-12 mb-4">
                                <input type="text" name="bill-address1" id="bill-address1" placeholder="" required>
                                <label for="bill-address1">Address line 1<span class="required">*</span></label>
                            </div>
                            <div class="form-group col-md-12 mb-4">
                                <input type="text" name="bill-address2" id="bill-address2" placeholder="">
                                <label for="bill-address2">Address line 2</label>
                            </div>
                        </div>
                        <!-- <hr> -->
                    </div>
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
                                <input type="hidden" name="ship-code-1" id="ship-code-1" placeholder="" required>
                                <input type="text" name="ship-code-2" id="ship-code-2" placeholder="" disabled required>
                                <label for="ship-code">Ship Code<span class="required">*</span></label>
                            </div>
                            <div class="form-group col-md-8 mb-4">
                                <input type="text" name="ship-name" id="ship-name" placeholder="" required>
                                <label for="name">Name<span class="required">*</span></label>
                            </div>
                            <div class="form-group col-md-4 mb-4">
                                <input type="email" name="ship-email" id="ship-email" placeholder="" required>
                                <label for="email">Email<span class="required">*</span></label>
                            </div>
                            <div class="form-group col-md-4 mb-4">
                                <input type="number" class="number" class="number" name="ship-phone" id="ship-phone" placeholder="" required>
                                <label for="phone">Phone No<span class="required">*</span></label>
                            </div>
                            <div class="form-group col-md-4 mb-4">
                                <select id="ship-country" name="ship-country" required>
                                    <!-- <option value="" disabled selected hidden></option> -->
                                    <option value="India" selected>India</option>
                                </select>
                                <label for="country">
                                    Country<span class="required">*</span>
                                </label>
                            </div>
                            <div class="form-group col-md-4 mb-4">
                                <select id="ship-state" name="ship-state" required>
                                    <option value="" disabled selected hidden> </option>
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
                                <input type="text" name="ship-city" id="ship-city" placeholder="">
                                <label for="ship-city">City<span class="required">*</span></label>
                            </div>
                            <div class="form-group col-md-4 mb-4">
                                <input type="number" class="number" name="ship-pincode" id="ship-pincode" placeholder="" required>
                                <label for="ship-pincode">Postal Code<span class="required">*</span></label>
                            </div>
                            <div class="form-group col-md-12 mb-4">
                                <input type="text" name="ship-address1" id="ship-address1" placeholder="" required>
                                <label for="ship-address1">Address line 1<span class="required">*</span></label>
                            </div>
                            <div class="form-group col-md-12 mb-4">
                                <input type="text" name="ship-address2" id="ship-address2" placeholder="">
                                <label for="ship-address2">Address line 2</label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <hr>
            <div class="form-group col-md-12 mb-4 mt-2">
                <p class="m-0 fw-bold">Currency Details :</p>
            </div>
            <div class="row">
                <div class="form-group col-md-5 mb-4">
                    <select id="currency" name="currency" required>
                        <option value="" selected disabled hidden></option>
                        <?php

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
                            <th scope="col">PRODUCT DESC</th>
                            <th scope="col">QNT</th>
                            <th scope="col">PRICE</th>
                            <th scope="col">UOM</th>
                            <th scope="col">DISC(VAL)</th>
                            <th scope="col">TOTAL</th>
                            <th scope="col">GST(%)</th>
                            <th scope="col">GST VAL</th>
                            <th scope="col">TOTAL + GST</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>

                    <!-- input field for total product rows  -->
                    <input type="hidden" name="total-products" id="total-products" value="1">

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
                        <tr>
                            <td class="">
                                <div class="form-group">
                                    <select id="product-name-1" name="product-name-1" required onchange="productData(this)">
                                        <option value="" disabled selected hidden>Select Product---</option>
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
                            </td>
                            <td class="">
                                <div class="form-group">
                                    <input class="desc" type="text" name="pro-desc-1" id="pro-desc-1" placeholder="" required>
                                </div>
                            </td>
                            <td class="text-center d-flex justify-content-center align-content-center quantity">
                                <button type="button" class="decrese me-0">-</button>
                                <span class="qtty">
                                    <div class="form-group">
                                        <input class="number quant" type="number" name="pro-quantity-1" id="pro-quantity-1" placeholder="" required>
                                    </div>
                                </span>
                                <button type="button" class="increse ms-0">+</button>
                            </td>
                            <td class="">
                                <div class="form-group">
                                    <input type="text" name="pro-price-1" id="pro-price-1" placeholder="" required>
                                </div>
                            </td>
                            <td class="">
                                <div class="form-group">
                                    <input type="text" name="pro-uom-1" id="pro-uom-1" placeholder="" required>
                                    <input type="hidden" name="pro-hsn-1" id="pro-hsn-1" placeholder="">
                                </div>
                            </td>
                            <td class="">
                                <div class="form-group">
                                    <input class="number discount" type="hidden" name="pro-max-discount-1" id="pro-max-discount-1" placeholder="">
                                    <input class="number discount" type="number" name="pro-discount-1" id="pro-discount-1" minlength="0" oninput="addDiscount(this)" placeholder="">
                                </div>
                            </td>
                            <td class="">
                                <div class="form-group">
                                    <input type="text" name="pro-total-without-gst-1" id="pro-total-without-gst-1" placeholder="" required>
                                </div>
                            </td>
                            <td class="">
                                <div class="form-group">
                                    <input type="text" name="pro-gst-1" id="pro-gst-1" placeholder="" required>
                                </div>
                            </td>
                            <td class="">
                                <div class="form-group">
                                    <input class="number" type="text" name="pro-gst-val-1" id="pro-gst-val-1" placeholder="" required>
                                </div>
                            </td>
                            <td class="t-price">
                                <div class="form-group">
                                    <input class="number" type="text" name="pro-t-price-1" id="pro-t-price-1" placeholder="" required>
                                </div>
                            </td>
                            <td class="p-1 text-center">
                                <button type="button" class="delete" onclick="deleteRow(this)"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="11">
                                <div class="text-lg-end ">
                                    <button type="button" class="add-row update ms-auto" onclick="addNewRow()">Add Row +</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="grand-total text-md-end">
                    <h5 class="mb-0">Total :
                        <input type="hidden" name="grand-total-1" id="grand-total-1" value="00.00">
                        <input type="text" name="grand-total-2" id="grand-total-2" value="00.00" disabled>
                    </h5>
                </div>
            </div>

        </div>

        <div class="button mt-2">
            <!-- <button class="update" type="button">Preview Invoice</button> -->
            <button class="save" type="submit">Save & Preview Invoice</button>
            <!-- <a href="#"><button type="reset" class="cancel" type="button">Cancel</button></a> -->
        </div>
    </form>
</div>


<script src="/Office/Browz Invoice/pages/sales-order.js"></script>

<?php include "footer.php"; ?>