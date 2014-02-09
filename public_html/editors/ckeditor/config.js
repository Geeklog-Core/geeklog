/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

var tools = {
	items: {
		'source': ['Source'],
		'clipboard': ['Cut', 'Copy', 'Paste', 'PasteText'],
		'undo': ['Undo', 'Redo'],
		'editing': ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'],
		'links': ['Link', 'Unlink'],
		'basicstyles': ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'],
		'insert': ['Image', 'Table', 'HorizontalRule', 'SpecialChar'],
		'paragraph': ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', '-', 'BidiLtr', 'BidiRtl'],
		'styles': ['Styles', 'Format', 'Font', 'FontSize'],
		'colors': ['TextColor', 'BGColor'],
		'tools': ['Maximize', 'ShowBlocks'],
		'about': ['About'],

		'basicstyles_basic': ['Bold', 'Italic'],
		'paragraph_basic': ['NumberedList', 'BulletedList'],

		'insert_advanced': ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar']
	},

	allowed: function(tag, attr) {
		var undefined;
		if (tag === undefined) {
			return undefined;
		}
		if (geeklogAllowedHtml[tag] === undefined) {
			return false;
		}
		if (attr === 1) {
			return true;
		}
		for (var i in attr) {
			if (geeklogAllowedHtml[tag][i] === undefined) {
				return false;
			}
		}
		return true;
	},

	remove_one: function(ary, target) {
		ary = this.items[ary];
		for (var i = ary.length - 1; i >= 0; i--) {
			if (ary[i] === target) ary.splice(i, 1);
		}
	},

	remove: function(pattern, target) {
		for (var i in pattern) {
			if (!this.allowed(i, pattern[i])) {
				for (var j in target) {
					for (var k in target[j]) {
						this.remove_one(j, target[j][k]);
					}
				}
			}
		}
	}
};

tools.remove({'strong':1}, {'basicstyles':['Bold'], 'basicstyles_basic':['Bold']});
tools.remove({'em':1}, {'basicstyles':['Italic'], 'basicstyles_basic':['Italic']});
tools.remove({'u':1}, {'basicstyles':['Underline']});
tools.remove({'s':1}, {'basicstyles':['Strike']});
tools.remove({'sub':1}, {'basicstyles':['Subscript']});
tools.remove({'sup':1}, {'basicstyles':['Superscript']});
tools.remove({'img':1}, {'insert':['Image'], 'insert_advanced':['Image']});
tools.remove({'table':1,'tr':1,'th':1,'td':1}, {'insert':['Table'], 'insert_advanced':['Table']});
tools.remove({'hr':1}, {'insert':['HorizontalRule'], 'insert_advanced':['HorizontalRule']});
tools.remove({'p':{'style':1}}, {'paragraph':['Outdent','Indent','JustifyLeft','JustifyCenter','JustifyRight']});
tools.remove({'p':{'dir':1}}, {'paragraph':['BidiLtr','BidiRtl']});
tools.remove({'blockquote':1}, {'paragraph':['Blockquote']});
tools.remove({'div':1}, {'paragraph':['CreateDiv']});
tools.remove({'span':{'style':1}}, {'styles':['Font','FontSize'], 'colors':['TextColor','BGColor']});

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

	// Add extra plugins
	// Makes protected source sections visible and editable.
	// Especially important for [code]..[/code] and [raw]..[/raw] for Geeklog.
	config.extraPlugins = 'showprotected';

	// Disable Advanced Content Filter
	config.allowedContent = true;

	// Whether to escape basic HTML entities in the document
	config.basicEntities = false;

	// Whether to use HTML entities in the output.
	config.entities = false;

	// Whether to convert some symbols, mathematical symbols, and Greek letters to HTML entities.
	config.entities_greek = false;

	// Whether to convert some Latin characters (Latin alphabet No. 1, ISO 8859-1) to HTML entities.
	config.entities_latin = false;

	// Whether automatically create wrapping blocks around inline contents
	config.autoParagraph = false;

	config.protectedSource.push(/<pre[\s\S]+?\/pre>/g);
	config.protectedSource.push(/\[code[^:][\s\S]+?\/code\]/g);
	config.protectedSource.push(/\[raw[\s\S]+?\/raw\]/g);

	config.toolbar = 'toolbar1';

	config.toolbar_toolbar1 = [
		tools.items['source'],
		tools.items['undo'],
		tools.items['basicstyles_basic'],
		tools.items['links'],
		tools.items['paragraph_basic'],
		tools.items['insert'],
		tools.items['tools']
	];

	config.toolbar_toolbar2 = [
		tools.items['source'],
		tools.items['clipboard'],
		tools.items['undo'],
		tools.items['editing'],
		tools.items['basicstyles'],
		tools.items['links'],
		tools.items['paragraph'],
		tools.items['insert'],
		tools.items['tools']
	];

	config.toolbar_toolbar3 = [
		tools.items['source'],
		tools.items['clipboard'],
		tools.items['undo'],
		tools.items['editing'],
		tools.items['basicstyles'],
		tools.items['links'],
		tools.items['paragraph'],
		tools.items['insert_advanced'],
		tools.items['colors'],
		tools.items['tools'],
		tools.items['styles']
	];

	config.toolbar_full = [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
		{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl' ] },
		{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
		{ name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
		'/',
		{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
		{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
		{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
		{ name: 'others', items: [ '-' ] },
		{ name: 'about', items: [ 'About' ] }
	];

	// Filemanager
	config.filebrowserBrowseUrl = geeklog.site_url + '/filemanager/index.php?Type=File';
//	config.filebrowserBrowseUrl = geeklog.site_url + '/filemanager/index.php?Type=Media';
	config.filebrowserImageBrowseUrl = geeklog.site_url + '/filemanager/index.php?Type=Image';
	config.filebrowserFlashBrowseUrl = geeklog.site_url + '/filemanager/index.php?Type=Flash';
};


CKEDITOR.on('instanceReady', function(ev) {
	// Fix ends of self closing tags
	ev.editor.dataProcessor.writer.selfClosingEnd = geeklog.xhtml + '>';
});
