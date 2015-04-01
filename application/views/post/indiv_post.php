<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container">

   <?php
   
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
        $pid = $this->pid;
        if (!empty($pid)) {
            echo "Post ID is " . $pid;
        
            $post = $this->post->getPost($pid);
                
            if ($post) {
                
                echo "<table style='border: solid 1px black;'>";
                echo "<tr><th>pid</th><th>title</th><th>content</th><th>submitted</th><th>hidden</th><th>author</th></tr>";

                foreach(new TableRows(new RecursiveArrayIterator($post)) as $k=>$v) {
                    echo $v;
                }
            } else {
                echo "<h2>Post does not exist! </h2>";
            }
            
            echo "</table>";
            
            if ($post) {
                echo $post->title;
            }
        } else {
            echo "<h2> Empty post number. </h2>";
        }
        
    ?>
    
</div>
<div class="container">

   <?php
        $pid = $this->pid;
        if (!empty($pid)) {
            $postID = $pid;
        
            $comment = $this->comment->getAllCommentsOfPost($postID);
                
            if ($comment) {
                
                echo "<table style='border: solid 1px black;'>";
                echo "<tr><th>cid</th><th>content</th><th>submitted</th><th>hidden</th><th>author</th><th>parent</th></tr>";

                foreach(new TableRows(new RecursiveArrayIterator($comment)) as $k=>$v) {
                    echo $v;
                }
            } else {
                echo "<h2>Comment does not exist! </h2>";
            }
            
            echo "</table>";
        } else {
            echo "<h2> Empty Post number. </h2>";
        }
        
    ?>
    
</div>
