<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airblio</title>
    <style>
        @font-face {
            font-family: 'Sensation Light';
            src: url('SensationLight.ttf') format('truetype');
        }
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');
        body {
            background-color: #126782;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Roboto', sans-serif;
            flex-direction: column;
        }
        h1 {
            color: white;
            margin-bottom: 20px;
            font-size: 4em;
            font-family: 'Playfair Display', serif;
        }
        .container {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .login-box {
            background-color: #219EBC;
            padding: 40px 60px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h2 {
            color: white;
            margin-bottom: 20px;
            font-size: 1.5em;
        }
        form {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        input[type="email"], input[type="password"] {
            width: 80%;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: none;
            font-size: 1em;
        }
        label {
            color: white;
            margin-bottom: 20px;
        }
        input[type="checkbox"] {
            margin-right: 10px;
        }
        button {
            background-color: #023047;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }
        button:hover {
            background-color: #023047;
        }
    </style>
</head>
<body>
    <h1>Airblio</h1>
    <div class="container">
        <div class="login-box">
            <h2>Connexion</h2>
            <form method="post">
                <input type="email" name="email" placeholder="Email" required><br>
                <input type="password" name="password" placeholder="Mot de passe" required><br>
                <label><input type="checkbox" name="remember"> Se souvenir de moi</label><br>
                <button type="submit">Se connecter</button>
            </form>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Rediriger vers la page d'accueil
                header("Location: accueil.php");
                exit();
            }
            ?>
        </div>
    </div>
</body>
</html>