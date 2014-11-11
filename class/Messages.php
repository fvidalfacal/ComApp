<?php

require_once 'Mysql.php';

class Messages{
    
    private $id;
    private $content;
    private $date;
    private $idUser;
    
    public function __construct($id){
        $this->id = $id;
        $query = "todo"; //Requête pour récupérer les informations en fonction de l'id utilisateur
        $result = "todo"; //Résultat 
        $this->content = $row['bl'];
        $this->date = $row['bl'];
        $this->idUser = $row['bl'];
    }
    
    public function get($id){
        
    }
    
    public function getGroups(){
        
    }
    
    public function getAuthor(){
        
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