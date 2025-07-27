<?php
header('Content-Type: application/json');
require_once '../config/database.php';

$featured_only = isset($_GET['featured']) && $_GET['featured'] == 'true';

try {
    if ($featured_only) {
        $stmt = $pdo->query("SELECT * FROM projects WHERE is_featured = 1 ORDER BY created_at DESC LIMIT 3");
    } else {
        $stmt = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC");
    }
    
    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($projects);
} catch(PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
