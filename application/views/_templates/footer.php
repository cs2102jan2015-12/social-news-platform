<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>
    </div> <!-- From <div class="container"> -->
    
    <!-- jQuery, loaded in the recommended protocol-less way -->
    <!-- more http://www.paulirish.com/2010/the-protocol-relative-url/ -->
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

    <!-- define the project's URL (to make AJAX calls possible, even when using this in sub-folders etc) -->
    <script>
        var url = "<?php echo URL_WITH_INDEX_FILE; ?>";
    </script>

    <!-- our JavaScript -->
    <!--<script src="<?php echo URL; ?>public/js/application.js"></script>-->
    <script src="<?php echo URL; ?>public/js/votes.js"></script>
</body>
</html>
