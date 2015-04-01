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
        
        //if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
          //  $post = $this->model->writePost($_POST['title'], $_POST['content'], $_POST['date'], $_POST['author']);
        //}
        
        $this->pid = $pid;
       // if (is_int($pid)) {
            // load views
            require APP . 'views/_templates/header.php';
            require APP . 'views/post/indiv_post.php';
            require APP . 'views/_templates/footer.php';
        //} else {
            //require APP . 'views/_templates/header.php';
           // require APP . 'views/error/message.php';
           // require APP . 'views/_templates/footer.php';
        //}
    }

    /**
     * PAGE: individual posts with comments
     * This method handles what happens when you move to http://yourproject/post/comments/____
     * The camelCase writing is just for better readability. The method name is case-insensitive.
     */
    public function comment()
    {
        // load views
        require APP . 'views/_templates/header.php';
        require APP . 'views/post/comment.php'; 
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
