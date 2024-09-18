<?php
session_start(); 
include('../config/constants.php'); 
include('partials/login-check.php'); 
include('partials/menu.php'); 
?>

<div class="main-content">
<video autoplay muted loop style="position: absolute; z-index: -1; width: 100%; height: 100%; object-fit: cover;">
        <source src="../videos/video-1.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="profile-container">
        <?php
        $roll_number = $_SESSION['student']; 

        
        $sql_student = "SELECT student_id, student_name, class_id, date_of_birth FROM tbl_students WHERE roll_number='$roll_number'";
        $res_student = mysqli_query($conn, $sql_student);

        if ($res_student) {
            if (mysqli_num_rows($res_student) > 0) {
                $row_student = mysqli_fetch_assoc($res_student);
                $student_id = $row_student['student_id'];
                $class_id = $row_student['class_id'];
                $student_name = $row_student['student_name'];
                $date_of_birth = $row_student['date_of_birth'];
                $profile_picture_path = "../img/profiles/" . $roll_number . ".jpg";
                
               
                if (!file_exists($profile_picture_path)) {
                    $profile_picture_path = '../img/default-profile.png';
                }

                
                $sql_class = "SELECT class_name, teacher_id FROM tbl_class WHERE class_id='$class_id'";
                $res_class = mysqli_query($conn, $sql_class);
                $class_name = "Unknown";
                $teacher_id = null;

                if ($res_class) {
                    if (mysqli_num_rows($res_class) > 0) {
                        $row_class = mysqli_fetch_assoc($res_class);
                        $class_name = $row_class['class_name'];
                        $teacher_id = $row_class['teacher_id'];
                    }
                }

                
                $sql_teacher = "SELECT teacher_name FROM tbl_teachers WHERE teacher_id='$teacher_id'";
                $res_teacher = mysqli_query($conn, $sql_teacher);

                $teachers = [];
                if ($res_teacher) {
                    if (mysqli_num_rows($res_teacher) > 0) {
                        $row_teacher = mysqli_fetch_assoc($res_teacher);
                        $teachers[] = $row_teacher['teacher_name'];
                    } else {
                        $teachers[] = "No teachers assigned.";
                    }
                } else {
                    $teachers[] = "Error fetching teacher details.";
                }
                ?>

                <div class="profile-card">
                    <div class="profile-picture">
                        <img src="<?php echo $profile_picture_path; ?>" alt="Profile Picture" onerror="this.src='../img/default-profile.png'">
                    </div>
                    <div class="profile-info">
                        <h2><?php echo $student_name; ?></h2>
                        <p><strong>Class:</strong> <?php echo $class_name; ?></p>
                        <p><strong>Date of Birth:</strong> <?php echo $date_of_birth; ?></p>
                        <p><strong>Assigned Teachers:</strong></p>
                        <ul>
                            <?php foreach ($teachers as $teacher) { ?>
                                <li><?php echo $teacher; ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>

                <?php
            } else {
                echo "<p>No student found.</p>";
            }
        } else {
            echo "<p>Error fetching student details.</p>";
        }
        ?>
    </div>
</div>

<?php
include('partials/footer.php');
?>
