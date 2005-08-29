// +---------------------------------------------------------------------------+
// | Copyright (C) 2003,2004,2005 by the following authors:                    |
// | Version 1.0    Date: Jun 4, 2005                                          |
// | Authors:   Blaine Lang - blaine@portalparts.com                           |
// |                                                                           |
// | Javascript functions for Geeklog Advanced Editor                          |
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

    function showhideEditorDiv(option) {
        var obj = document.getElementById('adveditor');
        var divarray1 = new Array('text_editor','html_editor');
        var divarray = new Array('publish','images','archive','perms');

        if (option != 'preview') {
            for (i=0; i < divarray.length; i++) {
                div = 'se_' + divarray[i];
                if (option != 'all' && option != divarray[i]) {
                    document.getElementById(div).style.display = 'none';
                } else {
                    document.getElementById(div).style.display = '';
                }
            }
        }

        if (option == 'editor' || option == 'all') {
            document.getElementById('editor_mode').style.display = '';
            if (document.getElementById('sel_editmode').value == 'html') {
                document.getElementById('text_editor').style.display = 'none';
                document.getElementById('html_editor').style.display = '';
            } else {
                document.getElementById('text_editor').style.display = '';
                document.getElementById('html_editor').style.display = 'none';
            }
            if (option == 'all') {
                document.getElementById('se_options').style.display = '';
            } else {
                document.getElementById('se_options').style.display = 'none';
            }

        } else if (option == 'preview') {
            if (document.getElementById('preview').style.display == 'none') {
                document.getElementById('preview').style.display = '';
            } else {
                document.getElementById('preview').style.display = 'none';
            }

        } else {
            document.getElementById('se_options').style.display = '';
            document.getElementById('text_editor').style.display = 'none';
            document.getElementById('html_editor').style.display = 'none';
            document.getElementById('editor_mode').style.display = 'none';
        }
        document.getElementById('navcontainer').scrollIntoView(true);

    }
 