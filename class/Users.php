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
        $query = "SELECT id, email, password, name, firstName FROM users WHERE id = ".$id.";"; //Requête pour récupérer les informations en fonction de l'id utilisateur
        $result = $connexion->TabResSQL($query); //Résultat 
        $this->email = $result[0]['email'];
        $this->password = $result[0]['password'];
        $this->name = $result[0]['name'];
        $this->firstName = $result[0]['firstName'];
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getGroups(){
        //Connexion à la base de données
        $connexion = new Mysql();
        
        //Récupération des ids de groups sur usersGroup en fonction de l'utilisateur
        $sql='SELECT * FROM usersGroup WHERE idUser='.$this->getId();
        $results = $connexion->tabResSQL($sql);
        
        //Récupération des noms de groupes et mise en place du html
        foreach ($results as $result) {
            $groups = new Groups($result['idGroup']);
            $html.='<li><a href="index.php?group='.$groups->getName().'">#'.$groups->getName().'</a></li>';
        }
        
        return $html;
    }
    
    public function update(){
        
    }
    
    public function insert(){
        
    }
    
    public function delete(){
        
    }


}