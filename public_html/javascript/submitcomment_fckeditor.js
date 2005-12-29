// +---------------------------------------------------------------------------+
// | Copyright (C) 2003,2004 by the following authors:                         |
// | Version 1.0    Date: Jun 4, 2005                                          |
// | Authors:   Blaine Lang - blaine@portalparts.com                           |
// |                                                                           |
// | Javascript functions for FCKEditor Integration into Geeklog                |
// |                                                                           |
// +---------------------------------------------------------------------------+

    window.onload = function() {
        var oFCKeditor1 = new FCKeditor( 'comment_html' ) ;
        oFCKeditor1.BasePath = geeklogEditorBasePath;
        oFCKeditor1.ToolbarSet = 'editor-toolbar1' ;
        oFCKeditor1.Height = 200 ;
        oFCKeditor1.ReplaceTextarea() ;
    }

    function change_editmode(obj) {
        if (obj.value == 'html') {
            document.getElementById('text_editor').style.display='none';
            document.getElementById('html_editor').style.display='';
            swapEditorContent('html');
        } else {
            document.getElementById('text_editor').style.display='';
            document.getElementById('html_editor').style.display='none';
            swapEditorContent('text');
        }
    }


    function getEditorContent(instanceName) {
        editor_frame = document.getElementById(instanceName+'___Frame');
        editor_source = editor_frame.contentWindow.document.getElementById('eEditorArea');
        if (editor_source!=null) {
            return editor_source.contentWindow.document.body.innerHTML;
        } else {
            return '';
        }
    }

    function swapEditorContent(curmode) {
        var content = '';
        editor_frame = document.getElementById('comment___Frame');
        editor_source = editor_frame.contentWindow.document.getElementById('eEditorArea');

        if (curmode == 'html') {
            content = document.getElementById('comment_text').value;
            editor_source.contentWindow.document.body.innerHTML = content;
        } else {
            content = editor_source.contentWindow.document.body.innerHTML;
            document.getElementById('comment_text').value = content;
        }
    }

    function set_postcontent() {
        if (document.getElementById('sel_editmode').value == 'html') {
            document.getElementById('comment_text').value = getEditorContent('comment_html');
        }
    }
