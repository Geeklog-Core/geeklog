/* Geeklog Advanced Editor adapter. GPL-2.0-or-later. */
(function () {
    'use strict';
    var states = Object.create(null);
    var toolbars = [
        'code undo redo | bold italic | link | bullist numlist | image table | fullscreen',
        'code undo redo | bold italic underline strikethrough subscript superscript | link | bullist numlist outdent indent | alignleft aligncenter alignright blockquote | image table hr charmap | fullscreen',
        'code undo redo | blocks fontfamily fontsize | bold italic underline strikethrough subscript superscript removeformat | forecolor backcolor | link | bullist numlist outdent indent | alignleft aligncenter alignright alignjustify blockquote | image table hr charmap | fullscreen',
        'code undo redo | blocks fontfamily fontsize | bold italic underline strikethrough subscript superscript removeformat | forecolor backcolor | link anchor | bullist numlist outdent indent | alignleft aligncenter alignright alignjustify blockquote | image media table hr charmap | searchreplace visualblocks fullscreen preview'
    ];
    function allowed(tag, attribute) {
        return Object.prototype.hasOwnProperty.call(geeklogAllowedHtml, tag) &&
            (!attribute || (geeklogAllowedHtml[tag] &&
                Object.prototype.hasOwnProperty.call(geeklogAllowedHtml[tag], attribute)));
    }
    function toolbar(level) {
        var rules = {bold:['strong'], italic:['em'], underline:['u'], strikethrough:['s'],
            subscript:['sub'], superscript:['sup'], link:['a','href'], image:['img','src'],
            table:['table'], hr:['hr'], bullist:['ul'], numlist:['ol'], blockquote:['blockquote'],
            alignleft:['p','style'], aligncenter:['p','style'], alignright:['p','style'],
            alignjustify:['p','style'], indent:['p','style'], outdent:['p','style'],
            fontfamily:['span','style'], fontsize:['span','style'], forecolor:['span','style'],
            backcolor:['span','style'], anchor:['a','id'], media:['video']};
        return toolbars[level].split(' ').filter(function (button) {
            var rule = rules[button];
            return !rule || (allowed.apply(null, rule) &&
                (button !== 'table' || ['tr','td','th'].every(function (tag) { return allowed(tag); })));
        }).join(' ').replace(/\|\s*\|/g, '|');
    }
    function picker(callback, value, meta) {
        var url = new URL(geeklog.site_url + '/filemanager/index.php', window.location.href);
        url.searchParams.set('Type', meta.filetype === 'image' ? 'Image' : 'File');
        url.searchParams.set('GeeklogPicker', '1');
        var popup = window.open(url.href, '_blank', 'width=1000,height=750,resizable=yes,scrollbars=yes');
        if (!popup) { return; }
        var timer;
        function cleanup() {
            window.removeEventListener('message', receive);
            window.clearInterval(timer);
        }
        function receive(event) {
            if (event.origin !== url.origin || event.source !== popup ||
                !event.data || event.data.type !== 'geeklog-media-selected' ||
                typeof event.data.url !== 'string') { return; }
            var selected;
            try { selected = new URL(event.data.url, url.origin); } catch (e) { return; }
            if (selected.protocol !== 'https:' && selected.protocol !== 'http:') { return; }
            cleanup();
            popup.close();
            callback(selected.href);
        }
        window.addEventListener('message', receive);
        timer = window.setInterval(function () { if (popup.closed) { cleanup(); } }, 1000);
    }
    function start(id, level) {
        var element = document.getElementById(id);
        if (!element) { return; }
        var state = states[id] = {element:element, level:level, ready:false, height:element.offsetHeight || 300};
        function config() {
            return {
                target: element, license_key:'gpl', menubar:false, promotion:false, branding:false,
                height:state.height, toolbar:toolbar(state.level),
                plugins:'code lists link image table charmap fullscreen anchor media searchreplace visualblocks preview',
                entity_encoding:'raw', convert_urls:false, verify_html:true,
                valid_elements:'*[*]', extended_valid_elements:'*[*]',
                protect:[/<pre\b[\s\S]*?<\/pre>/gi, /\[code(?:\s[^\]]*)?\][\s\S]*?\[\/code\]/gi, /\[raw(?:\s[^\]]*)?\][\s\S]*?\[\/raw\]/gi],
                automatic_uploads:false, paste_data_images:false,
                file_picker_types:'file image media',
                file_picker_callback:geeklogFileManager ? picker : undefined,
                setup:function (editor) {
                    editor.on('init', function () {
                        state.ready = true;
                        if (state.pending !== undefined) { editor.setContent(state.pending); delete state.pending; }
                        if (state.requested !== undefined && state.requested !== state.level) {
                            var requested = state.requested;
                            window.setTimeout(function () { changeToolbar(id, requested); }, 0);
                        }
                    });
                    editor.on('change input undo redo', function () { if (state.ready) { editor.save(); } });
                }
            };
        }
        if (typeof tinymce === 'undefined') { return; }
        tinymce.init(config()).catch(function (error) {
            state.ready = false;
            element.style.display = '';
            if (window.console) { console.error('Geeklog TinyMCE initialization failed', error); }
        });
    }
    function getContent(id) {
        var state = states[id], editor = typeof tinymce !== 'undefined' && tinymce.get(id);
        return state && state.ready && editor ? editor.getContent() : document.getElementById(id).value;
    }
    function setContent(id, content) {
        var state = states[id], editor = typeof tinymce !== 'undefined' && tinymce.get(id);
        document.getElementById(id).value = content;
        if (state && state.ready && editor) { editor.setContent(content); }
        else if (state) { state.pending = content; }
    }
    function changeToolbar(id, level) {
        var state = states[id];
        if (!state) { return; }
        if (typeof level === 'string') {
            level = {'editor-toolbar1':0,'editor-toolbar2':1,'editor-toolbar3':2}[level];
            if (level === undefined) { level = 3; }
        }
        if (!state.ready) { state.requested = level; return; }
        if (state.level === level) { return; }
        var content = getContent(id), height = state.height;
        tinymce.get(id).remove();
        state.element.value = content;
        start(id, level);
        states[id].height = height;
    }
    AdvancedEditor.api.tinymce = {
        newEditor:function (id, options) { var n = Number(options.toolbar); start(id, n >= 0 && n <= 3 ? n : 1); },
        setContent:setContent, getContent:getContent, changeToolbar:changeToolbar,
        changeTextAreaSize:function (id, option) {
            var state = states[id], editor = typeof tinymce !== 'undefined' && tinymce.get(id);
            if (!state) { return; }
            state.height = Math.max(150, state.height + (option === 'larger' ? 50 : -50));
            if (state.ready && editor) { editor.getContainer().style.height = state.height + 'px'; }
            else { state.element.style.height = state.height + 'px'; }
        }
    };
}());
