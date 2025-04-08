<?php
session_start();
include("dbinfo.php");
$insert_alert = false ;
$id = $_REQUEST['id'];

if(isset($_POST['category_add'])){

    $SGST = $_POST['SGST'];
    $CGST = $_POST['CGST'];
    $Discount = $_POST['Discount'];

if($SGST != "" && $CGST != "" && $Discount != ""){

    $update_qur = "update taxdis_tbl set sgst ='$SGST' , cgst ='$CGST' , discount  ='$Discount'  where taxdis_id = '$id' ";
    $update_res = mysqli_query($con,$update_qur);
    if($update_res == true){
        $insert_alert = true ;
        header("location: taxdis.php");

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
                        <div class="col-sm-6">
                            <h3 class="mb-0">Tax & Discount - Eidt</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                Tax & Discount Eidt
                                </li>
                            </ol>
                        </div>
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div> <!--end::App Content Header--> <!--begin::App Content-->
            <div class="app-content"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                   
                <div class="row">

                <?php
                    $select_qur = "SELECT * FROM taxdis_tbl where taxdis_id = '$id'";
                    $select_res = mysqli_query($con, $select_qur);
                    $row = mysqli_fetch_array($select_res)
                ?>
                    <!-- form -->
               <div class="col-md-6"> <div class="card card-warning card-outline mb-4"> <!--begin::Header-->
                                <div class="card-header">
                                    <div class="card-title">Category Form</div>
                                </div> <!--end::Header--> <!--begin::Form-->
                                <form action="" method="post"> <!--begin::Body-->

                                    <div class="card-body">
                                        <div class="row mb-3"> <label for="inputEmail3" class="col-sm-2 col-form-label">SGST(%)</label>
                                            <div class="col-sm-10"> <input type="sgst" value="<?php echo $row['sgst'] ?>" name="SGST" class="form-control" id="" placeholder="Enter Category "> </div>
                                        </div>


                                        <div class="row mb-3"> <label for="inputEmail3" class="col-sm-2 col-form-label">CGST(%)</label>
                                            <div class="col-sm-10"> <input type="CGST" value="<?php echo $row['cgst'] ?>" name="CGST" class="form-control" id="" placeholder="Enter Category "> </div>
                                        </div>


                                        <div class="row mb-3"> <label for="inputEmail3" class="col-sm-2 col-form-label">Discount(%)</label>
                                            <div class="col-sm-10"> <input type="Discount" value="<?php echo $row['discount'] ?>" name="Discount" class="form-control" id="" placeholder="Enter Category "> </div>
                                        </div>

                                        <button type="submit" name="category_add" class="btn btn-warning">Edit</button> 

                                        </div>
                                      </form> <!--end::Form-->
                            </div> <!--end::Horizontal Form--></div>

                                    
                                   
                              




               <!-- table -->
               <div class="col-md-6">
    <div class="card mb-4">
        <div class="card-header">
        <h3 class="card-title">Tax & Discount Menu</h3>

        </div> <!-- /.card-header -->
        
        <div class="card-body p-0">
            <!-- Search Bar Positioned to the Right -->
          
            
            <table class="table table-sm" id="categoryTable">
                <thead>
                    <tr>
                        <th>SGST</th>
                        <th>CGST</th>
                        <th>Discount</th>
                         </tr>
                </thead>

                <tbody>
                   
                    <tr class="align-middle">
                    <td><?php echo $row['sgst']; ?></td>
                    <td><?php echo $row['cgst']; ?></td>
                    <td><?php echo $row['cgst']; ?></td>
                      </tr>
                    <?php
                    
                    ?>
                </tbody>
            </table>
        </div> <!-- /.card-body -->
    </div> <!-- /.card -->
</div>









                            </div>
               </div> <!--end::App Content-->
            </div> <!--end::App Content-->
        </main> 



        



        <?php
include("footer.php");
?>