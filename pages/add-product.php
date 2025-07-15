<!-- including side nav bar  -->
<?php include 'side-nav.php'; ?>

<a href="product-page.php"><button class="back" type="button"><i class="fa-solid fa-arrow-left me-1"></i>Back</button></a>
<div class="add-form py-5">
    <form action="\Office\Browz Invoice\php\handle-add-product.php" method="post" enctype="multipart/form-data" class="col-md-8 col-sm-10 m-auto shadow p-sm-5 py-5 p-3" style="background-color: white;">
        <div class="form-heading mb-5">
            <h3 class="m-0">Add Product</h3>
        </div>

        <div class="alert-box">
            <?php
            $message = false;
            $error = false;

            if (isset($_GET['s']) && $_GET['s'] == '1') {
                $message = 'Product added successfully!';
            } else if (isset($_GET['s']) && $_GET['s'] == '0') {
                $error = 'Fail to add product, please try again';
            } else if (isset($_GET['s']) && $_GET['s'] == '3') {
                $error = 'This HSN No. already exist.';
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

            // AUTO GENERATING product CODE BY FINDING THE LAST product CODE
            include 'db-conn.php';

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

            echo '
            <div class="form-group col-md-4 mb-4">
                <input type="hidden" name="pro-code" id="pro-code" placeholder="" value="' . $productCode . '" required>
                <input type="text" name="pro-code" id="pro-code" placeholder="" value="' . $productCode . '" disabled required>
                <label for="pro-code">Product Code<span class="required">*</span></label>
            </div>
            ';

            $conn->close();
            ?>
            <div class="form-group col-md-4 mb-4">
                <input type="text" name="name" id="name" placeholder="" required>
                <label for="name">Product Name<span class="required">*</span></label>
            </div>
            <div class="form-group col-md-4 mb-4">
                <input type="number" class="number" name="hsnno" id="hsnno" placeholder="" required>
                <label for="hsnno">Product HSN No<span class="required">*</span></label>
            </div>
            <div class="form-group col-md-4 mb-4">
                <select id="category" name="category" required>
                    <option value="" selected></option>

                    <?php
                    include 'db-conn.php';
                    $gstCatSql = "SELECT GST_CATEGORY FROM `gst`";
                    $gstCatResult = mysqli_query($conn, $gstCatSql);
                    if ($gstCatResult && $gstCatResult->num_rows > 0) {
                        while ($gstCatData = $gstCatResult->fetch_assoc()) {
                            echo '
                            <option value="' . $gstCatData['GST_CATEGORY'] . '">' . $gstCatData['GST_CATEGORY'] . '</option>
                            ';
                        }
                    }
                    ?>

                </select>
                <label for="uom">
                    Category<span class="required">*</span>
                </label>
            </div>
            <div class="form-group col-md-4 mb-4">
                <select id="uom" name="uom" required>
                    <option value="" selected></option>
                    <option value="meters">Meters(m)</option>
                    <option value="grams">Grams(gm)</option>
                    <option value="kilograms">Kilograms(kg)</option>
                    <option value="liters">Liters(L)</option>
                    <option value="cubic meters">Cubic meters(m³)</option>
                    <option value="each">Each(per piece)</option>
                    <option value="dozen">dozen</option>
                    <option value="sheets">sheets</option>
                    <option value="pallets">pallets</option>
                    <option value="cartons">cartons</option>
                    <option value="cases">cases</option>
                </select>
                <label for="uom">
                    U.O.M<span class="required">*</span>
                </label>
            </div>
            <!-- <div class="form-group col-md-4 mb-4">
                <select id="currency" name="currency" required>
                    <option value="" disabled hidden></option>
                    <option value="INR" selected>INR</option>
                </select>
                <label for="currency">
                    Currency<span class="required">*</span>
                </label>
            </div> -->
            <div class="form-group col-md-4 mb-4">
                <input type="number" class="number" name="price" id="price" placeholder="" required>
                <label for="price">Price<span class="required">*</span></label>
            </div>
            <div class="form-group col-md-4 mb-4">
                <input type="number" class="number" name="max-discount" id="max-discount" placeholder="" required>
                <label for="max-discount">Max Discount<span class="required">*</span></label>
            </div>
            <div class="form-group col-md-8 mb-4">
                <input type="text" name="desc" id="desc" placeholder="">
                <label for="desc">Description</label>
            </div>
            <div class="form-group col-md-4 mb-4">
                <input type="file" class="number" name="image" id="image" placeholder="" accept="image/png, image/jpeg">
                <label for="image">Product Image<span class="required">*</span></label>
                <small class="file-size-error">file between 1kb to
                    150kb</small>
            </div>
        </div>

        <div class="button mt-2">
            <button class="save" type="submit">Save</button>
            <a href="product-page.php"><button class="cancel" type="button">Cancel</button></a>
        </div>
    </form>
</div>

<script>
    try {

        let imageField = document.getElementById('image');
        let fileSizeError = document.querySelector('.file-size-error');
        // console.log(fileSizeError);

        // console.log(imageField);

        imageField.addEventListener("change", function() {
            const file = this.files[0];
            if (file) {
                const fileSizeInKB = file.size / 1024; // Converting size to KB
                const fileAllowdType = ['image/jpeg', 'image/png'];
                if (fileSizeInKB > 150 || fileSizeInKB < 1) {
                    fileSizeError.style.color = 'red';
                    fileSizeError.textContent = 'File size must be between 1kb to 150kb';
                    this.value = ''; // Clear the input field
                } else if (!fileAllowdType.includes(file.type)) {
                    fileSizeError.style.color = 'red';
                    fileSizeError.textContent = 'File type must be jpeg or png';
                    this.value = ''; // Clear the input field
                } else {
                    fileSizeError.style.color = 'green';
                    fileSizeError.textContent = 'File size and type is valid.';
                }
            }
        });

    } catch (err) {
        console.log(err);
    }
</script>

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

    // Prevent numbers in product name
    const nameInput = document.getElementById('name');
    if (nameInput) {
        nameInput.addEventListener('keypress', function(e) {
            if (/\d/.test(e.key)) {
                e.preventDefault();
            }
        });
    }

    // Validation rules for each field
    const validators = {
        'name': v => !v.trim() ? 'Product name is required' : /\d/.test(v) ? 'Numbers not allowed in product name' : '',
        'hsnno': v => !v.trim() ? 'HSN No is required' : isNaN(v) || Number(v) < 0 ? 'Enter a valid HSN No' : '',
        'category': v => !v.trim() ? 'Category is required' : '',
        'uom': v => !v.trim() ? 'U.O.M is required' : '',
        'price': v => !v.trim() ? 'Price is required' : isNaN(v) || Number(v) < 0 ? 'Enter a valid price' : '',
        'max-discount': v => !v.trim() ? 'Max Discount is required' : isNaN(v) || Number(v) < 0 ? 'Enter a valid discount' : '',
        // 'image': v => !v ? 'Product image is required' : ''
    };

    // Attach real-time validation to all relevant fields
    Object.keys(validators).forEach(id => {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('input', function() {
                const error = validators[id](input.type === 'file' ? input.value : input.value);
                if (error) setError(input, error);
                else clearError(input);
            });
            input.addEventListener('blur', function() {
                const error = validators[id](input.type === 'file' ? input.value : input.value);
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
                const error = validators[id](input.type === 'file' ? input.value : input.value);
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