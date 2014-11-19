<?php

require_once 'Mysql.php';

class Groups{
    
    private $id;
    private $name;
    private $private;
    private $readOnly;
    
    public function __construct($id){
        $this->id = $id;
        $connexion = new Mysql();
        $query = "SELECT id, name, private, readOnly FROM Groups WHERE id ".$id.";"; //Requête pour récupérer les informations en fonction de l'id utilisateur
        $result = $connexion->TabResSQL($query); //Résultat 
        $this->name = $result[0]['name'];
        $this->private = $resut[0]['private'];
        $this->readOnly = $result[0]['readOnly'];
    }
    
    public function get($id){
        return $this->id;
    }
    
    public function getMessages(){
        
    }
    
    public function getUsers(){
        
    }
    
    public function update(){
        
    }
    
    public function insert(){
        
    }
    
    public function delete(){
        
    }
            
}