<?php
require_once '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($email) || empty($password)) {
        header("Location: ../inscription.php?error=Tous les champs sont requis");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $avatar = strtoupper(substr($username, 0, 2));

    try {
        $sql = "INSERT INTO utilisateurs (nom_utilisateur, email, mot_de_passe, avatar) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $email, $hashed_password, $avatar]);
        header("Location: ../connexion.php?success=Inscription réussie ! Vous pouvez vous connecter.");
        exit();
    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) {
            header("Location: ../inscription.php?error=Cet email ou nom d'utilisateur est déjà pris.");
        } else {
            header("Location: ../inscription.php?error=Une erreur est survenue.");
        }
        exit();
    }
}
?>