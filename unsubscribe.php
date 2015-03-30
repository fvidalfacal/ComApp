<?php
session_start();
if (!isset($_SESSION['connect']) || $_SESSION['connect'] == false) {
    header("Location: login.php");
}
include ('includeClass.php');


$idGroup = $_GET['id'];
$idUser = $_SESSION['userId'];

$unsubscribe = Group::unsubscribe($idUser, $idGroup);

header('Location: index.php?settings');
