<?php
// Démarrer la session au début du fichier
session_start();

// Inclure les fichiers nécessaires pour la base de données et le header
require_once(__DIR__ . '/BDD.php');
require_once(__DIR__ . '/header.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Description de votre site ou page">
    <meta name="keywords" content="mots-clés, séparés, par, des, virgules">
    <meta name="author" content="Votre Nom">
    <title>Accueil</title>

    <!-- Inclusion de Bootstrap pour le style -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Inclusion de jQuery -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Inclusion de Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <h1 class="mt-4">Lemauvaiscoin</h1>
    
</div>

<div>
    <?php 
    require_once(__DIR__ . 'page_liste_annonce.php')
    ?>
</div>

</body>
</html>

