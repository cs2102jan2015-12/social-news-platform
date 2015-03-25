<?php

class User
{
    /**
     * @param object $db A PDO database connection
     */
    function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    /**
     * Add a user to database
     *
     * @param string $username Username
     * @param string $password Password
     */
    public function addUser($username, $password) {
        // TODO: Username validation.

        $sql = "INSERT INTO User (username, hash) VALUES (:username, :hash)";
        $query = $this->db->prepare($sql);
        $parameters = array(':username' => $username, ':hash' => password_hash($password, PASSWORD_DEFAULT));

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }
}
