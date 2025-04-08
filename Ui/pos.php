<?php
session_start();
if (!isset($_SESSION['admin-username']) || $_SESSION['admin-role'] != "admin") {
    header('location:../index.php');
}
?>
<?php
include('dbinfo.php');
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
    $arry_p_id = isset($_POST['array_p_id']) ? $_POST['array_p_id'] : [];
    $arry_barcode = isset($_POST['array_barcode']) ? $_POST['array_barcode'] : [];
    $array_product_name = isset($_POST['array_product_name']) ? $_POST['array_product_name'] : [];
    $array_stock = isset($_POST['array_stock']) ? $_POST['array_stock'] : [];
    $array_price = isset($_POST['array_price']) ? $_POST['array_price'] : [];
    $array_qty = isset($_POST['array_qty']) ? $_POST['array_qty'] : [];
    $array_total = isset($_POST['array_total']) ? $_POST['array_total'] : [];

    // Check if any of the product arrays are empty
    if (empty($arry_p_id) || empty($arry_barcode) || empty($array_product_name) || empty($array_stock) || empty($array_price) || empty($array_qty) || empty($array_total)) {
        echo "<script>alert('Please add at least one product to the order before submitting!');</script>";
    } else {
        // Flag to check if stock is insufficient
        $stock_insufficient = false;

        // Step 1: Loop through the products to check stock before inserting or updating
        for ($i = 0; $i < count($array_product_name); $i++) {
            $stock = $array_stock[$i];
            $qty = $array_qty[$i];

            // Check if stock is less than the quantity being ordered
            if ($stock < $qty) {
                $stock_insufficient = true;
                break; // Exit the loop as we don't need to check further
            }
        }

        // If stock is insufficient for any product, show alert and stop further execution
        if ($stock_insufficient) {
            echo "<script>alert('Order cannot be completed. Insufficient stock for one or more products!');</script>";
        } else {
            // Step 2: Insert into invoice_tbl (if all stock checks pass)
            $oder_invoice_qur = "INSERT INTO invoice_tbl VALUES (null , '$date', '$subtotal', '$discount', '$sgst', '$cgst', '$total', '$payment_method', '$due', '$paid')";
            $oder_invoice_res = mysqli_query($con, $oder_invoice_qur);

            if ($oder_invoice_res) {
                // Step 3: Get last inserted ID for invoice_tbl
                $last_id = mysqli_insert_id($con);

                if ($last_id != null) {
                    // Step 4: Loop through the products to update stock and insert order details
                    for ($i = 0; $i < count($array_product_name); $i++) {
                        $p_id = $arry_p_id[$i];
                        $product_barcode = $arry_barcode[$i];
                        $product_name = $array_product_name[$i];
                        $stock = $array_stock[$i];
                        $price = $array_price[$i];
                        $qty = $array_qty[$i];
                        $total_price = $array_total[$i];

                        // Calculate new stock
                        $minus_qty = $stock - $qty;

                        // Update stock in product_tbl only if sufficient stock
                        $minus_qur = "UPDATE product_tbl SET stock = '$minus_qty' WHERE product_id = '$p_id'";
                        $minus_qty_res = mysqli_query($con, $minus_qur);

                        // Insert order details into invoice_details_tbl
                        $invoice_details_qur = "INSERT INTO invoice_details_tbl VALUES (null, '$last_id', '$product_barcode', '$p_id', '$product_name', '$qty', '$price', '$total_price', '$date')";
                        $invoice_details_res = mysqli_query($con, $invoice_details_qur);
                    }

                    // Redirect to order list page after successful insertion
                    header("Location: oder_list.php");
                    exit(); // Make sure script stops here
                }
            }
        }
    }
}

?>

 




<?php include("admin-header.php"); ?>

<style>
    .tablefixhead {
        overflow: scroll;
        height: 520px;
    }
    .tablefixhead thead th {
        position: sticky;
        top: 0;
        z-index: 1;
    }
    .thead {
        background: #000;
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        padding: 8px 16px;
    }
