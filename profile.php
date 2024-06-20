<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

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
    <h1>Profil de l'utilisateur</h1>
    <p>Nom: <?php echo htmlspecialchars($user['nom']); ?></p>
    <p>Prénom: <?php echo htmlspecialchars($user['prenom']); ?></p>
    <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
    <p>Mot de passe: <?php echo htmlspecialchars($user['mot_de_passe']); ?></p>
    <p>Date d'inscription: <?php echo htmlspecialchars($user['date_inscription']); ?></p>
</body>
</html>

<?php
// Fermer les connexions et les statements
$stmt_user->close();
$conn->close();
?>
