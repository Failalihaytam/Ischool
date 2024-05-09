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
  $query = "SELECT * FROM students WHERE email='$username_email' AND password='".md5($password)."'";
  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);

  if ($count == 1) {

    $row = mysqli_fetch_array($result);
    $student_id = $row['id'];
    // Set session variables
    $_SESSION["email"] = $username_email;
    $_SESSION["student_id"] = $student_id;

    // Redirect to welcome page after successful login
    header("Location: welcome.php");
    exit();
  } else {
    echo "<div class='message'>
      <span>Invalid username or password</span>
    </div>";
  }

  // Close database connection
  mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <style>
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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Error</title>
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="singup.php" method="post">
                <h1>Créer un compte</h1>
                <input type="text" placeholder="Prénom" name="firstname" required/>
                <input type="text" placeholder="Nom" name="lastname" required/>
                <input type="email" placeholder="Email" name="email" required />
                <input type="password" placeholder="Mot de passe" name="password" required/>
                <button>S'inscrire</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form action="login.php" method="post">
                <h1>Se connecter</h1>
                <input type="email" placeholder="Email" name="email" required/>
                <input type="password" placeholder="Mot de passe" name="password" required/>
                <button>Se connecter</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Bienvenue</h1>
                    <p>Entrez vos coordonnées personnelles pour utiliser toutes les fonctionnalités du site</p>
                    <button class="hidden" id="login">Se connecter</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Bonjour, ami !</h1>
                    <p>
                        Inscrivez-vous avec vos coordonnées personnelles pour utiliser toutes les fonctionnalités du site
                    </p>
                    <button class="hidden" id="register">S'inscrire</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="main.js"></script>

</html>
