<?php
// Démarrer la session
session_start();

// Inclure le fichier de connexion à la base de données
require_once(__DIR__ . '/BDD.php');
require_once(__DIR__ . '/header.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $categorie = $_POST['categorie'];
    $date_publication = date('Y-m-d');
    $id_utilisateur = $_SESSION['user_id'];

    // Préparer et exécuter la requête SQL pour insérer l'annonce
    $sql = "INSERT INTO annonces (titre, description, prix, date_publication, id_utilisateur, id_categorie) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$titre, $description, $prix, $date_publication, $id_utilisateur, $categorie]);

    // Rediriger vers la page de liste des annonces après l'insertion
    header('Location: page_liste_annonce.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une annonce</title>
</head>
<body>

<h1>Ajouter une nouvelle annonce</h1>

<form action="post_annonce.php" method="POST">
    <label for="titre">Titre :</label>
    <input type="text" id="titre" name="titre" required>
    <br>
    <label for="description">Description :</label>
    <textarea id="description" name="description" required></textarea>
    <br>
    <label for="prix">Prix :</label>
    <input type="number" id="prix" name="prix" step="0.01" required>
    <br>
    <label for="categorie">Catégorie :</label>
    <select id="categorie" name="categorie" required>
        <?php
        // Récupérer les catégories de la base de données
        $sql = "SELECT id, nom FROM categories";
        $stmt = $dbh->query($sql);
        while ($row = $stmt->fetch()) {
            echo '<option value="' . $row['id'] . '">' . $row['nom'] . '</option>';
        }
        ?>
    </select>
    <br>
    <button type="submit" class="btn btn-primary">Ajouter l'annonce</button>
</form>

</body>
</html>
