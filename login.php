<?php
session_start();
include 'conexao.php'; // Arquivo para conectar ao banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    // Buscar o usuário na tabela
    $sql = "SELECT * FROM users WHERE login = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$login]);
    $user = $stmt->fetch();

    // Verificar se o usuário existe e a senha está correta
    if ($user && password_verify($senha, $user['senha'])) {
        $_SESSION['usuario'] = $user['login'];
        header('Location: adicionar_desfibrilador.php'); // Redireciona para a página protegida
        exit();
    } else {
        $erro = "Login ou senha inválidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            background-color: #0275d8;
            color: #fff;
            text-align: center;
            padding: 1rem 0;
        }
        nav {
            background-color: #025aa5;
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
            background-color: #0275d8;
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
            color: #0275d8;
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
        <h2>Login</h2>
    </header>
        
    <?php if (isset($erro)) { echo "<p style='color: red;'>$erro</p>"; } ?>
    <form action="login.php" method="POST">
        <label for="login">Login:</label>
        <input type="text" id="login" name="login" required>
        <br><br>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        <br><br>
        <button type="submit">Entrar</button>
    </form>

    <nav>
        <a href="index.php">Voltar à página inicial</a>
    </nav>

    <footer>
        &copy; 2024 Life Nearby Montes Claros. Todos os direitos reservados.
    </footer>

</body>
</html>
