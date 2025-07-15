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
</style>

<div class="add-form py-5">
    <form action="\Office\Browz Invoice\php\handle-update-customer.php" method="post" class="shadow p-sm-5 py-5 p-3 mx-sm-5" style="background-color: white;">
        <div class="form-heading mb-5">
            <h3 class="m-0">Update Customer</h3>
        </div>

        <div class="alert-box">
            <?php
            $message = false;
            $error = false;

            if (isset($_GET['u']) && $_GET['u'] == '1') {
                $message = 'Customer updated successfully!';
            } else if (isset($_GET['u']) && $_GET['u'] == '0') {
                $error = 'Fail to update customer, please try again';
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


        <?php

        $updateCustomer = (isset($_GET['update']) ? $_GET['update'] : '');

        include 'db-conn.php';
        $updateSql = "SELECT * FROM `customer` WHERE `CUST_CODE`='$updateCustomer' LIMIT 1";
        $updateResult = mysqli_query($conn, $updateSql);
        $billCode;
        $shipCode;
        if ($updateResult && $updateResult->num_rows > 0) {
            while ($data = $updateResult->fetch_assoc()) {
                $name = trim($data['CUST_FULL_NAME']);
                $name = preg_replace('/\s+/u', ' ', $name);
                $namaArray = explode(' ', $name);
                $fname = isset($namaArray[0]) ? $namaArray[0] : '';
                $lname = count($namaArray) > 1 ? $namaArray[count($namaArray) - 1] : '';
                $mname = '';
                if (count($namaArray) > 2) {
                    $mname = implode(' ', array_slice($namaArray, 1, -1));
                }

                $billCode = $data['CUST_BILLING_ADD'];
                $shipCode = $data['CUST_SHIPPING_ADD'];


                echo '
                <div class="row">
                    <div class="form-group d-flex align-items-center justify-content-between col-md-12 mb-4 mt-2">
                        <p class="m-0 fw-bold">Customer Details :</p>
                    </div>
                    <div class="form-group col-md-3 mb-4">
                        <input type="hidden" name="cust-code" id="cust-code" placeholder="" value="' . htmlspecialchars($data['CUST_CODE']) . '" required>
                        <input type="text" name="cust-code-2" id="cust-code-2" placeholder="" value="' . htmlspecialchars($data['CUST_CODE']) . '" disabled required>
                        <label for="cust-code">Customer Code<span class="required">*</span></label>
                    </div>
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
                    <div class="form-group col-md-12 mb-4">
                        <input type="text" name="address1" id="address1" placeholder="" value="' . htmlspecialchars($data['CUST_ADDRESS_1']) . '" required>
                        <label for="address1">Address line 1<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-12 mb-4">
                        <input type="text" name="address2" id="address2" placeholder="" value="' . htmlspecialchars($data['CUST_ADDRESS_2']) . '">
                        <label for="address2">Address line 2</label>
                    </div>
                </div>
                ';
            }
        }

        echo '
                <hr>

                <div class="form-group d-flex align-items-center justify-content-between col-md-12 mb-4 mt-2">
                    <p class="m-0 fw-bold">Billing Details :</p>
                    <div class="checkbox d-flex align-items-center">
                        <input type="checkbox" name="same-as-permanent" id="same-as-perm">
                        <label for="same-as-perm">Same as customers address</label>
                    </div>
                </div>
        ';

        // echo $billCode;
        // displaying billing address
        $updateBillSql = "SELECT * FROM `bill_to_address` WHERE `BILL_CODE`='$billCode'";
        $updateBillResult = mysqli_query($conn, $updateBillSql);
        if ($updateBillResult && $updateBillResult->num_rows > 0) {
            while ($data = $updateBillResult->fetch_assoc()) {
                echo '
                <div class="row">
                    <div class="form-group col-md-3 mb-4">
                        <input type="hidden" name="bill-code" id="bill-code" placeholder="" value="' . htmlspecialchars($data['BILL_CODE'])  . '" required>
                        <input type="text" name="bill-code-2" id="bill-code-2" placeholder="" value="' . htmlspecialchars($data['BILL_CODE'])  . '" disabled required>
                        <label for="bill-code">Bill Code<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-6 mb-4">
                        <input type="text" name="bill-name" id="bill-name" placeholder="" value="' . htmlspecialchars($data['BILL_NAME'])  . '" required>
                        <label for="bil-name">Name<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-3 mb-4">
                        <input type="email" name="bill-email" id="bill-email" placeholder="" value="' . htmlspecialchars($data['BILL_EMAIL'])  . '" required>
                        <label for="bill-email">Email<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-3 mb-4">
                        <input type="number" class="number" name="bill-phone" id="bill-phone" placeholder="" value="' . htmlspecialchars($data['BILL_PHONE_NO'])  . '" required>
                        <label for="bill-phone">Phone No<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-3 mb-4">
                        <select id="bill-country" name="bill-country" required>
                            <option  value="' . htmlspecialchars($data['BILL_COUNTRY'])  . '" selected>' . htmlspecialchars($data['BILL_COUNTRY'])  . '</option>
                            <option value="India" >India</option>
                        </select>
                        <label for="bill-country">
                            Country<span class="required">*</span>
                        </label>
                    </div>
                    <div class="form-group col-md-3 mb-4">
                        <select id="bill-state" name="bill-state" required>
                            <option value="' . htmlspecialchars($data['BILL_STATE'])  . '" selected>' . htmlspecialchars($data['BILL_STATE'])  . '</option>
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
                    <div class="form-group col-md-3 mb-4">
                        <input type="text" name="bill-city" id="bill-city" placeholder="" value="' . htmlspecialchars($data['BILL_CITY'])  . '">
                        <label for="bill-city">City<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-3 mb-4">
                        <input type="number" class="number" name="bill-pincode" id="bill-pincode" placeholder="" value="' . htmlspecialchars($data['BILL_POSTAL_CODE'])  . '" required>
                        <label for="bill-pincode">Postal Code<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-12 mb-4">
                        <input type="text" name="bill-address1" id="bill-address1" placeholder="" value="' . htmlspecialchars($data['BILL_ADDRESS_1'])  . '" required>
                        <label for="bill-address1">Address line 1<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-12 mb-4">
                        <input type="text" name="bill-address2" id="bill-address2" placeholder="" value="' . htmlspecialchars($data['BILL_ADDRESS_2'])  . '">
                        <label for="bill-address2">Address line 2</label>
                    </div>
                </div>
                ';
            }
        }

        echo '
            <div class="form-group d-flex align-items-center justify-content-between col-md-12 mb-4 mt-2">
                <p class="m-0 fw-bold">Shipping Details :</p>
                <div class="checkbox d-flex align-items-center">
                    <input type="checkbox" name="same-as-billing" id="same-as-bill">
                    <label for="same-as-bill">Same as billing address</label>
                </div>
            </div>
        ';

        // displaying shiping address 
        // echo $billCode;
        $updateShipSql = "SELECT * FROM `ship_to_address` WHERE `SHIP_CODE`='$shipCode'";
        $updateShipResult = mysqli_query($conn, $updateShipSql);
        if ($updateShipResult && $updateShipResult->num_rows > 0) {
            while ($data = $updateShipResult->fetch_assoc()) {
                echo '
            <div class="row">
                <div class="form-group col-md-3 mb-4">
                    <input type="hidden" name="ship-code" id="ship-code" placeholder="" value="' . htmlspecialchars($data['SHIP_CODE'])  . '" required>
                    <input type="text" name="ship-code-2" id="ship-code-2" placeholder="" value="' . htmlspecialchars($data['SHIP_CODE'])  . '" disabled required>
                    <label for="ship-code">Ship Code<span class="required">*</span></label>
                </div>
                 <div class="form-group col-md-6 mb-4">
                    <input type="text" name="ship-name" id="ship-name" placeholder=""value="' . htmlspecialchars($data['SHIP_NAME'])  . '" required>
                    <label for="name">Name<span class="required">*</span></label>
                </div>
                <div class="form-group col-md-3 mb-4">
                    <input type="email" name="ship-email" id="ship-email" placeholder=""value="' . htmlspecialchars($data['SHIP_EMAIL'])  . '" required>
                    <label for="email">Email<span class="required">*</span></label>
                </div>
                <div class="form-group col-md-3 mb-4">
                    <input type="number" class="number" name="ship-phone" id="ship-phone" placeholder=""value="' . htmlspecialchars($data['SHIP_PHONE_NO'])  . '" required>
                    <label for="phone">Phone No<span class="required">*</span></label>
                </div>
                <div class="form-group col-md-3 mb-4">
                    <select id="ship-country" name="ship-country" required>
                        <option value="' . htmlspecialchars($data['SHIP_COUNTRY'])  . '" selected >' . htmlspecialchars($data['SHIP_COUNTRY'])  . '</option>
                        <option value="India" selected>India</option>
                    </select>
                    <label for="country">
                        Country<span class="required">*</span>
                    </label>
                </div>
                <div class="form-group col-md-3 mb-4">
                    <select id="ship-state" name="ship-state" required>
                        <option value="' . htmlspecialchars($data['SHIP_STATE'])  . '" selected>' . htmlspecialchars($data['SHIP_STATE'])  . '</option>
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
                <div class="form-group col-md-3 mb-4">
                    <input type="text" name="ship-city" id="ship-city" placeholder="" value="' . htmlspecialchars($data['SHIP_CITY'])  . '" >
                    <label for="ship-city">City<span class="required">*</span></label>
                </div>
                <div class="form-group col-md-3 mb-4">
                    <input type="number" class="number" name="ship-pincode" id="ship-pincode" placeholder="" value="' . htmlspecialchars($data['SHIP_POSTAL_CODE'])  . '" required>
                    <label for="ship-pincode">Postal Code<span class="required">*</span></label>
                </div>
                <div class="form-group col-md-12 mb-4">
                    <input type="text" name="ship-address1" id="ship-address1" placeholder="" value="' . htmlspecialchars($data['SHIP_ADDRESS_1'])  . '" required>
                    <label for="ship-address1">Address line 1<span class="required">*</span></label>
                </div>
                <div class="form-group col-md-12 mb-4">
                    <input type="text" name="ship-address2" id="ship-address2" placeholder="" value="' . htmlspecialchars($data['SHIP_ADDRESS_2'])  . '">
                    <label for="ship-address2">Address line 2</label>
                </div>
            </div>
                ';
            }
        }

        ?>

        <div class="button mt-2">
            <button class="save" type="submit">Save</button>
            <a href="customer-page.php"><button class="cancel" type="button">Cancel</button></a>
        </div>
    </form>
</div>


<script>
    let sameAsPerm = document.getElementById('same-as-perm');
    let sameAsBill = document.getElementById('same-as-bill');

    sameAsPerm.addEventListener("click", () => {
        if (sameAsPerm.checked) {
            // console.log('checked');
            document.getElementById('bill-name').value = document.getElementById('fname').value + " " + document.getElementById('mname').value + ' ' + document.getElementById('lname').value;
            // document.getElementById('bill-gstin').value = document.getElementById('gstin').value;
            document.getElementById('bill-email').value = document.getElementById('email').value;
            document.getElementById('bill-phone').value = document.getElementById('phone').value;
            document.getElementById('bill-country').value = document.getElementById('country').value;
            document.getElementById('bill-state').value = document.getElementById('state').value;
            document.getElementById('bill-city').value = document.getElementById('city').value;
            document.getElementById('bill-pincode').value = document.getElementById('pincode').value;
            document.getElementById('bill-address1').value = document.getElementById('address1').value;
            document.getElementById('bill-address2').value = document.getElementById('address2').value;
        } else {
            // console.log('not checked');
            document.getElementById('bill-name').value = '';
            // document.getElementById('bill-gstin').value = '';
            document.getElementById('bill-email').value = '';
            document.getElementById('bill-phone').value = '';
            document.getElementById('bill-country').value = '';
            document.getElementById('bill-state').value = '';
            document.getElementById('bill-city').value = '';
            document.getElementById('bill-pincode').value = '';
            document.getElementById('bill-address1').value = '';
            document.getElementById('bill-address2').value = '';
        }
    });

    sameAsBill.addEventListener("click", () => {
        if (sameAsBill.checked) {
            // console.log('checked');
            document.getElementById('ship-name').value = document.getElementById('bill-name').value;
            document.getElementById('ship-email').value = document.getElementById('bill-email').value;
            document.getElementById('ship-phone').value = document.getElementById('bill-phone').value;
            document.getElementById('ship-country').value = document.getElementById('bill-country').value;
            document.getElementById('ship-state').value = document.getElementById('bill-state').value;
            document.getElementById('ship-city').value = document.getElementById('bill-city').value;
            document.getElementById('ship-pincode').value = document.getElementById('bill-pincode').value;
            document.getElementById('ship-address1').value = document.getElementById('bill-address1').value;
            document.getElementById('ship-address2').value = document.getElementById('bill-address2').value;
        } else {
            // console.log('not checked');
            document.getElementById('ship-name').value = '';
            // document.getElementById('ship-gstin').value = '';
            document.getElementById('ship-email').value = '';
            document.getElementById('ship-phone').value = '';
            document.getElementById('ship-country').value = '';
            document.getElementById('ship-state').value = '';
            document.getElementById('ship-city').value = '';
            document.getElementById('ship-pincode').value = '';
            document.getElementById('ship-address1').value = '';
            document.getElementById('ship-address2').value = '';
        }
    });
</script>

<!-- validations  -->
<script>
    // Helper function to show/hide error messages
    function setError(input, message) {
        let errorElem = input.parentElement.querySelector('.error-message');
        if (!errorElem) {
            errorElem = document.createElement('div');
            errorElem.className = 'error-message';
            errorElem.style.color = 'red';
            errorElem.style.fontSize = '12px';
            errorElem.style.marginTop = '2px';
            input.parentElement.appendChild(errorElem);
        }
        errorElem.textContent = message;
    }

    function clearError(input) {
        let errorElem = input.parentElement.querySelector('.error-message');
        if (errorElem) errorElem.textContent = '';
    }

    // Prevent numbers in name fields
    ['fname', 'mname', 'lname', 'bill-name', 'ship-name'].forEach(id => {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('keypress', function(e) {
                if (/\d/.test(e.key)) {
                    e.preventDefault();
                }
            });
        }
    });

    // Validation rules for each field
    const validators = {
        'fname': v => !v.trim() ? 'First name is required' : /\d/.test(v) ? 'Numbers not allowed in name' : '',
        'lname': v => !v.trim() ? 'Last name is required' : /\d/.test(v) ? 'Numbers not allowed in name' : '',
        'email': v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v) ? '' : 'Enter a valid email',
        'phone': v => /^\d{10}$/.test(v) ? '' : 'Enter a valid 10-digit phone number',
        'country': v => v ? '' : 'Country is required',
        'state': v => v ? '' : 'State is required',
        'city': v => v.trim() ? '' : 'City is required',
        'pincode': v => /^\d{6}$/.test(v) ? '' : 'Enter a valid 6-digit postal code',
        'address1': v => v.trim() ? '' : 'Address line 1 is required',
        'bill-name': v => v.trim() ? '' : 'Name is required',
        'bill-email': v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v) ? '' : 'Enter a valid email',
        'bill-phone': v => /^\d{10}$/.test(v) ? '' : 'Enter a valid 10-digit phone number',
        'bill-country': v => v ? '' : 'Country is required',
        'bill-state': v => v ? '' : 'State is required',
        'bill-city': v => v.trim() ? '' : 'City is required',
        'bill-pincode': v => /^\d{6}$/.test(v) ? '' : 'Enter a valid 6-digit postal code',
        'bill-address1': v => v.trim() ? '' : 'Address line 1 is required',
        'ship-name': v => v.trim() ? '' : 'Name is required',
        'ship-email': v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v) ? '' : 'Enter a valid email',
        'ship-phone': v => /^\d{10}$/.test(v) ? '' : 'Enter a valid 10-digit phone number',
        'ship-country': v => v ? '' : 'Country is required',
        'ship-state': v => v ? '' : 'State is required',
        'ship-city': v => v.trim() ? '' : 'City is required',
        'ship-pincode': v => /^\d{6}$/.test(v) ? '' : 'Enter a valid 6-digit postal code',
        'ship-address1': v => v.trim() ? '' : 'Address line 1 is required'
    };

    // Attach real-time validation to all relevant fields
    Object.keys(validators).forEach(id => {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('input', function() {
                const error = validators[id](input.value);
                if (error) setError(input, error);
                else clearError(input);
            });
            // Validate on blur as well
            input.addEventListener('blur', function() {
                const error = validators[id](input.value);
                if (error) setError(input, error);
                else clearError(input);
            });
        }
    });

    // On form submit, check all fields and prevent submission if any error
    document.querySelector('form').addEventListener('submit', function(e) {
        let hasError = false;
        Object.keys(validators).forEach(id => {
            const input = document.getElementById(id);
            if (input) {
                const error = validators[id](input.value);
                if (error) {
                    setError(input, error);
                    hasError = true;
                } else {
                    clearError(input);
                }
            }
        });
        // Extra check: if any error-message is visible, prevent submit
        if (document.querySelector('.error-message') && Array.from(document.querySelectorAll('.error-message')).some(el => el.textContent.trim() !== '')) {
            hasError = true;
        }
        if (hasError) e.preventDefault();
    });
</script>

<?php include "footer.php"; ?>