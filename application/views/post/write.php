<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container">
    
    <?php if (array_key_exists('user', $_SESSION)) { ?>
    <h2>Create a new post</h2>
    
    <form action="newpost" method="POST">
        <div>
            <span>Title</span>
            <input type="text" name="title">
        </div>
        <div>
            <span>Content</span>
            <input type="textarea" name="content">
        </div>
        <div>
            <span>Tags</span>
            <input type="text" name="tags">
        </div>
        <input type="submit" value="Submit">
    </form>
    
    <?php } else { ?>
    <h2>Please come back as a member!</h2>
    <a href="<?php echo URL_WITH_INDEX_FILE; ?>">Newpost</a>
    <?php } ?>
</div>