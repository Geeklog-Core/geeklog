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
        startrecord = 0,
        totalrows = 0,
        totalrowsprocessed = 0,
        dbFileName = null,
        periods = '',
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
        $('#dbbackupbutton').click(pub.update);
    };

    var process = function() {
        if (item) {

            if ( startrecord == 0 ) {
                periods = '';
            } else {
                periods = periods + '.';
            }

            var dataS = {
                "mode" : 'dbbackup_table',
                "table" : item,
                "backup_filename" : dbFileName,
                "start" : startrecord,
            };

            data = $.param(dataS);

            // ajax call to process item
            $.ajax({
                type: "POST",
                dataType: "json",
                url: url,
                data: data,
                timeout: 60000,
            }).done(function(data) {
                var result = $.parseJSON(data["json"]);
                var rowsthissession = result.processed;

                if ( result.errorCode == 3 ) {
                    alert("Database Backup Failed - unable to open backup file");
                    window.location.href = "database.php";
                }
                if ( result.errorCode == 2 ) {
                    console.log("DBadmin: Table backup incomplete - making another pass");
                    startrecord = result.startrecord;
                } else {
                    item = items.shift();
                    done++;
                    startrecord = 0;
                }
                totalrowsprocessed = totalrowsprocessed + rowsthissession;

                message('<p style="padding-left:20px;">' + lang_backingup + ' ' + done + '/' + count + ' - '+ item + periods + '</p>');

                var percent = Math.round(( done / count ) * 100);
                $('#progress-bar').css('width', percent + "%");
                $('#progress-bar').html(percent + "%");

                var wait = 250;
                window.setTimeout(process, wait);

            }).fail(function(jqXHR, textStatus ) {
                if (textStatus === 'timeout') {
                     console.log("DBadmin: JavaScript timeout - error backing up table " + item);
                     alert("Error performing backup - timed out on table " + item);
                     window.location.href = "database.php";
                }
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
        startrecord = 0;
        totalrows = 0;
        totalrowsprocessed = 0;
        window.setTimeout(function() {
            // ajax call to process item
            $.ajax({
                type: "POST",
                dataType: "json",
                url: url,
                data: {"mode" : 'dbbackup_complete', "backup_filename" : dbFileName},
            }).done(function(data) {
                $("#dbbackupbutton").html(lang_backup);
                UIkit.modal.confirm_mod(lang_success, function(){
                    $(location).attr('href', 'database.php');
                }, {labels:{'Ok': lang_ok}});
            });
        }, 2000);
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
        url = $( '#dbbackupform' ).attr( 'action' );

        $("#dbadmin_batchprocesor").show();
        $('#dbbackupbutton').prop("disabled",true);
        $("#dbbackupbutton").html(lang_backingup);

        throbber_on();

        $.ajax({
            type: "POST",
            dataType: "json",
            url: url,
            data: { "mode" : "dbbackup_init" },
        }).done(function(data) {
            var result = $.parseJSON(data["json"]);
            items = result.tablelist;
            totalrows = result.totalrows;
            dbFileName = result.backup_filename;
            count = items.length;
            if ( result.errorCode != 0 ) {
                throbber_off();
                message('Error');
                $('#dbbackupbutton').prop("disabled",false);
                $("#dbbackupbutton").html(lang_backup);
                return alert(result.statusMessage);
            }
            item = items.shift();
            message(lang_backingup);
            window.setTimeout(process,1000);
        }).fail(function(jqXHR, textStatus ) {
             alert("Error initializing the database backup");
             window.location.href = "database.php";
        });
        return false;
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
