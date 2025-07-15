<!-- including side nav bar  -->
<?php include 'side-nav.php'; ?>


<a href="ship-to-address-page.php"><button class="back" type="button"><i class="fa-solid fa-arrow-left me-1"></i>Back</button></a>
<div class="add-form py-5">
    <form action="\Office\Browz Invoice\php\handle-add-ship-to.php" method="post" class="shadow p-sm-5 py-5 p-3 mx-sm-5" style="background-color: white;">
        <div class="form-heading mb-5">
            <h3 class="m-0">Add Shipping Address</h3>
        </div>

        <div class="alert-box">
            <?php
            $message = false;
            $error = false;

            if (isset($_GET['s']) && $_GET['s'] == '1') {
                $message = 'Customer shipping address added successfully!';
            } else if (isset($_GET['s']) && $_GET['s'] == '0') {
                $error = 'Fail to add customer shipping address, please try again';
            } else if (isset($_GET['s']) && $_GET['s'] == '3') {
                $error = 'This shipping code already exist.';
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
            <?php

            $curYear = date('Y');
            // echo $curYear;

            // AUTO GENERATING bill CODE BY FINDING THE LAST bill CODE
            include 'db-conn.php';

            $result = mysqli_query($conn, "SELECT SHIP_CODE FROM ship_to_address ORDER BY SHIP_CODE DESC LIMIT 1");
            $row = mysqli_fetch_assoc($result);

            if ($row) {
                // Extracting number and increment
                $lastCode = $row['SHIP_CODE'];
                // echo $lastCode;
                $number = (int)substr($lastCode, -4); // Geting numeric part after 'CUST'
                $newNumber = $number + 1;
            } else {
                // No bills yet
                $newNumber = 1;
            }

            // echo $newNumber;

            $shipCode = 'S' . (string)$curYear . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
            // echo $shipCode;

            echo '
            <div class="form-group col-md-3 mb-4">
                <input type="hidden" name="ship-code" id="ship-code" placeholder="" value="' . $shipCode . '" required>
                <input type="text" name="ship-code" id="ship-code" placeholder="" value="' . $shipCode . '" disabled required>
                <label for="ship-code">Ship Code<span class="required">*</span></label>
            </div>
            ';

            $conn->close();
            ?>
            <div class="form-group col-md-6 mb-4">
                <input type="text" name="name" id="name" placeholder="" required>
                <label for="name">Name<span class="required">*</span></label>
            </div>
            <div class="form-group col-md-3 mb-4">
                <input type="text" class="number" name="gstin" id="gstin" placeholder="">
                <label for="gstin">GSTIN No</label>
            </div>
            <div class="form-group col-md-3 mb-4">
                <input type="email" name="email" id="email" placeholder="" required>
                <label for="email">Email<span class="required">*</span></label>
            </div>
            <div class="form-group col-md-3 mb-4">
                <input type="number" class="number" class="number" name="phone" id="phone" placeholder="" required>
                <label for="phone">Phone No<span class="required">*</span></label>
            </div>
            <div class="form-group col-md-3 mb-4">
                <select id="country" name="country" required>
                    <!-- <option value="" disabled selected hidden></option> -->
                    <option value="India" selected>India</option>
                </select>
                <label for="country">
                    Country<span class="required">*</span>
                </label>
            </div>
            <div class="form-group col-md-3 mb-4">
                <select id="state" name="state">
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
                <input type="number" class="number" name="pincode" id="pincode" placeholder="" required>
                <label for="pincode">Postal Code<span class="required">*</span></label>
            </div>
            <div class="form-group col-md-12 mb-4">
                <input type="text" name="address1" id="address1" placeholder="" required>
                <label for="address1">Address line 1<span class="required">*</span></label>
            </div>
            <div class="form-group col-md-12 mb-4">
                <input type="text" name="address2" id="address2" placeholder="">
                <label for="address2">Address line 2</label>
            </div>
        </div>

        <div class="button mt-2">
            <button class="save" type="submit">Save</button>
            <a href="ship-to-address-page.php"><button class="cancel" type="button">Cancel</button></a>
        </div>
    </form>
</div>

<?php include "footer.php"; ?>