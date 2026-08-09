<?php

namespace Geeklog\Media;

/**
 * Resolves Geeklog permissions, storage roots, and Media Library policy.
 */
class MediaLibrary
{
    private $admin;
    private $storage;

    public static function fromGeeklog()
    {
        global $_CONF, $_CONF_FCK;

        if (!empty($_CONF['filemanager_disabled']) || COM_isDemoMode()) {
            throw new \RuntimeException('The Media Library is unavailable.');
        }

        $admin = SEC_inGroup('Root') || SEC_inGroup('Filemanager Admin')
            || SEC_hasRights('filemanager.admin');
        $editor = SEC_hasRights('story.edit') || SEC_hasRights('story.submit');
        if (!$admin && !$editor) {
            throw new \RuntimeException('You are not authorized to use the Media Library.');
        }

        if ($admin) {
            $root = $_CONF['path_images'];
        } elseif (isset($_CONF_FCK['imgl'])) {
            $root = $_CONF['path_html'] . trim($_CONF_FCK['imgl'], '/\\') . '/';
        } elseif (isset($_CONF_FCK['imagelibrary'])) {
            $root = $_CONF['path_html'] . trim($_CONF_FCK['imagelibrary'], '/\\') . '/';
        } else {
            $root = $_CONF['path_html'] . 'images/library/';
        }

        $rootReal = realpath($root);
        $htmlReal = realpath($_CONF['path_html']);
        if ($rootReal === false || $htmlReal === false) {
            throw new \RuntimeException('The media directory is unavailable.');
        }
        $htmlPrefix = rtrim($htmlReal, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $rootComparable = rtrim($rootReal, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $inside = DIRECTORY_SEPARATOR === '\\'
            ? stripos($rootComparable, $htmlPrefix) === 0
            : strpos($rootComparable, $htmlPrefix) === 0;
        if (!$inside) {
            throw new \RuntimeException('The configured media directory is not publicly accessible.');
        }
        $relativeRoot = str_replace(DIRECTORY_SEPARATOR, '/', substr($rootComparable, strlen($htmlPrefix)));
        $baseUrl = rtrim($_CONF['site_url'], '/') . '/' . trim($relativeRoot, '/');

        $validator = new MediaValidator(
            (array) $_CONF['filemanager_images_ext'],
            (array) $_CONF['filemanager_videos_ext'],
            (array) $_CONF['filemanager_audios_ext']
        );
        $limitBytes = (int) $_CONF['filemanager_upload_file_size_limit'] * 1024 * 1024;
        $storage = new MediaStorage(
            $rootReal,
            $baseUrl,
            $validator,
            $limitBytes,
            !empty($_CONF['filemanager_upload_overwrite'])
        );

        return new self($admin, $storage);
    }

    public function __construct($admin, MediaStorage $storage)
    {
        $this->admin = (bool) $admin;
        $this->storage = $storage;
    }

    public function isAdmin()
    {
        return $this->admin;
    }

    public function canWrite()
    {
        global $_CONF;
        return empty($_CONF['filemanager_browse_only']);
    }

    public function canCreateDirectory()
    {
        return $this->canWrite() && $this->admin;
    }

    public function storage()
    {
        return $this->storage;
    }
}
