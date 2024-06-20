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
        
<?php
session_start();


// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    $errorMessage = "Vous n'êtes pas connecté.";
    $redirectLink = "login.php";
}
else {
    // Connexion à la base de données
    $servername = '10.96.16.90';
    $username = 'groupe3';
    $password = 'groupe3';
    $dbname = 'groupe3';

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Récupération des informations de l'utilisateur connecté
    $user_id = $_SESSION['user_id'];
    $sql_user = "SELECT * FROM utilisateurs WHERE id = ?";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("i", $user_id);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();
    $user = $result_user->fetch_assoc();

    if (!$user) {
        die("Utilisateur non trouvé");
    }

    // Fermer le statement
    $stmt_user->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
</head>
<body>
    <?php if (isset($errorMessage)): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; margin: 10px;">
            <?php echo htmlspecialchars($errorMessage); ?>
            <a href="<?php echo htmlspecialchars($redirectLink); ?>">Se connecter</a>
        </div>
    <?php else: ?>
        <h1>Profil de l'utilisateur</h1>
        <p>Nom: <?php echo htmlspecialchars($user['nom']); ?></p>
        <p>Prénom: <?php echo htmlspecialchars($user['prenom']); ?></p>
        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
        <p>Mot de passe: <?php echo htmlspecialchars($user['mot_de_passe']); ?></p>
        <p>Date d'inscription: <?php echo htmlspecialchars($user['date_inscription']); ?></p>
    <?php endif; ?>

</div>
    <!--pied de page -->
    <?php require_once(__DIR__ . '/footer.php'); ?>
</body>
</html>