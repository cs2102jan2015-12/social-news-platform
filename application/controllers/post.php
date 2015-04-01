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
    public function index()
    {
        
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
            $post = $this->model->writePost($_POST['title'], $_POST['content'], $_POST['date'], $_POST['author']);
        }
        
        // load views
        require APP . 'views/_templates/header.php';
        require APP . 'views/home/index.php';
        require APP . 'views/_templates/footer.php';
    }

    /**
     * 
     */
    public function newpost()
    {
        
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $user = $_SESSION['user']['uid'];
            $tags = explode(",", $_POST['tags']);
            $submitted = date("Y/m/d", $_SERVER['REQUEST_TIME']);
            
            if(empty($title) || empty($content)) {
                $message = 'Title and content cannot be empty!';
            } else {
                $this->post->writePost($title, $content, $submitted, $user, $tags);
                
            }
        }
        
        // load views
        require APP . 'views/_templates/header.php';
        require APP . 'views/error/message.php';
        require APP . 'views/post/writenew.php'; 
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
