<!-- including side nav bar  -->
<?php include '../pages/side-nav.php'; ?>

<?php
include 'db-conn.php';

// needed variables 
$SOCode = '';
$invoicedate = '';
$customerCode = '';
$billCode = '';
$shipCode = '';
$custGstin = '';
$grandTotalPrice = '';
$currency = '';
$curName = '';
$curSymbol = '';


//fetching so code from get request
$SOCode = (isset($_GET['inv']) ? $_GET['inv'] : '');


// fetching customer data
$custSql = "SELECT * FROM `sales_order` WHERE `SO_CODE`='$SOCode'";
$custResult = mysqli_query($conn, $custSql);
if ($custResult && $custResult->num_rows > 0) {
    $custData = $custResult->fetch_assoc();
    $customerCode = $custData['SO_CUST_CODE'];
    $grandTotalPrice = $custData['SO_TOTAL'];
    $invoicedate = $custData['SO_DATE'];
    $currency = $custData['SO_CURRENCY'];
}


// fetching billing and shipping code from db
$fetchSql = "SELECT * FROM `customer` WHERE `CUST_CODE`='$customerCode'";
$fetchResult = mysqli_query($conn, $fetchSql);
if ($fetchResult && $fetchResult->num_rows > 0) {
    $fetchData = $fetchResult->fetch_assoc();
    $billCode = $fetchData['CUST_BILLING_ADD'];
    $shipCode = $fetchData['CUST_SHIPPING_ADD'];
    $custGstin = $fetchData['CUST_GSTIN'];
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


?>

<div class="print bg-white">
    <style>
        .invoice-box {
            border: 1px solid black;
            color: black;
            overflow: hidden;
        }

        h5 {
            color: black;
        }

        p {
            margin: 0;
            font-size: 13px;
        }

        .invoice-heading {
            border: 1px solid black;
            color: black;
            text-align: center;
            background-color: #fce4d6;
        }

        .top-body {
            border-right: 1px solid black;
            border-left: 1px solid black;
        }

        .add-heading {
            background-color: #fff2cc;
            color: black;
            font-size: 15px;
            font-weight: bold;
            border: 1px solid black;
            border-left: none;
            border-right: none;
        }

        .detail-box {
            border-left: 1px solid black;
            border-bottom: 1px solid black;
        }

        .row {
            --bs-gutter-x: 0;
            --bs-gutter-y: 0;
            display: flex;
            flex-wrap: wrap;
            margin-top: calc(var(--bs-gutter-y) * -1);
            margin-right: calc(var(--bs-gutter-x) / -2);
            margin-left: calc(var(--bs-gutter-x) / -2);
        }

        /* table css  */

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            color: black;
            white-space: normal;
            word-break: auto-phrase;
        }

        tr.table-head td {
            background: #fff2cc;
        }

        table td,
        table th {
            border: 1px solid #000;
            padding: 0px 5px;
            vertical-align: top;
            font-size: 13px;
        }

        .no-border td {
            border: none;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .signature {
            height: 50px;
        }

        .small {
            font-size: 12px;
        }

        .in-words {
            border: 1px solid black;
            /* border-top: none; */
            color: black;

        }

        @media print {
            @page {
                margin: 30px;
            }

            body * {
                visibility: hidden;
            }

            .print,
            .print * {
                visibility: visible;
            }

            .print {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            /* You can also hide specific elements if they are part of your page content */
            .no-print {
                display: none;
            }
        }
    </style>

    <!-- invoice design  -->
    <div class="invoice-box bg-white text-capitalize">
        <div class="invoice-heading">
            <h5 class="m-0 px-1">Tax Invoice</h5>
        </div>
        <div class="top-body row">
            <div class="col-6">
                <div class="address-details">
                    <div class="add-1 px-1">
                        <strong>Icontech Projects And Services Private Limited</strong><br>
                        <p>C-89, Vibhuti Khand<br>
                            Gomti Nagar, Lucknow<br>
                            GSTIN/UIN: 09AAECI8307L1Z4<br>
                            State Name: Uttar Pradesh<br>
                            Contact: +91 522 3517741<br>
                            E-Mail: icontechindia17@gmail.com</p>
                        <!-- <p class="mb-5">Selles address</p> -->
                    </div>
                    <div class="add-2">
                        <div class="add-heading px-1">
                            Consignee (Ship to)
                        </div>
                        <div class="add px-1">
                            <!-- <strong>GN Universal Greens</strong><br>
                            <p>1327, Sector-16, Indira Nagar<br>
                                Lucknow<br>
                                GSTIN/UIN: 09AFKPT5926R1ZA<br>
                                State Name: Uttar Pradesh Code: 09<br>
                            </p> -->
                            <?php
                            include 'db-conn.php';
                            $shipSql = "SELECT * FROM `sales_order_ship_add` WHERE `SOS_CODE`='$shipCode' AND `SOS_SO_CODE`='$SOCode'";
                            $shipResult = mysqli_query($conn, $shipSql);
                            if ($shipResult && $shipResult->num_rows > 0) {
                                $data = $shipResult->fetch_assoc();
                                echo '
                                        <strong>' . $data['SOS_NAME'] . '</strong><br />
                                        <p>' . $data['SOS_ADDRESS_1'] . ' ' . $data['SOS_ADDRESS_2'] . ',<br />
                                        ' . $data['SOS_CITY'] . ',' . $data['SOS_STATE'] . '-' . $data['SOS_PINCODE'] . '<br />
                                        ' . $data['SOS_COUNTRY'] . '<br>
                                        GSTIN: ' . $custGstin . '<br>
                                        State Name:' . $data['SOS_STATE'] . '</p>
                                    ';
                            }

                            ?>
                        </div>
                    </div>
                    <div class="add-3">
                        <div class="add-heading px-1">
                            Buyer (Bill to)
                        </div>
                        <div class="add px-1">
                            <!-- <strong>GN Universal Greens</strong><br>
                            <p>1327, Sector-16, Indira Nagar<br>
                                Lucknow<br>
                                GSTIN/UIN: 09AFKPT5926R1ZA<br>
                                State Name: Uttar Pradesh Code: 09<br>
                                Place of Supply : Uttar Pradesh <br>
                            </p> -->

                            <?php

                            $billTo = '';
                            $billSql = "SELECT * FROM `sales_order_bill_add` WHERE (`SOB_CODE`='$billCode' AND `SOB_SO_CODE`='$SOCode') LIMIT 1";
                            $billResult = mysqli_query($conn, $billSql);
                            if ($billResult && $billResult->num_rows > 0) {
                                $data = $billResult->fetch_assoc();
                                $billTo = $data['SOB_NAME'];
                                echo '
                                        <strong>' . $data['SOB_NAME'] . '</strong><br />
                                        <p>' . $data['SOB_ADDRESS_1'] . ' ' . $data['SOB_ADDRESS_2'] . ',<br />
                                        ' . $data['SOB_CITY'] . ',' . $data['SOB_STATE'] . '-' . $data['SOB_PINCODE'] . '<br />
                                        ' . $data['SOB_COUNTRY'] . '<br>
                                        GSTIN: ' . $custGstin . '<br>
                                        State Name:' . $data['SOB_STATE'] . '</p>
                                    ';
                            }

                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="invoice-details col-6 h-100">
                <div class="row">
                    <div class="detail-box col-6 px-1">
                        <p>Invoice No. </p>
                        <p class="fw-bold"><?php echo $SOCode; ?></p>
                    </div>
                    <div class="detail-box col-6 px-1">
                        <p>Dated</p>
                        <p class="fw-bold"><?php echo $invoicedate; ?></p>
                    </div>
                    <div class="detail-box col-6 px-1">
                        <p>Delivery Note</p><br>
                        <p class="fw-bold"></p>
                    </div>
                    <div class="detail-box col-6 px-1">
                        <p>Mode/Terms of Payment </p><br>
                        <p class="fw-bold"></p>
                    </div>
                    <div class="detail-box col-6 px-1">
                        <p>Reference No. & Date.</p><br>
                        <p class="fw-bold"></p>
                    </div>
                    <div class="detail-box col-6 px-1">
                        <p>Other References</p><br>
                        <p class="fw-bold"></p>
                    </div>
                    <div class="detail-box col-6 px-1">
                        <p>Buyer's Order No.</p><br>
                        <p class="fw-bold"></p>
                    </div>
                    <div class="detail-box col-6 px-1">
                        <p>Dated</p><br>
                        <p class="fw-bold"></p>
                    </div>
                    <div class="detail-box col-6 px-1">
                        <p>Dispatch Doc No.</p><br>
                        <p class="fw-bold"></p>
                    </div>
                    <div class="detail-box col-6 px-1">
                        <p>Delivery Note Date</p><br>
                        <p class="fw-bold"></p>
                    </div>
                    <div class="detail-box col-6 px-1">
                        <p>Dispatched through</p><br>
                        <p class="fw-bold"></p>
                    </div>
                    <div class="detail-box col-6 px-1">
                        <p>Destination</p><br>
                        <p class="fw-bold"></p>
                    </div>
                    <div class="detail-box col-6 px-1">
                        <p>Bill of Lading/LR-RR No.</p><br>
                        <p class="fw-bold"></p>
                    </div>
                    <div class="detail-box col-6 px-1">
                        <p>Motor Vehicle No.</p><br>
                        <p class="fw-bold"></p>
                    </div>
                    <div class="detail-box border-bottom-0 col-12 px-1" style="height: 130px;">
                        <p>Terms of Delivery</p><br>
                        <p class="fw-bold"></p>
                    </div>
                </div>
            </div>
        </div>
        <table class="mt-0" style="word-wrap: normal;">
            <tbody>
                <tr class="bold center table-head">
                    <td>Sl. No.</td>
                    <td>Description of Goods</td>
                    <td>HSN/SAC</td>
                    <td>Qty</td>
                    <td>Rate</td>
                    <td>Per</td>
                    <td>Amount</td>
                </tr>
                <!-- <tr>
                    <td class="center">1</td>
                    <td>Website - Maintenance Services<br>From 01-June-2025 To 31-May-2026</td>
                    <td class="center">998313</td>
                    <td class="center">1 Nos</td>
                    <td class="right">2,500.00</td>
                    <td class="center">Nos</td>
                    <td class="right">2,500.00</td>
                </tr> -->


                <?php
                $count = 0;
                $totalAmountWOGST = 0;
                $totalGSTVal = 0;
                $totalGST = 0;

                $productSql = "SELECT * FROM `sales_order_item` WHERE `SOI_SO_CODE`='$SOCode'";
                $productResult = mysqli_query($conn, $productSql);
                if ($productResult && $productResult->num_rows > 0) {
                    while ($data = $productResult->fetch_assoc()) {
                        $count++;
                        // $proNameSql = "SELECT PRO_NAME,PRO_UOM,PRO_HSNNO FROM `product` WHERE `PRO_CODE`='" . $data['SOI_PRO_CODE'] . "'";
                        // $proNameRes = mysqli_query($conn, $proNameSql);
                        // $proData = $proNameRes->fetch_assoc();
                        // $proName = $proData['PRO_NAME'];
                        // $proUOM = $proData['PRO_UOM'];
                        // $proHSNNo = ($proData['PRO_HSNNO'] == null ? '' : $proData['PRO_']);

                        // geting total without gst with discount
                        $totalAmountWOGST += (float)$data['SOI_TOTAL_WITHOUT_GST'];
                        $totalGSTVal += (float)$data['SOI_GST_VAL'];
                        $totalGST += (float)(str_replace("%", "", $data['SOI_GST']));

                        echo '
                            <tr>
                                <td class="center">' . $count . '</td>
                                <td>' . $data['SOI_PRO_DESC'] . '</td>
                                <td class="right">' . $data['SOI_PRO_HSNNO'] . '</td>
                                <td class="right">' . $data['SOI_PRO_QUANTITY'] . '</td>
                                <td class="right">' . number_format($data['SOI_PRO_PRICE']) . '</td>
                                <td class="right">' . (empty($data['SOI_PRO_UOM']) ? 'Nos' : $data['SOI_PRO_UOM']) . '</td>
                                <td class="right">' . number_format($data['SOI_TOTAL_WITHOUT_GST']) . '</td>
                            </tr>
                            ';
                    }
                }

                ?>




                <tr>
                    <td colspan="" class=""></td>
                    <td colspan="2" class="right bold">Total</td>
                    <td colspan="" class=""></td>
                    <td colspan="" class=""></td>
                    <td colspan="" class=""></td>
                    <td class="right bold"><?php echo '<span>' . $curSymbol . '</span> ' . number_format($totalAmountWOGST); ?></td>
                </tr>
                <tr>
                    <td colspan="" class=""></td>
                    <td colspan="2" class="right bold">CGST</td>
                    <td colspan="" class=""></td>
                    <td colspan="" class=""></td>
                    <td colspan="" class=""></td>
                    <td class="right"><?php echo number_format($totalGSTVal / 2, 2); ?></td>
                </tr>
                <tr>
                    <td colspan="" class=""></td>
                    <td colspan="2" class="right bold">SGST</td>
                    <td colspan="" class=""></td>
                    <td colspan="" class=""></td>
                    <td colspan="" class=""></td>
                    <td class="right"><?php echo number_format($totalGSTVal / 2, 2); ?></td>
                </tr>
                <tr>
                    <td colspan="" class=""></td>
                    <td colspan="2" class="bold">
                        <div class="d-flex justify-content-between">
                            Less
                            <div class="">ROUNDING OFF</div>
                        </div>
                    </td>
                    <td colspan="" class=""></td>
                    <td colspan="" class=""></td>
                    <td colspan="" class=""></td>
                    <td class="right"><?php echo number_format(round($totalGSTVal) - $totalGSTVal, 2); ?></td>
                </tr>
                <tr>
                    <td colspan="" class=""></td>
                    <td colspan="2" class="right bold">TOTAL</td>
                    <td colspan="" class=""></td>
                    <td colspan="" class=""></td>
                    <td colspan="" class=""></td>
                    <td class="right bold total-amount"><?php echo '<span>' . $curSymbol . '</span> ' . number_format(round($grandTotalPrice)); ?></td>
                </tr>
            </tbody>
        </table>

        <div class="in-words px-1 bg-white">
            <p class=" mt-0">Amount Chargeable (in words)</p>
            <p class="bold fs-6 total-words"></p>
        </div>

        <style>
            .table-bordered td,
            .table-bordered th {
                border: 1px solid black !important;
                text-align: center;
                vertical-align: middle;
            }

            .bg-light-yellow {
                background-color: #fff2cc;
            }

            .bold {
                font-weight: bold;
            }

            .expand {
                padding: 0px 100px;
            }

            .border-sta {
                border-left: 1px solid black;
                padding: 0px 10px;
            }
        </style>

        <table class="mt-0">
            <tbody>
                <tr class="center bold table-head">
                    <td rowspan="2" class="expand"></td>
                    <td rowspan="2">Taxable Value</td>
                    <td colspan="2">CGST</td>
                    <td colspan="2">SGST/UTGST</td>
                    <td colspan="2">Total</td>
                </tr>
                <tr class="center bold table-head">
                    <td>Rate</td>
                    <td>Amount</td>
                    <td>Rate</td>
                    <td>Amount</td>
                    <td>Tax Amount</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-end bold"><?php echo '<span>' . $curSymbol . '</span> ' . number_format($totalAmountWOGST); ?></td>
                    <td class="text-end"><?php echo number_format((($totalGSTVal / 2) / $totalAmountWOGST) * 100, 2); ?>%</td>
                    <td class="text-end"><?php echo number_format($totalGSTVal / 2, 2); ?></td>
                    <td class="text-end"><?php echo number_format((($totalGSTVal / 2) / $totalAmountWOGST) * 100, 2); ?>%</td>
                    <td class="text-end"><?php echo number_format($totalGSTVal / 2, 2); ?></td>
                    <td class="text-end"><?php echo number_format($totalGSTVal, 2); ?></td>
                </tr>
                <tr>
                    <td class="text-end bold">
                        <p class="border-sta d-inline">Total</p>
                    </td>
                    <td class="text-end bold"><?php echo '<span>' . $curSymbol . '</span> ' . number_format($totalAmountWOGST); ?></td>
                    <td class="text-end bold"></td>
                    <td class="text-end bold"><?php echo number_format($totalGSTVal / 2, 2); ?></td>
                    <td class="text-end bold"></td>
                    <td class="text-end bold"><?php echo number_format($totalGSTVal / 2, 2); ?></td>
                    <td class="text-end bold tax-amount"><?php echo number_format($totalGSTVal, 2); ?></td>
                </tr>
            </tbody>
        </table>

        <div class="in-words px-1 bg-white">
            <p class="bold mt-0 tax-words">Tax Amount (in words): INR Four Hundred Fifty Only</p>
        </div>

        <table class="mt-0">
            <tbody>
                <tr>
                    <td>
                        <strong>Declaration:</strong><br>
                        We declare that this invoice shows the actual price of the goods<br>
                        described and that all particulars are true and correct.
                    </td>
                    <td>
                        <!-- <strong>Company Bank Account Details</strong><br>
                        Name: ICONTECH PROJECTS AND SERVICES PRIVATE LIMITED<br>
                        Account Number: 5800200000142<br>
                        Bank Name: Bank of Baroda<br>
                        Branch: SECTOR 14 INDIRANAGAR, UP<br>
                        IFSC Code: BARB0INDLUC -->
                        <!-- <strong>Seller's</strong><br>
                        Banking details -->
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Customer's Seal and Signature</strong>
                    </td>
                    <td>
                        <div class="mb-5"><strong>For Icontech Projects And Services Private Limited</strong></div>
                        Authorised Signatory
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
    <p class="text-center bg-white text-black">SUBJECT TO LUCKNOW JURISDICTION <br>
        This is a Computer Generated Invoice</p>

    <!-- <div class="printing-date text-end d-none">
        <?php
        $printingDate = date('Y-m-d');
        echo 'Invoice printing date : ' . $printingDate;
        ?>
    </div> -->
</div>


<!-- buttons  -->
<div class="print-btn text-center mt-3 mb-5">
    <!-- <a href="\Office\Browz Invoice\pages\update-sales-order.php?inv=<?php echo $SOCode; ?>">
        <button class="update" type="button">Update</button>
    </a> -->
    <button class="save print-btn mx-1" type="button" onclick="printInvoice()">Print Invoice</button>
    <a href="\Office\Browz Invoice\pages\sales-order.php">
        <button class="delete" type="button">Back</button>
    </a>
</div>


<script>
    // print invoice code
    document.title = "Invoice - <?php echo $billTo; ?>";

    function printInvoice() {
        // let printData = document.querySelector('.print').innerHTML;
        // let bodyData = document.body.innerHTML;

        // document.body.innerHTML = printData;
        document.body.style.background = 'white';

        // window.focus();
        window.print();
        // printData.print();

        // document.body.innerHTML = bodyData;

        location.reload();
    }
</script>

<!-- convert number to words  -->
<script>
    function convertToWords(n) {
        if (n === 0)
            return "Zero";

        // Words for numbers 0 to 19
        const units = [
            "", "One", "Two", "Three",
            "Four", "Five", "Six", "Seven",
            "Eight", "Nine", "Ten", "Eleven",
            "Twelve", "Thirteen", "Fourteen", "Fifteen",
            "Sixteen", "Seventeen", "Eighteen", "Nineteen"
        ];

        // Words for numbers multiple of 10        
        const tens = [
            "", "", "Twenty", "Thirty", "Forty",
            "Fifty", "Sixty", "Seventy", "Eighty", "Ninety"
        ];

        const multiplier = ["", "Thousand", "Million", "Billion"];

        let res = "";
        let group = 0;

        // Process number in group of 1000s
        while (n > 0) {
            if (n % 1000 !== 0) {

                let value = n % 1000;
                let temp = "";

                // Handle 3 digit number
                if (value >= 100) {
                    temp = units[Math.floor(value / 100)] + " Hundred ";
                    value %= 100;
                }

                // Handle 2 digit number
                if (value >= 20) {
                    temp += tens[Math.floor(value / 10)] + " ";
                    value %= 10;
                }

                // Handle unit number
                if (value > 0) {
                    temp += units[value] + " ";
                }

                // Add the multiplier according to the group
                temp += multiplier[group] + " ";

                // Add the result of this group to overall result
                res = temp + res;
            }
            n = Math.floor(n / 1000);
            group++;
        }

        // Remove trailing space
        return res.trim();
    }


    // console.log(convertToWords(n));
    let total = document.querySelector('.total-amount').innerHTML;
    let totalWords = document.querySelector('.total-words');

    let totalTax = document.querySelector('.tax-amount').innerHTML;
    let totalTaxWords = document.querySelector('.tax-words');

    // Extract the number part from the total (e.g., "₹ 12,345")
    let noArray = total.replace(/,/g, '').split(' ');
    let totalNo = Math.round(parseFloat(noArray[1]));
    let taxNo = Math.round(parseFloat(totalTax.replace(/,/g, '')));
    console.log(noArray[1], totalNo, taxNo);

    // Format numbers with commas
    let formattedTotal = totalNo.toLocaleString('en-IN');
    let formattedTax = taxNo.toLocaleString('en-IN');

    // for total amount 
    let words = convertToWords(totalNo);
    totalWords.innerHTML = `<i><?php echo $currency; ?> ${words} Only (${formattedTotal})</i>`;

    // for tax amount 
    let taxWords = convertToWords(taxNo);
    totalTaxWords.innerHTML = `<i>Tax Amount (in words): <?php echo $currency; ?> ${taxWords} Only (${formattedTax})</i>`;
</script>


<?php include "../pages/footer.php"; ?>