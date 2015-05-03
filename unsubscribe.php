<?php
session_start();
if (!isset($_SESSION['connect']) || $_SESSION['connect'] == false) {
    header("Location: login.php");
}
include ('includeClass.php');

//Récupération des informations de l'utilisateur et du groupe
$idGroup = $_GET['id'];
$idUser = $_SESSION['userId'];

//Suppresion de l'abonnement
$unsubscribe = Group::unsubscribe($idUser, $idGroup);

header('Location: index.php?settings');
