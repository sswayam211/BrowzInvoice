<!-- including side nav bar  -->
<?php include 'side-nav.php'; ?>


<div class="add-form py-5">
    <form action="\Office\Browz Invoice\php\handle-update-currency.php" method="post" class="col-md-8 col-sm-10 m-auto shadow p-sm-5 py-5 p-3" style="background-color: white;">
        <div class="form-heading mb-5">
            <h3 class="m-0">Update Currency</h3>
        </div>

        <div class="alert-box">
            <?php
            $message = false;
            $error = false;

            if (isset($_GET['u']) && $_GET['u'] == '1') {
                $message = 'currency updated successfully!';
            } else if (isset($_GET['u']) && $_GET['u'] == '0') {
                $error = 'Fail to update currency, please try again';
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

        $updatecurrency = (isset($_GET['update']) ? $_GET['update'] : '');

        include 'db-conn.php';
        $updateSql = "SELECT * FROM `currency` WHERE `CURRENCY_CODE`='$updatecurrency' LIMIT 1";
        $updateResult = mysqli_query($conn, $updateSql);
        if ($updateResult && $updateResult->num_rows > 0) {
            while ($data = $updateResult->fetch_assoc()) {

                echo '
                <div class="row">
                    <div class="form-group col-md-8 mb-4">
                        <select id="country" name="country" required>
                            <option value="' . $data['COUNTRY_NAME'] . '" selected>' . $data['COUNTRY_NAME'] . '</option>
                        </select>
                        <label for="country">
                            Country<span class="required">*</span>
                        </label>
                    </div>
                    <div class="form-group col-md-4 mb-4">
                        <input type="hidden" class="number" name="country-code" id="country-code-1" placeholder="" value="' . $data['COUNTRY_CODE'] . '" required>
                        <input type="text" class="number" name="country-code" id="country-code-2" placeholder="" value="' . $data['COUNTRY_CODE'] . '" disabled required>
                        <label for="country-code-1">Country Code<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-4 mb-4">
                        <input type="hidden" name="prev-currency-code" id="currency-code" placeholder="" value="' . $data['CURRENCY_CODE'] . '" required>
                        <input type="hidden" name="upd-currency-code" id="currency-code-1" placeholder="" value="' . $data['CURRENCY_CODE'] . '" required>
                        <input type="text" name="currency-code" id="currency-code-2" placeholder="" value="' . $data['CURRENCY_CODE'] . '" disabled required>
                        <label for="currency-code">Currency Code<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-4 mb-4">
                        <input type="hidden" class="number" name="currency-name" id="currency-name-1" placeholder="" value="' . $data['CURRENCY'] . '" required>
                        <input type="text" class="number" name="currency-name" id="currency-name-2" placeholder="" value="' . $data['CURRENCY'] . '" disabled required>
                        <label for="currency-name-1">Currency Name<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-4 mb-4">
                        <input type="hidden" class="number" name="currency-symbol" id="currency-symbol-1" placeholder="" value="' . $data['CURRENCY_SYMBOL'] . '" required>
                        <input type="text" class="number" name="currency-symbol" id="currency-symbol-2" placeholder="" value="' . $data['CURRENCY_SYMBOL'] . '" disabled required>
                        <label for="currency-symbol-1">Currency Symbol<span class="required">*</span></label>
                    </div>
                    <div class="form-group col-md-4 mb-4">
                        <select id="status" name="status" required>
                            <option  value="' . $data['STATUE'] . '" selected > ' . $data['STATUE'] . '</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        <label for="status">
                            Status<span class="required">*</span>
                        </label>
                    </div>
                </div>
                ';
            }
        }

        ?>

        <div class="button mt-2">
            <button class="save" type="submit">Save</button>
            <a href="currency-page.php"><button class="cancel" type="button">Cancel</button></a>
        </div>
    </form>
</div>

<script>
    const countryDialCodes = [{
            name: "Afghanistan",
            dialCode: "+93",
            currency: {
                code: "AFN",
                name: "Afghan Afghani",
                symbol: "؋"
            }
        },
        {
            name: "Albania",
            dialCode: "+355",
            currency: {
                code: "ALL",
                name: "Albanian Lek",
                symbol: "L"
            }
        },
        {
            name: "Algeria",
            dialCode: "+213",
            currency: {
                code: "DZD",
                name: "Algerian Dinar",
                symbol: "DA"
            }
        },
        {
            name: "Andorra",
            dialCode: "+376",
            currency: {
                code: "EUR",
                name: "Euro",
                symbol: "€"
            }
        },
        {
            name: "Angola",
            dialCode: "+244",
            currency: {
                code: "AOA",
                name: "Angolan Kwanza",
                symbol: "Kz"
            }
        },
        {
            name: "Antigua and Barbuda",
            dialCode: "+1", // Part of North American Numbering Plan
            currency: {
                code: "XCD",
                name: "East Caribbean Dollar",
                symbol: "$"
            }
        },
        {
            name: "Argentina",
            dialCode: "+54",
            currency: {
                code: "ARS",
                name: "Argentine Peso",
                symbol: "$"
            }
        },
        {
            name: "Armenia",
            dialCode: "+374",
            currency: {
                code: "AMD",
                name: "Armenian Dram",
                symbol: "֏"
            }
        },
        {
            name: "Australia",
            dialCode: "+61",
            currency: {
                code: "AUD",
                name: "Australian Dollar",
                symbol: "$"
            }
        },
        {
            name: "Austria",
            dialCode: "+43",
            currency: {
                code: "EUR",
                name: "Euro",
                symbol: "€"
            }
        },
        {
            name: "Azerbaijan",
            dialCode: "+994",
            currency: {
                code: "AZN",
                name: "Azerbaijani Manat",
                symbol: "₼"
            }
        },
        {
            name: "Bahamas",
            dialCode: "+1-242", // Part of North American Numbering Plan
            currency: {
                code: "BSD",
                name: "Bahamian Dollar",
                symbol: "$"
            }
        },
        {
            name: "Bahrain",
            dialCode: "+973",
            currency: {
                code: "BHD",
                name: "Bahraini Dinar",
                symbol: ".د.ب"
            }
        },
        {
            name: "Bangladesh",
            dialCode: "+880",
            currency: {
                code: "BDT",
                name: "Bangladeshi Taka",
                symbol: "৳"
            }
        },
        {
            name: "Barbados",
            dialCode: "+1-246", // Part of North American Numbering Plan
            currency: {
                code: "BBD",
                name: "Barbadian Dollar",
                symbol: "$"
            }
        },
        {
            name: "Belarus",
            dialCode: "+375",
            currency: {
                code: "BYN",
                name: "Belarusian Ruble",
                symbol: "Br"
            }
        },
        {
            name: "Belgium",
            dialCode: "+32",
            currency: {
                code: "EUR",
                name: "Euro",
                symbol: "€"
            }
        },
        {
            name: "Belize",
            dialCode: "+501",
            currency: {
                code: "BZD",
                name: "Belize Dollar",
                symbol: "$"
            }
        },
        {
            name: "Benin",
            dialCode: "+229",
            currency: {
                code: "XOF", // CFA Franc BCEAO
                name: "West African CFA franc",
                symbol: "XOF"
            }
        },
        {
            name: "Bhutan",
            dialCode: "+975",
            currency: {
                code: "BTN",
                name: "Bhutanese Ngultrum",
                symbol: "Nu."
            }
        },
        {
            name: "Bolivia",
            dialCode: "+591",
            currency: {
                code: "BOB",
                name: "Bolivian Boliviano",
                symbol: "Bs."
            }
        },
        {
            name: "Bosnia and Herzegovina",
            dialCode: "+387",
            currency: {
                code: "BAM",
                name: "Bosnia and Herzegovina Convertible Mark",
                symbol: "KM"
            }
        },
        {
            name: "Botswana",
            dialCode: "+267",
            currency: {
                code: "BWP",
                name: "Botswana Pula",
                symbol: "P"
            }
        },
        {
            name: "Brazil",
            dialCode: "+55",
            currency: {
                code: "BRL",
                name: "Brazilian Real",
                symbol: "R$"
            }
        },
        {
            name: "Brunei",
            dialCode: "+673",
            currency: {
                code: "BND",
                name: "Brunei Dollar",
                symbol: "$"
            }
        },
        {
            name: "Bulgaria",
            dialCode: "+359",
            currency: {
                code: "BGN",
                name: "Bulgarian Lev",
                symbol: "лв"
            }
        },
        {
            name: "Burkina Faso",
            dialCode: "+226",
            currency: {
                code: "XOF",
                name: "West African CFA franc",
                symbol: "XOF"
            }
        },
        {
            name: "Burundi",
            dialCode: "+257",
            currency: {
                code: "BIF",
                name: "Burundian Franc",
                symbol: "FBu"
            }
        },
        {
            name: "Cabo Verde",
            dialCode: "+238",
            currency: {
                code: "CVE",
                name: "Cape Verdean Escudo",
                symbol: "Esc"
            }
        },
        {
            name: "Cambodia",
            dialCode: "+855",
            currency: {
                code: "KHR",
                name: "Cambodian Riel",
                symbol: "៛"
            }
        },
        {
            name: "Cameroon",
            dialCode: "+237",
            currency: {
                code: "XAF", // CFA Franc BEAC
                name: "Central African CFA franc",
                symbol: "XAF"
            }
        },
        {
            name: "Canada",
            dialCode: "+1", // Part of North American Numbering Plan
            currency: {
                code: "CAD",
                name: "Canadian Dollar",
                symbol: "$"
            }
        },
        {
            name: "Central African Republic",
            dialCode: "+236",
            currency: {
                code: "XAF",
                name: "Central African CFA franc",
                symbol: "XAF"
            }
        },
        {
            name: "Chad",
            dialCode: "+235",
            currency: {
                code: "XAF",
                name: "Central African CFA franc",
                symbol: "XAF"
            }
        },
        {
            name: "Chile",
            dialCode: "+56",
            currency: {
                code: "CLP",
                name: "Chilean Peso",
                symbol: "$"
            }
        },
        {
            name: "China",
            dialCode: "+86",
            currency: {
                code: "CNY",
                name: "Chinese Yuan",
                symbol: "¥"
            }
        },
        {
            name: "Colombia",
            dialCode: "+57",
            currency: {
                code: "COP",
                name: "Colombian Peso",
                symbol: "$"
            }
        },
        {
            name: "Comoros",
            dialCode: "+269",
            currency: {
                code: "KMF",
                name: "Comorian Franc",
                symbol: "CF"
            }
        },
        {
            name: "Congo (Congo-Brazzaville)",
            dialCode: "+242",
            currency: {
                code: "XAF",
                name: "Central African CFA franc",
                symbol: "XAF"
            }
        },
        {
            name: "Costa Rica",
            dialCode: "+506",
            currency: {
                code: "CRC",
                name: "Costa Rican Colón",
                symbol: "₡"
            }
        },
        {
            name: "Côte d'Ivoire",
            dialCode: "+225",
            currency: {
                code: "XOF",
                name: "West African CFA franc",
                symbol: "XOF"
            }
        },
        {
            name: "Croatia",
            dialCode: "+385",
            currency: {
                code: "EUR", // Croatia joined the Eurozone on Jan 1, 2023
                name: "Euro",
                symbol: "€"
            }
        },
        {
            name: "Cuba",
            dialCode: "+53",
            currency: {
                code: "CUP",
                name: "Cuban Peso",
                symbol: "$"
            }
        },
        {
            name: "Cyprus",
            dialCode: "+357",
            currency: {
                code: "EUR",
                name: "Euro",
                symbol: "€"
            }
        },
        {
            name: "Czechia (Czech Republic)",
            dialCode: "+420",
            currency: {
                code: "CZK",
                name: "Czech Koruna",
                symbol: "Kč"
            }
        },
        {
            name: "Democratic Republic of the Congo",
            dialCode: "+243",
            currency: {
                code: "CDF",
                name: "Congolese Franc",
                symbol: "FC"
            }
        },
        {
            name: "Denmark",
            dialCode: "+45",
            currency: {
                code: "DKK",
                name: "Danish Krone",
                symbol: "kr"
            }
        },
        {
            name: "Djibouti",
            dialCode: "+253",
            currency: {
                code: "DJF",
                name: "Djiboutian Franc",
                symbol: "Fdj"
            }
        },
        {
            name: "Dominica",
            dialCode: "+1-767", // Part of North American Numbering Plan
            currency: {
                code: "XCD",
                name: "East Caribbean Dollar",
                symbol: "$"
            }
        },
        {
            name: "Dominican Republic",
            dialCode: "+1-809", // Part of North American Numbering Plan
            currency: {
                code: "DOP",
                name: "Dominican Peso",
                symbol: "RD$"
            }
        },
        {
            name: "Ecuador",
            dialCode: "+593",
            currency: {
                code: "USD",
                name: "United States Dollar",
                symbol: "$"
            }
        },
        {
            name: "Egypt",
            dialCode: "+20",
            currency: {
                code: "EGP",
                name: "Egyptian Pound",
                symbol: "E£"
            }
        },
        {
            name: "El Salvador",
            dialCode: "+503",
            currency: {
                code: "USD",
                name: "United States Dollar",
                symbol: "$"
            }
        },
        {
            name: "Equatorial Guinea",
            dialCode: "+240",
            currency: {
                code: "XAF",
                name: "Central African CFA franc",
                symbol: "XAF"
            }
        },
        {
            name: "Eritrea",
            dialCode: "+291",
            currency: {
                code: "ERN",
                name: "Eritrean Nakfa",
                symbol: "Nfk"
            }
        },
        {
            name: "Estonia",
            dialCode: "+372",
            currency: {
                code: "EUR",
                name: "Euro",
                symbol: "€"
            }
        },
        {
            name: "Eswatini (formerly Swaziland)",
            dialCode: "+268",
            currency: {
                code: "SZL",
                name: "Swazi Lilangeni",
                symbol: "E"
            }
        },
        {
            name: "Ethiopia",
            dialCode: "+251",
            currency: {
                code: "ETB",
                name: "Ethiopian Birr",
                symbol: "Br"
            }
        },
        {
            name: "Fiji",
            dialCode: "+679",
            currency: {
                code: "FJD",
                name: "Fijian Dollar",
                symbol: "$"
            }
        },
        {
            name: "Finland",
            dialCode: "+358",
            currency: {
                code: "EUR",
                name: "Euro",
                symbol: "€"
            }
        },
        {
            name: "France",
            dialCode: "+33",
            currency: {
                code: "EUR",
                name: "Euro",
                symbol: "€"
            }
        },
        {
            name: "Gabon",
            dialCode: "+241",
            currency: {
                code: "XAF",
                name: "Central African CFA franc",
                symbol: "XAF"
            }
        },
        {
            name: "Gambia",
            dialCode: "+220",
            currency: {
                code: "GMD",
                name: "Gambian Dalasi",
                symbol: "D"
            }
        },
        {
            name: "Georgia",
            dialCode: "+995",
            currency: {
                code: "GEL",
                name: "Georgian Lari",
                symbol: "₾"
            }
        },
        {
            name: "Germany",
            dialCode: "+49",
            currency: {
                code: "EUR",
                name: "Euro",
                symbol: "€"
            }
        },
        {
            name: "Ghana",
            dialCode: "+233",
            currency: {
                code: "GHS",
                name: "Ghanaian Cedi",
                symbol: "₵"
            }
        },
        {
            name: "Greece",
            dialCode: "+30",
            currency: {
                code: "EUR",
                name: "Euro",
                symbol: "€"
            }
        },
        {
            name: "Grenada",
            dialCode: "+1-473", // Part of North American Numbering Plan
            currency: {
                code: "XCD",
                name: "East Caribbean Dollar",
                symbol: "$"
            }
        },
        {
            name: "Guatemala",
            dialCode: "+502",
            currency: {
                code: "GTQ",
                name: "Guatemalan Quetzal",
                symbol: "Q"
            }
        },
        {
            name: "Guinea",
            dialCode: "+224",
            currency: {
                code: "GNF",
                name: "Guinean Franc",
                symbol: "FG"
            }
        },
        {
            name: "Guinea-Bissau",
            dialCode: "+245",
            currency: {
                code: "XOF",
                name: "West African CFA franc",
                symbol: "XOF"
            }
        },
        {
            name: "Guyana",
            dialCode: "+592",
            currency: {
                code: "GYD",
                name: "Guyanese Dollar",
                symbol: "$"
            }
        },
        {
            name: "Haiti",
            dialCode: "+509",
            currency: {
                code: "HTG",
                name: "Haitian Gourde",
                symbol: "G"
            }
        },
        {
            name: "Holy See (Vatican City)",
            dialCode: "+379",
            currency: {
                code: "EUR",
                name: "Euro",
                symbol: "€"
            }
        },
        {
            name: "Honduras",
            dialCode: "+504",
            currency: {
                code: "HNL",
                name: "Honduran Lempira",
                symbol: "L"
            }
        },
        {
            name: "Hungary",
            dialCode: "+36",
            currency: {
                code: "HUF",
                name: "Hungarian Forint",
                symbol: "Ft"
            }
        },
        {
            name: "Iceland",
            dialCode: "+354",
            currency: {
                code: "ISK",
                name: "Icelandic Króna",
                symbol: "kr"
            }
        },
        {
            name: "India",
            dialCode: "+91",
            currency: {
                code: "INR",
                name: "Indian Rupee",
                symbol: "₹"
            }
        },
        {
            name: "Indonesia",
            dialCode: "+62",
            currency: {
                code: "IDR",
                name: "Indonesian Rupiah",
                symbol: "Rp"
            }
        },
        {
            name: "Iran",
            dialCode: "+98",
            currency: {
                code: "IRR",
                name: "Iranian Rial",
                symbol: "﷼"
            }
        },
        {
            name: "Iraq",
            dialCode: "+964",
            currency: {
                code: "IQD",
                name: "Iraqi Dinar",
                symbol: "ع.د"
            }
        },
        {
            name: "Ireland",
            dialCode: "+353",
            currency: {
                code: "EUR",
                name: "Euro",
                symbol: "€"
            }
        },
        {
            name: "Israel",
            dialCode: "+972",
            currency: {
                code: "ILS",
                name: "Israeli New Shekel",
                symbol: "₪"
            }
        },
        {
            name: "Italy",
            dialCode: "+39",
            currency: {
                code: "EUR",
                name: "Euro",
                symbol: "€"
            }
        },
        {
            name: "Jamaica",
            dialCode: "+1-876", // Part of North American Numbering Plan
            currency: {
                code: "JMD",
                name: "Jamaican Dollar",
                symbol: "$"
            }
        },
        {
            name: "Japan",
            dialCode: "+81",
            currency: {
                code: "JPY",
                name: "Japanese Yen",
                symbol: "¥"
            }
        },
        {
            name: "Jordan",
            dialCode: "+962",
            currency: {
                code: "JOD",
                name: "Jordanian Dinar",
                symbol: "JD"
            }
        },
        {
            name: "Kazakhstan",
            dialCode: "+7",
            currency: {
                code: "KZT",
                name: "Kazakhstani Tenge",
                symbol: "₸"
            }
        },
        {
            name: "Kenya",
            dialCode: "+254",
            currency: {
                code: "KES",
                name: "Kenyan Shilling",
                symbol: "KSh"
            }
        },
        {
            name: "Kiribati",
            dialCode: "+686",
            currency: {
                code: "AUD",
                name: "Australian Dollar",
                symbol: "$"
            }
        },
        {
            name: "Kuwait",
            dialCode: "+965",
            currency: {
                code: "KWD",
                name: "Kuwaiti Dinar",
                symbol: "KD"
            }
        },
        {
            name: "Kyrgyzstan",
            dialCode: "+996",
            currency: {
                code: "KGS",
                name: "Kyrgyzstani Som",
                symbol: "лв"
            }
        },
        {
            name: "Laos",
            dialCode: "+856",
            currency: {
                code: "LAK",
                name: "Lao Kip",
                symbol: "₭"
            }
        },
        {
            name: "Latvia",
            dialCode: "+371",
            currency: {
                code: "EUR",
                name: "Euro",
                symbol: "€"
            }
        },
        {
            name: "Lebanon",
            dialCode: "+961",
            currency: {
                code: "LBP",
                name: "Lebanese Pound",
                symbol: "£"
            }
        },
        {
            name: "Lesotho",
            dialCode: "+266",
            currency: {
                code: "LSL",
                name: "Lesotho Loti",
                symbol: "L"
            }
        },
        {
            name: "Liberia",
            dialCode: "+231",
            currency: {
                code: "LRD",
                name: "Liberian Dollar",
                symbol: "$"
            }
        },
        {
            name: "Libya",
            dialCode: "+218",
            currency: {
                code: "LYD",
                name: "Libyan Dinar",
                symbol: "ل.د"
            }
        },
        {
            name: "Liechtenstein",
            dialCode: "+423",
            currency: {
                code: "CHF",
                name: "Swiss Franc",
                symbol: "CHF"
            }
        },
        {
            name: "Lithuania",
            dialCode: "+370",
            currency: {
                code: "EUR",
                name: "Euro",
                symbol: "€"
            }
        },
        {
            name: "Luxembourg",
            dialCode: "+352",
            currency: {
                code: "EUR",
                name: "Euro",
                symbol: "€"
            }
        },
        {
            name: "Madagascar",
            dialCode: "+261",
            currency: {
                code: "MGA",
                name: "Malagasy Ariary",
                symbol: "Ar"
            }
        },
        {
            name: "Malawi",
            dialCode: "+265",
            currency: {
                code: "MWK",
                name: "Malawian Kwacha",
                symbol: "MK"
            }
        },
        {
            name: "Malaysia",
            dialCode: "+60",
            currency: {
                code: "MYR",
                name: "Malaysian Ringgit",
                symbol: "RM"
            }
        },
        {
            name: "Maldives",
            dialCode: "+960",
            currency: {
                code: "MVR",
                name: "Maldivian Rufiyaa",
                symbol: "Rf"
            }
        },
        {
            name: "Mali",
            dialCode: "+223",
            currency: {
                code: "XOF",
                name: "West African CFA franc",
                symbol: "XOF"
            }
        },
        {
            name: "Malta",
            dialCode: "+356",
            currency: {
                code: "EUR",
                name: "Euro",
                symbol: "€"
            }
        },
        {
            name: "Marshall Islands",
            dialCode: "+692",
            currency: {
                code: "USD",
                name: "United States Dollar",
                symbol: "$"
            }
        },
        {
            name: "Mauritania",
            dialCode: "+222",
            currency: {
                code: "MRU",
                name: "Mauritanian Ouguiya",
                symbol: "UM"
            }
        },
        {
            name: "Mauritius",
            dialCode: "+230",
            currency: {
                code: "MUR",
                name: "Mauritian Rupee",
                symbol: "₨"
            }
        },
        {
            name: "Mexico",
            dialCode: "+52",
            currency: {
                code: "MXN",
                name: "Mexican Peso",
                symbol: "$"
            }
        },
        {
            name: "Micronesia",
            dialCode: "+691",
            currency: {
                code: "USD",
                name: "United States Dollar",
                symbol: "$"
            }
        },
        {
            name: "Moldova",
            dialCode: "+373",
            currency: {
                code: "MDL",
                name: "Moldovan Leu",
                symbol: "L"
            }
        },
        {
            name: "Monaco",
            dialCode: "+377",
            currency: {
                code: "EUR",
                name: "Euro",
                symbol: "€"
            }
        },
        {
            name: "Mongolia",
            dialCode: "+976",
            currency: {
                code: "MNT",
                name: "Mongolian Tögrög",
                symbol: "₮"
            }
        },
        {
            name: "Montenegro",
            dialCode: "+382",
            currency: {
                code: "EUR",
                name: "Euro",
                symbol: "€"
            }
        },
        {
            name: "Morocco",
            dialCode: "+212",
            currency: {
                code: "MAD",
                name: "Moroccan Dirham",
                symbol: "د.م."
            }
        },
        {
            name: "Mozambique",
            dialCode: "+258",
            currency: {
                code: "MZN",
                name: "Mozambican Metical",
                symbol: "MT"
            }
        },
        {
            name: "Myanmar (formerly Burma)",
            dialCode: "+95",
            currency: {
                code: "MMK",
                name: "Myanmar Kyat",
                symbol: "Ks"
            }
        },
        {
            name: "Namibia",
            dialCode: "+264",
            currency: {
                code: "NAD",
                name: "Namibian Dollar",
                symbol: "$"
            }
        },
        {
            name: "Nauru",
            dialCode: "+674",
            currency: {
                code: "AUD",
                name: "Australian Dollar",
                symbol: "$"
            }
        },
        {
            name: "Nepal",
            dialCode: "+977",
            currency: {
                code: "NPR",
                name: "Nepalese Rupee",
                symbol: "₨"
            }
        },
        {
            name: "Netherlands",
            dialCode: "+31",
            currency: {
                code: "EUR",
                name: "Euro",
                symbol: "€"
            }
        },
        {
            name: "New Zealand",
            dialCode: "+64",
            currency: {
                code: "NZD",
                name: "New Zealand Dollar",
                symbol: "$"
            }
        },
        {
            name: "Nicaragua",
            dialCode: "+505",
            currency: {
                code: "NIO",
                name: "Nicaraguan Córdoba",
                symbol: "C$"
            }
        },
        {
            name: "Niger",
            dialCode: "+227",
            currency: {
                code: "XOF",
                name: "West African CFA franc",
                symbol: "XOF"
            }
        },
        {
            name: "Nigeria",
            dialCode: "+234",
            currency: {
                code: "NGN",
                name: "Nigerian Naira",
                symbol: "₦"
            }
        },
        {
            name: "North Korea",
            dialCode: "+850",
            currency: {
                code: "KPW",
                name: "North Korean Won",
                symbol: "₩"
            }
        },
        {
            name: "North Macedonia",
            dialCode: "+389",
            currency: {
                code: "MKD",
                name: "Macedonian Denar",
                symbol: "ден"
            }
        },
        {
            name: "Norway",
            dialCode: "+47",
            currency: {
                code: "NOK",
                name: "Norwegian Krone",
                symbol: "kr"
            }
        },
        {
            name: "Oman",
            dialCode: "+968",
            currency: {
                code: "OMR",
                name: "Omani Rial",
                symbol: "﷼"
            }
        },
        {
            name: "Pakistan",
            dialCode: "+92",
            currency: {
                code: "PKR",
                name: "Pakistani Rupee",
                symbol: "₨"
            }
        },
        {
            name: "Palau",
            dialCode: "+680",
            currency: {
                code: "USD",
                name: "United States Dollar",
                symbol: "$"
            }
        },
        {
            name: "Palestine State",
            dialCode: "+970",
            currency: {
                code: "ILS", // Commonly uses Israeli New Shekel
                name: "Israeli New Shekel",
                symbol: "₪"
            }
        },
        {
            name: "Panama",
            dialCode: "+507",
            currency: {
                code: "PAB",
                name: "Panamanian Balboa",
                symbol: "B/."
            }
        },
        {
            name: "Papua New Guinea",
            dialCode: "+675",
            currency: {
                code: "PGK",
                name: "Papua New Guinean Kina",
                symbol: "K"
            }
        },
        {
            name: "Paraguay",
            dialCode: "+595",
            currency: {
                code: "PYG",
                name: "Paraguayan Guaraní",
                symbol: "₲"
            }
        },
        {
            name: "Peru",
            dialCode: "+51",
            currency: {
                code: "PEN",
                name: "Peruvian Sol",
                symbol: "S/."
            }
        },
        {
            name: "Philippines",
            dialCode: "+63",
            currency: {
                code: "PHP",
                name: "Philippine Peso",
                symbol: "₱"
            }
        },
        {
            name: "Poland",
            dialCode: "+48",
            currency: {
                code: "PLN",
                name: "Polish Złoty",
                symbol: "zł"
            }
        },
        {
            name: "Portugal",
            dialCode: "+351",
            currency: {
                code: "EUR",
                name: "Euro",
                symbol: "€"
            }
        },
        {
            name: "Qatar",
            dialCode: "+974",
            currency: {
                code: "QAR",
                name: "Qatari Riyal",
                symbol: "﷼"
            }
        },
        {
            name: "Romania",
            dialCode: "+40",
            currency: {
                code: "RON",
                name: "Romanian Leu",
                symbol: "lei"
            }
        },
        {
            name: "Russia",
            dialCode: "+7",
            currency: {
                code: "RUB",
                name: "Russian Ruble",
                symbol: "₽"
            }
        },
        {
            name: "Rwanda",
            dialCode: "+250",
            currency: {
                code: "RWF",
                name: "Rwandan Franc",
                symbol: "RF"
            }
        },
        {
            name: "Saint Kitts and Nevis",
            dialCode: "+1-869", // Part of North American Numbering Plan
            currency: {
                code: "XCD",
                name: "East Caribbean Dollar",
                symbol: "$"
            }
        },
        {
            name: "Saint Lucia",
            dialCode: "+1-758", // Part of North American Numbering Plan
            currency: {
                code: "XCD",
                name: "East Caribbean Dollar",
                symbol: "$"
            }
        },
        {
            name: "Saint Vincent and the Grenadines",
            dialCode: "+1-784", // Part of North American Numbering Plan
            currency: {
                code: "XCD",
                name: "East Caribbean Dollar",
                symbol: "$"
            }
        },
        {
            name: "Samoa",
            dialCode: "+685",
            currency: {
                code: "WST",
                name: "Samoan Tala",
                symbol: "WS$"
            }
        },
        {
            name: "San Marino",
            dialCode: "+378",
            currency: {
                code: "EUR",
                name: "Euro",
                symbol: "€"
            }
        },
        {
            name: "Sao Tome and Principe",
            dialCode: "+239",
            currency: {
                code: "STD", // Dobra, will be STP from 2018
                name: "São Tomé and Príncipe Dobra",
                symbol: "Db"
            }
        },
        {
            name: "Saudi Arabia",
            dialCode: "+966",
            currency: {
                code: "SAR",
                name: "Saudi Riyal",
                symbol: "﷼"
            }
        },
        {
            name: "Senegal",
            dialCode: "+221",
            currency: {
                code: "XOF",
                name: "West African CFA franc",
                symbol: "XOF"
            }
        },
        {
            name: "Serbia",
            dialCode: "+381",
            currency: {
                code: "RSD",
                name: "Serbian Dinar",
                symbol: "дин."
            }
        },
        {
            name: "Seychelles",
            dialCode: "+248",
            currency: {
                code: "SCR",
                name: "Seychellois Rupee",
                symbol: "₨"
            }
        },
        {
            name: "Sierra Leone",
            dialCode: "+232",
            currency: {
                code: "SLL",
                name: "Sierra Leonean Leone",
                symbol: "Le"
            }
        },
        {
            name: "Singapore",
            dialCode: "+65",
            currency: {
                code: "SGD",
                name: "Singapore Dollar",
                symbol: "$"
            }
        },
        {
            name: "Slovakia",
            dialCode: "+421",
            currency: {
                code: "EUR",
                name: "Euro",
                symbol: "€"
            }
        },
        {
            name: "Slovenia",
            dialCode: "+386",
            currency: {
                code: "EUR",
                name: "Euro",
                symbol: "€"
            }
        },
        {
            name: "Solomon Islands",
            dialCode: "+677",
            currency: {
                code: "SBD",
                name: "Solomon Islands Dollar",
                symbol: "$"
            }
        },
        {
            name: "Somalia",
            dialCode: "+252",
            currency: {
                code: "SOS",
                name: "Somali Shilling",
                symbol: "Sh"
            }
        },
        {
            name: "South Africa",
            dialCode: "+27",
            currency: {
                code: "ZAR",
                name: "South African Rand",
                symbol: "R"
            }
        },
        {
            name: "South Korea",
            dialCode: "+82",
            currency: {
                code: "KRW",
                name: "South Korean Won",
                symbol: "₩"
            }
        },
        {
            name: "South Sudan",
            dialCode: "+211",
            currency: {
                code: "SSP",
                name: "South Sudanese Pound",
                symbol: "£"
            }
        },
        {
            name: "Spain",
            dialCode: "+34",
            currency: {
                code: "EUR",
                name: "Euro",
                symbol: "€"
            }
        },
        {
            name: "Sri Lanka",
            dialCode: "+94",
            currency: {
                code: "LKR",
                name: "Sri Lankan Rupee",
                symbol: "₨"
            }
        },
        {
            name: "Sudan",
            dialCode: "+249",
            currency: {
                code: "SDG",
                name: "Sudanese Pound",
                symbol: "£"
            }
        },
        {
            name: "Suriname",
            dialCode: "+597",
            currency: {
                code: "SRD",
                name: "Surinamese Dollar",
                symbol: "$"
            }
        },
        {
            name: "Sweden",
            dialCode: "+46",
            currency: {
                code: "SEK",
                name: "Swedish Krona",
                symbol: "kr"
            }
        },
        {
            name: "Switzerland",
            dialCode: "+41",
            currency: {
                code: "CHF",
                name: "Swiss Franc",
                symbol: "CHF"
            }
        },
        {
            name: "Syria",
            dialCode: "+963",
            currency: {
                code: "SYP",
                name: "Syrian Pound",
                symbol: "£"
            }
        },
        {
            name: "Tajikistan",
            dialCode: "+992",
            currency: {
                code: "TJS",
                name: "Tajikistani Somoni",
                symbol: "ЅМ"
            }
        },
        {
            name: "Tanzania",
            dialCode: "+255",
            currency: {
                code: "TZS",
                name: "Tanzanian Shilling",
                symbol: "Sh"
            }
        },
        {
            name: "Thailand",
            dialCode: "+66",
            currency: {
                code: "THB",
                name: "Thai Baht",
                symbol: "฿"
            }
        },
        {
            name: "Timor-Leste",
            dialCode: "+670",
            currency: {
                code: "USD",
                name: "United States Dollar",
                symbol: "$"
            }
        },
        {
            name: "Togo",
            dialCode: "+228",
            currency: {
                code: "XOF",
                name: "West African CFA franc",
                symbol: "XOF"
            }
        },
        {
            name: "Tonga",
            dialCode: "+676",
            currency: {
                code: "TOP",
                name: "Tongan Paʻanga",
                symbol: "T$"
            }
        },
        {
            name: "Trinidad and Tobago",
            dialCode: "+1-868", // Part of North American Numbering Plan
            currency: {
                code: "TTD",
                name: "Trinidad and Tobago Dollar",
                symbol: "$"
            }
        },
        {
            name: "Tunisia",
            dialCode: "+216",
            currency: {
                code: "TND",
                name: "Tunisian Dinar",
                symbol: "د.ت"
            }
        },
        {
            name: "Turkey",
            dialCode: "+90",
            currency: {
                code: "TRY",
                name: "Turkish Lira",
                symbol: "₺"
            }
        },
        {
            name: "Turkmenistan",
            dialCode: "+993",
            currency: {
                code: "TMT",
                name: "Turkmenistani Manat",
                symbol: "m"
            }
        },
        {
            name: "Tuvalu",
            dialCode: "+688",
            currency: {
                code: "AUD",
                name: "Australian Dollar",
                symbol: "$"
            }
        },
        {
            name: "Uganda",
            dialCode: "+256",
            currency: {
                code: "UGX",
                name: "Ugandan Shilling",
                symbol: "USh"
            }
        },
        {
            name: "Ukraine",
            dialCode: "+380",
            currency: {
                code: "UAH",
                name: "Ukrainian Hryvnia",
                symbol: "₴"
            }
        },
        {
            name: "United Arab Emirates",
            dialCode: "+971",
            currency: {
                code: "AED",
                name: "United Arab Emirates Dirham",
                symbol: "د.إ"
            }
        },
        {
            name: "United Kingdom",
            dialCode: "+44",
            currency: {
                code: "GBP",
                name: "British Pound Sterling",
                symbol: "£"
            }
        },
        {
            name: "United States of America",
            dialCode: "+1",
            currency: {
                code: "USD",
                name: "United States Dollar",
                symbol: "$"
            }
        },
        {
            name: "Uruguay",
            dialCode: "+598",
            currency: {
                code: "UYU",
                name: "Uruguayan Peso",
                symbol: "$U"
            }
        },
        {
            name: "Uzbekistan",
            dialCode: "+998",
            currency: {
                code: "UZS",
                name: "Uzbekistani Som",
                symbol: "лв"
            }
        },
        {
            name: "Vanuatu",
            dialCode: "+678",
            currency: {
                code: "VUV",
                name: "Vanuatu Vatu",
                symbol: "Vt"
            }
        },
        {
            name: "Venezuela",
            dialCode: "+58",
            currency: {
                code: "VES",
                name: "Venezuelan Bolívar Soberano",
                symbol: "Bs.S"
            }
        },
        {
            name: "Vietnam",
            dialCode: "+84",
            currency: {
                code: "VND",
                name: "Vietnamese Đồng",
                symbol: "₫"
            }
        },
        {
            name: "Yemen",
            dialCode: "+967",
            currency: {
                code: "YER",
                name: "Yemeni Rial",
                symbol: "﷼"
            }
        },
        {
            name: "Zambia",
            dialCode: "+260",
            currency: {
                code: "ZMW",
                name: "Zambian Kwacha",
                symbol: "ZK"
            }
        },
        {
            name: "Zimbabwe",
            dialCode: "+263",
            currency: {
                code: "ZWL",
                name: "Zimbabwean Dollar",
                symbol: "$"
            }
        }
        // ... continue for all 195 countries
    ];

    const countrySelect = document.getElementById("country");
    const currencyCodeInput1 = document.getElementById("currency-code-1");
    const currencyCodeInput2 = document.getElementById("currency-code-2");
    const countryCodeInput1 = document.getElementById("country-code-1");
    const countryCodeInput2 = document.getElementById("country-code-2");
    const countryCurrencyInput1 = document.getElementById("currency-name-1");
    const countryCurrencyInput2 = document.getElementById("currency-name-2");
    const countryCurrencySymbolInput1 = document.getElementById("currency-symbol-1");
    const countryCurrencySymbolInput2 = document.getElementById("currency-symbol-2");

    // Populate country dropdown
    countryDialCodes.forEach(country => {
        const option = document.createElement("option");
        option.value = country.name;
        option.textContent = country.name;
        countrySelect.appendChild(option);
    });

    // Update country code on selection
    countrySelect.addEventListener("change", function() {
        const selectedCountry = this.value;
        const match = countryDialCodes.find(country => country.name === selectedCountry);
        if (match) {
            currencyCodeInput1.value = match.currency.code;
            currencyCodeInput2.value = match.currency.code;
            countryCodeInput1.value = match.dialCode;
            countryCodeInput2.value = match.dialCode;
            countryCurrencyInput1.value = match.currency.name;
            countryCurrencyInput2.value = match.currency.name;
            countryCurrencySymbolInput1.value = match.currency.symbol;
            countryCurrencySymbolInput2.value = match.currency.symbol;
        } else {
            currencyCodeInput1.value = "";
            currencyCodeInput2.value = "";
            countryCodeInput1.value = "";
            countryCodeInput2.value = "";
            countryCurrencyInput1.value = "";
            countryCurrencyInput2.value = "";
            countryCurrencySymbolInput1.value = "";
            countryCurrencySymbolInput2.value = "";
        }
    });
</script>
<?php include "footer.php"; ?>