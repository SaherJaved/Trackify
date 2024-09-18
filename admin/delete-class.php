<?php
include('../config/constants.php');

$id = $_GET['id'];


$sql_check = "SELECT * FROM tbl_students WHERE class_id = $id";
$res_check = mysqli_query($conn, $sql_check);

if (mysqli_num_rows($res_check) > 0) {
    $_SESSION['delete'] = "<div class='error'>Cannot delete class because there are students assigned to it.</div>";
    header('location:' . SITEURL . 'admin/manage_classes.php');
    exit(); 
}


$sql_delete = "DELETE FROM tbl_class WHERE class_id = $id";
$res_delete = mysqli_query($conn, $sql_delete);

if ($res_delete) {
    $_SESSION['delete'] = "<div class='success'>Class Deleted Successfully</div>";
} else {
    $_SESSION['delete'] = "<div class='error'>Failed to Delete Class</div>";
}

header('location:' . SITEURL . 'admin/manage_classes.php');
?>
