<?php

require_once 'Mysql.php';

class Users{

    private $id;
    private $email;
    private $password;
    private $name;
    private $firstName;

    public function __construct($id){
        $this->id = $id;
        $query = "todo"; //Requête pour récupérer les informations en fonction de l'id utilisateur
        $result = "todo"; //Résultat 
        $this->email = $row['bl'];
        $this->password = $row['bl'];
        $this->name = $row['bl'];
        $this->firstName = $row['bl'];
    }
    
    public function get($id){
        
    }
    
    public function getGroups(){
        
    }
    
    public function update(){
        
    }
    
    public function insert(){
        
    }
    
    public function delete(){
        
    }


}