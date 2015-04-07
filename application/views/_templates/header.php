<?php

// This here blocks direct access to this file (so an attacker can't look into application/views/_templates/header.php).
// "$this" only exists if header.php is loaded from within the app, but not if THIS file here is called directly.
// If someone called header.php directly we completely stop everything via exit() and send a 403 server status code.
// Also make sure there are NO spaces etc. before "<!DOCTYPE" as this might break page rendering.
if (!$this) {
    exit(header('HTTP/1.0 403 Forbidden'));
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Not Reddit</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- JS -->
    <!-- please note: The JavaScript files are loaded in the footer to speed up page construction -->
    <!-- See more here: http://stackoverflow.com/q/2105327/1114320 -->

    <!-- CSS -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo URL; ?>public/css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
                </button>
                <a class="navbar-brand" href="<?php echo URL_WITH_INDEX_FILE; ?>">Not Reddit</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <?php if (isset($_SESSION['user'])) { ?>
                    <li>
                        <span class="navbar-text">Hello <?php echo $_SESSION['user']['username']; ?></span>
                    </li>
                    <li>
                        <a href="<?php echo URL_WITH_INDEX_FILE; ?>auth/logout">Logout</a>
                    </li>
                    <li>
                        <a href="<?php echo URL_WITH_INDEX_FILE; ?>feed">Feeds</a>
                    </li>
                    <li>
                        <a href="<?php echo URL_WITH_INDEX_FILE; ?>post/newpost">New Post</a>
                    </li>
                        <?php if ($_SESSION['user']['isAdmin']) { ?>
                    <li>
                        <a href="<?php echo URL_WITH_INDEX_FILE; ?>admin">Admin</a>
                    </li>
                        <?php } ?>
                    <?php } else { ?>
                    <li>
                        <a href="<?php echo URL_WITH_INDEX_FILE; ?>register">Register</a>
                    </li>
                    <li>
                        <a href="<?php echo URL_WITH_INDEX_FILE; ?>auth/login">Login</a>
                    </li>
                    <li>
                        <a href="<?php echo URL_WITH_INDEX_FILE; ?>feed">Feeds</a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
