$(function() {
    $('a[gl-help-popup]').each(function() {
        var $link = $(this);
        $link.one('click', function() {

            var $loading = $('<div style="margin: auto; padding-top: 90px; width: 32px; height: 32px">'
                + '<img src="' + geeklog.layout_url + '/images/loading.gif" alt="loading"' + geeklog.xhtml + '></div>');

            var $dialog = $('<div></div>')
                .append($loading.clone());

            var buttons_obj = new Object();
            buttons_obj[geeklog.lang.close] = function() {
                $dialog.dialog("close");
            };

            $dialog
                .load($link.attr('href')+ ' #content')
                .dialog({
                    title: $link.attr("title"),
                    width: 800,
                    height: 600,
                    responsive: true, // used by jquery-ui-dialogoptions and makes dialog responsive for small screens
                    buttons: buttons_obj,
                });

            $link.click(function() {
                $dialog.dialog("open");

                return false;
            });

            return false;
        });
    });
});
