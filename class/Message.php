<?php

require_once 'Mysql.php';

class Message{
    
    private $id;
    private $content;
    private $date;
    private $idUser;
    
    public function __construct($id){
        $this->id = $id;
        $connexion = new Mysql();
        $query = "SELECT id, content, date, idUser FROM messages WHERE id = ".$id.";"; //Requête pour récupérer les informations en fonction de l'id utilisateur
        $result = $connexion->TabResSQL($query); //Résultat 
        $this->content = $result[0]['content'];
        $this->date = $result[0]['date'];
        $this->idUser = $result[0]['idUser'];
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
        //Connexion à la base de données
        $connexion = new Mysql();
        
        //Récupération des ids de groups sur usersGroup en fonction de l'utilisateur
        $sql='SELECT messages.date,messages.content, users.firstName, users.name FROM messagesGroup, messages, users 
                WHERE messagesGroup.idMessage = messages.id
                AND messages.idUser = users.id
                AND messagesGroup.idGroup='.$idHashtag.';';
        $results = $connexion->tabResSQL($sql);
        
        foreach ($results as $result) {
            $html.='<tr>';
            $html.='<td>'.$result['date'].'</td>';
            $html.='<td>'.$result['content'].'</td>';
            $html.='<td>'.$result['firstName'].' '.strtoupper($result['name']).'</td>';
            $html.='</tr>';
            //$html.='<li><a href="index.php?group='.$groups->getId().'"><i class="fa fa-slack"></i>'.$groups->getName().'</a></li>';
        }
        
        return $html;
    }
    
    public function sendNotification(){
        //@todo plus tard
    }
    
    public function update(){
        
    }
    
    public function insert(){
        
    }
    
    public function delete(){
        
    }
}