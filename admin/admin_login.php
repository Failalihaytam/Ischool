<?php
session_start();

// Include database connection
include_once "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Check if the username and password match an admin record in the database
  $query = "SELECT id FROM admin WHERE username = '$username' AND password = '$password'";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    // Login successful, set session variables
    $_SESSION["username"] = $username;

    // Redirect to welcome.php
    header("Location: welcome.php");
    exit();
  } else {
    echo "<div class='message'>
      <span>Invalid username or password</span>
    </div>";
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
  <title>Admin Login</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
    body {
      font-family:"Roboto" , sans-serif;
      height: 100vh;
      width: 100%;
      background-image: radial-gradient(circle, #6db4ed 39%, #656bb8 82%);
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
    }

    .container {
      display: flex;
      flex-direction: column;
      align-items: center;
      width: 550px;
      background: #F8F9FD;
      background: linear-gradient(0deg, rgb(255, 255, 255) 0%, rgb(244, 247, 251) 100%);
      border-radius: 40px;
      padding: 25px 35px;
      border: 5px solid rgb(255, 255, 255);
      box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 30px 30px -20px;
    }

.heading {
  text-align: center;
  font-weight: 900;
  font-size: 40px;
  color: rgb(16, 137, 211);
  margin: 20px auto;
}

.form {
  display: flex;
  align-items: center;
  flex-direction: column;
  justify-content: center;
  margin: 20px auto;
  width: 100%;
}

.form input {
  width: 90%;
  background: white;
  border: none;
  padding: 15px 20px;
  border-radius: 20px;
  margin: 15px auto;
  box-shadow: #cff0ff 0px 10px 10px -5px;
  font-size: 17px;
  font-weight: 600;
}

.form .input::-moz-placeholder {
  color: rgb(170, 170, 170);
  font-size: 17px;
  font-weight: 600;
}

.form .input::placeholder {
  color: rgb(170, 170, 170);
  font-size: 17px;
  font-weight: 600;
}

.form .input:focus {
  outline: none;
  border-inline: 2px solid #12B1D1;
}


.form .login-button {
  display: block;
  width: 90%;
  font-weight: bold;
  background: linear-gradient(45deg, rgb(16, 137, 211) 0%, rgb(18, 177, 209) 100%);
  color: white;
  padding-block: 15px;
  margin: 20px auto;
  border-radius: 20px;
  box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 20px 10px -15px;
  border: none;
  transition: all 0.2s ease-in-out;
  cursor: pointer;
  font-size: 17px;
}

.form .login-button:hover {
  transform: scale(1.03);
  box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 23px 10px -20px;
}

.form .login-button:active {
  transform: scale(0.95);
  box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 15px 10px -10px;
}

.message {
  width: 500px;
  text-align: center;
  position: absolute;
  top: 20px;
  margin: auto;
  background: #E2A5A5;
  padding: 15px;
  border: 3px solid #A30A0A;
  border-radius: 10px;
}

.message span {
  font-size: 19px;
  font-weight: 500;
  color: #421818;
}

  </style>
</head>
<body>
  <div class="container">
      <div class="heading">Sign In</div>
      <form action="admin_login.php" class="form" method="post">
        <input class="input" type="text" name="username" id="email" placeholder="Username" required>
        <input class="input" type="password" name="password" id="password" placeholder="Password" required>
        <input class="login-button" type="submit" value="Sign In">
      </form>
    </div>
  </body>
</html>