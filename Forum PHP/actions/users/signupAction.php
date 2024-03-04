<?php
session_start();
require ('actions/database.php');

// Validation du formulaire
if(isset($_POST['validate'])){

    // Vérifier si l'utilisateur a bien complété tous les champs
    if(!empty($_POST['pseudo']) && !empty($_POST['lastname']) && !empty($_POST['firstname'])){

        // Les données de l'user
        $user_pseudo = htmlspecialchars($_POST['pseudo']);
        $user_lastname = htmlspecialchars($_POST['lastname']);
        $user_firstname = htmlspecialchars($_POST['firstname']);
        $user_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Vérifier si l'utilisateur existe déjà sur le site
        $checkIfUserAlreadyExists = $bdd->prepare('SELECT pseudo FROM users WHERE pseudo = ?');
        $checkIfUserAlreadyExists->execute(array($user_pseudo));

        if($checkIfUserAlreadyExists->rowCount() == 0){

            // Insérer l'utilisateur dans la bdd
            $insertUserOnWebsite = $bdd->prepare('INSERT INTO users(pseudo, nom, prenom, mdp) VALUES (?, ?, ?, ?)');
            $insertUserOnWebsite->execute(array($user_pseudo, $user_lastname, $user_firstname, $user_password));

            // Récupérer les infos de l'utilisateur
            $getInfoOfThisUserReq = $bdd->prepare('SELECT id, pseudo, nom, prenom FROM users WHERE nom = ? AND prenom = ? AND pseudo = ?');
            $getInfoOfThisUserReq->execute(array($user_lastname, $user_firstname, $user_pseudo));

            $usersInfo = $getInfoOfThisUserReq->fetch();

            // Authentifier l'utilisateur sur le site et récupérer ses données dans la session
            $_SESSION['auth'] = true;
            $_SESSION['id'] = $usersInfo['id'];
            $_SESSION['lastname'] = $usersInfo['nom'];
            $_SESSION['firstname'] = $usersInfo['prenom'];
            $_SESSION['pseudo'] = $usersInfo['pseudo'];

            // Rediriger l'utilisateur dans l'accueil
            header('Location: index.php');

        }else{
            $errorMsg = "Ce nom d'utilisateur existe déjà";
        }

    } else {
        $errorMsg = 'Veuillez répondre aux champs';
    }
}