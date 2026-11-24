#!/usr/bin/env python3
"""Build a small admin-only preview ZIP from native-media-library-pr.
This script is run on the build machine, NOT on the PHP 5.6 web server.
"""
from pathlib import Path
import hashlib
import zipfile

here = Path(__file__).resolve().parent
repo = here.parent.parent
name = "geeklog-2.2.2-native-media-library-preview-1"
output = Path.cwd() / (name + ".zip")
files = [
    "public_html/filemanager/index.php",
    "public_html/filemanager/api.php",
    "public_html/filemanager/assets/media-library.js",
    "public_html/filemanager/assets/media-library.css",
    "system/classes/Media/MediaValidator.php",
    "system/classes/Media/MediaStorage.php",
    "system/classes/Media/MediaLibrary.php",
    "system/classes/Media/MediaImageEditor.php",
    "system/classes/Media/MediaThumbnail.php",
]
extra = ["install.sh", "rollback.sh", "README.md"]
editor_access = "$editor = SEC_hasRights('story.edit') || SEC_hasRights('story.submit');"
admin_restricted = "$editor = false; // Preview: administrators only"
with zipfile.ZipFile(output, "w", zipfile.ZIP_DEFLATED, compresslevel=9) as archive:
    for filename in files:
        data = (repo / filename).read_bytes()
        if filename.endswith("/MediaLibrary.php"):
            text = data.decode("utf-8")
            if text.count(editor_access) != 1:
                raise SystemExit("ERROR: MediaLibrary permission layout changed; refusing to build.")
            data = text.replace(editor_access, admin_restricted).encode("utf-8")
        archive.writestr(name + "/" + filename, data)
    for filename in extra:
        archive.write(here / filename, arcname=name + "/" + filename)
digest = hashlib.sha256(output.read_bytes()).hexdigest()
print("Preview archive:", output)
print("SHA-256:", digest)
print("Only admins can access the generated MediaLibrary.php.")
