/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2003-2009 by the following authors:                         |
// | Version 1.0    Date: Jun 4, 2005                                          |
// | Authors:   Blaine Lang - blaine@portalparts.com                           |
// |                                                                           |
// | Javascript functions for FCKEditor Integration into Geeklog               |
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


    window.onload = function() {
        var oFCKeditor1 = new FCKeditor( 'sp_content' ) ;
        oFCKeditor1.BasePath = geeklogEditorBasePath;
        oFCKeditor1.Config['CustomConfigurationsPath'] = geeklogEditorBaseUrl + '/fckeditor/myconfig.js';
        oFCKeditor1.ToolbarSet = 'editor-toolbar2' ;
        oFCKeditor1.Height = 400 ;
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
