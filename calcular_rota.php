<?php
include 'conexao.php';
include 'desfibriladores.php';

$desfibriladores = new Desfibriladores($pdo);
$locations = $desfibriladores->listarLatLong() ?? [];

// Converte os valores de latitude e longitude para float
foreach ($locations as &$location) {
    $location['latitude'] = (float)$location['latitude'];
    $location['longitude'] = (float)$location['longitude'];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Life Nearby</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
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
    <script>
        var map;
        var userLatitude, userLongitude;
        var desfibriladores = <?php echo json_encode($locations); ?>;

        function initMap() {
            map = L.map('map').setView([-16.729559768879874, -43.865470134290895], 12);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    userLatitude = position.coords.latitude;
                    userLongitude = position.coords.longitude;
                    L.marker([userLatitude, userLongitude]).addTo(map).bindPopup("Você está aqui").openPopup();
                    map.setView([userLatitude, userLongitude], 14);
                    calculateClosestRoute();
                }, function() {
                    alert('Erro ao obter localização.');
                });
            } else {
                alert('Geolocalização não suportada.');
            }
        }

        function calculateClosestRoute() {
            if (!desfibriladores.length) {
                alert('Nenhum desfibrilador disponível.');
                return;
            }

            let userLocation = [userLatitude, userLongitude];
            let closest = desfibriladores.reduce((prev, curr) => {
                let prevDist = getDistance(userLocation, [prev.latitude, prev.longitude]);
                let currDist = getDistance(userLocation, [curr.latitude, curr.longitude]);
                return currDist < prevDist ? curr : prev;
            });

            let routeUrl = `https://router.project-osrm.org/route/v1/driving/${userLongitude},${userLatitude};${closest.longitude},${closest.latitude}?overview=full&geometries=geojson`;

            fetch(routeUrl)
                .then(response => response.json())
                .then(data => {
                    if (data.routes && data.routes.length) {
                        let route = data.routes[0].geometry;
                        L.geoJSON(route).addTo(map);
                        L.marker([closest.latitude, closest.longitude]).addTo(map).bindPopup(closest.nome + ' - Rua ' + closest.rua + ', ' + closest.numero).openPopup();
                    } else {
                        alert('Rota não encontrada.');
                    }
                }).catch(err => {
                    console.error(err);
                    alert('Erro ao acessar o serviço de rotas.');
                });
        }

        function getDistance(origin, destination) {
            var R = 6371;
            var dLat = (destination[0] - origin[0]) * Math.PI / 180;
            var dLon = (destination[1] - origin[1]) * Math.PI / 180;
            var lat1 = origin[0] * Math.PI / 180;
            var lat2 = destination[0] * Math.PI / 180;

            var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.sin(dLon / 2) * Math.sin(dLon / 2) * Math.cos(lat1) * Math.cos(lat2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }
    </script>
</head>
<body onload="initMap()">
    <header>
        <h1>Este é o desfibrilador mais próximo de sua localização</h1>
        <div id="map" style="height: 500px;"></div>
    </header>

    <nav>
        <a href="index.php">Voltar à página inicial</a>
    </nav>

    <footer>
        &copy; 2024 Life Nearby Montes Claros. Todos os direitos reservados.
    </footer>
</body>
</html>
