<?php

// Vérifier si l'utilisateur est authentifié au niveau du site
session_start();
if(!isset($_SESSION['auth'])){
    header('Location: ../../login.php');
}

require('../database.php');

// Vérifier si l'id est rentré en paramètre dans l'URL
if(isset($_GET['id']) AND !empty($_GET['id'])){

    // L'id de la question en paramètre
    $idOfTheQuestion = $_GET['id'];

    // Vérifier si la question existe
    $checkIfQuestionExists = $bdd->prepare('SELECT id_author FROM questions WHERE id = ?');
    $checkIfQuestionExists->execute(array($idOfTheQuestion));

    if ($checkIfQuestionExists->rowCount() > 0){

        // Récupérer les infos de la question
        $questionsInfos = $checkIfQuestionExists->fetch();
        if($questionsInfos['id_author'] == $_SESSION['id']){

            //  Supprimer la question en fonction de son id rentré en paramètre
            $deleteThisQuestion = $bdd->prepare('DELETE FROM questions WHERE id = ?');
            $deleteThisQuestion->execute(array($idOfTheQuestion));

            header('Location: ../../my-questions.php');

        }else{
            $errorMsg = "Vous n'avez pas le droit de supprimer une question qui ne vous appartient pas !";
        }
        
    }else{
        $errorMsg = "Aucune question n'a été trouvée";
    }

}else{
    $errorMsg = "Aucune question n'a été trouvée";
}