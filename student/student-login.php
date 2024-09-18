<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../img/user-icn.png">
    <title>Login - Student Portal</title>
    <style>
    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        overflow: hidden;
        font-family: 'Poppins', sans-serif;
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
        align-items: center;
        justify-content: space-between;
        padding: 0 20px;
        box-sizing: border-box;
    }

    .image-container,
    .image-container-new {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .image-container-new {
        margin-right: 200px;
    }

    .image-container img,
    .image-container-new img {
        max-width: 100%;
        height: auto;
        object-fit: contain;
        max-height: 500px;
    }

    .login-container {
        flex: 0 1 35%;
        background: linear-gradient(135deg, rgba(72, 84, 96, 0.9), rgba(31, 52, 72, 0.9));
        padding: 40px;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        max-width: 450px;
        width: 100%;
        z-index: 1;
        margin-right: 20px;
    }

    .login-header {
        margin-bottom: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
    }

    .login-logo {
        width: 70px;
        height: auto;
    }

    .heading {
        font-size: 32px;
        color: #fff;
        margin: 0;
        text-align: left;
        font-weight: 600;
    }

    .form-group {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .form-group label {
        width: 30%;
        margin-right: 10px;
        text-align: right;
        font-weight: 600;
        color: #fff;
    }

    .form-group input {
        width: 70%;
        padding: 12px;
        border-radius: 5px;
        border: none;
        background: rgba(255, 255, 255, 0.9);
        font-size: 16px;
    }

    input[type="submit"] {
        margin-top: 20px;
        padding: 12px;
        border-radius: 5px;
        border: none;
        background: #2980b9;
        color: white;
        cursor: pointer;
        width: 30%;
        font-size: 18px;
        font-weight: 600;
        transition: background 0.3s ease;
    }

    input[type="submit"]:hover {
        background: #3498db;
    }

    .success {
        color: #2ed573;
        font-weight: 600;
    }

    .error {
        margin-bottom: 40px;
        color: #ff4757 !important;
        font-weight: 600;
    }

    .text-center {
        margin-top: 30px;
        text-align: center;
        color: #fff;
        font-size: 14px;
    }

    .text-center a {
        color: #ff6f61;
        text-decoration: none;
        font-weight: 600;
    }

    .text-center a:hover {
        text-decoration: underline;
    }

    .back-button {
        margin-top: 20px;
        padding: 12px 20px;
        border-radius: 8px;
        border: none;
        background: #333;
        color: #f9f9f9;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        transition: background 0.3s ease, box-shadow 0.3s ease;
    }

    .back-button:hover {
        background: #444;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

$(document).ready(function () {
    function showContainer(step) {
        $('#password_container, #create_password_container').hide();
        $('#roll_form input[type="submit"]').show();

        if (step === 'roll') {
            $('#roll_container').show();
            $('#roll_number').attr('readonly', false);
        } else if (step === 'password') {
            $('#password_container').show();
            $('#roll_number').attr('readonly', true);
            $('#roll_form input[type="submit"]').hide();
        } else if (step === 'create_password') {
            $('#create_password_container').show();
            $('#roll_number').attr('readonly', true);
            $('#roll_form input[type="submit"]').hide();
        }
    }

    function handleFormSubmit(formId) {
        let data = $(formId).serialize();
        $.ajax({
            type: 'POST',
            url: 'student-login-ajax.php',
            data: data,
            success: function (response) {
                if (response === 'password_required') {
                    showContainer('password');
                } else if (response === 'no_password') {
                    showContainer('create_password');
                } else if (response === 'login_success') {
                    window.location.href = 'student-index.php'; 
                } else if (response === 'incorrect_password') {
                    $('#password_error').text('Incorrect password. Please try again.');
                } else if (response.includes('Roll number does not exist')) {
                    $('#roll_error').text(response);
                } else if (response.includes('Passwords do not match')) {
                    $('#create_password_error').text(response);
                } else if (response === 'password_set') {
                    window.location.href = 'student-index.php'; 
                }
            },
            error: function (xhr, status, error) {
                console.log("AJAX Error: ", error); 
            }
        });
    }

    $('#roll_form').on('submit', function (e) {
        e.preventDefault();
        handleFormSubmit('#roll_form');
    });

    $('#password_form').on('submit', function (e) {
        e.preventDefault();
        handleFormSubmit('#password_form');
    });

    $('#create_password_form').on('submit', function (e) {
        e.preventDefault();
        handleFormSubmit('#create_password_form');
    });

    $('.back-button').on('click', function (e) {
        e.preventDefault();
        showContainer('roll');
    });
});


    </script>
</head>
<body>

<div id="video-container">
    <video autoplay muted loop>
        <source src="../videos/video-1.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div>

<div class="main-container">
    <div class="image-container">
        <img src="../img/profiles/7.png" alt="Student Image" />
    </div>

    <div class="login-container">
        <div class="login-header">
            <img src="../img/attnlg.jpg" alt="Login Logo" class="login-logo">
            <h1 class="heading">Student Login</h1>
        </div>

        <div id="roll_container">
            <form id="roll_form">
                <div class="form-group">
                    <label for="roll_number">Roll No:</label>
                    <input type="text" id="roll_number" name="roll_number" placeholder="Enter Roll Number" required>
                </div>
                <input type="submit" value="Next">
            </form>
            <p id="roll_error" class="error"></p>
        </div>

        <div id="password_container" style="display: none;">
            <form id="password_form">
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter Password" required>
                </div>
                <input type="submit" value="Login">
            </form>
            <p id="password_error" class="error"></p>
            <button class="back-button">Back</button>
        </div>

        <div id="create_password_container" style="display: none;">
            <form id="create_password_form">
                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" id="new_password" name="new_password" placeholder="Enter New Password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm New Password" required>
                </div>
                <input type="submit" value="Login">
            </form>
            <p id="create_password_error" class="error"></p>
            <button class="back-button">Back</button>
        </div>
    </div>

    <div class="image-container-new">
        <img src="../img/profiles/6.png" alt="Student Image" />
    </div>
</div>

</body>
</html>
