<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container">
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
</div>
