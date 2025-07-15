<!-- including side nav bar  -->
<?php include 'side-nav.php'; ?>

<a href="salesman-page.php"><button class="back" type="button"><i class="fa-solid fa-arrow-left me-1"></i>Back</button></a>
<div class="add-form py-5">
    <form action="\Office\Browz Invoice\php\handle-add-salesman.php" method="post" class="shadow p-sm-5 py-5 p-3 mx-sm-5" style="background-color: white;">
        <div class="form-heading mb-5">
            <h3 class="m-0">Add Salesman</h3>
        </div>

        <div class="alert-box">
            <?php
            $message = false;
            $error = false;

            if (isset($_GET['s']) && $_GET['s'] == '1') {
                $message = 'Salesman added successfully!';
            } else if (isset($_GET['s']) && $_GET['s'] == '0') {
                $error = 'Fail to add salesman, please try again';
            } else if (isset($_GET['s']) && $_GET['s'] == '3') {
                $error = 'This salesman code already exist.';
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

            // AUTO GENERATING CUSTOMER CODE BY FINDING THE LAST CUSTOMER CODE
            include 'db-conn.php';

            $result = mysqli_query($conn, "SELECT SM_CODE FROM salesman ORDER BY SM_CODE DESC LIMIT 1");
            $row = mysqli_fetch_assoc($result);

            if ($row) {
                // Extracting number and increment
                $lastCode = $row['SM_CODE'];
                // echo $lastCode;
                $number = (int)substr($lastCode, -4); // Geting numeric part after 'CUST'
                $newNumber = $number + 1;
            } else {
                // No customers yet
                $newNumber = 1;
            }

            // echo $newNumber;

            $salesmanCode = 'SM' . (string)$curYear . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
            // echo $customerCode;

            echo '
            <div class="form-group col-md-3 mb-4">
                <input type="hidden" name="sm-code" id="sm-code" placeholder="" value="' . $salesmanCode . '" required>
                <input type="text" name="sm-code" id="sm-code" placeholder="" value="' . $salesmanCode . '" disabled required>
                <label for="sm-code">Salesman Code<span class="required">*</span></label>
            </div>
            ';

            $conn->close();
            ?>
            <div class="form-group col-md-3 mb-4">
                <input type="text" name="fname" id="fname" placeholder="" required>
                <label for="fname">First Name<span class="required">*</span></label>
            </div>
            <div class="form-group col-md-3 mb-4">
                <input type="text" name="mname" id="mname" placeholder="">
                <label for="mname">Middle Name</label>
            </div>
            <div class="form-group col-md-3 mb-4">
                <input type="text" name="lname" id="lname" placeholder="" required>
                <label for="lname">Last Name<span class="required">*</span></label>
            </div>
            <div class="form-group col-md-3 mb-4">
                <input type="email" name="email" id="email" placeholder="" required>
                <label for="email">Email<span class="required">*</span></label>
            </div>
            <div class="form-group col-md-3 mb-4">
                <input type="number" class="number" name="phone" id="phone" placeholder="" required>
                <label for="phone">Phone No<span class="required">*</span></label>
            </div>
            <div class="form-group col-md-3 mb-4">
                <select id="country" name="country" required>
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

            <div class="form-group col-md-12 mb-4 mt-2">
                <p class="m-0">Joining Info.</p>
            </div>

            <div class="form-group col-md-3 mb-4">
                <input type="date" class="" name="joiningDate" id="joiningDate" placeholder="" required>
                <label for="joiningDate">Joining Date<span class="required">*</span></label>
            </div>
            <!-- <div class="form-group col-md-3 mb-4">
                <input type="text" class="" name="status" id="status" placeholder="" required>
                <label for="status">Status<span class="required">*</span></label>
            </div> -->
            <div class="form-group col-md-3 mb-4">
                <select id="status" name="status" required>
                    <option value="Active" selected>Active</option>
                </select>
                <label for="Status">
                    Status<span class="required">*</span>
                </label>
            </div>
            <div class="form-group col-md-12 mb-4">
                <input type="text" class="" name="remark" id="remark" placeholder="">
                <label for="remark">Remark</label>
            </div>
        </div>

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