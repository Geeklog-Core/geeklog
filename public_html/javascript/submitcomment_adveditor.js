/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.0                                                               |
// +---------------------------------------------------------------------------+
// | Javascript functions for WISIWIG HTML Editor Integration into Geeklog     |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2003-2013 by the following authors:                         |
// |                                                                           |
// | Authors:   Blaine Lang - blaine@portalparts.com                           |
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
    document.getElementById('advanced_editor').style.display = '';
    adve_newEditor('comment_html', {'toolbar':0});
}

function change_editmode(obj) {
    if (obj.value == 'html') {
        document.getElementById('text_editor').style.display = 'none';
        document.getElementById('html_editor').style.display = '';
        swapEditorContent('html');
    } else {
        document.getElementById('text_editor').style.display = '';
        document.getElementById('html_editor').style.display = 'none';
        swapEditorContent('text');
    }
}

function swapEditorContent(curmode) {
    if (curmode == 'html') {
        var content = document.getElementById('comment_text').value;
        adve_setContent('comment_html', content);
    } else {
        document.getElementById('comment_text').value = adve_getContent('comment_html');
    }
}

function set_postcontent() {
    if (document.getElementById('sel_editmode').value == 'html') {
        document.getElementById('comment_text').value = adve_getContent('comment_html');
    }
}
