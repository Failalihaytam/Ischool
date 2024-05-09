<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Include database connection
  include_once "connection.php";

  // Get form data
  $username_email = $_POST["email"];
  $password = $_POST["password"];

  // Validate and sanitize inputs (you can add more validation here)
  $username_email = filter_var($username_email, FILTER_SANITIZE_STRING);

  // Check if the username/email and password match in the database
  $query = "SELECT * FROM teachers WHERE email='$username_email' AND password='".md5($password)."'";
  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);

  if ($count == 1) {
    // Fetch the teacher ID from the database
    $row = mysqli_fetch_assoc($result);
    $teacher_id = $row['id'];

    // Set session variables
    $_SESSION["email"] = $username_email;
    $_SESSION["teacher_id"] = $teacher_id; // Add teacher ID to the session

    // Redirect to welcome page after successful login
    header("Location: welcome.php");
    exit();
  } else {
    echo "E-mail ou mot de passe invalide..";
  }

  // Close database connection
  mysqli_close($conn);
}
?>
