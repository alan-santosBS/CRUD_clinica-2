<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../db.php';

$id_med = $_GET['med'] ?? null;
$id_pac = $_GET['pac'] ?? null;
$dt = $_GET['dt'] ?? null;
if (!$id_med || !$id_pac || !$dt) { header('Location: index.php'); exit; }
$dt = urldecode($dt);

$stmt = $pdo->prepare('SELECT * FROM consulta WHERE id_medico = ? AND id_paciente = ? AND data_hora = ?');
$stmt->execute([$id_med, $id_pac, $dt]);
$c = $stmt->fetch();
if (!$c) { echo "Consulta não encontrada"; exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $observacoes = $_POST['observacoes'] ?? '';
    $u = $pdo->prepare('UPDATE consulta SET observacoes = ? WHERE id_medico = ? AND id_paciente = ? AND data_hora = ?');
    $u->execute([$observacoes, $id_med, $id_pac, $dt]);
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="utf-8"><title>Editar Consulta</title></head>
<body>
    <h1>Editar Observações da Consulta</h1>
    <a href="index.php">Voltar</a>
    <form method="post">
        <p><strong>Médico:</strong> <?= htmlspecialchars($c['id_medico']) ?></p>
        <p><strong>Paciente:</strong> <?= htmlspecialchars($c['id_paciente']) ?></p>
        <p><strong>Data/Hora:</strong> <?= htmlspecialchars($c['data_hora']) ?></p>
        <label>Observações:<br>
            <textarea name="observacoes" rows="6"><?= htmlspecialchars($c['observacoes']) ?></textarea>
        </label><br>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>
