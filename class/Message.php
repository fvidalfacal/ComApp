<?php

require_once 'connexion.php';

class Message{
    
    private $id;
    private $content;
    private $date;
    private $idUser;
    
    public function __construct($id){
        $this->id = $id;
        //Requête pour récupérer les informations en fonction de l'id utilisateur
        $query = "SELECT id, content, date, idUser FROM messages WHERE id = ?;"; 
        //Résultats
        $results = Connexion::table($query, array($this->id));
        $this->content = $results[0]['content'];
        $this->date = $results[0]['date'];
        $this->idUser = $results[0]['idUser'];
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getGroups(){
        
    }
    
    public function getAuthor(){
        $idAuthor = $this->idUser;
        $user= new User($idAuthor);
        return $user;
    }
    
    public static function getMessagesByIdHashtag($idHashtag){
        $html = "";
        //Récupération des ids de groups sur usersGroup en fonction de l'utilisateur
        $sql='SELECT messages.date,messages.content, users.firstName, users.name FROM messagesGroup, messages, users 
                WHERE messagesGroup.idMessage = messages.id
                AND messages.idUser = users.id
                AND messagesGroup.idGroup=?
                ORDER BY messages.date;';
        $results = Connexion::table($sql, array($idHashtag));
        
        foreach ($results as $result) {
            $html.='<tr>';
            $html.='<td>'.$result['date'].'</td>';
            $html.='<td>'.$result['content'].'</td>';
            $html.='<td>'.$result['firstName'].' '.strtoupper($result['name']).'</td>';
            $html.='</tr>';
            //$html.='<li><a href="index.php?group='.$groups->getId().'"><i class="fa fa-slack"></i>'.$groups->getName().'</a></li>';
        }
        
        return utf8_encode($html);
    }
    
    public function sendNotification(){
        //@todo plus tard
    }
    
    public function update(){
        
    }
    
    public static function insertMessage($userId,$content){
        $date = date('Y-m-d H-i-s');
        
        //Ajout du message dans la base de données
        $sql= "INSERT INTO messages(content, date, idUser)
               VALUES (?,?,?)";
        $results = Connexion::query($sql, array($content,$date,$userId));
        
        $searchGroup = Message::searchGroup($content);
        return $searchGroup;
    }
    
    public static function searchGroup($contentMessage){
        $explodeGroups = explode('#', $contentMessage);
        unset($explodeGroups[0]);
        var_dump($explodeGroups);
        
        ECHO '------';
        
        foreach($explodeGroups as $explodeGroup){
            $explodeSpace = explode(' ', $explodeGroup);
            var_dump($explodeGroup);
            $groups[] = $explodeSpace[0];
        }
        ECHO '------';
        var_dump($groups);
        $addGroups = Group::addGroups($groups);
        return $addGroups;
    }
    
}