</style>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Point Of Sale</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">POS</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-warning card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">POS</div>
                </div>


               <form action="" method="post" name="">


                <div class="row">
                    <div class="col-md-8 mt-1">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-barcode"></i></span>
                            <input type="text" class="form-control" id="barcode-input" placeholder="Scan Barcode" aria-label="Barcode" aria-describedby="basic-addon1">
                        </div>

                        <?php
                       
                        $product_qur = "SELECT * FROM product_tbl";
                        $product_res = mysqli_query($con, $product_qur);
                        ?>

                        <select name="example" class="form-control select2" style="width: 100%;" id="example">
                            <option selected="selected">Select Product</option>
                            <?php
                            while($row = mysqli_fetch_array( $product_res)) {
                            ?>
                                <option><?php echo $row['product_name'] ?></option>
                            <?php
                            } ?>
                        </select>

                        <br>

                        <div class="tablefixhead mt-3">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Stock</th>
                                        <th>Sale Price</th>
                                        <th>QTY</th>
                                        <th>Total</th>
                                        <th>Del</th>
                                    </tr>
                                </thead>
                                <tbody class="details" id="itemtable">
                                    <!-- Products will be appended here dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div><!-- close col-md-8 -->

                    <?php
                        include('dbinfo.php');
                        $discount_qur = "SELECT * FROM  taxdis_tbl where taxdis_id = '1' ";
                        $discount_res = mysqli_query($con, $discount_qur);
                        $discount_row = mysqli_fetch_array($discount_res)
                        ?>


                    <div class="col-md-4 mt-1">
                        <div class="input-group mb-3">
                            <span class="input-group-text">SUBTOTAL(Rs)</span>
                            <input type="text" class="form-control" name="subtotal" aria-label="Amount" readonly>
                            <span class="input-group-text">Rs</span>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text">DISCOUNT(%)</span>
                            <input type="number" class="form-control" name="discount"  value="<?php echo $discount_row['discount'];?>" id="discount-percent" aria-label="Discount Percentage">
                            <span class="input-group-text">%</span>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text">DISCOUNT(Rs)</span>
                            <input type="text" class="form-control"  id="discount-amount" aria-label="Discount Amount" readonly>
                            <span class="input-group-text">Rs</span>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text">SGST(%)</span>
                            <input type="text" class="form-control" name="sgst" value="<?php echo $discount_row['sgst'];?>" aria-label="SGST Percentage" readonly>
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
                            <input type="text" class="form-control" id="cgst-amount" aria-label="CGST Amount" readonly>
                            <span class="input-group-text">Rs</span>
                        </div>

                        <hr style="height: 2px; border-width: 0; color: black; background-color: black;">

                        <div class="input-group mb-3">
                            <span class="input-group-text">TOTAL(Rs)</span>
                            <input type="text" class="form-control" name="total" id="total-amount" aria-label="Total Amount" readonly>
                            <span class="input-group-text">Rs</span>
                        </div>

                        <div class="icheck-success d-inline">
                            <input type="radio" name="r3" checked name="cash" value="Cash" id="radioSuccess1">
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
                            <input type="text" class="form-control" name="due" id="due-amount" aria-label="Due Amount" readonly>
                            <span class="input-group-text">Rs</span>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text">PAID(Rs)</span>
                            <input type="text" class="form-control" name="paid" id="paid-amount" aria-label="Paid Amount" required>
                            <span class="input-group-text">Rs</span>
                        </div>

                        <div class="card-footer">
                            <input type="submit" value="Save_Order" name="save_oder" class="btn btn-primary mt-2">
                        </div>

                        
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include("footer.php"); ?>

