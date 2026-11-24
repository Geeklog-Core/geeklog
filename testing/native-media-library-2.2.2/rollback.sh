#!/usr/bin/env bash
# Restore exactly the previous filemanager and Media class directory.
set -Eeuo pipefail
[[ $# -eq 1 && -f "$1/targets.txt" && -d "$1/filemanager" ]] || {
  echo "Usage: bash rollback.sh /path/to/geeklog-media-preview-backups/BACKUP"; exit 2;
}
BACKUP="$(cd "$1" && pwd -P)"
mapfile -t TARGETS < "$BACKUP/targets.txt"
[[ "${#TARGETS[@]}" -eq 2 ]] || { echo "Invalid backup metadata."; exit 1; }
WEB="${TARGETS[0]}"; SYS="${TARGETS[1]}"
[[ -f "$WEB/lib-common.php" && -d "$SYS/classes" ]] || { echo "Invalid target paths."; exit 1; }
echo "Restore Geeklog media files from $BACKUP?"
echo "This replaces the current filemanager directory and Media classes."
read -r -p "Type RESTORE to continue: " CONFIRM
[[ "$CONFIRM" == "RESTORE" ]] || { echo "Cancelled."; exit 1; }
rm -rf "$WEB/filemanager" "$SYS/classes/Media"
cp -a "$BACKUP/filemanager" "$WEB/filemanager"
if [[ -d "$BACKUP/Media" ]]; then
  cp -a "$BACKUP/Media" "$SYS/classes/Media"
fi
echo "Previous filemanager restored. No media directories or database records touched."
