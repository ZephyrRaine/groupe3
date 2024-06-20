
    

<?php

require_once('BDD.php'); // Assurez-vous que ce fichier contient les informations de connexion à votre base de données

 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = $_POST['nom'];

    $prenom = $_POST['prenom'];

    $email = $_POST['email'];

    $mot_de_passe = $_POST['mot_de_passe']; // Récupération du mot de passe

    $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_BCRYPT);

     // Connexion à la base de données
     $servername = '10.96.16.90';
     $username = 'groupe3';
     $password = 'groupe3';
     $dbname = 'groupe3';

    // Connexion à la base de données

    $conn = new mysqli($servername, $username, $password, $dbname);

 

    // Vérifier la connexion

    if ($conn->connect_error) {

        die("Échec de la connexion : " . $conn->connect_error);

    }

 

    // Préparation de la requête

    $sql = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, date_inscription) VALUES (?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ssss", $nom, $prenom, $email, $mot_de_passe);

 

    // Exécution de la requête

    if ($stmt->execute()) {

        echo "Inscription réussie. <a href='login.php'>Cliquez ici pour vous connecter</a>";

    } else {

        echo "Erreur : " . $sql . "<br>" . $conn->error;

    }

 

    // Fermeture de la connexion

    $stmt->close();

    $conn->close();

}

?>

