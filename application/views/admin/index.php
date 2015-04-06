<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container">
    <div class="reported-posts">
        <h2>Reported Posts</h2>
        <?php foreach ($reportedPosts as $post) { ?>
            <?php require APP . 'views/post/post.php'; ?>
            <span>Reported by <?php echo $post->reporter; ?> on <?php echo $post->reportedTime ?></span>
        <?php } ?>
    </div>
    
    <div class="reported-comments">
        <h2>Reported Comments</h2>
        <?php foreach ($reportedComments as $comment) { ?>
            <h4><?php echo $comment->author; ?></h4>
                <div class="container-content">
                    <p><h5><?php echo $comment->content ?></h5></p>
                <!-- <p align = "right">Authored by <font color="orange"><?php //echo $comment->author; ?></font></p> -->
                <p align = "right">Submitted on <font color="green"><?php echo $comment->submitted; ?></font></p>
                
            </div>
            <span>Reported by <?php echo $post->reporter; ?> on <?php echo $post->reportedTime ?></span>
        <?php } ?>
    </div>
</div>
