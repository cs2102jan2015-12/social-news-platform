<?php

class Post 
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
     * Add a post to database
     *
     * @param int $pID pID
     * @param string $title title
     * @param string $content content
     * @param string $submitted date
     * @param string $uID author
     */
    public function writePost($pID, $title, $content, $submitted, $uID) {
        $sql = "INSERT INTO Post (pID, title, content, submitted, author) VALUES (:pID, :title, :content, :submitted, :author)";
        $query = $this->db->prepare($sql);
        $parameters = array(':pID'=> $pID, ':title' => $title, ':content' => $content, ':submitted' => $submitted, ':author' => $uID,);
        $query->execute($parameters);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . debugPDO($sql, $parameters);  exit();

        if ($query->execute($parameters) > 0) { // If the query is successful...
            $sql = "SELECT * FROM Post WHERE pID = :pID";
            $query = $this->db->prepare($sql);
            $query->execute(array(':pID' => $pID)); // Execute query first, then...
            $post = $query->fetch(PDO::FETCH_ASSOC); // Fetch the array of attributes of the user.
            return $post; // Return the post.
        }

        return false; // If it hits here, return false to signify failure.
    }
    
    /**
     * Get a post from database using post ID
     *
     * @param int $pID pID
     */
    public function getPost($pID) {
        $sql = "SELECT * FROM Post WHERE pID = :pID";
        $query = $this->db->prepare($sql); 
        $parameters = array(':pID' => $pID);
        
        $query->execute($parameters);
         
        // fetch() is the PDO method that get exactly one result
        return $query->fetch(); 
    }
    
}