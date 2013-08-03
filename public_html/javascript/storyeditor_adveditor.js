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
    adve_newEditor('introhtml', {'toolbar':bar});
    adve_newEditor('bodyhtml',  {'toolbar':bar});
    document.getElementById('fckeditor_toolbar_selector').options[bar].selected = true;
}

function change_editmode(obj) {
    var navlistcount = document.getElementById('navlist').getElementsByTagName('li').length;
    showhideEditorDiv('editor', navlistcount - 6);
    if (obj.value == 'html') {
        document.getElementById('html_editor').style.display = 'none';
        document.getElementById('text_editor').style.display = '';
        swapEditorContent('html', 'introhtml');
        swapEditorContent('html', 'bodyhtml');
    } else if (obj.value == 'adveditor') {
        document.getElementById('text_editor').style.display = 'none';
        document.getElementById('html_editor').style.display = '';
        swapEditorContent('adveditor', 'introhtml');
        swapEditorContent('adveditor', 'bodyhtml');
    } else {
        document.getElementById('html_editor').style.display = 'none';
        document.getElementById('text_editor').style.display = '';
        swapEditorContent('text', 'introhtml');
        swapEditorContent('text', 'bodyhtml');
    }
}

function changeHTMLTextAreaSize(element, option) {
    adve_changeTextAreaSize(element, option);
}

function changeTextAreaSize(element, option) {
    var size = document.getElementById(element).rows;
    if (option == 'larger') {
        document.getElementById(element).rows = +(size) + 3;
    } else if (option == 'smaller') {
        document.getElementById(element).rows = +(size) - 3;
    }
}

function swapEditorContent(curmode,instanceName) {
    var textelem = (instanceName == 'introhtml') ? 'introtext' : 'bodytext';
    if (curmode == 'adveditor') {
        var content = document.getElementById(textelem).value;
        adve_setContent(instanceName, content)
    } else {
        document.getElementById(textelem).value = adve_getContent(instanceName);
    }
}

function set_postcontent() {
    if (document.getElementById('sel_editmode').value == 'adveditor') {
        document.getElementById('introtext').value = adve_getContent('introhtml');
        document.getElementById('bodytext').value = adve_getContent('bodyhtml');
    }
}

function changeToolbar(toolbar) {
    adve_changeToolbar('introhtml', toolbar);
    adve_changeToolbar('bodyhtml', toolbar);
}
