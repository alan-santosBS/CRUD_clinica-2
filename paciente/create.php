<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $data_nascimento = $_POST['data_nascimento'] ?? '';
    $tipo_sanguineo = $_POST['tipo_sanguineo'] ?? '';
    $imagem_perfil = null;

    // Processa upload da imagem, se houver
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

    $stmt = $pdo->prepare('INSERT INTO paciente (nome, data_nascimento, tipo_sanguineo, imagem_perfil) VALUES (?, ?, ?, ?)');
    $stmt->execute([$nome, $data_nascimento, $tipo_sanguineo, $imagem_perfil]);
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="utf-8"><title>Adicionar Paciente</title></head>
<body>
    <h1>Adicionar Paciente</h1>
    <a href="index.php">Voltar</a>
    <form method="post" enctype="multipart/form-data">
        <label>Nome:<br><input type="text" name="nome" required></label><br>
        <label>Data de Nascimento:<br><input type="date" name="data_nascimento" required></label><br>
        <label>Tipo Sanguíneo:<br><input type="text" name="tipo_sanguineo" maxlength="3" required></label><br>
        <label for="imagem_perfil">Foto de Perfil:<br><input type="file" name="imagem_perfil" id="imagem_perfil" accept="image/*"></label><br>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>
