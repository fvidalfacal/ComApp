<?php

require_once 'connexion.php';

class Group{
    
    private $id;
    private $name;
    private $private;
    private $readOnly;
    
    public function __construct($id){
        $this->id = $id;
        $query = "SELECT id, name, private, readOnly FROM groups WHERE id =?;"; //Requête pour récupérer les informations en fonction de l'id utilisateur
        //Résultats
        $result = Connexion::table($query, array($this->id));
        $this->name = $result[0]['name'];
        $this->private = $result[0]['private'];
        $this->readOnly = $result[0]['readOnly'];
    }
    
    public function getId(){
        return $this->id;
    }
    
    
    public function getName(){
        return $this->name;
    }
    
    public static function addGroups($groups){
        for($i=1;$i<=sizeof($groups);$i++){
            
            
        }
    }
    
    public function update(){
        
    }
    
    public function insert(){
        
    }
    
    public function delete(){
        
    }
            
}