
$(function(){
    $("input[ type=text ]").change(function() {
        $(window).on('beforeunload', function() {
            return 'Form is not completed. Are you leave?';
        });
    });
    $("input[ type=submit ]").click(function() {
        $(window).off('beforeunload');
    });
});