<script>$(document).ready(function() {
    // Barcode scan hone par
    $('#barcode-input').on('input', function() {
        var barcode = $(this).val(); // Barcode ki value lene ke liye

        if (barcode.length >= 1) { // Agar barcode ki length 1 ya zyada ho
            $.ajax({
                url: 'fetch-product.php', // PHP file jahan se product ka data aayega
                method: 'GET',
                data: { barcode: barcode }, // Barcode bhejna
                success: function(response) {
                    var product = JSON.parse(response); // Product ka data JSON format mein

                    if (product) {
                        // Check karenge agar product already table mein hai
                        var existingRow = $('#itemtable').find('tr[data-barcode="' + barcode + '"]');

                        if (existingRow.length > 0) {
                            // Agar product already table mein hai, quantity ko update karenge
                            var quantityInput = existingRow.find('.qty');
                            var newQuantity = parseInt(quantityInput.val()) + 1; // Quantity ko 1 badhaenge
                            quantityInput.val(newQuantity); // Quantity update

                            // Total ko bhi update karenge
                            var price = parseFloat(existingRow.find('td:nth-child(3)').text()); // Sale price
                            var newTotal = price * newQuantity; // Naya total calculate karenge
                            existingRow.find('.total').text(newTotal.toFixed(2)); // Total ko update karenge

                            // **IMPORTANT**: Hidden input field ko sirf agar wo empty ho update karenge
                            var totalInput = existingRow.find('.total input');
                            if (totalInput.length > 0) {
                                // Agar input field already exist hai, to uska value update karenge
                                totalInput.val(newTotal.toFixed(2)); // Update value of hidden input
                            } else {
                                // Agar input field nahi hai, to naya input field add karein
                                existingRow.find('.total').html('<input type="hidden" name="array_total[]" value="' + newTotal.toFixed(2) + '">' + newTotal.toFixed(2));
                            }

                            updateSubtotal(); // Subtotal ko update karenge
                        } else {
                            // Agar product nahi hai, nayi row add karenge
                            var newRow = `<tr data-barcode="${barcode}" data-product-name="${product.product_name}">
                                <td><input type="hidden" name="array_product_name[]" value="${product.product_name}">${product.product_name}</td>
                                <td><input type="hidden" name="array_stock[]" value="${product.stock}">${product.stock}</td>
                                <td><input type="hidden" name="array_price[]" value="${product.sale}">${product.sale}</td>
                                <td><input type="number" name="array_qty[]" class="form-control qty" value="1"></td>
                                <td class="total">
                                    <input type="hidden" name="array_total[]" value="${product.sale}">${product.sale}
                                </td>
                                <td><button type="button" class="btn btn-danger remove-item">Delete</button></td>
                                <input type="hidden" name="array_p_id[]" value="${product.p_id}">
                                <input type="hidden" name="array_barcode[]" value="${product.barcode}">
                            </tr>`;

                            $('#itemtable').append(newRow); // Nayi row ko table mein add karenge
                        }

                        $('#barcode-input').val(''); // Barcode input ko clear karenge
                        updateSubtotal(); // Subtotal ko update karenge
                    } else {
                        alert("Product not found!"); // Agar product nahi mila
                    }
                },
                error: function() {
                    alert("Error fetching product details."); // Agar error aaye
                }
            });
        }
    });

    // Dropdown selection hone par
    $('#example').on('change', function() {
        var productName = $(this).val(); // Selected product ka naam

        if (productName !== 'Select Product') { // Agar default option select na ho
            $.ajax({
                url: 'fetch-product.php', // PHP file jahan se product ka data aayega
                method: 'GET',
                data: { product_name: productName }, // Product ka naam bhejna
                success: function(response) {
                    var product = JSON.parse(response); // Product ka data JSON format mein

                    if (product) {
                        // Check karenge agar product already table mein hai (by product name or barcode)
                        var existingRow = $('#itemtable').find('tr[data-product-name="' + product.product_name + '"], tr[data-barcode="' + product.barcode + '"]');
                        
                        if (existingRow.length > 0) {
                            // Agar product already table mein hai, quantity ko update karenge
                            var quantityInput = existingRow.find('.qty');
                            var newQuantity = parseInt(quantityInput.val()) + 1; // Quantity ko 1 badhaenge
                            quantityInput.val(newQuantity); // Quantity update

                            // Total ko bhi update karenge
                            var price = parseFloat(existingRow.find('td:nth-child(3)').text()); // Sale price
                            var newTotal = price * newQuantity; // Naya total calculate karenge
                            existingRow.find('.total').text(newTotal.toFixed(2)); // Total ko update karenge

                            // Update the hidden input field for total value as well
                            var totalInput = existingRow.find('.total input');
                            if (totalInput.length > 0) {
                                // Update the value of the input field inside the total column
                                totalInput.val(newTotal.toFixed(2)); // Set total value in input field
                            } else {
                                // If there's no input field, add one manually
                                existingRow.find('.total').html('<input type="hidden" name="array_total[]" value="' + newTotal.toFixed(2) + '">' + newTotal.toFixed(2));
                            }

                            updateSubtotal(); // Subtotal ko update karenge
                        } else {
                            // Agar product nahi hai, nayi row add karenge
                            var newRow = `<tr data-barcode="${product.barcode}" data-product-name="${product.product_name}">
                                <td><input type="hidden" name="array_product_name[]" value="${product.product_name}">${product.product_name}</td>
                                <td><input type="hidden" name="array_stock[]" value="${product.stock}">${product.stock}</td>
                                <td><input type="hidden" name="array_price[]" value="${product.sale}">${product.sale}</td>
                                <td><input type="number" name="array_qty[]" class="form-control qty" value="1"></td>
                                <td class="total">
                                    <input type="hidden" name="array_total[]" value="${product.sale}">${product.sale}
                                </td>
                                <td><button type="button" class="btn btn-danger remove-item">Delete</button></td>
                                <input type="hidden" name="array_p_id[]" value="${product.p_id}">
                                <input type="hidden" name="array_barcode[]" value="${product.barcode}">
                            </tr>`;

                            $('#itemtable').append(newRow); // Nayi row ko table mein add karenge
                        }
                        updateSubtotal(); // Subtotal ko update karenge
                    } else {
                        alert("Product not found!"); // Agar product nahi mila
                    }
                },
                error: function() {
                    alert("Error fetching product details."); // Agar error aaye
                }
            });
        }
    });



    // Quantity update hone par
    $('#itemtable').on('input', '.qty', function() {
        var row = $(this).closest('tr');
        var priceText = row.find('td:nth-child(3)').text(); // Sale price as text
        var price = parseFloat(priceText); // Convert price to float

        // Ensure quantity is valid (non-zero and numeric)
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

        // Update the total text in .total column
        row.find('.total').text(total.toFixed(2)); // Set the text value for total

        // Find the input field inside the .total column and update its value
        var totalInput = row.find('.total input');
        if (totalInput.length > 0) {
            // Update the value of the input field inside the total column
            totalInput.val(total.toFixed(2)); // Set total value in input field
        } else {
            // If there's no input field, add one manually
            row.find('.total').html('<input type="hidden" name="array_total[]" value="' + total.toFixed(2) + '">' + total.toFixed(2));
        }

        updateSubtotal(); // Call the subtotal function to update the total amount
    });

    // Subtotal aur total update karna
    function updateSubtotal() {
        var subtotal = 0;
        $('#itemtable .total').each(function() {
            subtotal += parseFloat($(this).text()); // Subtotal calculate karenge
        });
        $('input[aria-label="Amount"]').val(subtotal.toFixed(2)); // Subtotal ko field mein update karenge
        
        var discount = parseFloat($('#discount-percent').val()) || 0;
        var discountAmount = (subtotal * discount) / 100;
        var discountedTotal = subtotal - discountAmount;

        $('#discount-amount').val(discountAmount.toFixed(2));

        // SGST aur CGST ko calculate karenge
        var sgst = parseFloat($('input[aria-label="SGST Percentage"]').val()) || 0;
        var cgst = parseFloat($('input[aria-label="CGST Percentage"]').val()) || 0;

        var sgstAmount = (discountedTotal * sgst) / 100;
        var cgstAmount = (discountedTotal * cgst) / 100;

        $('#sgst-amount').val(sgstAmount.toFixed(2));
        $('#cgst-amount').val(cgstAmount.toFixed(2));

        var totalAmount = discountedTotal + sgstAmount + cgstAmount;
        $('#total-amount').val(totalAmount.toFixed(2));

        // Paid amount aur Due amount ko update karenge
        var paidAmount = parseFloat($('#paid-amount').val()) || 0;
        var dueAmount = totalAmount - paidAmount;
        $('#due-amount').val(dueAmount.toFixed(2));
    }

    // Row ko delete karne par
    $('#itemtable').on('click', '.remove-item', function() {
        $(this).closest('tr').remove(); // Row ko remove karenge
        updateSubtotal(); // Subtotal ko update karenge
    });

    // Discount aur Paid amount change hone par
    $('#discount-percent, #paid-amount').on('input', function() {
        updateSubtotal(); // Subtotal update karenge
    });
});

</script>



