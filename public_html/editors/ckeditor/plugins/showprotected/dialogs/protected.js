
CKEDITOR.dialog.add( 'showProtectedDialog', function( editor ) {

	var size = CKEDITOR.document.getWindow().getViewPaneSize();

	// Make it maximum 700px wide, but still fully visible in the viewport.
	var width = Math.min(size.width - 30, 700);

	// Make it maximum 300px high, but still fully visible in the viewport.
	var height = Math.min(size.height - 130, 300);

	return {
		title: 'Edit Protected Source',
		minWidth: width,
		minHeight: height,

		onOk: function() {
			var newSourceValue = this.getContentElement( 'main', 'protectedSource' ).getValue();
			
			var encodedSourceValue = CKEDITOR.plugins.showprotected.encodeProtectedSource( newSourceValue );
			
			this._.selectedElement.setAttribute('data-cke-realelement', encodedSourceValue);
			this._.selectedElement.setAttribute('title', newSourceValue);
			this._.selectedElement.setAttribute('alt', newSourceValue);
		},

		onHide: function() {
			delete this._.selectedElement;
		},

		onShow: function() {
			this._.selectedElement = editor.getSelection().getSelectedElement();
			
			var decodedSourceValue = CKEDITOR.plugins.showprotected.decodeProtectedSource( this._.selectedElement.getAttribute('data-cke-realelement') );

			this.setValueOf( 'main', 'protectedSource', decodedSourceValue );

			if (typeof jQuery !== undefined) {
				var jqobj = jQuery('.cke_dialog_contents_body');
				// Fine-tune padding.
				jqobj.css('padding','10px');
				// Make textarea height resizable.
				jqobj.find('div').css('height','100%');
				jqobj.find('table').css('height','100%');
				jqobj.find('td').css('height','100%');
				jqobj.find('textarea').css('height','100%');
			}
		},
		contents: [ {
			id: 'main',
			label: 'Edit Protected Source',
			accessKey: 'I',
			elements: [ {
				type: 'textarea',
				id: 'protectedSource',
				dir: 'ltr',
				inputStyle: 'cursor:auto;' +
					'width:100%;' +
					'height:' + height + 'px;' +
					'tab-size:4;' +
					'text-align:left;',
				'class': 'cke_source',
				required: true,
				validate: function() {
					if ( !this.getValue() ) {
						alert( 'The value cannot be empty' );
						return false;
					}
					return true;
				}
			} ]
		} ]
	};
} );
