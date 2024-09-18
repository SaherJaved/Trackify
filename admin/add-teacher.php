<?php
include('../config/constants.php'); 
include('partials/menu.php');
include('partials/login-check.php');
?>

<div class="main-content">
<video autoplay muted loop>
    <source src="../videos/video-1.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>
<div class="wrapper">
    <h1>Add Teacher</h1>
    <br /><br />

    <?php
    if (isset($_SESSION['add'])) {
        echo $_SESSION['add'];
        unset($_SESSION['add']);
    }
    ?>
    
    <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
                <td>Teacher Name: </td>
                <td><input type="text" name="teacher_name" placeholder="Enter teacher name" required></td>
            </tr>

            <tr>
                <td>Email: </td>
                <td><input type="email" name="email" placeholder="Enter email"></td>
            </tr>

            <tr>
                <td>Profile Picture: </td>
                <td><input type="file" name="profile_picture"></td>
            </tr>

            <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Add Teacher" class="btn-secondary">
                </td>
            </tr>
        </table>
    </form>
</div>
</div>

<?php
include('partials/footer.php');

if (isset($_POST['submit'])) {
    $teacher_name = $_POST['teacher_name'];
    $email = $_POST['email'];

   
    $profile_picture = "";
    if (isset($_FILES['profile_picture']['name']) && $_FILES['profile_picture']['name'] != "") {
        $profile_picture = $_FILES['profile_picture']['name'];
        $ext = pathinfo($profile_picture, PATHINFO_EXTENSION);
        $profile_picture = "Teacher_" . rand(100, 999) . '.' . $ext;
        $source_path = $_FILES['profile_picture']['tmp_name'];
        $destination_path = "../images/teachers/" . $profile_picture;

      
        if (!is_dir("../images/teachers/")) {
            mkdir("../images/teachers/", 0755, true);
        }

    
        if (!move_uploaded_file($source_path, $destination_path)) {
            $_SESSION['upload'] = "<div class='error'>Failed to Upload Picture.</div>";
            header("Location: " . SITEURL . 'admin/add-teacher.php');
            exit();
        }
    }

    $sql = "INSERT INTO tbl_teachers (teacher_name, email, profile_picture) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sss", $teacher_name, $email, $profile_picture);
        $res = $stmt->execute();

        if ($res) {
            $_SESSION['add'] = "<div class='success'>Teacher Added Successfully</div>";
            header("Location: " . SITEURL . 'admin/manage_teachers.php');
        } else {
            $_SESSION['add'] = "<div class='error'>Failed to Add Teacher</div>";
            header("Location: " . SITEURL . 'admin/add-teacher.php');
        }
    } else {
        $_SESSION['add'] = "<div class='error'>Failed to Prepare SQL Statement</div>";
        header("Location: " . SITEURL . 'admin/add-teacher.php');
    }
}
?>
