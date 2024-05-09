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

    // Validate and sanitize inputs
    $first_name = filter_var($first_name, FILTER_SANITIZE_STRING);
    $last_name = filter_var($last_name, FILTER_SANITIZE_STRING);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the database
    $query = "INSERT INTO students (firstName, lastName, email, password) VALUES ('$first_name', '$last_name', '$email', '$hashed_password')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Redirect to welcome page after successful sign-up
        header("Location: index.html");
        exit();
    } else {
        // Handle errors
        echo "Error: Unable to sign up. Please try again later.";
        // Log detailed error message (optional)
        error_log("Database error: " . mysqli_error($conn));
    }

    // Close database connection
    mysqli_close($conn);
}
?>
