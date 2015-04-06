<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container-post">
<?php
    $pid = $this->pid;
    if (!empty($pid)): ?>
    
        <?php $post = $this->post->getPostInformation($pid);
        $tags = $this->post->getTagsOfPost($pid);
        if ($post): ?>
        <?php
    require APP . 'views/post/post.php';
?>
            <div class="vote-panel">
                <a class="upvote <?php if ($this->vote->getVotesOfPostBy($pid, $_SESSION['user']['uid'])->value > 0) { echo 'active'; } ?>"
                href="<?php echo URL_WITH_INDEX_FILE; ?>votes/post/<?php echo $pid ?>/upvote">&#x25B2;</a>
                <span class="count"><?php echo $this->vote->getVotesOfPost($pid)->votes; ?></span>
                <a class="downvote <?php if ($this->vote->getVotesOfPostBy($pid, $_SESSION['user']['uid'])->value < 0) { echo 'active'; } ?>"
                    href="<?php echo URL_WITH_INDEX_FILE; ?>votes/post/<?php echo $pid ?>/downvote">&#x25BC;</a>
            </div> 
            
            <h2><?php echo $post->title; ?></h2>
            
            <div class="container-content">
                <p><h3><?php echo $post->content ?></h3></p>
                <p align = "right">Authored by <font color="orange"><?php echo $post->author; ?></font></p>
                <p align = "right">Submitted on <font color="green"><?php echo $post->submitted; ?></font></p>
                <?php if ($tags): ?>
                    <p align = 'right'>
                    <?php foreach($tags as $tag) { ?>
                       <a href="<?php echo URL_WITH_INDEX_FILE; ?>feed/<?php echo $tag->tid; ?>">#<?php echo $tag->tagname; ?></a>&nbsp;
                    <?php } ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <h2>Post does not exist! </h2>
        <?php endif; ?>
    <?php else: ?>
        <h2> Empty post number. </h2>
    <?php endif; ?>
</div>
<div class = "container-newcomment">
    <?php if ($post): ?>
        <?php if (!empty($pid)):?>
            <?php if (array_key_exists('user', $_SESSION)): ?>
                <h3>Post Comment</h3>
                <form action="" id="cmtform" method="POST">
                    <div>
                        <textarea style=" width:100%; max-width: 100%; min-width: 100%" name="comment" form="cmtform" placeholder = "Write here..."></textarea>
                    </div>
                    <input type="submit" value="Send">
                </form>
    
            <?php else: ?>
                <h3>Login to comment!</h3>
                <a href="<?php echo URL_WITH_INDEX_FILE; ?>auth/login">Login</a>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
    
</div>
<div class = "container-comments">
    <?php if ($post): ?>
        <?php if (!empty($pid)):
            $postID = $pid;
        
            $comment_list = $this->comment->getAllCommentsOfPost($postID);
                
            if ($comment_list): ?>
                <div align = "center"><h3> Comments </h3></div>
                <?php foreach($comment_list as $comment) { ?>
                    
                    <?php $cid = $comment->cid; ?>
                    <h4><?php echo $comment->author; ?></h4>
                    <div class="vote-panel">
                        <a class="upvote <?php if ($this->vote->getVotesOfCommentBy($cid, $_SESSION['user']['uid'])->value > 0) { echo 'active'; } ?>"
                        href="<?php echo URL_WITH_INDEX_FILE; ?>votes/comment/<?php echo $cid ?>/upvote">&#x25B2;</a>
                        <span class="count"><?php echo $this->vote->getVotesOfComment($cid)->votes; ?></span>
                        <a class="downvote <?php if ($this->vote->getVotesOfCommentBy($cid, $_SESSION['user']['uid'])->value < 0) { echo 'active'; } ?>"
                       href="<?php echo URL_WITH_INDEX_FILE; ?>votes/comment/<?php echo $cid ?>/downvote">&#x25BC;</a>
                    </div> 
                    <div class="container-content">
                        <p><h5><?php echo $comment->content ?></h5></p>
                        <p align = "right">Submitted on <font color="green"><?php echo $comment->submitted; ?></font></p>
                    </div>
                
                <?php } ?>
            <?php else: ?>
                No Comments.
            <?php endif; ?> 
        <?php endif; ?>
    <?php endif; ?>
</div>
