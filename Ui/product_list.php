<?php
session_start();
if(!isset($_SESSION['admin-username']) || $_SESSION['admin-role'] != "admin"){
    header('location:../index.php');
}

include('dbinfo.php');
?>

<?php
include("admin-header.php");
?>

<main class="app-main"> <!--begin::App Content Header-->
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Product-List</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Product-List</li>
                    </ol>
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div> <!--end::App Content Header--> 

    <!--begin::App Content-->
    <div class="app-content"> 
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-md-12"> <!-- Full-width column for the card -->
                    <div class="card card-warning card-outline mb-4"> <!-- Single card containing all inputs -->
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-title">List</div>
                            <div class="d-flex justify-content-end ms-auto">
                                <input type="text" id="searchInput" class="form-control w-auto" style="max-width: 200px;" placeholder="Search by product ..." onkeyup="searchTable()">
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive"> <!-- Make the table responsive on mobile -->
                                <table class="table table-sm " id="categoryTable">
                                    <thead class="">
                                        <tr>
                                            <th>Barcode</th>
                                            <th>Product Name</th>
                                            <th>Category</th>
                                            <th>Description</th>
                                            <th>Stock</th>
                                            <th>Purchase Price</th>
                                            <th>Sale Price</th>
                                            <th>Product Image</th>
                                            <th colspan="4" class="text-center">Actions</th> <!-- Center the Actions header -->
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $select_qur = "SELECT * FROM product_tbl";
                                        $select_res = mysqli_query($con, $select_qur);

                                        while($row = mysqli_fetch_array($select_res)) {
                                        ?>
                                        <tr class="align-middle">
                                            <td><?php echo $row['barcode']; ?></td>
                                            <td><?php echo $row['product_name']; ?></td>
                                            <td><?php echo $row['category']; ?></td>
                                            <td><?php echo $row['description']; ?></td>
                                            <td><?php echo $row['stock']; ?></td>
                                            <td><?php echo $row['purchase']; ?></td>
                                            <td><?php echo $row['sale']; ?></td>
                                            <td><img src="assets/img/<?php echo $row['product_img'];?>" height="70" width="80" alt=""></td>
                                        
                                            <td class="text-center">
    <a href="product_barcode.php?id=<?php echo $row['product_id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" title="Barcode">
        <span class="fa fa-barcode"></span>
    </a>
    <a href="view_product.php?id=<?php echo $row['product_id']; ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" title="View">
        <span class="fa fa-eye"></span>
    </a>
    <a href="update_product.php?id=<?php echo $row['product_id']; ?>" class="btn btn-warning btn-sm" data-toggle="tooltip" title="Edit">
        <span class="fa fa-edit"></span>
    </a>
    <a href="delete_product.php?id=<?php echo $row['product_id']; ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete">
        <span class="fa-solid fa-trash"></span>
    </a>
</td>

<!-- Initialize Bootstrap tooltips -->
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive -->
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div> <!-- end col-md-12 -->
            </div> <!-- end row -->
        </div> <!-- end container-fluid -->
    </div> <!-- end app-content -->
</main>

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


<?php
include("footer.php");
?>