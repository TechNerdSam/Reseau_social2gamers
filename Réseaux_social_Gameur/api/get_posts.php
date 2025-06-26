<?php
// api/get_posts.php
require_once '../config.php';

header('Content-Type: application/json');

try {
    $sql = "SELECT p.id, p.contenu, p.media, p.timestamp, 
                   u.nom_utilisateur, u.avatar, 
                   (SELECT COUNT(*) FROM likes WHERE id_publication = p.id) as likes
            FROM publications p
            JOIN utilisateurs u ON p.id_utilisateur = u.id
            ORDER BY p.timestamp DESC";
            
    $stmt = $pdo->query($sql);
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($posts);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de base de données: ' . $e->getMessage()]);
}
?>