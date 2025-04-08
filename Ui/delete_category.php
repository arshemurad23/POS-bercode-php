<?php
    include("dbinfo.php");
    $id = $_REQUEST['id'];
    $qur = "delete from category_tbl where category_id = '$id'";
    $res = mysqli_query($con, $qur);
    if($res == true){
        header("location: category.php");

    }







?>