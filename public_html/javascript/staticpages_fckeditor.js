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
        oFCKeditor1.ReplaceTextarea() ;
    }

    function changeHTMLAreaSize(option) {
        var size = 0;
        var size = document.getElementById('sp_content___Frame').height;
        if (option == 'larger') {
            document.getElementById('sp_content___Frame').height = +(size) + 50;
        } else if (option == 'smaller') {
            document.getElementById('sp_content___Frame').height = +(size) - 50;
        }
    }

   function changeToolbar(toolbar) {
        var oEditor1 = FCKeditorAPI.GetInstance('sp_content');
        oEditor1.ToolbarSet.Load( toolbar ) ;
   }
