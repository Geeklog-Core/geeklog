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
    var imageRevisions = Object.create(null);

    function freshImageUrl(item) {
        var url = new URL(item.url, window.location.href);
        url.searchParams.set('glMediaVersion', imageRevisions[item.path] || String(item.modified || 0));
        return url.toString();
    }

    function thumbnailUrl(item) {
        var url = new URL(settings.apiUrl, window.location.href);
        url.searchParams.set('action', 'thumbnail');
        url.searchParams.set('type', settings.type);
        url.searchParams.set('path', item.path);
        url.searchParams.set('v', imageRevisions[item.path] || item.version || String(item.modified || 0));
        return url.toString();
    }

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

    function openImageEditor(item) {
        var ext = item.name.split('.').pop().toLowerCase();
        var mime = (ext === 'jpg' || ext === 'jpeg') ? 'image/jpeg'
            : (ext === 'png' ? 'image/png' : (ext === 'webp' ? 'image/webp' : ''));
        if (!mime) { showError(t('editUnsupported')); return; }
        var overlay = document.createElement('div');
        overlay.className = 'media-edit-overlay';
        var dialog = document.createElement('section');
        dialog.className = 'media-edit-dialog';
        dialog.setAttribute('role', 'dialog');
        dialog.setAttribute('aria-modal', 'true');
        dialog.setAttribute('aria-label', t('editImage') + ': ' + item.name);
        overlay.appendChild(dialog);
        var header = document.createElement('div');
        header.className = 'media-edit-header';
        var title = document.createElement('strong');
        title.textContent = t('editImage') + ': ' + item.name;
        header.appendChild(title);
        var close = addButton(t('closeEditor'), '', finish);
        header.appendChild(close);
        dialog.appendChild(header);
        var canvas = document.createElement('canvas');
        canvas.className = 'media-edit-preview';
        canvas.setAttribute('aria-label', t('editHelp'));
        var stage = document.createElement('div');
        stage.className = 'media-edit-stage';
        stage.appendChild(canvas);
        var workspace = document.createElement('div');
        workspace.className = 'media-edit-workspace';
        workspace.appendChild(stage);
        var sidebar = document.createElement('aside');
        sidebar.className = 'media-edit-sidebar';
        sidebar.setAttribute('aria-label', t('toolsSection'));
        workspace.appendChild(sidebar);
        dialog.appendChild(workspace);
        var help = document.createElement('p');
        help.className = 'media-edit-help';
        help.textContent = t('editHelp');
        sidebar.appendChild(help);
        var toolbar = document.createElement('div');
        toolbar.className = 'media-edit-toolbar';
        sidebar.appendChild(toolbar);
        function toolGroup(titleText) {
            var group = document.createElement('section');
            group.className = 'media-edit-group';
            var caption = document.createElement('strong');
            caption.className = 'media-edit-group-title';
            caption.textContent = titleText;
            group.appendChild(caption);
            var actions = document.createElement('div');
            actions.className = 'media-edit-group-actions';
            group.appendChild(actions);
            toolbar.appendChild(group);
            return actions;
        }
        var cropTools = toolGroup(t('cropImage'));
        var rotateTools = toolGroup(t('toolsSection'));
        var sourceTools = toolGroup(t('replaceSection'));
        var sizeRow = document.createElement('div');
        sizeRow.className = 'media-edit-size';
        var sizeSection = document.createElement('section');
        sizeSection.className = 'media-edit-group media-edit-dimensions';
        var sizeHeading = document.createElement('strong');
        sizeHeading.className = 'media-edit-group-title';
        sizeHeading.textContent = t('dimensionsSection');
        sizeSection.appendChild(sizeHeading);
        sizeSection.appendChild(sizeRow);
        sidebar.appendChild(sizeSection);
        var error = document.createElement('div');
        error.className = 'media-edit-error';
        error.setAttribute('role', 'alert');
        sidebar.appendChild(error);
        var footer = document.createElement('div');
        footer.className = 'media-edit-footer';
        sidebar.appendChild(footer);
        var original = null;
        var working = null;
        var starting = null;
        var selection = null;
        var dragMode = 'create';
        var dragOrigin = null;
        var initialSelection = null;
        var ratio = 0;
        var busy = false;
        var previousFocus = document.activeElement;
        var widthInput = document.createElement('input');
        var heightInput = document.createElement('input');
        [widthInput, heightInput].forEach(function (input) {
            input.type = 'number'; input.min = '1'; input.max = '10000'; input.step = '1';
        });
        var locked = document.createElement('input');
        locked.type = 'checkbox';
        locked.checked = true;
        function field(text, input) {
            var label = document.createElement('label');
            label.textContent = text + ' ';
            label.appendChild(input);
            return label;
        }
        sizeRow.appendChild(field(t('width'), widthInput));
        sizeRow.appendChild(field(t('height'), heightInput));
        sizeRow.appendChild(field(t('lockRatio'), locked));
        function fail(message) { error.textContent = message; }
        function valid(w, h) {
            return Number.isInteger(w) && Number.isInteger(h) && w > 0 && h > 0
                && w <= 10000 && h <= 10000 && w * h <= 24000000;
        }
        function resized(source, w, h) {
            if (!valid(w, h)) { throw new Error(t('dimensionsInvalid')); }
            var next = document.createElement('canvas');
            next.width = w; next.height = h;
            next.getContext('2d').drawImage(source, 0, 0, w, h);
            return next;
        }
        function refresh() {
            if (!working) { return; }
            canvas.width = working.width; canvas.height = working.height;
            var ctx = canvas.getContext('2d');
            ctx.drawImage(working, 0, 0);
            if (selection) {
                var x = Math.min(selection.x1, selection.x2);
                var y = Math.min(selection.y1, selection.y2);
                var w = Math.abs(selection.x2 - selection.x1);
                var h = Math.abs(selection.y2 - selection.y1);
                if (w > 1 && h > 1) {
                    // Darken the unselected region while keeping the crop rectangle clear.
                    ctx.fillStyle = 'rgba(8, 20, 36, 0.62)';
                    ctx.fillRect(0, 0, canvas.width, canvas.height);
                    ctx.drawImage(working, x, y, w, h, x, y, w, h);
                    var line = Math.max(2, canvas.width / Math.max(1, canvas.clientWidth) * 2.5);
                    ctx.setLineDash([]);
                    ctx.lineWidth = line + 2;
                    ctx.strokeStyle = '#ffffff';
                    ctx.strokeRect(x, y, w, h);
                    ctx.lineWidth = line;
                    ctx.strokeStyle = '#087dea';
                    ctx.strokeRect(x, y, w, h);
                    var handle = line * 2.5;
                    [[x, y], [x + w, y], [x, y + h], [x + w, y + h]].forEach(function (corner) {
                        ctx.fillStyle = '#fff';
                        ctx.fillRect(corner[0] - handle / 2, corner[1] - handle / 2, handle, handle);
                        ctx.strokeStyle = '#087dea';
                        ctx.lineWidth = line / 2;
                        ctx.strokeRect(corner[0] - handle / 2, corner[1] - handle / 2, handle, handle);
                    });
                }
            }
            widthInput.value = String(working.width);
            heightInput.value = String(working.height);
        }
        function normalizedSelection() {
            if (!selection) { return null; }
            var x = Math.min(selection.x1, selection.x2);
            var y = Math.min(selection.y1, selection.y2);
            return {x: x, y: y, w: Math.abs(selection.x2 - selection.x1),
                h: Math.abs(selection.y2 - selection.y1)};
        }
        function within(p, rect) {
            return p.x >= rect.x && p.x <= rect.x + rect.w
                && p.y >= rect.y && p.y <= rect.y + rect.h;
        }
        function cornerAt(p, rect) {
            if (!rect || rect.w < 2 || rect.h < 2) { return null; }
            var tolerance = Math.max(12, Math.round(canvas.width * 14 / Math.max(1, canvas.clientWidth)));
            var corners = [
                {id: 'nw', x: rect.x, y: rect.y},
                {id: 'ne', x: rect.x + rect.w, y: rect.y},
                {id: 'sw', x: rect.x, y: rect.y + rect.h},
                {id: 'se', x: rect.x + rect.w, y: rect.y + rect.h}
            ];
            for (var i = 0; i < corners.length; i++) {
                if (Math.hypot(p.x - corners[i].x, p.y - corners[i].y) <= tolerance) {
                    return corners[i].id;
                }
            }
            return null;
        }
        function selectionFromDrag(anchor, pointer) {
            var dx = pointer.x - anchor.x, dy = pointer.y - anchor.y;
            if (ratio > 0) {
                // Follow the stronger pointer movement to permit vertical or horizontal drags.
                var w = Math.max(Math.abs(dx), Math.abs(dy) * ratio);
                var h = w / ratio;
                var limitX = dx >= 0 ? working.width - anchor.x : anchor.x;
                var limitY = dy >= 0 ? working.height - anchor.y : anchor.y;
                w = Math.min(w, limitX, limitY * ratio);
                h = w / ratio;
                dx = (dx < 0 ? -1 : 1) * w;
                dy = (dy < 0 ? -1 : 1) * h;
            }
            return {x1: anchor.x, y1: anchor.y,
                x2: Math.max(0, Math.min(working.width, Math.round(anchor.x + dx))),
                y2: Math.max(0, Math.min(working.height, Math.round(anchor.y + dy)))};
        }
        function updateSelection(pointer) {
            if (!starting) { return; }
            if (dragMode === 'move' && initialSelection) {
                var rect = initialSelection;
                var dx = pointer.x - dragOrigin.x, dy = pointer.y - dragOrigin.y;
                var x = Math.max(0, Math.min(working.width - rect.w, rect.x + dx));
                var y = Math.max(0, Math.min(working.height - rect.h, rect.y + dy));
                selection = {x1: x, y1: y, x2: x + rect.w, y2: y + rect.h};
            } else {
                selection = selectionFromDrag(starting, pointer);
            }
            refresh();
        }
        function setWorking(source) {
            if (!valid(source.width, source.height)) { throw new Error(t('dimensionsInvalid')); }
            working = resized(source, source.width, source.height);
            selection = null;
            refresh();
        }
        function loadImage(url, callback) {
            var image = new Image();
            image.onload = function () {
                try {
                    if (!valid(image.naturalWidth, image.naturalHeight)) {
                        throw new Error(t('dimensionsInvalid'));
                    }
                    var source = resized(image, image.naturalWidth, image.naturalHeight);
                    callback(source);
                    fail('');
                } catch (e) { fail(e.message); }
            };
            image.onerror = function () { fail(t('imageLoadFailed')); };
            image.src = url;
        }
        function point(event) {
            var bounds = canvas.getBoundingClientRect();
            return {
                x: Math.max(0, Math.min(canvas.width, Math.round((event.clientX - bounds.left) * canvas.width / bounds.width))),
                y: Math.max(0, Math.min(canvas.height, Math.round((event.clientY - bounds.top) * canvas.height / bounds.height)))
            };
        }
        canvas.addEventListener('pointerdown', function (event) {
            if (!working || busy || event.button !== 0) { return; }
            event.preventDefault();
            var p = point(event);
            var rect = normalizedSelection();
            var corner = cornerAt(p, rect);
            dragOrigin = p;
            initialSelection = rect;
            if (corner) {
                dragMode = 'resize';
                var oppositeX = corner.indexOf('w') >= 0 ? rect.x + rect.w : rect.x;
                var oppositeY = corner.indexOf('n') >= 0 ? rect.y + rect.h : rect.y;
                starting = {x: oppositeX, y: oppositeY};
            } else if (rect && within(p, rect)) {
                dragMode = 'move';
                starting = p;
            } else {
                dragMode = 'create';
                starting = p;
                selection = selectionFromDrag(p, p);
            }
            canvas.setPointerCapture(event.pointerId);
            canvas.style.cursor = dragMode === 'move' ? 'grabbing'
                : (dragMode === 'resize' ? 'nwse-resize' : 'crosshair');
            refresh();
        });
        canvas.addEventListener('pointermove', function (event) {
            if (!working) { return; }
            var p = point(event);
            if (starting) {
                updateSelection(p);
                return;
            }
            var rect = normalizedSelection();
            var corner = cornerAt(p, rect);
            if (corner) {
                canvas.style.cursor = (corner === 'nw' || corner === 'se')
                    ? 'nwse-resize' : 'nesw-resize';
            } else {
                canvas.style.cursor = rect && within(p, rect) ? 'move' : 'crosshair';
            }
        });
        canvas.addEventListener('pointerup', function (event) {
            if (starting && working) { updateSelection(point(event)); }
            starting = null;
            canvas.style.cursor = 'crosshair';
        });
        canvas.addEventListener('pointercancel', function () {
            canvas.style.cursor = 'crosshair';
            starting = null;
            selection = null;
            refresh();
        });
        var ratioLabel = document.createElement('label');
        ratioLabel.textContent = t('cropRatio') + ' ';
        var ratioSelect = document.createElement('select');
        ratioSelect.className = 'media-edit-ratio';
        [['0', t('ratioFree')], ['1', '1:1'], ['1.333333333', '4:3'],
            ['1.777777778', '16:9']].forEach(function (option) {
            var node = document.createElement('option');
            node.value = option[0];
            node.textContent = option[1];
            ratioSelect.appendChild(node);
        });
        ratioSelect.addEventListener('change', function () {
            ratio = Number(ratioSelect.value);
            selection = null;
            refresh();
        });
        ratioLabel.appendChild(ratioSelect);
        cropTools.appendChild(ratioLabel);
        cropTools.appendChild(addButton(t('cropImage'), '', function () {
            if (!working || !selection) { return; }
            var x = Math.min(selection.x1, selection.x2), y = Math.min(selection.y1, selection.y2);
            var w = Math.abs(selection.x2 - selection.x1), h = Math.abs(selection.y2 - selection.y1);
            if (w < 2 || h < 2) { return; }
            var next = document.createElement('canvas');
            next.width = w; next.height = h;
            next.getContext('2d').drawImage(working, x, y, w, h, 0, 0, w, h);
            working = next; selection = null; refresh();
        }));
        function rotate(clockwise) {
            if (!working) { return; }
            var next = document.createElement('canvas');
            next.width = working.height; next.height = working.width;
            var ctx = next.getContext('2d');
            ctx.translate(clockwise ? next.width : 0, clockwise ? 0 : next.height);
            ctx.rotate(clockwise ? Math.PI / 2 : -Math.PI / 2);
            ctx.drawImage(working, 0, 0);
            working = next; selection = null; refresh();
        }
        rotateTools.appendChild(addButton(t('rotateLeft'), '', function () { rotate(false); }));
        rotateTools.appendChild(addButton(t('rotateRight'), '', function () { rotate(true); }));
        [widthInput, heightInput].forEach(function (input) {
            input.addEventListener('change', function () {
                if (!working) { return; }
                var w = Number(widthInput.value), h = Number(heightInput.value);
                if (locked.checked) {
                    if (input === widthInput) { h = Math.round(working.height * w / working.width); }
                    else { w = Math.round(working.width * h / working.height); }
                }
                if (!valid(w, h)) { fail(t('dimensionsInvalid')); refresh(); return; }
                widthInput.value = String(w); heightInput.value = String(h);
            });
        });
        sizeRow.appendChild(addButton(t('resizeImage'), '', function () {
            if (!working) { return; }
            var w = Number(widthInput.value), h = Number(heightInput.value);
            if (!valid(w, h)) { fail(t('dimensionsInvalid')); return; }
            working = resized(working, w, h); selection = null; refresh(); fail('');
        }));
        rotateTools.appendChild(addButton(t('resetImage'), '', function () {
            if (original) { setWorking(original); fail(''); }
        }));
        var replacement = document.createElement('input');
        replacement.type = 'file';
        replacement.accept = 'image/jpeg,image/png,image/webp';
        replacement.className = 'media-edit-file';
        var replacementLabel = document.createElement('label');
        replacementLabel.className = 'media-edit-replace-button';
        replacementLabel.setAttribute('role', 'button');
        replacementLabel.setAttribute('tabindex', '0');
        replacementLabel.textContent = t('replaceImage');
        replacementLabel.appendChild(replacement);
        replacementLabel.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                replacement.click();
            }
        });
        sourceTools.appendChild(replacementLabel);
        var replacementName = document.createElement('span');
        replacementName.className = 'media-edit-replace-name';
        sourceTools.appendChild(replacementName);
        replacement.addEventListener('change', function () {
            if (!replacement.files.length) { return; }
            var file = replacement.files[0];
            replacementName.textContent = t('replacementSelected', {name: file.name});
            if (['image/jpeg', 'image/png', 'image/webp'].indexOf(file.type) < 0) {
                fail(t('editUnsupported')); return;
            }
            var url = URL.createObjectURL(file);
            loadImage(url, function (source) {
                original = source;
                setWorking(original);
                URL.revokeObjectURL(url);
            });
        });
        function save(copy) {
            if (!working || busy) { return; }
            if (!copy && !window.confirm(t('editConfirm'))) { return; }
            busy = true; fail('');
            working.toBlob(function (blob) {
                if (!blob) { busy = false; fail(t('requestFailed')); return; }
                var body = new FormData();
                body.set('path', item.path);
                body.set('save_copy', copy ? '1' : '0');
                body.set('image', blob, item.name);
                request('edit_image', {method: 'POST', body: body}).then(function () {
                    imageRevisions[item.path] = String(Date.now());
                    busy = false;
                    finish();
                    return load(currentPath);
                }).then(function () { setStatus(t('imageSaved')); })
                  .catch(function (e) { busy = false; fail(e.message); });
            }, mime, mime === 'image/jpeg' ? 0.9 : 0.92);
        }
        var warning = document.createElement('p');
        warning.className = 'media-edit-warning';
        warning.textContent = t('replaceWarning');
        footer.appendChild(warning);
        footer.appendChild(addButton(t('saveCopy'), '', function () { save(true); }));
        footer.appendChild(addButton(t('saveOriginal'), 'media-edit-primary', function () { save(false); }));
        function finish() {
            if (busy) { return; }
            document.removeEventListener('keydown', onKey);
            overlay.remove();
            if (previousFocus && previousFocus.isConnected) { previousFocus.focus(); }
        }
        function onKey(event) {
            if (event.key === 'Escape' && !busy) { event.stopPropagation(); finish(); }
        }
        document.addEventListener('keydown', onKey);
        document.body.appendChild(overlay);
        close.focus();
        loadImage(freshImageUrl(item) + '&mediaEdit=' + Date.now(), function (source) {
            original = source;
            setWorking(source);
        });
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
                image.src = thumbnailUrl(item);
                image.alt = '';
                image.loading = 'lazy';
                function showFallbackIcon() {
                    image.remove();
                    if (!preview.querySelector('svg')) {
                        preview.appendChild(icon('file'));
                    }
                }
                // Valid 1x1 transparent placeholders do not trigger an error.
                // Treat them like missing previews, without changing the file itself.
                image.addEventListener('load', function () {
                    if (image.naturalWidth <= 1 && image.naturalHeight <= 1) {
                        showFallbackIcon();
                    }
                }, {once: true});
                image.addEventListener('error', showFallbackIcon, {once: true});
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
            if (item.kind === 'file' && /\.(jpe?g|png|webp)$/i.test(item.name)) {
                menu.appendChild(addButton(t('editImage'), '', function () {
                    controls.open = false;
                    openImageEditor(item);
                }));
            }
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
