<?php

class Feed
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
     * Get all feeds from database
     */
    public function getAllFeeds()
    {
        if (array_key_exists('user', $_SESSION)) {
            $parameters = array(':uid' => $_SESSION['user']['uid']);
            $sql = "SELECT t.name AS tag, t.tid AS tid
            FROM Tag t, Feed f, User u
            WHERE t.tid = f.tid
            AND f.uid = u.uid
            AND u.uid = :uid
            ";
            $query = $this->db->prepare($sql);
            $query->execute($parameters);
    
            // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
            // core/controller.php! If you prefer to get an associative array as the result, then do
            // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
            // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
            return $query->fetchAll();
        }
    }
    /**
     * Remove feed from user (unsubscribe)
     * @param tid tag id
     */
     public function unsubscribe($tid)
     {
         if (array_key_exists('user', $_SESSION)) {
            $sql = "SELECT tid FROM Tag WHERE tid = :tid";
            $query = $this->db->prepare($sql);
            $parameters = array(':tid' => $tid);
            $query->execute($parameters);
            
            $tid = $query->fetchColumn(0);
            
            $parameters = array(':uid' => $_SESSION['user']['uid'], ':tid' => $tid);
            $sql = "DELETE FROM Feed WHERE tid = :tid AND uid = :uid;";
            $query = $this->db->prepare($sql);
            $query->execute($parameters);
         }
         
     }
     
     /**
     * Add feed to user (subscribe)
     * @param tagname tag name
     */
     public function subscribe($tagname)
     {
         if (array_key_exists('user', $_SESSION)) {
            
             // if statement for checking whether the tag is a new one
            $sql = "SELECT tid FROM Tag WHERE name = :tag";
            $query = $this->db->prepare($sql);
            $parameters = array(':tag' => $tagname);
            $query->execute($parameters);
            
            $tid = $query->fetchColumn(0);

            if ($tid == false) { // tag is new, create new entry
                $sql = "INSERT INTO Tag (name) VALUES (:tag)";
                $query = $this->db->prepare($sql);
                $parameters = array(':tag' => $tagname);
                $query->execute($parameters);
                $tid = $this->db->lastInsertId();
            }
            
            //create Feed entity
            $sql = "INSERT INTO Feed (uid, tid) VALUES (:uid, :tid);";
            $query = $this->db->prepare($sql);
            $parameters = array(':uid' => $_SESSION['user']['uid'], ':tid' => $tid);
            $query->execute($parameters);
         }
         
     }
}
