# Geeklog 2.2.2 — Native Media Library preview 1 (admins only)

This is an **experimental compatibility package**, not a Geeklog core release. It can remain installed on a Geeklog 2.2.2 site until the official Geeklog 2.2.3 upgrade, provided the site's administrator accepts the preview risk. It installs
only the native Media Library and the required PHP classes. It does not edit
`lib-common.php`, the database, the Geeklog installer, themes or story records.

## Compatibility

- Geeklog **2.2.2** (verify the version before installing).
- PHP **5.6.4 or newer** with GD/PNG and Fileinfo. PHP 5.6 code compatibility is
  targeted, but **full functional tests under PHP 5.6 still need to be run**.
- PHP GD with WebP support is optional: thumbnails use WebP if available and PNG
  otherwise. Existing WebP source processing depends on server GD capabilities.
- JavaScript browser APIs require a reasonably recent browser.
- **Administrators only:** non-admin story editors are deliberately not enabled
  by this package. Admin privileges are verified in PHP on every request.

> PHP 5.6 is end-of-life and has known security risks. Prefer a supported PHP version; if a legacy site must remain on 5.6, use a protected staging clone for initial validation before any production decision. This preview does not mitigate vulnerabilities in unsupported PHP versions.

## Prepare the ZIP (for the maintainer)

From the repository root checked out at `native-media-library-pr`:

```bash
python3 testing/native-media-library-2.2.2/build-preview.py
```

The builder packages just nine runtime files, `install.sh`, `rollback.sh`
and this README. It patches `MediaLibrary.php` **inside the ZIP only** to
remove editor access. It does not alter the PR branch's normal editor support.

## Test installation

1. Back up your site and database independently.
2. Extract the generated ZIP outside the web root.
3. Find the real Geeklog public directory and system directory.
4. Run preflight; no file is changed:

```bash
cd geeklog-2.2.2-native-media-library-preview-1
bash install.sh --check /absolute/path/to/public_html /absolute/path/to/system
```

5. Verify site version and web-facing PHP version, not just CLI. Then install:

```bash
bash install.sh --install /absolute/path/to/public_html /absolute/path/to/system
```

The installer backs up only files it replaces or removes, and existing
`system/classes/Media` classes. It deletes **obsolete executable Filemanager
endpoints** but never deletes media files in `images` or `userfiles`.

The command prints its backup path. Keep it. It also copies `rollback.sh`
into the backup directory so you can restore without retaining the ZIP.

## Running this preview until Geeklog 2.2.3

This package does not create a separate media database or a new media location.
Uploaded images and folders continue to reside in the existing Geeklog media
directories. Cached thumbnails are disposable, not the source files.

- **Keep the installer backup** until the official upgrade has been verified.
- Continue normal backups of the Geeklog database and actual media directories.
- Do not remove user-uploaded files or Geeklog's existing `_thumbs` folders.
- When Geeklog **2.2.3** is officially released, use the normal Geeklog
  upgrade process; **do not run the preview rollback first**, since that would
  restore obsolete Filemanager code before the upgrade.
- Check that the released version includes PR #1173 or an equivalent native
  media implementation before upgrading. If the official integration differs,
  review the release notes/migration instructions rather than assuming it is identical.
- After upgrading, verify old image URLs, edited copies, the library, the editor
  and permissions. Once everything works, archive or remove the backup.
- The preview is admin-only. The future official release can enable authorized
  editors without changing the stored media.

If a site elects to use this on production, first verify the live site's PHP
version, upload limits, permission model and restore procedure on a clone.

## Roll back

```bash
bash /path/to/geeklog-media-preview-backups/BACKUP/rollback.sh /path/to/geeklog-media-preview-backups/BACKUP
```

Type `RESTORE` when prompted. This restores only the files affected by the
preview, leaving images uploaded during tests intact. Previously removed old
Filemanager endpoints are restored from the backup.

## Manual test plan

1. Log in as an administrator and open `/filemanager/index.php?Type=Root`.
2. Confirm a non-admin account cannot access `index.php` or `api.php`.
3. List and create directories, and confirm `_thumbs` is not accessible.
4. Upload a small JPEG/PNG, check previews and private thumbnail cache.
5. Crop/rotate/resize, save a copy and replace the original.
6. Select an image through CKEditor on the admin article form.
7. Verify image display on existing articles; verify rollback.
8. If testing on PHP 5.6, report separately whether WebP support exists
   and whether upload/thumbnail/edit functions succeed.

## Report issues

Please report results with Geeklog version, PHP web version, operating system,
browser, reproduction steps and the exact PHP error log entry (without private
data): https://github.com/Geeklog-Core/geeklog/pull/1173
