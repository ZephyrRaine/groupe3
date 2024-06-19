    <!-- Barre de recherche -->
    <form method="GET" action="index.php" class="form-inline my-4">
        <input type="text" name="query" class="form-control mr-2" placeholder="Rechercher des annonces">
        <button type="submit" class="btn btn-primary">Rechercher</button>
    </form>
    
    <!-- Options de filtrage -->
    <div class="mb-4">
        <form method="GET" action="index.php" class="form-row">
            <div class="form-group col-md-3">
                <label for="categorie">Catégorie</label>
                <select id="categorie" name="categorie" class="form-control">
                    <option value="">Toutes les catégories</option>
                    <?php
                    $categories_stmt = $dbh->prepare("SELECT id, nom FROM categories");
                    $categories_stmt->execute();
                    $categories = $categories_stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($categories as $categorie) {
                        echo '<option value="' . htmlspecialchars($categorie['id']) . '">' . htmlspecialchars($categorie['nom']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="prix">Prix</label>
                <input type="number" id="prix" name="prix" class="form-control" placeholder="Prix max">
            </div>
            <div class="form-group col-md-3 align-self-end">
                <button type="submit" class="btn btn-secondary">Filtrer</button>
            </div>
        </form>
    </div>
    
    <!-- Affichage des annonces -->
    <div class="row">
        <?php
        if (!$dbh) {
            die("Connexion échouée");
        }

        $selected_category = isset($_GET['categorie']) ? intval($_GET['categorie']) : 0;
        $search_term = isset($_GET['query']) ? trim($_GET['query']) : '';
        $max_price = isset($_GET['prix']) ? floatval($_GET['prix']) : 0;

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

        if ($max_price > 0) {
            $sql .= " AND annonces.prix <= :max_price";
        }

        $stmt = $dbh->prepare($sql);
        if ($selected_category > 0) {
            $stmt->bindParam(':category', $selected_category, PDO::PARAM_INT);
        }
        if (!empty($search_term)) {
            $search_term_with_wildcards = '%' . $search_term . '%';
            $stmt->bindParam(':search', $search_term_with_wildcards, PDO::PARAM_STR);
        }
        if ($max_price > 0) {
            $stmt->bindParam(':max_price', $max_price, PDO::PARAM_STR);
        }

        $stmt->execute();
        $annonces = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($annonces as $annonce) {
            echo "<div class='col-md-4 mb-4'>";
            echo "<div class='card'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>" . htmlspecialchars($annonce['titre']) . "</h5>";
            echo "<p class='card-text'>Prix: " . htmlspecialchars($annonce['prix']) . " €</p>";
            echo "<p class='card-text'>Catégorie: " . htmlspecialchars($annonce['nom_categorie']) . "</p>";
            echo "<a href='annonce.php?id=" . htmlspecialchars($annonce['id']) . "' class='btn btn-primary'>Voir l'annonce</a>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>

    <!-- Bouton pour publier une annonce -->
    <div class="mt-4">
        <a href="publish.php" class="btn btn-success">Publier une annonce</a>
    </div>