<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container">

   <?php
        echo "Post ID is " . $_GET['pid'];
        
        echo "<table style='border: solid 1px black;'>";
        echo "<tr><th>pid</th><th>title</th><th>content</th><th>submitted</th><th>hidden</th><th>author</th></tr>";

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
        
        try {
            $post = $this->post->getPost($_GET['pid']);
         
            foreach(new TableRows(new RecursiveArrayIterator($post)) as $k=>$v) {
                echo $v;
            }
        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        echo "</table>";
        
    ?>
    
</div>
