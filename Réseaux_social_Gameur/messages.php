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
$pageTitle = "Messages - Gamer's Hub";
require_once 'templates/header.php';
require_once 'templates/sidebar.php';
?>

<style>
.messages-layout {
    display: flex;
    gap: 1.5rem;
}
.conversations-list {
    flex: 1;
    background: var(--card-background);
    padding: 1rem;
    border-radius: 8px;
    height: 70vh;
    overflow-y: auto;
}
.conversation-item {
    padding: 0.8rem;
    border-bottom: 1px solid var(--border-color);
    cursor: pointer;
}
.conversation-item:hover {
    background: var(--background-color);
}
.messages-view {
    flex: 3;
}
</style>

<section class="messages-layout">
    <div class="conversations-list" id="conversations-container">
        </div>
    <div class="messages-view post-card">
        <h1>Messagerie</h1>
        <p>Sélectionnez une conversation pour afficher les messages.</p>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', async () => {
    const container = document.getElementById('conversations-container');
    container.innerHTML = '<p>Chargement...</p>';
    
    try {
        const response = await fetch('api/get_messages.php');
        const conversations = await response.json();
        container.innerHTML = '';

        if(conversations.length > 0) {
            conversations.forEach(convo => {
                container.innerHTML += `<div class="conversation-item">${convo.contact_name}</div>`;
            });
        } else {
            container.innerHTML = '<p>Aucune conversation.</p>';
        }

    } catch(error) {
        container.innerHTML = '<p style="color:red">Erreur</p>';
    }
});
</script>

<?php
require_once 'templates/footer.php';
?>