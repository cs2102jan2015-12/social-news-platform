<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container">
    <div class="reported-posts">
        <h2>Reported Posts</h2>
        <?php foreach ($reportedPosts as $post) { ?>
            <?php require APP . 'views/post/post.php'; ?>
            <span>Reported by <?php echo $post->reporter; ?> on <?php echo $post->reportedTime ?></span>
            <form action="<?php echo URL_WITH_INDEX_FILE; ?>admin/hide/post/<?php echo $post->pid; ?>" method="POST">
                <input type="submit" value="Hide & Close">
            </form>
            <form action="<?php echo URL_WITH_INDEX_FILE; ?>admin/close/post/<?php echo $post->pid; ?>" method="POST">
                <input type="submit" value="Close">
            </form>
        <?php } ?>
    </div>
    
    <div class="reported-comments">
        <h2>Reported Comments</h2>
        <?php foreach ($reportedComments as $comment) { ?>
            <?php require APP . 'views/comment/comment.php'; ?>
            <span>Reported by <?php echo $comment->reporter; ?> on <?php echo $comment->reportedTime ?></span>
            <form action="<?php echo URL_WITH_INDEX_FILE; ?>admin/hide/comment/<?php echo $comment->cid; ?>" method="POST">
                <input type="submit" value="Hide & Close">
            </form>
            <form action="<?php echo URL_WITH_INDEX_FILE; ?>admin/close/comment/<?php echo $comment->cid; ?>" method="POST">
                <input type="submit" value="Close">
            </form>
        <?php } ?>
    </div>
</div>
