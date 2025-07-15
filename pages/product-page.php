<!-- including side nav bar  -->
<?php include 'side-nav.php'; ?>

<div class="page-header d-flex justify-content-between align-content-center flex-wrap">
    <div class="heading d-flex align-content-center">
        <h3 class="m-0"><img class="heading-icon" src="../assets/images/myImages/product-icon.png" alt="">Products</h3>
    </div>
    <div class="add-new ms-auto me-3">
        <a class="add-link" href="\Office\Browz Invoice\pages\add-product.php"
            title="add more products">
            Add New
            <div class="d-inline">
                <i class="fa-solid fa-plus"></i>
            </div>
        </a>
    </div>
</div>

<div class="product-table-container py-5">

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="alert-box">
                    <?php
                    $message = false;
                    $error = false;

                    if (isset($_GET['d']) && $_GET['d'] == '1') {
                        $message = 'Product deleted successfully!';
                    } else if (isset($_GET['d']) && $_GET['d'] == '0') {
                        $error = 'Fail to delete product, please try again';
                    } else if (isset($_GET['u']) && $_GET['u'] == '1') {
                        $message = 'Product details with code: ' . $_GET['update'] . ' updated successfully!';
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
                    <table id="example" class="table table-hover">
                        <thead>
                            <tr class="table-warning">
                                <th>S NO</th>
                                <th>CODE</th>
                                <th>NAME</th>
                                <th>HSN NO</th>
                                <th>PRICE</th>
                                <!-- <th>Max Discount</th>
                                <th>UOM</th>
                                <th>CATEGORY</th>
                                <th>DESCRIPTION</th> -->
                                <th>Product Image</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'db-conn.php';
                            $sql = "SELECT * FROM `product`";
                            $result = mysqli_query($conn, $sql);

                            if ($result && $result->num_rows > 0) {
                                $count = 0;
                                while ($row = $result->fetch_assoc()) {
                                    // fetching image data hand conveting it into image 
                                    $proImage = json_decode($row['PRO_IMAGE'], true);
                                    if ($proImage && isset($proImage['imageType']) && isset($proImage['imageData'])) {
                                        $imageSRC = 'data:' . $proImage['imageType'] . ';base64,' . $proImage['imageData'];
                                        $imageAlt = (!empty($proImage['imageName']) ? $proImage['imageName'] : 'image not available');
                                    } else {
                                        $imageSRC = '';
                                        $imageAlt = (!empty($proImage['imageName']) ? $proImage['imageName'] : 'image not available');
                                    }

                                    $count++;
                                    echo '
                                        <tr class="text-capitalize">
                                            <td>' . $count . '</td>
                                            <td>' . htmlspecialchars($row['PRO_CODE']) . '</td>
                                            <td>' . htmlspecialchars($row['PRO_NAME']) . '</td>
                                            <td>' . htmlspecialchars($row['PRO_HSNNO']) . '</td>
                                            <td>' . htmlspecialchars($row['PRO_PRICE']) . '</td>
                                            <!-- <td>' . htmlspecialchars($row['PRO_MAX_DISCOUNT']) . '</td>
                                            <td>' . htmlspecialchars($row['PRO_UOM']) . '</td>
                                            <td>' . htmlspecialchars($row['PRO_CATEGORY']) . '</td>
                                            <td>' . htmlspecialchars($row['PRO_DESC']) . '</td> -->
                                            <td><img src="' . $imageSRC . '" alt="' . $imageAlt . '" height="70px"></td>
                                            <td>
                                                <a title="Update" onclick="return confirm(`Do you want to update this product with ID = ' . $row['PRO_CODE'] . '?`)" href="\Office\Browz Invoice\pages\update-product.php?update=' . $row['PRO_CODE'] . '"><button class="update"><i class="fa-solid fa-pen-to-square"></i></button></a>
                                                <a title="Delete" onclick="return confirm(`Do you want to delete this product with ID = ' . $row['PRO_CODE'] . '?`)" href="\Office\Browz Invoice\php\delete-product.php?delete=' . $row['PRO_CODE'] . '"><button class="delete"><i class="fa-solid fa-trash"></i></button></a>
                                            </td>
                                        </tr>
                                        ';
                                }
                            } else {
                                // echo '
                                //     <tr>
                                //         <td colspan="13" class="text-center">No products</td>
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
                                <th>DESCRIPTION</th>
                                <th>PRICE</th>
                                <th>CATEGORY</th>
                                <th>UOM</th>
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