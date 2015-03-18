<?php

require_once 'connexion.php';

class User {

    private $id;
    private $email;
    private $password;
    private $name;
    private $firstName;

    public function __construct($id) {
        $this->id = $id;
        //Connexion à la base de données
        //Requête
        $query = "SELECT id, email, password, name, firstName FROM users WHERE id = ?;"; //Requête pour récupérer les informations en fonction de l'id utilisateur
        $result = Connexion::table($query, array($this->id));
        $this->email = $result[0]['email'];
        $this->password = $result[0]['password'];
        $this->name = $result[0]['name'];
        $this->firstName = $result[0]['firstName'];
    }

    public function getId() {
        return $this->id;
    }

    public function getGroups() {
        $html = "";
        //Récupération des ids de groups sur usersGroup en fonction de l'utilisateur
        $sql = 'SELECT * FROM usersGroup WHERE idUser=?;';
        $results = Connexion::table($sql, array($this->id));
        //Récupération des noms de groupes et mise en place du html
        foreach ($results as $result) {
            $groups = new Group($result['idGroup']);
            $html.='<li><a href="index.php?group=' . $groups->getId() . '"><i class="fa fa-slack"></i>' . $groups->getName() . '</a></li>';
        }

        return utf8_encode($html);
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        //Connexion à la base de données
        //Requête de mis à jour du mot de passe
        $sql = 'UPDATE users SET email = ? WHERE id = ?;';
        $execute = Connexion::query($sql, array($email, $this->id));
        $this->email = $email;
        return $execute;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        //Connexion à la base de données
        //Requête de mis à jour du mot de passe
        $sql = 'UPDATE users SET password = "' . $password . '" WHERE id = ' . $this->id . ';';
        $execute = Connexion::query($sql, array($password, $this->id));
        $this->password = $password;
        return $execute;
    }
    
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        //Connexion à la base de données
        //Requête de mis à jour du mot de passe
        $sql = 'UPDATE users SET name = ? WHERE id = ?;';
        $execute = Connexion::query($sql, array($name, $this->id));
        $this->name = $name;
        return $execute;
    }
    
    public function getFirstName() {
        return $this->firstName;
    }

    public function setFirstName($firstName) {
        //Connexion à la base de données
        //Requête de mis à jour du mot de passe
        $sql = 'UPDATE users SET email = ? WHERE id = ?;';
        $execute = Connexion::query($sql, array($firstName, $this->id));
        $this->firstName = $firstName;
        return $execute;
    }

    public static function verifyUser($email, $password) {
        $query = 'SELECT id, email,password, name , firstName FROM users WHERE email = ? AND password = ?;';
        $results = Connexion::table($query, array($email, $password));
        return $results;
    }

    public static function createUser($email, $password, $name, $firstName) {
        $query = 'INSERT INTO users(email,password,name,firstName) VALUES (?,?,?,?)';
        $results = Connexion::query($query, array($email, $password, $name, $firstName));
        return $results;
    }

    public static function verifyPassword($password) {
        $regex = '('    // Commencement
                    .'(?=.*\d)'    // Le mot de passe doit contenir un chiffre
                    .'(?=.*[a-z])'    // Le mot de passe doit contenir au moins une lettre minuscule
                    .'(?=.*[A-Z])'    // Le mot de passe doit contenir au moins une lettre majuscule
                    //.'(?=.*[@#$%])'    // Le mot de passe doit contenir au moins un caractère spéciale parmi "@#$%"
                    .'.'        // Toutes les conditions précédente doivent être respectées
                    .'{7,20}'    //  La longueur doit être comprises entre 7 et 20 caractères
                  .')';    // Fin';
        $verify = preg_match($regex, $password);
        return $verify;
    }

}
