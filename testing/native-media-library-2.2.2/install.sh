#!/usr/bin/env bash
# Geeklog 2.2.2 Native Media Library preview -- restricted to administrators.
set -Eeuo pipefail

usage() {
  echo "Usage: bash install.sh --check|--install PUBLIC_HTML_PATH SYSTEM_PATH"
  echo "Example: bash install.sh --check /home/account/public_html /home/account/geeklog/system"
  exit 2
}
[[ $# -eq 3 ]] || usage
MODE="$1"; WEB="${2%/}"; SYS="${3%/}"
[[ "$MODE" == "--check" || "$MODE" == "--install" ]] || usage
[[ -d "$WEB/filemanager" && -f "$WEB/lib-common.php" && -f "$WEB/siteconfig.php" ]] || { echo "ERROR: not a Geeklog public_html directory."; exit 1; }
[[ -d "$SYS/classes" ]] || { echo "ERROR: invalid Geeklog system path."; exit 1; }
WEB="$(cd "$WEB" && pwd -P)"
SYS="$(cd "$SYS" && pwd -P)"
SOURCE="$(cd "$(dirname "$0")" && pwd -P)"
[[ -f "$SOURCE/public_html/filemanager/index.php" && -f "$SOURCE/system/classes/Media/MediaLibrary.php" ]] || {
  echo "ERROR: unpack the full preview ZIP first."; exit 1;
}
echo "Geeklog 2.2.2 preview: target $WEB, system $SYS"
echo "NOTE: Confirm in the Geeklog control panel that this is Geeklog 2.2.2."
echo "NOTE: The HTTP/web PHP version must also be PHP 8.3+ (CLI alone is not sufficient)."
if ! php -r 'exit(PHP_VERSION_ID >= 80300 ? 0 : 1);'; then
  echo "ERROR: PHP CLI 8.3+ is required; do not install on PHP 5.6."
  exit 1
fi
if ! php -r 'exit(extension_loaded("gd") && function_exists("imagewebp") ? 0 : 1);'; then
  echo "ERROR: GD with WebP support required."
  exit 1
fi
for file in "$SOURCE"/public_html/filemanager/{index,api}.php "$SOURCE"/system/classes/Media/*.php; do
  php -l "$file" >/dev/null || { echo "ERROR: PHP syntax: $file"; exit 1; }
done
grep -Fq 'Preview: administrators only' "$SOURCE/system/classes/Media/MediaLibrary.php" || {
  echo "ERROR: package is missing the admin-only permission restriction."; exit 1;
}
if [[ "$MODE" == "--check" ]]; then
  echo "Preflight passed (CLI checks only). No files changed."
  exit 0
fi
BASE="$HOME/geeklog-media-preview-backups"
mkdir -p "$BASE"
BACKUP="$BASE/$(date -u +%Y%m%dT%H%M%SZ)-$$"
mkdir -m 700 "$BACKUP"
cp -a "$WEB/filemanager" "$BACKUP/filemanager"
if [[ -e "$SYS/classes/Media" ]]; then
  cp -a "$SYS/classes/Media" "$BACKUP/Media"
else
  touch "$BACKUP/Media.did-not-exist"
fi
printf '%s\n%s\n' "$WEB" "$SYS" > "$BACKUP/targets.txt"
chmod 600 "$BACKUP/targets.txt"

rollback_on_error() {
  echo "ERROR: installation failed. Restoring original files from $BACKUP"
  rm -rf "$WEB/filemanager" "$SYS/classes/Media"
  cp -a "$BACKUP/filemanager" "$WEB/filemanager"
  if [[ -d "$BACKUP/Media" ]]; then
    cp -a "$BACKUP/Media" "$SYS/classes/Media"
  fi
}
trap rollback_on_error ERR
mkdir -p "$SYS/classes/Media" "$WEB/filemanager/assets"
for file in "$SOURCE"/system/classes/Media/*.php; do
  cp -p "$file" "$SYS/classes/Media/"
done
for file in index.php api.php; do
  cp -p "$SOURCE/public_html/filemanager/$file" "$WEB/filemanager/$file"
done
for file in media-library.js media-library.css; do
  cp -p "$SOURCE/public_html/filemanager/assets/$file" "$WEB/filemanager/assets/$file"
done
# Block obsolete executable upload endpoints without deleting media content.
for file in \
  connectors/php/events.php \
  connectors/php/filemanager.php \
  libs/jQuery-File-Upload/server/php/UploadHandler.php \
  libs/jQuery-File-Upload/server/php/index.php \
  libs/jQuery-File-Upload/test/index.html \
  libs/jQuery-File-Upload/test/test.js; do
  rm -f "$WEB/filemanager/$file"
done
trap - ERR
echo "Installed admin-only preview. Backup: $BACKUP"
echo "Rollback command: bash rollback.sh '$BACKUP'"
echo "DO NOT use in production until PHP/web compatibility and functional tests pass."
