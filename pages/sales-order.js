// displaying add new customer form
try {
    let addNewCustFormBtn = document.getElementById('show-add-new-cust-form');
    let addCustForm = document.querySelector('.cust-details');
    let searchedCustTable = document.querySelector('.searched-customers-table');
    addNewCustFormBtn.addEventListener('click', () => {
        // let custCodeField = document.querySelector('#cust-code');

        if (addCustForm.classList.contains('d-none')) {
            // console.log('form was hidden');
            searchedCustTable.classList.add('d-none');
            addCustForm.classList.remove('d-none');
            {
                let result = new XMLHttpRequest();
                result.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        // Parse JSON response
                        let data = JSON.parse(this.responseText);
                        // console.log(data);


                        document.getElementById('cust-code-1').value = data.custCode || '';
                        document.getElementById('cust-code-2').value = data.custCode || '';
                        document.getElementById('fname').value = '';
                        document.getElementById('mname').value = '';
                        document.getElementById('lname').value = '';
                        document.getElementById('gstin').value = '';
                        document.getElementById('email').value = '';
                        document.getElementById('phone').value = '';
                        document.getElementById('country').value = '';
                        document.getElementById('state').value = '';
                        document.getElementById('city').value = '';
                        document.getElementById('pincode').value = '';
                        document.getElementById('address1').value = '';
                        document.getElementById('address2').value = '';

                        // billing details
                        document.getElementById('bill-code-1').value = data.billCode || '';
                        document.getElementById('bill-code-2').value = data.billCode || '';
                        document.getElementById('bill-name').value = '';
                        document.getElementById('bill-email').value = '';
                        document.getElementById('bill-phone').value = '';
                        document.getElementById('bill-country').value = '';
                        document.getElementById('bill-state').value = '';
                        document.getElementById('bill-city').value = '';
                        document.getElementById('bill-pincode').value = '';
                        document.getElementById('bill-address1').value = '';
                        document.getElementById('bill-address2').value = '';

                        // shipping details
                        document.getElementById('ship-code-1').value = data.shipCode || '';
                        document.getElementById('ship-code-2').value = data.shipCode || '';
                        document.getElementById('ship-name').value = '';
                        document.getElementById('ship-email').value = '';
                        document.getElementById('ship-phone').value = '';
                        document.getElementById('ship-country').value = '';
                        document.getElementById('ship-state').value = '';
                        document.getElementById('ship-city').value = '';
                        document.getElementById('ship-pincode').value = '';
                        document.getElementById('ship-address1').value = '';
                        document.getElementById('ship-address2').value = '';
                    }
                };
                result.open("GET", "/Office/Browz Invoice/php/generate-new-cust-code-ajax.php", true);
                result.send();


                // seting auto fill false to stop validation
                setCustomerAutofilled(false);
                setBillingAutofilled(false);
                setShippingAutofilled(false);
            }
        } else {
            addCustForm.classList.add('d-none');
        }
    });

} catch (err) {
    console.log(err);
}


// filling bill and ship fields when clicked
try {
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
            // setCustomerAutofilled(true);
            setBillingAutofilled(true);
            // setShippingAutofilled(true);
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
            setBillingAutofilled(false);
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
            // setCustomerAutofilled(true);
            // setBillingAutofilled(true);
            setShippingAutofilled(true);
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
            setShippingAutofilled(false);
        }
    });
} catch (err) {
    console.log(err);
}


// searching customer
try {
    document.getElementById('search-cust').addEventListener('input', () => {
        let query = document.getElementById('search-cust').value;
        let searchTable = document.querySelector('#searched-customers-table');
        let form = document.querySelector('.cust-details');
        if (query.length >= 1) {
            let result = new XMLHttpRequest();
            result.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    searchTable.classList.remove('d-none');
                    form.classList.add('d-none');
                    document.getElementById('searched-customers-table').innerHTML = this.responseText;
                }
            };
            result.open("GET", "/Office/Browz Invoice/php/search-customer.php?query=" + query, true);
            result.send();
        } else {
            searchTable.classList.add('d-none');
        }

    });

} catch (err) {
    console.log(err);
}


