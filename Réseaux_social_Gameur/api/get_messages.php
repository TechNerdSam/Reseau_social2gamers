<?php
// api/get_messages.php
require_once '../config.php';
$userId = 1; // Utilisateur "connecté"

try {
    $sql = "SELECT DISTINCT c.id, c.timestamp, 
            IF(c.user1_id = ?, u2.nom_utilisateur, u1.nom_utilisateur) as contact_name
            FROM conversations c
            JOIN utilisateurs u1 ON c.user1_id = u1.id
            JOIN utilisateurs u2 ON c.user2_id = u2.id
            WHERE c.user1_id = ? OR c.user2_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId, $userId, $userId]);
    $conversations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($conversations);
} catch(Exception $e) {
    // Gérer l'erreur
}
?>