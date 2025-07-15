<?php
session_start();

$error = false;
$message = false;

include 'pages/db-conn.php';

// // checking for login token
// if (isset($_COOKIE['BrowzInvoice'])) {
//     $rmbtoken = $_COOKIE['BrowzInvoice'];
//     $sql = "SELECT * FROM `login_details` WHERE `REMEMBER`='$rmbtoken' LIMIT 1";
//     $result = mysqli_query($conn, $sql);
//     if ($result->num_rows > 0) {
//         $data = $result->fetch_assoc();
//         $_SESSION['login'] = true;
//         $_SESSION['userID'] = $data['USER_ID'];

//         $updateSql = "UPDATE `login_details` SET `LAST_LOGIN`=current_timestamp() WHERE `REMEMBER`='$rmbtoken'";
//         $result = mysqli_query($conn, $updateSql);

//         header('location: /Office/Browz%20Invoice/index.php');
//         exit();
//     }
// }

// // processing data if requested
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     // include 'pages/db-conn.php';

//     $userID = $_POST['id'];
//     $password = $_POST['pass'];
//     $remember = (isset($_POST['remember']) ? 'rem' : '');

//     // echo $userID . '<br>' . $password . '<br>' . $remember . '<br>';

//     // echo password_hash($password, PASSWORD_DEFAULT);

//     $fetchSql = "SELECT * FROM `login_details` WHERE `USER_ID`='$userID' LIMIT 1";
//     $fetchResult = mysqli_query($conn, $fetchSql);
//     if ($fetchResult && $fetchResult->num_rows > 0) {
//         while ($data = $fetchResult->fetch_assoc()) {
//             if (password_verify($password, $data['PASSWORD'])) {

//                 $_SESSION['login'] = true;
//                 $_SESSION['userID'] = $userID;

//                 if ($remember === 'rem') {
//                     // generating unique token
//                     $token = bin2hex(random_bytes(16));
//                     $expire = time() + (30 * 24 * 3600);

//                     setcookie('BrowzInvoice', $token, $expire);

//                     // updating token in database 
//                     $updateTokenSql = "UPDATE `login_details` SET `REMEMBER`='$token', `LAST_LOGIN`=current_timestamp() WHERE `USER_ID`='$userID'";
//                     $result = mysqli_query($conn, $updateTokenSql);
//                 } else {
//                     // updating last login if remember me is unchecked
//                     $updateTokenSql = "UPDATE `login_details` SET `LAST_LOGIN`=current_timestamp() WHERE `USER_ID`='$userID'";
//                     $result = mysqli_query($conn, $updateTokenSql);
//                 }


//                 header('location: /Office/Browz%20Invoice/index.php');
//                 exit();
//             } else {
//                 $error = 'password does not match';
//             }
//         }
//     } else {
//         $error = 'No records found!';
//     }
// }

// $conn->close();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browz Invoice || Reset Pass</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="assets/css/pages/auth.css">

    <!-- font awsome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .header-border {
            background: #b5d6df;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: bold;
        }

        input,
        select {
            width: 100%;
            border: 1px solid #656091;
            outline: none;
            color: #656091;
            padding: 2px 3px;
            font-size: 15px;
        }

        #remember {
            width: fit-content;
        }

        a {
            color: rgb(129, 118, 227);
            font-size: 10px;
        }

        .login-btn {
            border: 1px solid #369e05;
            background-color: #369e05;
            color: white;
        }

        .login-btn:hover {
            background-color: #61da2a;
        }

        .clear-btn {
            border: 1px solid #ffb419;
            background-color: #ffb419;
            color: white;
        }

        .clear-btn:hover {
            background-color: #ffc758;
        }

        .fa-brands {
            padding: 8px 10px;
            border-radius: 50%;
            color: white;
            font-size: 18px;
        }

        .fa-facebook-f {
            padding: 8px 11px;
            border: 1px solid #3a59a0;
            background-color: #3a59a0;
        }

        .fa-instagram {
            border: 1px solid #ca3084;
            background-color: #ca3084;
        }

        .fa-linkedin-in {
            border: 1px solid #017cb7;
            background-color: #017cb7;
        }

        .fa-youtube {
            border: 1px solid #fa0208;
            background-color: #fa0208;
            padding: 8px 7px;
        }

        .fa-brands:hover {
            filter: brightness(1.5);
        }

        footer p {
            font-size: 12px;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body class="bg-light">
    <div class="login">
        <div class="col-xl-3 col-lg-4 col-md-5 col-sm-6 col-10 mt-5 m-auto border shadow bg-white">
            <div class="login-header p-3 pb-0">

                <img class="img-fluid" src="assets/images/myImages/itpro.jpg" alt="">
            </div>
            <div class="header-border p-3">
            </div>
            <div class="login-body p-3">
                <div class="alert-box">
                    <?php

                    // if (isset($_GET['s']) && $_GET['s'] == '1') {
                    //     $message = 'Customer billing address added successfully!';
                    // } else if (isset($_GET['s']) && $_GET['s'] == '0') {
                    //     $error = 'Fail to add customer billing address, please try again';
                    // } else if (isset($_GET['s']) && $_GET['s'] == '3') {
                    //     $error = 'This billing code already exist.';
                    // }

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
                <form action="" method="post" class="mb-0">
                    <div class="form-group">
                        <label for="id" class="">User Id</label>
                        <input type="text" name="id" id="id" value="<?php echo (isset($_SESSION['userID']) ? $_SESSION['userID'] : ''); ?>">
                    </div>
                    <div class="form-group">
                        <label for="pass" class="">Password</label>
                        <input type="password" name="pass" id="pass">
                    </div>
                    <!-- <div class="form-group">
                            <label for="company" class="">Company</label>
                            <select name="company" id="company">
                                <option value="" selected>Select an option</option>
                                <option value="">Options</option>
                                <option value="">Options</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="location" class="">Location</label>
                            <select name="location" id="location">
                                <option value="" selected>Select an option</option>
                                <option value="">Options</option>
                                <option value="">Options</option>
                            </select>
                        </div> -->
                    <!-- <div class="form-group mb-1 d-flex align-content-center">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember" class="ms-1">Remember me</label>
                    </div>
                    <div class="form-group mb-1">
                        <a href="auth-forgot-password.php">
                            <p class="d-inline">Forget Password?</p>
                        </a>
                    </div> -->
                    <div class="form-group m-0 d-flex align-content-center justify-content-center">
                        <button type="submit" class="mx-1 login-btn btn">Reset</button>
                        <button type="reset" class="mx-1 clear-btn btn">Clear</button>
                    </div>
                </form>
            </div>
            <hr class="m-0">
            <div class="login-footer p-3 text-center">
                <span class="footer-icon"><a href=""><i class="fa-brands fa-facebook-f"></i></a></span>
                <span class="footer-icon"><a href=""><i class="fa-brands fa-instagram"></i></a></span>
                <span class="footer-icon"><a href=""><i class="fa-brands fa-linkedin-in"></i></a></span>
                <span class="footer-icon"><a href=""><i class="fa-brands fa-youtube"></i></a></span>
            </div>
        </div>
        <footer>
            <p>Copyright© 2024, Icon Technology Projects & Services LLC. All Rights Reserved.</p>
        </footer>
    </div>


    <script src="/Office/Browz Invoice/assets/js/bootstrap.bundle.min.js"></script>

</body>

</html>