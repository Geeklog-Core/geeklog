// jQuery handles adding what is selected/unselected in tid[] and adds it selected to (or deletes from) inherit_tid[] as well as default_tid (not selected)
// This only happens if these 2 select boxes are visible

// On all radio selected, clear selection of tids
$('#topic_option_all').change( function () {
    // Clear all selections
    $('select#tid option').attr('selected', false);
});
// On homeonly radio option selected, clear selection of tids
$('#topic_option_homeonly').change( function () {
    // Clear all selections
    $('select#tid option').attr('selected', false);
});
// On radio option changed, change topic control display
$('input[name="topic_option"]').change( function () {
    changeTopicControlDisplay();
});

$('#tid').change( function () {

    if($('#panel_radio_options').is(':visible')) {
        // On selecting a tid make sure selecttopics radio option is selected
        $('#topic_option_selectedtopics').click();
    }

    changeTopicControlDisplay();

    // *********************************************
    // Inherited tids Multi-Selection Box
    // Get all selected tids and the not selected inherited
    var options_inherited = $('select#tid option:selected').sort().clone();
    var options_inherited_not_selected = $('select#inherit_tid option:not(:selected)').sort().clone();

    // Cleanup tids and trim spaces and select everything
    $(options_inherited).each(function(){
        $(this).text($.trim($(this).text()));
        $(this).attr('selected', true);
    });

    // Now add in inherited
    $('select#inherit_tid')
        .empty()
        .append(options_inherited)
        .sortSelect();

    // Now deselect anything that has been before
    $(options_inherited_not_selected).each(function(){
        $("#inherit_tid option[value='" + $(this).val() + "']").attr('selected', false);
    });

    // *********************************************
    // Default tid Selection Box
    // Figure out Default tid. Grab all selected tids
    var options_default = $('select#tid option:selected').sort().clone();

    // Trim spaces and find which one was selected before if it still exists and select it again
    $(options_default).each(function(){
        $(this).text($.trim($(this).text()));
    });

    var select_default_tid = $('select#default_tid');

    // Grab previous selection
    var prev_default_tid = select_default_tid.val();

    select_default_tid
        .empty()
        .append(options_default)
        .sortSelect();

    // Initialize Selection Box
    options_default = select_default_tid.children();
    options_default.attr('selected', false);
    select_default_tid.val('');

    // If the option is only one, set to that value
    if (options_default.size() == 1) {
        options_default.eq(0).attr('selected', true);
        select_default_tid.val(options_default.eq(0).val());
    } else {
        // Set Selection as before if still exist
        var last_option = options_default.filter('[value="' + prev_default_tid + '"]');
        if (last_option.size() == 1) {
            last_option.attr('selected', true);
            select_default_tid.val(prev_default_tid);
        }
    }
});

// Sorting function for Select
$.fn.sortSelect = function() {
    var op = this.children("option");
    op.sort(function(a, b) {
        return a.text.toLowerCase() > b.text.toLowerCase() ? 1 : -1;
    })
    return this.empty().append(op);
}

// Change topic control display
function changeTopicControlDisplay() {
    var $display = '';

    if ($('#panel_radio_options').is(':visible')) {
        $display = ($('#topic_option_selectedtopics').is(':checked'))
                 ? 'inline-block' : 'none';
        $('#panel_topic_options').css('display', $display);
    }

    $display = ($('#tid option:selected').size() == 0)
             ? 'none' : 'inline-block';
    if ($('#panel_radio_options').is(':visible') &&
        !$('#topic_option_selectedtopics').is(':checked')) {
        $display = 'none';
    }
    var $inherit = 'none';
    if ($('input[name="topic_inherit_hide"]').val() == 0) {
        $inherit = $display;
    }
    var $defalut = 'none';
    if ($('input[name="topic_default_hide"]').val() == 0) {
        $defalut = $display;
    }
    $('#panel_inherit_options').css('display', $inherit);
    $('#panel_default_options').css('display', $defalut);
}
