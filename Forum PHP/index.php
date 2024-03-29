<?php
    session_start();
    require('actions/questions/showAllQuestionsAction.php');
    // require('actions/users/securityAction.php');
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'includes/head.php' ;?>
<body>
    <?php include 'includes/navbar.php' ;?>
    <br><br>

    <div class="container">
        <form method="GET">

            <!-- <input type="search" name="search">
            <button type="submit">Valider</button> -->

            <div class="form-group row">

                <div class="col-8">
                    <input type="search" name="search" class="form-control">
                </div>
                <div class="col-4">
                    <button class="btn btn-success">Rechercher</button>
                </div>

            </div>
        </form>

        <br>

        <?php
            while ($question = $getAllQuestions->fetch()) {
                ?>
                <div class="card">
                    <div class="card-header">
                        <a href="article.php?id=<?= $question['id'];?>">
                            <?= $question['title']; ?>
                        </a>
                    </div>
                    <div class="card-body">
                        <?= $question['description']; ?>
                    </div>
                    <div class="card-footer">
                        Publié par <a href="profile.php?id=<?= $question['id_author']; ?>"><?= $question['pseudo_auteur']; ?></a> le <?= $question['date_publication']; ?>
                    </div>
                </div><br>
                <?php
            }
        ?>

    </div>

</body>
</html>