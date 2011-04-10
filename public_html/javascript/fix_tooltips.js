/* Prevents the tooltips from disappearing outside the viewport */
$(document).ready(function() {
    var fix_tooltips = function() {
        // fix each tooltip
        $('.gl-tooltip').each(function() {
            // size of the viewport
            var $w = $(window);
            var viewport_height = parseInt($w.height());
            var viewport_width  = parseInt($w.width());
             // cache the tooltip element
            var $s = $(this).find('span');
            // estimate the bottom and right coordinates of the tooltip
            var tooltip_bottom  = parseInt($(this).offset().top + $s.outerHeight() - $w.scrollTop() + 30);
            var tooltip_right   = parseInt($(this).offset().left + $s.outerWidth() - $w.scrollLeft() + 30);
            // move the element around as necessary
            if (tooltip_bottom >= viewport_height) {
                var top = parseInt(($s.outerHeight() + 22) * -1) + 'px';
                $s.css('top', top);
            } else {
                $s.css('top', '2.2em');
            }
            if (tooltip_right >= viewport_width) {
                var left = parseInt($s.width() * -1) + 'px';
                $s.css('left', left);
            } else {
                $s.css('left', '2.2em');
            }
        });
    };
    // repeat all of the above every 200 mS
    setInterval(fix_tooltips, 200);
});
