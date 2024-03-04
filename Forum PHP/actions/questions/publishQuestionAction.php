<?php

require('actions/database.php');

// Vérifier si un formulaire a été validé
if(isset($_POST['validate'])){

    // Vérifier que les champs ne sont pas vides
    if(!empty($_POST['title']) AND !empty($_POST['description']) AND !empty($_POST['content'])){

        // Les données de la question
        $question_title = htmlspecialchars($_POST['title']);
        $question_description = nl2br(htmlspecialchars($_POST['description']));
        $question_content = nl2br(htmlspecialchars($_POST['content']));
        $question_date = date('d/m/Y');
        $question_id_author = $_SESSION['id'];
        $question_pseudo_author = $_SESSION['pseudo'];

        // Insérer la question 
        $insertQuestionOnWebsite = $bdd->prepare('INSERT INTO questions(title, description, content, id_author, pseudo_auteur, date_publication) VALUES (?, ?, ?, ?, ?, ?)');
        $insertQuestionOnWebsite->execute([$question_title, $question_description, $question_content, $question_id_author, $question_pseudo_author, $question_date]);

        $succesMsg = "Votre question a bien été publiée sur le site";

    }else{
        $errorMsg = "Veuillez compléter tous les champs";
    }
}