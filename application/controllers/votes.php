<?php

/**
 * Class VoteController
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class VotesController extends Controller {
    /**
     * AJAX/JSON ACTION: post
     * 
     * @param int $pid : The post id.
     * @param string $action [upvote|downvote] optional
     * 
     *  METHOD: HTTP GET
     *   URL: votes/post/$pid
     *   e.g. votes/post/1
     * 
     *  METHOD: HTTP POST
     *   URL: votes/post/$pid/$action
     *   e.g. votes/post/1/upvote
     * 
     * @return JSON
     *  { votes: int,
     *    action: string [upvote|downvote]
     *  }
     */
    public function post($pid, $action = null) {
        if (!isset($pid)) {
            echo json_encode(array('message' => 'pid not present.'));
        }
        
        // If we have POST data, this is a upvote or downvote.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user'])) {
                echo json_encode(array('message' => 'You need to login or register to vote!'));
                exit(); return;
            }
            
            $uid = $_SESSION['user']['uid'];
            
            $currentVote = $this->vote->getVotesOfPostBy($pid, $uid)['value'];
            
            if (($action === 'upvote' && $currentVote > 0)
                || ($action === 'downvote' && $currentVote < 0)) // If unvoting...
            {
                $result = $this->vote->unvotePost($pid, $uid);
                $result['action'] = 'unvote';
            } else if ($action === 'upvote') { // If upvoting...
                $result = $this->vote->upvotePost($pid, $uid);
                $result['action'] = 'upvote';
            } else if ($action === 'downvote') { // If downvoting...
                $result = $this->vote->downvotePost($pid, $uid);
                $result['action'] = 'downvote';
            }
        }
        
        // If we have GET data, this is a request to get the number of votes.
        // A POST data without an action will just return the number of votes.
        if (!isset($result)) {
            $result = $this->vote->getVotesOfPost($pid);   
        }
        
        // Return the new vote count.
        echo json_encode($result);
    }
    
    /**
     * AJAX/JSON ACTION: comment
     * 
     * @param int $cid : The comment id.
     * @param string $action [upvote|downvote] optional
     * 
     *  METHOD: HTTP GET
     *   URL: votes/comment/$cid
     *   e.g. votes/comment/1
     * 
     *  METHOD: HTTP POST
     *   URL: votes/comment/$cid/$action
     *   e.g. votes/comment/1/upvote
     * 
     * @return JSON
     *  { votes: int }
     */
    public function comment($cid, $action = null) {
        if (!isset($cid)) {
            echo json_encode(array('message' => 'cid not present.'));
        }
        
        // If we have POST data, this is a upvote or downvote.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user'])) {
                echo json_encode(array('message' => 'You need to login or register to vote!'));
                exit(); return;
            }
            
            if ($action === 'upvote') {
                $result = $this->vote->upvoteComment($cid, $_SESSION['user']['uid']);
            } else if ($action === 'downvote') {
                $result = $this->vote->downvoteComment($cid, $_SESSION['user']['uid']);
            }
        }
        
        // If we have GET data, this is a request to get the number of votes.
        // A POST data without an action will just return the number of votes.
        if (!isset($result)) {
            $result = $this->vote->getVotesOfComment($cid);   
        }
        
        // Return the new vote count.
        echo json_encode($result);
    }
    
    public function loadModel() {
        require APP . '/models/vote.php';
        $this->vote = new Vote($this->db);
    }
}
