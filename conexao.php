<?php
$host = '127.0.0.1';
$dbname = 'desfibrillators';
$username = 'root'; // substitua pelo seu usuário do MySQL
$password = '12345678'; // substitua pela sua senha do MySQL, se houver

try {
    // Cria a conexão com o banco de dados usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Configura o PDO para lançar exceções em caso de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "Conexão bem-sucedida com o banco de dados 'desfibrillators'";
} catch (PDOException $e) {
    // Exibe a mensagem de erro caso a conexão falhe
    echo "Erro ao conectar com o banco de dados: " . $e->getMessage();
}
?>
