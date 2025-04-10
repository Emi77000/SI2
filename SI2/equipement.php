<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Équipement</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .header {
            display: flex;
            align-items: center;
            padding: 10px;
            background-color: #f0f0f0;
        }
        .header .logo {
            color: #8ECAE6;
            font-family: 'Merriweather', serif;
            font-size: 24px;
            margin-right: 20px;
        }
        .navbar {
            background-color: #023047;
            padding: 10px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            flex-grow: 1;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            font-family: 'Merriweather', serif;
            padding: 10px 20px;
            position: relative;
        }
        .navbar a.active {
            color: #FFB703;
        }
        .navbar a.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 5px;
            height: 5px;
            background-color: #FFB703;
            border-radius: 50%;
        }
        .navbar .logout {
            padding: 10px 20px;
        }
        .navbar .logout img {
            width: 20px;
            height: 20px;
        }
        .content {
            padding: 20px;
            text-align: center;
        }
        .chart-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        .chart-row {
            display: flex;
            justify-content: space-around;
            width: 100%;
        }
        .chart {
            width: 200px;
            height: 200px;
            margin: 20px;
            position: relative;
        }
        .chart canvas {
            width: 100%;
            height: 100%;
        }
        .chart-label {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: 'Merriweather', serif;
            font-size: 14px;
            text-align: center;
        }
        .legend {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .legend div {
            margin: 0 10px;
            display: flex;
            align-items: center;
        }
        .legend div span {
            width: 20px;
            height: 20px;
            display: inline-block;
            margin-right: 5px;
        }
        .legend .stock span {
            background-color: #219EBC;
        }
        .legend .used span {
            background-color: #FB8500;
        }
        .legend .rupture span {
            background-color: #829cbc;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const data = [
                { label: 'Caisson Hyperbare', stock: 40, used: 30, rupture: 30 },
                { label: 'Sonar de Plongée', stock: 50, used: 20, rupture: 30 },
                { label: 'Combinaison de Plongée Étanche', stock: 60, used: 25, rupture: 15 },
                { label: 'Propulseur Sous-Marin', stock: 70, used: 20, rupture: 10 },
                { label: 'Robot Sous-Marin (ROV)', stock: 50, used: 40, rupture: 10 },
                { label: 'Équipement de Soudure Sous-Marine', stock: 30, used: 50, rupture: 20 }
            ];

            data.forEach((item, index) => {
                const ctx = document.getElementById(`chart${index}`).getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['En stock', 'Utilisé', 'Rupture'],
                        datasets: [{
                            data: [item.stock, item.used, item.rupture],
                            backgroundColor: ['#219EBC', '#FB8500', '#829cbc']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            });
        });
    </script>
</head>
<body>
    <div class="header">
        <div class="logo">Airblio</div>
        <div class="navbar">
            <a href="accueil.php">Accueil</a>
            <a href="intervention.php">Intervention</a>
            <a href="carte.php">Carte</a>
            <a href="equipement.php" class="active">Équipement</a>
            <a href="demande.php">Demande</a>
            <a href="deconnexion.php" class="logout"><img src="deconnexion.png" alt="Déconnexion"></a>
        </div>
    </div>
    <div class="content">
        <div class="chart-container">
            <div class="chart-row">
                <div class="chart">
                    <canvas id="chart0"></canvas>
                    <div class="chart-label">Caisson Hyperbare</div>
                </div>
                <div class="chart">
                    <canvas id="chart1"></canvas>
                    <div class="chart-label">Sonar de Plongée</div>
                </div>
                <div class="chart">
                    <canvas id="chart2"></canvas>
                    <div class="chart-label">Combinaison de Plongée Étanche</div>
                </div>
            </div>
            <div class="chart-row">
                <div class="chart">
                    <canvas id="chart3"></canvas>
                    <div class="chart-label">Propulseur Sous-Marin</div>
                </div>
                <div class="chart">
                    <canvas id="chart4"></canvas>
                    <div class="chart-label">Robot Sous-Marin (ROV)</div>
                </div>
                <div class="chart">
                    <canvas id="chart5"></canvas>
                    <div class="chart-label">Équipement de Soudure Sous-Marine</div>
                </div>
            </div>
        </div>
        <div class="legend">
            <div class="stock"><span></span>En stock</div>
            <div class="used"><span></span>Utilisé</div>
            <div class="rupture"><span></span>Rupture</div>
        </div>
    </div>
</body>
</html>