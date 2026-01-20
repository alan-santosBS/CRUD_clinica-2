<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $especialidade = $_POST['especialidade'] ?? '';

    $stmt = $pdo->prepare('INSERT INTO medico (nome, especialidade) VALUES (?, ?)');
    $stmt->execute([$nome, $especialidade]);

    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="utf-8"><title>Adicionar Médico</title></head>
<body>
    <h1>Adicionar Médico</h1>
    <a href="index.php">Voltar</a>
    <form method="post" enctype="multipart/form-data">
        <label>Nome:<br><input type="text" name="nome" required></label><br>
        <label>Especialidade:<br><input type="text" name="especialidade" required></label><br>
        <label for="imagem_perfil">Foto de Perfil:<br><input type="file" name="imagem_perfil" id="imagem_perfil" accept="image/*"></label><br>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>
