<?php

/**
 * Class PostController
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class PostController extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/post/index (which is the default page btw)
     */
    public function index($pid)
    {
        
       if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
           if (isset($_POST['comment']) && trim($_POST['comment']) !=='')
            $user = $this->comment->addComment($_POST['comment'], $_SESSION['user']['uid'], $pid);
            header('location: ' . URL_WITH_INDEX_FILE . 'post/' . $pid);
       }
        
        $this->pid = $pid;
            require APP . 'views/_templates/header.php';
            require APP . 'views/post/indiv_post.php';
            require APP . 'views/_templates/footer.php';
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
