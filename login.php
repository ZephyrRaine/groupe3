<!DOCTYPE html>
<html>
<head>
    
    <title>Page d'accueil</title>
    <link
    
    >
        <!-- Inclusion de Bootstrap pour le style -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Inclusion de jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Inclusion de Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>

<body class="">
    <div class="container">
        <?php require_once(__DIR__ . '/header.php'); ?>
        <h1></h1>
   <!-- Le corps -->
    </div>
    <div id="corps">
       
        
        <?php if (!isset($_SESSION['LOGGED_USER'])) : ?>
            <?php 
                if(isset($_SESSION['LOGIN_ERROR_MESSAGE']))
                    echo $_SESSION['LOGIN_ERROR_MESSAGE']; ?>

            <form action="submit_login.php" method="POST">
                <!-- si message d'erreur on l'affiche -->
                <?php if (isset($_SESSION['LOGIN_ERROR_MESSAGE'])) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION['LOGIN_ERROR_MESSAGE'];
                        unset($_SESSION['LOGIN_ERROR_MESSAGE']); ?>
                    </div>
                <?php endif; ?>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="email-help" placeholder="you@exemple.com">
                    <div id="email-help" class="form-text">L'email utilisé lors de la création de compte.</div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
            <!-- Si utilisateur/trice bien connectée on affiche un message de succès -->
        <?php else : ?>
            <div class="alert alert-success" role="alert">
                Bonjour <?php echo $_SESSION['LOGGED_USER']['email']; ?> et bienvenue sur le site !
            </div>
        <?php endif; ?>


    
    </div>
    <!--pied de page -->
    <?php require_once(__DIR__ . '/footer.php'); ?>
</body>
</html>
