<div class = "container-editcomment">
    <h3>Edit Comment</h3>
        <form action="" id="cmtform" method="POST">
            <div>
                <textarea style=" width:100%; max-width: 100%; min-width: 100%" name="comment" form="cmtform"><?php echo $comment->content?></textarea>
            </div>
            <input type="submit" value="Send">
        </form>
</div>