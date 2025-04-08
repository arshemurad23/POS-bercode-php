<?php

ob_start();

session_start();
if (!isset($_SESSION['admin-username']) || $_SESSION['admin-role'] != "admin") {
    header('location:../index.php');
}


include('dbinfo.php');
$id = $_REQUEST['id'];

$edit_order_qur = "SELECT * FROM invoice_tbl where invoice_id = '$id' ";
$edit_order_res = mysqli_query($con, $edit_order_qur);
$edit_order_row = mysqli_fetch_array($edit_order_res);
$invoice_id = $edit_order_row['invoice_id'];


 ?>




<?php include("admin-header.php"); ?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Edit Order</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Order</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-warning card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">Edit</div>
                </div>

                <form action="" method="post">

                    <div class="row">
                        <div class="col-md-8">
                            <br>

                            <div class="tablefixhead mt-3">


                            <!-- invoice_details_tbl---php -->

                            <?php
                                    $sql = "SELECT * FROM invoice_details_tbl WHERE invoice_id = '$invoice_id'";
                                    $res = mysqli_query($con, $sql);?>

                                <table class="table table-bordered table-hover">
                                    <thead>
                                       
                                 
                                        <tr>
                                            <th>Product</th>
                                           
                                            <th>Sale Price</th>
                                            <th>QTY</th>
                                            <th>Total</th>
                                         
                                        </tr>

                                    </thead>
                                    <tbody class="details" id="itemtable">


                                    <?php
                                  while($product_row = mysqli_fetch_array($res)){
                                    
                                    $product_row['id'];
                                    
                                   $product_row['qty'];
                                    $product_row['rate'];
                                    $product_row['saleprice'];
                                    $product_row['barcode']; // Add barcode if available
    
                                    
                                    ?>
                             <tr>

                                    <input type="hidden" name="barcode[]" value="<?php echo $product_row['barcode']; ?>">

                                <td>
                                    <input type="hidden" name="array_product_name[]" value="<?php echo $product_row['product_name']; ?>">
                                    <?php echo $product_row['product_name']; ?>
                                </td>
                                <td>
                                    <input type="hidden" name="array_price[]" class="price" value="<?php echo $product_row['rate']; ?>">
                                    <?php echo $product_row['rate']; ?>
                                </td>
                                <td>
                                    <input type="number" name="array_qty[]" class="form-control qty" value="<?php echo $product_row['qty']; ?>">
                                </td>
                                <td class="total">
                                    <input type="hidden" name="array_total[]" value="<?php echo $product_row['saleprice']; ?>">
                                    <?php echo $product_row['saleprice']; ?>
                                </td>
                            </tr>

                               <?php
                                  }
                                ?>

                                    </tbody>
                                </table>
                            </div>

                        </div><!-- close col-md-8 -->



                        <div class="col-md-4 mt-1">

                         <!-- taxdis_tbl---php -->

                        <?php
                        include('dbinfo.php');
                        $discount_qur = "SELECT * FROM  taxdis_tbl where taxdis_id = '1' ";
                        $discount_res = mysqli_query($con, $discount_qur);
                        $discount_row = mysqli_fetch_array($discount_res)
                        ?>

                        
                            <div class="input-group mb-3">
                                <span class="input-group-text">SUBTOTAL(Rs)</span>
                                <input type="text" value="<?php echo $edit_order_row['subtotal']; ?>" class="form-control" name="subtotal" aria-label="Amount" readonly>
                                <span class="input-group-text">Rs</span>
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text">DISCOUNT(%)</span>
                                <input type="number" class="form-control" name="discount"  value="<?php echo $discount_row['discount'];?>" id="discount-percent" aria-label="Discount Percentage">
                                <span class="input-group-text">%</span>
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text">DISCOUNT(Rs)</span>
                                <input type="text" class="form-control"  id="discount-amount"  aria-label="Discount Amount" readonly>
                                <span class="input-group-text">Rs</span>
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text">SGST(%)</span>
                                <input type="text" class="form-control" name="sgst"  value="<?php echo $discount_row['sgst'];?>" aria-label="SGST Percentage" readonly>
                                <span class="input-group-text">%</span>
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text">CGST(%)</span>
                                <input type="text" class="form-control" name="cgst" value="<?php echo $discount_row['cgst'];?>" aria-label="CGST Percentage" readonly>
                                <span class="input-group-text">%</span>
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text">SGST(Rs)</span>
                                <input type="text" class="form-control" id="sgst-amount" aria-label="SGST Amount" readonly>
                                <span class="input-group-text">Rs</span>
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text">CGST(Rs)</span>
                                <input type="text" class="form-control" id="cgst-amount"  aria-label="CGST Amount" readonly>
                                <span class="input-group-text">Rs</span>
                            </div>

                            <hr style="height: 2px; border-width: 0; color: black; background-color: black;">

                            <div class="input-group mb-3">
                                <span class="input-group-text">TOTAL(Rs)</span>
                                <input type="text" class="form-control" name="total"  id="total-amount" aria-label="Total Amount" readonly>
                                <span class="input-group-text">Rs</span>
                            </div>

                            <div class="icheck-success d-inline">
                                <input type="radio" name="r3" checked name="cash"  value="Cash" id="radioSuccess1">
                                <label for="radioSuccess1">CASH</label>
                            </div>

                            <div class="icheck-primary d-inline">
                                <input type="radio" name="r3" name="card" value="Card" id="radioSuccess2">
                                <label for="radioSuccess2">CARD</label>
                            </div>

                            <div class="icheck-danger d-inline">
                                <input type="radio" name="r3" name="check" value="Check" id="radioSuccess3">
                                <label for="radioSuccess3">CHECK</label>
                            </div>

                            <hr style="height: 2px; border-width: 0; color: black; background-color: black;">

                            <div class="input-group mb-3">
                                <span class="input-group-text">DUE(Rs)</span>
                                <input type="text" class="form-control" name="due" value="<?php echo $edit_order_row['due']; ?>"  id="due-amount" aria-label="Due Amount" readonly>
                                <span class="input-group-text">Rs</span>
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text">PAID(Rs)</span>
                                <input type="text" class="form-control" name="paid" value="<?php echo $edit_order_row['paid']; ?>" id="paid-amount" aria-label="Paid Amount" required>
                                <span class="input-group-text">Rs</span>
                            </div>

                            <div class="card-footer">
                                <input type="submit" value="Save Order" name="save_oder" class="btn btn-primary mt-2">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include("footer.php"); ?>








