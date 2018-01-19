
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

(function($) {
    $('form').addClass('uk-form');

    if (geeklog.theme_options.header_search == 0) {
        $('#header-search').remove();
    }

    var oheader = $('#header');
    if (geeklog.theme_options.header_brand_type == 1) {
        if (oheader.hasClass("brand-image")) {
            oheader.removeClass("brand-image").addClass("brand-text");
        }
    } else {
        if (oheader.hasClass("brand-text")) {
            oheader.removeClass("brand-text").addClass("brand-image");
        }
    }

    if (geeklog.theme_options.block_left_search == 0) {
        $('#block-left-search').remove();
    }

    if (geeklog.theme_options.welcome_msg == 0) {
        $('.welcome_msg').remove();
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

    var oc_mode;
    switch (geeklog.theme_options.off_canvas_mode) {
        case 1:
            oc_mode = 'slide';
            break;
        case 2:
            oc_mode = 'reveal';
            break;
        case 3:
            oc_mode = 'none';
            break;
        default:
            oc_mode = 'push';
            break;
    }
    $('#header-content > a.tm-toggle').attr('data-uk-offcanvas', "{mode:'" + oc_mode + "'}");

    var totop = $('#totop-scroller');
    $(window).scroll(function() {
        if ($(this).scrollTop() > 400) {
            totop.fadeIn();
        } else {
            totop.fadeOut();
        }
    });
})(jQuery);
