<?php if(isset($message)) { ?>
    <div class="message">
        <?php
            echo "There was an error. ", $message;
        ?>
    </div>
<?php } ?>