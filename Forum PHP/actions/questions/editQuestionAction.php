<?php

require('actions/database.php');

// Vérifier si la variable validate existe (donc que la personne a bien appuyé sur le bouton 'validate' pour éditer sa question)
if(isset($_POST['validate'])) {

    // Vérifier que les champs titre, description et content ne sont pas vides
    if(!empty($_POST['title']) AND !empty($_POST['description']) AND !empty($_POST['content'])) {

        // Les données à faire passer dans la requête
        $new_question_title = htmlspecialchars($_POST['title']);
        $new_question_description = nl2br(htmlspecialchars($_POST['description']));
        $new_question_content = nl2br(htmlspecialchars($_POST['content']));

        // Modifier les infos de la questions qui possèdent l'id rentré en paramêtre dans l'URL
        $editQuestionOnWebsite = $bdd->prepare('UPDATE questions SET title = ?, description = ?, content = ? WHERE id = ?');
        $editQuestionOnWebsite->execute(array($new_question_title, $new_question_description, $new_question_content, $idOfQuestion));

        // Redirection vers la page d'affichage des questions de l'utilisateur
        header('Location: my-questions.php');
        
    }else{
        $errorMsg = 'Veuillez compléter tous les champs';
    }

}