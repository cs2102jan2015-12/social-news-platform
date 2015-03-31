<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container">
    <?php
      foreach ($posts as $post) {
    ?>
    <li><a href="<?php echo URL_WITH_INDEX_FILE; ?>post/<?php echo $post->pid; ?>"><?php echo $post->title; ?></a> authored by <?php echo $post->username; ?> submitted on <?php echo $post->submitted; ?></li>
    <?php
      }
    ?>
</div>
