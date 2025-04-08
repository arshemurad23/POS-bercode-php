<?php
session_start();
if (!isset($_SESSION['admin-username']) || $_SESSION['admin-role'] != "admin") {
    header('location:../index.php');
    exit();
}

// Include database connection
include('dbinfo.php');
$id = $_REQUEST['id'];

if (isset($_POST['add'])) {
    // Get form data
    $product_name = mysqli_real_escape_string($con, $_POST['product_name']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $stock_quantity = $_POST['stock_quantity'];
    $purchase_price = $_POST['purchase_price'];
    $sale_price = isset($_POST['sale_price']) ? $_POST['sale_price'] : '';

    // Handle image upload
    $img = $_FILES['product_image']['name'];
    $tpm_img = $_FILES['product_image']['tmp_name'];
    $folder = 'assets/img/' . $img;

    if (!empty($img)) {
        // Validate image (check for actual image type, size, etc.)
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = mime_content_type($tpm_img);

        if (in_array($file_type, $allowed_types)) {
            // Move the uploaded file
            move_uploaded_file($tpm_img, $folder);

            // Update query with image
            $qur = "UPDATE product_tbl SET product_name = '$product_name', category = '$category', description = '$description', 
                    stock = '$stock_quantity', purchase = '$purchase_price', sale = '$sale_price', product_img = '$img' 
                    WHERE product_id = '$id'";
        } else {
            // Handle invalid image type
            echo "<script>alert('Invalid image file type. Please upload a valid image.');</script>";
            exit();
        }
    } else {
        // If no image is uploaded, skip the image update
        $qur = "UPDATE product_tbl SET product_name = '$product_name', category = '$category', description = '$description', 
                stock = '$stock_quantity', purchase = '$purchase_price', sale = '$sale_price' WHERE product_id = '$id'";
    }

    // Execute the query
    $res = mysqli_query($con, $qur);

    if ($res) {
        // Redirect to the product list page after success
        header('location:product_list.php');
        exit();
    } else {
        // Handle error if query fails
        echo "<script>alert('Failed to update product. Please try again.');</script>";
    }
}
?>


<?php
include("admin-header.php");
?>


<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Update Product</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Update Product</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-warning card-outline mb-4 mt-3">
                        <div class="card-header">
                            <div class="card-title">Update Product</div>
                        </div>
                        <div class="card-body">

                        <?php
                        // Fetch existing product data from database
                        $product_fetch_qur = "SELECT * FROM product_tbl WHERE product_id = '$id'";
                        $product_fetch_res = mysqli_query($con, $product_fetch_qur);
                        $product_fetch_row = mysqli_fetch_array($product_fetch_res);
                        ?>

                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mt-3">
                                            <label for="input2">Product Name</label>
                                            <input type="text" class="form-control" value="<?php echo $product_fetch_row['product_name']; ?>" id="input2" name="product_name" placeholder="Enter Product Name" required>
                                        </div>

                                        <div class="form-group mt-3">
                                            <?php
                                            // Fetch categories for dropdown
                                            $category_qur = "SELECT * FROM category_tbl";
                                            $category_res = mysqli_query($con, $category_qur);
                                            ?>
                                            <label for="input3">Category</label>
                                            <select class="form-control" id="input3" name="category" required>
                                                <option value="" disabled>Select Category</option>
                                                <?php while ($row = mysqli_fetch_array($category_res)) { ?>
                                                    <option value="<?php echo $row['category_name']; ?>" 
                                                        <?php echo ($row['category_name'] == $product_fetch_row['category']) ? 'selected' : ''; ?>>
                                                        <?php echo $row['category_name']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label for="input4">Description</label>
                                            <textarea class="form-control" rows="3" id="input4" name="description" placeholder="Enter Description" required><?php echo $product_fetch_row['description']; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mt-3">
                                            <label for="input5">Stock Quantity</label>
                                            <input type="number" class="form-control" value="<?php echo $product_fetch_row['stock']; ?>" id="input5" name="stock_quantity" placeholder="Enter Stock Quantity" required>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label for="input6">Purchase Price</label>
                                            <input type="number" class="form-control" id="input6" value="<?php echo $product_fetch_row['purchase']; ?>" name="purchase_price" placeholder="Enter Purchase Price" required>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label for="input7">Sale Price</label>
                                            <input type="number" class="form-control" id="input7" name="sale_price" value="<?php echo $product_fetch_row['sale']; ?>" placeholder="Enter Sale Price" required>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label for="input8">Product Image</label>
                                            <input type="file" class="form-control" name="product_image" value="<?php echo $product_fetch_row['product_img']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" name="add" class="btn btn-info">Save Product</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<?php
include("footer.php");
?>