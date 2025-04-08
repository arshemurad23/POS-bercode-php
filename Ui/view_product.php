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
                            <h3 class="mb-0">View product</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    View product
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
            <div class="card-title">View </div>

        </div>

        <div class="card-body">

<div class="row">
<div class="col-md-6">
<ul class="list-group">

<center><p class="list-group-item list-group-item-info"><br>Product Details<br></p></center>

<?php
require 'vendor/autoload.php';

use Picqer\Barcode\BarcodeGeneratorPNG;


    // Barcode generator object create karein
    $generator = new BarcodeGeneratorPNG();

    // Barcode ko generate karein
    $barcode = $generator->getBarcode( $row['product_name'] , $generator::TYPE_CODE_128);

    // HTML mein barcode image ko display karen
   

?>

<li class="list-group-item mt-3">
  Barcode 
  <span class=" text-dark float-end">
    <img src="data:image/png;base64,<?php echo base64_encode($barcode); ?>" />
    <p class="text-center"><?php echo $row['barcode'] ?></p>
  </span>

</li>
<li class="list-group-item mt-3">
  Product Name 
  <span class="badge badge-primary float-end"><?php echo $row['product_name']; ?></span>
</li>
<li class="list-group-item mt-3">
  Category 
  <span class="badge badge-warning float-end"><?php echo $row['category']; ?></span>
</li>
<li class="list-group-item mt-3">
  Description 
  <span class="badge badge-danger float-end"><?php echo $row['description']; ?></span>
</li>
<li class="list-group-item mt-3">
  Stock 
  <span class="badge badge-success float-end"><?php echo $row['stock']; ?></span>
</li>
<li class="list-group-item mt-3">
  Purchase Price 
  <span class="badge badge-info float-end"><?php echo $row['purchase']; ?></span>
</li>
<li class="list-group-item mt-3">
  Sale Price 
  <span class="badge badge-dark float-end"><?php echo $row['sale']; ?></span>
</li>
<li class="list-group-item mt-3">
  Product Profit 
  <span class="badge badge-secondary float-end"><?php echo $row['sale'] - $row['purchase']; ?></span>
</li>

</ul>

</div>








<div class="col-md-6">
    <ul class="list-group">
<center><p class="list-group-item list-group-item-info"><br>Product image<br></p></center>

<center>
<img src="./assets/img/<?php echo $row['product_img']?>" height="300" width="300" alt="img">

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