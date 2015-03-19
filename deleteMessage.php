<?php
session_start();
if (!isset($_SESSION['connect']) || $_SESSION['connect'] == false) {
    header("Location: login.php");
}
include ('includeClass.php');

if($_GET){
    $idMessage = $_GET['id'];
    $from = $_GET['from'];
    $idUser = (isset($_SESSION['idUser'])) ? $_SESSION['idUser'] : null;
    
    $deleteMessage = Message::deleteMessage($idMessage, $idUser);
    
    
    if($deleteMessage){
        header('Location: '.$from);
    }else{
        echo 'message d\'erreur';
    }
}

?>