<?php 
ob_start();
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
        <h1>Update Student</h1>
        <br><br>

        <?php
       
        $id = $_GET['id'];

  
        $sql = "SELECT * FROM tbl_students WHERE student_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $student_name = $row['student_name'];
            $roll_number = $row['roll_number'];
            $date_of_birth = $row['date_of_birth'];
            $class_id = $row['class_id'];
            $profile_picture = $row['profile_picture'];
        } else {
            
            header('location:' . SITEURL . 'admin/manage_students.php');
            exit();
        }
        ?>

     
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Student Name: </td>
                    <td><input type="text" name="student_name" placeholder="Enter student name" value="<?php echo htmlspecialchars($student_name); ?>" required></td>
                </tr>

                <tr>
                    <td>Roll Number: </td>
                    <td><input type="text" name="roll_number" placeholder="Enter Roll Number" value="<?php echo htmlspecialchars($roll_number); ?>" required></td>
                </tr>

                <tr>
                    <td>Date of Birth: </td>
                    <td><input type="date" name="date_of_birth" value="<?php echo htmlspecialchars($date_of_birth); ?>" required></td>
                </tr>

                <tr>
                    <td>Class: </td>
                    <td>
                        <select name="class_id" required>
                            <option value="">Select Class</option>
                            <?php
                            $sql = "SELECT * FROM tbl_class";
                            $res = mysqli_query($conn, $sql);

                            if ($res == TRUE) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $class_id_option = $row['class_id'];
                                    $class_name = $row['class_name'];
                                    ?>
                                    <option value="<?php echo htmlspecialchars($class_id_option); ?>" <?php if ($class_id_option == $class_id) echo 'selected'; ?>><?php echo htmlspecialchars($class_name); ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Profile Picture: </td>
                    <td>
                        <?php
                        if (!empty($profile_picture)) {
                            echo "<img src='../images/students/" . htmlspecialchars($profile_picture) . "' width='100px'><br>";
                        }
                        ?>
                        <input type="file" name="profile_picture">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                        <input type="hidden" name="existing_picture" value="<?php echo htmlspecialchars($profile_picture); ?>">
                        <input type="submit" name="submit" value="Update Student" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
include('partials/footer.php');

?>

<?php
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $student_name = $_POST['student_name'];
    $roll_number = $_POST['roll_number'];
    $date_of_birth = $_POST['date_of_birth'];
    $class_id = $_POST['class_id'];
    $existing_picture = $_POST['existing_picture'];
    $profile_picture = $_FILES['profile_picture']['name'];

    
    if ($profile_picture != "") {
        $ext = pathinfo($profile_picture, PATHINFO_EXTENSION);
        $profile_picture = "student_" . rand(100, 999) . '.' . $ext;

      
        $source_path = $_FILES['profile_picture']['tmp_name'];
        $destination_path = "../images/students/" . $profile_picture;

      
        if (!is_dir("../images/students/")) {
            mkdir("../images/students/", 0755, true);
        }

        if (move_uploaded_file($source_path, $destination_path)) {
        
            if ($existing_picture != "" && file_exists("../images/students/" . $existing_picture)) {
                unlink("../images/students/" . $existing_picture);
            }
        } else {
            $_SESSION['upload'] = "<div class='error'>Failed to upload image</div>";
            header("Location: " . SITEURL . 'admin/update_student.php?id=' . $id);
            exit();
        }
    } else {
        $profile_picture = $existing_picture;
    }

  
    $sql2 = "UPDATE tbl_students SET 
        student_name = ?, 
        roll_number = ?, 
        date_of_birth = ?, 
        class_id = ?, 
        profile_picture = ? 
        WHERE student_id = ?";

    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("sssisi", $student_name, $roll_number, $date_of_birth, $class_id, $profile_picture, $id);
    $res2 = $stmt2->execute();

    if ($res2 == TRUE) {
        $_SESSION['update'] = "<div class='success'>Student Updated Successfully</div>";
        header("Location: " . SITEURL . 'admin/manage_students.php');
    } else {
        $_SESSION['update'] = "<div class='error'>Failed to Update Student</div>";
        header("Location: " . SITEURL . 'admin/update_student.php?id=' . $id);
    }
}
?>
