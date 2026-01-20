<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../db.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare('DELETE FROM medico WHERE id = ?');
    $stmt->execute([$id]);
}
header('Location: index.php');
exit;
