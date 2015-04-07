<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container">
  <div class="feeds">
    <h3> Manage your feed subscription </h3>
    <p> Click on tags to unsubscribe to them.</p>
      <ul class="pagination">
        <?php
          foreach ($feeds as $feed) {
        ?>
        <li><a href="<?php echo URL_WITH_INDEX_FILE; ?>feed/unsubscribe/<?php echo $feed->tag ?>"><?php echo $feed->tag ?></a></li>
        <?php
          }
        ?>
      </ul>
    <p> Subscribe to a tag (one tag at a time) </p>
     <form action="" method="POST">
        <div>
            <span>Tag</span>
            <input placeholder="tag name" type="text" name="tag">
            <input type="submit" value="Add tag">
        </div>
        <?php if(isset($message)) { echo $message;} ?>
        
    </form>
    <hr>
    <p><a href="<?php echo URL_WITH_INDEX_FILE; ?>feed">Back to feeds</a></p>
  </div>
</div>