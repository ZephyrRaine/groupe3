<?php
session_start();

// Connexion à la base de données
$servername = '10.96.16.90';
$username = 'groupe3';
$password = "groupe3";
$dbname = 'groupe3';


$conn = new mysqli($servername, $username, $password, $dbname);

 

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}


// Gestion de la connexion utilisateur

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {

    $email = $_POST['email'];

    $password = $_POST['password'];

 

    // Utilisation des requêtes préparées pour éviter les injections SQL

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");

    $stmt->bind_param("ss", $email, $password);

    $stmt->execute();

    $result = $stmt->get_result();

 

    if ($result->num_rows > 0) {

        $user = $result->fetch_assoc();

        $_SESSION['user_id'] = $user['id'];

        redirectToUrl("accueil.php");

    } else {

        echo "Invalid credentials";

    }

    $stmt->close();

}

 

// Affichage du profil privé

if (isset($_SESSION['user_id'])) {

    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");

    $stmt->bind_param("i", $user_id);

    $stmt->execute();

    $user_result = $stmt->get_result();

    $user = $user_result->fetch_assoc();

 

    $stmt = $conn->prepare("SELECT * FROM posts WHERE user_id = ?");

    $stmt->bind_param("i", $user_id);

    $stmt->execute();

    $post_result = $stmt->get_result();

 

    $stmt = $conn->prepare("SELECT * FROM comments WHERE user_id = ?");

    $stmt->bind_param("i", $user_id);

    $stmt->execute();

    $comment_result = $stmt->get_result();

    $stmt->close();

}

?>

 

<!DOCTYPE html>

<html>

<head>

    <title>Profile Page</title>

</head>

<body>

 

<?php if (!isset($_SESSION['user_id'])): ?>

    <h1>Login</h1>

    <form method="post" action="accueil.php">

        <label for="email">Email:</label>

        <input type="email" id="email" name="email" required><br>

        <label for="password">Password:</label>

        <input type="password" id="password" name="password" required><br>

        <button type="submit" name="login">Login</button>

    </form>

<?php else: ?>

    <h1>Private Profile</h1>

    <p>Name: <?= htmlspecialchars($user['first_name'] . " " . $user['last_name']) ?></p>

    <p>Email: <?= htmlspecialchars($user['email']) ?></p>

    <p>Account created on: <?= htmlspecialchars($user['created_at']) ?></p>

 

    <h2>Your Posts</h2>

    <?php while($post = $post_result->fetch_assoc()): ?>

        <div>

            <h3><?= htmlspecialchars($post['title']) ?></h3>

            <p><?= htmlspecialchars($post['content']) ?></p>

            <p>Posted on: <?= htmlspecialchars($post['created_at']) ?></p>

        </div>

    <?php endwhile; ?>

 

    <h2>Your Comments</h2>

    <?php while($comment = $comment_result->fetch_assoc()): ?>

        <div>

            <p><?= htmlspecialchars($comment['content']) ?></p>

            <p>Commented on: <?= htmlspecialchars($comment['created_at']) ?></p>

        </div>

    <?php endwhile; ?>

 

    <a href="logout.php">Logout</a>

<?php endif; ?>

 

</body>

</html>

