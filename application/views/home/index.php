<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <div class="jumbotron" align="center">
    <h1>Welcome to Not Reddit</h1>      
    <p>Not Reddit is not Reddit. Clearly. But it aims to be. At least enough for our assignment. </p>
    <a href="<?php echo URL_WITH_INDEX_FILE; ?>feed" class="btn btn-primary" role="button">Enter Cautiously</a>
  </div>   
</div>

</body>
</html>
