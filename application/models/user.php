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
        if (!(strlen($username) > 0)) {
            return array('message' => 'Username must not be empty.');
        }
        if (!(strlen($password) > 0)) {
            return array('message' => 'Password must not be empty.');
        }

        // Allow PDO to throw exceptions. May want to set this globally?
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO User (username, hash) VALUES (:username, :hash)";
        $query = $this->db->prepare($sql);
        $parameters = array(':username' => $username, ':hash' => password_hash($password, PASSWORD_DEFAULT));

        try {
            $query->execute($parameters);
            $sql = "SELECT * FROM User WHERE uid = :lastInsertId";
            $query = $this->db->prepare($sql);
            $query->execute(array(':lastInsertId' => $this->db->lastInsertId())); // Execute query first, then...
            $user = $query->fetch(); // Fetch the array of attributes of the user.
            return array('user' => $user); // Return the user.
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // SQLStates 23000 is duplicate key error.
                return array('message' => 'This username is already taken.');
            }
            return array('message' => $e->getMessage());
        }

        // If it hits here, something unknown has happened.
        return array('message' => 'Something has happened. We are not sure what.');
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
            if ($user && password_verify($password, $user->hash)) {
                return $user; // Return the user.
            }
        }

        return null; // Return null to denote false and signify failure.
    }
}
