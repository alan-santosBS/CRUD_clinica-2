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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $especialidade = $_POST['especialidade'] ?? '';
    $imagem_perfil = $medico['imagem_perfil']; // valor atual

    // Processa upload da nova imagem, se houver
    if (isset($_FILES['imagem_perfil']) && $_FILES['imagem_perfil']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $ext = pathinfo($_FILES['imagem_perfil']['name'], PATHINFO_EXTENSION);
        $nomeArquivo = uniqid('medico_', true) . '.' . $ext;
        $caminhoCompleto = $uploadDir . $nomeArquivo;
        if (move_uploaded_file($_FILES['imagem_perfil']['tmp_name'], $caminhoCompleto)) {
            $imagem_perfil = 'uploads/' . $nomeArquivo;
        }
    }
    $u = $pdo->prepare('UPDATE medico SET nome = ?, especialidade = ?, imagem_perfil = ? WHERE id = ?');
    $u->execute([$nome, $especialidade, $imagem_perfil, $id]);
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="utf-8"><title>Editar Médico</title></head>
<body>
    <h1>Editar Médico</h1>
    <a href="index.php">Voltar</a>
    <form method="post" enctype="multipart/form-data">
        <label>Nome:<br><input type="text" name="nome" value="<?= htmlspecialchars($medico['nome']) ?>" required></label><br>
        <label>Especialidade:<br><input type="text" name="especialidade" value="<?= htmlspecialchars($medico['especialidade']) ?>" required></label><br>
        <label for="imagem_perfil">Foto de Perfil:<br><input type="file" name="imagem_perfil" id="imagem_perfil" accept="image/*"></label><br>
        <?php if (!empty($medico['imagem_perfil'])): ?>
            <div style="margin:10px 0;">
                <img src="../<?= htmlspecialchars($medico['imagem_perfil']) ?>" alt="Foto atual" style="width:100px;height:100px;border-radius:50%;object-fit:cover;border:2px solid #ccc;">
            </div>
        <?php endif; ?>
        <button type="submit">Atualizar</button>
    </form>
</body>
</html>
