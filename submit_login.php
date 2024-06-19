<?php

session_start();
require_once(__DIR__ . '/BDD.php');


/**
 * On ne traite pas les super globales provenant de l'utilisateur directement,
 * ces données doivent être testées et vérifiées.
 */
$postData = $_POST;


$results = $dbh->prepare("SELECT id, email, mot_de_passe FROM utilisateurs");
$results->execute();
$users = $results->fetchAll(PDO::FETCH_ASSOC);

// Validation du formulaire
if (isset($postData['email']) &&  isset($postData['password'])) {
    $_SESSION['user_id'] = null;
    if (!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['LOGIN_ERROR_MESSAGE'] = 'Il faut un email valide pour soumettre le formulaire. ' . $postData['email'] . '<=';
    } else {
        foreach ($users as $user) {
            if (
                $user['email'] === $postData['email'] &&
                $user['mot_de_passe'] === $postData['password']
            ) {
                $_SESSION['user_id'] = $user['id'];
            }
        }

       
    }
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['LOGIN_ERROR_MESSAGE'] = sprintf(
            'Les iLnformations envoyées ne permettent pas de vous identifier : (%s/%s)',
            $postData['email'],
            strip_tags($postData['password']));
            header("Location: login.php");
            exit();
    }
    else
    {
        header("Location: accueil.php");
        exit();
    }
}