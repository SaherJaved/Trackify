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
        <h1>Update Teacher</h1>
        <br /><br />

        <?php
        $id = $_GET['id'];
        $sql = "SELECT * FROM tbl_teachers WHERE teacher_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $teacher_name = $row['teacher_name'];
            $username = $row['username'];
            $email = $row['email'];
            $current_picture = $row['profile_picture'];
        } else {
            header('Location: ' . SITEURL . 'admin/manage_teachers.php');
            exit();
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Teacher Name: </td>
                    <td><input type="text" name="teacher_name" value="<?php echo htmlspecialchars($teacher_name); ?>" required></td>
                </tr>

                <tr>
                    <td>Email: </td>
                    <td><input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>"></td>
                </tr>

                <tr>
                    <td>Profile Picture: </td>
                    <td>
                        <?php
                        if ($current_picture != "") {
                            echo "<img src='../images/teachers/$current_picture' width='100px'>";
                        }
                        ?>
                        <input type="file" name="profile_picture">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Teacher" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
include('partials/footer.php');

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $teacher_name = $_POST['teacher_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $profile_picture = $current_picture; 

    if (isset($_FILES['profile_picture']['name']) && $_FILES['profile_picture']['name'] != "") {
        $profile_picture = $_FILES['profile_picture']['name'];
        $ext = pathinfo($profile_picture, PATHINFO_EXTENSION);
        $profile_picture = "Teacher_" . rand(100, 999) . '.' . $ext;
        $source_path = $_FILES['profile_picture']['tmp_name'];
        $destination_path = "../images/teachers/" . $profile_picture;

        if (!move_uploaded_file($source_path, $destination_path)) {
            $_SESSION['upload'] = "<div class='error'>Failed to Upload Picture.</div>";
            header("Location: " . SITEURL . 'admin/update-teacher.php?id=' . $id);
            exit();
        }
    }

    if (!empty($password)) {
        $password = password_hash($password, PASSWORD_DEFAULT); 
        $sql = "UPDATE tbl_teachers SET teacher_name=?, username=?, password=?, email=?, profile_picture=? WHERE teacher_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $teacher_name, $username, $password, $email, $profile_picture, $id);
    } else {
        $sql = "UPDATE tbl_teachers SET teacher_name=?, username=?, email=?, profile_picture=? WHERE teacher_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $teacher_name, $username, $email, $profile_picture, $id);
    }

    $res = $stmt->execute();

    if ($res) {
        $_SESSION['update'] = "<div class='success'>Teacher Updated Successfully</div>";
        header("Location: " . SITEURL . 'admin/manage_teachers.php');
    } else {
        $_SESSION['update'] = "<div class='error'>Failed to Update Teacher</div>";
        header("Location: " . SITEURL . 'admin/update-teacher.php?id=' . $id);
    }
}
?>
