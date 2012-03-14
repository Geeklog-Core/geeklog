$(document).ready(function() {
    // Show the openid button for JS-enabled browsers
    $('form.third-party-login div').show();
    $('form.third-party-login img').click(function() {
        // Ensure that clicking on an icon will trigger the login action
        $(this).prev().click();
    });
    $('form.third-party-login').submit(function(e) {
        if ($(this).find('noscript').length) { // OpenId form submitted
            e.preventDefault();
            // Add a textbox for the identity provider url
            // and change the text in the submit button
            $(this)
            .unbind('submit')
            .find('> div')
            .prepend(
                $('<input/>', {'type':'text','name':'identity_url','value':'http://'})
            );
        }
    });
});
