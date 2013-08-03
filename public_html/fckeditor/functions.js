
function adve_newEditor(instanceName, options) {
    var oEditor = new FCKeditor(instanceName);
    oEditor.BasePath = geeklogEditorBasePath;
    oEditor.Config['CustomConfigurationsPath'] = geeklogEditorBaseUrl + '/fckeditor/myconfig.js';
    oEditor.ToolbarSet = 'editor-toolbar' + (options['toolbar'] + 1);
    oEditor.Height = 200;
    oEditor.ReplaceTextarea();
}

function adve_getContent(instanceName) {
    return FCKeditorAPI.GetInstance(instanceName).GetXHTML(true);
}

function adve_setContent(instanceName, content) {
    FCKeditorAPI.GetInstance(instanceName).SetHTML(content);
}

function adve_changeToolbar(instanceName, toolbar) {
    FCKeditorAPI.GetInstance(instanceName).ToolbarSet.Load(toolbar);
}

function adve_changeTextAreaSize(instanceName, option) {
    var currentSize = parseInt(document.getElementById(instanceName + '___Frame').style.height);
    if (option == 'larger') {
        var newsize = currentSize + 50;
    } else if (option == 'smaller') {
        var newsize = currentSize - 50;
    }
    document.getElementById(instanceName + '___Frame').style.height = newsize + 'px';
}
