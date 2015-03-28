<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container">
    <h2>You are in the View: application/views/home/index.php (everything in the box comes from this file)</h2>
    <p>In a real application this could be the homepage.</p>
    
    <p> Test Post with ID 1
    

    <!--<a href="<?php //echo URL_WITH_INDEX_FILE; ?>comment.php?pID=<?php ?>"> DO THE PHP THING TO GET ID BUT FOR NOW-->
        <a href="<?php echo URL_WITH_INDEX_FILE; ?>post/comment/?pid=1">Post 1</a>
    <!--'location: ' . URL_WITH_INDEX_FILE . 'register/complete'-->
    </p>
    <p> Test Post with ID 2
    <a href="<?php echo URL_WITH_INDEX_FILE; ?>post/comment/?pid=2">Post 2</a>
    </p>
</div>
