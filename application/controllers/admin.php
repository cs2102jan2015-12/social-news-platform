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
    
    public function close($type, $id) {
        if (!$_SESSION['user']['isAdmin']) {
            header('location: ' . URL_WITH_INDEX_FILE . '');
        }
        
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
            if ($type === "post") {
                $this->post->closeReport($id);
            }
            if ($type === "comment") {
                $this->comment->closeReport($id);
            }
        }
        
        return $this->index();
    }
    
    public function hide($type, $id) {
        if (!$_SESSION['user']['isAdmin']) {
            header('location: ' . URL_WITH_INDEX_FILE . '');
        }
        
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
            if ($type === "post") {
                $this->post->hidePost($id);
                $this->post->closeReport($id);
            }
            if ($type === "comment") {
                $this->comment->hideComment($id);
                $this->comment->closeReport($id);
            }
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
