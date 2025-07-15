<!-- including side nav bar  -->
<?php include 'side-nav.php'; ?>

<div class="page-header d-flex justify-content-between align-content-center flex-wrap">
    <div class="heading d-flex align-content-center">
        <h3 class="m-0"><img class="heading-icon" src="../assets/images/myImages/customer-icon.png" alt="">Bill To Address</h3>
    </div>
    <div class="add-new ms-auto me-3">
        <a class="add-link" href="\Office\Browz Invoice\pages\add-bill-to.php"
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
                        $message = 'Billing address deleted successfully!';
                    } else if (isset($_GET['d']) && $_GET['d'] == '0') {
                        $error = 'Fail to delete billing address, please try again';
                    } else if (isset($_GET['u']) && $_GET['u'] == '1') {
                        $message = 'Billing address details with code: ' . $_GET['update'] . ' updated successfully!';
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
                                <th>PHONE</th>
                                <th>GSTIN</th>
                                <th>STATE</th>
                                <th>CITY</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'db-conn.php';
                            $sql = "SELECT * FROM `bill_to_address`";
                            $result = mysqli_query($conn, $sql);

                            if ($result && $result->num_rows > 0) {
                                $count = 0;
                                while ($row = $result->fetch_assoc()) {
                                    $count++;
                                    echo '
                                        <tr class="text-capitalize">
                                            <td>' . $count . '</td>
                                            <td>' . htmlspecialchars($row['BILL_CODE']) . '</td>
                                            <td>' . htmlspecialchars($row['BILL_NAME']) . '</td>
                                            <td class="text-lowercase">' . htmlspecialchars($row['BILL_EMAIL']) . '</td>
                                            <td>' . htmlspecialchars($row['BILL_PHONE_NO']) . '</td>
                                            <td>' . htmlspecialchars($row['GSTIN_NO']) . '</td>
                                            <!-- <td>' . htmlspecialchars($row['BILL_ADDRESS_1']) . '</td>
                                            <td>' . htmlspecialchars($row['BILL_ADDRESS_2']) . '</td>
                                            <td>' . htmlspecialchars($row['BILL_COUNTRY']) . '</td> -->
                                            <td>' . htmlspecialchars($row['BILL_STATE']) . '</td>
                                            <td>' . htmlspecialchars($row['BILL_CITY']) . '</td>
                                            <!-- <td>' . htmlspecialchars($row['BILL_POSTAL_CODE']) . '</td> -->
                                            <td>
                                                <a title="Update" onclick="return confirm(`Do you want to update this bill to address with ID = ' . $row['BILL_CODE'] . '?`)" href="\Office\Browz Invoice\pages\update-bill-to.php?update=' . $row['BILL_CODE'] . '"><button class="update"><i class="fa-solid fa-pen-to-square"></i></button></a>
                                                <a title="Delete" onclick="return confirm(`Do you want to delete this bill to address with ID = ' . $row['BILL_CODE'] . '?`)" href="\Office\Browz Invoice\php\delete-bill-to.php?delete=' . $row['BILL_CODE'] . '"><button class="delete"><i class="fa-solid fa-trash"></i></button></a>
                                            </td>
                                        </tr>
                                        ';
                                }
                            }
                            $conn->close();
                            ?>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
</div>

<?php include "footer.php"; ?>