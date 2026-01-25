<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Busca todas as consultas com JOIN nas tabelas médico e paciente
$stmt = $pdo->query('
    SELECT c.data_hora, c.observacoes,
           m.nome AS medico_nome, 
           p.nome AS paciente_nome
    FROM consulta c
    JOIN medico m ON c.id_medico = m.id
    JOIN paciente p ON c.id_paciente = p.id
    ORDER BY c.data_hora DESC
');
$consultas = $stmt->fetchAll();

// HTML para o relatório
$html = '
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Consultas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
            border-bottom: 2px solid #0066cc;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #0066cc;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .total {
            margin-top: 20px;
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>
<body>
    <h1>Relatório de Consultas da Clínica Médica</h1>
    
    <table>
        <thead>
            <tr>
                <th>Paciente</th>
                <th>Médico</th>
            </tr>
        </thead>
        <tbody>';

if (count($consultas) > 0) {
    foreach ($consultas as $consulta) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($consulta['paciente_nome']) . '</td>';
        $html .= '<td>' . htmlspecialchars($consulta['medico_nome']) . '</td>';
        $html .= '</tr>';
    }
} else {
    $html .= '<tr><td colspan="2" style="text-align: center;">Nenhuma consulta registrada.</td></tr>';
}

$html .= '
        </tbody>
    </table>
    
    <div class="total">
        Total de consultas: ' . count($consultas) . '
    </div>
</body>
</html>';

// Configurar o DomPDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

// Carregar o HTML
$dompdf->loadHtml($html);

// Definir o tamanho e orientação do papel
$dompdf->setPaper('A4', 'portrait');

// Renderizar o PDF
$dompdf->render();

// Enviar o PDF para o navegador
$dompdf->stream('relatorio_consultas.pdf', [
    'Attachment' => false  // false = exibe no navegador, true = força download
]);
