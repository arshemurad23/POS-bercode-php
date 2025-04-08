<?php
session_start();
if (!isset($_SESSION['admin-username']) || $_SESSION['admin-role'] != "admin") {
    header('location:../index.php');
}
?>


<?php

include("dbinfo.php");
$insert_alert = false ;
if(isset($_POST['category_add'])){

    $category_name = $_POST['category_name'];

if($category_name != ""){

    $insert_qur = "insert into category_tbl values (null,'$category_name')";
    $insert_res = mysqli_query($con,$insert_qur);
    if($insert_res == true){
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
                            <h3 class="mb-0">Category</h3>
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
                <!-- form -->
               <div class="col-md-6"> <div class="card card-warning card-outline mb-4"> <!--begin::Header-->
                                <div class="card-header">
                                    <div class="card-title">Category Form</div>
                                </div> <!--end::Header--> <!--begin::Form-->
                                <form action="" method="post"> <!--begin::Body-->

                                    <div class="card-body">
                                        <div class="row mb-3"> <label for="inputEmail3" class="col-sm-2 col-form-label">Category</label>
                                            <div class="col-sm-10"> <input type="name" name="category_name" class="form-control" id="" placeholder="Enter Category " required> </div>
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

             <!-- Smaller input with custom width and right-aligned -->
             <input type="text" id="searchInput" class="form-control w-auto" style="max-width: 200px; float: right;" placeholder="Search by Category Name..." onkeyup="searchTable()">
        </div> <!-- /.card-header -->
        
        <div class="card-body p-0">
            <!-- Search Bar Positioned to the Right -->

           

            
            <table class="table table-sm" id="categoryTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Edit</th>
                        <th style="width: 40px">Drop</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $select_qur = "SELECT * FROM category_tbl";
                    $select_res = mysqli_query($con, $select_qur);

                    while($row = mysqli_fetch_array($select_res)) {
                    ?>
                    <tr class="align-middle">
                        <td><?php echo $row['category_id']; ?></td>
                        <td><?php echo $row['category_name']; ?></td>
                        <td><a href="update_category.php?id=<?php echo $row['category_id']; ?>" class="btn btn-warning">Update</a></td>
                        <td><a href="delete_category.php?id=<?php echo $row['category_id']; ?>" class="btn btn-danger">Delete</a></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div> <!-- /.card-body -->
    </div> <!-- /.card -->
</div>

<script>
    // Function to filter table based on the search input
    function searchTable() {
        var input, filter, table, tr, td, i, j, txtValue;
        input = document.getElementById('searchInput');
        filter = input.value.toLowerCase();
        table = document.getElementById('categoryTable');
        tr = table.getElementsByTagName('tr');

        // Loop through all table rows (except the first row, which is the header)
        for (i = 1; i < tr.length; i++) {
            td = tr[i].getElementsByTagName('td');
            let found = false;

            // Loop through each cell in the row to find a match
            for (j = 0; j < td.length; j++) {
                if (td[j]) {
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        found = true;
                        break; // Stop checking other columns if a match is found
                    }
                }
            }

            // Show or hide the row based on whether a match was found
            if (found) {
                tr[i].style.display = '';
            } else {
                tr[i].style.display = 'none';
            }
        }
    }
</script>

               








                            </div>
               </div> <!--end::App Content-->
            </div> <!--end::App Content-->
        </main> 



        


        <?php
include("footer.php");
?>