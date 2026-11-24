(function () {
    'use strict';

    var settings = JSON.parse(document.getElementById('media-settings').textContent);
    var labels = settings.labels || {};
    function t(key, values) {
        var value = labels[key] || key;
        Object.keys(values || {}).forEach(function (name) {
            value = value.split('{' + name + '}').join(String(values[name]));
        });
        return value;
    }
    var currentPath = '';
    var itemsElement = document.getElementById('items');
    var statusElement = document.getElementById('status');
    var errorElement = document.getElementById('error');
    var breadcrumbsElement = document.getElementById('breadcrumbs');
    var allItems = [];
    var searchQuery = '';
    var sortOrder = 'name-asc';
    var viewMode = 'grid';
    var searchInput;
    var sortSelect;
    var viewButtons = {};
    var resultCount;

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
                var contentType = response.headers.get('content-type') || t('unknownContent');
                throw new Error(t('invalidResponse', {status: response.status, type: contentType}));
            }).then(function (payload) {
                if (payload.csrfToken) {
                    settings.csrfToken = payload.csrfToken;
                }
                if (!response.ok || !payload.ok) {
                    throw new Error(payload.error || t('requestFailed'));
                }
                return payload;
            });
        }).catch(function (error) {
            if (error && error.name === 'AbortError') {
                throw new Error(t('timeout'));
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
            throw new Error(t('invalidFile', {extensions: settings.uploadExtensions.join(', ')}));
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
        var root = addButton(t('mediaRoot'), '', function () { load(''); });
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
        setStatus(t('working'));
        return request(action, {method: 'POST', body: body}).then(function () {
            return load(currentPath);
        }).catch(function (error) {
            setStatus('');
            showError(error.message);
        });
    }

    function icon(name) {
        var paths = {
            folder: '<path d="M3 7a2 2 0 0 1 2-2h5l2 2h7a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>',
            file: '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/>',
            grid: '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>',
            list: '<path d="M8 6h13M8 12h13M8 18h13"/><path d="M3 6h.01M3 12h.01M3 18h.01" stroke-width="3" stroke-linecap="round"/>',
            search: '<circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/>'
        };
        var svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
        svg.setAttribute('viewBox', '0 0 24 24');
        svg.setAttribute('fill', 'none');
        svg.setAttribute('stroke', 'currentColor');
        svg.setAttribute('stroke-width', '1.7');
        svg.setAttribute('stroke-linecap', 'round');
        svg.setAttribute('stroke-linejoin', 'round');
        svg.setAttribute('aria-hidden', 'true');
        // Only hard-coded, locally defined SVG paths are inserted here.
        svg.innerHTML = paths[name] || paths.file;
        return svg;
    }

    function renderItem(item) {
        var card = document.createElement('article');
        card.className = 'media-item ' + item.kind;
        var preview = document.createElement('button');
        preview.type = 'button';
        preview.className = 'media-preview';
        preview.setAttribute('aria-label', (item.kind === 'folder' ? t('open') : t('select')) + ' ' + item.name);
        preview.title = item.name;
        if (item.kind === 'folder') {
            preview.appendChild(icon('folder'));
            preview.addEventListener('click', function () { load(item.path); });
        } else {
            if (item.image && settings.showThumbnails) {
                var image = document.createElement('img');
                image.src = item.url;
                image.alt = '';
                image.loading = 'lazy';
                image.addEventListener('error', function () {
                    // Broken, empty or unsupported images get a neutral file icon.
                    image.remove();
                    preview.appendChild(icon('file'));
                }, {once: true});
                preview.appendChild(image);
            } else {
                preview.appendChild(icon('file'));
            }
            preview.addEventListener('click', function () { selectFile(item); });
        }
        card.appendChild(preview);

        var info = document.createElement('div');
        info.className = 'media-info';
        var name = document.createElement('div');
        name.className = 'media-name';
        name.textContent = item.name;
        name.title = item.name;
        info.appendChild(name);

        var meta = document.createElement('div');
        meta.className = 'media-meta';
        meta.textContent = item.kind === 'file' ? formatSize(item.size) : t('folder');
        info.appendChild(meta);
        card.appendChild(info);

        if (settings.canManage) {
            var controls = document.createElement('details');
            controls.className = 'media-controls';
            var summary = document.createElement('summary');
            summary.textContent = '⋯';
            summary.title = t('actionsFor') + ' ' + item.name;
            summary.setAttribute('aria-label', t('actionsFor') + ' ' + item.name);
            controls.appendChild(summary);
            var menu = document.createElement('div');
            menu.className = 'media-control-menu';
            menu.appendChild(addButton(t('rename'), '', function () {
                controls.open = false;
                var nextName = window.prompt(t('newName'), item.name);
                if (nextName && nextName !== item.name) {
                    mutate('rename', {path: item.path, name: nextName});
                }
            }));
            menu.appendChild(addButton(t('delete'), 'danger', function () {
                controls.open = false;
                if (!settings.confirmChanges || window.confirm(t('confirmDelete', {name: item.name}))) {
                    mutate('delete', {path: item.path});
                }
            }));
            controls.appendChild(menu);
            controls.addEventListener('toggle', function () {
                if (controls.open) {
                    itemsElement.querySelectorAll('details.media-controls[open]').forEach(function (other) {
                        if (other !== controls) { other.open = false; }
                    });
                }
            });
            card.appendChild(controls);
        }
        return card;
    }

    function compareItems(a, b) {
        if (sortOrder === 'size-desc' || sortOrder === 'size-asc') {
            var difference = (Number(a.size) || 0) - (Number(b.size) || 0);
            if (difference !== 0) {
                return sortOrder === 'size-desc' ? -difference : difference;
            }
        }
        var comparison = a.name.localeCompare(b.name, undefined, {numeric: true, sensitivity: 'base'});
        return sortOrder === 'name-desc' ? -comparison : comparison;
    }

    function renderResults() {
        var filtered = allItems.filter(function (item) {
            return item.name.toLocaleLowerCase().indexOf(searchQuery) !== -1;
        });
        var folders = filtered.filter(function (item) { return item.kind === 'folder'; }).sort(compareItems);
        var files = filtered.filter(function (item) { return item.kind !== 'folder'; }).sort(compareItems);
        itemsElement.textContent = '';
        itemsElement.className = 'media-results view-' + viewMode;
        [{title: t('folders'), items: folders}, {title: t('files'), items: files}].forEach(function (group) {
            if (!group.items.length) { return; }
            var section = document.createElement('section');
            section.className = 'media-group';
            var heading = document.createElement('h2');
            heading.textContent = group.title + ' (' + group.items.length + ')';
            section.appendChild(heading);
            var grid = document.createElement('div');
            grid.className = 'media-grid';
            group.items.forEach(function (item) { grid.appendChild(renderItem(item)); });
            section.appendChild(grid);
            itemsElement.appendChild(section);
        });
        resultCount.textContent = t('itemCount', {count: filtered.length});
        setStatus(filtered.length ? '' : (searchQuery ? t('noMatches') : t('empty')));
    }

    function createToolbar() {
        var toolbar = document.createElement('div');
        toolbar.className = 'media-toolbar';

        var searchLabel = document.createElement('label');
        searchLabel.className = 'media-search';
        searchLabel.appendChild(icon('search'));
        searchInput = document.createElement('input');
        searchInput.type = 'search';
        searchInput.placeholder = t('searchPlaceholder');
        searchInput.setAttribute('aria-label', t('searchLabel'));
        searchInput.addEventListener('input', function () {
            searchQuery = searchInput.value.toLocaleLowerCase().trim();
            renderResults();
        });
        searchLabel.appendChild(searchInput);
        toolbar.appendChild(searchLabel);

        sortSelect = document.createElement('select');
        sortSelect.className = 'media-sort';
        sortSelect.setAttribute('aria-label', t('sortLabel'));
        [
            ['name-asc', t('sortNameAsc')],
            ['name-desc', t('sortNameDesc')],
            ['size-desc', t('sortSizeDesc')],
            ['size-asc', t('sortSizeAsc')]
        ].forEach(function (option) {
            var element = document.createElement('option');
            element.value = option[0];
            element.textContent = option[1];
            sortSelect.appendChild(element);
        });
        sortSelect.addEventListener('change', function () {
            sortOrder = sortSelect.value;
            renderResults();
        });
        toolbar.appendChild(sortSelect);

        var views = document.createElement('div');
        views.className = 'media-view-switch';
        ['grid', 'list'].forEach(function (view) {
            var button = document.createElement('button');
            button.type = 'button';
            button.setAttribute('aria-label', view === 'grid' ? t('gridView') : t('listView'));
            button.title = view === 'grid' ? t('gridView') : t('listView');
            button.appendChild(icon(view));
            button.addEventListener('click', function () {
                viewMode = view;
                updateViewButtons();
                renderResults();
            });
            viewButtons[view] = button;
            views.appendChild(button);
        });
        toolbar.appendChild(views);
        resultCount = document.createElement('span');
        resultCount.className = 'media-result-count';
        resultCount.setAttribute('aria-live', 'polite');
        toolbar.appendChild(resultCount);
        itemsElement.parentNode.insertBefore(toolbar, itemsElement);
        updateViewButtons();
    }

    function updateViewButtons() {
        Object.keys(viewButtons).forEach(function (view) {
            viewButtons[view].setAttribute('aria-pressed', String(view === viewMode));
        });
    }

    function load(path) {
        clearError();
        setStatus(t('loading'));
        return request('list', {path: path}).then(function (payload) {
            var changedDirectory = currentPath !== payload.data.path;
            currentPath = payload.data.path;
            allItems = payload.data.items;
            if (changedDirectory) {
                searchQuery = '';
                searchInput.value = '';
            }
            renderBreadcrumbs(currentPath);
            renderResults();
        }).catch(function (error) {
            setStatus('');
            showError(error.message);
        });
    }

    document.addEventListener('click', function (event) {
        if (!event.target.closest('.media-controls')) {
            itemsElement.querySelectorAll('details.media-controls[open]').forEach(function (menu) {
                menu.open = false;
            });
        }
    });
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            itemsElement.querySelectorAll('details.media-controls[open]').forEach(function (menu) {
                menu.open = false;
                menu.querySelector('summary').focus();
            });
        }
    });

    createToolbar();

    document.getElementById('refresh-button').addEventListener('click', function () { load(currentPath); });
    var uploadForm = document.getElementById('upload-form');
    if (uploadForm) {
        var selectedFileLabel = document.getElementById('selected-file');
        var uploadInput = document.getElementById('upload-file');
        uploadInput.addEventListener('change', function () {
            selectedFileLabel.textContent = uploadInput.files.length
                ? uploadInput.files[0].name : t('noFile');
        });
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
            setStatus(t('uploading'));
            request('upload', {method: 'POST', body: body}).then(function () {
                uploadForm.reset();
                selectedFileLabel.textContent = t('noFile');
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
            var name = window.prompt(t('folderName'));
            if (name) { mutate('mkdir', {path: currentPath, name: name}); }
        });
    }

    load('');
}());
