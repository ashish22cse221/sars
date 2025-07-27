<?php
header('Content-Type: application/json');
require_once '../config/database.php';

try {
    $stmt = $pdo->query("SELECT * FROM about_us WHERE id = 1");
    $about = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo json_encode($about);
} catch(PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
