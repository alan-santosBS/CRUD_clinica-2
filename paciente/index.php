<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../db.php';

$stmt = $pdo->query('SELECT * FROM paciente ORDER BY id');
$pacientes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="utf-8"><title>Pacientes</title></head>
<body>
    <h1>Pacientes</h1>
    <a href="../index.php">Voltar</a> |
    <a href="create.php">Adicionar Paciente</a>
    <table border="1" cellpadding="6" cellspacing="0">
        <thead>
            <tr><th>ID</th><th>Nome</th><th>Data Nasc.</th><th>Tipo Sanguíneo</th><th>Ações</th></tr>
        </thead>
        <tbody>
            <?php foreach ($pacientes as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['id']) ?></td>
                    <td><?= htmlspecialchars($p['nome']) ?></td>
                    <td><?= htmlspecialchars($p['data_nascimento']) ?></td>
                    <td><?= htmlspecialchars($p['tipo_sanguineo']) ?></td>
                    <td>
                        <a href="read.php?id=<?= $p['id'] ?>">Ver</a> |
                        <a href="update.php?id=<?= $p['id'] ?>">Editar</a> |
                        <a href="delete.php?id=<?= $p['id'] ?>" onclick="return confirm('Deletar?')">Deletar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
