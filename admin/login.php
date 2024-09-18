<?php
session_start(); 

include('../config/constants.php');
if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); 

    
    $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

    $res = mysqli_query($conn, $sql);


    $count = mysqli_num_rows($res);

    if($count == 1) {
        $_SESSION['login'] = "<div class='success'>Login Successful</div>";
        $_SESSION['user'] = $username; 
        header('location:' . SITEURL . 'admin/');
        exit();
    } else {
        $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match</div>";
        header('location:' . SITEURL . 'admin/login.php');
        exit(); 
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../img/user-icn.png">
    <title>Login - AMS</title>
    <style>
        
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden; 
        }

       
        #video-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

      
        video {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            object-fit: cover; 
            z-index: -1;
        }

        .main-container {
            display: flex;
            height: 100vh; 
        }

        .heading-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px;
        }

        .login-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin-right: 100px;
        }

        .heading {
            margin-bottom: 80px;
            text-align: center;
            font-size: 30px;
            color: white;
        }

        .login {
            background: rgba(255, 255, 255, 0.7); 
            padding: 40px; 
            border-radius: 10px;
            width: 400px; 
            max-width: 90%;
            text-align: center;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2); 
        }

        .login-header {
            display: flex;
            align-items: center;
            gap: 15px; 
        }

        .login-logo {
            margin-left: 100px;
            width: 80px; 
            height: auto; 
        }

        .text-right {
            font-size: 34px; 
            color: #333; 
        }

        .form-group {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px; 
        }

        label {
            width: 100px; 
            text-align: right; 
            margin-right: 20px; 
            font-weight: 700;
        }

        input[type="text"],
        input[type="password"] {
            width: 300px; 
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            padding: 10px;
            border-radius: 5px;
            border: none;
            background-color: #5cb85c;
            color: white;
            cursor: pointer;
            width: 200px; 
        }

        input[type="submit"]:hover {
            background-color: #4cae4c;
        }

        .success {
            color: #2ed573;
        }

        .error {
            color: #ff4757;
        }
    </style>
</head>
<body>


<div id="video-container">
    <video autoplay muted loop>
        <source src="../videos/video-1.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div>

<div class="main-container">
  
    <div class="heading-container">
        <div class="heading">
            <h1>Student Attendance Management System</h1>
        </div>
    </div>

  
    <div class="login-container">
        <div class="login">
            <div class="login-header">
             
                <img src="../img/attnlg.jpg" alt="Login Logo" class="login-logo">
                
                <h1 class="text-right">Login</h1>
            </div>
            <br><br>

            <?php
    if(isset($_SESSION['login'])) {
        echo $_SESSION['login'];
        unset($_SESSION['login']);
    }

    if(isset($_SESSION['no-login-message'])) {
        echo $_SESSION['no-login-message'];
        unset($_SESSION['no-login-message']);
    }
    ?>
    <br><br>
    <form action="" method="POST" class="text-center">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter Username">
        </div>
        <br>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter Password">
        </div>
        <br>
        <input type="submit" name="submit" value="Login" class="btn-primary">
        <br><br>
    </form>

    <p class="text-center">Created by - <a href="https://www.saher.com">Saher Javed</a></p>
</div>
</div>
</div>

</body>
</html>

