<?php


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!defined('SITEURL')) {
    define('SITEURL', 'http://localhost/Saher/student_ams/');
}

if (!defined('LOCALHOST')) {
    define('LOCALHOST', 'localhost');
}

if (!defined('DB_USERNAME')) {
    define('DB_USERNAME', 'root');
}

if (!defined('DB_PASSWORD')) {
    define('DB_PASSWORD', '');
}

if (!defined('DB_NAME')) {
    define('DB_NAME', 'student_ams');
}


$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME) or die(mysqli_error($conn));
