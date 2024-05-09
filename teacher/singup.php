<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Include database connection
  include_once "connection.php";

  // Get form data
  $first_name = $_POST["firstname"];
  $last_name = $_POST["lastname"];
  $email = $_POST["email"];
  $password = $_POST["password"];

  // Validate and sanitize inputs (you can add more validation here)
  $username = filter_var($username, FILTER_SANITIZE_STRING);
  $email = filter_var($email, FILTER_SANITIZE_EMAIL);

  // Hash the password (for better security, use password_hash() function)
  $hashed_password = md5($password); // This is just an example, not recommended for production

  // Insert user data into the database
  $query = "INSERT INTO teachers (firstName, lastName, email, password) VALUES ('$first_name', '$last_name', '$email', '$hashed_password')";
  $result = mysqli_query($conn, $query);

  if ($result) {
    // Redirect to welcome page after successful sign-up
    header("Location: welcome.php");
    exit();
  } else {
    echo "Erreur: " . mysqli_error($conn);
  }

  // Close database connection
  mysqli_close($conn);
}
?>
