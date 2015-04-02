<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container-post">

   <?php
        $pid = $this->pid;
        if (!empty($pid)) {
        
            $post = $this->post->getPostInformation($pid);
            $tags = $this->post->
                
            if ($post) {
                
                echo "<h2>" . $post->title . "</h2>";
                ?>
                
                <div class="container-content">
                    <p><h3><?php echo $post->content ?></h3></p>
                    <p align = "right">Authored by <font color="orange"><?php echo $post->author; ?></font></p>
                    <p align = "right">Submitted on <font color="green"><?php echo $post->submitted; ?></font></p>
                    
                </div>
                <?php
                
            } else {
                echo "<h2>Post does not exist! </h2>";
            }
            
        } else {
            echo "<h2> Empty post number. </h2>";
        }
        
    ?>
</div>
<div class = "container-newcomment">
    <?php
    
    if (!empty($pid)) {
        if (array_key_exists('user', $_SESSION)) { ?>
            <h3>Post Comment</h3>
            <form action="" id="cmtform" method="POST">
            <div>
                <textarea style=" width:100%; max-width: 100%; min-width: 100%" name="comment" form="cmtform" placeholder = "Write here..."></textarea>
            </div>
        
            <input type="submit" value="Send">
            </form>
    
        <?php } else { ?>
            <h3>Login to comment!</h3>
            <a href="<?php echo URL_WITH_INDEX_FILE; ?>auth/login">Login</a>
    <?php 
        }
    }
    ?>
    
    
</div>
<div class = "container-comments">
   <?php
        
        if (!empty($pid)) {
            $postID = $pid;
        
            $comment_list = $this->comment->getAllCommentsOfPost($postID);
                
            if ($comment_list) { ?>
                <div align = "center"><h3> Comments </h3></div>
                <?php
                foreach($comment_list as $comment) {
                 echo "<h4>" . $comment->author . "</h4>";
                ?>
                
                <div class="container-content">
                    <p><h5><?php echo $comment->content ?></h5></p>
                    <!-- <p align = "right">Authored by <font color="orange"><?php //echo $comment->author; ?></font></p> -->
                    <p align = "right">Submitted on <font color="green"><?php echo $comment->submitted; ?></font></p>
                    
                </div>
                
                <?php
                }
            } else {
                echo "No Comments.";
            }
            
        } 
        
    ?>
    
</div>
