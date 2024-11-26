<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Senha</title>
</head>
<body>
    <h2>Atualizar Senha</h2>
    <form action="atualizar_senha.php" method="POST">
        <label for="nome">Nome de Usuário:</label>
        <input type="text" id="nome" name="nome" required>
        <br><br>
        <label for="nova_senha">Nova Senha:</label>
        <input type="password" id="nova_senha" name="nova_senha" required>
        <br><br>
        <button type="submit">Atualizar Senha</button>
    </form>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'conexao.php'; // Arquivo para conexão ao banco de dados

    $nome = $_POST['nome'];
    $nova_senha = $_POST['nova_senha'];

    // Gerar o hash da nova senha
    $nova_senha_hash = password_hash($nova_senha, PASSWORD_BCRYPT);

    // Atualizar a senha no banco de dados
    $sql = "UPDATE users SET senha = ? WHERE nome = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$nova_senha_hash, $nome])) {
        echo "Senha atualizada com sucesso!";
    } else {
        echo "Erro ao atualizar a senha.";
    }
}
?>
