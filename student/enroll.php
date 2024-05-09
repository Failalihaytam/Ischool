<?php
session_start();

// Vérifie si l'utilisateur est connecté en tant qu'étudiant
if (!isset($_SESSION['student_id'])) {
    header("Location: classes.php"); // Redirige vers la page des classes si non connecté
    exit();
}

// Inclut la connexion à la base de données
include_once "connection.php";

// Vérifie si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['class_id'])) {
    $class_id = $_POST['class_id'];
    $student_id = $_SESSION['student_id'];
    // Vérifie si l'étudiant est déjà inscrit dans la classe
    $check_sql = "SELECT * FROM enrollment WHERE student_id = '$student_id' AND class_id = '$class_id'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        echo "Vous êtes déjà inscrit dans cette classe.";
    } else {
        // Inscrit l'étudiant dans la classe
        $enroll_sql = "INSERT INTO enrollment (student_id, class_id) VALUES ('$student_id', '$class_id')";
        if (mysqli_query($conn, $enroll_sql)) {
            echo "Inscription réussie !";
            header("Location: welcome.php");
        } else {
            echo "Erreur : " . $enroll_sql . "<br>" . mysqli_error($conn);
        }
    }
}

// Ferme la connexion à la base de données
mysqli_close($conn);
?>
