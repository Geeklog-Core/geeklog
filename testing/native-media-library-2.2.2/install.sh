#!/usr/bin/env bash
# Admin-only Geeklog 2.2.2 Native Media Library preview (PHP >= 5.6.4).
set -Eeuo pipefail
usage() {
  echo "Usage: bash install.sh --check|--install PUBLIC_HTML_PATH SYSTEM_PATH"
  exit 2
}
[[ $# -eq 3 ]] || usage
MODE="$1"; WEB="${2%/}"; SYS="${3%/}"
[[ "$MODE" == "--check" || "$MODE" == "--install" ]] || usage
[[ -f "$WEB/lib-common.php" && -f "$WEB/siteconfig.php" && -d "$WEB/filemanager" ]] || {
  echo "ERROR: invalid Geeklog public_html directory."; exit 1;
}
[[ -d "$SYS/classes" ]] || { echo "ERROR: invalid Geeklog system directory."; exit 1; }
WEB="$(cd "$WEB" && pwd -P)"
SYS="$(cd "$SYS" && pwd -P)"
SOURCE="$(cd "$(dirname "$0")" && pwd -P)"
[[ -f "$SOURCE/public_html/filemanager/index.php" && -f "$SOURCE/system/classes/Media/MediaLibrary.php" ]] || {
  echo "ERROR: extract the complete preview ZIP before installing."; exit 1;
}
if ! php -r 'exit(PHP_VERSION_ID >= 50604 ? 0 : 1);'; then
  echo "ERROR: PHP CLI 5.6.4 or later is required."; exit 1;
fi
if ! php -r 'exit(extension_loaded("gd") && function_exists("imagepng") && function_exists("finfo_open") ? 0 : 1);'; then
  echo "ERROR: PHP GD/PNG and Fileinfo are required."; exit 1;
fi
for file in "$SOURCE"/public_html/filemanager/{index,api}.php "$SOURCE"/system/classes/Media/*.php; do
  php -l "$file" >/dev/null || { echo "ERROR: PHP syntax: $file"; exit 1; }
done
grep -Fq 'Preview: administrators only' "$SOURCE/system/classes/Media/MediaLibrary.php" || {
  echo "ERROR: admin-only restriction missing from package."; exit 1;
}
echo "Target public_html: $WEB"
echo "Target system:      $SYS"
echo "Verify Geeklog is 2.2.2 and the WEBSITE PHP (not only CLI) is >= 5.6.4."
echo "PHP 5.6 is obsolete and receives no upstream security fixes."
if [[ "$MODE" == "--check" ]]; then
  echo "Preflight passed. No files modified."
  exit 0
fi
BASE="$HOME/geeklog-media-preview-backups"
mkdir -p "$BASE"
BACKUP="$BASE/$(date -u +%Y%m%dT%H%M%SZ)-$$"
mkdir -m 700 "$BACKUP"
printf '%s\n%s\n' "$WEB" "$SYS" > "$BACKUP/targets.txt"
chmod 600 "$BACKUP/targets.txt"
# Only back up files we will touch: never copy or delete userfiles/media.
FILES=(
  index.php api.php
  assets/media-library.js assets/media-library.css
  connectors/php/events.php connectors/php/filemanager.php
  libs/jQuery-File-Upload/server/php/UploadHandler.php
  libs/jQuery-File-Upload/server/php/index.php
  libs/jQuery-File-Upload/test/index.html
  libs/jQuery-File-Upload/test/test.js
)
mkdir -p "$BACKUP/filemanager"
for file in "${FILES[@]}"; do
  if [[ -f "$WEB/filemanager/$file" ]]; then
    mkdir -p "$BACKUP/filemanager/$(dirname "$file")"
    cp -p "$WEB/filemanager/$file" "$BACKUP/filemanager/$file"
  fi
done
if [[ -d "$SYS/classes/Media" ]]; then
  cp -a "$SYS/classes/Media" "$BACKUP/Media"
else
  touch "$BACKUP/Media.did-not-exist"
fi
# The rollback script knows exactly which files the preview changes.
cp "$SOURCE/rollback.sh" "$BACKUP/rollback.sh"
install_files() {
  mkdir -p "$SYS/classes/Media" "$WEB/filemanager/assets" || return 1
  for file in "$SOURCE"/system/classes/Media/*.php; do
    cp -p "$file" "$SYS/classes/Media/" || return 1
  done
  for file in index.php api.php; do
    cp -p "$SOURCE/public_html/filemanager/$file" "$WEB/filemanager/$file" || return 1
  done
  for file in media-library.js media-library.css; do
    cp -p "$SOURCE/public_html/filemanager/assets/$file" "$WEB/filemanager/assets/$file" || return 1
  done
  for file in "${FILES[@]:4}"; do
    rm -f "$WEB/filemanager/$file" || return 1
  done
}
echo "Backup: $BACKUP"
if ! install_files; then
  echo "ERROR: installation interrupted. Restoring the previous Filemanager files."
  if ! printf 'RESTORE\\n' | bash "$BACKUP/rollback.sh" "$BACKUP"; then
    echo "CRITICAL: automatic restore failed; restore manually from: $BACKUP" >&2
  fi
  exit 1
fi
echo "Installed. Restore with: bash '$BACKUP/rollback.sh' '$BACKUP'"
echo "No media files, lib-common.php, database, or Geeklog installer modified."
