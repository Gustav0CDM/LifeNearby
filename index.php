<?php
// Conectar ao banco de dados MySQL com PDO
include 'conexao.php';

// listar_desfibriladores.php
include 'desfibriladores.php';

// Instancia a classe Desfibriladores
$desfibriladores = new Desfibriladores($pdo);

// Obtém todos os desfibriladores
$lista = $desfibriladores->listarDesfibriladores();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Life Nearby</title>
    <link rel="stylesheet" href="stylenew.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-TxXrCxyO5PzKlvS9igXj33o4huPqdt4"></script>
    <script>
        // Função para inicializar o mapa
        function initMap() {
            // Configuração inicial do mapa
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: {lat: -16.729559768879874, lng: -43.865470134290895} // Posição central inicial (Montes Claros, MG)
            });

            // Obter localização do usuário
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    // Obter latitude e longitude
                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;

                    // Atualiza o mapa para a localização do usuário
                    map.setCenter(new google.maps.LatLng(latitude, longitude));

                    // Adiciona um marcador no local do usuário
                    new google.maps.Marker({
                        position: {lat: latitude, lng: longitude},
                        map: map,
                        title: 'Você está aqui'
                    });

                    // Envia as coordenadas para o PHP
                    fetch('salvar_localizacao.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ latitude, longitude }),
                    })
                    .then(response => response.text())
                    .then(data => console.log(data))
                    .catch(error => console.error('Erro ao enviar localização:', error));
                }, function() {
                    alert('Erro ao obter localização. Certifique-se de que a geolocalização está ativada.');
                });
            } else {
                alert('Geolocalização não é suportada neste navegador.');
            }

            // Carregar coordenadas dos desfibriladores do banco de dados
            fetch('buscar_coordenadas.php')
            .then(response => response.json())
            .then(data => {
                data.forEach(function(location) {
                    // Cria o marcador para o desfibrilador
                    var marker = new google.maps.Marker({
                        position: {
                            lat: parseFloat(location.latitude),
                            lng: parseFloat(location.longitude)
                        },
                        map: map
                    });

                    // Cria a InfoWindow com o nome do desfibrilador
                    var infoWindow = new google.maps.InfoWindow({
                        content: '<h3>' + location.nome + '</h3>' // Exibe o nome do desfibrilador
                    });

                    // Quando o marcador for clicado, abre a InfoWindow
                    marker.addListener('click', function() {
                        infoWindow.open(map, marker);
                    });
                });
            })
            .catch(error => console.error('Erro ao carregar dados de desfibriladores:', error));

        }
    </script>
</head>
<body onload="initMap()">
    <header>
        <h1>Life Nearby - Montes Claros - MG</h1>

        <nav>
            <ul>
                <li><a href="sobre.html">Sobre nós</a></li>
                <li><a href="mapa.php">Mapa ampliado</a></li>
                <li><a href="contato.html">Contato</a></li>
                <li><a href="buscar_desfibrilador.php">Consultar desfibrilador</a></li>
                <li><a href="calcular_rota.php">Desfibrilador mais próximo</a></li>
                <li><a href="adicionar_desfibrilador.php">Cadastrar desfibrilador</a></li>
                <li><a href="atualizar_desfibrilador.php">Atualizar desfibrilador</a></li>
            </ul>
        </nav>
    
        <div id="map" style="height: 500px;"></div>

        <h2>Lista e localização de desfibriladores</h2>
    </header>

    <table>
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Nome</th>
                <th>Cidade</th>
                <th>Bairro</th>
                <th>Rua</th>
                <th>Número</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Situacao</th>
 
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lista as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['id']) ?></td>
                    <td><?= htmlspecialchars($item['nome']) ?></td>
                    <td><?= htmlspecialchars($item['cidade']) ?></td>
                    <td><?= htmlspecialchars($item['bairro']) ?></td>
                    <td><?= htmlspecialchars($item['rua']) ?></td>
                    <td><?= htmlspecialchars($item['numero']) ?></td>
                    <td><?= htmlspecialchars($item['latitude']) ?></td>
                    <td><?= htmlspecialchars($item['longitude']) ?></td>
                    <td><?= htmlspecialchars($item['situacao']) ?></td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <footer>
        &copy; 2024 Life Nearby Montes Claros. Todos os direitos reservados.
    </footer>
</body>
</html>