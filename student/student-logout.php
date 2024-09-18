<?php

include('../config/constants.php');


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


session_destroy();


header('location:'.SITEURL.'student/student-login.php');


exit();
?>
