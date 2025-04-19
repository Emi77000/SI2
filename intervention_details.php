<?php
$id = $_GET['id'] ?? null;

$interventions = [
    '1783052' => [
        'ref_demande' => '682713',
        'titre' => 'Installation du nouvel équipement de plongée',
        'date' => '22/03/2025',
        'heure' => '15h03',
        'entreprise' => 'Entreprise Y',
        'site' => 'Port autonome de Marseille, 13002 Marseille, France',
        'contact' => 'Client A, +33 7 43 83 51 90',
        'realisation' => '24/03/2025',
        'description' => "Remplacement complet du système de communication défaillant...",
        'commentaires' => "Installation réalisée sans incident...",
        'statut' => 'Terminée',
        'importance' => 'Faible',
        'avancement' => '100%',
        'couts' => '38 500€',
        'membres' => [
            'Chef de mission : M. Lefèvre',
            'Technicien Plongée : C. Marin',
            'Assistant technique : J. Dubois'
        ],
        'equipements' => [
            'Caisson Hyperbare',
            'Sonar de Plongée',
            'Combinaison de Plongée Étanche'
        ]
    ]
];

$data = $interventions[$id] ?? null;
?>

<?php if ($data): ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail Intervention</title>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Times New Roman', serif; background-color: #e5f1f7; margin: 0; padding: 0; }
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

        .content { padding: 20px; display: flex; flex-direction: column; gap: 20px; }
        .back-btn {
            background-color: #FB8500;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            width: fit-content;
        }

        .details { display: flex; gap: 20px; flex-wrap: wrap; }
        .left-box, .right-box {
            background: white;
            padding: 20px;
            border-radius: 5px;
            flex: 1 1 400px;
        }

        .right-box img {
            width: 100%;
            border-radius: 5px;
        }

        .info-box {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }
        .info-box div {
            background: #d6eaf8;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            flex: 1;
            margin: 0 5px;
        }

        .btn-group {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-top: 30px;
        }
        .btn-group button {
            background-color: #219EBC;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Merriweather', serif;
        }

        .left-box h2 {
            font-family: 'Merriweather', serif;
        }
        .left-box p {
            margin: 10px 0;
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

    <div class="content">
        <a class="back-btn" href="intervention.php">← Retour à la liste des interventions</a>

        <div class="details">
            <div class="left-box">
                <p><strong>Membres :</strong><br><?= implode('<br>', $data['membres']) ?></p>
                <p><strong>Équipements :</strong><br><?= implode('<br>', $data['equipements']) ?></p>
            </div>
            <div class="right-box">
                <img src="img/marseille_port.jpg" alt="Carte site">
                <div class="info-box">
                    <div>Avancement<br><?= $data['avancement'] ?></div>
                    <div>Coûts<br><?= $data['couts'] ?></div>
                </div>
            </div>
        </div>

        <div class="left-box">
            <h2>Intervention - <?= $data['titre'] ?></h2>
            <p><strong>N° <?= $id ?></strong> | Demande N° <?= $data['ref_demande'] ?></p>
            <p><em>Entreprise :</em> <?= $data['entreprise'] ?><br>
               <em>Site concerné :</em> <?= $data['site'] ?><br>
               <em>Contact sur site :</em> <?= $data['contact'] ?><br>
               <em>Date de réalisation :</em> <?= $data['realisation'] ?></p>
            <p><?= $data['description'] ?></p>
            <p><em>Commentaires :</em> <?= $data['commentaires'] ?></p>
            <p><strong>Statut :</strong> <?= $data['statut'] ?> — <strong>Importance :</strong> <?= $data['importance'] ?></p>
            <button disabled>Ajouter un Commentaire</button>
        </div>

        <div class="btn-group">
            <button>Créer une Intervention</button>
            <button>Modifier l’Intervention</button>
            <button>Clore l’Intervention</button>
        </div>
    </div>
</body>
</html>
<?php else: ?>
    <p style=\"padding: 20px;\">Intervention non trouvée.</p>
<?php endif; ?>
