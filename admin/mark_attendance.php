<?php
include('../config/constants.php'); 
include('partials/menu.php');
include('partials/login-check.php');

if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];
} else {
    header('location:' . SITEURL . 'admin/manage_attendance.php');
}

if (isset($_POST['mark_attendance'])) {
    $attendance_date = date('Y-m-d');
    $student_ids = $_POST['student_ids'];

    foreach ($student_ids as $student_id => $status) {
       
        $check_sql = "SELECT * FROM tbl_attendance WHERE student_id=$student_id AND attendance_date='$attendance_date'";
        $check_res = mysqli_query($conn, $check_sql);

        if (mysqli_num_rows($check_res) == 0) {
        
            $insert_sql = "INSERT INTO tbl_attendance (student_id, attendance_date, status) VALUES ($student_id, '$attendance_date', '$status')";
            mysqli_query($conn, $insert_sql);
        } else {
         
            $update_sql = "UPDATE tbl_attendance SET status='$status' WHERE student_id=$student_id AND attendance_date='$attendance_date'";
            mysqli_query($conn, $update_sql);
        }
    }

    header('location:' . SITEURL . 'admin/manage_attendance.php?class_id=' . $class_id);
}
?>

<div class="main-content">
<video autoplay muted loop>
            <source src="../videos/video-1.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    <div class="wrapper">
        <h1>Mark Attendance</h1>
        <br />

        <?php
        
        $student_sql = "SELECT * FROM tbl_students WHERE class_id=$class_id";
        $student_res = mysqli_query($conn, $student_sql);

        if ($student_res == TRUE && mysqli_num_rows($student_res) > 0) {
            ?>
            <form action="" method="POST">
                <table class="tbl-full">
                    <tr>
                        <th>S.No.</th>
                        <th>Student Name</th>
                        <th>Attendance Status</th>
                    </tr>
                    <?php
                    $sn = 1;
                    while ($student_row = mysqli_fetch_assoc($student_res)) {
                        $student_id = $student_row['student_id'];
                        $student_name = $student_row['student_name'];

                    
                        $attendance_sql = "SELECT * FROM tbl_attendance WHERE student_id=$student_id AND attendance_date=CURDATE()";
                        $attendance_res = mysqli_query($conn, $attendance_sql);
                        $attendance_row = mysqli_fetch_assoc($attendance_res);

                        $status = isset($attendance_row['status']) ? $attendance_row['status'] : "Present";
                        ?>
                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $student_name; ?></td>
                            <td>
                                <select name="student_ids[<?php echo $student_id; ?>]">
                                    <option value="Present" <?php echo ($status == 'Present') ? 'selected' : ''; ?>>Present</option>
                                    <option value="Absent" <?php echo ($status == 'Absent') ? 'selected' : ''; ?>>Absent</option>
                                </select>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <br />
                <input type="submit" name="mark_attendance" value="Submit" class="btn-primary">
            </form>
            <?php
        } else {
            echo "<div class='error'>No Students Found for Selected Class</div>";
        }
        ?>
    </div>
</div>

<?php
include('partials/footer.php');
?>
