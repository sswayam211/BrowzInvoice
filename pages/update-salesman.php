<!-- including side nav bar  -->
<?php include 'side-nav.php'; ?>


<div class="add-form py-5">
    <form action="\Office\Browz Invoice\php\handle-update-salesman.php" method="post" class="shadow p-sm-5 py-5 p-3 mx-sm-5" style="background-color: white;">
        <div class="form-heading mb-5">
            <h3 class="m-0">Update Salesman</h3>
        </div>

        <div class="alert-box">
            <?php
            $message = false;
            $error = false;

            if (isset($_GET['u']) && $_GET['u'] == '1') {
                $message = 'Salesman updated successfully!';
            } else if (isset($_GET['u']) && $_GET['u'] == '0') {
                $error = 'Fail to update salesman, please try again';
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

        $updatesalesman = (isset($_GET['update']) ? $_GET['update'] : '');

        include 'db-conn.php';
        $updateSql = "SELECT * FROM `salesman` WHERE `SM_CODE`='$updatesalesman' LIMIT 1";
        $updateResult = mysqli_query($conn, $updateSql);
        if ($updateResult && $updateResult->num_rows > 0) {
            while ($data = $updateResult->fetch_assoc()) {
                $name = trim($data['SM_FULL_NAME']);
                $name = preg_replace('/\s+/u', ' ', $name);
                $namaArray = explode(' ', $name);
                $fname = isset($namaArray[0]) ? $namaArray[0] : '';
                $lname = count($namaArray) > 1 ? $namaArray[count($namaArray) - 1] : '';
                $mname = '';
                if (count($namaArray) > 2) {
                    $mname = implode(' ', array_slice($namaArray, 1, -1));
                }

                echo '
                <div class="row">
                    <div class="form-group col-md-3 mb-4">
                        <input type="hidden" name="sm-code" id="sm-code" placeholder="" value="' . htmlspecialchars($data['SM_CODE']) . '" required>
                        <input type="text" name="sm-code" id="sm-code" placeholder="" value="' . htmlspecialchars($data['SM_CODE']) . '" disabled required>
                        <label for="sm-code">Salesman Code<span class="required">*</span></label>
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
                        <input type="email" name="email" id="email" placeholder="" value="' . htmlspecialchars($data['SM_EMAIL']) . '" required>
                        <label for="email">Email<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-3 mb-4">
                        <input type="tel" name="phone" id="phone" placeholder="" value="' . htmlspecialchars($data['SM_PHONE_NO']) . '" required>
                        <label for="phone">Phone No<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-3 mb-4">
                        <select id="country" name="country" required>
                            <option value="' . htmlspecialchars($data['SM_COUNTRY']) . '" selected>' . htmlspecialchars($data['SM_COUNTRY']) . '</option> 
                            <option value="India">India</option>
                        </select>
                        <label for="country">
                            Country<span class="required">*</span>
                        </label>
                    </div>
                    <div class="form-group col-md-3 mb-4">
                        <select id="state" name="state" oninput="populateCities()" required>
                            <option value="' . htmlspecialchars($data['SM_STATE']) . '" selected>' . htmlspecialchars($data['SM_STATE']) . '</option>
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
                        <input type="text" name="city" id="city" value="' . htmlspecialchars($data['SM_CITY']) . '" placeholder="">
                        <label for="phone">City<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-3 mb-4">
                        <input type="number" name="pincode" id="pincode" placeholder="" value="' . htmlspecialchars($data['SM_POSTAL_CODE']) . '" required>
                        <label for="phone">Postal Code<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-12 mb-4">
                        <input type="text" name="address1" id="address1" placeholder="" value="' . htmlspecialchars($data['SM_ADDRESS_1']) . '" required>
                        <label for="address1">Address line 1<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-12 mb-4">
                        <input type="text" name="address2" id="address2" placeholder="" value="' . htmlspecialchars($data['SM_ADDRESS_2']) . '">
                        <label for="address2">Address line 2</label>
                    </div>
                    
                    <div class="form-group col-md-12 mb-4 mt-2">
                        <p class="m-0">Joining Info.</p>
                    </div>

                    <div class="form-group col-md-3 mb-4">
                        <input type="date" class="" name="joiningDate" id="joiningDate" placeholder="" value="' . htmlspecialchars($data['SM_JOINING_DATE']) . '" required>
                        <label for="joiningDate">Joining Date<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-3 mb-4">
                        <select id="status" name="status" required>
                            <option value="' . htmlspecialchars($data['SM_STATUS']) . '" selected>' . htmlspecialchars($data['SM_STATUS']) . '</option>
                            <option value="Active" >Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        <label for="Status">
                            Status<span class="required">*</span>
                        </label>
                    </div>
                    <div class="form-group col-md-12 mb-4">
                        <input type="text" class="" name="remark" id="remark" placeholder="" value="' . htmlspecialchars($data['SM_REMARK']) . '">
                        <label for="remark">Remark</label>
                    </div>

                </div>
                ';
            }
        }

        ?>

        <div class="button mt-2">
            <button class="save" type="submit">Save</button>
            <a href="salesman-page.php"><button class="cancel" type="button">Cancel</button></a>
        </div>
    </form>
</div>

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
    ['fname', 'mname', 'lname'].forEach(id => {
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
        'mname': v => v && /\d/.test(v) ? 'Numbers not allowed in name' : '',
        'lname': v => !v.trim() ? 'Last name is required' : /\d/.test(v) ? 'Numbers not allowed in name' : '',
        'email': v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v) ? '' : 'Enter a valid email',
        'phone': v => /^\d{10}$/.test(v) ? '' : 'Enter a valid 10-digit phone number',
        'country': v => v ? '' : 'Country is required',
        'state': v => v ? '' : 'State is required',
        'city': v => v.trim() ? '' : 'City is required',
        'pincode': v => /^\d{6}$/.test(v) ? '' : 'Enter a valid 6-digit postal code',
        'address1': v => v.trim() ? '' : 'Address line 1 is required',
        'joiningDate': v => v ? '' : 'Joining date is required',
        'status': v => v ? '' : 'Status is required'
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