<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container-post">
    <div class="vote-panel">
        <a class="upvote <?php if ($this->vote->getVotesOfPostBy($post->pid, $_SESSION['user']['uid'])->value > 0) { echo 'active'; } ?>"
           href="<?php echo URL_WITH_INDEX_FILE; ?>votes/post/<?php echo $post->pid ?>/upvote">&#x25B2;</a>
        <span class="count"><?php echo $this->vote->getVotesOfPost($post->pid)->votes; ?></span>
        <a class="downvote <?php if ($this->vote->getVotesOfPostBy($post->pid, $_SESSION['user']['uid'])->value < 0) { echo 'active'; } ?>"
           href="<?php echo URL_WITH_INDEX_FILE; ?>votes/post/<?php echo $post->pid ?>/downvote">&#x25BC;</a>
    </div> 
   <?php
        if ($post) {
            
            echo "<h2>" . $post->title . "</h2>";
            ?>
            
            <div class="container-content">
                <p align = "right">Authored by <font color="orange"><?php echo $post->author; ?></font></p>
                <p align = "right">Submitted on <font color="green"><?php echo $post->submitted; ?></font></p>
                
            </div>
            <?php
            
        } else {
            echo "<h2>Post does not exist! </h2>";
        }
    ?>
</div>