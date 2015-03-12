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
    
    public static function getIdByName($name){
        $sql = 'SELECT id FROM groups WHERE name = ?';
        $result = Connexion::table($sql, array($name));
        return $result;
    }
    
    public function getName(){
        return $this->name;
    }
    
    public static function createGroups($groups){
        
        $groupsCreated = array();
        
        //Vérification si le hashtag existe déjà, si non on l'ajoute à la base de données
        
        foreach($groups as $group){
            $sqlVerif = "SELECT name FROM groups WHERE name = ?;";
            $result = Connexion::table($sqlVerif, array($group));
            if(empty($result)){
                $sqlAdd = "INSERT INTO groups(name) VALUES (?);";
                $query = Connexion::query($sqlAdd, array($group));
                $groupsCreated[] = $group;
            }
        }
        return $groupsCreated;
    }
    
    public static function createSubscription($userId,$content,$groups){
        $groupsId = array();
        var_dump($groups);
        foreach ($groups as $group) {
            
            //Avant cela on récupère l'id du groupe
            $groupId = self::getIdByName($group);
            $groupsId[] = $groupId[0]['id'];
            var_dump($groupId[0]['id']);
            var_dump($userId);
            //Et on insère
            $sqlSubscription = 'INSERT INTO usersGroup(idUser, idGroup) Values(?,?);';
            $resultSubscription = Connexion::query($sqlSubscription, array($userId,$groupId[0]['id']));
        }
        return $groupsId;
    }
    
    public function update(){
        
    }
    
    public function insert(){
        
    }
    
    public function delete(){
        
    }
            
}