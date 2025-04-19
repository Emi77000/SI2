<?php
// Démarrer la session
session_start();

// Détruire toutes les sessions
session_destroy();

// Rediriger vers la page de connexion
header("Location: login.php");
exit();
?>
