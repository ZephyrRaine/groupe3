<?php
session_start();

// Connexion à la base de données
$servername = '10.96.16.90';
$username = 'groupe3';
$password = "groupe3";
$dbname = 'groupe3';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Inscription des utilisateurs
if (isset($_POST['register'])) {
    $reg_username = $_POST['reg_username'];
    $reg_password = password_hash($_POST['reg_password'], PASSWORD_BCRYPT);
    $reg_firstname = $_POST['reg_firstname'];
    $reg_lastname = $_POST['reg_lastname'];
    $reg_email = $_POST['reg_email'];

    $sql = "INSERT INTO users (username, password, firstname, lastname, email, role) VALUES (?, ?, ?, ?, ?, 'public')";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    $stmt->bind_param("sssss", $reg_username, $reg_password, $reg_firstname, $reg_lastname, $reg_email);

    if ($stmt->execute()) {
        echo "Inscription réussie !";
    } else {
        echo "Erreur : " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

// Connexion des utilisateurs
if (isset($_POST['login'])) {
    $login_email = $_POST['login_email'];
    $login_password = $_POST['login_password'];

    $sql = "SELECT id, password, role FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $login_email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password, $role);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($login_password, $hashed_password)) {
            $_SESSION['userid'] = $id;
            $_SESSION['role'] = $role;

            // Redirection en fonction du rôle de l'utilisateur
            if ($role === 'public') {
                header("Location: single_page.php?profile=public");
            } elseif ($role === 'private') {
                header("Location: single_page.php?profile=private");
            } else {
                // Redirection par défaut si le rôle n'est pas spécifié
                header("Location: single_page.php?profile=unknown");
            }
            exit();
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Adresse email incorrecte.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion et Profil Utilisateur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
        }
        .container {
            width: 300px;
        }
        form {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"], input[type="password"], input[type="email"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!isset($_SESSION['userid'])): ?>
            <h2>Inscription</h2>
            <form action="" method="post">
                <label for="reg_username">Nom d'utilisateur :</label>
                <input type="text" id="reg_username" name="reg_username" required>
                <label for="reg_password">Mot de passe :</label>
                <input type="password" id="reg_password" name="reg_password" required>
                <label for="reg_firstname">Prénom :</label>
                <input type="text" id="reg_firstname" name="reg_firstname" required>
                <label for="reg_lastname">Nom :</label>
                <input type="text" id="reg_lastname" name="reg_lastname" required>
                <label for="reg_email">Email :</label>
                <input type="email" id="reg_email" name="reg_email" required>
                <input type="submit" name="register" value="S'inscrire">
            </form>

            <h2>Connexion</h2>
            <form action="" method="post">
                <label for="login_email">Adresse email :</label>
                <input type="email" id="login_email" name="login_email" required>
                <label for="login_password">Mot de passe :</label>
                <input type="password" id="login_password" name="login_password" required>
                <input type="submit" name="login" value="Se connecter">
            </form>
        <?php else: ?>
            <h1>Profil Utilisateur</h1>
            <?php
            // Affichage du profil en fonction du rôle de l'utilisateur
            if (isset($_GET['profile'])) {
                $profile_type = $_GET['profile'];
                switch ($profile_type) {
                    case 'public':
                        echo "<p>Bienvenue sur votre profil public !</p>";
                        break;
                    case 'private':
                        echo "<p>Bienvenue sur votre profil privé !</p>";
                        break;
                    default:
                        echo "<p>Profil inconnu.</p>";
                        break;
                }
            }
            ?>

            <p><a href="single_page.php?logout=true">Se déconnecter</a></p>
        <?php endif; ?>
    </div>
</body>
</html>