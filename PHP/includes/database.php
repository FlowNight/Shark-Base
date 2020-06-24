<?php
 
    /**
     * Connexion à la base de données.
     */
    function getPDO() {
        try {
            $pdo = new PDO('mysql:dbname=clients;host=127.0.0.1', 'root', '123');
            $pdo->exec("SET CHARACTER SET utf8");
            return $pdo;
        } catch (PDOException $e) {
            var_dump($e);
        }
    }
 
    function countDatabaseValue($connexionBDD, $key, $value) {
        $request = "SELECT * FROM users WHERE $key = ?";
        $rowCount = $connexionBDD->prepare($request);
        $rowCount->execute(array($value));
        return $rowCount->rowCount();
    }