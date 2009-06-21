// +---------------------------------------------------------------------------+
// | Copyright (C) 2003,2004 by the following authors:                         |
// | Version 1.0    Date: Jun 4, 2005                                          |
// | Authors:   Blaine Lang - blaine@portalparts.com                           |
// |                                                                           |
// | Javascript functions for FCKEditor Integration into Geeklog                |
// |                                                                           |
// +---------------------------------------------------------------------------+


    window.onload = function() {
        var oFCKeditor1 = new FCKeditor( 'introhtml' ) ;
        oFCKeditor1.BasePath = geeklogEditorBasePath;
        oFCKeditor1.Config['CustomConfigurationsPath'] = geeklogEditorBaseUrl + '/fckeditor/myconfig.js';
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

    function getEditorContent() {
        // Get the editor instance that we want to interact with.
        var oEditor = FCKeditorAPI.GetInstance('introhtml') ;
        // return the editor contents in XHTML.
        return oEditor.GetXHTML( true );
    }

    function swapEditorContent(curmode) {
        var content = '';
        var oEditor = FCKeditorAPI.GetInstance('introhtml') ;
        if (curmode == 'html') { // Switching from Text to HTML mode
            // Get the content from the textarea 'text' content and copy it to the editor
            content = document.getElementById('introtext').value;
            oEditor.SetHTML(content);
        } else {
              content = getEditorContent();
              document.getElementById('introtext').value = content;
          }
    }

    function set_postcontent() {
        if (document.getElementById('sel_editmode').value == 'html') {
            document.getElementById('introtext').value = getEditorContent();
        }
    }
