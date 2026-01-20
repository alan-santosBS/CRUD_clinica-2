<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../db.php';

$id_med = $_GET['med'] ?? null;
$id_pac = $_GET['pac'] ?? null;
$dt = $_GET['dt'] ?? null;
if ($id_med && $id_pac && $dt) {
    $dt = urldecode($dt);
    $d = $pdo->prepare('DELETE FROM consulta WHERE id_medico = ? AND id_paciente = ? AND data_hora = ?');
    $d->execute([$id_med, $id_pac, $dt]);
}
header('Location: index.php');
exit;
