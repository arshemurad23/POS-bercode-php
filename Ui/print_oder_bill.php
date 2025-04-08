<?php




include('dbinfo.php');
$id = $_REQUEST['id'];


$edit_order_qur = "SELECT * FROM invoice_tbl where invoice_id = '$id' ";
$edit_order_res = mysqli_query($con, $edit_order_qur);
$edit_order_row = mysqli_fetch_array($edit_order_res);

$invoice_id = $edit_order_row['invoice_id'];
$invoice_date = $edit_order_row['order_date'];
$sgst_p = $edit_order_row['sgst_p'];
$cgst_p = $edit_order_row['cgst_p'];
$discount = $edit_order_row['discount'];
$due = $edit_order_row['due'];
$paid = $edit_order_row['paid'];
$pay_type = $edit_order_row['payment_type'];
$total = $edit_order_row['total'];




// // // // invoice_details_tbl table

$sql = "SELECT * FROM invoice_details_tbl WHERE invoice_id = '$invoice_id'";
$res = mysqli_query($con, $sql);

                                    
 ?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Order List</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <script>
        
        window.onload = function() {
            window.print();
        };
    </script>

</head>
<body class="bg-light">

    <div class="container my-5 d-flex justify-content-center">
        <div class="card shadow-sm" style="width: 450px;"> <!-- Fixed width applied here -->
            <div class="card-body">
                <h1 class="text-center">Bill Order List</h1>
                <br>
                <div class="row">
    <div class="col-6">
        <p><u><strong>Bill ID:</strong> <?php echo $invoice_id; ?></u></p>
    </div>
    <div class="col-6 text-right">
        <p><u><strong>Order Date:</strong> <?php echo $invoice_date; ?></u></p>
    </div>
</div>
      
-  - - - - - - - - - - - - - - - - - - - -  - - - - - - - - - - - - - - - - -       

                <table class="table table-bordered mt-4">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    while($product_row = mysqli_fetch_array($res)){
                                    
                                     
                   ?>
                          <tr>
                            <td><?php echo $product_row['product_name'];?></td>
                            <td><?php echo $product_row['qty'];?></td>
                            <td><?php echo $product_row['rate'];?></td>
                            <td><?php echo $product_row['saleprice'];?></td>
                        </tr>
<?php
                    }
                    ?>

                      
                    </tbody>
                </table>


                -  - - - - - - - - - - - - - - - - - - - -  - - - - - - - - - - - - - - - - -       

                
                <div class="row mt-3">
    <div class="col-6">
        <p><u><strong>Discount% : </strong> </u></p>
    </div>
    <div class="col-6 text-right">
        <p> <?php echo $discount ; ?></p>
    </div>
</div>




                <div class="row ">
    <div class="col-6">
        <p><u><strong>Sgst% : </strong> </u></p>
    </div>
    <div class="col-6 text-right">
        <p> <?php echo $sgst_p ; ?></p>
    </div>
</div>



                <div class="row ">
    <div class="col-6">
        <p><u><strong>Cgst% : </strong> </u></p>
    </div>
    <div class="col-6 text-right">
        <p> <?php echo $cgst_p ; ?></p>
    </div>
</div>



<div class="row ">
    <div class="col-6">
        <p><u><strong>Due : </strong> </u></p>
    </div>
    <div class="col-6 text-right">
        <p> <?php echo $due ; ?></p>
    </div>
</div>



<div class="row ">
    <div class="col-6">
        <p><u><strong>Paid : </strong> </u></p>
    </div>
    <div class="col-6 text-right">
        <p> <?php echo $paid ; ?></p>
    </div>
</div>


-  - - - - - - - - - - - - - - - - - - - -  - - - - - - - - - - - - - - - - -    

<div class="row ">
    <div class="col-6">
        <p><u><strong>Payment type : </strong> </u></p>
    </div>
    <div class="col-6 text-right">
        <p> <?php echo $pay_type ; ?></p>
    </div>
</div>




<div class="d-flex justify-content-between font-weight-bold mt-3">
                    <span class="mt-2">Total Amount:</span>

                    <h3><span id="totalAmount"><?php echo $total ?></span></h3>
                </div>

-  - - - - - - - - - - - - - - - - - - - -  - - - - - - - - - - - - - - - - -    



              



            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
