<?php
session_start();
include('class/Mysql.php');
include('bootstrap.min.css');

//Connexion à la base de données
$mysql = new Mysql();

//Récuperation des identifiants
$email = $_POST['email'];
$motDePasseCryptee = sha1($_POST['password']);

//Vérification des identifiants
$resultats = $mysql->TabResSQL('SELECT id, email,password, name , firstName FROM users WHERE email = "' . $email . '" AND password = "' . $motDePasseCryptee . '";');

if (sizeof($resultats) == 0) {
    ?>
    <div class = "alert alert-danger">
        Votre identifiant et/ou mot de passe sont érronés.<a href = "login.php" class = "alert-link"><br/>Retour à la page de connexion.</a>
    </div>
    <?php
} else {
    $_SESSION['connect'] = true;
    $_SESSION['user'] = $resultats[0]['firstName'] ." ".$resultats[0]['name'];
    $_SESSION['userId'] = $resultats[0]['id'];
    $_SESSION['email'] = $resultats[0]['email'];
    header('Location: index.php');
}
?>