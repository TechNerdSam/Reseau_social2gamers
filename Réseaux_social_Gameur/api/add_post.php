<?php
require_once '../config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Vous devez être connecté pour publier.']);
    exit;
}

$id_utilisateur = $_SESSION['user_id'];
$contenu = isset($_POST['content']) ? trim($_POST['content']) : '';
$media_path = null;

if (isset($_FILES['media']) && $_FILES['media']['error'] == 0) {
    $target_dir = "../uploads/";
    $file_name = time() . '_' . basename($_FILES["media"]["name"]);
    $target_file = $target_dir . $file_name;
    
    if (move_uploaded_file($_FILES["media"]["tmp_name"], $target_file)) {
        $media_path = "uploads/" . $file_name;
    }
}

if (empty($contenu) && $media_path === null) {
    http_response_code(400);
    echo json_encode(['error' => 'Le contenu ou le média est requis.']);
    exit;
}

try {
    $sql = "INSERT INTO publications (id_utilisateur, contenu, media) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_utilisateur, $contenu, $media_path]);
    echo json_encode(['success' => true, 'message' => 'Publication ajoutée !']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors de l\'ajout : ' . $e->getMessage()]);
}
?>