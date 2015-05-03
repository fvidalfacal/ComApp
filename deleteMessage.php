<?php
session_start();
if (!isset($_SESSION['connect']) || $_SESSION['connect'] == false) {
    header("Location: login.php");
}
include ('includeClass.php');
?>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
        if ($_GET) {
            //Récupération des infos du message
            $idMessage = $_GET['id'];
            $from = $_GET['from'];
            $idUser = (isset($_SESSION['userId'])) ? $_SESSION['userId'] : null;

            //Suppression du messageg
            $deleteMessage = Message::deleteMessage($idMessage, $idUser);

            //Gestion de la suppression de message écrit par un autre utilisateur
            if ($deleteMessage) {
                header('Location: ' . $from);
            } else {
                $message = '<p class="bg-danger text-danger">Veuillez contacter l\'auteur de ce message si vous voulez qu\'il soit supprimé. Retour à <a href="index.php">l\'accueil</a></p>';
                echo $message;
            }
        }
        ?>
    </body>
</html>