/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2003-2009 by the following authors:                         |
// | Version 1.1    Date: Jun 4, 2006                                          |
// | Authors:   Blaine Lang - blaine@portalparts.com                           |
// |                                                                           |
// | Javascript functions for Geeklog Story Editor                             |
// |                                                                           |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+


    function enablearchive(obj) {
        var f = obj.form;               // all elements have their parent form in "form"
        var disable = obj.checked;      // Disable when checked
        if (f.elements["archiveflag"].checked==true && f.elements["storycode11"].checked==false) {
            f.elements["storycode10"].checked=true;
        }
        f.elements["storycode10"].disabled=!disable;
        f.elements["storycode11"].disabled=!disable;
        f.elements["expire_month"].disabled=!disable;
        f.elements["expire_day"].disabled=!disable;
        f.elements["expire_year"].disabled=!disable;
        f.elements["expire_hour"].disabled=!disable;
        f.elements["expire_minute"].disabled=!disable;
        f.elements["expire_ampm"].disabled=!disable;
    }

    function enablecmtclose(obj) {
        var f = obj.form;               // all elements have their parent form in "form"
        var disable = obj.checked;      // Disable when checked
        f.elements["cmt_close_month"].disabled=!disable;
        f.elements["cmt_close_day"].disabled=!disable;
        f.elements["cmt_close_year"].disabled=!disable;
        f.elements["cmt_close_hour"].disabled=!disable;
        f.elements["cmt_close_minute"].disabled=!disable;
        f.elements["cmt_close_ampm"].disabled=!disable;
    }

    $(function() {
        var cmt_close_flag = $("input[name='cmt_close_flag']").attr("checked");
        var s = $("select");
        if (cmt_close_flag !== "checked") {
            s.filter("[name='cmt_close_month']").attr("disabled","disabled");
            s.filter("[name='cmt_close_day']").attr("disabled","disabled");
            s.filter("[name='cmt_close_year']").attr("disabled","disabled");
            s.filter("[name='cmt_close_hour']").attr("disabled","disabled");
            s.filter("[name='cmt_close_minute']").attr("disabled","disabled");
            s.filter("[name='cmt_close_ampm']").attr("disabled","disabled");
        }

        var archiveflag = $("input[name='archiveflag']").attr("checked");
        if (archiveflag !== "checked") {
            s.filter("[name='expire_month']").attr("disabled","disabled");
            s.filter("[name='expire_day']").attr("disabled","disabled");
            s.filter("[name='expire_year']").attr("disabled","disabled");
            s.filter("[name='expire_hour']").attr("disabled","disabled");
            s.filter("[name='expire_minute']").attr("disabled","disabled");
            s.filter("[name='expire_ampm']").attr("disabled","disabled");
            s.filter("[name='storycode10']").attr("disabled","disabled");
            s.filter("[name='storycode11']").attr("disabled","disabled");
        }
    });

    function showhideEditorDiv(option,selindex) {
        var obj = document.getElementById('adveditor');
        var divarray = new Array('publish','images','archive','perms','options','bottom');

        // Reset the current selected navbar tab
        var navbar = document.getElementById('current');
        if (navbar) navbar.id = '';
        // Cycle thru the navlist child elements - building an array of just the link items
        var navbar = document.getElementById('navlist');
        var menuitems = new Array(8);
        var item = 0;
        for (var i=0 ;i < navbar.childNodes.length ; i++ ) {
            if (navbar.childNodes[i].nodeName.toLowerCase() == 'li') {
                menuitems[item] = navbar.childNodes[i];
                item++;
            }
        }
        // Now that I have just the link items I can set the selected tab using the passed selected Item number
        // Set the <a> tag to have an id called 'current'
        var menuitem = menuitems[selindex];
        for (var j=0 ;j < menuitem.childNodes.length ; j++ ) {
            if (menuitem.childNodes[j].nodeName.toLowerCase() == 'a')  menuitem.childNodes[j].id = 'current';
        }

        // Reset or show all the main divs - editor tab sections
        for (i=0; i < divarray.length; i++) {
            div = 'se_' + divarray[i];
            if (option != 'all' && option != divarray[i]) {
                document.getElementById(div).style.display = 'none';
            } else {
                document.getElementById(div).style.display = '';
            }
        }
        document.getElementById('text_editor').style.display = 'none';
        document.getElementById('html_editor').style.display = 'none';
        document.getElementById('preview').style.display = 'none';

        if (option == 'editor' || option == 'all') {
            document.getElementById('editor_mode').style.display = '';
            document.getElementById('se_bottom').style.display = '';
            if (document.getElementById('sel_editmode').value == 'adveditor') {
                document.getElementById('text_editor').style.display = 'none';
                document.getElementById('html_editor').style.display = '';
            } else {
                document.getElementById('text_editor').style.display = '';
                document.getElementById('html_editor').style.display = 'none';
            }
            if (option == 'all') {
                document.getElementById('se_options').style.display = '';
                document.getElementById('preview').style.display = '';
            }

        } else if (option == 'preview') {
            document.getElementById('preview').style.display = '';
            document.getElementById('editor_mode').style.display = 'none';
        } else {
            document.getElementById('se_options').style.display = '';
            document.getElementById('se_bottom').style.display = '';
            document.getElementById('text_editor').style.display = 'none';
            document.getElementById('html_editor').style.display = 'none';
            document.getElementById('editor_mode').style.display = 'none';
            document.getElementById('preview').style.display = 'none';
        }

    }

    /* Enable if you want to have toolbar only auto-collapse when not editing in field */
    /*
    function FCKeditor_OnComplete( editorInstance )  {
        editorInstance.Events.AttachEvent( 'OnBlur'    , FCKeditor_OnBlur ) ;
        editorInstance.Events.AttachEvent( 'OnFocus', FCKeditor_OnFocus ) ;
    }

    function FCKeditor_OnBlur( editorInstance ) {
        editorInstance.ToolbarSet.Collapse() ;
    }

    function FCKeditor_OnFocus( editorInstance ) {
        editorInstance.ToolbarSet.Expand() ;
    }
    */

