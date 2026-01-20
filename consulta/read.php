<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../db.php';

$id_med = $_GET['med'] ?? null;
$id_pac = $_GET['pac'] ?? null;
$dt = $_GET['dt'] ?? null;
if (!$id_med || !$id_pac || !$dt) { header('Location: index.php'); exit; }

$dt = urldecode($dt);

$stmt = $pdo->prepare('
    SELECT c.*, m.nome AS medico_nome, p.nome AS paciente_nome
    FROM consulta c
    JOIN medico m ON c.id_medico = m.id
    JOIN paciente p ON c.id_paciente = p.id
    WHERE c.id_medico = ? AND c.id_paciente = ? AND c.data_hora = ?
');
$stmt->execute([$id_med, $id_pac, $dt]);
$c = $stmt->fetch();
if (!$c) { echo "Consulta não encontrada"; exit; }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="utf-8"><title>Detalhes Consulta</title></head>
<body>
    <h1>Detalhes da Consulta</h1>
    <a href="index.php">Voltar</a>
    <p><strong>Médico:</strong> <?= htmlspecialchars($c['medico_nome']) ?></p>
    <p><strong>Paciente:</strong> <?= htmlspecialchars($c['paciente_nome']) ?></p>
    <p><strong>Data / Hora:</strong> <?= htmlspecialchars($c['data_hora']) ?></p>
    <p><strong>Observações:</strong><br><?= nl2br(htmlspecialchars($c['observacoes'])) ?></p>
</body>
</html>
