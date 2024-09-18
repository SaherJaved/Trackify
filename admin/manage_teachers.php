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
        <h1 class="text-center">Manage Teachers</h1>
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
         <br /> <br /> 
        <a href="add-teacher.php" class="btn-primary">Add Teacher</a>
        <br /><br />
        
        <table class="tbl-full">
            <tr>
                <th>S.No</th>
                <th>Teacher Name</th>
                <th>Email</th>
                <th>Picture</th>
                <th>Actions</th>
            </tr>

            <?php
            
            $sql = "SELECT * FROM tbl_teachers";
            $res = mysqli_query($conn, $sql);

            if ($res == TRUE) {
                $count = mysqli_num_rows($res);
                $sn = 1;

                if ($count > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $teacher_id = $row['teacher_id'];
                        $teacher_name = $row['teacher_name'];
                        $email = $row['email'];
                        $profile_picture = $row['profile_picture'];
            ?>

                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo htmlspecialchars($teacher_name); ?></td>
                            <td><?php echo htmlspecialchars($email); ?></td>
                            <td>
                                <?php
                                if ($profile_picture != "") {
                                    echo "<img src='../images/teachers/$profile_picture' width='100px'>";
                                } else {
                                    echo "<div class='error'>No Picture</div>";
                                }
                                ?>
                            </td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-teacher.php?id=<?php echo $teacher_id; ?>" class="btn-secondary">Update</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-teacher.php?id=<?php echo $teacher_id; ?>" class="btn-danger">Delete</a>
                            </td>
                        </tr>

            <?php
                    }
                } else {
                    echo "<tr><td colspan='5' class='error'>No Teachers Available</td></tr>";
                }
            }
            ?>

        </table>
    </div>
</div>

<?php
include('partials/footer.php');
?>
