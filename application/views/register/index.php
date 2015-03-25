<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container">
    <?php if (!array_key_exists('user', $_SESSION)) { ?>
    <h2>Registration</h2>
    <form action="" method="POST">
        <div>
            <span>Username</span>
            <input type="text" name="username">
        </div>
        <div>
            <span>Password</span>
            <input type="password" name="password">
        </div>
        <input type="submit" value="Register">
    </form>
    <?php } else { ?>
    <h2>Already registered lah</h2>
    <?php } ?>
</div>
