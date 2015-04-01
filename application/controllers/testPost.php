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
        $result = $this->post->writePost("This be title", "content so cool pro", 2015/4/1, 100, array("tag1", "tag2", "tag3"));
        echo $result;
        exit();
    }
   

}