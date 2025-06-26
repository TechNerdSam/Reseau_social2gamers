<?php
require_once 'config.php';

// Vérification de la session
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}

$pageTitle = "Accueil - Gamer's Hub";
require_once 'templates/header.php';
require_once 'templates/sidebar.php';
?>

<section class="feed">
    <div class="post-creator-card">
        <div class="post-creator-header">
            <div class="user-avatar"><?php echo strtoupper(substr($_SESSION['username'], 0, 2)); ?></div>
            <textarea id="post-text" placeholder="Partage ton dernier exploit, une astuce, ou une question à la communauté !"></textarea>
        </div>
        <div class="post-creator-actions">
            <label for="post-media" class="btn media-btn">
                <i class="fas fa-camera"></i> Ajouter Média
                <input type="file" id="post-media" accept="image/*,video/*" class="hidden-input">
            </label>
            <button id="publish-post" class="btn primary-btn">Publier <i class="fas fa-paper-plane"></i></button>
        </div>
    </div>

    <div id="posts-container" class="posts-container">
        <div class="loading-spinner">
            <i class="fas fa-spinner fa-spin"></i> Chargement des posts...
        </div>
    </div>
</section>

<?php
require_once 'templates/footer.php';
?>