<script>// Function to update the subtotal, discount, taxes, and total amount
// Function to update the subtotal, discount, taxes, and total amount
function updateSubtotal() {
    var subtotal = 0;

    // Calculate the new subtotal by summing all item totals
    $('#itemtable .total input').each(function() {
        subtotal += parseFloat($(this).val()) || 0; // Handle invalid numbers safely
    });

    // Update the subtotal input field
    $('input[name="subtotal"]').val(subtotal.toFixed(2));

    var discountPercent = parseFloat($('#discount-percent').val()) || 0;
    var discountAmount = (subtotal * discountPercent) / 100;
    var discountedTotal = subtotal - discountAmount;

    // Update discount fields
    $('#discount-amount').val(discountAmount.toFixed(2));

    var sgstPercent = parseFloat($('input[name="sgst"]').val()) || 0;
    var cgstPercent = parseFloat($('input[name="cgst"]').val()) || 0;

    // Calculate SGST and CGST amounts
    var sgstAmount = (discountedTotal * sgstPercent) / 100;
    var cgstAmount = (discountedTotal * cgstPercent) / 100;

    // Update SGST and CGST fields
    $('#sgst-amount').val(sgstAmount.toFixed(2));
    $('#cgst-amount').val(cgstAmount.toFixed(2));

    // Calculate the total amount
    var totalAmount = discountedTotal + sgstAmount + cgstAmount;
    $('#total-amount').val(totalAmount.toFixed(2));

    // Recalculate the due amount whenever subtotal, discount, SGST, or CGST is updated
    var paidAmount = parseFloat($('#paid-amount').val()) || 0;
    var dueAmount = totalAmount - paidAmount;

    // Update due amount
    $('#due-amount').val(dueAmount.toFixed(2));
}

// Function to update the item total when quantity or price is changed
$('#itemtable').on('input', '.qty', function() {
    var row = $(this).closest('tr');
    var price = parseFloat(row.find('.price').val()); // Sale price as a hidden input field
    var qty = parseInt($(this).val(), 10); // Quantity as integer

    if (isNaN(qty) || qty <= 0) {
        qty = 1; // Default to 1 if qty is invalid
    }

    // Perform multiplication to get total
    var total = price * qty; // Total calculation
    
    // Ensure that price and total are valid numbers
    if (isNaN(total)) {
        total = 0; // Default total to 0 if multiplication fails
    }

    // Update the total value in the .total column and its hidden input field
    row.find('.total').html('<input type="hidden" name="array_total[]" value="' + total.toFixed(2) + '">' + total.toFixed(2));

    updateSubtotal(); // Call the subtotal function to update the total amount
});

