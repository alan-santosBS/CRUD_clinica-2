<?php
session_start();
require 'db.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $senha   = md5($_POST['senha']);

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ? AND senha = ?");
    $stmt->execute([$usuario, $senha]);

    if ($stmt->rowCount() === 1) {
        $_SESSION['usuario'] = $usuario;
        header('Location: index.php');
        exit;
    } else {
        $erro = "Usuário ou senha inválidos";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
<h2>Login</h2>

<?php if ($erro): ?>
<p style="color:red"><?= $erro ?></p>
<?php endif; ?>

<form method="POST">
    <label>Usuário:</label>
    <input type="text" name="usuario" required><br>

    <label>Senha:</label>
    <input type="password" name="senha" required><br>

    <button type="submit">Entrar</button>
</form>
</body>
</html>
