<?php

session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

// Conexão ao banco de dados (substitua pelos seus dados de conexão)
include 'conexao.php';

// Função para atualizar um registro
function alterarDesfibrilador($pdo, $id, $coluna, $novoValor) {
    $sql = "UPDATE desfibrillators SET $coluna = :valor WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([':valor' => $novoValor, ':id' => $id]);
}

// Verifica se o formulário foi enviado
$mensagem = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $coluna = filter_input(INPUT_POST, 'coluna', FILTER_SANITIZE_STRING);
    $novoValor = filter_input(INPUT_POST, 'novo_valor', FILTER_SANITIZE_STRING);

    if ($id !== false && $id !== null && !empty($coluna) && !empty($novoValor)) {
        if (alterarDesfibrilador($pdo, $id, $coluna, $novoValor)) {
            $mensagem = "Registro atualizado com sucesso!";
        } else {
            $mensagem = "Erro ao atualizar o registro.";
        }
    } else {
        $mensagem = "Dados inválidos. Verifique os campos preenchidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Registro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 2rem;
            background-color: #c3baba;
            color: #000000;
            line-height: 1.6;
        }
        header {
            background-color: #d31818;
            color: #fff;
            text-align: center;
            padding: 1rem 0;
        }
        nav {
            background-color: #d31818;
            text-align: center;
            padding: 0.5rem 0;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 1rem;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 1.5rem;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin: 0.5rem 0 0.2rem;
            font-weight: bold;
        }
        input, select, button {
            width: 100%;
            padding: 0.8rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #d31818;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }
        button:hover {
            background-color: #025aa5;
        }
        footer {
            text-align: center;
            background-color: #ddd;
            padding: 1rem 0;
            margin-top: 2rem;
            font-size: 0.9rem;
            color: #555;
        }

        footer a {
            color: #d31818;
            text-decoration: none;
            font-weight: bold;
        }

        footer a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>

    <header>
        <h1>Alterar registro na tabela de desfibriladores</h1>
    </header>

    <nav>
        <a href="index.php">Voltar à página inicial</a>
        <a href="logout.php">Encerrar Sessão</a>
    </nav>    

    <form method="post">
        <label for="id">Codigo/ ID do Registro:</label>
        <input type="number" id="id" name="id" required><br><br>

        <label for="coluna">Coluna a Alterar (todas as letras minusculas e sem acentuacao):</label>
        <input type="text" id="coluna" name="coluna" required><br><br>

        <label for="novo_valor">Novo Valor:</label>
        <input type="text" id="novo_valor" name="novo_valor" required><br><br>

        <button type="submit">Alterar</button>
    </form>

    <?php if (!empty($mensagem)): ?>
        <p><?= htmlspecialchars($mensagem) ?></p>
    <?php endif; ?>

    <footer>
        &copy; 2024 Life Nearby Montes Claros. Todos os direitos reservados.
    </footer>

</body>
</html>
