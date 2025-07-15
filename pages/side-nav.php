<?php
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    header('location: /Office/Browz%20Invoice/auth-login.php');
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browz Invoice || Dashboard</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Office/Browz Invoice/assets/css/bootstrap.css">

    <link rel="stylesheet" href="/Office/Browz Invoice/assets/vendors/iconly/bold.css">

    <link rel="stylesheet" href="/Office/Browz Invoice/assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="/Office/Browz Invoice/assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="/Office/Browz Invoice/assets/css/app.css">
    <!-- <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon"> -->

    <!-- font awsome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- table cdn  -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">


    <!-- select search option cdn by select2 -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->


    <!-- my css  -->
    <link rel="stylesheet" href="/Office/Browz Invoice/assets/css/myStyle.css">
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between">
                        <div class="logo text-center">
                            <a href="\Office\Browz Invoice\index.php">Browz Invoice</a>
                        </div>
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>

                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Master</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="/Office/Browz%20Invoice/pages/salesman-page.php">Salesmans</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="/Office/Browz%20Invoice/pages/customer-page.php">Customers</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="/Office/Browz%20Invoice/pages/gst-page.php">GST</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="/Office/Browz%20Invoice/pages/product-page.php">Products</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="/Office/Browz%20Invoice/pages/currency-page.php">Currency</a>
                                </li>
                                <!-- <li class="submenu-item ">
                                        <a href="/Office/Browz%20Invoice/pages/bill-to-address-page.php">Bill to address</a>
                                    </li>
                                    <li class="submenu-item ">
                                        <a href="/Office/Browz%20Invoice/pages/ship-to-address-page.php">Ship to address</a>
                                    </li> -->
                            </ul>
                        </li>

                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-stack"></i>
                                <span>Main Menu</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="/Office/Browz%20Invoice/pages/sales-order.php">Invoice Form</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="/Office/Browz%20Invoice/pages/sales-order-history.php">History</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a href="/Office/Browz%20Invoice/php/logout.php" onclick="return confirm('Do you really want yo logout?');" class="sidebar-link">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                <span>Logout</span>
                            </a>
                        </li>

                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>



        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none text-dark">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>