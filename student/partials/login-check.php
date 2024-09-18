<?php
if(!isset($_SESSION['student'])){
    $_SESSION['no-login-message'] = "<div class='error text-center'>Please Login to Access Student Dashboard</div>";
    header('location:' . SITEURL . 'student/student-login.php');
    exit();
}
?>