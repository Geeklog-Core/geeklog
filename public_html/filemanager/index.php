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
$mediaLanguage = strtolower(substr((string) COM_getLangIso639Code(), 0, 2));
$mediaStrings = [
    'en' => [
        'title' => 'Media Library', 'selectImage' => 'Select an image', 'selectFile' => 'Select a file',
        'manageMedia' => 'Manage your media files', 'backToAdmin' => 'Back to administration',
        'editImage' => 'Edit image', 'replaceImage' => 'Replace image', 'cropImage' => 'Crop selection',
        'rotateLeft' => 'Rotate left', 'rotateRight' => 'Rotate right', 'resizeImage' => 'Resize',
        'width' => 'Width', 'height' => 'Height', 'lockRatio' => 'Keep proportions',
        'resetImage' => 'Reset', 'saveOriginal' => 'Replace original', 'saveCopy' => 'Save a copy',
        'closeEditor' => 'Close', 'imageSaved' => 'Image saved.',
        'editHelp' => 'Drag to crop. Move the selection or resize it using its corners.',
        'cropRatio' => 'Crop ratio', 'ratioFree' => 'Free', 'replaceSection' => 'Source image',
        'toolsSection' => 'Transform', 'dimensionsSection' => 'Dimensions',
        'replaceWarning' => 'Replacing the original updates every article using this image URL. Cached copies may take time to refresh.',
        'replacementSelected' => 'Selected: {name}',
        'editConfirm' => 'Replace the original image? Existing articles will use the new image.',
        'editUnsupported' => 'Image editing is available for JPEG, PNG and WebP only.',
        'imageLoadFailed' => 'Unable to load the image for editing.',
        'dimensionsInvalid' => 'Image dimensions must be between 1 and 10000 pixels (24 megapixels maximum).',
        'refresh' => 'Refresh', 'currentFolder' => 'Current folder', 'fileOperations' => 'File operations',
        'chooseFile' => 'Choose file', 'noFile' => 'No file selected', 'upload' => 'Upload',
        'newFolder' => 'New folder', 'filesLabel' => 'Media files',
        'mediaRoot' => 'Media', 'folder' => 'Folder', 'folders' => 'Folders', 'files' => 'Files',
        'open' => 'Open', 'select' => 'Select', 'actionsFor' => 'Actions for',
        'rename' => 'Rename', 'delete' => 'Delete', 'newName' => 'New name',
        'confirmDelete' => 'Delete "{name}"?', 'loading' => 'Loading...', 'working' => 'Working...',
        'uploading' => 'Uploading...', 'empty' => 'This folder is empty.',
        'noMatches' => 'No matching files or folders.', 'itemCount' => '{count} items',
        'searchPlaceholder' => 'Search this folder', 'searchLabel' => 'Search files and folders in the current directory',
        'sortLabel' => 'Sort files and folders', 'sortNameAsc' => 'Name A–Z',
        'sortNameDesc' => 'Name Z–A', 'sortSizeDesc' => 'Largest first',
        'sortSizeAsc' => 'Smallest first', 'gridView' => 'Grid view', 'listView' => 'List view',
        'folderName' => 'Folder name',
        'invalidFile' => 'This file type is not allowed. Allowed extensions: {extensions}.',
        'invalidResponse' => 'The server returned invalid JSON (HTTP {status}, {type}).',
        'unknownContent' => 'unknown content type', 'requestFailed' => 'The request failed.',
        'timeout' => 'The server did not answer within 30 seconds. The upload may have been blocked upstream.',
    ],
    'fr' => [
        'title' => 'Bibliothèque média', 'selectImage' => 'Sélectionner une image', 'selectFile' => 'Sélectionner un fichier',
        'manageMedia' => 'Gérer les fichiers médias', 'backToAdmin' => 'Retour à l’administration',
        'editImage' => 'Modifier l’image', 'replaceImage' => 'Remplacer l’image', 'cropImage' => 'Recadrer la sélection',
        'rotateLeft' => 'Pivoter à gauche', 'rotateRight' => 'Pivoter à droite', 'resizeImage' => 'Redimensionner',
        'width' => 'Largeur', 'height' => 'Hauteur', 'lockRatio' => 'Conserver les proportions',
        'resetImage' => 'Réinitialiser', 'saveOriginal' => 'Remplacer l’original', 'saveCopy' => 'Enregistrer une copie',
        'closeEditor' => 'Fermer', 'imageSaved' => 'Image enregistrée.',
        'editHelp' => 'Tracez une sélection, déplacez-la ou redimensionnez-la avec les coins.',
        'cropRatio' => 'Proportions du recadrage', 'ratioFree' => 'Libre', 'replaceSection' => 'Image source',
        'toolsSection' => 'Transformations', 'dimensionsSection' => 'Dimensions',
        'replaceWarning' => 'Remplacer l’original modifie tous les articles utilisant cette URL. Le cache peut retarder l’affichage.',
        'replacementSelected' => 'Sélection : {name}',
        'editConfirm' => 'Remplacer l’image originale ? Les articles existants utiliseront la nouvelle image.',
        'editUnsupported' => 'Seules les images JPEG, PNG et WebP peuvent être modifiées.',
        'imageLoadFailed' => 'Impossible de charger l’image pour modification.',
        'dimensionsInvalid' => 'Dimensions comprises entre 1 et 10000 pixels (24 mégapixels maximum).',
        'refresh' => 'Actualiser', 'currentFolder' => 'Dossier actuel', 'fileOperations' => 'Gestion des fichiers',
        'chooseFile' => 'Choisir un fichier', 'noFile' => 'Aucun fichier sélectionné', 'upload' => 'Envoyer',
        'newFolder' => 'Nouveau dossier', 'filesLabel' => 'Fichiers média',
        'mediaRoot' => 'Médias', 'folder' => 'Dossier', 'folders' => 'Dossiers', 'files' => 'Fichiers',
        'open' => 'Ouvrir', 'select' => 'Sélectionner', 'actionsFor' => 'Actions pour',
        'rename' => 'Renommer', 'delete' => 'Supprimer', 'newName' => 'Nouveau nom',
        'confirmDelete' => 'Supprimer « {name} » ?', 'loading' => 'Chargement...', 'working' => 'Traitement...',
        'uploading' => 'Envoi...', 'empty' => 'Ce dossier est vide.',
        'noMatches' => 'Aucun fichier ou dossier correspondant.', 'itemCount' => '{count} éléments',
        'searchPlaceholder' => 'Rechercher dans ce dossier', 'searchLabel' => 'Rechercher des fichiers et dossiers',
        'sortLabel' => 'Trier les fichiers et dossiers', 'sortNameAsc' => 'Nom A–Z',
        'sortNameDesc' => 'Nom Z–A', 'sortSizeDesc' => 'Plus grands d’abord',
        'sortSizeAsc' => 'Plus petits d’abord', 'gridView' => 'Vue grille', 'listView' => 'Vue liste',
        'folderName' => 'Nom du dossier',
        'invalidFile' => 'Type de fichier interdit. Extensions autorisées : {extensions}.',
        'invalidResponse' => 'Le serveur a renvoyé un JSON invalide (HTTP {status}, {type}).',
        'unknownContent' => 'type de contenu inconnu', 'requestFailed' => 'Échec de la requête.',
        'timeout' => 'Le serveur n’a pas répondu en 30 secondes. L’envoi a peut-être été bloqué.',
    ],
];
$mediaLabels = $mediaStrings[isset($mediaStrings[$mediaLanguage]) ? $mediaLanguage : 'en'];
$settings = [
    'labels' => $mediaLabels,
    'apiUrl' => $_CONF['site_url'] . '/filemanager/api.php',
    'type' => $type,
    'csrfName' => CSRF_TOKEN,
    'csrfToken' => $csrfToken,
    'browseOnly' => !$mediaLibrary->canWrite(),
    'canManage' => $mediaLibrary->canManage(),
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
    <title><?php echo htmlspecialchars($mediaLabels['title'], ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="assets/media-library.css?v=<?php echo (int) @filemtime(__DIR__ . '/assets/media-library.css'); ?>">
</head>
<body>
<main class="media-library" aria-labelledby="media-title">
    <header class="media-header">
        <div>
            <h1 id="media-title"><?php echo htmlspecialchars($mediaLabels['title'], ENT_QUOTES, 'UTF-8'); ?></h1>
            <p id="media-context"><?php echo htmlspecialchars($mediaLabels[$type === 'Root' ? 'manageMedia' : ($type === 'Image' ? 'selectImage' : 'selectFile')], ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
        <div class="media-header-actions">
            <?php if ($type === 'Root'
                && !isset($_GET['CKEditorFuncNum'])
                && !isset($_GET['CKEditor'])
                && (SEC_inGroup('Root') || SEC_hasRights('filemanager.admin'))) : ?>
            <a href="<?php echo htmlspecialchars($_CONF['site_admin_url'] . '/index.php', ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($mediaLabels['backToAdmin'], ENT_QUOTES, 'UTF-8'); ?></a>
            <?php endif; ?>
            <button id="refresh-button" type="button"><?php echo htmlspecialchars($mediaLabels['refresh'], ENT_QUOTES, 'UTF-8'); ?></button>
        </div>
    </header>

    <nav id="breadcrumbs" class="breadcrumbs" aria-label="<?php echo htmlspecialchars($mediaLabels['currentFolder'], ENT_QUOTES, 'UTF-8'); ?>"></nav>

    <?php if ($mediaLibrary->canWrite()) : ?>
    <section class="media-actions" aria-label="<?php echo htmlspecialchars($mediaLabels['fileOperations'], ENT_QUOTES, 'UTF-8'); ?>">
        <form id="upload-form" enctype="multipart/form-data">
            <label class="file-picker" for="upload-file"><span class="file-picker-label"><?php echo htmlspecialchars($mediaLabels['chooseFile'], ENT_QUOTES, 'UTF-8'); ?></span><input id="upload-file" name="upload" type="file" required aria-label="<?php echo htmlspecialchars($mediaLabels['chooseFile'], ENT_QUOTES, 'UTF-8'); ?>"><span id="selected-file" class="selected-file" aria-live="polite"><?php echo htmlspecialchars($mediaLabels['noFile'], ENT_QUOTES, 'UTF-8'); ?></span></label>
            <button type="submit"><?php echo htmlspecialchars($mediaLabels['upload'], ENT_QUOTES, 'UTF-8'); ?></button>
        </form>
        <?php if ($mediaLibrary->canCreateDirectory()) : ?>
        <button id="mkdir-button" type="button"><?php echo htmlspecialchars($mediaLabels['newFolder'], ENT_QUOTES, 'UTF-8'); ?></button>
        <?php endif; ?>
    </section>
    <?php endif; ?>

    <div id="status" class="status" role="status" aria-live="polite"></div>
    <div id="error" class="error" role="alert" hidden></div>
    <section id="items" class="media-results" aria-label="<?php echo htmlspecialchars($mediaLabels['filesLabel'], ENT_QUOTES, 'UTF-8'); ?>"></section>
</main>

<script id="media-settings" type="application/json"><?php
echo json_encode($settings, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
?></script>
<script src="assets/media-library.js?v=<?php echo (int) @filemtime(__DIR__ . '/assets/media-library.js'); ?>"></script>
</body>
</html>
