<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../db.php';

// buscar médicos e pacientes para os selects
$medicos = $pdo->query('SELECT id, nome FROM medico ORDER BY nome')->fetchAll();
$pacientes = $pdo->query('SELECT id, nome FROM paciente ORDER BY nome')->fetchAll();

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_medico = $_POST['id_medico'] ?? null;
    $id_paciente = $_POST['id_paciente'] ?? null;
    $data_hora = $_POST['data_hora'] ?? null; // espera 'YYYY-MM-DDTHH:MM' (input datetime-local)
    $observacoes = $_POST['observacoes'] ?? '';

    // converter input datetime-local para formato MySQL
    // input example: 2025-12-15T09:00
    if ($data_hora) {
        $data_hora = str_replace('T', ' ', $data_hora) . ':00'; // adiciona segundos
    }

    if ($id_medico && $id_paciente && $data_hora) {
        // checar se já existe (PK composta)
        $check = $pdo->prepare('SELECT COUNT(*) FROM consulta WHERE id_medico = ? AND id_paciente = ? AND data_hora = ?');
        $check->execute([$id_medico, $id_paciente, $data_hora]);
        if ($check->fetchColumn() > 0) {
            $erro = 'Já existe uma consulta para esse médico/paciente nessa data/hora.';
        } else {
            $ins = $pdo->prepare('INSERT INTO consulta (id_medico, id_paciente, data_hora, observacoes) VALUES (?, ?, ?, ?)');
            $ins->execute([$id_medico, $id_paciente, $data_hora, $observacoes]);
            header('Location: index.php');
            exit;
        }
    } else {
        $erro = 'Preencha todos os campos.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="utf-8"><title>Registrar Consulta</title></head>
<body>
    <h1>Registrar Consulta</h1>
    <a href="index.php">Voltar</a>
    <?php if ($erro): ?><p style="color:red;"><?= htmlspecialchars($erro) ?></p><?php endif; ?>
    <form method="post">
        <label>Médico:<br>
            <select name="id_medico" required>
                <option value="">-- selecione --</option>
                <?php foreach ($medicos as $m): ?>
                    <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['nome']) ?></option>
                <?php endforeach; ?>
            </select>
        </label><br>

        <label>Paciente:<br>
            <select name="id_paciente" required>
                <option value="">-- selecione --</option>
                <?php foreach ($pacientes as $p): ?>
                    <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nome']) ?></option>
                <?php endforeach; ?>
            </select>
        </label><br>

        <label>Data e Hora:<br>
            <!-- input datetime-local: valor ex. "2025-12-15T09:00" -->
            <input type="datetime-local" name="data_hora" required>
        </label><br>

        <label>Observações:<br>
            <textarea name="observacoes" rows="4"></textarea>
        </label><br>

        <button type="submit">Registrar</button>
    </form>
</body>
</html>
