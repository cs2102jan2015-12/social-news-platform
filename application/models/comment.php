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
    public function hideComment($cid) {
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
    public function unhideComment($cid) {
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
     public function deleteComment($cid) {
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
    /**
     * Reports the comment
     * 
     * @param uid
     * @param cid
     * 
     */
     public function reportComment($uid, $cid) {
        $sql = "INSERT INTO CommentReport (uid, cid, submitted) VALUES (:uid, :cid, :submitted);";
        $query = $this->db->prepare($sql);
        $parameters = array(':cid' => $cid, ':uid' => $uid, ':submitted' => date('Y-m-d H:i:s'));
        $query->execute($parameters);
     }
     
     /**
     * Check if you've already reported and still pending
     * 
     * @param uid
     * @param pid
     * 
     */
     public function hasUnreviewedReport($uid, $cid) {
        $sql = "SELECT cid 
                FROM CommentReport 
                WHERE uid = :uid 
                AND cid = :cid
                AND reviewed = 0;;";
        $query = $this->db->prepare($sql);
        $parameters = array(':cid' => $cid, ':uid' => $uid);
        $query->execute($parameters);
        return $query->fetch();
     }
     
     /**
     * Check if you've already reported and issue closed
     * 
     * @param uid
     * @param pid
     * 
     */
     public function hasReviewedReport($uid, $cid) {
        $sql = "SELECT cid 
                FROM CommentReport 
                WHERE uid = :uid 
                AND cid = :cid
                AND reviewed = 1;";
        $query = $this->db->prepare($sql);
        $parameters = array(':cid' => $cid, ':uid' => $uid);
        $query->execute($parameters);
        return $query->fetch();
     }
    /**
     * Get all reported comments.
     */
    public function getReportedComments() {
        $sql = "SELECT c.cid AS cid, c.content AS content, author.username AS author, c.submitted AS submitted,
            c.parent AS pid,
            reporter.username AS reporter, cr.submitted AS reportedTime
            FROM Comment AS c
            INNER JOIN CommentReport AS cr ON c.cid = cr.cid AND cr.reviewed = 0
            INNER JOIN User AS reporter ON cr.uid = reporter.uid
            INNER JOIN User AS author ON c.author = author.uid";
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // core/controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetchAll();
    }
    
    /**
     * Close the reports associated with this cid.
     */
    public function closeReport($cid) {
        $sql = "UPDATE CommentReport SET reviewed = 1 WHERE cid = :cid";
        $query = $this->db->prepare($sql);
        return $query->execute(array(':cid' => $cid));
    }

}