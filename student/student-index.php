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
    <div class="wrond" style="position: relative; display: flex; justify-content: space-between; align-items: center; padding: 20px;">
        <?php
        if (isset($_SESSION['login'])) {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }

        $roll_number = $_SESSION['student']; 

       
        $sql_student = "SELECT student_id, class_id, student_name FROM tbl_students WHERE roll_number='$roll_number'";
        $res_student = mysqli_query($conn, $sql_student);

        if ($res_student) {
            if (mysqli_num_rows($res_student) > 0) {
                $row_student = mysqli_fetch_assoc($res_student);
                $student_id = $row_student['student_id'];
                $class_id = $row_student['class_id'];
                $student_name = $row_student['student_name'];

            } else {
                $student_name = "Student";
            }
        } else {
            $student_name = "Student";
        }
        ?>

       
        <div style="width: 60%; padding: 20px; color: #fff; background-color: rgba(0, 0, 0, 0.7); border-radius: 10px; margin-bottom: 200px">
            <h1 style="font-size: 32px; font-weight: bold;">Welcome Champ! 🚀</h1><br><br>
            <p style="font-size: 18px; margin-top: 10px;">Let’s check out your progress and achievements. 📚✨</p>

            
            <div style="margin-top: 20px; font-style: italic; font-size: 16px; color:#5352ed;">
                <p>“The beautiful thing about learning is that nobody can take it away from you.”</p>
                <p style="text-align: right; margin-top: 10px; color:yellow;">- B.B. King</p>
            </div>

            
            <div style="margin-top: 30px;">
                <h3 style="font-size: 20px;">Your Progress</h3>
                <div style="margin-top: 10px; background-color: #ccc; border-radius: 10px; overflow: hidden;">
                    <div style="width: 70%; background-color: #4caf50; padding: 10px 0; text-align: center; color: #fff;">70% Complete</div>
                </div>
            </div>
        </div>

       
        <div class="image-container" style="position: relative; display: flex; justify-content: center; align-items: center;">
            <img src="../img/profiles/2.png" alt="Student Image" style="width: 100%; height: 500px; object-fit: contain; margin-left: 30px;" />
            <div style="position: absolute; top: 0%; left: 20%; width: 250px; padding: 3px; background-color: #fff; border: 2px solid #ccc; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); font-size: 18px; text-align: center; animation: fadeInUp 1s ease-out, bounce 2s infinite;">
                Hi, <?php echo $student_name; ?>! 😎
                <div style="position: absolute; bottom: -20px; left: 30%; width: 0; height: 0; border-left: 20px solid transparent; border-right: 20px solid transparent; border-top: 20px solid #fff;"></div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    60% {
        transform: translateY(-5px);
    }
}
</style>

<?php  
include('partials/footer.php');     
?>
