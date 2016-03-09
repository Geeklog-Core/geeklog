
function FixHTML(leftblocksID, centerblocksID, rightblocksID) {
    var ua = navigator.userAgent.toLowerCase();
    var is_old_ie = (ua.indexOf("msie") != -1) && (ua.indexOf("msie 8") == -1) &&
                    (ua.indexOf("msie 9") == -1) && (ua.indexOf("msie 10") == -1) &&
                    (ua.indexOf("opera") == -1);
    // Set class attribute name
    // 'class'     for Gecko, Opera, Safari, IE9 and other
    // 'className' for IE8, IE7, IE6
    var classattr = is_old_ie ? 'className' : 'class';

    if (document.body.getAttribute(classattr) != 'js_off') return;

    var leftblocks   = document.getElementById(leftblocksID);
    var centerblocks = document.getElementById(centerblocksID);
    var rightblocks  = document.getElementById(rightblocksID);

    // Check HTML id attribute
    var classValue = 'left-center-right';
    if (leftblocks  && centerblocks && !rightblocks) classValue = 'left-center';
    if (!leftblocks && centerblocks && rightblocks ) classValue = 'center-right';
    if (!leftblocks && centerblocks && !rightblocks) classValue = 'center';

    // Set body class attribute by HTML structure
    document.body.setAttribute(classattr, classValue);
}


function delconfirm() {
    return confirm("Delete this?");
}

function postconfirm() {
    return confirm("Send this?");
}

$(function() {
    var istouch = ('ontouchstart' in window);
    var istablet = false;

    if (istouch) {
        var ua = navigator.userAgent;
        istablet = (ua.indexOf('Android') > 0 && ua.indexOf('Mobile') == -1) ||
                   (ua.indexOf('iPad') > 0) || (ua.indexOf('SC-01C') > 0);

        if (!istablet) {
            var obj = $('.block-title');

            obj.addClass("show");
            $(".block-left-content").css("display", "none");
            $(".block-right-content").css("display", "none");
            $(".block-list-content").css("display", "none");
            $(document).on('touchstart', '.block-title', function () {
                this.touched = true;
            });
            $(document).on('touchmove', '.block-title', function () {
                this.touchmoved = true;
            });
            $(document).on('touchend', '.block-title', function () {
                if (this.touched && !this.touchmoved) {
                    $(this).next().toggle();
                    $(this).toggleClass("show");
                    $(this).toggleClass("hide");
                }

                this.touched = false;
                this.touchmoved = false;
            });
        }
    }

    $('form').addClass('uk-form');

    if (geeklog.theme_options.header_search == 0) {
        $('#header-search').remove();
    }

    if (geeklog.theme_options.block_left_search == 0) {
        $('#block-left-search').remove();
    }

    if (geeklog.theme_options.welcome_msg == 0) {
        $('.welcome_msg').remove();
    }

    if (geeklog.theme_options.topic_image == 0) {
        $('.story_image').remove();
    }

    if (geeklog.theme_options.trademark_msg == 0) {
        $('#trademark').remove();
    }

    if (geeklog.theme_options.execution_time == 0) {
        $('#execution_textandtime').remove();
    }

    if (geeklog.theme_options.pagenavi_string == 0) {
        $('.uk-icon-angle-double-left').parent().empty().append('<i class="uk-icon-angle-double-left"></i>');
        $('.uk-icon-angle-left').parent().empty().append('<i class="uk-icon-angle-left"></i>');
        $('.uk-icon-angle-right').parent().empty().append('<i class="uk-icon-angle-right"></i>');
        $('.uk-icon-angle-double-right').parent().empty().append('<i class="uk-icon-angle-double-right"></i>');
    }

    if (!istouch || istablet) {
        $('.table-wrapper').attr('class', 'table-wrapper-fit');
    } else {
        if (geeklog.theme_options.table_overflow == 0) {
            $('.table-wrapper').attr('class', 'table-wrapper-visible');
        }
    }
});
