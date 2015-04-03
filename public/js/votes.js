(function() {
    'use strict';
    
    function sendPostRequest(event) {
        event.preventDefault();
        var self = this;
        $.post($(this).attr('href'), function(data) {
            /* data = {
             *  votes: int,
             *  action: string [upvote|downvote|unvote]
             * }
             */
            data = JSON.parse(data);
            
            // Update arrow highlight.
            $(self).siblings().addBack().removeClass('active');
            if (data.action === 'upvote') {
                $(self).addClass('active');
            } else if (data.action === 'downvote') {
                $(self).addClass('active');
            }
            
            // Update text display.
            $(self).siblings('.count').text(data.votes);
        });
    }
    
    // .upvote and .downvote should be siblings with a .count.
    $('.upvote').click(sendPostRequest);
    $('.downvote').click(sendPostRequest);
    
})();