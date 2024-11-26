<!DOCTYPE html>
<html>
<head>
    <title>Mapa com Desfibriladores</title>
    <link rel="stylesheet" href="stylenew.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-TxXrCxyO5PzKlvS9igXj33o4huPqdt4"></script>
    <script>
        // Função para inicializar o mapa
        function initMap() {
            // Configuração do mapa
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: {lat: -16.729559768879874, lng: -43.865470134290895} // Posição central inicial (São Paulo, por exemplo)
            });

            // Carregar coordenadas do PHP
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
        <h1>Localização de Desfibriladores</h1>
    </header>
   
    <nav>
        <a href="index.php">Voltar à página inicial</a>
    </nav>

    <div id="map" style="height: 900px; width: 100%;"></div>
    
    <footer>
        &copy; 2024 Life Nearby Montes Claros. Todos os direitos reservados.
    </footer>
</body>
</html>