// displaying customer details when selected a customer
try {
    let searchTable = document.getElementById('searched-customers-table');
    let form = document.querySelector('.cust-details');
    searchTable.addEventListener('click', function (e) {
        if (e.target.classList.contains('take-cust')) {

            // console.log('Customer button clicked:', e.target);
            let customerCode = e.target.value;
            // console.log(customerCode);

            {
                let result = new XMLHttpRequest();
                result.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        searchTable.classList.add('d-none');
                        form.classList.remove('d-none');
                        // Parse JSON response
                        let data = JSON.parse(this.responseText);
                        // console.log(data);

                        // Fill form fields
                        document.getElementById('cust-code-1').value = data.CUST_CODE || '';
                        document.getElementById('cust-code-2').value = data.CUST_CODE || '';
                        if (data.CUST_FULL_NAME.split(' ').length === 2) {
                            // console.log(data.CUST_FULL_NAME.split(' ').length);
                            document.getElementById('fname').value = data.CUST_FULL_NAME?.split(' ')[0] || '';
                            document.getElementById('lname').value = data.CUST_FULL_NAME?.split(' ')[1] || '';
                        } else {
                            document.getElementById('fname').value = data.CUST_FULL_NAME?.split(' ')[0] || '';
                            document.getElementById('mname').value = data.CUST_FULL_NAME?.split(' ')[1] || '';
                            document.getElementById('lname').value = data.CUST_FULL_NAME?.split(' ')[2] || '';
                        }
                        document.getElementById('gstin').value = data.CUST_GSTIN || '';
                        document.getElementById('email').value = data.CUST_EMAIL || '';
                        document.getElementById('phone').value = data.CUST_PHONE_NO || '';
                        document.getElementById('country').value = data.CUST_COUNTRY || '';
                        document.getElementById('state').value = data.CUST_STATE || '';
                        document.getElementById('city').value = data.CUST_CITY || '';
                        document.getElementById('pincode').value = data.CUST_POSTAL_CODE || '';
                        document.getElementById('address1').value = data.CUST_ADDRESS_1 || '';
                        document.getElementById('address2').value = data.CUST_ADDRESS_2 || '';

                        // billing data
                        document.getElementById('bill-code-1').value = data.BILL_CODE || '';
                        document.getElementById('bill-code-2').value = data.BILL_CODE || '';
                        document.getElementById('bill-name').value = data.BILL_NAME || '';
                        document.getElementById('bill-email').value = data.BILL_EMAIL || '';
                        document.getElementById('bill-phone').value = data.BILL_PHONE_NO || '';
                        document.getElementById('bill-country').value = data.BILL_COUNTRY || '';
                        document.getElementById('bill-state').value = data.BILL_STATE || '';
                        document.getElementById('bill-city').value = data.BILL_CITY || '';
                        document.getElementById('bill-pincode').value = data.BILL_POSTAL_CODE || '';
                        document.getElementById('bill-address1').value = data.BILL_ADDRESS_1 || '';
                        document.getElementById('bill-address2').value = data.BILL_ADDRESS_2 || '';

                        // shipping data
                        document.getElementById('ship-code-1').value = data.SHIP_CODE || '';
                        document.getElementById('ship-code-2').value = data.SHIP_CODE || '';
                        document.getElementById('ship-name').value = data.SHIP_NAME || '';
                        document.getElementById('ship-email').value = data.SHIP_EMAIL || '';
                        document.getElementById('ship-phone').value = data.SHIP_PHONE_NO || '';
                        document.getElementById('ship-country').value = data.SHIP_COUNTRY || '';
                        document.getElementById('ship-state').value = data.SHIP_STATE || '';
                        document.getElementById('ship-city').value = data.SHIP_CITY || '';
                        document.getElementById('ship-pincode').value = data.SHIP_POSTAL_CODE || '';
                        document.getElementById('ship-address1').value = data.SHIP_ADDRESS_1 || '';
                        document.getElementById('ship-address2').value = data.SHIP_ADDRESS_2 || '';
                    }
                };
                result.open("GET", "/Office/Browz Invoice/php/fetch-cust-data.php?query=" + customerCode, true);
                result.send();

                // seting auto fill true to stop validation
                setCustomerAutofilled(true);
                setBillingAutofilled(true);
                setShippingAutofilled(true);
            }
        }
    });
} catch (err) {
    console.log(err);
}



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

            // Update product description
            let desc = row.querySelector('input[name^="pro-desc-"]');
            if (desc) {
                desc.name = `pro-desc-${rowNum}`;
                desc.id = `pro-desc-${rowNum}`;
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

            // Update hsn input
            let hsn = row.querySelector('input[name^="pro-hsn-"]');
            if (hsn) {
                hsn.name = `pro-hsn-${rowNum}`;
                hsn.id = `pro-hsn-${rowNum}`;
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

            // Update total without gst input
            let totalWOGST = row.querySelector('input[name^="pro-total-without-gst-"]');
            if (totalWOGST) {
                totalWOGST.name = `pro-total-without-gst-${rowNum}`;
                totalWOGST.id = `pro-total-without-gst-${rowNum}`;
            }

            // Update gst value input
            let GSTVal = row.querySelector('input[name^="pro-gst-val-"]');
            if (GSTVal) {
                GSTVal.name = `pro-gst-val-${rowNum}`;
                GSTVal.id = `pro-gst-val-${rowNum}`;
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


    // geting previously selected products
    function getSelectedProductCodes() {
        return Array.from(document.querySelectorAll('select[name^="product-name-"]'))
            .map(sel => sel.value)
            .filter(val => val !== '');
    }


    //adding new row when clicked 
    function addNewRow() {
        let tbody = document.querySelector('tbody.product-table');
        let rows = tbody.querySelectorAll('tr');

        // The next product number
        let nextProductNum = rows.length;

        // Get all product options from the first select
        // let firstSelect = document.querySelector('select[name^="product-name-"]');
        // let options = Array.from(firstSelect ? firstSelect.options : []);
        // let selectedCodes = getSelectedProductCodes();

        let firstSelect = document.querySelector('#select-options');
        let options = Array.from(firstSelect ? firstSelect.options : []);
        let selectedCodes = getSelectedProductCodes();

        // Filter out selected products
        let filteredOptionsHtml = `<option value="" disabled selected hidden>Select Product --</option>` + options
            .filter(opt => !selectedCodes.includes(opt.value) || opt.value === '')
            .map(opt => `<option value="${opt.value}">${opt.text}</option>`)
            .join('');


        // new row 
        let newRow = document.createElement('tr');
        newRow.innerHTML = `
                                    <td class="">
                                        <div class="form-group">
                                            <select id="product-name-${nextProductNum}" name="product-name-${nextProductNum}" required onchange="productData(this)">
                                                ${filteredOptionsHtml}
                                            </select>
                                        </div>
                                    </td>
                                    <td class="">
                                        <div class="form-group">
                                            <input class="desc" type="text" name="pro-desc-${nextProductNum}" id="pro-desc-${nextProductNum}" placeholder="" required>
                                        </div>
                                    </td>
                                    <td class="text-center d-flex justify-content-center align-content-center quantity">
                                        <button type="button" class="decrese">-</button>
                                        <span class="qtty">
                                            <div class="form-group">
                                                <input class="number quant" type="number" name="pro-quantity-${nextProductNum}" id="pro-quantity-${nextProductNum}" placeholder="" required>
                                            </div>
                                        </span>
                                        <button type="button" class="increse">+</button>
                                    </td>
                                    <td class="">
                                        <div class="form-group">
                                            <input type="text" name="pro-price-${nextProductNum}" id="pro-price-${nextProductNum}" placeholder="" required>
                                        </div>
                                    </td>
                                    <td class="">
                                        <div class="form-group">
                                            <input type="text" name="pro-uom-${nextProductNum}" id="pro-uom-${nextProductNum}" placeholder="" required>
                                            <input type="hidden" name="pro-hsn-${nextProductNum}" id="pro-hsn-${nextProductNum}" placeholder="">
                                        </div>
                                    </td>
                                    <td class="">
                                        <div class="form-group">
                                            <input class="number discount" type="hidden" name="pro-max-discount-${nextProductNum}" id="pro-max-discount-${nextProductNum}" placeholder="">
                                            <input class="number discount" type="number" name="pro-discount-${nextProductNum}" id="pro-discount-${nextProductNum}" minlength="0" oninput="addDiscount(this)" placeholder="">
                                        </div>
                                    </td>
                                    <td class="">
                                        <div class="form-group">
                                            <input type="text" name="pro-total-without-gst-${nextProductNum}" id="pro-total-without-gst-${nextProductNum}" placeholder="" required>
                                        </div>
                                    </td>
                                    <td class="">
                                        <div class="form-group">
                                            <input type="text" name="pro-gst-${nextProductNum}" id="pro-gst-${nextProductNum}" placeholder="" required>
                                        </div>
                                    </td>
                                    <td class="t-price">
                                        <div class="form-group">
                                            <input class="number" type="text" name="pro-gst-val-${nextProductNum}" id="pro-gst-val-${nextProductNum}" placeholder="" required>
                                        </div>
                                    </td>
                                    <td class="t-price">
                                        <div class="form-group">
                                            <input class="number" type="text" name="pro-t-price-${nextProductNum}" id="pro-t-price-${nextProductNum}" placeholder="" required>
                                        </div>
                                    </td>
                                    <td class="p-1 text-center">
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
            result.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    // Parse JSON response
                    let data = JSON.parse(this.responseText);
                    // console.log(data);
                    let GSTVal = (parseFloat(data.PRO_PRICE) * ((parseFloat(data.SGST) + parseFloat(data.CGST)) / 100)).toFixed(2);
                    let totalPrice = parseFloat(data.PRO_PRICE) + parseFloat(GSTVal);

                    document.getElementById(`pro-price-${proNo}`).value = data.PRO_PRICE || '';
                    document.getElementById(`pro-desc-${proNo}`).value = data.PRO_DESC || '';
                    document.getElementById(`pro-uom-${proNo}`).value = data.PRO_UOM || '';
                    document.getElementById(`pro-hsn-${proNo}`).value = data.PRO_HSNNO || '';
                    document.getElementById(`pro-quantity-${proNo}`).value = 1;
                    document.getElementById(`pro-max-discount-${proNo}`).value = data.PRO_MAX_DISCOUNT;
                    document.getElementById(`pro-discount-${proNo}`).value = '';
                    document.getElementById(`pro-total-without-gst-${proNo}`).value = data.PRO_PRICE || '';
                    document.getElementById(`pro-gst-${proNo}`).value = parseFloat(data.SGST) + parseFloat(data.CGST) + '%' || '';
                    document.getElementById(`pro-gst-val-${proNo}`).value = GSTVal;
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
// ...existing code...

// Helper function to calculate total with discount, GST, and update all relevant fields
function calculateDiscountedTotal(row) {
    let priceInput = row.querySelector('input[name^="pro-price-"]');
    let qtyInput = row.querySelector('input[name^="pro-quantity-"]');
    let gstInput = row.querySelector('input[name^="pro-gst-"]');
    let disInput = row.querySelector('input[name^="pro-discount-"]');
    let tPriceInput = row.querySelector('input[name^="pro-t-price-"]');
    let totalWithoutGstInput = row.querySelector('input[name^="pro-total-without-gst-"]');
    let gstValInput = row.querySelector('input[name^="pro-gst-val-"]');

    let price = parseFloat(priceInput.value) || 0;
    let qty = parseInt(qtyInput.value) || 0;
    let gst = parseFloat((gstInput.value || '0').replace('%', '')) || 0;
    let discount = parseFloat(disInput.value) || 0;

    // Calculate total without GST (after discount)
    let totalWithoutGst = (price - discount) * qty;
    if (totalWithoutGst < 0) totalWithoutGst = 0;

    // Calculate GST value
    let gstVal = totalWithoutGst * (gst / 100);

    // Calculate total price (with GST)
    let totalWithGst = totalWithoutGst + gstVal;

    // Update fields
    totalWithoutGstInput.value = totalWithoutGst.toFixed(2);
    gstValInput.value = gstVal.toFixed(2);
    tPriceInput.value = totalWithGst.toFixed(2);
}

// ...existing code...

try {
    // Delegate event to tbody for dynamic rows
    document.querySelector('tbody.product-table').addEventListener('click', function (e) {
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

        // handling inputs 
        let mytot;
        if (e.target.classList.contains('quant')) {
            // clearTimeout(mytot);
            // mytot = setTimeout(() => {
            let row = e.target.closest('tr');
            console.log(row);
            let qtyInput = row.querySelector('input[name^="pro-quantity-"]');

            qtyInput.removeEventListener('input', handleInput);
            qtyInput.addEventListener('input', handleInput);

            function handleInput() {

                clearTimeout(mytot);
                mytot = setTimeout(() => {
                    let qty = parseInt(qtyInput.value) || 0;
                    if (qty >= 1) {
                        // qty--;
                        qtyInput.value = qty;

                        // Calculate total price with discount
                        calculateDiscountedTotal(row);

                        // updating grand total
                        updateGrandTotal();

                    } else if (qty === 0 || qty === '') {
                        qty = 1;
                        qtyInput.value = qty;

                        // Calculate total price with discount
                        calculateDiscountedTotal(row);

                        // updating grand total
                        updateGrandTotal();

                    }
                }, 500);
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
}
catch (err) {
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

try {

    // Helper to show/hide a single error message above the submit button
    function showFormError(message) {
        let btnDiv = document.querySelector('.button.mt-2');
        let errorElem = document.getElementById('form-error-message');
        if (!errorElem) {
            errorElem = document.createElement('div');
            errorElem.id = 'form-error-message';
            errorElem.style.color = 'red';
            errorElem.style.fontSize = '15px';
            errorElem.style.margin = '0 0 15px 0';
            btnDiv.parentNode.insertBefore(errorElem, btnDiv);
        }
        errorElem.textContent = message;
    }

    function clearFormError() {
        let errorElem = document.getElementById('form-error-message');
        if (errorElem) errorElem.textContent = '';
    }

    // Helper to show/hide error messages below input fields
    function setFieldError(input, message) {
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

    function clearFieldError(input) {
        let errorElem = input.parentElement.querySelector('.error-message');
        if (errorElem) errorElem.textContent = '';
    }

    // Prevent numbers in name fields
    ['fname', 'mname', 'lname', 'bill-name', 'ship-name'].forEach(id => {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('keypress', function (e) {
                if (/\d/.test(e.key)) {
                    e.preventDefault();
                }
            });
        }
    });

    // Track if customer, billing, or shipping fields were autofilled by AJAX
    let customerAutofilled = false;
    let billingAutofilled = false;
    let shippingAutofilled = false;


    // Call these after AJAX autofill for each section
    function setCustomerAutofilled(flag = true) {
        customerAutofilled = flag;
        if (flag) {
            ['fname', 'lname', 'email', 'phone', 'country', 'state', 'city', 'pincode', 'address1'].forEach(id => {
                const input = document.getElementById(id);
                if (input) clearFieldError(input);
            });
            clearFormError();
        }
    }
    function setBillingAutofilled(flag = true) {
        billingAutofilled = flag;
        if (flag) {
            ['bill-name', 'bill-email', 'bill-phone', 'bill-country', 'bill-state', 'bill-city', 'bill-pincode', 'bill-address1'].forEach(id => {
                const input = document.getElementById(id);
                if (input) clearFieldError(input);
            });
            clearFormError();
        }
    }
    function setShippingAutofilled(flag = true) {
        shippingAutofilled = flag;
        if (flag) {
            ['ship-name', 'ship-email', 'ship-phone', 'ship-country', 'ship-state', 'ship-city', 'ship-pincode', 'ship-address1'].forEach(id => {
                const input = document.getElementById(id);
                if (input) clearFieldError(input);
            });
            clearFormError();
        }
    }


    // Validation rules for each field
    const validators = {
        // Customer details
        'fname': v => !v.trim() ? 'Customer details is required' : /\d/.test(v) ? 'Numbers not allowed in name' : '',
        'lname': v => !v.trim() ? 'Customer details name is required' : /\d/.test(v) ? 'Numbers not allowed in name' : '',
        'email': v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v) ? '' : 'Enter a valid email',
        'phone': v => /^\d{10}$/.test(v) ? '' : 'Enter a valid 10-digit phone number',
        'country': v => v ? '' : 'Country is required',
        'state': v => v ? '' : 'State is required',
        'city': v => v.trim() ? '' : 'City is required',
        'pincode': v => /^\d{6}$/.test(v) ? '' : 'Enter a valid 6-digit postal code',
        'address1': v => v.trim() ? '' : 'Address line 1 is required',

        // Billing
        'bill-name': v => v.trim() ? '' : 'Billing name is required',
        'bill-email': v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v) ? '' : 'Enter a valid billing email',
        'bill-phone': v => /^\d{10}$/.test(v) ? '' : 'Enter a valid 10-digit billing phone number',
        'bill-country': v => v ? '' : 'Billing country is required',
        'bill-state': v => v ? '' : 'Billing state is required',
        'bill-city': v => v.trim() ? '' : 'Billing city is required',
        'bill-pincode': v => /^\d{6}$/.test(v) ? '' : 'Enter a valid 6-digit billing postal code',
        'bill-address1': v => v.trim() ? '' : 'Billing address line 1 is required',

        // Shipping
        'ship-name': v => v.trim() ? '' : 'Shipping name is required',
        'ship-email': v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v) ? '' : 'Enter a valid shipping email',
        'ship-phone': v => /^\d{10}$/.test(v) ? '' : 'Enter a valid 10-digit shipping phone number',
        'ship-country': v => v ? '' : 'Shipping country is required',
        'ship-state': v => v ? '' : 'Shipping state is required',
        'ship-city': v => v.trim() ? '' : 'Shipping city is required',
        'ship-pincode': v => /^\d{6}$/.test(v) ? '' : 'Enter a valid 6-digit shipping postal code',
        'ship-address1': v => v.trim() ? '' : 'Shipping address line 1 is required'
    };

    // Product row validation helper
    function validateProductRow(i) {
        let errors = [];
        const get = id => {
            const el = document.getElementById(id + i);
            return el ? el.value : '';
        };
        if (!get('product-name-')) errors.push({
            id: 'product-name-' + i,
            msg: `Product is required in row ${i}`
        });
        return errors;
    }

    // Real-time validation: show/hide error above the submit button and below fields
    function validateFormRealtime() {
        clearFormError();
        // Clear all field errors first
        Object.keys(validators).forEach(id => {
            const input = document.getElementById(id);
            if (input) clearFieldError(input);
        });
        // Clear product row field errors
        const totalProducts = document.getElementById('total-products');
        let totalRows = totalProducts ? parseInt(totalProducts.value) : 1;
        for (let i = 1; i <= totalRows; i++) {
            [
                'product-name-', 'pro-desc-', 'pro-quantity-', 'pro-price-', 'pro-uom-',
                'pro-total-without-gst-', 'pro-gst-', 'pro-gst-val-', 'pro-t-price-'
            ].forEach(prefix => {
                const input = document.getElementById(prefix + i);
                if (input) clearFieldError(input);
            });
        }

        let errors = [];

        // Validate all fields in validators
        Object.keys(validators).forEach(id => {
            // Skip customer fields if autofilled
            if (
                (customerAutofilled && ['fname', 'lname', 'email', 'phone', 'country', 'state', 'city', 'pincode', 'address1'].includes(id)) ||
                (billingAutofilled && ['bill-name', 'bill-email', 'bill-phone', 'bill-country', 'bill-state', 'bill-city', 'bill-pincode', 'bill-address1'].includes(id)) ||
                (shippingAutofilled && ['ship-name', 'ship-email', 'ship-phone', 'ship-country', 'ship-state', 'ship-city', 'ship-pincode', 'ship-address1'].includes(id))
            ) return;
            const input = document.getElementById(id);
            if (input) {
                const error = validators[id](input.value);
                if (error) {
                    setFieldError(input, error);
                    errors.push(error);
                }
            }
        });

        // Validate all product rows
        for (let i = 1; i <= totalRows; i++) {
            const rowErrors = validateProductRow(i);
            rowErrors.forEach(e => {
                const input = document.getElementById(e.id);
                if (input) setFieldError(input, e.msg);
                errors.push(e.msg);
            });
        }

        if (errors.length > 0) {
            showFormError(errors[0]); // Show only the first error
        } else {
            clearFormError();
        }
    }

    // Attach real-time validation to all relevant fields
    Object.keys(validators).forEach(id => {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('input', validateFormRealtime);
            input.addEventListener('blur', validateFormRealtime);
        }
    });

    // Attach real-time validation to product table fields
    document.addEventListener('input', function (e) {
        if (e.target && e.target.closest('.product-table')) {
            validateFormRealtime();
        }
    });

    // On form submit, check all fields and prevent submission if any error
    document.querySelector('form').addEventListener('submit', function (e) {
        clearFormError();
        // Clear all field errors first
        Object.keys(validators).forEach(id => {
            const input = document.getElementById(id);
            if (input) clearFieldError(input);
        });
        // Clear product row field errors
        const totalProducts = document.getElementById('total-products');
        let totalRows = totalProducts ? parseInt(totalProducts.value) : 1;
        for (let i = 1; i <= totalRows; i++) {
            [
                'product-name-', 'pro-desc-', 'pro-quantity-', 'pro-price-', 'pro-uom-',
                'pro-total-without-gst-', 'pro-gst-', 'pro-gst-val-', 'pro-t-price-'
            ].forEach(prefix => {
                const input = document.getElementById(prefix + i);
                if (input) clearFieldError(input);
            });
        }

        let errors = [];

        // Validate all fields in validators
        Object.keys(validators).forEach(id => {
            // Skip customer, billing, shipping fields if autofilled
            if (
                (customerAutofilled && ['fname', 'lname', 'email', 'phone', 'country', 'state', 'city', 'pincode', 'address1'].includes(id)) ||
                (billingAutofilled && ['bill-name', 'bill-email', 'bill-phone', 'bill-country', 'bill-state', 'bill-city', 'bill-pincode', 'bill-address1'].includes(id)) ||
                (shippingAutofilled && ['ship-name', 'ship-email', 'ship-phone', 'ship-country', 'ship-state', 'ship-city', 'ship-pincode', 'ship-address1'].includes(id))
            ) return;
            const input = document.getElementById(id);
            if (input) {
                const error = validators[id](input.value);
                if (error) {
                    setFieldError(input, error);
                    errors.push(error);
                }
            }
        });

        // Validate all product rows
        for (let i = 1; i <= totalRows; i++) {
            const rowErrors = validateProductRow(i);
            rowErrors.forEach(e => {
                const input = document.getElementById(e.id);
                if (input) setFieldError(input, e.msg);
                errors.push(e.msg);
            });
        }

        if (errors.length > 0) {
            showFormError(errors[0]); // Show only the first error
            e.preventDefault();
        } else {
            clearFormError();
        }
    });



} catch (err) {
    console.log(err);
}
