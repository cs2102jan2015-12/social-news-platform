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

        if ($query->execute($parameters)) { // If the query is successful...
            $sql = "SELECT * FROM User WHERE uid = :lastInsertId";
            $query = $this->db->prepare($sql);
            $query->execute(array(':lastInsertId' => $this->db->lastInsertId())); // Execute query first, then...
            $user = $query->fetch(); // Fetch the array of attributes of the user.
            return $user; // Return the user.
        }

        return false; // If it hits here, return false to signify failure.
    }

    /**
     * Verify a user's credentials.
     *
     * @param string $username Username
     * @param string $password Password
     */
    public function verifyUserCredentials($username, $password) {
        $sql = "SELECT * FROM User WHERE username = :username";
        $query = $this->db->prepare($sql);
        $parameters = array(':username' => $username);

        if ($query->execute($parameters)) { // If the query is successful...
            $user = $query->fetch(); // Fetch the array of attributes of the user.
            if (password_verify($password, $user->hash)) {
                return $user; // Return the user.
            }
        }

        return null; // Return null to denote false and signify failure.
    }
}
