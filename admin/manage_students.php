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
        <h1 class="text-center">Manage Students</h1>
        <br />

        <?php
        if(isset($_SESSION['add'])){
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if(isset($_SESSION['delete'])){
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }

        if(isset($_SESSION['update'])){
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }

        if(isset($_SESSION['student-not-found'])){
            echo $_SESSION['student-not-found'];
            unset($_SESSION['student-not-found']);
        }

        if(isset($_SESSION['pwd-not-matched'])){
            echo $_SESSION['pwd-not-matched'];
            unset($_SESSION['pwd-not-matched']);
        }

        if(isset($_SESSION['change-pwd'])){
            echo $_SESSION['change-pwd'];
            unset($_SESSION['change-pwd']);
        }
        ?>
        <br><br>

        <div class="action-container">

        
      
    
        <form action="" method="GET" class="dropdown-form">
            <select name="class_id" onchange="this.form.submit()">
                <option value="">Select Class</option>
                <?php
               
                $sql = "SELECT * FROM tbl_class";
                $res = mysqli_query($conn, $sql);

                if ($res == TRUE) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $class_id = $row['class_id'];
                        $class_name = $row['class_name'];
                        ?>
                        <option value="<?php echo $class_id; ?>" <?php if(isset($_GET['class_id']) && $_GET['class_id'] == $class_id) echo 'selected'; ?>><?php echo $class_name; ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </form>

        <br />
        <a href="add_student.php" class="btn-primary">Add Student</a>
        </div>
        <br /> <br />
        <table class="tbl-full">
            <tr>
                <th>S.No</th>
                <th>Picture</th>
                <th>Student Name</th>
                <th>Roll Number</th>
                <th>Date of Birth</th>
                <th>Class</th>
                <th>Actions</th>
            </tr>

            <?php
          
            $class_id = isset($_GET['class_id']) ? $_GET['class_id'] : '';

    
            $sql = "SELECT s.*, c.class_name FROM tbl_students s 
                    LEFT JOIN tbl_class c ON s.class_id = c.class_id";
            if ($class_id != '') {
                $sql .= " WHERE s.class_id = '$class_id'";
            }

            $res = mysqli_query($conn, $sql);
            if($res == TRUE){
                $count = mysqli_num_rows($res);
                $sn = 1;
                if($count > 0){
                    while($rows = mysqli_fetch_assoc($res)){
                        $id = $rows['student_id'];
                        $profile_picture = $rows['profile_picture'];
                        $student_name = $rows['student_name'];
                        $roll_number = $rows['roll_number'];
                        $date_of_birth = $rows['date_of_birth'];
                        $class_name = $rows['class_name'];
                        ?>

                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td>
                        <?php 
                        if($profile_picture != ""){
                            ?>
                            <img src="../images/students/<?php echo $profile_picture; ?>" width="80px" height="80px">
                            <?php
                        } else {
                            echo "<div class='error'>No Picture</div>";
                        }
                        ?>
                    </td>
                            <td><?php echo $student_name; ?></td>
                            <td><?php echo $roll_number; ?></td>
                            <td><?php echo $date_of_birth; ?></td>
                            <td><?php echo $class_name; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update_student.php?id=<?php echo $id; ?>" class="btn-secondary">Update Student</a>
                                <a href="<?php echo SITEURL; ?>admin/delete_student.php?id=<?php echo $id; ?>" class="btn-danger">Delete Student</a>
                            </td>
                        </tr>

                        <?php
                    }
                } else {
                    echo "<tr><td colspan='6'>No students found</td></tr>";
                }
            }
            ?>
        </table>
    </div>
</div>

<?php
include('partials/footer.php');
?>