// Trigger initial calculation for SGST and CGST when the page loads
$(document).ready(function() {
    updateSubtotal(); // This will perform the initial calculation on page load
});

// Event listener for discount field to trigger updates when discount is changed
$('#discount-percent').on('input', function() {
    updateSubtotal(); // Recalculate totals when discount is updated
});

// Event listener for paid amount field to trigger updates when paid amount is changed
$('#paid-amount').on('input', function() {
    updateSubtotal(); // Recalculate due amount when paid amount is updated
});


</script>






<?php
if (isset($_POST['save_oder'])) {
    // Variables from POST
    $date = date('Y-m-d');
    $subtotal = $_POST['subtotal'];
    $discount = $_POST['discount'];
    $sgst = $_POST['sgst'];
    $cgst = $_POST['cgst'];
    $total = $_POST['total'];
    $payment_method = $_POST['r3'];
    $due = $_POST['due'];
    $paid = $_POST['paid'];

    // Arrays from POST
    $array_product_name = $_POST['array_product_name'];
    $array_price = $_POST['array_price'];
    $array_qty = $_POST['array_qty'];
    $array_total = $_POST['array_total'];
    $array_barcode = $_POST['barcode'];

    // Step 1: Update the invoice table
    $invoice_update_qur = "UPDATE invoice_tbl SET order_date = '$date', subtotal = '$subtotal', discount = '$discount', sgst_p = '$sgst', cgst_p = '$cgst', total = '$total', payment_type = '$payment_method', due = '$due', paid = '$paid' WHERE invoice_id = '$id'";
    $invoice_update_res = mysqli_query($con, $invoice_update_qur);

    if ($invoice_update_res) {
        // Step 2: Loop through each product to update stock and invoice details
        $update_success = true;
        for ($i = 0; $i < count($array_product_name); $i++) {
            $product_name = $array_product_name[$i];
            $price = $array_price[$i];
            $qty = $array_qty[$i];
            $total_price = $array_total[$i];
            $barcode = $array_barcode[$i];

            // Step 3: Get current stock from product_tbl
            $product_qur = "SELECT stock FROM product_tbl WHERE barcode = '$barcode'";
            $product_res = mysqli_query($con, $product_qur);
            $product_row = mysqli_fetch_array($product_res);
            $product_qty = $product_row['stock'];

            // Step 4: Get current quantity from invoice_details_tbl for this product
            $invoice_details_qur = "SELECT qty FROM invoice_details_tbl WHERE invoice_id = '$id' AND barcode = '$barcode'";
            $invoice_details_res = mysqli_query($con, $invoice_details_qur);
            $invoice_details_row = mysqli_fetch_array($invoice_details_res);
            $old_qty = $invoice_details_row['qty'];

            // Step 5: Calculate the difference in quantity
            $qty_difference = $qty - $old_qty;

            // Step 6: Update stock in product_tbl
            $new_stock = $product_qty - $qty_difference;
            if ($new_stock >= 0) {
                $update_stock_qur = "UPDATE product_tbl SET stock = '$new_stock' WHERE barcode = '$barcode'";
                $update_stock_res = mysqli_query($con, $update_stock_qur);

                // Step 7: Update the quantity and sale price in invoice_details_tbl
                $invoice_details_update_qur = "UPDATE invoice_details_tbl SET qty = '$qty', saleprice = '$total_price' WHERE invoice_id = '$id' AND barcode = '$barcode'";
                $invoice_details_update_res = mysqli_query($con, $invoice_details_update_qur);
            } else {
                // If stock goes negative, show alert
                echo "<script>alert('Order cannot be completed. Insufficient stock for one or more products!: $product_name');</script>";
                $update_success = false;
                break;
            }
        }

        if ($update_success) {

            header('location:oder_list.php');

            // If all updates were successful, show success alert
            // echo "<script>alert('Invoice updated successfully!'); window.location='oder_list.php';</script>";
        }
    } else {
        // If invoice update failed, show error alert
        echo "<script>alert('Error updating invoice: " . mysqli_error($con) . "');</script>";
    }
}
?>
