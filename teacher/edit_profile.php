<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["email"])) {
  // Redirect to the login page if not logged in
  header("Location: index.html");
  exit();
}

// Include database connection
include_once "connection.php";

// Fetch current user information
$email = $_SESSION["email"];
$query = "SELECT id, firstname, lastname, email FROM teachers WHERE email = '$email'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $id = $row['id'];
  $firstname = $row['firstname'];
  $lastname = $row['lastname'];
  $email = $row['email'];
} else {
  echo "Error fetching user information.";
}

// Update user information if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $newFirstname = $_POST['firstname'];
  $newLastname = $_POST['lastname'];
  $newEmail = $_POST['email'];
  $newPassword = $_POST['password'];

  // Validate and update the database
  // Note: You should add proper validation and hashing for the password
  $hashed_password = md5($newPassword);
  $updateQuery = "UPDATE teachers SET firstname = '$newFirstname', lastname = '$newLastname', email = '$newEmail', password = '$hashed_password' WHERE id = '$id'";
  $updateResult = mysqli_query($conn, $updateQuery);

  if ($updateResult) {
    header("Location: profile.php");
    // Update session email if email is changed
    $_SESSION["email"] = $newEmail;
  } else {
    echo "Error updating profile.";
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
  <title>Edit Profile</title>
</head>
<body>
  <div class="container">
    <h2>Edit Profile</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <label for="firstname">First Name:</label>
      <input type="text" id="firstname" name="firstname" value="<?php echo $firstname; ?>" required><br>

      <label for="lastname">Last Name:</label>
      <input type="text" id="lastname" name="lastname" value="<?php echo $lastname; ?>" required><br>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" value="<?php echo $email; ?>" required><br>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required><br>

      <input type="submit" value="Update Profile">
    </form>
  </div>
</body>
</html>
