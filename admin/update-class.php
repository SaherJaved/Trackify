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
        <h1>Update Class</h1>
        <br /><br />

        <?php
      
        $id = $_GET['id'];

      
        $sql = "SELECT * FROM tbl_class WHERE class_id=$id";
        $res = mysqli_query($conn, $sql);

        if ($res == TRUE) {
            if (mysqli_num_rows($res) > 0) {
                $row = mysqli_fetch_assoc($res);
                $class_name = $row['class_name'];
                $section = $row['section'];
                $teacher_id = $row['teacher_id'];
            } else {
                header('location:' . SITEURL . 'admin/manage_classes.php');
            }
        }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Class Name: </td>
                    <td><input type="text" name="class_name" value="<?php echo $class_name; ?>" required></td>
                </tr>

                <tr>
                    <td>Section: </td>
                    <td><input type="text" name="section" value="<?php echo $section; ?>" required></td>
                </tr>

                <tr>
                    <td>Assign Teacher: </td>
                    <td>
                        <select name="teacher_id">
                            <option value="">Select Teacher</option>
                            <?php
                         
                            $sql_teachers = "SELECT * FROM tbl_teachers";
                            $res_teachers = mysqli_query($conn, $sql_teachers);

                            if ($res_teachers == TRUE) {
                                while ($row_teachers = mysqli_fetch_assoc($res_teachers)) {
                                    $teacher_id_db = $row_teachers['teacher_id'];
                                    $teacher_name = $row_teachers['teacher_name'];
                                    ?>
                                    <option value="<?php echo $teacher_id_db; ?>" <?php if ($teacher_id == $teacher_id_db) echo "selected"; ?>>
                                        <?php echo $teacher_name; ?>
                                    </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Class" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php


if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $class_name = $_POST['class_name'];
    $section = $_POST['section'];
    $teacher_id = $_POST['teacher_id'];

   
    $sql = "UPDATE tbl_class SET 
            class_name='$class_name', 
            section='$section', 
            teacher_id='$teacher_id' 
            WHERE class_id=$id";

    $res = mysqli_query($conn, $sql);

    if ($res == TRUE) {
        $_SESSION['update'] = "<div class='success'>Class Updated Successfully</div>";
        header("Location: " . SITEURL . 'admin/manage_classes.php');
    } else {
        $_SESSION['update'] = "<div class='error'>Failed to Update Class</div>";
        header("Location: " . SITEURL . 'admin/update-class.php?id=' . $id);
    }
}
?>
