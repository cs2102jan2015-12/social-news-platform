<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container">
    
    <?php if (array_key_exists('user', $_SESSION)) { ?>
    <h2>Create a new post</h2>
    
    <form action="newpost" method="POST">
        <div>
            <p>Title</p>
            <input value="<?php if(isset($message)) { echo $_POST['title'];} ?>" type="text" name="title">
        </div>
        <div>
            <p>Content</p>
            <textarea name="content" rows="10" cols="50"><?php if(isset($message)) { echo $_POST['content'];}?></textarea>
        </div>
        <div>
            <p>Tag</p>
            <input value="<?php if(isset($message)) { echo $_POST['tags'];} ?>" type="text" name="tags">
        </div>
        <div>
            <p>Link</p>
            <input value="<?php if(isset($message)) { echo $_POST['link'];} ?>" type="text" name="link">
        </div>
        <input type="submit" value="Submit">
    </form>
    
    <?php } else { ?>
    <h2>Please come back as a member!</h2>
    <a href="<?php echo URL_WITH_INDEX_FILE; ?>">Newpost</a>
    <?php } ?>
</div>