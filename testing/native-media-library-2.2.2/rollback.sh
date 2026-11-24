#!/usr/bin/env bash
# Restore only files changed by the preview. Media files are never touched.
set -Eeuo pipefail
[[ $# -eq 1 && -f "$1/targets.txt" && -d "$1/filemanager" ]] || {
  echo "Usage: bash rollback.sh /path/to/preview-backup"; exit 2;
}
BACKUP="$(cd "$1" && pwd -P)"
mapfile -t TARGETS < "$BACKUP/targets.txt"
[[ "${#TARGETS[@]}" -eq 2 ]] || { echo "Invalid backup metadata."; exit 1; }
WEB="${TARGETS[0]}"; SYS="${TARGETS[1]}"
[[ -f "$WEB/lib-common.php" && -d "$SYS/classes" ]] || { echo "Invalid restore destination."; exit 1; }
echo "Restore preview files from $BACKUP ?"
read -r -p "Type RESTORE: " CONFIRM
[[ "$CONFIRM" == "RESTORE" ]] || { echo "Cancelled."; exit 1; }
FILES=(
  index.php api.php
  assets/media-library.js assets/media-library.css
  connectors/php/events.php connectors/php/filemanager.php
  libs/jQuery-File-Upload/server/php/UploadHandler.php
  libs/jQuery-File-Upload/server/php/index.php
  libs/jQuery-File-Upload/test/index.html
  libs/jQuery-File-Upload/test/test.js
)
for file in "${FILES[@]}"; do
  if [[ -f "$BACKUP/filemanager/$file" ]]; then
    mkdir -p "$WEB/filemanager/$(dirname "$file")"
    cp -p "$BACKUP/filemanager/$file" "$WEB/filemanager/$file"
  else
    rm -f "$WEB/filemanager/$file"
  fi
done
if [[ -d "$BACKUP/Media" ]]; then
  mkdir -p "$SYS/classes/Media"
  cp -a "$BACKUP/Media/." "$SYS/classes/Media/"
  # Remove preview-only classes absent from the previous installation.
  for file in "$SYS"/classes/Media/*.php; do
    [[ -e "$file" ]] || continue
    [[ -e "$BACKUP/Media/$(basename "$file")" ]] || rm -f "$file"
  done
else
  for file in MediaValidator.php MediaLibrary.php MediaStorage.php MediaImageEditor.php MediaThumbnail.php; do
    rm -f "$SYS/classes/Media/$file"
  done
  rmdir "$SYS/classes/Media" 2>/dev/null || true
fi
echo "Restored previous filemanager. User-uploaded media and database were not touched."
