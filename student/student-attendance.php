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
    <div class="attendance-container">
        <?php
        $roll_number = $_SESSION['student']; 

        
        $sql_student = "SELECT student_id FROM tbl_students WHERE roll_number='$roll_number'";
        $res_student = mysqli_query($conn, $sql_student);

        if ($res_student) {
            if (mysqli_num_rows($res_student) > 0) {
                $row_student = mysqli_fetch_assoc($res_student);
                $student_id = $row_student['student_id'];

                
                $sql_attendance = "SELECT attendance_date, status FROM tbl_attendance WHERE student_id='$student_id' ORDER BY attendance_date DESC";
                $res_attendance = mysqli_query($conn, $sql_attendance);

                if ($res_attendance) {
                    if (mysqli_num_rows($res_attendance) > 0) {
                        ?>

                        <div class="attendance-table-wrapper">
                            <table class="attendance-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row_attendance = mysqli_fetch_assoc($res_attendance)) {
                                        $attendance_date = $row_attendance['attendance_date'];
                                        $status = $row_attendance['status'];
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($attendance_date); ?></td>
                                            <td class="<?php echo strtolower(htmlspecialchars($status)); ?>"><?php echo htmlspecialchars($status); ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <?php
                    } else {
                        echo "<p class='no-records'>No attendance records found.</p>";
                    }
                } else {
                    echo "<p class='error-message'>Error fetching attendance records.</p>";
                }
            } else {
                echo "<p class='error-message'>No student found.</p>";
            }
        } else {
            echo "<p class='error-message'>Error fetching student details.</p>";
        }
        ?>
    </div>
</div>

<?php
include('partials/footer.php');
?>
