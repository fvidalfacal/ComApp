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
        $connexion = new Mysql();
        $query = "SELECT id, email, password, name, firstName FROM Users WHERE id = ".$id.";"; //Requête pour récupérer les informations en fonction de l'id utilisateur
        $result = $connexion->TabResSQL($query); //Résultat 
        $this->email = $result[0]['email'];
        $this->password = $result[0]['password'];
        $this->name = $result[0]['name'];
        $this->firstName = $result[0]['firstName'];
    }
    
    public function get($id){
        return $this->id;
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