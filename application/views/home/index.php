<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container">
    
    <h2>Hi. </h2>
    
    <p> Go to <a href="<?php echo URL_WITH_INDEX_FILE; ?>feed">Feeds!</a> </p>
    
    <h2>Yo. </h2>
    
    <p><a href="<?php echo URL_WITH_INDEX_FILE; ?>post/newpost">Create new Post!</a> </p>
</div>
