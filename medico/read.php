<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM medico WHERE id = ?');
$stmt->execute([$id]);
$medico = $stmt->fetch();
if (!$medico) {
    echo "Médico não encontrado";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="utf-8"><title>Detalhes Médico</title></head>
<body>
    <h1>Detalhes do Médico</h1>
    <a href="index.php">Voltar</a>
    <?php
    $img = !empty($medico['imagem_perfil']) ? '../' . htmlspecialchars($medico['imagem_perfil']) : 'https://www.gravatar.com/avatar/?d=mp&f=y';
    ?>
    <div style="margin:20px 0;">
        <img src="<?= $img ?>" alt="Foto de Perfil" style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:2px solid #ccc;">
    </div>
    <p><strong>ID:</strong> <?= htmlspecialchars($medico['id']) ?></p>
    <p><strong>Nome:</strong> <?= htmlspecialchars($medico['nome']) ?></p>
    <p><strong>Especialidade:</strong> <?= htmlspecialchars($medico['especialidade']) ?></p>
</body>
</html>
