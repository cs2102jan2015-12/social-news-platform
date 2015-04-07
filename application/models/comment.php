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
    public function addComment($content, $uid, $pid) { 
        
        $sql = "INSERT INTO Comment (content, submitted, author, parent) VALUES (:content, :submitted, :author, :parent)";
        $query = $this->db->prepare($sql);
        $parameters = array(':content' => $content,'submitted' => date('Y-m-d H:i:s'), ':author' => $uid, 'parent' => $pid);
        
        $query->execute($parameters);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . debugPDO($sql, $parameters);  exit();
        $cid = $this->db->lastInsertId();
        return false; // If it hits here, return false to signify failure.
    }
    
    /**
     * Edit a comment in database.
     *
     * @param int $cid cid
     * @param string $newContent newContent
     */
    public function editComment($cid, $newContent) {
        
        $sql = "UPDATE Comment SET content = :newContent, submitted = :newsubmitted WHERE cid = :cid";
        $query = $this->db->prepare($sql);
        $query->execute(array(':cid' => $cid, ':newContent' => $newContent, ':newsubmitted' => date('Y-m-d H:i:s')));
        
    }
    /**
     * Get parent post. 
     * 
     * @param int $cid cid
     * @return pid $pid
     */
    public function getParent($cid) {
        $sql = "SELECT c.parent 
                FROM Comment c 
                WHERE c.cid = :cid;";
        $query = $this->db->prepare($sql);
        $parameters = array(':cid' => $cid);
        $query->execute($parameters);
        return $query->fetch();
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
     * 
     * @return content submitted author
     * 
     */
    public function getAllCommentsOfPost($pid) {
        $sql = "SELECT c.cid AS cid, c.content AS content, c.submitted AS submitted, u.username AS author, u.uid AS uid
                FROM Comment c, User u
                WHERE c.hidden = 0 
                AND c.parent = :pid
                AND u.uid = c.author
                ORDER BY c.submitted DESC";
        $query = $this->db->prepare($sql); 
        $parameters = array(':pid' => $pid);
        $query->execute($parameters);
        return $query->fetchAll(); 

    }
    
    /**
     * Get a comment
     * 
     * @param $cid cid
     * 
     * @return content submitted author
     * 
     */
    public function getComment($cid) {
        $sql = "SELECT c.cid AS cid, c.content AS content
                FROM Comment c
                WHERE c.hidden = 0 
                AND c.cid = :cid;";
        $query = $this->db->prepare($sql); 
        $parameters = array(':cid' => $cid);
        $query->execute($parameters);
        return $query->fetch(); 

    }
    
}