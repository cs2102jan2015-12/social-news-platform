<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container">
    <h2>Registration complete, yay!</h2>
    <p>If your registration is successful, you should be able to see...</p>
    <p></p><?php echo var_dump($_SESSION); ?></p>
</div>
