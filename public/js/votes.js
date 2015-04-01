(function() {
    'use strict';
    
    function sendPostRequest(event) {
        event.preventDefault();
        $.post($(this).attr('href'), function(data) {
            /* data = {
             *  votes: int,
             *  action: string [upvote|downvote|unvote]
             * }
             */
            
            $(this).siblings().removeClass('active');
            if (data.action === 'upvote') {
                $(this).siblings('.upvote').addClass('active');
            } else if (data.action === 'downvote') {
                $(this).siblings('.downvote').addClass('active');
            }
            
            $(this).siblings('.count').text(data.votes);
        });
    }
    
    $('.upvote').click(sendPostRequest);
    $('.downvote').click(sendPostRequest);
    
})();