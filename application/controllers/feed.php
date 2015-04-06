<?php

/**
 * Class Feed
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class FeedController extends Controller
{
    /**
     * PAGE: index
     */
    public function index($tag_name=NULL)
    {
        if (isset($tag_name)) {
            $posts = $this->posts->getPosts($tag_name); 
        } else {
            $posts = $this->posts->getAllPosts();
        }

        // load views
        require APP . 'views/_templates/header.php';
        
        $feeds = $this->feeds->getAllFeeds();
        
        if (isset($feeds)) {
            require APP . 'views/feed/feeds.php';
        }
        
        require APP . 'views/feed/posts.php';
        require APP . 'views/_templates/footer.php';
    }
    
    /**
     * Loads the "model".
     * @return object model
     */
    public function loadModel()
    {
        require APP . '/models/feed.php';
        $this->feeds = new Feed($this->db);
        
        require APP . '/models/post.php';
        $this->posts = new Post($this->db);
        
        // Load votes model to count votes on template load.
        require APP . '/models/vote.php';
        $this->vote = new Vote($this->db);
    }
}
