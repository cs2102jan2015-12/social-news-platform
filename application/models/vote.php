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
     * Reset the vote of the user on a post.
     * 
     * @param int $pid
     * @param int $uid
     * $param int $value = 0
     * 
     * @return int : Sum of votes on post.
     */
    public function unvotePost($pid, $uid, $value = 0) {
        return $this->upvotePost($pid, $uid, $value);
    }
     
    /**
     * Get votes of a post.
     * 
     * @param int $pid
     * @param int $uid = null
     * 
     * @return int : Sum of votes on post.
     */
    public function getVotesOfPost($pid, $uid = null) {
        $sql = "SELECT IFNULL(SUM(value), 0) AS votes FROM PostVote WHERE pid = :pid";
        $query = $this->db->prepare($sql);
        $query->execute(array(':pid' => $pid));
        
        $sum = $query->fetch();
        return $sum;
    }
    
    /**
     * Get votes on a post by a user.
     * 
     * @param int $pid
     * @param int $uid
     * 
     * @return int : Value of vote.
     */
    public function getVotesOfPostBy($pid, $uid) {
        $sql = "SELECT IFNULL(SUM(value), 0) AS value FROM PostVote WHERE pid = :pid AND uid = :uid";
        $query = $this->db->prepare($sql);
        $query->execute(array(':pid' => $pid, ':uid' => $uid));
        
        $votes = $query->fetch();
        return $votes;
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
     * Reset the vote of the user on a post.
     * 
     * @param int $cid
     * @param int $uid
     * $param int $value = 0
     * 
     * @return int : Sum of votes on post.
     */
    public function unvoteComment($cid, $uid, $value = 0) {
        return $this->upvoteComment($cid, $uid, $value);
    }
    
    /**
     * Get votes of a comment.
     * 
     * @param int $cid
     * 
     * @return int : Sum of votes on comment.
     */
    public function getVotesOfComment($cid, $uid = null) {
        $sql = "SELECT IFNULL(SUM(value), 0) AS votes FROM CommentVote WHERE cid = :cid";
        $query = $this->db->prepare($sql);
        $query->execute(array(':cid' => $cid));
        
        $sum = $query->fetch();
        return $sum;
    }
    
    /**
     * Get votes on a comment by a user.
     * 
     * @param int $cid
     * @param int $uid
     * 
     * @return int : Value of vote.
     */
    public function getVotesOfCommentBy($cid, $uid) {
        $sql = "SELECT IFNULL(SUM(value), 0) AS value FROM CommentVote WHERE cid = :cid AND uid = :uid";
        $query = $this->db->prepare($sql);
        $query->execute(array(':cid' => $cid, ':uid' => $uid));
        
        $votes = $query->fetch();
        return $votes;
    }
}
