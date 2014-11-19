<?php

require_once 'Mysql.php';

class Messages{
    
    private $id;
    private $content;
    private $date;
    private $idUser;
    
    public function __construct($id){
        $this->id = $id;
        $connexion = new Mysql();
        $query = "SELECT id, content, date, idUser FROM Messages WHERE id = ".$id.";"; //Requête pour récupérer les informations en fonction de l'id utilisateur
        $result = $connexion->TabResSQL($query); //Résultat 
        $this->content = $result[0]['content'];
        $this->date = $result[0]['date'];
        $this->idUser = $result[0]['idUser'];
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