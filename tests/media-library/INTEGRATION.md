# Native Media Library – Geeklog 2.2.3 integration checklist

This checklist concerns upstream [Geeklog-Core/geeklog PR #1173](https://github.com/Geeklog-Core/geeklog/pull/1173), **not** the standalone 2.2.2 preview. The preview installer, rollback and release workflow remain in the `native-media-library-2.2.2-preview` branch.

## Automated checks

- [x] Core compatibility workflow reported green for PHP 5.6, 8.3, 8.4 and 8.5 (2026-11-25; user-confirmed)
- [ ] PHP syntax, JavaScript syntax, runtime thumbnail and storage smoke checks
- [ ] PHPUnit media tests run in the project's supported development environment
- [ ] Legacy PHP connectors and Blueimp test handlers absent from distributed update
- [ ] Upgrade cleanup safely removes only the known legacy executable endpoints

## Manual tests – PHP and permissions

- [ ] Root/Filemanager administrator: browse, upload, edit, rename, create/remove empty folder, delete files
- [x] Tested account with both `story.submit` and `story.edit`, without Filemanager administration: images can be added directly in the gallery and through the article interface/CKEditor; deletion and folder creation are unavailable (user validation on Geeklog 2.2.2 / PHP 5.6.40)
- [ ] Verify `story.submit`-only and `story.edit`-only roles independently, and confirm server-side upload/delete/mkdir permissions (not just hidden buttons)
- [ ] Story editor: `Type=Root`, `Type=File` and `Type=Media` cannot enlarge access or permit a non-image upload
- [ ] Read-only setting forbids uploads, image edits, rename and deletion
- [ ] Non-member/anonymous access denied to index, JSON API and thumbnail endpoint
- [ ] CSRF: expired/replayed token returns JSON 403; sequential multi-upload obtains a new token for each file
- [ ] Upload validation rejects executable suffixes, SVG uploads, MIME mismatches, traversal and symlinks

## Manual tests – browser and storage

- [ ] CKEditor inserts a stable URL into a new article, images remain visible in existing articles
- [ ] Select multiple images and drag-drop; verify per-file progress, failed files, cancellation
- [ ] Changing folder resets finished upload list without rerouting active uploads
- [ ] Image picker filters to permitted image formats in Image/Root views
- [ ] Large directories render thumbnails without excessive concurrent PHP requests
- [ ] Rotation, crop, resize, save as copy and replace original on JPEG/PNG; WebP when GD supports it
- [ ] Confirm overwritten images refresh after cache invalidation

## Upgrade and hosting

- [ ] Fresh Geeklog 2.2.3 install with the replacement manager
- [ ] Upgrade from 2.2.2 containing Rich Filemanager; media/userfiles preserved
- [ ] Upgrade from 2.2.2 containing the standalone preview; no preliminary rollback
- [ ] Filemanager obsolete executable endpoints removed, or upgrade reports actionable permission errors
- [ ] IIS/Windows validation for issue #983: browser, folders, thumbnails, upload and CKEditor. Geeklog v2.2.2 officially documents Apache **or Microsoft IIS** as supported, but the legacy Rich Filemanager fails on IIS 7/8 (CLDR/Globalize loading, #983). Native Media Library removes that legacy dependency; do not close #983 without a Windows/IIS test. Static Pages experimental URL rewriting is separately documented as incompatible with IIS and is outside this PR.
- [ ] Verify URL/path handling on Unix and Windows; report missing extension support separately
- [ ] Verify PHP 8.4/8.5 runtime on a complete Geeklog installation (lint alone is not sufficient)

Do not mark the PR ready for merge until the manual permission and upgrade checks have been reviewed and at least one maintainer has approved the integration.
