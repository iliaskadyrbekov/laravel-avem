$(document).ready(function() {

    $(document).on('click', '.post__like-link', function(event){
        event.preventDefault();
        let id = +$(this).prop('id').match(/\d+/);
        let likeCountField = $(this).find('.post__like-text');
        let likeImage = $(this).find('.post__like-image'); // post__like-image--active
        //console.log('id', id);

        $.ajax({
            type: "POST",
            url: '/like',
            data: { blog_id: id }
        }).done(function (data) {
            if(data.like) {
                if(!likeImage.hasClass('post__like-image--active'))
                    likeImage.addClass('post__like-image--active');
                likeImage.prop('src', likeImage.prop('src').replace('icon-like-inactive', 'icon-like-active'));
            } else {
                if(likeImage.hasClass('post__like-image--active'))
                    likeImage.removeClass('post__like-image--active');
                likeImage.prop('src', likeImage.prop('src').replace('icon-like-active', 'icon-like-inactive'));
            }
            likeCountField.html(`${data.like_amount} avem(s)`);
        });
    });

    $(document).on('click', '.post__bookmark-link', function(event){
        event.preventDefault();
        let id = +$(this).prop('id').match(/\d+/);
        let bookmarkImage = $(this).find('.post__bookmark-image'); // post__bookmark-image--active
        console.log('id', id);

        $.ajax({
            type: "POST",
            url: '/bookmark',
            data: { blog_id: id }
        }).done(function (data) {
            if(data.bookmark) {
                if(!bookmarkImage.hasClass('post__bookmark-image--active'))
                    bookmarkImage.addClass('post__bookmark-image--active');
                bookmarkImage.prop('src', bookmarkImage.prop('src').replace('icon-bookmark-inactive', 'icon-bookmark-active'));
            } else {
                if(bookmarkImage.hasClass('post__bookmark-image--active'))
                    bookmarkImage.removeClass('post__bookmark-image--active');
                bookmarkImage.prop('src', bookmarkImage.prop('src').replace('icon-bookmark-active', 'icon-bookmark-inactive'));
            }
        });
    });

});
