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
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
        // load views
        require APP . 'views/_templates/header.php';
        require APP . 'views/post/index.php';
        require APP . 'views/_templates/footer.php';
    }

    /**
     * PAGE: individual posts with comments
     * This method handles what happens when you move to http://yourproject/post/comments/____
     * The camelCase writing is just for better readability. The method name is case-insensitive.
     */
    public function individualPost()
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
        require APP . '/models/posts.php';
        // create new "model" (and pass the database connection)
        $this->post = new Post($this->db);
        require APP . '/models/comment.php';
        // create new "model" (and pass the database connection)
        $this->comment = new Comment($this->db);
    }

}
