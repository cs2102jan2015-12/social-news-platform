<?php

class testPostController extends Controller {
    
     
    public function loadmodel()
    {
        require APP . '/models/post.php';
        $this->post = new Post($this->db);
    }
    
    public function testDoPost() {
        $result = $this->post->doPost();
        echo $result;
        exit();
    }
    
    public function testWritePost() {
        $result = $this->post->writePost("This be title", "content so cool pro", 2015/4/1, 2, array("tag1", "tag2", "tag3"));
        echo var_dump($result);
        exit();
    }
    
    public function testWritePost2() {
        $result = $this->post->writePost("Another title", "So content much write", 2015/4/2, 2, array("tag2", "tag4", "tag5"));
        echo var_dump($result);
        exit();
    }
    
    public function testEditPost() {
        $result = $this->post->editPost(4, "Changed title", "So content much modify", array("tag1", "tag3", "tag5"));
        exit();
    }
    
    public function testHidePost() {
        $result = $this->post->hidePost(3);
        exit();
    }
    
    public function testUnhidePost() {
        $result = $this->post->unhidePost(3);
        exit();
    }
    
    public function testDeletePost() {
        $result = $this->post->deletePost(4);
        exit();
    }

}