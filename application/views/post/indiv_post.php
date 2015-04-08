<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<?php
    //$pid = $this->pid;
        if ($post): ?>
            <?php
                require APP . 'views/post/post.php';
            ?>
            <p><h3><?php echo nl2br($post->content) ?></h3></p>
            <?php if ($post->link): ?>
                <p><h4><a href="<?php echo $post->link ?>"><?php echo $post->link ?></a>&nbsp;</h4></p>
            <?php endif; ?>
                
            <?php if ($tags): ?>
                <p align = 'left'>
                <?php foreach($tags as $tag) { ?>
                   <a href="<?php echo URL_WITH_INDEX_FILE; ?>feed/<?php echo $tag->tagname; ?>">#<?php echo $tag->tagname; ?></a>&nbsp;
                <?php } ?>
                </p>
            <?php endif; ?>
            <div class = "container-manage-post">
                <?php if (array_key_exists('user', $_SESSION)): ?>
                <p align = 'right'>
                    <?php if ($_SESSION['user']['uid'] === $post->uid): ?>
                        <a href="<?php echo URL_WITH_INDEX_FILE; ?>post/editpost/<?php echo $pid; ?>">Edit</a>&nbsp;    
                    <?php endif; ?>
                    <?php if (($_SESSION['user']['uid'] === $post->uid) || ($_SESSION['user']['isAdmin'])) : ?>
                        <a href="<?php echo URL_WITH_INDEX_FILE; ?>post/hide/<?php echo $pid; ?>">Delete</a>&nbsp;
                    <?php endif; ?>
                    <?php if ($this->post->hasUnreviewedReport($_SESSION['user']['uid'], $pid)): ?>
                        <font color="blue">Reported!</font>&nbsp;
                    <?php elseif ($this->post->hasReviewedReport($_SESSION['user']['uid'], $pid)): ?>
                        <font color="gray">Report  closed.</font>&nbsp;
                    <?php else: ?>
                        <a href="<?php echo URL_WITH_INDEX_FILE; ?>post/report/<?php echo $pid; ?>">Report</a>&nbsp;
                    <?php endif; ?>
                <?php endif; ?>                    
            </div>
            <hr>
            <?php
                require APP . 'views/comment/new.php';
            ?>
            <hr>
            <div class = "container-comments">
                <?php if ($comment_list): ?>
                    <div align = "center"><h3> Comments </h3>
                    </div>
                    <?php foreach($comment_list as $comment) { ?>
                        <?php $cid = $comment->cid; ?>
                        <?php require APP . 'views/comment/comment.php'; ?>
                        <div class = "container-manage-post">
                            <?php if (array_key_exists('user', $_SESSION)): ?>
                                <p align = 'right'>
                                <?php if ($_SESSION['user']['uid'] === $comment->uid): ?>
                                    <a href="<?php echo URL_WITH_INDEX_FILE; ?>comment/edit/<?php echo $cid; ?>">Edit</a>&nbsp;    
                                <?php endif; ?>
                                <?php if (($_SESSION['user']['uid'] === $comment->uid) || ($_SESSION['user']['isAdmin'])): ?>
                                    <a href="<?php echo URL_WITH_INDEX_FILE; ?>comment/delete/<?php echo $cid; ?>">Delete</a>&nbsp;
                                <?php endif; ?>
                                <?php if ($this->comment->hasUnreviewedReport($_SESSION['user']['uid'], $cid)): ?>
                                    <font color="blue">Reported!</font>&nbsp;
                                <?php elseif ($this->comment->hasReviewedReport($_SESSION['user']['uid'], $cid)): ?>
                                    <font color="gray">Report closed.</font>&nbsp;
                                <?php else: ?>
                                    <a href="<?php echo URL_WITH_INDEX_FILE; ?>comment/report/<?php echo $cid; ?>">Report</a>&nbsp;
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <hr>
                    <?php } ?>
                <?php else: ?>
                    No Comments.
                <?php endif; ?> 
            </div>
        <?php else: ?>
            <h2>Post does not exist! </h2>
        <?php endif; ?>
