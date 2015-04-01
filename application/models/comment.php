<?php

class Comment 
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
     * Add a comment to database
     *
     * @param string $content content
     * @param string $submitted date
     * @param string $uID author
     * @param array $pid parent
     */
    public function addComment($content, $submitted, $uID, $pid) { 
        
        $sql = "INSERT INTO Comment (content, submitted, author, parent) VALUES (:content, :submitted, :author, :parent)";
        $query = $this->db->prepare($sql);
        $parameters = array(':content' => $content, ':submitted' => $submitted, ':author' => $uID, 'parent' => $pid);
        
        $query->execute($parameters);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . debugPDO($sql, $parameters);  exit();
        $cid = $this->db->lastInsertId();
        
        if ($query->execute($parameters) > 0) { // If the query is successful...
            $sql = "SELECT * FROM Comment WHERE cid = :cid";
            $query = $this->db->prepare($sql);
            $query->execute(array(':cid' => $cid)); // Execute query first, then...
            $comment = $query->fetch(PDO::FETCH_ASSOC); // Fetch the array of attributes of the user.
            return $comment; // Return the post.
        }

        return false; // If it hits here, return false to signify failure.
    }
    
    /**
     * Edit a comment in database.
     *
     * @param int $cid cid
     * @param string $newContent newContent
     */
    public function editComment($cid, $newContent) {
        
        $sql = "UPDATE Comment SET content = :newContent WHERE cid = :cid";
        $query = $this->db->prepare($sql);
        $query->execute(array(':cid' => $cid, ':content' => $newContent));
        
    }
    
    /**
     * Hide comment. (For users, it will be displayed as "delete" function)
     * 
     * @param int $cid cid
     */
    public function hidePost($cid) {
        $sql = "UPDATE Comment SET hidden = 1 WHERE cid = :cid";
        $query = $this->db->prepare($sql);
        $parameters = array(':cid' => $cid);
        $query->execute($parameters);
    }
    
    /**
     * Undo the hide function on a comment.
     * Normally inaccessible to users: only for admins to restore the comment.
     * 
     * @param int $cid cid
     */
    public function unhidePost($cid) {
        $sql = "UPDATE Comment SET hidden = 0 WHERE cid = :cid";
        $query = $this->db->prepare($sql);
        $parameters = array(':cid' => $cid);
        $query->execute($parameters);
    }
    
         /**
     * Delete comment
     * Normally inaccessible to users: only for admins to remove the comment from DB.
     * 
     * @param int $cid cid
     */
     public function deletePost($cid) {
         $sql = "DELETE FROM Comment WHERE cid = :cid";
         $query = $this->db->prepare($sql);
         $parameters = array(':cid' => $cid);
         $query->execute($parameters);
     }

    
    /**
     * Get all comments that belong to a particular post
     * 
     * @param $pid pid
     */
    public function getAllCommentsOfPost($pid) {
        $sql = "SELECT * FROM Comment WHERE hidden = 0 AND parent = :pid";
        $query = $this->db->prepare($sql); 
        $parameters = array(':pid' => $pid);
        $query->execute($parameters);
        return $query->fetchAll(); 

    }
    
}