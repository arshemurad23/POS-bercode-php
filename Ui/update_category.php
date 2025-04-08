<?php
session_start();
include("dbinfo.php");
$insert_alert = false ;
$id = $_REQUEST['id'];

if(isset($_POST['category_add'])){
    $category_name = $_POST['category_name'];

    if($category_name != ""){

    $update_qur = "update category_tbl set category_name ='$category_name' where category_id = '$id' ";
    $update_res = mysqli_query($con,$update_qur);
    if($update_res == true){
        $insert_alert = true ;
        header("location: category.php");

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
                            <h3 class="mb-0">Category-Eidt</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                Category
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
                    $select_qur = "SELECT * FROM category_tbl where category_id = '$id'";
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
                                        <div class="row mb-3"> <label for="inputEmail3" class="col-sm-2 col-form-label">Category</label>
                                            <div class="col-sm-10"> <input type="name" value="<?php echo $row['category_name'] ?>" name="category_name" class="form-control" id="" placeholder="Enter Category "> </div>
                                        </div>
                                        <button type="submit" name="category_add" class="btn btn-warning">Add</button> 

                                        </div>
                                      </form> <!--end::Form-->
                            </div> <!--end::Horizontal Form--></div>

                                    
                                   
                              




               <!-- table -->
               <div class="col-md-6">
    <div class="card mb-4">
        <div class="card-header">
        <h3 class="card-title">Category Menu</h3>

        </div> <!-- /.card-header -->
        
        <div class="card-body p-0">
            <!-- Search Bar Positioned to the Right -->
          
            
            <table class="table table-sm" id="categoryTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category</th>
                         </tr>
                </thead>

                <tbody>
                   
                    <tr class="align-middle">
                        <td><?php echo $row['category_id']; ?></td>
                        <td><?php echo $row['category_name']; ?></td>
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