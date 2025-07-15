<!-- including side nav bar  -->
<?php include 'side-nav.php'; ?>

<div class="page-header d-flex justify-content-between align-content-center flex-wrap">
    <div class="heading d-flex align-content-center">
        <h3 class="m-0"><img class="heading-icon" src="../assets/images/myImages/customer-icon.png" alt="">Customers</h3>
    </div>
    <div class="add-new ms-auto me-3">
        <a class="add-link" href="\Office\Browz Invoice\pages\add-customer.php"
            title="add more customers">
            <div class="d-inline">
                Add New
                <i class="fa-solid fa-plus"></i>
            </div>
        </a>
    </div>
</div>

<div class="salesman-table-container py-5">

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="alert-box">
                    <?php
                    $message = false;
                    $error = false;

                    if (isset($_GET['d']) && $_GET['d'] == '1') {
                        $message = 'Customer deleted successfully!';
                    } else if (isset($_GET['d']) && $_GET['d'] == '0') {
                        $error = 'Fail to delete customer, please try again';
                    } else if (isset($_GET['u']) && $_GET['u'] == '1') {
                        $message = 'Customer details with code: ' . $_GET['update'] . ' updated successfully!';
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
                                <th>NAME</th>
                                <th>EMAIL</th>
                                <th>GSTIN</th>
                                <th>PHONE</th>
                                <!-- <th>ADDRESS 1</th>
                                <th>ADDRESS 2</th>
                                <th>COUNTRY</th> -->
                                <th>STATE</th>
                                <!-- <th>CITY</th> -->
                                <!-- <th>POSTAL CODE</th> -->
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'db-conn.php';
                            $sql = "SELECT * FROM `customer`";
                            $result = mysqli_query($conn, $sql);

                            if ($result && $result->num_rows > 0) {
                                $count = 0;
                                while ($row = $result->fetch_assoc()) {
                                    $count++;
                                    echo '
                                        <tr class="text-capitalize">
                                            <td>' . $count . '</td>
                                            <td>' . htmlspecialchars($row['CUST_CODE']) . '</td>
                                            <td>' . htmlspecialchars($row['CUST_FULL_NAME']) . '</td>
                                            <td class="text-lowercase">' . htmlspecialchars($row['CUST_EMAIL']) . '</td>
                                            <td>' . htmlspecialchars($row['CUST_GSTIN']) . '</td>
                                            <td>' . htmlspecialchars($row['CUST_PHONE_NO']) . '</td>
                                            <!-- <td>' . htmlspecialchars($row['CUST_ADDRESS_1']) . '</td>
                                            <td>' . htmlspecialchars($row['CUST_ADDRESS_2']) . '</td>
                                            <td>' . htmlspecialchars($row['CUST_COUNTRY']) . '</td> -->
                                            <td>' . htmlspecialchars($row['CUST_STATE']) . '</td>
                                            <!-- <td>' . htmlspecialchars($row['CUST_CITY']) . '</td>
                                            <td>' . htmlspecialchars($row['CUST_POSTAL_CODE']) . '</td> -->
                                            <td>
                                                <a title="Update" onclick="return confirm(`Do you want to update this customer with ID = ' . $row['CUST_CODE'] . '?`)" href="\Office\Browz Invoice\pages\update-customer.php?update=' . $row['CUST_CODE'] . '"><button class="update"><i class="fa-solid fa-pen-to-square"></i></button></a>
                                                <a title="Delete" onclick="return confirm(`Do you want to delete this customer with ID = ' . $row['CUST_CODE'] . '?`)" href="\Office\Browz Invoice\php\delete-customer.php?delete=' . $row['CUST_CODE'] . '"><button class="delete"><i class="fa-solid fa-trash"></i></button></a>
                                            </td>
                                        </tr>
                                        ';
                                }
                            } else {
                                // echo '
                                //     <tr>
                                //         <td colspan="13" class="text-center">No Customers</td>
                                //     </tr>
                                //     ';
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