<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Merriweather:wght@700&display=swap" rel="stylesheet">
    <style>
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
    font-size: 32px; /* légèrement agrandi */
    font-weight: 700;
    text-decoration: none;
    margin-right: 40px;
}

.navbar {
    background-color: #023047;
    padding: 20px 30px; /* hauteur augmentée */
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

.preview-container {
    display: grid;
    grid-template-columns: repeat(2, 500px); /* 2 colonnes */
    grid-template-rows: repeat(2, 250px);  /* 2 lignes de hauteur fixe */
    gap: 100px; /* espace entre les cartes */
    margin-top: 40px;
    padding: 0 40px;
    justify-content: center;
    max-width: 1000px;
    margin-left: auto;
    margin-right: auto;
}


.preview-card {
    position: relative;
    height: 300px; /* augmente la hauteur */
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    text-decoration: none;
}

.preview-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}

.preview-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.preview-card h2 {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 14px;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
    color: #ffffff;
    font-size: 22px;
    font-family: 'Merriweather', serif;
    margin: 0;
    text-align: left;
}

    </style>
</head>

<body>
    <div class="header">
        <div class="logo"><a href="accueil.php">Airblio</a></div>
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
        <div class="preview-container">
            <!-- Aperçu Intervention -->
            <a href="intervention.php" class="preview-card">
                <img src="img/intervention.png" alt="Intervention">
                <h2>Intervention</h2>
            </a>
            <!-- Aperçu Carte -->
            <a href="carte.php" class="preview-card">
                <img src="img/carte.png" alt="Carte">
                <h2>Carte</h2>
            </a>
            <!-- Aperçu Équipement -->
            <a href="equipement.php" class="preview-card">
                <img src="img/equipement.png" alt="Équipement">
                <h2>Équipement</h2>
            </a>
            <!-- Aperçu Demande -->
            <a href="demande.php" class="preview-card">
                <img src="img/demande.png" alt="Demande">
                <h2>Demande</h2>
            </a>
        </div>
    </div>
</body>
</html>
