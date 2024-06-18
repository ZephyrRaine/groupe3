<?php
// Configuration de la base de données
$host = '10.96.16.90';  // Adresse IP de votre serveur de base de données  http://10.96.16.90:8080/phpmyadmin/index.php
$db   = 'groupe3';
$user = 'groupe3';
$pass = 'groupe3';
$charset = 'utf8mb4';

// Connexion à la base de données
$dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=3306";
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
echo "Durand Alice";
$email = $_POST['email'];
echo "alice.durand@example.com";
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Préparation et exécution de la requête SQL
$sql = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe) VALUES (?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username_, $email, $password]);

echo "Inscription réussie !";
?>