<?php
session_start();

// Check if the user is logged in as a student
if (!isset($_SESSION['student_id'])) {
    header("Location: classes.php"); // Redirect to welcome page if not logged in
    exit();
}

// Include database connection
include_once "connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['class_id'])) {
    $class_id = $_POST['class_id'];
    $student_id = $_SESSION['student_id'];
    // Check if the student is already enrolled in the class
    $check_sql = "SELECT * FROM enrollment WHERE student_id = '$student_id' AND class_id = '$class_id'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        $message = "Vous êtes déjà inscrit dans cette classe";
    } else {
        // Enroll the student in the class
        $enroll_sql = "INSERT INTO enrollment (student_id, class_id) VALUES ('$student_id', '$class_id')";
        if (mysqli_query($conn, $enroll_sql)) {
            echo "Inscription réussie !";
            header("Location: welcome.php");
        } else {
            echo "Error: " . $enroll_sql . "<br>" . mysqli_error($conn);
        }
    }
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    require_once "dashbord_head.html";
    ?>
    <style>
        .card {
            display: flex;
            flex-direction: column;
            width: 800px;
            margin: 40px auto;
            padding: 20px;
            border: 2px solid #c4c4c4;
            border-radius: 20px;
            background: #D5D9EE;
            box-shadow: 9px 9px 30px #b0b0b0,
                -9px -9px 30px #ffffff;
        }

        .message {
            font-size: 20px;
            font-weight: 500;
            padding: 25px;
            text-align: center;
            border-bottom: 2px solid #141D47;
            border-radius: 25px;
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.2);
        }
    </style>
    <title>Enrollment</title>
</head>

<body>
    <div class="container">
        <?php
        require_once "dashbord_body.html";
        ?>
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
            </div>
            <div class="card">
                <?php echo "<p class='message'>".$message ."</p>"; ?>
            </div>
        </div>
    </div>
</body>
<?php
require_once "dashboard_script.html";
?>

</html>