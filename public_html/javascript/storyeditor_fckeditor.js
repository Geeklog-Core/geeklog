// +---------------------------------------------------------------------------+
// | Copyright (C) 2003,2004,2005,2006 by the following authors:               |
// | Version 1.1    Date: Jun 4, 2006                                          |
// | Authors:   Blaine Lang - blaine@portalparts.com                           |
// |                                                                           |
// | Javascript functions for FCKEditor Integration into Geeklog               |
// |                                                                           |
// +---------------------------------------------------------------------------+

    window.onload = function() {
        var oFCKeditor1 = new FCKeditor( 'introhtml' ) ;
        oFCKeditor1.BasePath = geeklogEditorBasePath;
        oFCKeditor1.Config['CustomConfigurationsPath'] = geeklogEditorBaseUrl + '/fckeditor/myconfig.js';
        oFCKeditor1.ToolbarSet = 'editor-toolbar2' ;
        oFCKeditor1.Height = 200 ;
        oFCKeditor1.ReplaceTextarea() ;

        var oFCKeditor2 = new FCKeditor( 'bodyhtml' ) ;
        oFCKeditor2.BasePath = geeklogEditorBasePath ;
        oFCKeditor2.Config['CustomConfigurationsPath'] = geeklogEditorBaseUrl + '/fckeditor/myconfig.js';
        oFCKeditor2.ToolbarSet = 'editor-toolbar2' ;
        oFCKeditor2.Height = 200 ;
        oFCKeditor2.ReplaceTextarea() ;
    }

    function change_editmode(obj) {
        showhideEditorDiv("editor",
                document.getElementById('navlist').childElementCount - 6);
        if (obj.value == 'html') {
            document.getElementById('html_editor').style.display='none';
            document.getElementById('text_editor').style.display='';
            swapEditorContent('html','introhtml');
            swapEditorContent('html','bodyhtml');
        } else if (obj.value == 'adveditor') {
            document.getElementById('text_editor').style.display='none';
            document.getElementById('html_editor').style.display='';
            swapEditorContent('adveditor','introhtml');
            swapEditorContent('adveditor','bodyhtml');
        } else {
            document.getElementById('html_editor').style.display='none';
            document.getElementById('text_editor').style.display='';
            swapEditorContent('text','introhtml');
            swapEditorContent('text','bodyhtml');
        }
    }

    function changeHTMLTextAreaSize(element, option) {
        var currentSize = parseInt(document.getElementById(element + '___Frame').style.height);
        if (option == 'larger') {
            var newsize = currentSize + 50;
        } else if (option == 'smaller') {
            var newsize = currentSize - 50;
        }
        document.getElementById(element + '___Frame').style.height = newsize + 'px';
    }

    function changeTextAreaSize(element, option) {
        var size = document.getElementById(element).rows;
        if (option == 'larger') {
            document.getElementById(element).rows = +(size) + 3;
        } else if (option == 'smaller') {
            document.getElementById(element).rows = +(size) - 3;
        }
    }


    function getEditorContent(instanceName) {
        // Get the editor instance that we want to interact with.
        var oEditor = FCKeditorAPI.GetInstance(instanceName) ;
        // return the editor contents in XHTML.
        var content = '';
        try {
            content = oEditor.GetXHTML( true );
        } catch (e) {}

        return content;
    }

    function swapEditorContent(curmode,instanceName) {
        var content = '';
        var oEditor = FCKeditorAPI.GetInstance(instanceName);
        if (curmode == 'adveditor') { // Switching from Text/HTML mode to AdvancedEditor Mode
            // Get the content from the textarea 'text' content and copy it to the editor
            if (instanceName == 'introhtml' )  {
                content = document.getElementById('introtext').value;
            } else {
                content = document.getElementById('bodytext').value;
            }
            try {
                oEditor.SetHTML(content);
                } catch (e) {}

        } else {
              content = getEditorContent(instanceName);
              if (content != '') {
                  if (instanceName == 'introhtml' )  {
                      document.getElementById('introtext').value = content;
                  } else {
                      document.getElementById('bodytext').value = content;
                  }
              }
          }
    }

    function set_postcontent() {
        if (document.getElementById('sel_editmode').value == 'adveditor') {
            document.getElementById('introtext').value = getEditorContent('introhtml');
            document.getElementById('bodytext').value = getEditorContent('bodyhtml');
        }
    }

   function changeToolbar(toolbar) {
        var oEditor1 = FCKeditorAPI.GetInstance('introhtml');
        oEditor1.ToolbarSet.Load( toolbar ) ;
        var oEditor2 = FCKeditorAPI.GetInstance('bodyhtml');
        oEditor2.ToolbarSet.Load( toolbar ) ;
   }
