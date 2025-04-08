<?php
    include("dbinfo.php");
    $id = $_REQUEST['id'];
    $invoice_tbl_qur = "DELETE FROM invoice_tbl WHERE invoice_id = '$id' ";
    $invoice_tbl_res = mysqli_query($con, $invoice_tbl_qur);

    if($invoice_tbl_res == true){

        
        $invoice_details_qur = "DELETE FROM invoice_details_tbl WHERE invoice_id = '$id'";
        $invoice_details_res = mysqli_query($con, $invoice_details_qur);

         if($invoice_details_res == true){

            header("location:oder_list.php");

         }

    }

   



   
    
    

?>