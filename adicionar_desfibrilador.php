<?php

session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

// Incluir a classe Desfibriladores e a conexão com o banco de dados
include 'conexao.php'; // Arquivo que contém a configuração da conexão com o banco
include 'desfibriladores.php'; // Arquivo que contém a classe Desfibriladores

// Criar uma instância da classe Desfibriladores
$desfibriladores = new Desfibriladores($pdo);

// Verificar se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Receber os dados do formulário
    $dados = [
        'nome' => $_POST['nome'],
        'cidade' => $_POST['cidade'],
        'bairro' => $_POST['bairro'],
        'rua' => $_POST['rua'],
        'numero' => $_POST['numero'],
        'latitude' => $_POST['latitude'],
        'longitude' => $_POST['longitude'],
        'situacao' => $_POST['situacao']
        // 'foto' => $_POST['foto']
        // 'foto_tamanho' => $_POST['foto_tamanho']
        // 'foto_tipo' => $_POST['foto_tipo']
    ];

    // Chamar o método adicionarDesfibrilador da classe Desfibriladores
    $result = $desfibriladores->adicionarDesfibrilador($dados);

    // Verificar se a inserção foi bem-sucedida
    if ($result) {
        echo "Desfibrilador cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar o desfibrilador.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Desfibrilador</title>
    <!-- <link rel="stylesheet" href="stylenew.css"> -->
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
            background-color: #d32020;
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
        <h1 style="text-align: center;">Novo desfibrilador</h1>
    </header>
    
    <nav>
        <a href="index.php">Voltar à página inicial</a>
        <a href="logout.php">Encerrar Sessão</a>
    </nav>

    <form action="adicionar_desfibrilador.php" method="POST">
        <label for="nome">Nome do Local</label>
        <input type="text" id="nome" name="nome" placeholder="Nome do local" required>
        
        <label for="cidade">Cidade</label>
        <input type="text" id="cidade" name="cidade" placeholder="Cidade" required>

        <label for="bairro">Bairro</label>
        <input type="text" id="bairro" name="bairro" placeholder="Bairro" required>

        <label for="rua">Rua</label>
        <input type="text" id="rua" name="rua" placeholder="Rua" required>

        <label for="numero">Numero</label>
        <input type="text" id="numero" name="numero" placeholder="Numero" required>

        <label for="latitude">Latitude</label>
        <input type="text" id="latitude" name="latitude" placeholder="Ex: -16.72767" required>

        <label for="longitude">Longitude</label>
        <input type="text" id="longitude" name="longitude" placeholder="Ex: -43.85778" required>
        
        <label for="situacao">Situacao</label>
        <select id="situacao" name="situacao" required>
            <option value= 1 >Ativo</option>
            <option value= 0 >Inativo</option>
        </select>

        <!-- <label for="foto">Foto nome</label>
        <input type="text" id="foto_nome" name="foto_nome" placeholder="Nome da foto" required>

        <label for="foto_tamanho">Foto tamanho</label>
        <input type="text" id="foto_tamanho" name="foto_tamanho" placeholder="" required>

        <label for="foto_tipo">Foto tipo</label>
        <input type="text" id="foto_tipo" name="foto_tipo" placeholder="" required> -->

        <!-- <label for="criado">Cadastrado em</label>
        <input type="text" id="criado" name="criado" required>

        <label for="atualizado">Atualizado em</label>
        <input type="text" id="atualizado" name="atualizado" required> -->

        <button type="submit">Adicionar Desfibrilador</button>
    </form>

    <footer>
        &copy; 2024 Life Nearby Montes Claros. Todos os direitos reservados.
    </footer>

</body>
</html>