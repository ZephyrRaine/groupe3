<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Description de votre site ou page">
    <meta name="keywords" content="mots-clés, séparés, par, des, virgules">
    <meta name="author" content="Votre Nom">
    <title>Accueil</title>

    <?php
    require_once(__DIR__ . '/BDD.php');
    ?>

    <!-- Inclusion de Bootstrap pour le style -->
    <link rel="stylesheet" href=https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css>
    <!-- Inclusion de jQuery -->
    <script src=https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js></script>
    <!-- Inclusion de Bootstrap JS -->
    <script src=https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js></script>
</head>
<body>

<div class="container">
    <h1 class="mt-4">Lemauvaiscoin</h1>
    
    <!-- Barre de recherche -->
    <form method="GET" action="search.php" class="form-inline my-4">
        <input type="text" name="query" class="form-control mr-2" placeholder="Rechercher des annonces">
        <button type="submit" class="btn btn-primary">Rechercher</button>
    </form>
    
    <!-- Options de filtrage -->
    <div class="mb-4">
        <form method="GET" action="filter.php" class="form-row">
            <div class="form-group col-md-3">
                <label for="categorie">Catégorie</label>
                <select id="categorie" name="categorie" class="form-control">
                    <option value="">Toutes les catégories</option>
                    <option value="immobilier">Immobilier</option>
                    <option value="vehicules">Véhicules</option>
                    <option value="informatique">Informatique</option>
                    <option value="electromenager">Électroménager</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="prix">Prix</label>
                <input type="number" id="prix" name="prix" class="form-control" placeholder="Prix max">
            </div>
            <div class="form-group col-md-3">
                <label for="localisation">Localisation</label>
                <input type="text" id="localisation" name="localisation" class="form-control" placeholder="Localisation">
            </div>
            <div class="form-group col-md-3 align-self-end">
                <button type="submit" class="btn btn-secondary">Filtrer</button>
            </div>
        </form>
    </div>
    
    <!-- Affichage des annonces -->
    <div class="row">
        <?php
        // Exemples d'annonces
        $annonces = [
            [
                'titre' => 'Appartement à louer',
                'description' => 'Un bel appartement à louer au centre-ville.',
                'categorie' => 'immobilier',
                'prix' => 750,
                'localisation' => 'Paris'
            ],
            [
                'titre' => 'Voiture d\'occasion',
                'description' => 'Voiture en bon état, peu de kilomètres.',
                'categorie' => 'vehicules',
                'prix' => 5000,
                'localisation' => 'Lyon'
            ],
            [
                'titre' => 'Ordinateur portable',
                'description' => 'Ordinateur portable performant, comme neuf.',
                'categorie' => 'informatique',
                'prix' => 1200,
                'localisation' => 'Marseille'
            ]
        ];

        foreach ($annonces as $annonce) {
            echo "
            <div class='col-md-4'>
                <div class='card mb-4'>
                    <div class='card-body'>
                        <h5 class='card-title'>{$annonce['titre']}</h5>
                        <p class='card-text'>{$annonce['description']}</p>
                        <p class='card-text'><strong>Catégorie:</strong> {$annonce['categorie']}</p>
                        <p class='card-text'><strong>Prix:</strong> {$annonce['prix']} €</p>
                        <p class='card-text'><strong>Localisation:</strong> {$annonce['localisation']}</p>
                    </div>
                </div>
            </div>
            ";
        }
        ?>
    </div>

    <!-- Bouton pour publier une annonce -->
    <div class="mt-4">
        <a href="publish.php" class="btn btn-success">Publier une annonce</a>
    </div>
</div>

</body>
</html>
