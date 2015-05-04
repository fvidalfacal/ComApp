<?php

require_once 'connexion.php';

class User {

    private $id;
    private $email;
    private $password;
    private $name;
    private $firstName;

    /**
     * 
     * @param int $id, l'identifiant de l'utilisateur qui permet de créer l'objet User
     */
    public function __construct($id) {
        $this->id = $id;
        //Requête
        $query = "SELECT id, email, password, name, firstName FROM users WHERE id = ?;"; //Requête pour récupérer les informations en fonction de l'id utilisateur
        $result = Connexion::table($query, array($this->id));
        $this->email = $result[0]['email'];
        $this->password = $result[0]['password'];
        $this->name = $result[0]['name'];
        $this->firstName = $result[0]['firstName'];
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
     * @return Group, tous les groupes associé à l'utilisateur
     */
    public function getGroups() {
        //Récupération des ids de groups sur usersGroup en fonction de l'utilisateur
        $sql = 'SELECT * FROM usersGroup WHERE idUser=?;';
        $results = Connexion::table($sql, array($this->id));
        //Récupération des groups
        if (sizeof($results) > 1) {
            foreach ($results as $result) {
                $groups[] = new Group($result['idGroup']);
            }
        }
        else{
            $groups = NULL;
        }
        return $groups;
    }

    /**
     * 
     * @return string email
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * 
     * @param string $email , adresse email à modifier
     * @return bool
     */
    public function setEmail($email) {
        //Requête de mis à jour du mot de passe
        $sql = 'UPDATE users SET email = ? WHERE id = ?;';
        $execute = Connexion::query($sql, array($email, $this->id));
        $this->email = $email;
        return $execute;
    }

    /**
     * 
     * @return string password
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * 
     * @param string $password , le mot de passe à modifier
     * @return bool
     */
    public function setPassword($password) {
        //Requête de mis à jour du mot de passe
        $sql = 'UPDATE users SET password = "' . $password . '" WHERE id = ' . $this->id . ';';
        $execute = Connexion::query($sql, array($password, $this->id));
        $this->password = $password;
        return $execute;
    }

    /**
     * 
     * @return string name
     */
    public function getName() {
        return $this->name;
    }

    /**
     * 
     * @param string $name , nom utilisateur à modifier
     * @return bool
     */
    public function setName($name) {
        //Requête de mis à jour du mot de passe
        $sql = 'UPDATE users SET name = ? WHERE id = ?;';
        $execute = Connexion::query($sql, array($name, $this->id));
        $this->name = $name;
        return $execute;
    }

    /**
     * 
     * @return string firstName
     */
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     * 
     * @param string $firstName , prénom utilisateur à modifier
     * @return bool
     */
    public function setFirstName($firstName) {
        //Requête de mis à jour du mot de passe
        $sql = 'UPDATE users SET email = ? WHERE id = ?;';
        $execute = Connexion::query($sql, array($firstName, $this->id));
        $this->firstName = $firstName;
        return $execute;
    }

    /**
     * Vérification des identifiants de l'utilisateur.
     * @param string $email
     * @param string $password
     * @return array $results
     */
    public static function verifyUser($email, $password) {
        $query = 'SELECT id, email,password, name , firstName FROM users WHERE email = ? AND password = ?;';
        $results = Connexion::table($query, array($email, $password));
        return $results;
    }

    /**
     * Création d'un utilisateur
     * @param string $email
     * @param string $password
     * @param string $name
     * @param string $firstName
     * @return bool
     */
    public static function createUser($email, $password, $name, $firstName) {
        $query = 'INSERT INTO users(email,password,name,firstName) VALUES (?,?,?,?)';
        $results = Connexion::query($query, array($email, $password, $name, $firstName));
        return $results;
    }

    /**
     * Vérification si le mot de passe saisie correspond bien aux règles de sécurité
     * @param string $password
     * @return bool
     */
    public static function verifyPassword($password) {
        $regex = '('    // Commencement
                . '(?=.*\d)'    // Le mot de passe doit contenir un chiffre
                . '(?=.*[a-z])'    // Le mot de passe doit contenir au moins une lettre minuscule
                . '(?=.*[A-Z])'    // Le mot de passe doit contenir au moins une lettre majuscule
                . '.'        // Toutes les conditions précédente doivent être respectées
                . '{7,20}'    //  La longueur doit être comprises entre 7 et 20 caractères
                . ')';    // Fin';
        $verify = preg_match($regex, $password);
        return $verify;
    }

}
