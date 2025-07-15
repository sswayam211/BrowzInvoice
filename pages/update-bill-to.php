<!-- including side nav bar  -->
<?php include 'side-nav.php'; ?>


<div class="add-form py-5">
    <form action="\Office\Browz Invoice\php\handle-update-bill-to.php" method="post" class="shadow p-sm-5 py-5 p-3 mx-sm-5" style="background-color: white;">
        <div class="form-heading mb-5">
            <h3 class="m-0">Update Billing Address</h3>
        </div>

        <div class="alert-box">
            <?php
            $message = false;
            $error = false;

            if (isset($_GET['u']) && $_GET['u'] == '1') {
                $message = 'Bill to address updated successfully!';
            } else if (isset($_GET['u']) && $_GET['u'] == '0') {
                $error = 'Fail to update bill to address, please try again';
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

        $updateBillAdd = (isset($_GET['update']) ? $_GET['update'] : '');

        include 'db-conn.php';
        $updateSql = "SELECT * FROM `bill_to_address` WHERE `BILL_CODE`='$updateBillAdd' LIMIT 1";
        $updateResult = mysqli_query($conn, $updateSql);
        if ($updateResult && $updateResult->num_rows > 0) {
            while ($data = $updateResult->fetch_assoc()) {

                echo '
                <div class="row">
                    <div class="form-group col-md-3 mb-4">
                        <input type="hidden" name="bill-code" id="bill-code" placeholder="" value="' . htmlspecialchars($data['BILL_CODE']) . '" required>
                        <input type="text" name="bill-code" id="bill-code" placeholder="" value="' . htmlspecialchars($data['BILL_CODE']) . '" disabled required>
                        <label for="bill-code">Bill Code<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-6 mb-4">
                        <input type="text" name="name" id="name" placeholder="" value="' . htmlspecialchars($data['BILL_NAME']) . '" required>
                        <label for="name">Name<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-3 mb-4">
                        <input type="text" class="number" name="gstin" id="gstin" placeholder="" value="' . htmlspecialchars($data['GSTIN_NO']) . '">
                        <label for="gstin">GSTIN No</label>
                    </div>
                    <div class="form-group col-md-3 mb-4">
                        <input type="email" name="email" id="email" placeholder="" value="' . htmlspecialchars($data['BILL_EMAIL']) . '" required>
                        <label for="email">Email<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-3 mb-4">
                        <input type="tel" name="phone" id="phone" placeholder="" value="' . htmlspecialchars($data['BILL_PHONE_NO']) . '" required>
                        <label for="phone">Phone No<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-3 mb-4">
                        <select id="country" name="country" required>
                            <option value="' . htmlspecialchars($data['BILL_COUNTRY']) . '" selected>' . htmlspecialchars($data['BILL_COUNTRY']) . '</option> 
                            <option value="India">India</option>
                        </select>
                        <label for="country">
                            Country<span class="required">*</span>
                        </label>
                    </div>
                    <div class="form-group col-md-3 mb-4">
                        <select id="state" name="state" required>
                            <option value="' . htmlspecialchars($data['BILL_STATE']) . '" selected>' . htmlspecialchars($data['BILL_STATE']) . '</option>
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
                        <input type="text" name="city" id="city" value="' . htmlspecialchars($data['BILL_CITY']) . '" placeholder="">
                        <label for="phone">City<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-3 mb-4">
                        <input type="number" class="number" name="pincode" id="pincode" placeholder="" value="' . htmlspecialchars($data['BILL_POSTAL_CODE']) . '" required>
                        <label for="phone">Postal Code<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-12 mb-4">
                        <input type="text" name="address1" id="address1" placeholder="" value="' . htmlspecialchars($data['BILL_ADDRESS_1']) . '" required>
                        <label for="address1">Address line 1<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-12 mb-4">
                        <input type="text" name="address2" id="address2" placeholder="" value="' . htmlspecialchars($data['BILL_ADDRESS_2']) . '">
                        <label for="address2">Address line 2</label>
                    </div>
                </div>
                ';
            }
        }

        ?>

        <div class="button mt-2">
            <button class="save" type="submit">Save</button>
            <a href="bill-to-address-page.php"><button class="cancel" type="button">Cancel</button></a>
        </div>
    </form>
</div>

<?php include "footer.php"; ?>