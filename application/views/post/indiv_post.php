<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<?php
    //$pid = $this->pid;
        if ($post): ?>
            <?php
                require APP . 'views/post/post.php';
            ?>
            <p><h3><?php echo $post->content ?></h3></p>
                
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
                    <a href="<?php echo URL_WITH_INDEX_FILE; ?>post/edit/<?php echo $pid; ?>">Edit</a>&nbsp;    
                    <?php endif; ?>
                    <?php if (($_SESSION['user']['uid'] === $post->uid) || ($_SESSION['user']['isAdmin'])) : ?>
                    <a href="<?php echo URL_WITH_INDEX_FILE; ?>post/delete/<?php echo $pid; ?>">Delete</a>&nbsp;
                    <?php endif; ?>
                    <a href="<?php echo URL_WITH_INDEX_FILE; ?>post/report/<?php echo $pid; ?>">Report</a>&nbsp;
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
                        <div class="container-post">
                            <div class="vote-panel" style="display: inline-block; vertical-align: top">
                                <a class="upvote <?php if ($this->vote->getVotesOfCommentBy($cid, $_SESSION['user']['uid'])->value > 0) { echo 'active'; } ?>"
                                    href="<?php echo URL_WITH_INDEX_FILE; ?>votes/comment/<?php echo $cid?>/upvote">&#x25B2;</a>
                                <div class="count"><?php echo $this->vote->getVotesOfComment($cid)->votes; ?></div>
                                <a class="downvote <?php if ($this->vote->getVotesOfCommentBy($cid, $_SESSION['user']['uid'])->value < 0) { echo 'active'; } ?>"
                                    href="<?php echo URL_WITH_INDEX_FILE; ?>votes/comment/<?php echo $cid ?>/downvote">&#x25BC;</a>
                            </div>
                            <div class="container-content" style="display: inline-block">
                                
                                <font color="orange"><?php echo $comment->author; ?></font> on <font color="green"><?php echo $comment->submitted; ?></font>
                                <p><h4><?php echo $comment->content ?></h4></p>
                            </div>
                        </div>
                        <div class = "container-manage-post">
                            <?php if (array_key_exists('user', $_SESSION)): ?>
                            <p align = 'right'>
                            <?php if ($_SESSION['user']['uid'] === $comment->uid): ?>
                                <a href="<?php echo URL_WITH_INDEX_FILE; ?>comment/edit/<?php echo $cid; ?>">Edit</a>&nbsp;    
                            <?php endif; ?>
                            <?php if (($_SESSION['user']['uid'] === $comment->uid) || ($_SESSION['user']['isAdmin'])) : ?>
                                <a href="<?php echo URL_WITH_INDEX_FILE; ?>comment/delete/<?php echo $cid; ?>">Delete</a>&nbsp;
                            <?php endif; ?>
                            <a href="<?php echo URL_WITH_INDEX_FILE; ?>comment/report/<?php echo $comment->uid; ?>">Report</a>&nbsp;
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
