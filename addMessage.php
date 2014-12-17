<?php
session_start();
if (!isset($_SESSION['connect']) || $_SESSION['connect'] == false) {
    header("Location: login.php");
}
include ('includeClass.php');

$contentMessage = $_POST['content'];
$userId = $_SESSION['userId'];

$addMessage = Message::insertMessage($userId, $contentMessage);
   

?>