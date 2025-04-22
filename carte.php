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

        .map-container {
            flex-grow: 1;
            padding: 20px;
        }

        .search-bar {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
        }

        .search-bar input {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #219EBC;
            border-radius: 5px;
            width: 300px;
        }

        .filter-box {
            display: flex;
            justify-content: space-between;
            margin-top: 40px; /* Espacement plus grand entre la carte et les filtres */
            gap: 10px;
        }

        .filter-box select,
        .filter-box input {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #219EBC;
            border-radius: 5px;
            width: 45%;
        }

        .map {
            width: 100%;
            height: 500px;
            background-color: #e0e0e0;
            border: 1px solid #829cbc;
        }

        #project-list {
            max-height: 80vh;
            overflow-y: auto;
            padding-right: 5px;
            list-style: none;
        }

        #project-list li.selected {
            background-color: #023047;
            border: 2px solid #FFB703;
            color: #FFB703;
            font-weight: normal;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.2);
        }

        #project-list li {
            transition: all 0.2s ease;
        }

        #project-list li.selected strong,
        #project-list li.selected small {
            color: #FFB703;
        }

        #project-list li strong,
        #project-list li small {
            color: #023047;
        }

        .reset-filters {
            margin-top: 20px;
            padding: 10px;
            background-color: #FFB703;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .reset-filters:hover {
            background-color: #FF9F00;
        }
    </style>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>
<body>
    <div class="header">
        <div class="logo"><a href="accueil.php">Airblio</a></div>
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
            <h2>Projets</h2>
            <ul id="project-list"></ul>
        </div>
        <div class="map-container">
            <div class="search-bar">
                <input type="text" placeholder="75016 / Projet X">
            </div>
            <!-- Filter Box -->
            <div class="filter-box">
                <input type="date" id="filter-date">
                <select id="filter-lieu">
                    <option value="">Sélectionner le lieu</option>
                    <option value="Paris, France">Paris</option>
                    <option value="New York, USA">New York</option>
                    <option value="Tokyo, Japon">Tokyo</option>
                    <option value="Berlin, Allemagne">Berlin</option>
                    <option value="Londres, Royaume-Uni">Londres</option>
                    <option value="Sydney, Australie">Sydney</option>
                    <option value="Rio de Janeiro, Brésil">Rio de Janeiro</option>
                    <option value="Vancouver, Canada">Vancouver</option>
                </select>
            </div>
            <div class="map" id="map"></div>

            <!-- Filters for state -->
            <div class="dropdowns">
                <button id="filter-current">Projets en cours</button>
                <button id="filter-planned">Projets prévus</button>
            </div>

            <button class="reset-filters" id="reset-filters">Réinitialiser tous les filtres</button>
        </div>
    </div>

    <script>
        var map = L.map('map').setView([48.8566, 2.3522], 2);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var projects = [
            { title: 'Projet 1', position: 'Paris, France', coords: [48.8566, 2.3522], state: 'en cours', members: 'Alice, Bob', equipment: 'A, B', date: '2025-05-01' },
            { title: 'Projet 2', position: 'New York, USA', coords: [40.7128, -74.0060], state: 'prévu', members: 'Charlie, David', equipment: 'X, Y', date: '2025-06-01' },
            { title: 'Projet 3', position: 'Tokyo, Japon', coords: [35.6762, 139.6503], state: 'en cours', members: 'Eva, Frank', equipment: 'C, D', date: '2025-04-15' },
            { title: 'Projet 4', position: 'Berlin, Allemagne', coords: [52.5200, 13.4050], state: 'prévu', members: 'George, Hannah', equipment: 'E, F', date: '2025-07-01' },
            { title: 'Projet 5', position: 'Londres, Royaume-Uni', coords: [51.5074, -0.1278], state: 'en cours', members: 'Isaac, Jake', equipment: 'G, H' },
            { title: 'Projet 6', position: 'Sydney, Australie', coords: [-33.8688, 151.2093], state: 'prévu', members: 'Kathy, Liam', equipment: 'I, J' },
            { title: 'Projet 7', position: 'Rio de Janeiro, Brésil', coords: [-22.9068, -43.1729], state: 'en cours', members: 'Mona, Noah', equipment: 'K, L' },
            { title: 'Projet 8', position: 'Vancouver, Canada', coords: [49.2827, -123.1207], state: 'prévu', members: 'Olivia, Peter', equipment: 'M, N' }
        ];

        var filterStateValue = "";  // Default to show all projects

        function filterProjects() {
            var filterDate = document.getElementById('filter-date').value;
            var filterLieu = document.getElementById('filter-lieu').value;

            projects.forEach(function(project) {
                var matchDate = filterDate ? project.date === filterDate : true;
                var matchLieu = filterLieu ? project.position === filterLieu : true;
                var matchState = filterStateValue ? project.state === filterStateValue : true;

                var match = matchDate && matchLieu && matchState;

                if (match) {
                    map.addLayer(project.marker);
                    project.listItem.style.display = 'block';
                } else {
                    map.removeLayer(project.marker);
                    project.listItem.style.display = 'none';
                }
            });
        }

        function handleFilterClick(event) {
            if (event.target.id === 'filter-current') {
                filterStateValue = 'en cours';
            } else if (event.target.id === 'filter-planned') {
                filterStateValue = 'prévu';
            }

            filterProjects();
        }

        function resetFilters() {
            document.getElementById('filter-date').value = '';
            document.getElementById('filter-lieu').value = '';
            filterStateValue = "";  // Reset state filter
            filterProjects();
        }

        // Add the projects to the map and project list
        var projectList = document.getElementById('project-list');

        projects.forEach(function(project) {
            var marker = L.marker(project.coords).addTo(map)
                .bindPopup(`<b>${project.title}</b><br>${project.position}<br><b>État :</b> ${project.state}<br><b>Membres :</b> ${project.members}<br><b>Équipement :</b> ${project.equipment}<br><b>Date :</b> ${project.date}`);

            project.marker = marker;

            var listItem = document.createElement('li');
            listItem.style.cursor = 'pointer';
            listItem.style.marginBottom = '15px';
            listItem.style.padding = '10px';
            listItem.style.border = '1px solid #ccc';
            listItem.style.borderRadius = '5px';
            listItem.style.fontFamily = "'Merriweather', serif";

            listItem.innerHTML = `
                <strong>${project.title}</strong><br>
                <small><b>Lieu :</b> ${project.position}</small><br>
                <small><b>État :</b> ${project.state}</small><br>
                <small><b>Membres :</b> ${project.members}</small><br>
                <small><b>Équipement :</b> ${project.equipment}</small><br>
                <small><b>Date :</b> ${project.date}</small>
            `;

            listItem.addEventListener('click', function () {
                map.setView(project.coords, 10);
                marker.openPopup();
                document.querySelectorAll('#project-list li').forEach(li => li.classList.remove('selected'));
                listItem.classList.add('selected');
            });

            projectList.appendChild(listItem);
            project.listItem = listItem;
        });

        // Apply filters on change
        document.getElementById('filter-date').addEventListener('change', filterProjects);
        document.getElementById('filter-lieu').addEventListener('change', filterProjects);
        document.getElementById('filter-current').addEventListener('click', handleFilterClick);
        document.getElementById('filter-planned').addEventListener('click', handleFilterClick);
        document.getElementById('reset-filters').addEventListener('click', resetFilters);
    </script>
</body>
</html>
