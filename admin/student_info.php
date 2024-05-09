<?php
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION["username"])) {
  // Redirect to the login page if not logged in
  header("Location: admin_login.php");
  exit();
}

// Include database connection
include_once "connection.php";

// Check if student ID is provided in the URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Fetch student details from database
    $query_student = "SELECT * FROM students WHERE id = '$student_id'";
    $result_student = mysqli_query($conn, $query_student);

    if ($result_student && mysqli_num_rows($result_student) > 0) {
        $row_student = mysqli_fetch_assoc($result_student);
        $firstName = $row_student['firstname'];
        $lastName = $row_student['lastname'];
        $email = $row_student['email'];
        // Add more fields if needed
    } else {
        echo "Student not found.";
        exit(); // Stop further execution
    }

    // Fetch classes enrolled by the student from database
    $query_classes = "SELECT c.class_name FROM enrollment e INNER JOIN classes c ON e.class_id = c.id WHERE e.student_id = '$student_id'";
    $result_classes = mysqli_query($conn, $query_classes);

    $classes = [];
    if ($result_classes && mysqli_num_rows($result_classes) > 0) {
        while ($row_classes = mysqli_fetch_assoc($result_classes)) {
            $classes[] = $row_classes['class_name'];
        }
    }
} else {
    echo "Invalid request.";
    exit(); // Stop further execution
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
  <title>Student Information</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .card {
      max-width: 600px;
      margin: 50px auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
      margin-bottom: 20px;
      text-align: center;
    }

    .student-details {
      margin-bottom: 20px;
    }

    .student-details p {
      margin-bottom: 10px;
    }

    .enrolled-classes {
      margin-bottom: 10px;
    }

    .enrolled-classes ul {
      list-style-type: none;
      padding: 0;
    }

    .enrolled-classes li {
      margin-bottom: 5px;
    }
  </style>
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
    <h2>Student Information</h2>

    <div class="student-details">
      <p><strong>ID:</strong> <?php echo $student_id; ?></p>
      <p><strong>First Name:</strong> <?php echo $firstName; ?></p>
      <p><strong>Last Name:</strong> <?php echo $lastName; ?></p>
      <p><strong>Email:</strong> <?php echo $email; ?></p>
      <?php if (!empty($classes)): ?>
        <div class="enrolled-classes">
          <p><strong>Enrolled Classes:</strong></p>
          <ul>
            <?php foreach ($classes as $class): ?>
              <li><?php echo $class; ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
      <!-- Add more fields if needed -->
    </div>

    <a href="students.php">Back to Students List</a>
  </div>
</body>
<?php
  require_once "dashboard_script.html";
?>
</html>
