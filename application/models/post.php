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
     * @param int $uID author
     * @param array $tags tags
     */
    public function writePost($title, $content, $submitted, $uID, $tags) { // $tags is an array
    
        $sql = "INSERT INTO Post (title, content, submitted, author) VALUES (:title, :content, :submitted, :author)";
        $query = $this->db->prepare($sql);
        $parameters = array(':title' => $title, ':content' => $content, ':submitted' => $submitted, ':author' => $uID);
        $successful = $query->execute($parameters);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . debugPDO($sql, $parameters);  exit();
        $postID = $this->db->lastInsertId();
        echo "Post ID is ", $postID, " ";
        
        foreach ($tags as $tag) {
            // if statement for checking whether the tag is a new one
            echo "Tag is ", $tag, "\r\n";
            $sql = "SELECT tID FROM Tag WHERE name = :tag";
            $query = $this->db->prepare($sql);
            $parameters = array(':tag' => $tag);
            $query->execute($parameters);
            
            $tagID = $query->fetchColumn(0);

            if ($tagID == false) { // tag is new, create new entry
                echo "tag not found\r\n";
                $sql = "INSERT INTO Tag (name) VALUES (:tag)";
                $query = $this->db->prepare($sql);
                $parameters = array(':tag' => $tag);
                $query->execute($parameters);
                $tagID = $this->db->lastInsertId();
            }
            
            echo "Second tagID check: ", $tagID, "\r\n";
            
            //create posttag entity for each pair
            $sql = "INSERT INTO PostTags (pID, tID) VALUES (:pID, :tID)";
            $query = $this->db->prepare($sql);
            $parameters = array(':pID' => $postID, 'tID' => $tagID);
            $query->execute($parameters);
            
        }

        if ($successful > 0) { // If the query is successful...
            echo "Successful\r\n";
            $sql = "SELECT * FROM Post WHERE pID = :pID";
            $query = $this->db->prepare($sql);
            $query->execute(array(':pID' => $postID)); // Execute query first, then...
            $post = $query->fetch(PDO::FETCH_ASSOC); // Fetch the array of attributes of the user.
            return $post; // Return the post.
        }

        return false; // If it hits here, return false to signify failure.
    }
    
    /**
     * Edit a post in database.
     *
     * @param int $pID pID
     * @param string $title title
     * @param string $content content
     * @param array $tags tags
     */
    public function editPost($pID, $title, $content, $tags) {
        $sql = "UPDATE Post SET title = :title WHERE pID = :pID";
        $query = $this->db->prepare($sql);
        $query->execute(array(':pID' => $pID, ':title' => $title));
        
        $sql = "UPDATE Post SET content = :content WHERE pID = :pID";
        $query = $this->db->prepare($sql);
        $query->execute(array(':pID' => $pID, ':content' => $content));
        
        // Remove all PostTags relations between this post and all the tags it has
        $sql = "DELETE FROM PostTags WHERE pID = :pID";
        $query = $this->db->prepare($sql);
        $query->execute(array(':pID' => $pID));
        
        foreach ($tags as $tag) {
            // if statement for checking whether the tag is a new one
            $sql = "SELECT tID FROM Tag GROUP BY name HAVING name = :tag";
            $query = $this->db->prepare($sql);
            $parameters = array(':tag' => $tag);
            $query->execute($parameters);
            $tagID = $query->fetchColumn(0);
            
            if ($tagID == false) { // tag is new, create new entry
                $sql = "INSERT INTO TAG (name) VALUES (:tag)";
                $query = $this->db->prepare($sql);
                $parameters = array(':tag' => $tag);
                $query->execute($parameters);
                $tagID = $this->db->lastInsertId();
            }
            
            //create posttage entity for each pair
            $sql = "INSERT INTO PostTags (pID, tID) VALUES (:pID, :tID)";
            $query = $this->db->prepare($sql);
            $parameters = array(':pID' => $pID, 'tID' => $tagID);
            $query->execute($parameters);
            
        }
        
    }
    
    /**
     * Hide post. (For users, it will be displayed as "delete" function)
     * 
     * @param int $pID pID
     */
    public function hidePost($pID) {
        $sql = "UPDATE Post SET hidden = 1 WHERE pID = :pID";
        $query = $this->db->prepare($sql);
        $parameters = array(':pID' => $pID);
        $query->execute($parameters);
    }
    
    /**
     * Undo the hide function on a post.
     * Normally inaccessible to users: only for admins to restore the post.
     * 
     * @param int $pID pID
     */
    public function unhidePost($pID) {
        $sql = "UPDATE Post SET hidden = 0 WHERE pID = :pID";
        $query = $this->db->prepare($sql);
        $parameters = array(':pID' => $pID);
        $query->execute($parameters);
    }
    
         /**
     * Delete post.
     * Normally inaccessible to users: only for admins to remove the post from DB.
     * 
     * @param int $pID pID
     */
     public function deletePost($pID) {
         
         $sql = "DELETE FROM PostTags WHERE pID = :pID";
         $query = $this->db->prepare($sql);
         $parameters = array(':pID' => $pID);
         $query->execute($parameters);
         
         $sql = "DELETE FROM Post WHERE pID = :pID";
         $query = $this->db->prepare($sql);
         $parameters = array(':pID' => $pID);
         $query->execute($parameters);
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
    
    /**
     * Get all posts from database that are not hidden
     *
     */
    public function getAllPosts() {
        $sql = "SELECT * FROM Post WHERE hidden = 0";
        $query = $this->db->prepare($sql); 
        $query->execute($parameters);
        return $query->fetch(); 
    }
    
}