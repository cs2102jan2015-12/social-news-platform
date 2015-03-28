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
    public function writePost($title, $content, $submitted, $uID, $tags) { // $tags is an array
        
        $sql = "INSERT INTO Post (title, content, submitted, author) VALUES (:title, :content, :submitted, :author)";
        $query = $this->db->prepare($sql);
        $parameters = array(':title' => $title, ':content' => $content, ':submitted' => $submitted, ':author' => $uID);
        $query->execute($parameters);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . debugPDO($sql, $parameters);  exit();
        $postID = $this->db->lastInsertId();
        
        foreach ($tags as $tag) {
            // if statement for checking whether the tag is a new one
            $sql = "SELECT tID FROM Tag GROUP BY name HAVING name = :tag";
            $query = $this->db->prepare($sql);
            $parameters = array(':tag' => $tag);
            $query->execute($parameters);
            $tagID = $query->fetch();
            
            if ($tagID === null) { // tag is new, create new entry
                $sql = "INSERT INTO TAG (name) VALUES (:tag)";
                $query = $this->db->prepare($sql);
                $parameters = array(':tag' => $tag);
                $query->execute($parameters);
                $tagID = $this->db->lastInsertId();
            }
            
            //create posttage entity for each pair
            $sql = "INSERT INTO PostTags (pID, tID) VALUES (:pID, :tID)";
            $query = $this->db->prepare($sql);
            $parameters = array(':pID' => $postID, 'tID' => $tagID);
            $query->execute($parameters);
            
        }

        if ($query->execute($parameters) > 0) { // If the query is successful...
            $sql = "SELECT * FROM Post WHERE pID = :pID";
            $query = $this->db->prepare($sql);
            $query->execute(array(':pID' => $postID)); // Execute query first, then...
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