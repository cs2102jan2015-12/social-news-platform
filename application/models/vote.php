<?php

class Vote
{
    /**
     * @param object $db : A PDO database connection
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
     * Upvote a post.
     * 
     * @param int $pid
     * @param int $uid
     * @param int $value = 1
     * 
     * @return int : Sum of votes on post.
     */
     public function upvotePost($pid, $uid, $value = 1) {
         $sql = "INSERT INTO PostVote (pid, uid, value) VALUES (:pid, :uid, :value)
            ON DUPLICATE KEY UPDATE value=:value";
         $query = $this->db->prepare($sql);
         $query->execute(array(':uid' => $uid, ':pid' => $pid, ':value' => $value));
         
         return $this->getVotesOfPost($pid);
     }
     
    /**
     * Downvote a post.
     * 
     * @param int $pid
     * @param int $uid
     * @param int $value = -1
     * 
     * @return int : Sum of votes on post.
     */
    public function downvotePost($pid, $uid, $value = -1) {
        return $this->upvotePost($pid, $uid, $value); // Technically it's a negative upvote.
    }
     
    /**
     * Get votes of a post.
     * 
     * @param int $pID
     * 
     * @return int : Sum of votes on post.
     */
    public function getVotesOfPost($pid, $uid = null) {
        $sql = "SELECT SUM(value) AS votes FROM PostVote WHERE pid = :pid";
        $query = $this->db->prepare($sql);
        $query->execute(array(':pid' => $pid));
        
        $sum = $query->fetch();
        return $sum;
    }
     
    /**
     * Upvote a comment.
     * 
     * @param int $cid
     * @param int $uid
     * @param int $value = 1
     * 
     * @return int : Sum of votes on comment.
     */
    public function upvoteComment($cid, $uid, $value = 1) {
         $sql = "INSERT INTO CommentVote (cid, uid, value) VALUES (:cid, :uid, :value)
            ON DUPLICATE KEY UPDATE value=:value";
         $query = $this->db->prepare($sql);
         $query->execute(array(':uid' => $uid, ':cid' => $cid, ':value' => $value));
         
         return $this->getVotesOfComment($cid);
    }
     
    /**
     * Downvote a post.
     * 
     * @param int $cid
     * @param int $uid
     * @param int $value = -1
     * 
     * @return int : Sum of votes on comment.
     */
    public function downvoteComment($cid, $uid, $value = -1) {
        return $this->upvoteComment($cid, $uid, $value); // Technically it's a negative upvote.
    }
    
    /**
     * Get votes of a comment.
     * 
     * @param int $pID
     * 
     * @return int : Sum of votes on comment.
     */
    public function getVotesOfComment($cid, $uid = null) {
        $sql = "SELECT SUM(value) AS votes FROM CommentVote WHERE cid = :cid";
        $query = $this->db->prepare($sql);
        $query->execute(array(':cid' => $cid));
        
        $sum = $query->fetch();
        return $sum;
    }
}
