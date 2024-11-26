<?php
include 'conexao.php'; // Conecta ao banco de dados

// Dados do novo usuário
$login = 'usuario'; // Substitua pelo login desejado
$senha = '123321';  // Substitua pela senha desejada

// Hash da senha
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// Inserir no banco de dados
try {
    $sql = "INSERT INTO users (login, senha) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$login, $senha_hash]);
    echo "Usuário criado com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao criar usuário: " . $e->getMessage();
}
?>
