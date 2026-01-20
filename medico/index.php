<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../db.php';

$stmt = $pdo->query('SELECT * FROM medico ORDER BY id');
$medicos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="utf-8"><title>Médicos</title></head>
<body>
    <h1>Médicos</h1>
    <a href="../index.php">Voltar</a> |
    <a href="create.php">Adicionar Médico</a>
    <table border="1" cellpadding="6" cellspacing="0">
        <thead>
            <tr><th>ID</th><th>Nome</th><th>Especialidade</th><th>Ações</th></tr>
        </thead>
        <tbody>
            <?php foreach ($medicos as $m): ?>
                <tr>
                    <td><?= htmlspecialchars($m['id']) ?></td>
                    <td><?= htmlspecialchars($m['nome']) ?></td>
                    <td><?= htmlspecialchars($m['especialidade']) ?></td>
                    <td>
                        <a href="read.php?id=<?= $m['id'] ?>">Ver</a> |
                        <a href="update.php?id=<?= $m['id'] ?>">Editar</a> |
                        <a href="delete.php?id=<?= $m['id'] ?>" onclick="return confirm('Deletar?')">Deletar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
