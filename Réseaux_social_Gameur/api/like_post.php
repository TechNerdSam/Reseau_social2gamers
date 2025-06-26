<?php
// api/like_post.php
require_once '../config.php';

$userId = 1; // Utilisateur qui aime (devrait venir d'une session)
$postId = isset($_POST['post_id']) ? (int)$_POST['post_id'] : 0;

if ($postId === 0) exit;

try {
    // Vérifier si le like existe déjà
    $stmtCheck = $pdo->prepare("SELECT * FROM likes WHERE id_publication = ? AND id_utilisateur = ?");
    $stmtCheck->execute([$postId, $userId]);
    
    if ($stmtCheck->fetch()) {
        // L'utilisateur a déjà aimé, on retire le like
        $stmtDelete = $pdo->prepare("DELETE FROM likes WHERE id_publication = ? AND id_utilisateur = ?");
        $stmtDelete->execute([$postId, $userId]);
    } else {
        // Ajouter le like
        $stmtInsert = $pdo->prepare("INSERT INTO likes (id_publication, id_utilisateur) VALUES (?, ?)");
        $stmtInsert->execute([$postId, $userId]);

        // Créer une notification pour l'auteur du post
        // 1. Trouver l'auteur du post
        $stmtAuthor = $pdo->prepare("SELECT id_utilisateur FROM publications WHERE id = ?");
        $stmtAuthor->execute([$postId]);
        $author = $stmtAuthor->fetch();

        // 2. Insérer la notification (sauf si on aime son propre post)
        if ($author && $author['id_utilisateur'] != $userId) {
            $stmtNotif = $pdo->prepare("INSERT INTO notifications (recipient_id, sender_id, post_id, type) VALUES (?, ?, ?, 'like')");
            $stmtNotif->execute([$author['id_utilisateur'], $userId, $postId]);
        }
    }
    
    // Renvoyer le nouveau nombre de likes
    $stmtCount = $pdo->prepare("SELECT COUNT(*) as like_count FROM likes WHERE id_publication = ?");
    $stmtCount->execute([$postId]);
    echo json_encode($stmtCount->fetch(PDO::FETCH_ASSOC));

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>