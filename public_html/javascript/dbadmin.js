/**
* Geeklog Database Administration Ajax Driver
*
* @author Mark R. Evans <mark AT glfusion DOT org>
*
*/

var geeklog_dbadminInterface = (function() {

    // public methods/properties
    var pub = {};

    // private vars
    var items = null,
    item =  null,
    url =  null,
    done =  1,
    count = 0,
    $msg = null;

    /**
    * initialize everything
    */
    pub.init = function() {
        // $msg is the status message area
        $msg = $('#batchinterface_msg');

        // if $msg does not exist, return.
        if ( ! $msg) {
            return;
        }

        // init interface events
        $('#dbconvertbutton').click(pub.update);
    };

    var process = function() {
        if (item) {

            var dataS = {
                "mode" : mode,
                "table" : item,
                "engine" : engine,
            };

            data = $.param(dataS);

            // ajax call to process item
            $.ajax({
                type: "POST",
                dataType: "json",
                url: url,
                data: data,
                timeout:60000
            }).done(function(data) {
                var result = $.parseJSON(data["json"]);
                if ( result.errorCode != 0 ) {
                    console.log("DBadmin: The table conversion did not complete");
                }
                message('<p style="padding-left:20px;">' + lang_converting + ' ' + done + '/' + count + ' - '+ item + '</p>');
                var percent = Math.round(( done / count ) * 100);
                $('#progress-bar').css('width', percent + "%");
                $('#progress-bar').html(percent + "%");
                item = items.shift();
                done++;
            }).fail(function(jqXHR, textStatus ) {
                if (textStatus === 'timeout') {
                     console.log("DBadmin: Error converting table " + item);
                     alert("Error: Timeout converting table " + item);
                     window.location.href = "database.php";
                }
            }).always(function( xhr, status ) {
                var wait = 250;
                window.setTimeout(process, wait);
            });

        } else {
            finished();
        }
    };

    var finished = function() {
        // we're done
        $('#progress-bar').css('width', "100%");
        $('#progress-bar').html("100%");
        throbber_off();
        message(lang_success);
        window.setTimeout(function() {
            // ajax call to process item
            $.ajax({
                type: "POST",
                dataType: "json",
                url: url,
                data: {"mode" : mode + "complete", "engine" : engine},
            }).done(function(data) {
                $('#dbconvertbutton').prop("disabled",false);
                $("#dbconvertbutton").html(lang_convert);
                UIkit.modal.confirm_mod(lang_success, function(){
                    $(location).attr('href', 'database.php');
                }, {labels:{'Ok': lang_ok}});
            });
        }, 3000);
    };


    /**
    * Gives textual feedback
    * updates the ID defined in the $msg variable
    */
    var message = function(text) {
        if (text.charAt(0) !== '<') {
            text = '<p style="padding-left:20px;">' + text + '</p>'
        }
        $msg.html(text);
    };

    // update process
    pub.update = function() {
        done = 1;
        url = $( '#dbcvtform' ).attr( 'action' );

        $("#dbadmin_batchprocesor").show();
        $('#dbconvertbutton').prop("disabled",true);
        $("#dbconvertbutton").html(lang_converting);

        throbber_on();

        $.ajax({
            type: "POST",
            dataType: "json",
            url: url,
            data: {"mode" : "dblist", "engine" : engine },
            timeout: 30000,
        }).done(function(data) {
            var result = $.parseJSON(data["json"]);
            items = result.tablelist;
            count = items.length;
            item = items.shift();
            message(lang_converting);
            window.setTimeout(process,1000);
        });
        return false; // prevent from firing
    };

    /**
    * add a throbber image
    */
    var throbber_on = function() {
        $msg.addClass('tm-updating');
    };

    /**
    * Stop the throbber
    */
    var throbber_off = function() {
        $msg.removeClass('tm-updating');
    };

    // return only public methods/properties
    return pub;
})();

(function(UI) {
    UI.modal.confirm_mod = function(content, onconfirm) {

        var options = arguments.length > 1 && arguments[arguments.length-1] ? arguments[arguments.length-1] : {};

        onconfirm = UI.$.isFunction(onconfirm) ? onconfirm : function(){};
        options   = UI.$.extend(true, {bgclose:false, keyboard:false, modal:false, labels:UI.modal.labels}, UI.$.isFunction(options) ? {}:options);

        var modal = UI.modal.dialog(([
            '<div class="uk-margin uk-modal-content">'+String(content)+'</div>',
            '<div class="uk-modal-footer uk-text-right"><button class="uk-button uk-button-primary">'+options.labels.Ok+'</button></div>'
        ]).join(""), options);

        modal.element.find('button:first').on("click", function(){
            onconfirm();
            modal.hide();
        });

        modal.on('show.uk.modal', function(){
            setTimeout(function(){
                modal.element.find('button:first').focus();
            }, 50);
        });

        return modal.show();
    };
})(UIkit);

$(function() {
    geeklog_dbadminInterface.init();
});