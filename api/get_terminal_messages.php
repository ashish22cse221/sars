<?php
header('Content-Type: application/json');
require_once '../config/database.php';

try {
    $stmt = $pdo->query("SELECT * FROM terminal_messages WHERE is_active = 1 ORDER BY created_at ASC");
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($messages);
} catch(PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
