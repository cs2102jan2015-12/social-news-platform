<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container-post">
    <div class="vote-panel" style="display: inline-block">
        <a class="upvote <?php if ($this->vote->getVotesOfPostBy($post->pid, $_SESSION['user']['uid'])->value > 0) { echo 'active'; } ?>"
           href="<?php echo URL_WITH_INDEX_FILE; ?>votes/post/<?php echo $post->pid ?>/upvote">&#x25B2;</a>
        <div class="count"><?php echo $this->vote->getVotesOfPost($post->pid)->votes; ?></div>
        <a class="downvote <?php if ($this->vote->getVotesOfPostBy($post->pid, $_SESSION['user']['uid'])->value < 0) { echo 'active'; } ?>"
           href="<?php echo URL_WITH_INDEX_FILE; ?>votes/post/<?php echo $post->pid ?>/downvote">&#x25BC;</a>
    </div>
    <div class="container-content" style="display: inline-block">
        <?php echo $post->title; ?><br>
        submitted by <font color="orange"><?php echo $post->author; ?></font> on <font color="green"><?php echo $post->submitted; ?></font>
    </div>
</div>