<?php
session_start();
if(!isset($_SESSION['admin-username']) || $_SESSION['admin-role'] != "admin"){
    header('location:../index.php');
  }
   ?>

   <?php
  include("dbinfo.php");
  $id = $_REQUEST['id'];
  $qur = "select * from product_tbl where product_id = '$id'";
  $res = mysqli_query($con, $qur);
  $row = mysqli_fetch_array($res);

?>

<?php
include("admin-header.php");
?>


<main class="app-main"> <!--begin::App Content Header-->
            <div class="app-content-header"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Print Barcode</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                Print Barcode
                                </li>
                            </ol>
                        </div>
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div> <!--end::App Content Header--> <!--begin::App Content-->
            <div class="app-content"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                   
               

                <div class="row">

        
<div class="col-md-12"> <!-- Full-width column for the card -->

    <div class="card card-warning card-outline mb-4 mt-3"> <!-- Single card containing all inputs -->
        <div class="card-header">
            <div class="card-title">Print List</div>

        </div>

        <div class="card-body">

<div class="row">
<div class="col-md-6">
<ul class="list-group">

<center><p class="list-group-item list-group-item-info"><br>Product Details<br></p></center>



</ul>


<form action="print_barcode.php" method="post">
        <!-- Barcode -->
     

        <!-- Product Name -->
        <div class="form-group">
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" value="<?php echo $row['product_name']; ?>" class="form-control" readonly>
        </div>


        <div class="form-group mt-4">
            <label for="product_name">Barcode ID:</label>
            <input type="text" id="product_name" name="barcode" value="<?php echo $row['barcode']; ?>"  class="form-control" readonly>
        </div>


    


         <!-- Sale Price -->
         <div class="form-group mt-4">
        <label for="sale">Sale Price:</label>
        <input type="text" id="sale" name="sale" value="<?php echo $row['sale']; ?>" class="form-control" readonly>
        </div>


        <!-- Stock -->
        <div class="form-group mt-4">
            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" value="<?php echo $row['stock']; ?>" class="form-control" readonly>
        </div>

        <!-- Category -->
       

       

       
         
                <div class="col-sm-4 mt-4">
            <label for="sale">Barcode Quantity:</label>

                    <input type="number" id="product_profit" name="barcode_quantity" class="form-control form-control-sm" required>
                </div>


        <button type="submit" name="print" class="btn btn-primary mt-4">Print code</button>
    </form>



</div>








<div class="col-md-6">
    <ul class="list-group">
<center><p class="list-group-item list-group-item-info"><br>Product image<br></p></center>

<center>
<img src="./assets/img/<?php echo $row['product_img']?>" height="600" width="500" alt="img">

</center>

</ul>
</div>











</div>
        
        </div> <!-- end card-body -->
    </div> <!-- end card -->
</div> <!-- end col-md-12 -->
</div> <!-- end row -->



               
                </div> <!--end::Container-->
            </div> <!--end::App Content-->
        </main> 







        <?php
include("footer.php");
?>