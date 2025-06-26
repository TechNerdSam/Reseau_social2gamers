<?php
require_once '../config.php';
// config.php démarre déjà la session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        header("Location: ../connexion.php?error=Email et mot de passe requis");
        exit();
    }

    try {
        $sql = "SELECT id, nom_utilisateur, mot_de_passe FROM utilisateurs WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['mot_de_passe'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['nom_utilisateur'];
            header("Location: ../index.php");
            exit();
        } else {
            header("Location: ../connexion.php?error=Email ou mot de passe incorrect.");
            exit();
        }
    } catch (PDOException $e) {
        header("Location: ../connexion.php?error=Erreur de base de données.");
        exit();
    }
}
?>