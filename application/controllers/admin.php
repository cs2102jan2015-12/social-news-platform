<?php

/**
 * Class AdminController
 */
class AdminController extends Controller
{
    /**
     * PAGE: index
     */
    public function index() {
        if (!$_SESSION['user']['isAdmin']) {
            header('location: ' . URL_WITH_INDEX_FILE . '');
        }
        
        $reportedPosts = $this->post->getReportedPosts();
        $reportedComments = $this->comment->getReportedComments();
        
        require APP . 'views/_templates/header.php';
        require APP . 'views/admin/index.php';
        require APP . 'views/_templates/footer.php';
    }
    
    public function hidePost($pid) {
        if (!$_SESSION['user']['isAdmin']) {
            header('location: ' . URL_WITH_INDEX_FILE . '');
        }
        
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
            $this->post->hidePost($pid);
        }
        
        return $this->index();
    }
    
    
    
    public function hidePost($cid) {
        if (!$_SESSION['user']['isAdmin']) {
            header('location: ' . URL_WITH_INDEX_FILE . '');
        }
        
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
            $this->comment->hideComment($pid);
        }
        
        return $this->index();
    }

    public function loadModel()
    {
        require APP . '/models/post.php';
        $this->post = new Post($this->db);
        require APP . '/models/comment.php';
        $this->comment = new Comment($this->db);
        
        // Load votes model to count votes on template load.
        require APP . '/models/vote.php';
        $this->vote = new Vote($this->db);
    }
}
