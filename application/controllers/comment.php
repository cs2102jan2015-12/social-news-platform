<?php

/**
 * Class CommentController
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class CommentController extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/post/index (which is the default page btw)
     */
    public function edit($cid)
    {
        $pid = $this->comment->getParent($cid);
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
                if (isset($_POST['comment']) && trim($_POST['comment']) !=='') {
                    $comment = htmlentities(rtrim($_POST['comment']));
                    $this->comment->editComment($cid, $comment);
                    header('location: ' . URL_WITH_INDEX_FILE . 'post/' . $pid->parent);
                }
            }
            $comment = $this->comment->getComment($cid);
           
            require APP . 'views/_templates/header.php';
            require APP . 'views/comment/edit.php';
            require APP . 'views/_templates/footer.php';
    }
    
    public function delete($cid)
    {
        $this->comment->hideComment($cid);
        $pid = $this->comment->getParent($cid);
        header('location: ' . URL_WITH_INDEX_FILE . 'post/' . $pid->parent);
    }
    public function report($cid) {
        $this->comment->reportComment($_SESSION['user']['uid'], $cid);
        $pid = $this->comment->getParent($cid);
        header('location: ' . URL_WITH_INDEX_FILE . 'post/' . $pid->parent);
    }
    
    /**
     * Overloaded loadModel() method. This method is called on __construct().
     */
    public function loadModel()
    {
        require APP . '/models/post.php';
        // create new "model" (and pass the database connection)
        $this->post = new Post($this->db);
        require APP . '/models/comment.php';
        // create new "model" (and pass the database connection)
        $this->comment = new Comment($this->db);
    }
    
    
    
}
