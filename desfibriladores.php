<?php
class Desfibriladores {
    private $pdo;

    // Construtor recebe a conexão PDO como parâmetro e a armazena em uma variável privada
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Método para adicionar um novo desfibrilador no banco de dados
    public function adicionarDesfibrilador($dados) {
        $sql = "INSERT INTO desfibrillators (nome, cidade, bairro, rua, numero, latitude, longitude, situacao)
                VALUES (:nome, :cidade, :bairro, :rua, :numero, :latitude, :longitude, :situacao)";

        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([
            ':nome' => $dados['nome'],
            ':cidade' => $dados['cidade'],
            ':bairro' => $dados['bairro'],
            ':rua' => $dados['rua'],
            ':numero' => $dados['numero'],
            ':latitude' => $dados['latitude'],
            ':longitude' => $dados['longitude'],
            ':situacao' => $dados['situacao'],
            // ':foto' => $dados['foto'],
            // ':foto_tamanho' => $dados['foto_tamanho'],
            // ':foto_tipo' => $dados['foto_tipo']           
        ]);
    }

    // // Método para obter um desfibrilador pelo ID
    // public function obterDesfibriladorPorId($pdo, $id){
    //     $sql = "SELECT * FROM desfibrillators WHERE id = :id";
    //     $stmt = $this->pdo->prepare($sql);
    //     $stmt->execute([':id' => $id]);
    //     return $stmt->fetch(PDO::FETCH_ASSOC);
    // }

    // Método para listar todos os desfibriladores
    public function listarDesfibriladores(): mixed {
        $sql = "SELECT * FROM desfibrillators";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarLatLong(): mixed {
        $sql = "SELECT latitude, longitude, nome, rua, numero FROM desfibrillators";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
