
function ckeditor_newEditor(instanceName, options) {
    switch (options['toolbar']) {
        case 0:
            name = 'toolbar1';
            break;
        case 1:
            name = 'toolbar2';
            break;
        case 2:
            name = 'toolbar3';
            break;
        default:
            name = 'full';
    }
    CKEDITOR.replace(instanceName, {toolbar:name});
}

function ckeditor_setContent(instanceName, content) {
    CKEDITOR.instances[instanceName].setData(content);
}

function ckeditor_getContent(instanceName) {
    return CKEDITOR.instances[instanceName].getData();
}

function ckeditor_changeToolbar(instanceName, toolbar) {
    var name = '';
    switch (toolbar) {
        case 'editor-toolbar1':
            name = 'toolbar1';
            break;
        case 'editor-toolbar2':
            name = 'toolbar2';
            break;
        case 'editor-toolbar3':
            name = 'toolbar3';
            break;
        default:
            name = 'full';
    }
    CKEDITOR.instances[instanceName].destroy();
    CKEDITOR.replace(instanceName, {toolbar:name});
}

function ckeditor_changeTextAreaSize(instanceName, option) {
    var oEditor = CKEDITOR.instances[instanceName];
    var height = oEditor.ui.space('contents').getStyle('height');
    var currentSize = parseInt(height.replace("px", ""));
    if (option == 'larger') {
        var newsize = currentSize + 50;
    } else if (option == 'smaller') {
        var newsize = currentSize - 50;
    }
    oEditor.resize('100%', newsize, true);
}

AdvancedEditor.api['ckeditor'] = {
    newEditor:          ckeditor_newEditor,
    setContent:         ckeditor_setContent,
    getContent:         ckeditor_getContent,
    changeToolbar:      ckeditor_changeToolbar,
    changeTextAreaSize: ckeditor_changeTextAreaSize
};
