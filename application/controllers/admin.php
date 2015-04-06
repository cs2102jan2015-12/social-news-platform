<?php

/**
 * Class AdminController
 */
class AdminController extends Controller
{
    /**
     * PAGE: index
     *
     * If this is a GET request, display the page.
     *
     * If this is a POST request, log the user in if credentials are right.
     */
    public function index() {
        if (!$_SESSION['user']['isAdmin']) {
            header('location: ' . URL_WITH_INDEX_FILE . '');
        }
        require APP . 'views/_templates/header.php';
        require APP . 'views/admin/index.php';
        require APP . 'views/_templates/footer.php';
    }

    public function loadModel()
    {
        // require APP . '/models/post.php';
        // $this->post = new Post($this->db);
    }
}
