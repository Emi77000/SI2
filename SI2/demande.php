<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande</title>
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
        .search-bar {
            margin: 20px;
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
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            font-family: 'Lora', serif;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: none;
            border-bottom: 1px solid #829cbc;
            height: 50px; /* Set a fixed height for all cells */
        }
        th {
            background-color: #8ECAE6;
        }
        .importance {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .importance span {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }
        .importance .high {
            background-color: red;
        }
        .importance .medium {
            background-color: orange;
        }
        .importance .low {
            background-color: green;
        }
        .delete-icon {
            cursor: pointer;
            width: 16px; /* Adjust the size as needed */
            height: 16px; /* Adjust the size as needed */
        }
        td:last-child {
            text-align: center;
        }
        tr.clicked {
            background-color:rgb(215, 234, 242);
        }
    </style>
    <script>
        function deleteRow(row) {
            var i = row.parentNode.parentNode.rowIndex;
            document.getElementById("requestsTable").deleteRow(i);
        }

        function toggleRowColor(row) {
            var rows = document.querySelectorAll("#requestsTable tr");
            rows.forEach(function(r) {
                r.classList.remove("clicked");
            });
            row.classList.add("clicked");
        }
    </script>
</head>
<body>
    <div class="header">
        <div class="logo">Airblio</div>
        <div class="navbar">
            <a href="accueil.php">Accueil</a>
            <a href="intervention.php">Intervention</a>
            <a href="carte.php">Carte</a>
            <a href="equipement.php">Équipement</a>
            <a href="demande.php" class="active">Demande</a>
            <a href="deconnexion.php" class="logout"><img src="deconnexion.png" alt="Déconnexion"></a>
        </div>
    </div>
    <div class="search-bar">
        <input type="text" placeholder="Rechercher...">
    </div>
    <table id="requestsTable">
        <thead>
            <tr>
                <th>N° client</th>
                <th>Intitulé</th>
                <th>Date</th>
                <th>Importance</th>
            </tr>
        </thead>
        <tbody>
            <tr onclick="toggleRowColor(this)">
                <td>5204</td>
                <td>Panne électrique suite à une tempête</td>
                <td>28/03</td>
                <td class="importance"><span class="high"></span></td>
                <td><img src="poubelle.png" alt="Supprimer" class="delete-icon" onclick="deleteRow(this)"></td>
            </tr>
            <tr onclick="toggleRowColor(this)">
                <td>4370</td>
                <td>Suivi de commande pour le nouvel équipement</td>
                <td>25/03</td>
                <td class="importance"><span class="medium"></span></td>
                <td><img src="poubelle.png" alt="Supprimer" class="delete-icon" onclick="deleteRow(this)"></td>
            </tr>
            <tr onclick="toggleRowColor(this)">
                <td>1234</td>
                <td>Installation de nouveaux logiciels</td>
                <td>01/04</td>
                <td class="importance"><span class="low"></span></td>
                <td><img src="poubelle.png" alt="Supprimer" class="delete-icon" onclick="deleteRow(this)"></td>
            </tr>
            <tr onclick="toggleRowColor(this)">
                <td>5678</td>
                <td>Maintenance du serveur</td>
                <td>02/04</td>
                <td class="importance"><span class="medium"></span></td>
                <td><img src="poubelle.png" alt="Supprimer" class="delete-icon" onclick="deleteRow(this)"></td>
            </tr>
            <tr onclick="toggleRowColor(this)">
                <td>9101</td>
                <td>Réparation du réseau</td>
                <td>03/04</td>
                <td class="importance"><span class="high"></span></td>
                <td><img src="poubelle.png" alt="Supprimer" class="delete-icon" onclick="deleteRow(this)"></td>
            </tr>
        </tbody>
    </table>
</body>
</html>