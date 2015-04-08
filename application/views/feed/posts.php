<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container">
  <div class="page-header">
    <h1><a href="<?php echo URL_WITH_INDEX_FILE; ?>feed/<?php echo $tag ?>"><?php echo $tag ?></a></h1>
  </div>
    <?php
      foreach ($posts as $post) {
        require APP . 'views/post/post.php';
    ?>
        <hr>
    <?php
      }
    ?>
</div>
