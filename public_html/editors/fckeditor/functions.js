
function fckeditor_newEditor(instanceName, options) {
    var oEditor = new FCKeditor(instanceName);
    oEditor.BasePath = geeklogEditorBasePath;
    oEditor.Config['CustomConfigurationsPath'] = geeklogEditorBaseUrl + '/fckeditor/myconfig.js';
    oEditor.ToolbarSet = 'editor-toolbar' + (options['toolbar'] + 1);
    oEditor.Height = 200;
    oEditor.ReplaceTextarea();
}

function fckeditor_getContent(instanceName) {
    return FCKeditorAPI.GetInstance(instanceName).GetXHTML(true);
}

function fckeditor_setContent(instanceName, content) {
    FCKeditorAPI.GetInstance(instanceName).SetHTML(content);
}

function fckeditor_changeToolbar(instanceName, toolbar) {
    FCKeditorAPI.GetInstance(instanceName).ToolbarSet.Load(toolbar);
}

function fckeditor_changeTextAreaSize(instanceName, option) {
    var currentSize = parseInt(document.getElementById(instanceName + '___Frame').style.height);
    if (option == 'larger') {
        var newsize = currentSize + 50;
    } else if (option == 'smaller') {
        var newsize = currentSize - 50;
    }
    document.getElementById(instanceName + '___Frame').style.height = newsize + 'px';
}

AdvancedEditor.api['fckeditor'] = {
    newEditor:          fckeditor_newEditor,
    setContent:         fckeditor_setContent,
    getContent:         fckeditor_getContent,
    changeToolbar:      fckeditor_changeToolbar,
    changeTextAreaSize: fckeditor_changeTextAreaSize
};
