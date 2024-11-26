<?php
// Conectar ao banco de dados MySQL com PDO
include 'conexao.php';

// Query para obter nome, latitude e longitude
$sql = "SELECT nome, latitude, longitude FROM desfibrillators";
$stmt = $pdo->prepare($sql);
$stmt->execute();

// Obtém os resultados como um array associativo
$locations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retorna os dados em JSON
header('Content-Type: application/json');
echo json_encode($locations);

// Fecha a conexão (opcional, o PDO fecha automaticamente no final do script)
// $pdo = null;
?>
