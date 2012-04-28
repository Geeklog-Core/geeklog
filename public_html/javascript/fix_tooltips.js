/* Prevents the tooltips from disappearing outside the viewport */
var fix_tooltips = function() {
    var $w = $(window);
    // size of the viewport
    var viewport_height = parseInt($w.height());
    var viewport_width  = parseInt($w.width());
    // fix each tooltip
    $('a.gl-tooltip').each(function() {
        // cache the tooltip element
        var $s = $(this).find('span');
        // estimate the bottom and right coordinates of the tooltip
        var tooltip_bottom  = parseInt($(this).offset().top + $s.outerHeight() - $w.scrollTop() + 30);
        var tooltip_right   = parseInt($(this).offset().left + $s.outerWidth() - $w.scrollLeft() + 40);
        // move the element around as necessary
        if (tooltip_bottom >= viewport_height) {
            var top = parseInt(($s.outerHeight() + 10) * -1) + 'px';
            $s.css('top', top);
        } else {
            $s.css('top', '2.2em');
        }
        if (tooltip_right >= viewport_width) {
            var left = parseInt(viewport_width - tooltip_right + 30) + 'px';
            $s.css('left', left);
        } else {
            $s.css('left', '2.2em');
        }
    });
};
// Bind tooltip-fixing function to relevant events
$(document).ready(fix_tooltips);
$(window).resize(fix_tooltips);
$(window).scroll(fix_tooltips);
