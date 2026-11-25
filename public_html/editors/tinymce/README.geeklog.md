# TinyMCE integration (experimental, issue #1272)

This branch is based on the native media library PR #1173. CKEditor remains the default and its adapter is unchanged.

## Test installation

Enable Advanced Editor in Geeklog configuration and in the user's preferences. Select TinyMCE in the existing Advanced Editor Name setting. Return to CKEditor at any time by changing that setting. Do not deploy to production until the browser regression checklist is complete.

TinyMCE 8.11.0 is self-hosted, with the GPL license key. Runtime files are vendored from https://github.com/tinymce/tinymce-dist/tree/c3b7b02cbf7bde14582c5e41eb0a82112ca52269 . Upstream source: https://github.com/tinymce/tinymce . Language packs from https://github.com/mklkj/tinymce-i18n/tree/5081dc30a30a8597441ee692a690043d4d40f09f/langs8 . Missing languages fall back to English. No cloud account is required.

## Regression checklist (not yet executed)

- Article editor with intro and body, submissions, comments and static pages.
- Switch plain/HTML/advanced modes, preview, save, re-open, and switch all four toolbar levels without losing content.
- Compare persisted HTML before and after editing existing articles, including autotags, raw/code blocks, pre, entities, Unicode, custom attributes and tables. TinyMCE may normalize markup; check exact protected content and semantic HTML equivalence.
- Test Root, article editor, submitter and ordinary users; verify denied media permissions and server-side HTML filtering. Toolbar visibility is not a security boundary.
- Select image and link through the native media library, cancel and reopen, verify wrong-origin/wrong-window messages are rejected, check both article textareas.
- Check French and English, other available languages, mobile, official themes and Eclipse; test cached and uncached scripts.
- Test CKEditor 4 before and after switching the site setting.
- Verify fresh install and upgrade packages include all runtime assets and corresponding source/license compliance before release.

Run the adapter contract test with node tests/tinymce/adapter.test.js. This is a mocked API test, not a real browser test. PHP lint is covered separately.
