<?php
require('actions/database.php');

// Vérifier si l'id de la question est rentré dans l'URL
if(isset($_GET['id']) AND !empty($_GET['id'])){

    //  Récupérer l'id de la question
    $idOfTheQuestion = $_GET['id'];

    // Vérifier si la question existe
    $checkIfQuestionExists = $bdd->prepare('SELECT * FROM questions WHERE id = ?');
    $checkIfQuestionExists->execute(array($idOfTheQuestion));

    if($checkIfQuestionExists->rowCount() > 0){

        // Récupérer toutes les datas de la question
        $questionsInfo = $checkIfQuestionExists->fetch();

        // Stocker les datas de la question dans des variables propres
        $question_title = $questionsInfo['title'];
        $question_content = $questionsInfo['content'];
        $question_id_author = $questionsInfo['id_author'];
        $question_pseudo_auteur = $questionsInfo['pseudo_auteur'];
        $question_publication_date = $questionsInfo['date_publication'];

    }else{
        $errorMsg = "Aucune question n'a été trouvée";
    }

}else{
    $errorMsg = "Aucune question n'a été trouvée";
}