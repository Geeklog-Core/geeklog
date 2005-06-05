// +---------------------------------------------------------------------------+
// | Copyright (C) 2003,2004 by the following authors:                         |
// | Version 1.0    Date: Jun 4, 2005                                          |
// | Authors:   Blaine Lang - blaine@portalparts.com                           |
// |                                                                           |
// | Javascript functions for FCKEdior Integration into Geeklog                |
// |                                                                           |
// +---------------------------------------------------------------------------+

    window.onload = function() {
        var oFCKeditor1 = new FCKeditor( 'introhtml' ) ;
        oFCKeditor1.BasePath = geeklogEditorBasePath;
        oFCKeditor1.ToolbarSet = 'editor-toolbar3' ;
        oFCKeditor1.Height = 200 ;
        oFCKeditor1.ReplaceTextarea() ;

        var oFCKeditor2 = new FCKeditor( 'bodyhtml' ) ;
        oFCKeditor2.BasePath = geeklogEditorBasePath ;
        oFCKeditor2.ToolbarSet = 'editor-toolbar3' ;
        oFCKeditor2.Height = 200 ;
        oFCKeditor2.ReplaceTextarea() ;

    }

    function change_editmode(obj) {
        if (obj.value == 'html') {
            document.getElementById('text_editor').style.display='none';
            document.getElementById('html_editor').style.display='';
            swapEditorContent('html','intro');
            swapEditorContent('html','body');
        } else {
            document.getElementById('text_editor').style.display='';
            document.getElementById('html_editor').style.display='none';
            swapEditorContent('text','intro');
            swapEditorContent('text','body');
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
        editor_frame = document.getElementById(instanceName+'___Frame');
        editor_source = editor_frame.contentWindow.document.getElementById('eEditorArea');
        if (editor_source!=null) {
            return editor_source.contentWindow.document.body.innerHTML;
        } else {
            return '';
        }
    }

    function swapEditorContent(curmode,instance) {
        var content = '';
        if (instance == 'intro' )  {
            editor_frame = document.getElementById('introhtml___Frame');
        } else {
            editor_frame = document.getElementById('bodyhtml___Frame');
        }
        editor_source = editor_frame.contentWindow.document.getElementById('eEditorArea');

        if (curmode == 'html') {
            if (instance == 'intro' )  {
                content = document.getElementById('introtext').value;
            } else {
                content = document.getElementById('bodytext').value;
            }
            editor_source.contentWindow.document.body.innerHTML = content;
        } else {
            content = editor_source.contentWindow.document.body.innerHTML;
            if (instance == 'intro' )  {
                document.getElementById('introtext').value = content;
            } else {
                document.getElementById('bodytext').value = content;
            }
        }
    }

    function set_postcontent() {
        if (document.getElementById('sel_editmode').value == 'html') {
            document.getElementById('introtext').value = getEditorContent('introtext');
            document.getElementById('bodytext').value = getEditorContent('bodytext');
        }
    }

   function changeToolbar(toolbar) {
        var basePath= "{site_url}/fckeditor/" ;
        var instanceName='introhtml';
        editor_frame = document.getElementById(instanceName+'___Frame');
        //alert(editor_frame.src);
        if (editor_frame!=null) {
            //editor_frame.src=basePath+'editor/fckeditor.html?InstanceName='+instanceName+'&Toolbar='+toolbar;
            editor_frame.src='http://localhost/geekcvs/fckeditor/editor/fckeditor.html?InstanceName=introhtml&Toolbar=editor-toolbar1';
            //editor_frame.src='http://www.google.com';
        }
   }