(function () {
    'use strict';

    var settings = JSON.parse(document.getElementById('media-settings').textContent);
    var currentPath = '';
    var itemsElement = document.getElementById('items');
    var statusElement = document.getElementById('status');
    var errorElement = document.getElementById('error');
    var breadcrumbsElement = document.getElementById('breadcrumbs');

    function setStatus(message) {
        statusElement.textContent = message || '';
    }

    function showError(message) {
        errorElement.textContent = message;
        errorElement.hidden = false;
    }

    function clearError() {
        errorElement.textContent = '';
        errorElement.hidden = true;
    }

    function request(action, options) {
        options = options || {};
        var url = new URL(settings.apiUrl, window.location.href);
        var controller = typeof AbortController !== 'undefined' ? new AbortController() : null;
        var timeout = null;
        var fetchOptions = {credentials: 'same-origin'};
        if (controller) {
            fetchOptions.signal = controller.signal;
            timeout = window.setTimeout(function () { controller.abort(); }, 30000);
        }
        if (options.method === 'POST') {
            fetchOptions.method = 'POST';
            fetchOptions.body = options.body || new FormData();
            fetchOptions.body.set('action', action);
            fetchOptions.body.set('type', settings.type);
            fetchOptions.body.set(settings.csrfName, settings.csrfToken);
        } else {
            url.searchParams.set('action', action);
            url.searchParams.set('type', settings.type);
            url.searchParams.set('path', options.path || '');
        }
        return fetch(url.toString(), fetchOptions).then(function (response) {
            return response.json().catch(function () {
                var contentType = response.headers.get('content-type') || 'unknown content type';
                throw new Error('The server returned invalid JSON (HTTP ' + response.status + ', ' + contentType + ').');
            }).then(function (payload) {
                if (payload.csrfToken) {
                    settings.csrfToken = payload.csrfToken;
                }
                if (!response.ok || !payload.ok) {
                    throw new Error(payload.error || 'The request failed.');
                }
                return payload;
            });
        }).catch(function (error) {
            if (error && error.name === 'AbortError') {
                throw new Error('The server did not answer within 30 seconds. The upload may have been blocked upstream.');
            }
            throw error;
        }).finally(function () {
            if (timeout !== null) { window.clearTimeout(timeout); }
        });
    }

    function validateUploadSelection(file) {
        var name = file && file.name ? file.name : '';
        var dot = name.lastIndexOf('.');
        var extension = dot >= 0 ? name.substring(dot + 1).toLowerCase() : '';
        var blocked = [
            'php', 'php3', 'php4', 'php5', 'php7', 'php8', 'phtml', 'phar',
            'cgi', 'pl', 'py', 'sh', 'bash', 'cmd', 'bat', 'com', 'exe', 'dll',
            'htaccess', 'config', 'ini'
        ];
        if (!extension || blocked.indexOf(extension) !== -1
            || settings.uploadExtensions.indexOf(extension) === -1) {
            throw new Error('This file type is not allowed. Allowed extensions: '
                + settings.uploadExtensions.join(', ') + '.');
        }
    }

    function addButton(label, className, handler) {
        var button = document.createElement('button');
        button.type = 'button';
        button.className = className || '';
        button.textContent = label;
        button.addEventListener('click', handler);
        return button;
    }

    function renderBreadcrumbs(path) {
        breadcrumbsElement.textContent = '';
        var root = addButton('Media', '', function () { load(''); });
        breadcrumbsElement.appendChild(root);
        var accumulated = '';
        path.split('/').filter(Boolean).forEach(function (part) {
            accumulated = accumulated ? accumulated + '/' + part : part;
            var target = accumulated;
            var separator = document.createElement('span');
            separator.textContent = ' / ';
            breadcrumbsElement.appendChild(separator);
            breadcrumbsElement.appendChild(addButton(part, '', function () { load(target); }));
        });
    }

    function formatSize(bytes) {
        if (bytes === null) { return ''; }
        if (bytes < 1024) { return bytes + ' B'; }
        if (bytes < 1048576) { return (bytes / 1024).toFixed(1) + ' KB'; }
        return (bytes / 1048576).toFixed(1) + ' MB';
    }

    function selectFile(item) {
        var callbackNumber = new URLSearchParams(window.location.search).get('CKEditorFuncNum');
        var target = window.opener || (window.parent !== window ? window.parent : null);
        if (callbackNumber && target && target.CKEDITOR && target.CKEDITOR.tools) {
            target.CKEDITOR.tools.callFunction(callbackNumber, item.url);
            window.close();
            return;
        }
        if (window.opener && typeof window.opener.SetUrl === 'function') {
            window.opener.SetUrl(item.url);
            window.close();
            return;
        }
        window.open(item.url, '_blank', 'noopener');
    }

    function mutate(action, values) {
        clearError();
        var body = new FormData();
        Object.keys(values).forEach(function (key) { body.set(key, values[key]); });
        setStatus('Working...');
        return request(action, {method: 'POST', body: body}).then(function () {
            return load(currentPath);
        }).catch(function (error) {
            setStatus('');
            showError(error.message);
        });
    }

    function renderItem(item) {
        var card = document.createElement('article');
        card.className = 'media-item ' + item.kind;
        var preview = document.createElement('button');
        preview.type = 'button';
        preview.className = 'media-preview';
        preview.setAttribute('aria-label', (item.kind === 'folder' ? 'Open ' : 'Select ') + item.name);
        if (item.kind === 'folder') {
            preview.textContent = 'Folder';
            preview.addEventListener('click', function () { load(item.path); });
        } else {
            if (item.image && settings.showThumbnails) {
                var image = document.createElement('img');
                image.src = item.url;
                image.alt = '';
                image.loading = 'lazy';
                preview.appendChild(image);
            } else {
                preview.textContent = 'File';
            }
            preview.addEventListener('click', function () { selectFile(item); });
        }
        card.appendChild(preview);

        var name = document.createElement('div');
        name.className = 'media-name';
        name.textContent = item.name;
        name.title = item.name;
        card.appendChild(name);

        var meta = document.createElement('div');
        meta.className = 'media-meta';
        meta.textContent = item.kind === 'file' ? formatSize(item.size) : 'Folder';
        card.appendChild(meta);

        if (!settings.browseOnly) {
            var controls = document.createElement('div');
            controls.className = 'media-controls';
            controls.appendChild(addButton('Rename', '', function () {
                var nextName = window.prompt('New name', item.name);
                if (nextName && nextName !== item.name) {
                    mutate('rename', {path: item.path, name: nextName});
                }
            }));
            controls.appendChild(addButton('Delete', 'danger', function () {
                if (!settings.confirmChanges || window.confirm('Delete "' + item.name + '"?')) {
                    mutate('delete', {path: item.path});
                }
            }));
            card.appendChild(controls);
        }
        return card;
    }

    function load(path) {
        clearError();
        setStatus('Loading...');
        return request('list', {path: path}).then(function (payload) {
            currentPath = payload.data.path;
            renderBreadcrumbs(currentPath);
            itemsElement.textContent = '';
            payload.data.items.forEach(function (item) {
                itemsElement.appendChild(renderItem(item));
            });
            setStatus(payload.data.items.length ? '' : 'This folder is empty.');
        }).catch(function (error) {
            setStatus('');
            showError(error.message);
        });
    }

    document.getElementById('refresh-button').addEventListener('click', function () { load(currentPath); });
    var uploadForm = document.getElementById('upload-form');
    if (uploadForm) {
        uploadForm.addEventListener('submit', function (event) {
            event.preventDefault();
            var fileInput = document.getElementById('upload-file');
            if (!fileInput.files.length) { return; }
            try {
                validateUploadSelection(fileInput.files[0]);
            } catch (validationError) {
                setStatus('');
                showError(validationError.message);
                return;
            }
            var body = new FormData();
            body.set('path', currentPath);
            body.set('upload', fileInput.files[0]);
            clearError();
            setStatus('Uploading...');
            request('upload', {method: 'POST', body: body}).then(function () {
                uploadForm.reset();
                return load(currentPath);
            }).catch(function (error) {
                setStatus('');
                showError(error.message);
            });
        });
    }
    var mkdirButton = document.getElementById('mkdir-button');
    if (mkdirButton) {
        mkdirButton.addEventListener('click', function () {
            var name = window.prompt('Folder name');
            if (name) { mutate('mkdir', {path: currentPath, name: name}); }
        });
    }

    load('');
}());
