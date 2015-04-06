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
    public function index($pid = null)
    {
        if ($pid !== null) {
            if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
                if (isset($_POST['comment']) && trim($_POST['comment']) !=='') {
                    $user = $this->comment->addComment($_POST['comment'], $_SESSION['user']['uid'], $pid);
                    header('location: ' . URL_WITH_INDEX_FILE . 'post/' . $pid);
                }
            }
            
            $post = $this->post->getPostInformation($pid);
            if ($post) {
                $tags = $this->post->getTagsOfPost($pid);
                $comment_list = $this->comment->getAllCommentsOfPost($pid);
                require APP . 'views/_templates/header.php';
                require APP . 'views/post/indiv_post.php';
                require APP . 'views/_templates/footer.php';
            } else {
                header('location: ' . URL_WITH_INDEX_FILE . 'home/');
            }
        } else {
            header('location: ' . URL_WITH_INDEX_FILE . 'feed/');
        }
    }
    
    public function newpost()
    {
        
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $user = $_SESSION['user']['uid'];
            $tags = explode(",", $_POST['tags']);
            $tags = array_map('trim', $tags);
            $tags = array_filter($tags, 'strlen');
            $submitted = date('Y-m-d H:i:s');
            
            if(empty($title) || empty($content)) {
                $message = 'Title and content cannot be empty!';
            } else {
                $response = $this->post->writePost($title, $content, $submitted, $user, $tags);
                header('location: ' . URL_WITH_INDEX_FILE . 'post/' . $response);
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
        
        // Load votes model to count votes on template load.
        require APP . '/models/vote.php';
        $this->vote = new Vote($this->db);
    }
    
    
    
}
