<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../db.php';

$stmt = $pdo->query('
    SELECT c.id_medico, c.id_paciente, c.data_hora, c.observacoes,
           m.nome AS medico_nome, p.nome AS paciente_nome
    FROM consulta c
    JOIN medico m ON c.id_medico = m.id
    JOIN paciente p ON c.id_paciente = p.id
    ORDER BY c.data_hora DESC
');
$consultas = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="utf-8"><title>Consultas</title></head>
<body>
    <h1>Consultas</h1>
    <a href="../index.php">Voltar</a> |
    <a href="create.php">Registrar Consulta</a>
    <table border="1" cellpadding="6">
        <thead><tr><th>Médico</th><th>Paciente</th><th>Data / Hora</th><th>Observações</th><th>Ações</th></tr></thead>
        <tbody>
            <?php foreach ($consultas as $c): ?>
                <tr>
                    <td><?= htmlspecialchars($c['medico_nome']) ?></td>
                    <td><?= htmlspecialchars($c['paciente_nome']) ?></td>
                    <td><?= htmlspecialchars($c['data_hora']) ?></td>
                    <td><?= nl2br(htmlspecialchars($c['observacoes'])) ?></td>
                    <td>
                        <a href="read.php?med=<?= $c['id_medico'] ?>&pac=<?= $c['id_paciente'] ?>&dt=<?= urlencode($c['data_hora']) ?>">Ver</a> |
                        <a href="update.php?med=<?= $c['id_medico'] ?>&pac=<?= $c['id_paciente'] ?>&dt=<?= urlencode($c['data_hora']) ?>">Editar</a> |
                        <a href="delete.php?med=<?= $c['id_medico'] ?>&pac=<?= $c['id_paciente'] ?>&dt=<?= urlencode($c['data_hora']) ?>" onclick="return confirm('Deletar consulta?')">Deletar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
