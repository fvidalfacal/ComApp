<?php
session_start();
include('class/connexion.php');
?>
<html lang="en">
    <meta charset="utf-8">
    <head>
        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
        //Récuperation des identifiants
        $email = $_POST['email'];
        $motDePasseCryptee = sha1($_POST['password']);

        //Vérification des identifiants
        $query = 'SELECT id, email,password, name , firstName FROM users WHERE email = ? AND password = ?;';
        $results = Connexion::table($query, array($email, $motDePasseCryptee));

        if (sizeof($results) == 0) {
            ?>
            <div class = "alert alert-danger">
                Votre identifiant et/ou mot de passe sont érronés.<a href = "login.php" class = "alert-link"><br/>Retour à la page de connexion.</a>
            </div>
        </body>
    </html>
    <?php
} else {
    $_SESSION['connect'] = true;
    $_SESSION['user'] = $results[0]['firstName'] . " " . strtoupper($results[0]['name']);
    $_SESSION['userId'] = $results[0]['id'];
    $_SESSION['email'] = $results[0]['email'];
    header('Location: index.php');
}
?>