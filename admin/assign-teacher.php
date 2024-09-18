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
        <h1>Assign Teacher to Class</h1>
        <br /><br />

        <?php
        if (isset($_SESSION['assign'])) {
            echo $_SESSION['assign'];
            unset($_SESSION['assign']);
        }
        ?>
        
        <form action="" method="POST">
            <table class="tbl-30">
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
                                    echo "<option value='" . $row['class_id'] . "'>" . $row['class_name'] . " - " . $row['section'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Teacher: </td>
                    <td>
                        <select name="teacher_id" required>
                            <option value="">Select Teacher</option>
                            <?php
                            $sql = "SELECT * FROM tbl_teachers";
                            $res = mysqli_query($conn, $sql);
                            if ($res == TRUE) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    echo "<option value='" . $row['teacher_id'] . "'>" . $row['teacher_name'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Assign Teacher" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
include('partials/footer.php');

if (isset($_POST['submit'])) {
    $class_id = $_POST['class_id'];
    $teacher_id = $_POST['teacher_id'];

    $sql = "UPDATE tbl_class SET teacher_id='$teacher_id' WHERE class_id='$class_id'";

    $res = mysqli_query($conn, $sql);

    if ($res == TRUE) {
        $_SESSION['assign'] = "<div class='success'>Teacher Assigned Successfully</div>";
        header("Location: " . SITEURL . 'admin/manage_classes.php');
    } else {
        $_SESSION['assign'] = "<div class='error'>Failed to Assign Teacher</div>";
        header("Location: " . SITEURL . 'admin/assign-teacher.php');
    }
}
?>
