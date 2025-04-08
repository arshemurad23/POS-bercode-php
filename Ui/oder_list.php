<?php
session_start();
if (!isset($_SESSION['admin-username']) || $_SESSION['admin-role'] != "admin") {
    header('location:../index.php');
}

include('dbinfo.php');

// Define how many records per page
$records_per_page = 15;

// Get the current page number (default is 1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Fetch records for the current page, order by the latest invoice (descending order)
$select_qur = "SELECT * FROM invoice_tbl ORDER BY invoice_id DESC LIMIT $offset, $records_per_page";
$select_res = mysqli_query($con, $select_qur);

// Count the total number of records in the database
$total_qur = "SELECT COUNT(*) FROM invoice_tbl";
$total_res = mysqli_query($con, $total_qur);
$total_rows = mysqli_fetch_array($total_res)[0];
$total_pages = ceil($total_rows / $records_per_page);
?>

<?php include("admin-header.php"); ?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Order-List</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Order-List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-warning card-outline mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-title">List</div>
                            <div class="d-flex justify-content-end ms-auto">
                                <input type="text" id="searchInput" class="form-control w-auto" style="max-width: 200px;" placeholder="Search by product ..." onkeyup="searchTable()">
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="categoryTable">
                                    <thead>
                                        <tr>
                                            <th>Invoice ID</th>
                                            <th>Order Date</th>
                                            <th>Total</th>
                                            <th>Paid</th>
                                            <th>Due</th>
                                            <th>Payment Method</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_array($select_res)) { ?>
                                        <tr class="align-middle">
                                            <td><?php echo $row['invoice_id']; ?></td>
                                            <td><?php echo $row['order_date']; ?></td>
                                            <td><?php echo $row['subtotal']; ?></td>
                                            <td><?php echo $row['paid']; ?></td>
                                            <td><?php echo $row['due']; ?></td>
                                            <td>
                                                <?php 
                                                if ($row['payment_type'] == "Cash") {
                                                    echo '<span class="badge badge-info">' . $row['payment_type'] . '</span>';
                                                } else if ($row['payment_type'] == 'Card') {
                                                    echo '<span class="badge badge-danger">' . $row['payment_type'] . '</span>';
                                                } else if ($row['payment_type'] == 'Check') {
                                                    echo '<span class="badge badge-warning">' . $row['payment_type'] . '</span>';
                                                } else {
                                                    echo '<span class="badge badge-secondary">' . $row['payment_type'] . '</span>';
                                                }
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="print_oder_bill.php?id=<?php echo $row['invoice_id']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" title="Print">
                                                    <span class="fa fa-print"></span>
                                                </a>
                                                <a href="update_order.php?id=<?php echo $row['invoice_id']; ?>" class="btn btn-warning btn-sm" data-toggle="tooltip" title="Edit">
                                                    <span class="fa fa-edit"></span>
                                                </a>
                                                <a href="delete_order.php?id=<?php echo $row['invoice_id']; ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete">
                                                    <span class="fa fa-trash"></span>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="pagination-container">
    <div class="d-flex justify-content-end">
        <ul class="pagination">
            <!-- Previous Page Link -->
            <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $page - 1; ?>">&laquo;</a>
            </li>

            <!-- Loop through each page number -->
            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php } ?>

            <!-- Next Page Link -->
            <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $page + 1; ?>">&raquo;</a>
            </li>
        </ul>
    </div>
</div>



                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
// Function to filter table based on the search input
function searchTable() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById('searchInput');
    filter = input.value.toLowerCase();
    table = document.getElementById('categoryTable');
    tr = table.getElementsByTagName('tr');

    // Loop through all table rows (except the first row, which is the header)
    for (i = 1; i < tr.length; i++) {
        td = tr[i].getElementsByTagName('td');
        let found = false;

        // Loop through each cell in the row, but only filter by the product-related column (e.g., 1st or 2nd column)
        for (j = 0; j < td.length; j++) {
            if (j === 0) { // Change the column index as necessary
                if (td[j]) {
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        found = true;
                        break; // Stop checking other columns if a match is found
                    }
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

<?php include("footer.php"); ?>
