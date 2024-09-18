<?php
include('../config/constants.php');

$id = $_GET['id'];
$sql = "DELETE FROM tbl_teachers WHERE teacher_id=$id";
$res = mysqli_query($conn, $sql);

if ($res == TRUE) {
    $_SESSION['delete'] = "<div class='success'>Teacher Deleted Successfully</div>";
    header('location:' . SITEURL . 'admin/manage_teachers.php');
} else {
    $_SESSION['delete'] = "<div class='error'>Failed to Delete Teacher</div>";
    header('location:' . SITEURL . 'admin/manage_teachers.php');
}
?>
