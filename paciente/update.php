<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../db.php';

$id = $_GET['id'] ?? null;
if (!$id) { header('Location: index.php'); exit; }

$stmt = $pdo->prepare('SELECT * FROM paciente WHERE id = ?');
$stmt->execute([$id]);
$p = $stmt->fetch();
if (!$p) { echo "Paciente não encontrado"; exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $data_nascimento = $_POST['data_nascimento'] ?? '';
    $tipo_sanguineo = $_POST['tipo_sanguineo'] ?? '';
    $imagem_perfil = $p['imagem_perfil']; // valor atual

    // Processa upload da nova imagem, se houver
    if (isset($_FILES['imagem_perfil']) && $_FILES['imagem_perfil']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $ext = pathinfo($_FILES['imagem_perfil']['name'], PATHINFO_EXTENSION);
        $nomeArquivo = uniqid('paciente_', true) . '.' . $ext;
        $caminhoCompleto = $uploadDir . $nomeArquivo;
        if (move_uploaded_file($_FILES['imagem_perfil']['tmp_name'], $caminhoCompleto)) {
            $imagem_perfil = 'uploads/' . $nomeArquivo;
        }
    }

    $u = $pdo->prepare('UPDATE paciente SET nome = ?, data_nascimento = ?, tipo_sanguineo = ?, imagem_perfil = ? WHERE id = ?');
    $u->execute([$nome, $data_nascimento, $tipo_sanguineo, $imagem_perfil, $id]);
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="utf-8"><title>Editar Paciente</title></head>
<body>
    <h1>Editar Paciente</h1>
    <a href="index.php">Voltar</a>
    <form method="post" enctype="multipart/form-data">
        <label>Nome:<br><input type="text" name="nome" value="<?= htmlspecialchars($p['nome']) ?>" required></label><br>
        <label>Data de Nascimento:<br><input type="date" name="data_nascimento" value="<?= htmlspecialchars($p['data_nascimento']) ?>" required></label><br>
        <label>Tipo Sanguíneo:<br><input type="text" name="tipo_sanguineo" maxlength="3" value="<?= htmlspecialchars($p['tipo_sanguineo']) ?>" required></label><br>
        <label for="imagem_perfil">Foto de Perfil:<br><input type="file" name="imagem_perfil" id="imagem_perfil" accept="image/*"></label><br>
        <?php if (!empty($p['imagem_perfil'])): ?>
            <div style="margin:10px 0;">
                <img src="../<?= htmlspecialchars($p['imagem_perfil']) ?>" alt="Foto atual" style="width:100px;height:100px;border-radius:50%;object-fit:cover;border:2px solid #ccc;">
            </div>
        <?php endif; ?>
        <button type="submit">Atualizar</button>
    </form>
    
</body>
</html>
