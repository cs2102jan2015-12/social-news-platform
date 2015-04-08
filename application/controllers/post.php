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

        $post = $this->post->getPostInformation($pid);

        require APP . 'views/_templates/header.php';
        require APP . 'views/post/indiv_post.php';
        require APP . 'views/_templates/footer.php';
    }
    
    /**
     * 
     */
    public function newpost() {
        
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $link = $_POST['link'];
            $user = $_SESSION['user']['uid'];
            $tags = explode(",", $_POST['tags']);
            $tags = array_map('trim', $tags);
            $tags = array_filter($tags, 'strlen');
            $submitted = date('Y-m-d H:i:s');
            
            if(empty($title) || empty($content)) {
                $message = 'Title and content cannot be empty!';
            } elseif (strlen($content) > 65535) {
                $message = 'The content is too long!';
            } elseif (strlen($title) > 255) {
                $message = 'The title is too long!';
            } elseif (!filter_var($link, FILTER_VALIDATE_URL)) {
                $message = "Please enter a valid link!";
            } else {
                $response = $this->post->writePost($title, $content, $link, $submitted, $user, $tags);
                header('location: ' . URL_WITH_INDEX_FILE . 'post/' . $response);
            }
        }
        
        // load views
        require APP . 'views/_templates/header.php';
        require APP . 'views/error/message.php';
        require APP . 'views/post/writenew.php';
        require APP . 'views/_templates/footer.php';
    }
    
    public function editpost($pid) {
        
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'GET') {
            
            $response = $this->post->getPostInformation($pid);
            
            $title = $response->title;
            $content = $response->content;
            $link = $response->link;
            
            $tagString = "";
            $response = $this->post->getPostTags($pid);
            
            foreach ($response as $tagInfo) {
                $tagString .= $tagInfo->tagName;
                $tagString .= ", ";
            }
            $tagString = substr($tagString, 0, -2); // remove the last ", "
        }
        
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
            
            $title = $_POST['title'];
            $content = $_POST['content'];
            $link = $_POST['link'];
            $tags = explode(",", $_POST['tags']);
            $tags = array_map('trim', $tags);
            $tags = array_filter($tags, 'strlen');
            
            $tagLengthOK = 1;
            foreach ($tags as $tag) {
                if (strlen($tag) > 255) {
                    $tagLengthOK = 0;
                    break;
                }
            }
            
            if(empty($title) || empty($content) || empty($tags)) {
                $message = 'Title and content and tags cannot be empty!';
            } elseif (strlen($content) > 65535) {
                $message = 'The content is too long!';
            } elseif (strlen($title) > 255) {
                $message = 'The title is too long!';
            } elseif ($tagLengthOK == 0) {
                $message = 'One of the tags is too long!';
            } elseif (!filter_var($link, FILTER_VALIDATE_URL)) {
                $message = "Please enter a valid link!";
            } else {
                $response = $this->post->editPost($pid, $title, $content, $link, $tags);
                header('location: ' . URL_WITH_INDEX_FILE . 'post/' . $response);
            }
            
        }
        
        require APP . 'views/_templates/header.php';
        require APP . 'views/error/message.php';
        require APP . 'views/post/writemod.php'; 
        require APP . 'views/_templates/footer.php';
        
    }
    
    public function delete($pid) {
        $this->post->deletePost($pid);
        
    }
    
    public function hide($pid) {
        $this->post->hidePost($pid);
    }
    
    public function unhide($pid) {
        $this->post->unhidePost($pid);
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
