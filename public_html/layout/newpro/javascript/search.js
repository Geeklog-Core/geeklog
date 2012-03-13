// Changes the background image of the search box on hover
$('#searchform > div').hover(function() {
    $(this).css('background-position', '0 -30px');
}, function () {
    $(this).css('background-position', '0 0');
});

// Toggles the text in the search box when it's selected
$('#searchform input[name=query]').focusin(function() {
    if ($(this).val() === this.defaultValue) {
        $(this).val('');
    }
});
$('#searchform input[name=query]').focusout(function() {
    if ($(this).val() === '') {
        $(this).val(this.defaultValue);
    }
});
