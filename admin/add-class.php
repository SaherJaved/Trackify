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
        <h1>Add Class</h1>
        <br />

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        ?>
        
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Class Name: </td>
                    <td><input type="text" name="class_name" placeholder="Enter class name" required></td>
                </tr>

                <tr>
                    <td>Section: </td>
                    <td><input type="text" name="section" placeholder="Enter section" required></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Class" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
include('partials/footer.php');

if (isset($_POST['submit'])) {
    $class_name = $_POST['class_name'];
    $section = $_POST['section'];

    $sql = "INSERT INTO tbl_class (class_name, section) VALUES ('$class_name', '$section')";

    $res = mysqli_query($conn, $sql);

    if ($res == TRUE) {
        $_SESSION['add'] = "<div class='success manage'>Class Added Successfully</div>";
        header("Location: " . SITEURL . 'admin/manage_classes.php');
    } else {
        $_SESSION['add'] = "<div class='error'>Failed to Add Class</div>";
        header("Location: " . SITEURL . 'admin/add-class.php');
    }
}
?>
