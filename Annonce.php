<?php
// Démarrer la session au début du fichier
session_start();

// Inclure les fichiers nécessaires
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
    <title>Annonce</title>
</head>
<body>
    <main>
        <?php
        global $dbh;

        if (!$dbh) {
            die("Connexion échouée");
        }

        // Récupération de l'ID de l'annonce à partir de l'URL
        $id_annonce = isset($_GET['id']) ? intval($_GET['id']) : 0;

        // Requête SQL pour récupérer les détails de l'annonce
        $sql = "SELECT annonces.titre, annonces.description, annonces.prix, annonces.date_publication, utilisateurs.nom AS nom_utilisateur, utilisateurs.prenom AS prenom_utilisateur, categories.nom AS nom_categorie
                FROM annonces
                JOIN utilisateurs ON annonces.id_utilisateur = utilisateurs.id
                JOIN categories ON annonces.id_categorie = categories.id
                WHERE annonces.id = :id_annonce";
        
        $stmt = $dbh->prepare($sql);
        if ($stmt === false) {
            die("Erreur de préparation de la requête: " . $dbh->errorInfo()[2]);
        }
        
        $stmt->bindParam(':id_annonce', $id_annonce, PDO::PARAM_INT);
        $stmt->execute();
        $annonce = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($annonce) {
            // Affichage des détails de l'annonce
            echo "<h1>" . htmlspecialchars($annonce['titre']) . "</h1>";
            echo "<p>Description: " . nl2br(htmlspecialchars($annonce['description'])) . "</p>";
            echo "<p>Prix: " . htmlspecialchars($annonce['prix']) . " €</p>";
            echo "<p>Date de publication: " . htmlspecialchars($annonce['date_publication']) . "</p>";
            echo "<p>Catégorie: " . htmlspecialchars($annonce['nom_categorie']) . "</p>";
            echo "<p>Publié par: " . htmlspecialchars($annonce['prenom_utilisateur']) . " " . htmlspecialchars($annonce['nom_utilisateur']) . "</p>";
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
