<!-- including side nav bar  -->
<?php include 'side-nav.php'; ?>

<div class="page-header d-flex justify-content-between align-content-center flex-wrap">
    <div class="heading d-flex align-content-center">
        <h3 class="m-0"><img class="heading-icon" src="../assets/images/myImages/invoice-icon.png" alt="">Invoice Details</h3>
    </div>
    <!-- <div class="add-new ms-auto me-3">
        <a class="add-link" href="\Office\Browz Invoice\pages\add-sales-order.php"
            title="add more sales-orders">
            <div class="d-inline">
                Add New
                <i class="fa-solid fa-plus"></i>
            </div>
        </a>
    </div> -->
</div>

<div class="sales-order-table-container py-5">

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="alert-box">
                    <?php
                    $message = false;
                    $error = false;

                    if (isset($_GET['d']) && $_GET['d'] == '1') {
                        $message = 'Invoice deleted successfully!';
                    } else if (isset($_GET['d']) && $_GET['d'] == '0') {
                        $error = 'Fail to delete invoice, please try again';
                    } else if (isset($_GET['u']) && $_GET['u'] == '1') {
                        $message = 'Invoice details with code: ' . $_GET['update'] . ' updated successfully!';
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

                <div class="table-responsive p-3 py-4 bg-light shadow">
                    <table id="example" class="table table-hover ">
                        <thead>
                            <tr class="table-warning">
                                <th>S NO</th>
                                <th>CODE</th>
                                <th>CUSTOMER CODE</th>
                                <th>SALESMAN CODE</th>
                                <th>CURRENCY</th>
                                <th>AMOUNT</th>
                                <th>DATE</th>
                                <!-- <th>STATUS</th> -->
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'db-conn.php';
                            $sql = "SELECT * FROM `sales_order`";
                            $result = mysqli_query($conn, $sql);

                            if ($result && $result->num_rows > 0) {
                                $count = 0;
                                while ($row = $result->fetch_assoc()) {
                                    $count++;
                                    echo '
                                        <tr class="text-capitalize">
                                            <td>' . $count . '</td>
                                            <td>' . htmlspecialchars($row['SO_CODE']) . '</td>
                                            <td>' . htmlspecialchars($row['SO_CUST_CODE']) . '</td>
                                            <td>' . htmlspecialchars($row['SO_SM_CODE']) . '</td>
                                            <td>' . htmlspecialchars($row['SO_CURRENCY']) . '</td>
                                            <td>' . htmlspecialchars($row['SO_TOTAL']) . '</td>
                                            <td>' . htmlspecialchars($row['SO_DATE']) . '</td>
                                            <!-- <td>' . htmlspecialchars($row['SO_STATUS']) . '</td> -->
                                            <td>
                                                <!-- <a title="Update" onclick="return confirm(`Do you want to update this sales-order with ID = ' . $row['SO_CODE'] . '?`)" href="\Office\Browz Invoice\pages\update-sales-order.php?update=' . $row['SO_CODE'] . '"><button class="update"><i class="fa-solid fa-pen-to-square"></i></button></a>
                                                <a title="Delete" onclick="return confirm(`Do you want to delete this sales-order with ID = ' . $row['SO_CODE'] . '?`)" href="\Office\Browz Invoice\php\delete-sales-order.php?delete=' . $row['SO_CODE'] . '"><button class="delete"><i class="fa-solid fa-trash"></i></button></a> -->
                                                <a title="View" onclick="return confirm(`Do you want to view this invoice with ID = ' . $row['SO_CODE'] . '?`)" href="\Office\Browz Invoice\pages\invoice-preview.php?inv=' . $row['SO_CODE'] . '"><button class="delete"><i class="fa-solid fa-eye"></i></button></a>
                                            </td>
                                        </tr>
                                        ';
                                }
                            } else {
                            }

                            $conn->close();
                            ?>

                        </tbody>
                        <!-- <tfoot>
                            <tr>
                                <th>S NO</th>
                                <th>CODE</th>
                                <th>NAME</th>
                                <th>EMAIL</th>
                                <th>PHONE</th>
                                <th>ADDRESS 1</th>
                                <th>ADDRESS 2</th>
                                <th>COUNTRY</th>
                                <th>STATE</th>
                                <th>CITY</th>
                                <th>POSTAL CODE</th>
                                <th>GSTIN</th>
                                <th>ACTION</th>
                            </tr>
                        </tfoot> -->
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
</div>

<?php include "footer.php"; ?>