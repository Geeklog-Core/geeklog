// +---------------------------------------------------------------------------+
// | Copyright (C) 2003,2004 by the following authors:                         |
// | Version 1.0    Date: Jun 4, 2005                                          |
// | Authors:   Blaine Lang - blaine@portalparts.com                           |
// |                                                                           |
// | Javascript functions for FCKEditor Integration into Geeklog               |
// |                                                                           |
// +---------------------------------------------------------------------------+


    window.onload = function() {
        var oFCKeditor1 = new FCKeditor( 'sp_content' ) ;
        oFCKeditor1.BasePath = geeklogEditorBasePath;
        oFCKeditor1.Config['CustomConfigurationsPath'] = geeklogEditorBaseUrl + '/fckeditor/myconfig.js';
        oFCKeditor1.ToolbarSet = 'editor-toolbar2' ;
        oFCKeditor1.Height = 200 ;
        oFCKeditor1.AutoGrowMax = 1200        
        oFCKeditor1.ReplaceTextarea() ;
    }

   function changeToolbar(toolbar) {
        var oEditor1 = FCKeditorAPI.GetInstance('sp_content');       
        oEditor1.ToolbarSet.Load( toolbar ) ;
   }
   
    function change_editmode(obj) {
        if (obj.value == 'adveditor') {
            document.getElementById('advanced_editarea').style.display='';
            document.getElementById('sel_toolbar').style.display='';             
            document.getElementById('html_editarea').style.display='none';
            swapEditorContent('advanced');
        } else {
            document.getElementById('advanced_editarea').style.display='none';
            document.getElementById('sel_toolbar').style.display='none';             
            document.getElementById('html_editarea').style.display='';
            swapEditorContent('html');
        }
    } 

    function swapEditorContent(curmode) {
        var content = '';
        var oEditor = FCKeditorAPI.GetInstance('sp_content');
        if (curmode == 'advanced') {
            content = document.getElementById('html_content').value;
            oEditor.SetHTML(content);
        } else {
            content = oEditor.GetXHTML( true );
            document.getElementById('html_content').value = content;         
       }
    }
    
    function set_postcontent() { 
        if (document.getElementById('sel_editmode').value == 'adveditor') {
            var oEditor = FCKeditorAPI.GetInstance('sp_content');        
            content = oEditor.GetXHTML( true );        
            document.getElementById('html_content').value = content;
        }
    }          
