<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container">
  <div class="feeds">
    <nav>
      <ul class="pagination">
        <li>
          <a href="#" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
            <?php
              foreach ($feeds as $feed) {
            ?>
            <li><a href="<?php echo URL_WITH_INDEX_FILE; ?>feed/<?php echo $feed->tag ?>"><?php echo $feed->tag ?></a></li>
            <?php
              }
            ?>
        <li>
          <a href="#" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</div>