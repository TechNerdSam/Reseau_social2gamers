<?php
// api/get_notifications.php
require_once '../config.php';
$userId = 1; // L'utilisateur "connecté"

try {
    $sql = "SELECT n.*, u.nom_utilisateur as sender_name 
            FROM notifications n
            JOIN utilisateurs u ON n.sender_id = u.id
            WHERE n.recipient_id = ? 
            ORDER BY n.timestamp DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId]);
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($notifications);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>