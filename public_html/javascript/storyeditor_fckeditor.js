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
        var size = 0;
        var size = document.getElementById(element + '___Frame').height;
        if (option == 'larger') {
            document.getElementById(element + '___Frame').height = +(size) + 50;

        } else if (option == 'smaller') {
            document.getElementById(element + '___Frame').height = +(size) - 50;
        }
    }

    function changeTextAreaSize(element, option) {
        var size = 0;
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
        return oEditor.GetXHTML( true );
    }

    function swapEditorContent(curmode,instanceName) {
        var content = '';
        var oEditor = FCKeditorAPI.GetInstance(instanceName) ;
        //alert(curmode + ':' + instanceName);
        if (curmode == 'adveditor') { // Switching from Text to HTML mode
            // Get the content from the textarea 'text' content and copy it to the editor
            if (instanceName == 'introhtml' )  {
                content = document.getElementById('introtext').value;
                //alert('Intro :' + instanceName + '\n' + content);
            } else {
                content = document.getElementById('bodytext').value;
                //alert('HTML :' + instanceName + '\n' + content);
            }
            oEditor.SetHTML(content);
        } else {
               content = getEditorContent(instanceName);
              if (instanceName == 'introhtml' )  {
                  document.getElementById('introtext').value = content;
              } else {
                  document.getElementById('bodytext').value = content;
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