<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intervention</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Merriweather&display=swap">
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
    padding: 10px 20px;
    background-color: #ffffff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}

        
        .logo a {
    color: #219EBC;
    font-family: 'Merriweather', serif;
    font-size: 36px;
    font-weight: bold;
    text-decoration: none;
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
            font-size: 18px; /* texte plus grand */
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

        .sidebar {
            display: flex;
            align-items: center;
            background-color: #cde4ef;
            padding: 10px;
        }
        .sidebar input[type="search"] {
            margin-right: 10px;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #219EBC;
        }
        .sidebar button {
            background-color: #219EBC;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Merriweather', serif;
        }
        .stats {
            display: flex;
            justify-content: space-around;
            padding: 20px;
        }
        .stat-box {
            background-color: #d9edf4;
            border: 2px solid #91c7da;
            padding: 15px;
            text-align: center;
            flex: 1;
            margin: 0 10px;
        }
        .stat-box h3 {
            margin: 0;
        }
        .stat-box .count {
            font-size: 28px;
            margin-top: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            margin-top: 20px;
        }
        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ccc;
        }
        .status-terminee {
            color: green;
        }
        .status-en-cours {
            color: orange;
        }
        .status-retard {
            color: red;
        }
        .importance-dot {
            height: 12px;
            width: 12px;
            border-radius: 50%;
            display: inline-block;
        }
        .importance-mineure { background-color: green; }
        .importance-critique { background-color: orange; }
        .importance-majeure { background-color: red; }
        .charts-container {
            display: flex;
            justify-content: space-around;
            padding: 30px;
        }
        .chart-box {
            background-color: #e5f1f7;
            border: 2px solid #a3cfe2;
            padding: 15px;
            width: 30%;
        }
        tr {
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="header">
    <div class="logo"><a href="accueil.php">Airblio</a></div>
    <div class="navbar">
        <a href="accueil.php">Accueil</a>
        <a href="intervention.php" class="active">Intervention</a>
        <a href="carte.php">Carte</a>
        <a href="equipement.php">Équipement</a>
        <a href="demande.php">Demande</a>
        <a href="deconnexion.php" class="logout"><img src="deconnexion.png" alt="Déconnexion"></a>
    </div>
</div>


    <div class="sidebar">
        <input type="search" placeholder="Rechercher...">
        <button>Créer une Intervention</button>
    </div>

    <div class="stats">
        <div class="stat-box">
            <h3>Interventions terminées</h3>
            <div class="count" style="color: green;">150</div>
        </div>
        <div class="stat-box">
            <h3>Interventions en cours</h3>
            <div class="count" style="color: orange;">25</div>
        </div>
        <div class="stat-box">
            <h3>Interventions à venir</h3>
            <div class="count" style="color: #EFB703;">15</div>
        </div>
        <div class="stat-box">
            <h3>Interventions en retard</h3>
            <div class="count" style="color: red;">5</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>N° intervention</th>
                <th>Réf Demande</th>
                <th>Intitulé</th>
                <th>Date</th>
                <th>Lieu</th>
                <th>Statut</th>
                <th>Importance</th>
            </tr>
        </thead>
        <tbody>
            <tr onclick="window.location.href='intervention_details.php?id=1783052'">
                <td>1783052</td>
                <td>682713</td>
                <td>Installation du nouvel équipement ...</td>
                <td>22/03</td>
                <td>Marseille, France</td>
                <td class="status-terminee">Terminée</td>
                <td><span class="importance-dot importance-mineure"></span></td>
            </tr>
            <tr onclick="window.location.href='intervention_details.php?id=1783051'">
                <td>1783051</td>
                <td>682712</td>
                <td>Remise à niveau du système de ...</td>
                <td>18/03</td>
                <td>Brest, France</td>
                <td class="status-en-cours">À venir</td>
                <td><span class="importance-dot importance-critique"></span></td>
            </tr>
            <tr onclick="window.location.href='intervention_details.php?id=1783050'">
                <td>1783050</td>
                <td>682712</td>
                <td>Vérification des câbles de communication ...</td>
                <td>18/03</td>
                <td>Brest, France</td>
                <td class="status-en-cours">En cours</td>
                <td><span class="importance-dot importance-critique"></span></td>
            </tr>
            <tr onclick="window.location.href='intervention_details.php?id=1783049'">
                <td>1783049</td>
                <td>682711</td>
                <td>Maintenance préventive annuelle des ...</td>
                <td>16/03</td>
                <td>Helsinki, Finlande</td>
                <td class="status-terminee">Terminée</td>
                <td><span class="importance-dot importance-mineure"></span></td>
            </tr>
        </tbody>
    </table>

    <div class="charts-container">
        <div class="chart-box">
            <h4>Interventions par criticité</h4>
        </div>
        <div class="chart-box">
            <h4>Overview des interventions</h4>
        </div>
        <div class="chart-box">
            <h4>Interventions par site</h4>
        </div>
    </div>
</body>
</html>