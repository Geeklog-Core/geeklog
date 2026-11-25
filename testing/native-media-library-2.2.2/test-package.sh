#!/usr/bin/env bash
# End-to-end package test against a disposable mock Geeklog 2.2.2 site.
set -Eeuo pipefail
ZIP="${1:-geeklog-2.2.2-native-media-library-preview-1.zip}"
ROOT="$(mktemp -d)"
trap 'rm -rf "$ROOT"' EXIT
export HOME="$ROOT/home"
mkdir -p "$HOME" "$ROOT/site/filemanager/assets" "$ROOT/system/classes/Media" "$ROOT/unpacked"
WEB="$ROOT/site"
SYS="$ROOT/system"
printf '%s\n' '<?php // test fixture' > "$WEB/lib-common.php"
printf '%s\n' '<?php // test fixture' > "$WEB/siteconfig.php"
printf '%s\n' 'previous-index' > "$WEB/filemanager/index.php"
printf '%s\n' 'previous-legacy-endpoint' > "$WEB/filemanager/connectors-legacy-placeholder"
printf '%s\n' 'previous-js' > "$WEB/filemanager/assets/media-library.js"
printf '%s\n' 'original-class' > "$SYS/classes/Media/MediaValidator.php"
mkdir -p "$WEB/filemanager/connectors/php" "$WEB/images/library"
printf '%s\n' 'old endpoint' > "$WEB/filemanager/connectors/php/filemanager.php"
printf '%s\n' 'media must survive' > "$WEB/images/library/photo.jpg"
unzip -q "$ZIP" -d "$ROOT/unpacked"
SOURCE="$ROOT/unpacked/geeklog-2.2.2-native-media-library-preview-1"
test -f "$SOURCE/install.sh"
test -f "$SOURCE/rollback.sh"
test ! -e "$SOURCE/README_FR.md"
bash "$SOURCE/install.sh" --check "$WEB" "$SYS"
test "$(cat "$WEB/filemanager/index.php")" = 'previous-index'
bash "$SOURCE/install.sh" --install "$WEB" "$SYS"
test -s "$WEB/filemanager/api.php"
test -s "$WEB/filemanager/assets/media-library.css"
test ! -e "$WEB/filemanager/connectors/php/filemanager.php"
test -f "$WEB/images/library/photo.jpg"
grep -Fq 'Preview: administrators only' "$SYS/classes/Media/MediaLibrary.php"
BACKUP="$(find "$HOME/geeklog-media-preview-backups" -mindepth 1 -maxdepth 1 -type d | head -n 1)"
test -n "$BACKUP"
test -f "$BACKUP/rollback.sh"
printf 'RESTORE\n' | bash "$BACKUP/rollback.sh" "$BACKUP"
test "$(cat "$WEB/filemanager/index.php")" = 'previous-index'
test "$(cat "$WEB/filemanager/assets/media-library.js")" = 'previous-js'
test "$(cat "$SYS/classes/Media/MediaValidator.php")" = 'original-class'
test "$(cat "$WEB/filemanager/connectors/php/filemanager.php")" = 'old endpoint'
test ! -e "$WEB/filemanager/api.php"
test ! -e "$WEB/filemanager/assets/media-library.css"
test ! -e "$SYS/classes/Media/MediaLibrary.php"
test "$(cat "$WEB/images/library/photo.jpg")" = 'media must survive'
echo 'PASS: ZIP install / preflight / rollback / media preservation'