// Adds jQuery UI datepicker to year/month/day selectors
jQuery(function () {
    var $ = jQuery,
        names = ['publish', 'expire', 'cmt_close'],
        name,
        imgUrl = geeklog.siteUrl + '/images/calendar.png',
        title = geeklog.lang.calendar,
        langCode = geeklog.lang.code,
        i, len, inputName, timeStamp;
    
    var getTimeStampFromSelectors = function (name) {
        var y = $("select[name='" + name + "_year']").val(),
            m = '0' + $("select[name='" + name + "_month']").val(),
            d = $("select[name='" + name + "_day']").val();
        
        m = m.substr(m.length - 2, 2);
        
        return y + '-' + m + '-' + d;
    };
    
    // Converts ISO-639-1 code to that used in jQuery UI datepicker
    switch (geeklog.lang.code) {
        case 'en':
            geeklog.lang.code = 'en-GB';
            break;
        
        case 'fr-ca':
            geeklog.lang.code = 'fr';
            break;
        
        case 'nb':
            geeklog.lang.code = 'no';
            break;
        
        case 'pt-br':
            geeklog.lang.code = 'pt-BR';
            break;
        
        case 'zh-cn':
            geeklog.lang.code = 'zh-CN';
            break;
        
        case 'zh':
            geeklog.lang.code = 'zh-TW';
            break;
    }
    
    // Set default options for datepickers
    $.datepicker.setDefaults({
        autoSize: true,
        buttonImage: imgUrl,
        buttonImageOnly: true,
        buttonText: title,
        dateFormat: 'yy-mm-dd',
        showOn: 'button'
    });
    
    for (i = 0, len = names.length; i < len; i++) {
        // Creates an invisible input field for a datepicker
        name = names[i];
        inputId = name + '_value_hidden';
        $("select[name='" + name + "_month']")
            .before('<span>&nbsp;</span><input type="text" id="' + inputId + '" style="display: none;" value="' + getTimeStampFromSelectors(name) + '" />&nbsp;');
        
        // Attaches a datepicker to the input field
        $('#' + inputId).datepicker();
        
        // Sets default locale
        $.datepicker.setDefaults($.datepicker.regional[geeklog.lang.code]);
        
        // Resets date format
        $.datepicker.setDefaults({
            dateFormat: 'yy-mm-dd'
        });
        
        // When a date is selected, then it is reflected back to selectors
        $('#' + inputId).change(function () {
            var inputId = $(this).attr('id');
            var name = inputId.substr(0, inputId.indexOf('_value_hidden'));
            var d = $(this).val();
            
            $("select[name='" + name + "_month']").val(parseInt(d.substr(5, 2), 10));
            $("select[name='" + name + "_year']").val(parseInt(d.substr(0, 4)), 10);
            $("select[name='" + name + "_day']").val(d.substr(8, 2));
        });
        
        // When month, day or year selectors are changed, then their values are
        // reflected back to the input field
        $("select[name^='" + name + "_']").change(function () {
            var selectorName = $(this).attr('name'),
                inputId, d;
            
            selectorName = selectorName.substr(0, selectorName.lastIndexOf('_'));
            inputId = selectorName + '_value_hidden';
            d = getTimeStampFromSelectors(selectorName);
            $('#' + inputId).val(d);
            $('#' + inputId).datepicker('setDate', d);
        });
    }
});
