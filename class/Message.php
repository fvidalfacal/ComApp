<?php

require_once 'connexion.php';

class Message {

    private $id;
    private $content;
    private $date;
    private $idUser;

    /**
     * 
     * @param int $id, l'identifiant du message qui permet de créer l'objet Message
     */
    public function __construct($id) {
        $this->id = $id;
        //Requête pour récupérer les informations en fonction de l'id utilisateur
        $query = "SELECT id, content, date, idUser FROM messages WHERE id = ?;";
        //Résultats
        $results = Connexion::table($query, array($this->id));
        $this->content = $results[0]['content'];
        $this->date = $results[0]['date'];
        $this->idUser = $results[0]['idUser'];
    }

    /**
     * 
     * @return int id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * 
     * @return string content
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * 
     * @return Date date
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Récupération de l'id du message à l'aide des informations du message
     * @param string $content
     * @param string $date
     * @param int $userId
     * @return array $result
     */
    public static function getIdByContent($content, $date, $userId) {

        $sql = 'SELECT id FROM messages WHERE content = ? AND date = ? AND idUser = ?';
        $result = Connexion::table($sql, array($content, $date, $userId));
        return $result;
    }

    /**
     * 
     * @return \User
     */
    public function getAuthor() {
        $idAuthor = $this->idUser;
        $user = new User($idAuthor);
        return $user;
    }

    /**
     * Récupération des messages d'un hashtag
     * @param int $idHashtag
     * @return \Message
     */
    public static function getMessagesByIdHashtag($idHashtag) {
        //Récupération des ids de groups sur usersGroup en fonction de l'utilisateur
        $sql = 'SELECT messages.id, messages.date,messages.content
                FROM messagesGroup, messages
                WHERE messagesGroup.idMessage = messages.id
                AND messagesGroup.idGroup=?
                ORDER BY messages.date;';
        $results = Connexion::table($sql, array($idHashtag));

        foreach ($results as $result) {
            $message[] = new Message($result['id']);
        }

        return $message;
    }

    /**
     * Insertion du message
     * @param int $userId
     * @param string $content
     */
    public static function insertMessage($userId, $content) {
        $date = date('Y-m-d H-i-s');

        //Ajout du message dans la base de données
        $sqlInsertMessage = "INSERT INTO messages(content, date, idUser)
               VALUES (?,?,?)";
        $results = Connexion::query($sqlInsertMessage, array($content, $date, $userId));

        // Récupération des hashtags du message
        $explodeGroups = explode('#', $content);
        unset($explodeGroups[0]);

        foreach ($explodeGroups as $explodeGroup) {
            $explodeSpace = explode(' ', $explodeGroup);
            $groups[] = $explodeSpace[0];
        }

        //Création de(s) hashtag(s) si ils sont non existants
        $groupsCreated = Group::createGroups($groups);

        //Si le(s) groupe(s) n'existait pas, on abonne le créateur du message au(x) groupe(s)
        $createSubscription = Group::createSubscription($userId, $groupsCreated);

        //Relier le message aux groupes
        $createLinkMessageGroup = self::createLinkMessageGroup($content, $date, $userId, $groups);
    }

    /**
     * Suppression d'un message
     * @param int $idMessage
     * @param int $idUser
     * @return boolean
     */
    public static function deleteMessage($idMessage, $idUser) {
        //On vérifie l'id de l'utilisateur qui supprime le message pour savoir si il est bien le créateur du message
        $sqlVerifyIdUser = 'SELECT messages.id from messages WHERE id = ? AND idUser = ?;';
        $result = Connexion::table($sqlVerifyIdUser, array($idMessage, $idUser));

        if (sizeof($result) > 0) {
            $sqlDeleteMessageGroup = 'DELETE FROM messagesGroup WHERE idMessage = ?';
            $resultsSqlDeleteMessageGroup = Connexion::query($sqlDeleteMessageGroup, array($idMessage));

            $sqlDeleteMessage = 'DELETE FROM messages WHERE id = ?';
            $resultsSqlDeleteMessage = Connexion::query($sqlDeleteMessage, array($idMessage));
            return true;
        } else {
            return false;
        }
    }

    /**
     * Création d'un lien entre le message et le/les groupes associés
     * @param string $content
     * @param Date $date
     * @param int $userId
     * @param array $groups
     */
    public static function createLinkMessageGroup($content, $date, $userId, $groups) {
        foreach ($groups as $group) {
            //On récupère l'id du message
            $messageId = self::getIdByContent($content, $date, $userId);


            //On récupère l'id du groupe
            $groupId = Group::getIdByName($group);


            //Et on crée le lien
            $sqlCreateLink = "INSERT INTO messagesGroup(idMessage,idGroup) VALUES (?,?)";
            $result = Connexion::query($sqlCreateLink, array($messageId[0]['id'], $groupId[0]['id']));
        }
    }

}
