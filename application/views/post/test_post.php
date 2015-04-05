<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap Core CSS -->
    <link href="//ironsummitmedia.github.io/startbootstrap-blog-post/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo URL; ?>public/css/style.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
    <!-- Page Content -->
    <div class="container">
        
        <div class="row">

            <!-- Blog Post -->
            <?php
            $pid = $this->pid;
            if (!empty($pid)):
                $post = $this->post->getPostInformation($pid);
                $tags = $this->post->getTagsOfPost($pid);
                
                if($post): ?>
                    
                    <div class = "vote-panel">
                            <a class="upvote <?php if ($this->vote->getVotesOfPostBy($pid, $_SESSION['user']['uid'])->value > 0) { echo 'active'; } ?>"
                            href="<?php echo URL_WITH_INDEX_FILE; ?>votes/post/<?php echo $pid ?>/upvote">&#x25B2;</a>
                    
                           <span class="count"><?php echo $this->vote->getVotesOfPost($pid)->votes; ?></span>
                        
                           <a class="downvote <?php if ($this->vote->getVotesOfPostBy($pid, $_SESSION['user']['uid'])->value < 0) { echo 'active'; } ?>"
                            href="<?php echo URL_WITH_INDEX_FILE; ?>votes/post/<?php echo $pid ?>/downvote">&#x25BC;</a>
                    </div>
                    <!-- Title -->
                    <h1><?php echo $post->title ?></h1>
                    
                    <!-- Author -->
                    <p class="lead">
                    by <?php echo $post->author; ?></a>
                    </p>
                       
                            
                    <hr>

                    <!-- Date/Time -->
                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post->submitted; ?></p>

                    <hr>

                    <!-- Post Content -->
                    
                    <p><?php echo $post->content ?></p>
                    
                    <!-- Post Tags -->
                    <?php
                    if ($tags): ?>
                        <p align = 'right'>
                        <?php foreach($tags as $tag) { ?>
                           <a href="<?php echo URL_WITH_INDEX_FILE; ?>feed/<?php echo $tag->tid; ?>">#<?php echo $tag->tagname; ?></a>&nbsp;
                        <?php  }  ?>
                        </p>
                    <?php endif; ?>
                    
                    <hr>
                    <!-- Blog Comments -->

                    <!-- Comments Form -->
                    <div class="well">
                        <?php if (array_key_exists('user', $_SESSION)): ?>
                        <h4>Post Comment:</h4>
                            <form role="form" action="" id="cmtform" method="POST">
                                <div class="form-group">
                                    <textarea class="form-control" rows="3" style=" width:100%; max-width: 100%; min-width: 100%" name="comment" form="cmtform" placeholder = "Write here..."></textarea>
                                </div>
                                <input type="submit" class="btn btn-primary" value= "Submit">
                            </form>
                        <?php else: ?>
                            <h4><a href="<?php echo URL_WITH_INDEX_FILE; ?>auth/login">Login</a> to comment!</h4>
                            
                        <?php endif; ?>
                    </div>

                    <hr>

                    <!-- Posted Comments -->

                    <!-- Comment -->
                    <?php $comment_list = $this->comment->getAllCommentsOfPost($pid);
                    
                    if ($comment_list): ?>
                        <?php foreach($comment_list as $comment) { ?>
                    
                            <div class="media">
                                <p class="pull-left">
                                    <div class = "vote-panel">
                                    <a class="upvote <?php if ($this->vote->getVotesOfCommentBy($comment->cid, $_SESSION['user']['uid'])->value > 0) { echo 'active'; } ?>"
                                    href="<?php echo URL_WITH_INDEX_FILE; ?>votes/post/<?php echo $comment->cid ?>/upvote">&#x25B2;</a>
                    
                                    <span class="count"><?php echo $this->vote->getVotesOfComment($comment->cid)->votes; ?></span>
                        
                                    <a class="downvote <?php if ($this->vote->getVotesOfCommentBy($comment->cid, $_SESSION['user']['uid'])->value < 0) { echo 'active'; } ?>"
                                    href="<?php echo URL_WITH_INDEX_FILE; ?>votes/post/<?php echo $comment->cid ?>/downvote">&#x25BC;</a>
                                    </div>
                                </p>
                                <div class="media-body">
                                    <h4 class="media-heading"><?php echo $comment->author;?>
                                        <small><?php echo $comment->submitted; ?></small>
                                    </h4>
                                    <?php echo $comment->content ?>
                                </div>
                            </div>
                        <?php } ?>
                    <?php else: ?>
                        <div class="media">
                            <div class="media-body">
                                <h4 class="media-heading"> No Comments
                                </h4>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    Post does not exist!
                <?php endif; ?>
            <?php else: ?>
                Error with post url
            <?php endif; ?>
        </div>
        <!-- /.row -->
        <hr>
        </div>
    
        <!-- /.container -->
        

</body>

</html>