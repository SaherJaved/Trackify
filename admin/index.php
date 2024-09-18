<?php
session_start(); // Start session
include('../config/constants.php'); // Include constants
include('partials/login-check.php'); // Include authentication check
include('partials/menu.php'); // Include menu
?>



<div class="main-content">

<video autoplay muted loop>
            <source src="../videos/video-1.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    <div class="wrond">
        <h1>Dashboard</h1>
        <br><br>
        
        <?php
 
        if(isset($_SESSION['login'])) {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        ?>
        <br><br>
        
     

        <?php
     
 

     
        $sql_students = "SELECT COUNT(*) AS count FROM tbl_students";
        $res_students = mysqli_query($conn, $sql_students);
        $row_students = mysqli_fetch_assoc($res_students);
        $student_count = $row_students['count'];

      
        $sql_teachers = "SELECT COUNT(*) AS count FROM tbl_teachers";
        $res_teachers = mysqli_query($conn, $sql_teachers);
        $row_teachers = mysqli_fetch_assoc($res_teachers);
        $teacher_count = $row_teachers['count'];

       
        $sql_classes = "SELECT COUNT(*) AS count FROM tbl_class";
        $res_classes = mysqli_query($conn, $sql_classes);
        $row_classes = mysqli_fetch_assoc($res_classes);
        $class_count = $row_classes['count'];

     
        $sql_attendance = "SELECT COUNT(*) AS count FROM tbl_attendance";
        $res_attendance = mysqli_query($conn, $sql_attendance);
        $row_attendance = mysqli_fetch_assoc($res_attendance);
        $attendance_count = $row_attendance['count'];
        ?>

        <div class="col-4 text-center">
            <h1><?php echo $student_count; ?></h1>
            <br />
            Students
        </div>

        <div class="col-4 text-center">
            <h1><?php echo $teacher_count; ?></h1>
            <br />
            Teachers
        </div>

        <div class="col-4 text-center">
            <h1><?php echo $class_count; ?></h1>
            <br />
            Classes
        </div>

        <div class="col-4 text-center">
            <h1><?php echo $attendance_count; ?></h1>
            <br />
            Attendance Records
        </div>

        <div class="clearfix"></div>
    </div>
</div>   

<?php  

include ('partials/footer.php');     
?>
