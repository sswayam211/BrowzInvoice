<!-- including side nav bar  -->
<?php include 'side-nav.php'; ?>

<a href="gst-page.php"><button class="back" type="button"><i class="fa-solid fa-arrow-left me-1"></i>Back</button></a>
<div class="add-form py-5">
    <form action="\Office\Browz Invoice\php\handle-add-gst.php" method="post" class="col-md-8 col-sm-10 m-auto shadow p-sm-5 py-5 p-3" style="background-color: white;">
        <div class="form-heading mb-5">
            <h3 class="m-0">Add GST</h3>
        </div>

        <div class="alert-box">
            <?php
            $message = false;
            $error = false;

            if (isset($_GET['s']) && $_GET['s'] == '1') {
                $message = 'gst added successfully!';
            } else if (isset($_GET['s']) && $_GET['s'] == '0') {
                $error = 'Fail to add gst, please try again';
            } else if (isset($_GET['s']) && $_GET['s'] == '3') {
                $error = 'This gst code already exist.';
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

            // AUTO GENERATING gst CODE BY FINDING THE LAST gst CODE
            include 'db-conn.php';

            $result = mysqli_query($conn, "SELECT GST_CODE FROM gst ORDER BY GST_CODE DESC LIMIT 1");
            $row = mysqli_fetch_assoc($result);

            if ($row) {
                // Extracting number and increment
                $lastCode = $row['GST_CODE'];
                // echo $lastCode;
                $number = (int)substr($lastCode, -4); // Geting numeric part after 'CUST'
                $newNumber = $number + 1;
            } else {
                // No gsts yet
                $newNumber = 1;
            }

            // echo $newNumber;

            $gstCode = 'G' . (string)$curYear . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
            // echo $gstCode;

            echo '
            <div class="form-group col-md-4 mb-4">
                <input type="hidden" name="gst-code" id="gst-code" placeholder="" value="' . $gstCode . '" required>
                <input type="text" name="gst-code" id="gst-code" placeholder="" value="' . $gstCode . '" disabled required>
                <label for="gst-code">gst Code<span class="required">*</span></label>
            </div>
            ';

            $conn->close();
            ?>
            <div class="form-group col-md-4 mb-4">
                <input type="text" name="category" id="category" placeholder="" required>
                <label for="category">GST Category<span class="required">*</span></label>
            </div>
            <div class="form-group col-md-4 mb-4">
                <input type="text" name="sgst" id="sgst" placeholder="" required>
                <label for="sgst">SGST(%)<span class="required">*</span></label>
            </div>
            <div class="form-group col-md-4 mb-4">
                <input type="text" name="cgst" id="cgst" placeholder="" required>
                <label for="cgst">CGST(%)<span class="required">*</span></label>
            </div>
            <div class="form-group col-md-4 mb-4">
                <input type="text" name="igst" id="igst" placeholder="" required>
                <label for="igst">IGST(%)<span class="required">*</span></label>
            </div>

        </div>

        <div class="button mt-2">
            <button class="save" type="submit">Save</button>
            <a href="gst-page.php"><button class="cancel" type="button">Cancel</button></a>
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

    // Prevent non-numeric input for SGST, CGST, IGST
    ['sgst', 'cgst', 'igst'].forEach(id => {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('keypress', function(e) {
                // Allow only numbers and dot
                if (!/[0-9.]/.test(e.key)) {
                    e.preventDefault();
                }
            });
        }
    });

    // Prevent numbers in category field
    const categoryInput = document.getElementById('category');
    if (categoryInput) {
        categoryInput.addEventListener('keypress', function(e) {
            if (/\d/.test(e.key)) {
                e.preventDefault();
            }
        });
    }


    // Validation rules for each field
    const validators = {
        'category': v => !v.trim() ? 'GST Category is required' : /\d/.test(v) ? 'Numbers not allowed in category' : '',
        'sgst': v => v.trim() === '' ? 'SGST is required' : isNaN(v) || Number(v) < 0 || Number(v) > 100 ? 'Enter a valid SGST (0-100)' : '',
        'cgst': v => v.trim() === '' ? 'CGST is required' : isNaN(v) || Number(v) < 0 || Number(v) > 100 ? 'Enter a valid CGST (0-100)' : '',
        'igst': v => v.trim() === '' ? 'IGST is required' : isNaN(v) || Number(v) < 0 || Number(v) > 100 ? 'Enter a valid IGST (0-100)' : ''
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