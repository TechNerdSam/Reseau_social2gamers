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
$pageTitle = "Notifications - Gamer's Hub";
require_once 'templates/header.php';
require_once 'templates/sidebar.php';
?>

<style>
.notification-item {
    background: var(--card-background);
    padding: 1rem 1.5rem;
    border-radius: 8px;
    margin-bottom: 1rem;
    border-left: 4px solid var(--primary-color);
}
.notification-item p { margin: 0; }
</style>

<section class="feed">
    <div class="post-card">
        <h1>Notifications</h1>
        <div id="notifications-container">
            </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', async () => {
    const container = document.getElementById('notifications-container');
    container.innerHTML = '<p>Chargement...</p>';

    try {
        const response = await fetch('api/get_notifications.php');
        const notifications = await response.json();
        container.innerHTML = '';

        if (notifications.length > 0) {
            notifications.forEach(notif => {
                let message = '';
                switch (notif.type) {
                    case 'like':
                        message = `<b>${notif.sender_name}</b> a aimé votre publication.`;
                        break;
                    case 'comment':
                        message = `<b>${notif.sender_name}</b> a commenté votre publication.`;
                        break;
                    default:
                        message = 'Nouvelle notification.';
                }
                container.innerHTML += `<div class="notification-item"><p>${message}</p></div>`;
            });
        } else {
            container.innerHTML = '<p>Vous n\'avez aucune nouvelle notification.</p>';
        }
    } catch (error) {
        container.innerHTML = '<p style="color:red;">Impossible de charger les notifications.</p>';
    }
});
</script>

<?php
require_once 'templates/footer.php';
?>