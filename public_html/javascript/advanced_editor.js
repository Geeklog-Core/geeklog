/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.0                                                               |
// +---------------------------------------------------------------------------+
// | Javascript functions for WYSIWYG HTML Editor Integration into Geeklog     |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2003-2013 by the following authors:                         |
// |                                                                           |
// | Authors:   Blaine Lang       - blaine AT portalparts DOT com              |
// |            Yoshinori Tahara  - dengenxp AT gmail DOT com                  |
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

AdvancedEditor = new Object();

AdvancedEditor.TextareaId = [];

AdvancedEditor.ContainerId = 'advanced_editor';

AdvancedEditor.SelToolbarId = 'fckeditor_toolbar_selector';

AdvancedEditor.EditModeId = 'sel_editmode';

AdvancedEditor.ValModeAdvanced = 'adveditor';

AdvancedEditor.AutoToolbar = true;

AdvancedEditor.api = [];

AdvancedEditor.editor = 'ckeditor';

AdvancedEditor.newEditor = function(options) {
    if (geeklogEditorName) {
        this.editor = geeklogEditorName;
    }
    if (options.editor) {
        this.editor = options.editor;
    }
    if (options.TextareaId) {
        this.TextareaId = options.TextareaId;
    }
    if (options.ValModeAdvanced) {
        this.ValModeAdvanced = options.ValModeAdvanced;
    }
    if (options.AutoToolbar === false) {
        this.AutoToolbar = false;
    }

    var bar = 1;
    if (options.toolbar !== false) {
        bar = options.toolbar;
    }
    if (this.AutoToolbar === true &&
            navigator.userAgent.match(/iPhone|Android|IEMobile/i)) {
        bar = 0;
    }

    for (var i = 0; i < this.TextareaId.length; i++) {
        this.api[this.editor].newEditor(this.TextareaId[i].advanced, {toolbar:bar});
    }

    this.addEvent();

    var elem;
    elem = document.getElementById(this.ContainerId);
    if (elem) elem.style.display = '';

    elem = document.getElementById(this.SelToolbarId);
    if (elem) elem.options[bar].selected = true;
}

AdvancedEditor.isAdvancedMode = function() {
    return (document.getElementById(this.EditModeId).value == this.ValModeAdvanced);
}

AdvancedEditor.swapEditorContent = function() {
    if (this.isAdvancedMode()) {
        for (var i = 0; i < this.TextareaId.length; i++) {
            this.api[this.editor].setContent(this.TextareaId[i].advanced,
                document.getElementById(this.TextareaId[i].plain).value);
        }
    } else {
        for (var i = 0; i < this.TextareaId.length; i++) {
            document.getElementById(this.TextareaId[i].plain).value =
                this.api[this.editor].getContent(this.TextareaId[i].advanced);
        }
    }
}

AdvancedEditor.set_postcontent = function() {
    if (!this.isAdvancedMode()) return;
    for (var i = 0; i < this.TextareaId.length; i++) {
        document.getElementById(this.TextareaId[i].plain).value =
            this.api[this.editor].getContent(this.TextareaId[i].advanced);
    }
}

AdvancedEditor.changeHTMLTextAreaSize = function(element, option) {
    this.api[this.editor].changeTextAreaSize(element, option);
}

AdvancedEditor.changeToolbar = function(toolbar) {
    for (var i = 0; i < this.TextareaId.length; i++) {
        this.api[this.editor].changeToolbar(this.TextareaId[i].advanced, toolbar);
    }
}

AdvancedEditor.addEvent = function() {
    var elem = document.getElementById(this.EditModeId);
    this.addEventListener(elem, 'change', this.onchange_editmode);
}

AdvancedEditor.addEventListener = function(target, type, listener) {
    if (target.addEventListener) {
        target.addEventListener(type, listener, false);
    } else if (target.attachEvent) {
        target.attachEvent('on' + type, listener); // support legacy IE
    }
}

AdvancedEditor.onchange_editmode = function() {
    if (AdvancedEditor.isAdvancedMode()) {
        document.getElementById('text_editor').style.display = 'none';
        document.getElementById('html_editor').style.display = '';
    } else {
        document.getElementById('text_editor').style.display = '';
        document.getElementById('html_editor').style.display = 'none';
    }
    AdvancedEditor.swapEditorContent();
}

function changeToolbar(toolbar) {
    AdvancedEditor.changeToolbar(toolbar);
}

function changeHTMLTextAreaSize(element, option) {
    AdvancedEditor.changeHTMLTextAreaSize(element, option);
}

function set_postcontent() {
    AdvancedEditor.set_postcontent();
}

function change_editmode(obj) {
    /* do nothing */
}

function changeTextAreaSize(element, option) {
    document.getElementById(element).rows += (option == 'larger' ? 3 : -3);
}

