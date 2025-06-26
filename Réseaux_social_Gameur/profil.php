<?php
require_once 'config.php'; // Assurez-vous que config est inclus

// Vérification de la session
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}

// ... le reste du code de la page (ex: $pageTitle = "...")
?>

<?php
$pageTitle = "Profil - Gamer's Hub";
require_once 'templates/header.php';
require_once 'templates/sidebar.php';
?>

<style>
    .profile-header {
        background-color: var(--card-background);
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }
    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background-color: var(--primary-color);
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 3rem;
        font-weight: bold;
        color: white;
    }
    .profile-info h1 {
        margin: 0;
        color: var(--primary-color);
    }
</style>

<section class="feed" id="profile-feed">
    <div id="profile-header-container"></div>
    
    <h2>Publications</h2>
    <div id="posts-container" class="posts-container">
        <div class="loading-spinner">
            <i class="fas fa-spinner fa-spin"></i> Chargement du profil...
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const headerContainer = document.getElementById('profile-header-container');
    const postsContainer = document.getElementById('posts-container');
    
    // Fonction pour créer une carte de publication (similaire à script.js)
    function createPostCard(post) {
        const postCard = document.createElement('div');
        postCard.classList.add('post-card');
        postCard.innerHTML = `
            <div class="post-header">
                <div class="avatar">${post.avatar}</div>
                <div class="post-info">
                    <span class="username">${post.nom_utilisateur}</span>
                    <span class="timestamp">${new Date(post.timestamp).toLocaleDateString()}</span>
                </div>
            </div>
            <div class="post-content"><p>${post.contenu}</p></div>
            <div class="post-actions"><button><i class="fas fa-heart"></i> J'aime (${post.likes})</button></div>
        `;
        return postCard;
    }

    async function loadProfile() {
        const urlParams = new URLSearchParams(window.location.search);
        const userId = urlParams.get('id') || 1; // Par défaut, profil de l'utilisateur 1

        try {
            const response = await fetch(`api/get_user_data.php?id=${userId}`);
            const data = await response.json();

            if (data.error) throw new Error(data.error);

            // Afficher les infos du profil
            const { user_info, user_posts } = data;
            const joinDate = new Date(user_info.date_inscription).toLocaleDateString();
            headerContainer.innerHTML = `
                <div class="profile-header">
                    <div class="profile-avatar">${user_info.avatar}</div>
                    <div class="profile-info">
                        <h1>${user_info.nom_utilisateur}</h1>
                        <p>Membre depuis le ${joinDate}</p>
                    </div>
                </div>
            `;
            
            // Afficher les posts
            postsContainer.innerHTML = ''; // Vider le spinner
            if (user_posts.length > 0) {
                user_posts.forEach(post => {
                    postsContainer.appendChild(createPostCard(post));
                });
            } else {
                postsContainer.innerHTML = '<p>Cet utilisateur n\'a encore rien publié.</p>';
            }

        } catch (error) {
            postsContainer.innerHTML = `<p style="color:red;">Erreur: ${error.message}</p>`;
        }
    }

    loadProfile();
});
</script>

<?php
require_once 'templates/footer.php';
?>