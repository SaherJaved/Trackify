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
        <h1 class="text-center">Manage Attendance</h1>
        <br />

        <form action="" method="GET" class="dropdown-form">
            <table class="tbl-30">
                <tr>
                    <td>Select Class: </td>
                    <td>
                        <select name="class_id" onchange="this.form.submit()">
                            <option value="">Select Class</option>
                            <?php
                           
                            $class_sql = "SELECT * FROM tbl_class";
                            $class_res = mysqli_query($conn, $class_sql);

                            if ($class_res == TRUE) {
                                while ($class_row = mysqli_fetch_assoc($class_res)) {
                                    $selected = "";
                                    if (isset($_GET['class_id']) && $_GET['class_id'] == $class_row['class_id']) {
                                        $selected = "selected";
                                    }
                                    echo "<option value='" . $class_row['class_id'] . "' $selected>" . $class_row['class_name'] . " - " . $class_row['section'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
            </table>
        </form>

        <br />

        <?php
        if (isset($_GET['class_id']) && $_GET['class_id'] != "") {
            $class_id = $_GET['class_id'];
          
            $attendance_sql = "SELECT tbl_students.student_name, tbl_attendance.status 
                               FROM tbl_students 
                               LEFT JOIN tbl_attendance 
                               ON tbl_students.student_id = tbl_attendance.student_id 
                               AND tbl_attendance.attendance_date = CURDATE()
                               WHERE tbl_students.class_id = $class_id";
            $attendance_res = mysqli_query($conn, $attendance_sql);

            if ($attendance_res == TRUE && mysqli_num_rows($attendance_res) > 0) {
                ?>
                <table class="tbl-full">
                    <tr>
                        <th>S.No.</th>
                        <th>Student Name</th>
                        <th>Status</th>
                    </tr>
                    <?php
                    $sn = 1;
                    while ($row = mysqli_fetch_assoc($attendance_res)) {
                        $student_name = $row['student_name'];
                        $status = $row['status'] ? $row['status'] : "Not Marked";
                        ?>
                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $student_name; ?></td>
                            <td><?php echo $status; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <br />
                <a href="mark_attendance.php?class_id=<?php echo $class_id; ?>" class="btn-primary">Mark Attendance</a>
                <?php
            } else {
                echo "<div class='error'>No Students Found for Selected Class</div>";
            }
        }
        ?>
    </div>
</div>

<?php
include('partials/footer.php');
?>
