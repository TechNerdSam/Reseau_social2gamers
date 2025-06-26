<?php
require_once 'config.php';
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
$pageTitle = "Connexion - Gamer's Hub";
require_once 'templates/header_auth.php';
?>

<div class="auth-container">
    <div class="auth-card">
        <h1>Connexion</h1>
        <form action="api/handle_connexion.php" method="POST">
             <?php if(isset($_GET['error'])) { echo '<p class="error-message">' . htmlspecialchars($_GET['error']) . '</p>'; } ?>
             <?php if(isset($_GET['success'])) { echo '<p class="success-message">' . htmlspecialchars($_GET['success']) . '</p>'; } ?>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn primary-btn full-width">Se connecter</button>
        </form>
        <p class="auth-switch">Pas encore de compte ? <a href="inscription.php">Inscrivez-vous</a></p>
    </div>
</div>

<?php require_once 'templates/footer_auth.php'; ?>