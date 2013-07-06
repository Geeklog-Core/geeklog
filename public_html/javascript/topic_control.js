// jQuery handles adding what is selected/unselected in tid[] and adds it selected to (or deletes from) inherit_tid[] as well as default_tid (not selected)
// This only happens if these 2 select boxes are visible

// On all radio selected, clear selection of tids
$('#topic_option_all').change( function () {
    // Clear all selections
    $('select#tid option').attr('selected',false);
});
// On homeonly radio option selected, clear selection of tids
$('#topic_option_homeonly').change( function () {
    // Clear all selections
    $('select#tid option').attr('selected',false);
});
        

$('#tid').change( function () {
    
    if($("#panel_radio_options").is(':visible')) {
        // On selecting a tid make sure selecttopics radio option is selected
        $('#topic_option_selectedtopics').attr('checked',true);
        $('#topic_option_all').attr('checked',false);
        $('#topic_option_homeonly').attr('checked',false);        
    } else {
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
        $('select#inherit_tid').empty();
        $('select#inherit_tid').append(options_inherited);
        $('select#inherit_tid').sortSelect();
        
        // Now deselect anything that has been before
        $(options_inherited_not_selected).each(function(){
                $("#inherit_tid option[value='"+$(this).val()+"']").attr("selected",false);
        });    
    
    
        // *********************************************
        // Default tid Selection Box
        // Figure out Default tid. Grab all selected tids
        var options_default = $('select#tid option:selected').sort().clone();
        // Grab previous selection
        var option_default_tid = $('select#default_tid option:selected').sort().clone();
        
        // Trim spaces and find which one was selected before if it still exists and select it again
        $(options_default).each(function(){
            $(this).text($.trim($(this).text()));
        });    
        
        $('select#default_tid').empty();
        $('select#default_tid').append(options_default);
         $('select#default_tid').sortSelect();
        
        // Clear all selections
        $('select#default_tid option').attr('selected',false);
        // Set Selection as before if still exist
        $('#default_tid').val($(option_default_tid).val());
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
