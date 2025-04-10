<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
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
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">Airblio</div>
        <div class="navbar">
            <a href="accueil.php" class="active">Accueil</a>
            <a href="intervention.php">Intervention</a>
            <a href="carte.php">Carte</a>
            <a href="equipement.php">Équipement</a>
            <a href="demande.php">Demande</a>
            <a href="deconnexion.php" class="logout"><img src="deconnexion.png" alt="Déconnexion"></a>
        </div>
    </div>
    <div class="content">
        <h1>Bienvenue sur la page d'accueil</h1>
        <p>Utilisez la barre de navigation pour accéder aux différentes sections du site.</p>
    </div>
</body>
</html>