<?php 
session_start();
include('../config/constants.php');

function sanitize($conn, $input) {
    return mysqli_real_escape_string($conn, trim($input));
}


function verify_password($input_password, $stored_password) {

    if (strpos($stored_password, '$2y$') === 0 || strpos($stored_password, '$2a$') === 0) {
        return password_verify($input_password, $stored_password);
    }
    
    return md5($input_password) === $stored_password;
}


if (isset($_POST['roll_number']) && !isset($_POST['password']) && !isset($_POST['new_password']) && !isset($_POST['confirm_password'])) {
    $roll_number = sanitize($conn, $_POST['roll_number']);
    $sql = "SELECT * FROM tbl_students WHERE roll_number='$roll_number'";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) == 1) {
        $student = mysqli_fetch_assoc($res);
        $_SESSION['roll_number'] = $roll_number;
        if (!empty($student['password'])) {
            echo 'password_required'; 
        } else {
            echo 'no_password'; 
        }
    } else {
        echo 'Roll number does not exist.';
    }
} 

elseif (isset($_POST['password']) && !isset($_POST['new_password']) && !isset($_POST['confirm_password'])) {
    $roll_number = $_SESSION['roll_number'];
    $password = sanitize($conn, $_POST['password']); 
    $sql = "SELECT * FROM tbl_students WHERE roll_number='$roll_number'";
    $res = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($res) == 1) {
        $student = mysqli_fetch_assoc($res);
       
        if (verify_password($password, $student['password'])) {
            $_SESSION['student_logged_in'] = true;
            $_SESSION['student'] = $roll_number; 
            echo 'login_success'; 
        } else {
            echo 'incorrect_password'; 
        }
    } else {
        echo 'Roll number does not exist.';
    }
} 

elseif (isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
    $roll_number = $_SESSION['roll_number'];
    $new_password = sanitize($conn, $_POST['new_password']);
    $confirm_password = sanitize($conn, $_POST['confirm_password']);

    if ($new_password === $confirm_password) {
       
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE tbl_students SET password='$hashed_password' WHERE roll_number='$roll_number'";
        $res = mysqli_query($conn, $sql);

        if ($res) {
            $_SESSION['student_logged_in'] = true; 
            $_SESSION['student'] = $roll_number; 
            echo 'password_set'; 
        } else {
            echo 'Failed to set password. Please try again.';
        }
    } else {
        echo 'Passwords do not match.';
    }
} else {
    echo 'Invalid request.';
}
?>
