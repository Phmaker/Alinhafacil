<?php
include 'conexao.php';

header('Content-Type: application/json');

// Total de clientes
$resultClientes = $conn->query("SELECT COUNT(*) AS total FROM clientes");
$totalClientes = $resultClientes->fetch_assoc()['total'];

// Alinhamentos de hoje
$hoje = date('Y-m-d');
$resultAlinhamentos = $conn->query("SELECT COUNT(*) AS total FROM servicos WHERE tipo_servico LIKE '%alinhamento%' AND data_servico = '$hoje'");
$alinhamentosHoje = $resultAlinhamentos->fetch_assoc()['total'];

// Último carro atendido
$resultUltimo = $conn->query("SELECT * FROM servicos ORDER BY data_servico DESC, id DESC LIMIT 1");
$ultimo = $resultUltimo->fetch_assoc();

echo json_encode([
  'totalClientes' => $totalClientes,
  'alinhamentosHoje' => $alinhamentosHoje,
  'ultimoCarro' => $ultimo
]);
?>
