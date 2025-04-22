<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Équipement</title>
  <style>
    .chart-info {
  margin-top: 10px;
  font-family: 'Merriweather', serif;
  font-size: 14px;
  color: #FB8500;
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.recommandation {
  background-color: #023047;
  color: #FB8500;
  font-weight: bold;
  border-radius: 6px;
  padding: 4px 8px;
  margin-top: 6px; /* ajoute un peu plus d'espace sous le total */
}

    .chart-row:nth-of-type(2) {
  margin-top: 50px; 
}

    .apply-button {
    width: 100%;
    background-color: #219EBC;
    color: white;
    padding: 8px;
    border: none;
    border-radius: 6px;
    font-weight: bold;
    font-family: 'Merriweather', serif;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin-top: 10px;
}

.apply-button:hover {
    background-color: #1a7ea1;
}
    body {
      font-family: 'Times New Roman', serif;
      background-color: #f0f0f0;
      margin: 0;
      padding: 0;
    }

    .header {
      display: flex;
      align-items: center;
      padding: 10px 20px;
      background-color: #ffffff;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .logo a {
      color: #219EBC;
      font-family: 'Merriweather', serif;
      font-size: 32px;
      font-weight: 700;
      text-decoration: none;
      margin-right: 40px;
    }

    .navbar {
      background-color: #023047;
      padding: 20px 30px;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-grow: 1;
      gap: 140px;
      border-radius: 10px;
    }

    .navbar a {
      color: white;
      font-size: 18px;
      font-weight: 600;
      text-decoration: none;
      position: relative;
      transition: color 0.3s ease;
    }

    .navbar a:hover {
      color: #FFB703;
    }

    .navbar a.active {
      color: #FFB703;
    }

    .navbar a.active::after {
      content: '';
      position: absolute;
      bottom: -6px;
      left: 50%;
      transform: translateX(-50%);
      width: 6px;
      height: 6px;
      background-color: #FFB703;
      border-radius: 50%;
    }

    .navbar .logout img {
      width: 24px;
      height: 24px;
      filter: brightness(0) invert(1);
    }

    .main-layout {
      display: flex;
      align-items: center; /* centrer verticalement */
      justify-content: center;
      gap: 40px;
      padding: 40px 20px;
    }

    .filter-box {
    position: absolute;
    top: 50%;
    left: 40px;
    transform: translateY(-50%);
    background-color: white;
    border: 1px solid #ccc;
    padding: 15px;
    border-radius: 8px;
    width: 180px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    text-align: left;
    font-family: 'Merriweather', serif;
    z-index: 10;
}


    .filter-box label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
    }

    .filter-box select,
    .filter-box input[type="date"] {
      width: 100%;
      margin-bottom: 10px;
      padding: 6px;
      border-radius: 4px;
      border: 1px solid #ccc;
      font-family: 'Times New Roman', serif;
    }

    .chart-container {
        padding: 20px;
    padding-left: 250px; /* ajoute cette ligne */
    text-align: center;
}
    .content {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }
    .chart-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .chart-row {
      display: flex;
      justify-content: space-around;
      width: 100%;
      flex-wrap: wrap;
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
    .chart-info {
  margin-top: 10px;
  font-family: 'Merriweather', serif;
  font-size: 14px;
  color: #FB8500;
  text-align: center;
}

.recommandation {
  background-color: #023047;
  color: #FB8500;
  font-weight: bold;
  border-radius: 6px;
  padding: 4px 8px;
  margin-top: 4px;
  display: inline-block;
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
    document.addEventListener('DOMContentLoaded', function () {
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
        const chartDiv = document.getElementById(`chart${index}`).parentElement;

const infoDiv = document.createElement('div');
infoDiv.classList.add('chart-info');

const total = item.stock + item.used + item.rupture;
infoDiv.innerHTML = `Total : ${total} unités`;

if (item.stock < 50) {
  const reco = document.createElement('div');
  reco.classList.add('recommandation');
  reco.textContent = 'Recommandé';
  infoDiv.appendChild(reco);
}

chartDiv.appendChild(infoDiv);

      });
    });
  </script>
</head>
<body>

<div class="header">
  <div class="logo"><a href="accueil.php">Airblio</a></div>
  <div class="navbar">
    <a href="accueil.php">Accueil</a>
    <a href="intervention.php">Intervention</a>
    <a href="carte.php">Carte</a>
    <a href="equipement.php" class="active">Équipement</a>
    <a href="demande.php">Demande</a>
    <a href="deconnexion.php" class="logout"><img src="deconnexion.png" alt="Déconnexion"></a>
  </div>
</div>

<div class="filter-box">
    <label for="date">Date</label>
    <input type="date" id="date">

    <label for="lieu">Lieu</label>
    <select id="lieu">
        <option>Lieu</option>
        <!-- Tu peux ajouter d'autres options ici -->
    </select>

    <button class="apply-button">Appliquer les filtres</button>
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
</div>

</body>
</html>
