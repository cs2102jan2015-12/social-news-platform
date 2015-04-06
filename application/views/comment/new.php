<div class = "container-newcomment">
    <?php if (array_key_exists('user', $_SESSION)): ?>
        <h3>Post Comment</h3>
            <form action="" id="cmtform" method="POST">
                <div>
                    <textarea style=" width:100%; max-width: 100%; min-width: 100%" name="comment" form="cmtform" placeholder = "Write here..."></textarea>
                </div>
                <input type="submit" value="Send">
            </form>
    
    <?php else: ?>
        <h3>Login to comment!</h3>
        <a href="<?php echo URL_WITH_INDEX_FILE; ?>auth/login">Login</a>
    <?php endif; ?>
</div>