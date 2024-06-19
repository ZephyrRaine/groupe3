<?php
// Configuration de la base de données
$host = 'localhost';
$db   = 'votre_base_de_donnees';
$user = 'votre_utilisateur';
$pass = 'votre_mot_de_passe';
$charset = 'utf8mb4';

// Connexion à la base de données
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Récupération des données du formulaire
$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Préparation et exécution de la requête SQL
$sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
$stmt= $pdo->prepare($sql);
$stmt->execute([$username, $email, $password]);

echo "Inscription réussie !";
?>







<form method="get" action="">
<p>
    <label for="prenom">Votre prénom :</label>
    <label for="Nom">Votre nom :</label>
    <label for="prenom">Votre prénom :</label>
    <input type="email"></input>

</p>
</form>

<?php

//Profil User Private

$userName1="Your Name & surname";
echo "Pierre";
$userEmail1="mail@site.fr";
echo "Pierre@gmail.com";
$userDateRegistration1="MM/DD/YYYY";
echo "05/24/2018";

//Profil User Public
/*
$userName2="Your Name & surname" echo "Nom et Prénom";
$userEmail2="mail@site.fr" echo "votre mail";
$userDateRegistration2="MM/DD/YYYY" echo"date d'inscription";
*/




?>