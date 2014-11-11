<?php

require_once 'Mysql.php';

class Groups{
    
    private $id;
    private $name;
    private $private;
    private $readOnly;
    
    public function __construct($id){
        $this->id = $id;
        $query = "todo"; //Requête pour récupérer les informations en fonction de l'id utilisateur
        $result = "todo"; //Résultat 
        $this->name = $row['bl'];
        $this->private = $row['bl'];
        $this->readOnly = $row['bl'];
    }
    
    public function get($id){
        
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