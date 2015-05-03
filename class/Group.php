<?php

require_once 'connexion.php';

class Group {

    private $id;
    private $name;

    /**
     * 
     * @param int $id, l'identifiant du groupe qui permet de créer l'objet Group
     */
    public function __construct($id) {
        $this->id = $id;
        $query = "SELECT id, name FROM groups WHERE id =?;"; //Requête pour récupérer les informations en fonction de l'id utilisateur
        //Résultats
        $result = Connexion::table($query, array($this->id));
        $this->name = $result[0]['name'];
    }

    /**
     * 
     * @return int id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Récupération de l'id du groupe selon son nom
     * @param string $name
     * @return array $result
     */
    public static function getIdByName($name) {
        $sql = 'SELECT id FROM groups WHERE name = ?';
        $result = Connexion::table($sql, array($name));
        return $result;
    }

    /**
     * 
     * @return string name
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Récupération du tout les groupes
     * @return array $result
     */
    public static function getAllGroups() {
        $sqlGetAllGroups = "SELECT id, name FROM groups;";
        $result = Connexion::table($sqlGetAllGroups, array());
        return $result;
    }

    /**
     * 
     * @param array $groups
     * @return array $groupsCreated
     */
    public static function createGroups($groups) {

        $groupsCreated = array();

        //Vérification si le hashtag existe déjà, si non on l'ajoute à la base de données

        foreach ($groups as $group) {
            if (strlen($group) > 0) {
                $sqlVerif = "SELECT name FROM groups WHERE name = ?;";
                $result = Connexion::table($sqlVerif, array($group));
                if (empty($result)) {
                    $sqlAdd = "INSERT INTO groups(name) VALUES (?);";
                    $query = Connexion::query($sqlAdd, array($group));
                    $groupsCreated[] = $group;
                }
            }
        }
        return $groupsCreated;
    }

    /**
     * Création du l'abonnement d'un utilisateur à un groupe
     * @param int $userId
     * @param string $groups
     * @return array $groupsId
     */
    public static function createSubscription($userId, $groups) {
        $groupsId = array();
        foreach ($groups as $group) {

            //Avant cela on récupère l'id du groupe
            $groupId = self::getIdByName($group);
            $groupsId[] = $groupId[0]['id'];
            //Et on insère
            $sqlSubscription = 'INSERT INTO usersGroup(idUser, idGroup) Values(?,?);';
            $resultSubscription = Connexion::query($sqlSubscription, array($userId, $groupId[0]['id']));
        }
        return $groupsId;
    }
    
    /**
     * Suppression de l'abonnement d'un utilisateur à un groupe
     * @param int $idUser
     * @param int $idGroup
     * @return bool
     */
    public static function unsubscribe($idUser, $idGroup){
        
        $sqlUnsubscribe = 'DELETE FROM usersGroup WHERE idUser = ? AND idGroup = ?';
        $resultUnsubscribe = Connexion::query($sqlUnsubscribe,array($idUser, $idGroup));
        
        return $resultUnsubscribe;
    }
    
    

}
