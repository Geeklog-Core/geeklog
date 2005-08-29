// +---------------------------------------------------------------------------+
// | Copyright (C) 2003,2004 by the following authors:                         |
// | Version 1.0    Date: Jun 4, 2005                                          |
// | Authors:   Blaine Lang - blaine@portalparts.com                           |
// |                                                                           |
// | Javascript functions for FCKEditor Integration into Geeklog                |
// |                                                                           |
// +---------------------------------------------------------------------------+


    window.onload = function() {
        var oFCKeditor1 = new FCKeditor( 'sp_content' ) ;
        oFCKeditor1.BasePath = geeklogEditorBasePath;
        oFCKeditor1.ToolbarSet = 'editor-toolbar3' ;
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
        var basePath= geeklogEditorBasePath ;
        var instanceName='sp_content';
        editor_frame = document.getElementById(instanceName+'___Frame');
        //alert(editor_frame.src);
        if (editor_frame!=null) {
            editor_frame.src=basePath+'editor/fckeditor.html?InstanceName='+instanceName+'&Toolbar='+toolbar;
            //editor_frame.src='http://localhost/geekcvs/fckeditor/editor/fckeditor.html?InstanceName=sp_content&Toolbar=editor-toolbar1';
        }
   }