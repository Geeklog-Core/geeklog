<?php

/* Native Geeklog Media Library compatibility entry point. */

global $_USER;

require_once dirname(__DIR__) . '/lib-common.php';
require_once $_CONF['path_system'] . 'classes/Media/MediaValidator.php';
require_once $_CONF['path_system'] . 'classes/Media/MediaStorage.php';
require_once $_CONF['path_system'] . 'classes/Media/MediaLibrary.php';

use Geeklog\Media\MediaLibrary;

try {
    $mediaLibrary = MediaLibrary::fromGeeklog();
} catch (RuntimeException $e) {
    COM_accessLog("User {$_USER['username']} was denied access to the Media Library.");
    $content = COM_showMessageText($e->getMessage(), $LANG_ACCESS['accessdenied']);
    COM_output(COM_createHTMLDocument($content, ['pagetitle' => $LANG_ACCESS['accessdenied']]));
    exit;
}

$type = isset($_GET['Type']) ? ucfirst(strtolower((string) $_GET['Type'])) : 'File';
if (!in_array($type, ['Image', 'File', 'Media', 'Root'], true)) {
    $type = 'File';
}
$csrfToken = SEC_createToken();
$uploadExtensions = $type === 'Image'
    ? (array) $_CONF['filemanager_images_ext']
    : array_merge(
        (array) $_CONF['filemanager_images_ext'],
        (array) $_CONF['filemanager_videos_ext'],
        (array) $_CONF['filemanager_audios_ext']
    );
$uploadExtensions = array_values(array_unique(array_filter(array_map(function ($extension) {
    $extension = strtolower(ltrim(trim((string) $extension), '.'));
    // SVG browsing remains compatible, but uploads require a sanitizer and are
    // rejected by the server-side validator.
    return $extension === 'svg' ? '' : $extension;
}, $uploadExtensions))));
$settings = [
    'apiUrl' => $_CONF['site_url'] . '/filemanager/api.php',
    'type' => $type,
    'csrfName' => CSRF_TOKEN,
    'csrfToken' => $csrfToken,
    'browseOnly' => !$mediaLibrary->canWrite(),
    'canCreateDirectory' => $mediaLibrary->canCreateDirectory(),
    'confirmChanges' => !empty($_CONF['filemanager_show_confirmation']),
    'showThumbnails' => !empty($_CONF['filemanager_show_thumbs']),
    'uploadExtensions' => $uploadExtensions,
];

header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
header('Content-Type: text/html; charset=utf-8');
header("Content-Security-Policy: default-src 'self'; img-src 'self' data:; style-src 'self'; script-src 'self'; object-src 'none'; base-uri 'none'; frame-ancestors 'self'");
?>
<!doctype html>
<html lang="<?php echo htmlspecialchars(COM_getLangIso639Code(), ENT_QUOTES, 'UTF-8'); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Geeklog Media Library</title>
    <link rel="stylesheet" href="assets/media-library.css?v=<?php echo (int) @filemtime(__DIR__ . '/assets/media-library.css'); ?>">
</head>
<body>
<main class="media-library" aria-labelledby="media-title">
    <header class="media-header">
        <div>
            <h1 id="media-title">Media Library</h1>
            <p id="media-context"><?php echo $type === 'Image' ? 'Select an image' : 'Select a file'; ?></p>
        </div>
        <button id="refresh-button" type="button">Refresh</button>
    </header>

    <nav id="breadcrumbs" class="breadcrumbs" aria-label="Current folder"></nav>

    <?php if ($mediaLibrary->canWrite()) : ?>
    <section class="media-actions" aria-label="File operations">
        <form id="upload-form" enctype="multipart/form-data">
            <label class="file-picker">Choose file<input id="upload-file" name="upload" type="file" required></label>
            <button type="submit">Upload</button>
        </form>
        <?php if ($mediaLibrary->canCreateDirectory()) : ?>
        <button id="mkdir-button" type="button">New folder</button>
        <?php endif; ?>
    </section>
    <?php endif; ?>

    <div id="status" class="status" role="status" aria-live="polite"></div>
    <div id="error" class="error" role="alert" hidden></div>
    <section id="items" class="media-grid" aria-label="Media files"></section>
</main>

<script id="media-settings" type="application/json"><?php
echo json_encode($settings, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
?></script>
<script src="assets/media-library.js?v=<?php echo (int) @filemtime(__DIR__ . '/assets/media-library.js'); ?>"></script>
</body>
</html>
