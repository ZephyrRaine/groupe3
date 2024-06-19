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

 

    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";

    $result = $conn->query($sql);

 

    if ($result->num_rows > 0) {

        $user = $result->fetch_assoc();

        $_SESSION['user_id'] = $user['id'];

        header("Location: index.php");

    } else {

        echo "Invalid credentials";

    }

}

 

// Affichage du profil privé

if (isset($_SESSION['user_id'])) {

    $user_id = $_SESSION['user_id'];

    $sql = "SELECT * FROM users WHERE id = '$user_id'";

    $user_result = $conn->query($sql);

    $user = $user_result->fetch_assoc();

 

    $post_sql = "SELECT * FROM posts WHERE user_id = '$user_id'";

    $post_result = $conn->query($post_sql);

 

    $comment_sql = "SELECT * FROM comments WHERE user_id = '$user_id'";

    $comment_result = $conn->query($comment_sql);

}

 

// Affichage du profil public

if (isset($_GET['user_id'])) {

    $public_user_id = $_GET['user_id'];

    $sql = "SELECT * FROM users WHERE id = '$public_user_id'";

    $public_user_result = $conn->query($sql);

    $public_user = $public_user_result->fetch_assoc();

 

    $public_post_sql = "SELECT * FROM posts WHERE user_id = '$public_user_id'";

    $public_post_result = $conn->query($public_post_sql);

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

    <form method="post" action="index.php">

        <label for="email">Email:</label>

        <input type="email" id="email" name="email" required><br>

        <label for="password">Password:</label>

        <input type="password" id="password" name="password" required><br>

        <button type="submit" name="login">Login</button>

    </form>

<?php else: ?>

    <h1>Private Profile</h1>

    <p>Name: <?= $user['first_name'] . " " . $user['last_name'] ?></p>

    <p>Email: <?= $user['email'] ?></p>

    <p>Account created on: <?= $user['created_at'] ?></p>

 

    <h2>Your Posts</h2>

    <?php while($post = $post_result->fetch_assoc()): ?>

        <div>

            <h3><?= $post['title'] ?></h3>

            <p><?= $post['content'] ?></p>

            <p>Posted on: <?= $post['created_at'] ?></p>

        </div>

    <?php endwhile; ?>

 

    <h2>Your Comments</h2>

    <?php while($comment = $comment_result->fetch_assoc()): ?>

        <div>

            <p><?= $comment['content'] ?></p>

            <p>Commented on: <?= $comment['created_at'] ?></p>

        </div>

    <?php endwhile; ?>

 

    <a href="logout.php">Logout</a>

<?php endif; ?>

 

<?php if (isset($public_user)): ?>

    <h1>Public Profile</h1>

    <p>Name: <?= $public_user['first_name'] . " " . $public_user['last_name'] ?></p>

    <p>Account created on: <?= $public_user['created_at'] ?></p>

 

    <h2>Posts</h2>

    <?php while($post = $public_post_result->fetch_assoc()): ?>

        <div>

            <h3><?= $post['title'] ?></h3>

            <p><?= $post['content'] ?></p>

            <p>Posted on: <?= $post['created_at'] ?></p>

        </div>

    <?php endwhile; ?>

<?php endif; ?>

 

</body>

</html>