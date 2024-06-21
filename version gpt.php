<!DOCTYPE html>

<html>

<head>

    <title>Page de profil</title>

</head>

<body>



<?php
session_start();
require_once('BDD.php');



// Affichage du profil privé
if (isset($_SESSION['user_id'])) {
   
    $utilisateurs_id = $_SESSION['user_id'];
    echo $utilisateurs_id;
    $sql = "SELECT * FROM utilisateurs WHERE id = '$utilisateurs_id'";

    $utilisateurs_result = $dbh->query($sql);

    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $utilisateurs = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $annonces_sql = "SELECT * FROM annonces WHERE id_utilisateur = '$utilisateurs_id'";
    $annonces_result = $dbh->prepare($annonces_sql);
    $annonces_result->execute();
    $annonces = $annonces_result->fetchAll(PDO::FETCH_ASSOC);

    $commentaires_sql = "SELECT * FROM commentaires WHERE id_utilisateur = '$utilisateurs_id'";
    $commentaires_result = $dbh->prepare($commentaires_sql);
    $commentaires_result->execute();
    $commentaires = $commentaires_result->fetchAll(PDO::FETCH_ASSOC);
}
 

// Affichage du profil public
if (isset($_GET['user_id'])) {
    
    $public_utilisateur_id = $_GET['user_id'];
    echo $utilisateurs_id;

    $sql = "SELECT * FROM utilisateurs WHERE utilisateurs.id = '$public_utilisateur_id'";

    $public_utilisateurs_result = $dbh->query($sql);

    $public_utilisateurs = $public_utilisateurs_result->fetch(PDO::FETCH_ASSOC);
    

    $public_annonces_sql = "SELECT * FROM annonces WHERE id_utilisateur = '$public_utilisateur_id'";
    $public_annonces_result = $dbh->prepare($public_annonces_sql);
    $public_annonces_result->execute();
    $public_annonces = $public_annonces_result->fetchAll(PDO::FETCH_ASSOC);
}

?>

 

<?php 


if (!isset($_SESSION['user_id'])): ?>

    <h1>Inscription</h1>

    <form method="annonces" action="Annonce.php">

        <label for="email">Email:</label>

        <input type="email" id="email" nom="email" required><br>

        <label for="password">Password:</label>

        <input type="password" id="password" nom="password" required><br>

        <button type="submit" nom="login">Login</button>

    </form>

<?php else: ?>

    <h1>Private Profile</h1>

    <p>Nom: <?php $utilisateurs['prenom'] ?? 'lol' . " " . $utilisateurs['nom']  ?? 'lol' ?></p>

    <p>Email: <?= $utilisateurs['email'] ?></p>

    <p>Account created on: <?=$utilisateurs['date_inscription']?></p>

 

    <h2>Vos annonces</h2>

    

    <?php 
    
    
    
    foreach($annonces as $annonce)
    { ?>
        <div>

            <h3><?= $annonce['titre'] ?></h3>

            <p><?= $annonce['description'] ?></p>

            <p>Posted on: <?= $annonce['date_publication'] ?></p>

            
        </div>

    <?php }; ?>

 

    <h2>Vos commentaires</h2>

    <?php
    foreach($commentaires as $commentaire)
    { ?>
        <div>

            <h3><?= $commentaire['id_annonce'] ?></h3>

            <p><?= $commentaire['contenu'] ?></p>

            <p>Posted on: <?= $commentaire['date_commentaire'] ?></p>

        </div>

    <?php }; ?>

    
 

    <a href="logout.php">Logout</a>

<?php endif; ?>

 

<?php if (isset($public_utilisateur_id)): ?>

    <h1>Profil publique</h1>

    <p>Name: <?= $public_utilisateurs['prenom'] . " " . $public_utilisateurs['nom'] ?></p>

    <p>Account created on: <?= $public_utilisateurs['date_inscription'] ?></p>

 

    <h2>Posts</h2>

    <?php 
    foreach($public_annonces as $public_annonce) 
    { ?>

        <div>
            <h3><?= $public_annonce['titre'] ?></h3>

            <p><?= $public_annonce['description'] ?></p>

            <p>Posted on: <?= $public_annonce['date_publication'] ?></p>

        </div>

    <?php } ?>

<?php endif; ?>
</body>
</html>