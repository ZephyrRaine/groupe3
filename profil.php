<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

require 'header.php';
$_SESSION['user']['id'] = 0;
// Connexion à la base de données (ajustez les paramètres de connexion selon votre configuration)
$pdo = new PDO('mysql:host=localhost;dbname=nom_de_la_base', 'utilisateur', 'mot_de_passe');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupération des dernières annonces de l'utilisateur
$stmt_annonces = $pdo->prepare('SELECT * FROM annonces WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 5');
$stmt_annonces->execute(['user_id' => $_SESSION['user']['id']]);
$annonces = $stmt_annonces->fetchAll(PDO::FETCH_ASSOC);

// Récupération des derniers commentaires de l'utilisateur
$stmt_commentaires = $pdo->prepare('SELECT * FROM commentaires WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 5');
$stmt_commentaires->execute(['user_id' => $_SESSION['user']['id']]);
$commentaires = $stmt_commentaires->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
</head>
<body>
    <h1>Profil de l'utilisateur</h1>
    <p>Nom: <?php echo htmlspecialchars($_SESSION['user']['last_name']); ?></p>
    <p>Prénom: <?php echo htmlspecialchars($_SESSION['user']['first_name']); ?></p>
    <p>Email: <?php echo htmlspecialchars($_SESSION['user']['email']); ?></p>
    <p>Adresse: <?php echo htmlspecialchars($_SESSION['user']['address']); ?></p>
    <p>Téléphone: <?php echo htmlspecialchars($_SESSION['user']['phone']); ?></p>
    
    <h2>Dernières annonces</h2>
    <ul>
        <?php foreach ($annonces as $annonce): ?>
            <li><?php echo htmlspecialchars($annonce['title']); ?> - <?php echo htmlspecialchars($annonce['created_at']); ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Derniers commentaires</h2>
    <ul>
        <?php foreach ($commentaires as $commentaire): ?>
            <li><?php echo htmlspecialchars($commentaire['content']); ?> - <?php echo htmlspecialchars($commentaire['created_at']); ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
