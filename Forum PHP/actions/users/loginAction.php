<?php
session_start();
require('actions/database.php');

// Validation du formulaire
if(isset($_POST['validate'])){

    // Vérifier si l'user a bien complété tous les champs
    if(!empty($_POST['pseudo']) && !empty($_POST['password'])){

        // Les données de l'user
        $user_pseudo = htmlspecialchars($_POST['pseudo']);
        $user_password = htmlspecialchars($_POST['password']);

        // Vérifier si l'user existe (si le pseudo est correct)
        $checkIfUserExists = $bdd->prepare('SELECT * FROM users WHERE pseudo = ?');
        $checkIfUserExists->execute(array($user_pseudo));

        if($checkIfUserExists->rowCount() > 0){

            // Récupérer les données de l'utilisateur 
            $usersInfo = $checkIfUserExists->fetch();

            // Vérifier si le mot de passe est correct
            if(password_verify($user_password, $usersInfo['mdp'])){

                // Authentifier l'utilisateur sur le site et récupérer ses données dans la session
                $_SESSION['auth'] = true;
                $_SESSION['id'] = $usersInfo['id'];
                $_SESSION['lastname'] = $usersInfo['nom'];
                $_SESSION['firstname'] = $usersInfo['prenom'];
                $_SESSION['pseudo'] = $usersInfo['pseudo'];

                // Rediriger l'user vers la page d'accueil
                header('Location: index.php');

            }else{
                $errorMsg = 'Votre mot de passe est incorrect';
            }

        }else{
            $errorMsg = 'Votre pseudo est incorrect';
        }

    } else {
        $errorMsg = 'Veuillez répondre aux champs';
    }
}