# Geeklog 2.2.2 — Native Media Library Preview 1

**Community preview · not an official Geeklog release · administrators only**

Download the attached **`geeklog-2.2.2-native-media-library-preview-1.zip`**, not GitHub's automatic source code archive. Install on an existing Geeklog 2.2.2 site after a full backup.

Highlights:
- Native file browser with directory management, upload, rename, delete and CKEditor image selection.
- JPEG/PNG/WebP editing: crop, rotate, resize, save copy or replace original, depending on the server's GD capabilities.
- Private cached thumbnail generation, with PNG fallback on PHP 5.6.
- Throttled, near-viewport thumbnail loading to reduce load on older shared hosting.
- Always confirm deletion of an empty folder.
- Installs only the required files; no database, lib-common.php or installer changes.
- Backup and rollback scripts, English installation and rollback documentation.
- Intended to remain usable until the official 2.2.3 upgrade, subject to release compatibility checks.

**Requirements:** Geeklog 2.2.2, PHP >= 5.6.4, GD/PNG and Fileinfo; SSH/Bash for installer. PHP 5.6 is end-of-life and carries security risks. Tested on live Geeklog 2.2.2 sites with PHP 5.6.40 and PHP 8.3; automated smoke tests do not guarantee compatibility with every hosting configuration.

**Installation:**
```bash
unzip geeklog-2.2.2-native-media-library-preview-1.zip
cd geeklog-2.2.2-native-media-library-preview-1
bash install.sh --check /absolute/path/to/public_html /absolute/path/to/system
bash install.sh --install /absolute/path/to/public_html /absolute/path/to/system
```

Read **README.md** inside the archive before installing. Keep the backup until Geeklog 2.2.3 is installed and validated.

Please report issues and testing results to the upstream [PR #1173](https://github.com/Geeklog-Core/geeklog/pull/1173).
