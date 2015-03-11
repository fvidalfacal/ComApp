<?php

class Connexion {

    private static $_pdo;
    private static $_query = array();
    public static $last_query;

    private function __construct() {
        $dsn = 'mysql:dbname=ComApp;host=localhost';
        self::$_pdo = new \PDO(
                $dsn, "root", "pwsio", array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }

    static public function get() {
        if (!isset(self::$_pdo)) {
            new Connexion();
        }
        return self::$_pdo;
    }

    /**
     * 
     * @param String $statement
     * @return PDOStatement
     */
    static public function query($statement, $params = array()) {
        self::$last_query = $statement;
        $prepare = self::prepare($statement);
        return $prepare->execute($params);
    }

    static function prepare($statement, $driver_options = array()) {
        self::$last_query = $statement;
        if (!isset(self::$_query[$md5 = md5($statement)])) {
            self::$_query[$md5] = self::get()->prepare($statement, $driver_options);
        }
        return self::$_query[$md5];
    }

    static function table($statement, $params) {
        $queryPrepare = self::get()->prepare($statement);
        if ($queryPrepare->execute($params)) {
            return $queryPrepare->fetchAll();
        } else {
            return false;
        }
    }

}
