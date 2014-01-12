$(function() {
    var postmode = $('[name="postmode"]');
    postmode.change(function () {
        $('.allowed_html_tags')
            .hide()
            .filter('.post_mode_' + postmode.val())
            .show();
    });
    postmode.change();
});
