<?php
// Conexão ao banco de dados (substitua pelos seus dados de conexão)
include 'conexao.php';

function obterDesfibriladorPorId($pdo, $id) {
    $sql = "SELECT * FROM desfibrillators WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
// Verifica se o formulário foi enviado
$result = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if ($id !== false && $id !== null) {
        $result = obterDesfibriladorPorId($pdo, $id);
    } else {
        echo "<p>ID inválido. Por favor, insira um número inteiro.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Desfibrilador</title>
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
            background-color: #f8f9fa;
            text-align: center;
            padding: 1rem 0;
            margin-top: 2rem;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <header>
        <h1>Buscar desfibrilador por codigo (id)</h1>
    </header>
    
    <form method="post">
        <label for="id">Codigo do Desfibrilador:</label>
        <input type="number" id="id" name="id" required>
        <button type="submit">Buscar</button>
    </form>

    <?php if ($result): ?>
        <h2>Resultado:</h2>
        <table border="1">
            <thead>
                <tr>
                    <?php foreach (array_keys($result) as $coluna): ?>
                        <th><?= htmlspecialchars($coluna) ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php foreach ($result as $valor): ?>
                        <td><?= htmlspecialchars($valor) ?></td>
                    <?php endforeach; ?>
                </tr>
            </tbody>
        </table>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <p>Nenhum desfibrilador encontrado para o codigo/ id informado.</p>
    <?php endif; ?>

    <nav>
        <a href="index.php">Voltar à página inicial</a>
    </nav>

    <footer>
        &copy; 2024 Life Nearby Montes Claros. Todos os direitos reservados.
    </footer>

</body>
</html>
