<?php
require_once 'config.php';
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
$pageTitle = "Inscription - Gamer's Hub";
require_once 'templates/header_auth.php';
?>

<div class="auth-container">
    <div class="auth-card">
        <h1>Créer un compte</h1>
        <form action="api/handle_inscription.php" method="POST">
            <?php if(isset($_GET['error'])) { echo '<p class="error-message">' . htmlspecialchars($_GET['error']) . '</p>'; } ?>
            
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn primary-btn full-width">S'inscrire</button>
        </form>
        <p class="auth-switch">Déjà un compte ? <a href="connexion.php">Connectez-vous</a></p>
    </div>
</div>

<?php require_once 'templates/footer_auth.php'; ?>