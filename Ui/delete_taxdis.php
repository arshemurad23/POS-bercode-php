<?php
    include("dbinfo.php");
    $id = $_REQUEST['id'];
    $qur = "delete from  taxdis_tbl where taxdis_id = '$id'";
    $res = mysqli_query($con, $qur);
    if($res == true){
        header("location:  taxdis.php");

    }







?>