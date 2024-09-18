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
        <h1 class="text-center">Manage Classes</h1>
        <br />

        <?php
      
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        ?>
        <br><br>
        <a href="add-class.php" class="btn-primary">Add Class</a>
        <a href="assign-teacher.php" class="btn-primary">Assign Teacher</a>
        <br /><br />
        
        <table class="tbl-full">
            <tr>
                <th>Class Name</th>
                <th>Section</th>
                <th>Teacher</th>
                <th>Actions</th>
            </tr>

            <?php
           
            $sql = "SELECT c.*, t.teacher_name FROM tbl_class c LEFT JOIN tbl_teachers t ON c.teacher_id = t.teacher_id";
            $res = mysqli_query($conn, $sql);

            if ($res == TRUE) {
                $count = mysqli_num_rows($res);
                $sn = 1;

                if ($count > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $class_id = $row['class_id'];
                        $class_name = $row['class_name'];
                        $section = $row['section'];
                        $teacher_name = $row['teacher_name'] ? $row['teacher_name'] : 'Not Assigned';
            ?>

                        <tr>
                
                            <td><?php echo $class_name; ?></td>
                            <td><?php echo $section; ?></td>
                            <td><?php echo $teacher_name; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-class.php?id=<?php echo $class_id; ?>" class="btn-secondary">Update</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-class.php?id=<?php echo $class_id; ?>" class="btn-danger">Delete</a>
                            </td>
                        </tr>

            <?php
                    }
                } else {
                    echo "<tr><td colspan='5' class='error'>No Classes Available</td></tr>";
                }
            }
            ?>

        </table>
    </div>
</div>

<?php
include('partials/footer.php');
?>