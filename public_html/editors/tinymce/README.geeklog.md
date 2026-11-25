# TinyMCE integration (experimental, issue #1272)

This branch is based on the native media library PR #1173. CKEditor remains the default and its adapter is unchanged.

## Test installation

Enable Advanced Editor in Geeklog configuration and in the user's preferences. Select TinyMCE in the existing Advanced Editor Name setting. Return to CKEditor at any time by changing that setting. Do not deploy to production until the browser regression checklist is complete.

TinyMCE 8.11.0 is self-hosted, with the GPL license key. Runtime files are vendored from https://github.com/tinymce/tinymce-dist/tree/c3b7b02cbf7bde14582c5e41eb0a82112ca52269 . Corresponding upstream version: https://github.com/tinymce/tinymce/tree/472adf35a45153e271a261f6c0b68a54d2d2d30a . Language packs from https://github.com/mklkj/tinymce-i18n/tree/5081dc30a30a8597441ee692a690043d4d40f09f/langs8 . Missing languages fall back to English. No cloud account is required.

## Regression checklist

- Article editor with intro and body, submissions, comments and static pages.
- Switch plain/HTML/advanced modes, preview, save, re-open, and switch all four toolbar levels without losing content.
- Compare persisted HTML before and after editing existing articles, including autotags, raw/code blocks, pre, entities, Unicode, custom attributes and tables. TinyMCE may normalize markup; check exact protected content and semantic HTML equivalence.
- Test Root, article editor, submitter and ordinary users; verify denied media permissions and server-side HTML filtering. Toolbar visibility is not a security boundary.
- Select image and link through the native media library, cancel and reopen, verify wrong-origin/wrong-window messages are rejected, check both article textareas.
- Check French and English, other available languages, mobile, official themes and Eclipse; test cached and uncached scripts.
- Test CKEditor 4 before and after switching the site setting.
- Verify fresh install and upgrade packages include all runtime assets and corresponding source/license compliance before release.

Run the adapter contract test with node tests/tinymce/adapter.test.js. This is a mocked API test, not a real browser test. PHP lint is covered separately.

## Staging evidence — 2026-11-25

Contributor-reported browser checks: article edit/preview/save/reopen, four toolbar levels, resizing and mode switching; image insertion and article save; preserved HTML, Unicode, protected blocks and autotags compared with CKEditor (with Root filtering bypass and four-byte removal disabled for the unrestricted comparison); static page content save; nine comment/submission checks; ten of eleven member permission checks; ten Eclipse checks including mobile and light/dark modes; switching back to CKEditor. Member article save/reopen, remaining static page and media picker cases, official themes and fresh-install/upgrade packaging remain open. Intermittent site-wide server response delay is not attributed to TinyMCE and remains separately unresolved.

The picker accepts only HTTP(S) media URLs from its configured origin and the originating popup. The browser toolbar is not a permission or HTML security boundary; server checks remain authoritative.

## Distribution release gate

Preserve upstream license and third-party notices and the translation license/notice. Language packs are redistributed under their applicable TinyMCE terms, not blanket MIT. Before distributing a release, verify complete corresponding source (including applicable language sources, build instructions and bundled dependencies) and GPL-compatible redistribution terms and license notices. The source tag alone is not a claim that these obligations are fulfilled. Keep CKEditor default; do not merge upstream before the native media dependency and maintainer review.
