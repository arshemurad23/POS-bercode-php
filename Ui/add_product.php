<?php
session_start();
if(!isset($_SESSION['admin-username']) || $_SESSION['admin-role'] != "admin"){
    header('location:../index.php');
}

?>

<?php
// Include the database connection (Make sure to replace with your actual database credentials)
include('dbinfo.php');
$inser_alert = false;
$inser_alert_barcode = false;

if (isset($_POST['add'])) {
    // Get form data
    $barcode = $_POST['barcode'];
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $stock_quantity = $_POST['stock_quantity'];
    $purchase_price = $_POST['purchase_price'];
    $sale_price = $_POST['sale_price'];

    // Handle image upload
    $img = $_FILES['product_image']['name'];
    $tpm_img = $_FILES['product_image']['tmp_name'];
    $folder = 'assets/img/' . $img; 
    move_uploaded_file($tpm_img, $folder);

    // If barcode is empty, insert new product and then update with generated barcode
    if (empty($barcode)) {
        // Insert new record with empty barcode
        $insertQuery = "INSERT INTO product_tbl (product_name, category, description, stock, purchase, sale, product_img) 
                        VALUES ('$product_name', '$category', '$description', '$stock_quantity', '$purchase_price', '$sale_price', '$img')";
        $insertResult = mysqli_query($con, $insertQuery);

        if ($insertResult) {
            // Get the last inserted ID to generate barcode
            $lastInsertedId = mysqli_insert_id($con);
            $barcode = $lastInsertedId . date('his');  // Generate barcode with ID and timestamp

            // Update the product record with the new barcode
            $updateQuery = "UPDATE product_tbl SET barcode = '$barcode' WHERE product_id = '$lastInsertedId'";
            $updateResult = mysqli_query($con, $updateQuery);

            if ($updateResult) {
                $inser_alert_barcode = true; // Set alert flag to true after successful insertion and update
            } else {
                // Handle update failure
                echo "Error updating barcode: " . mysqli_error($con);
            }
        } else {
            // Handle insert failure
            echo "Error inserting product: " . mysqli_error($con);
        }
    } else {
        // If barcode is provided, directly insert with barcode
        $insertQuery = "INSERT INTO product_tbl (barcode, product_name, category, description, stock, purchase, sale, product_img) 
                        VALUES ('$barcode', '$product_name', '$category', '$description', '$stock_quantity', '$purchase_price', '$sale_price', '$img')";
        $insertResult = mysqli_query($con, $insertQuery);

        if ($insertResult) {
            $inser_alert = true; // Set alert flag to true after successful insertion
        } else {
            // Handle insert failure
            echo "Error inserting product: " . mysqli_error($con);
        }
    }
}

?>


<?php
include("admin-header.php");
?>

<main class="app-main"> <!--begin::App Content Header-->
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">

            <?php
            // Display success message if $inser_alert is true
            if($inser_alert_barcode){
                echo '<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                        <strong>Success!</strong> The product has been inserted successfully  generate whit barcode .
                       
                       
                      </div>';
            }
            ?>


<?php
            // Display success message if $inser_alert is true
            if($inser_alert){
                echo '<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                        <strong>Success!</strong> The product has been inserted successfully.
                       
                       
                      </div>';
            }
            ?>

                <div class="col-sm-6">
                    <h3 class="mb-0">Add-product</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Add-product
                        </li>
                    </ol>
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div> <!--end::App Content Header-->
    
    <!--begin::App Content-->
    <div class="app-content mt-5"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">

        
                <div class="col-md-12"> <!-- Full-width column for the card -->

                    <div class="card card-warning card-outline mb-4 mt-3"> <!-- Single card containing all inputs -->
                        <div class="card-header">
                            <div class="card-title">Add-product</div>

                        </div>

                        <div class="card-body">


                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <!-- First set of 4 input fields (1st Column) -->
                                    <div class="col-md-6">
                                        <div class="form-group mt-3">
                                            <label for="input1">Barcode</label>
                                            <input type="text" class="form-control" id="input1" name="barcode" placeholder="Enter Barcode" >
                                        </div>

                                        <div class="form-group mt-3">
                                            <label for="input2">Product Name</label>
                                            <input type="text" class="form-control" id="input2" name="product_name" placeholder="Enter Product Name" required>
                                        </div>

                                        <div class="form-group mt-3">
                                            <?php
                                            $category_qur = "SELECT * FROM category_tbl";
                                            $category_res = mysqli_query($con,$category_qur);
                                            ?>

                                            <label for="input3">Category</label>
                                            <select class="form-control" id="input3" name="category" required>
                                                <option value="" disabled selected>Select Category</option>
                                            <?php while($row = mysqli_fetch_array($category_res)){
                                            ?>
                                                <option value="<?php echo $row['category_name'] ?>"><?php echo $row['category_name'] ?> </option>
                                             <?php
                                                }
                                            ?>
                                            </select>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label for="input4">Description</label>
                                            <textarea type="text" rows="3" class="form-control" id="input4" name="description" placeholder="Enter Description" required></textarea>
                                        </div>
                                    </div>
                                    
                                    <!-- Second set of 4 input fields (2nd Column) -->
                                    <div class="col-md-6">
                                        <div class="form-group mt-3">
                                            <label for="input5">Stock Quantity</label>
                                            <input type="number" class="form-control" id="input5" name="stock_quantity" placeholder="Enter Stock Quantity" required>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label for="input6">Purchase Price</label>
                                            <input type="number" class="form-control" id="input6" name="purchase_price" placeholder="Enter Purchase Price" required>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label for="input7">Sale Price</label>
                                            <input type="number" class="form-control" id="input7" name="sale_price" placeholder="Enter Sale Price" required>
                                        </div>
                                        
                                        <div class="form-group mt-3">
                                            <label for="input8">Product Image</label>
                                            <input type="file" class="form-control" id="input8" name="product_image" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" name="add" class="btn btn-info">Save Product</button>
                                </div>
                            </form>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div> <!-- end col-md-12 -->
            </div> <!-- end row -->
        </div> <!-- end container-fluid -->
    </div> <!-- end app-content -->
</main>



<?php
include("footer.php");
?>