<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container-post">
    <div class="vote-panel" style="display: inline-block; vertical-align: top">
        <a class="upvote <?php if ($this->vote->getVotesOfCommentBy($comment->cid, $_SESSION['user']['uid'])->value > 0) { echo 'active'; } ?>"
        href="<?php echo URL_WITH_INDEX_FILE; ?>votes/comment/<?php echo $comment->cid?>/upvote">&#x25B2;</a>
        <div class="count"><?php echo $this->vote->getVotesOfComment($comment->cid)->votes; ?></div>
        <a class="downvote <?php if ($this->vote->getVotesOfCommentBy($comment->cid, $_SESSION['user']['uid'])->value < 0) { echo 'active'; } ?>"
        href="<?php echo URL_WITH_INDEX_FILE; ?>votes/comment/<?php echo $comment->cid ?>/downvote">&#x25BC;</a>
    </div>
    <div class="container-content" style="display: inline-block">
        <font color="orange"><?php echo $comment->author; ?></font> on <font color="green"><?php echo $comment->submitted; ?></font>
        <p><h4><?php echo $comment->content ?></h4></p>
    </div>
</div>