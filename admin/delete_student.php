<?php

include('../config/constants.php');


$id = $_GET['id'];


$sql = "DELETE FROM tbl_students WHERE student_id = $id";


$res = mysqli_query($conn, $sql);


if($res == TRUE) {
    $_SESSION['delete'] = "<div class='success'>Student Deleted Successfully</div>";
    header('location:'.SITEURL.'admin/manage_students.php');
} else {
    $_SESSION['delete'] = "<div class='error'>Failed to delete Student</div>";
    header('location:'.SITEURL.'admin/manage_students.php');
}
?>
