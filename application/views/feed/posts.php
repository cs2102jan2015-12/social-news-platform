<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container">
    <?php
      foreach ($posts as $post) {
        require APP . 'views/post/post.php';
    ?>
        <hr>
    <?php
      }
    ?>
</div>
