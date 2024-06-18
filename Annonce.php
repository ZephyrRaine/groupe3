<?php
// Démarrer la session au début du fichier
session_start();

// Inclure les fichiers nécessaires
require_once(__DIR__ . '/BDD.php'); // Assurez-vous que ce fichier contient la connexion à la base de données
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
    <title>Annonce</title>
</head>
<body>
    <main>
        <?php
        // Utiliser la connexion globale à la base de données
        global $dbh;

        // Vérification de la connexion
        if (!$dbh) {
            die("Connexion échouée");
        }

        // Requête SQL pour récupérer toutes les annonces
        $sql = "SELECT annonces.titre, annonces.description, annonces.prix, annonces.date_publication, utilisateurs.nom AS nom_utilisateur, utilisateurs.prenom AS prenom_utilisateur, categories.nom AS nom_categorie
                FROM annonces
                JOIN utilisateurs ON annonces.id_utilisateur = utilisateurs.id
                JOIN categories ON annonces.id_categorie = categories.id";
        
        $stmt = $dbh->prepare($sql);
        if ($stmt === false) {
            die("Erreur de préparation de la requête: " . $dbh->errorInfo()[2]);
        }
        
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0) {
            // Affichage des détails de l'annonce
            foreach ($result as $row) {
                echo "<h1>" . htmlspecialchars($row['titre']) . "</h1>";
                echo "<p>Description: " . nl2br(htmlspecialchars($row['description'])) . "</p>";
                echo "<p>Prix: " . htmlspecialchars($row['prix']) . " €</p>";
                echo "<p>Date de publication: " . htmlspecialchars($row['date_publication']) . "</p>";
                echo "<p>Catégorie: " . htmlspecialchars($row['nom_categorie']) . "</p>";
                echo "<p>Publié par: " . htmlspecialchars($row['prenom_utilisateur']) . " " . htmlspecialchars($row['nom_utilisateur']) . "</p>";
            }
        } else {
            echo "<p>Aucune annonce trouvée.</p>";
        }
        ?>
    </main>

    <footer>
        <?php
        require_once(__DIR__ . '/footer.php');
        ?>
    </footer>
</body>
</html>
