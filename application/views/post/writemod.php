<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container">
    
        <?php if (array_key_exists('user', $_SESSION)) { ?>
    <h2>Edit the post</h2>
    
    <form action="<?php echo $pid ?>" method="POST">
        <div>
            <span>Title<br></span>
            <input value="<?php echo $title; ?>" type="text" name="title">
        </div>
        <div>
            <span>Content<br></span>
            <textarea name="content" rows="10" cols="50"><?php echo $content; ?></textarea>
        </div>
        <div>
            <span>Tags<br></span>
            <input value="<?php echo $tagString ?>" type="text" name="tags">
        </div>
        <div>
            <span>Link<br></span>
            <input value="<?php echo $link ?>" type="text" name="link">
        </div>
        <input type="submit" value="Submit">
    </form>
    
    <?php } else { ?>
    <h2>Please come back as a member!</h2>
    <a href="<?php echo URL_WITH_INDEX_FILE; ?>">Newpost</a>
    <?php } ?>
</div>