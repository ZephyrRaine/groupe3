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
    <title>Liste des Annonces</title>
</head>
<body>
    <main>
        <?php
        global $dbh;

        if (!$dbh) {
            die("Connexion échouée");
        }

        $categories_stmt = $dbh->prepare("SELECT id, nom FROM categories");
        $categories_stmt->execute();
        $categories = $categories_stmt->fetchAll(PDO::FETCH_ASSOC);

        $selected_category = isset($_POST['category']) ? intval($_POST['category']) : 0;
        $search_term = isset($_POST['search']) ? trim($_POST['search']) : '';

        $sql = "SELECT annonces.id, annonces.titre, annonces.prix, categories.nom AS nom_categorie
                FROM annonces
                JOIN categories ON annonces.id_categorie = categories.id
                WHERE 1=1";

        if ($selected_category > 0) {
            $sql .= " AND annonces.id_categorie = :category";
        }

        if (!empty($search_term)) {
            $sql .= " AND annonces.titre LIKE :search";
        }

        $stmt = $dbh->prepare($sql);
        if ($selected_category > 0) {
            $stmt->bindParam(':category', $selected_category, PDO::PARAM_INT);
        }
        if (!empty($search_term)) {
            $search_term_with_wildcards = '%' . $search_term . '%';
            $stmt->bindParam(':search', $search_term_with_wildcards, PDO::PARAM_STR);
        }

        $stmt->execute();
        $annonces = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <form method="POST" action="page_liste_annonce.php">
            <label for="category">Catégorie :</label>
            <select name="category" id="category">
                <option value="0">Toutes</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>" <?php if ($category['id'] == $selected_category) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($category['nom']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <label for="search">Recherche :</label>
            <input type="text" name="search" id="search" value="<?php echo htmlspecialchars($search_term); ?>">
            
            <button type="submit">Filtrer</button>
        </form>

        <?php if (count($annonces) > 0): ?>
            <ul>
                <?php foreach ($annonces as $annonce): ?>
                    <li>
                        <a href="annonce.php?id=<?php echo $annonce['id']; ?>"><strong><?php echo htmlspecialchars($annonce['titre']); ?></strong></a><br>
                        Prix: <?php echo htmlspecialchars($annonce['prix']); ?> €<br>
                        Catégorie: <?php echo htmlspecialchars($annonce['nom_categorie']); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Aucune annonce trouvée.</p>
        <?php endif; ?>
    </main>

    <footer>
        <?php
        require_once(__DIR__ . '/footer.php');
        ?>
    </footer>
</body>
</html>
