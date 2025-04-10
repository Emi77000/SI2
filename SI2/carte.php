<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
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
            display: flex;
            padding: 20px;
        }
        .sidebar {
            width: 300px;
            padding: 20px;
            background-color: #f0f0f0;
            border-right: 1px solid #829cbc;
        }
        .sidebar h2 {
            font-family: 'Merriweather', serif;
            font-size: 18px;
            color: #023047;
        }
        .sidebar p {
            font-family: 'Times New Roman', serif;
            font-size: 16px;
            color: #023047;
        }
        .map-container {
            flex-grow: 1;
            padding: 20px;
        }
        .search-bar {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            position: relative;
        }
        .search-bar input {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #219EBC;
            border-radius: 5px;
            padding-left: 10px;
            width: 300px;
        }
        .map {
            width: 100%;
            height: 500px;
            background-color: #e0e0e0;
            border: 1px solid #829cbc;
        }
        .dropdowns {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .dropdowns select {
            margin: 0 10px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #219EBC;
            border-radius: 5px;
        }
    </style>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>
<body>
    <div class="header">
        <div class="logo">Airblio</div>
        <div class="navbar">
            <a href="accueil.php">Accueil</a>
            <a href="intervention.php">Intervention</a>
            <a href="carte.php" class="active">Carte</a>
            <a href="equipement.php">Équipement</a>
            <a href="demande.php">Demande</a>
            <a href="deconnexion.php" class="logout"><img src="deconnexion.png" alt="Déconnexion"></a>
        </div>
    </div>
    <div class="content">
        <div class="sidebar">
            <h2 id="project-title">Projet 3</h2>
            <p id="project-position">Position : Porte Dauphine, 75016, Paris</p>
            <p id="project-state">État : en cours</p>
            <p id="project-members">Members : Naila, Emi, Sabana, Gabrielle</p>
            <p id="project-equipment">Equipement : X, Y, Z</p>
        </div>
        <div class="map-container">
            <div class="search-bar">
                <input type="text" placeholder="75016 / Projet X">
            </div>
            <div class="map" id="map"></div>
            <div class="dropdowns">
                <select>
                    <option>Projets en cours</option>
                    <!-- Add options here -->
                </select>
                <select>
                    <option>Projets prévus</option>
                    <!-- Add options here -->
                </select>
            </div>
        </div>
    </div>
    <script>
        // Initialize the map
        var map = L.map('map').setView([48.8588443, 2.2943506], 13); // Coordinates for Paris

        // Add a tile layer to the map
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Function to update project details
        function updateProjectDetails(title, position, state, members, equipment) {
            document.getElementById('project-title').innerText = title;
            document.getElementById('project-position').innerText = 'Position : ' + position;
            document.getElementById('project-state').innerText = 'État : ' + state;
            document.getElementById('project-members').innerText = 'Members : ' + members;
            document.getElementById('project-equipment').innerText = 'Equipement : ' + equipment;
        }

        // Example of updating project details (replace with actual map selection logic)
        updateProjectDetails('Projet 4', 'Champs-Élysées, 75008, Paris', 'prévu', 'Alice, Bob, Charlie', 'A, B, C');
    </script>
</body>
</html>