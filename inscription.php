<!DOCTYPE html>
<html>
<head>
    
    <title>Page d'accueil</title>
    <link
    
    >
</head>
<body class="">
    <div class="container">
        <?php require_once(__DIR__ . '/header.php'); ?>
        <h1></h1>
   <!-- Le corps -->
    </div>
    <div id="corps">
       


<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Inscription</title>

</head>

<body>

    <h1>Formulaire d'inscription</h1>

    <form action="submit_inscription.php" method="post">

        <label for="nom">Nom :</label>

        <input type="text" id="nom" name="nom" required><br><br>

 

        <label for="prenom">Prénom :</label>

        <input type="text" id="prenom" name="prenom" required><br><br>

 

        <label for="email">Email :</label>

        <input type="email" id="email" name="email" required><br><br>

 

        <label for="mot_de_passe">Mot de passe :</label>

        <input type="password" id="mot_de_passe" name="mot_de_passe" required><br><br>

 

        <input type="submit" value="S'inscrire">

    </form>

</body>
</div>
    <!--pied de page -->
    <?php require_once(__DIR__ . '/footer.php'); ?>
</body>
</html>

</html>