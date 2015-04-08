<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container">
  <div class="feeds">
    <h3> Manage Feeds</h3>
    <p>Unfollow tags by clicking them.</p>
      <ul class="pagination">
        <?php
          foreach ($feeds as $feed) {
        ?>
        <li><a href="<?php echo URL_WITH_INDEX_FILE; ?>feed/unsubscribe/<?php echo $feed->tid ?>"><?php echo $feed->tag ?></a></li>
        <?php
          }
        ?>
      </ul>
    <p>Follow tags, one at a time.</p>
     <form action="" method="POST">
        <div>
            <span>Tag</span>
            <input placeholder="tag name" type="text" name="tag">
            <input type="submit" value="Add tag">
        </div>
        <br>
        <font color="orange"><?php if(isset($message)) { echo $message;} ?></font>
        
    </form>
    <hr>
    <p><a href="<?php echo URL_WITH_INDEX_FILE; ?>feed">Back to feeds</a></p>
  </div>
</div>