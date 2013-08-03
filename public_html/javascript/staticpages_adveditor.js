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
    var bar = 1;
    if (navigator.userAgent.match(/iPhone|Android|IEMobile/i)) {
        bar = 0;
    }
    document.getElementById('advanced_editor').style.display = '';
    adve_newEditor('adv_content', {'toolbar':bar});
    document.getElementById('fckeditor_toolbar_selector').options[bar].selected = true;
}

function changeToolbar(toolbar) {
    adve_changeToolbar('adv_content', toolbar);
}

function change_editmode(obj) {
    if (obj.value == 'adveditor') {
        document.getElementById('advanced_editarea').style.display = '';
        document.getElementById('sel_toolbar').style.display = '';
        document.getElementById('html_editarea').style.display = 'none';
        swapEditorContent('advanced');
    } else {
        document.getElementById('advanced_editarea').style.display = 'none';
        document.getElementById('sel_toolbar').style.display = 'none';
        document.getElementById('html_editarea').style.display = '';
        swapEditorContent('html');
    }
}

function swapEditorContent(curmode) {
    if (curmode == 'advanced') {
        var content = document.getElementById('html_content').value;
        adve_setContent('adv_content', content);
    } else {
        document.getElementById('html_content').value = adve_getContent('adv_content');
    }
}

function set_postcontent() {
    if (document.getElementById('sel_editmode').value == 'adveditor') {
        document.getElementById('html_content').value = adve_getContent('adv_content');
    }
}
