<?php

require_once 'connexion.php';

class Message {

    private $id;
    private $content;
    private $date;
    private $idUser;

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

    public function getId() {
        return $this->id;
    }

    public static function getIdByContent($content, $date, $userId) {

        $sql = 'SELECT id FROM messages WHERE content = ? AND date = ? AND idUser = ?';
        $result = Connexion::table($sql, array($content, $date, $userId));
        return $result;
    }

    public function getGroups() {
        
    }

    public function getAuthor() {
        $idAuthor = $this->idUser;
        $user = new User($idAuthor);
        return $user;
    }

    public static function getMessagesByIdHashtag($idHashtag, $userId) {
        $html = "";
        //Récupération des ids de groups sur usersGroup en fonction de l'utilisateur
        $sql = 'SELECT messages.id, messages.date,messages.content, users.id, users.firstName, users.name FROM messagesGroup, messages, users 
                WHERE messagesGroup.idMessage = messages.id
                AND messages.idUser = users.id
                AND messagesGroup.idGroup=?
                ORDER BY messages.date;';
        $results = Connexion::table($sql, array($idHashtag));

        foreach ($results as $result) {
            $html.='<tr>';
            $html.='<td>' . $result['date'] . '</td>';
            $html.='<td>' . $result['content'] . '</td>';
            $html.='<td>' . $result['firstName'] . ' ' . $result['name'] . '</td>';
            $html.='<td>';
            if ($userId == $result['id']) {
                $html.='<a class="btn btn-danger fa fa-times" href="deleteMessage.php?id=' . $result['id'] . '&from=' . $_SERVER['REQUEST_URI'] . '" role="button"></a>';
            }
            $html.='</td>';
            $html.='</tr>';
            //$html.='<li><a href="index.php?group='.$groups->getId().'"><i class="fa fa-slack"></i>'.$groups->getName().'</a></li>';
        }

        return $html;
    }

    public function sendNotification() {
        //@todo plus tard
    }

    public function update() {
        
    }

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
        $createSubscription = Group::createSubscription($userId, $content, $groupsCreated);

        //Relier le message aux groupes
        $createLinkMessageGroup = self::createLinkMessageGroup($content, $date, $userId, $groups);
    }

    public static function deleteMessage($idMessage, $idUser) {
        //On vérifie l'id de l'utilisateur qui supprime le message pour savoir si il est bien le créateur du message
        $sqlVerifyIdUser = 'SELECT * from messages WHERE idUser = ?;';
        $result = Connexion::table($sqlVerifyUser, array($idUser));

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
