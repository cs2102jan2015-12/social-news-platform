<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container">

   <?php
    
        if (!empty($_GET['pid'])) {
            echo "Post ID is " . $_GET['pid'];
        
            
            class TableRows extends RecursiveIteratorIterator {
                function __construct($it) {
                    parent::__construct($it, self::LEAVES_ONLY);
                }

                function current() {
                    return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
                }

                function beginChildren() {
                    echo "<tr>";
                }

                function endChildren() {
                    echo "</tr>" . "\n";
                }
            } 
        
           // try {
            $post = $this->post->getPost($_GET['pid']);
                
            if ($post) {
                
                echo "<table style='border: solid 1px black;'>";
                echo "<tr><th>pid</th><th>title</th><th>content</th><th>submitted</th><th>hidden</th><th>author</th></tr>";

                foreach(new TableRows(new RecursiveArrayIterator($post)) as $k=>$v) {
                    echo $v;
                }
            } else {
                echo "<h2>Post does not exist! </h2>";
            }
            //}
            //catch(PDOException $e) {
               // echo "<h2>Post does not exist! </h2>";
            //}
            
            echo "</table>";
        } else {
            echo "<h2> Empty post number. </h2>";
        }
        
    ?>
    
</div>
