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
        <h1>Add Student</h1>
        <br><br>

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Student Name: </td>
                    <td><input type="text" name="student_name" placeholder="Enter student name" required></td>
                </tr>

                <tr>
                    <td>Roll Number: </td>
                    <td><input type="text" name="roll_number" placeholder="Enter Roll Number" required></td>
                </tr>

                <tr>
                    <td>Date of Birth: </td>
                    <td><input type="date" name="date_of_birth" required></td>
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
                                    $class_id = $row['class_id'];
                                    $class_name = $row['class_name'];
                                    ?>
                                    <option value="<?php echo htmlspecialchars($class_id); ?>" <?php if (isset($_GET['class_id']) && $_GET['class_id'] == $class_id) echo 'selected'; ?>><?php echo htmlspecialchars($class_name); ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Student Picture: </td>
                    <td><input type="file" name="picture" required></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Student" class="btn-secondary">
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
    $student_name = $_POST['student_name'];
    $roll_number = $_POST['roll_number'];
    $date_of_birth = $_POST['date_of_birth'];
    $class_id = $_POST['class_id'];

   
    $profile_picture = "";
    if (isset($_FILES['picture']['name']) && $_FILES['picture']['name'] != "") {
        $profile_picture = $_FILES['picture']['name'];

       
        $ext = pathinfo($profile_picture, PATHINFO_EXTENSION);
        $profile_picture = "Student_" . rand(100, 999) . '.' . $ext;

        $source_path = $_FILES['picture']['tmp_name'];
        $destination_path = "../images/students/" . $profile_picture;

        
        if (!is_dir("../images/students/")) {
            mkdir("../images/students/", 0755, true);
        }

      
        $upload = move_uploaded_file($source_path, $destination_path);

        if (!$upload) {
            $_SESSION['upload'] = "<div class='error'>Failed to Upload Picture.</div>";
            header("Location: " . SITEURL . 'admin/add_student.php');
            exit();
        }
    }

    
    $sql = "INSERT INTO tbl_students (student_name, roll_number, date_of_birth, class_id, profile_picture) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $student_name, $roll_number, $date_of_birth, $class_id, $profile_picture);

    $res = $stmt->execute();

    if ($res) {
        $_SESSION['add'] = "<div class='success'>Student Added Successfully</div>";
        header("Location: " . SITEURL . 'admin/manage_students.php');
    } else {
        $_SESSION['add'] = "<div class='error'>Failed to Add Student</div>";
        header("Location: " . SITEURL . 'admin/add_student.php');
    }
}
?>
