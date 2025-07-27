<?php
header('Content-Type: application/json');
require_once '../config/database.php';

try {
    $stmt = $pdo->query("SELECT * FROM team_members ORDER BY display_order ASC");
    $team = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($team);
} catch(PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
