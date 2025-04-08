<?php
    include("dbinfo.php");
    $id = $_REQUEST['id'];
    $qur = "delete from product_tbl where product_id = '$id'";
    $res = mysqli_query($con, $qur);
    if($res == true){
        header("location:product_list.php");

    }







?>