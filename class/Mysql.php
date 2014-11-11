<?php

class Mysql{

    private $serveur = '';
    private $bdd = '';
    private $identifiant = '';
    private $mdp = '';
    private $lien = '';

    /**
     * Constructeur de la classe
     * Connexion aux serveur de base de donnée et sélection de la base
     *
     * $serveur     = L'hôte (ordinateur sur lequel Mysql est installé)
     * $bdd         = Le nom de la base de données
     * $identifiant = Le nom d'utilisateur
     * $mdp         = Le mot de passe
     */
    public function __construct($bdd = '', $serveur = '', $identifiant = '', $mdp = '') {
        $this->serveur = $serveur;
        $this->bdd = $bdd;
        $this->identifiant = $identifiant;
        $this->mdp = $mdp;

        $this->lien = mysql_connect($this->serveur, $this->identifiant, $this->mdp);

        $base = mysql_select_db($this->bdd, $this->lien);

    }

    /**
     * Envoie une requête SQL et récupère le résultât dans un tableau pré formaté
     *
     * $requete = Requête SQL
     */
    public function TabResSQL($requete) {
        $i = 0;

        $ressource = mysql_query($requete, $this->lien);

        $tabResultat = array();

        while ($ligne = mysql_fetch_assoc($ressource)) {
            foreach ($ligne as $clef => $valeur) {
                $tabResultat[$i][$clef] = $valeur;
            }
            $i++;
        }

        mysql_free_result($ressource);

        return $tabResultat;
    }

    /**
     * Retourne le dernier identifiant généré par un champ de type AUTO_INCREMENT
     *
     */
    public function DernierId() {
        return mysql_insert_id($this->lien);
    }

    /**
     * Envoie une requête SQL et retourne le nombre de table affecté
     *
     * $requete = Requête SQL
     */
    public function ExecuteSQL($requete) {
        $ressource = mysql_query($requete, $this->lien);

        $nbAffectee = mysql_affected_rows();

        return $nbAffectee;
    }

}

?>