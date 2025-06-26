<?php
// api/get_user_data.php
require_once '../config.php';

header('Content-Type: application/json');

// On récupère l'ID de l'utilisateur depuis l'URL (?id=X)
$userId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
// Pour la démo, si aucun ID n'est fourni, on prend l'utilisateur 1 (l'utilisateur "connecté")
if ($userId === 0) {
    $userId = 1; 
}

$response = [];

try {
    // 1. Récupérer les informations de l'utilisateur
    $stmtUser = $pdo->prepare("SELECT id, nom_utilisateur, avatar, date_inscription FROM utilisateurs WHERE id = ?");
    $stmtUser->execute([$userId]);
    $response['user_info'] = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if (!$response['user_info']) {
        throw new Exception("Utilisateur non trouvé.");
    }

    // 2. Récupérer les publications de cet utilisateur
    $stmtPosts = $pdo->prepare("SELECT p.*, u.nom_utilisateur, u.avatar, (SELECT COUNT(*) FROM likes WHERE id_publication = p.id) as likes FROM publications p JOIN utilisateurs u ON p.id_utilisateur = u.id WHERE p.id_utilisateur = ? ORDER BY p.timestamp DESC");
    $stmtPosts->execute([$userId]);
    $response['user_posts'] = $stmtPosts->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($response);

} catch (Exception $e) {
    http_response_code(404);
    echo json_encode(['error' => $e->getMessage()]);
}
?>