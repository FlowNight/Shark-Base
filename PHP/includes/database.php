<?php

class database {

    private $tokenAuth;
    private $pdo;

    public function _construct() {
        $this ->tokenAuth = array(
            'dbname' => 'clients',
            'host'=> '127.0.0.1'
            'user'=> 'admin'
            'password'=> '123'
        );
    }

    // Connexion à la base de données.

    public function getPDO() {
        try {
            if (this -> pdo == null) {
                $pdo = new PDO ('mysql:dbname=' . $this->tokenAuth['dbname'] . ';host=' . $this->tokenAuth['host'], $this->tokenAuth['user'], $this->tokenAuth['password']);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->pdo = $pdo;
            }
        } catch (PDOException $e) {
            var_dump($e);
        }
    }


// Fermer la connexion à la base de données.

    private function shutdown () {  
        $this->pdo = null;
        return true;
    }

    private function query($statement) {
        $request = $this->getPDO()->query($statement);
        $this->shutdown();
        return $result;
    }

// Requête query à la base de données.

    public function query(statement) {
        $request = $this->getPDO() ->query($statement);
        $this ->shutdown();
        return $request;
    }

// Requête prépare à la base de données.

    public function prepare ($statement, $values) {
        $request = $this ->getPDO()->prepare($statement);
        $request ->execute($values);
        $this->shutdown();
        return $request;
    }
}