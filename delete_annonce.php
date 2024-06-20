<?php
// Démarrer la session
session_start();

// Inclure le fichier de connexion à la base de données
require_once(__DIR__ . '/BDD.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Récupération de l'ID de l'annonce à partir de l'URL
$id_annonce = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Vérifier si l'ID de l'annonce est valide
if ($id_annonce <= 0) {
    header('Location: accueil.php');
    exit;
}

// Requête SQL pour vérifier si l'annonce appartient à l'utilisateur connecté
$sql = "SELECT id_utilisateur FROM annonces WHERE id = :id_annonce";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':id_annonce', $id_annonce, PDO::PARAM_INT);
$stmt->execute();
$annonce = $stmt->fetch(PDO::FETCH_ASSOC);

if ($annonce && $annonce['id_utilisateur'] == $_SESSION['user_id']) {
    // Requête SQL pour supprimer l'annonce
    $sql = "DELETE FROM annonces WHERE id = :id_annonce";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id_annonce', $id_annonce, PDO::PARAM_INT);
    $stmt->execute();

    // Rediriger vers la page d'accueil après la suppression
    header('Location: accueil.php');
    exit;
} else {
    // Rediriger vers la page d'accueil si l'annonce n'appartient pas à l'utilisateur
    header('Location: accueil.php');
    exit;
}
?>
