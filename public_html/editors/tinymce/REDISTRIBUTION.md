# TinyMCE redistribution — release checklist

Geeklog uses TinyMCE 8.11.0 under GPL-2.0-or-later with `license_key: 'gpl'`. No commercial plugins or cloud services are required by this integration.

## Pinned provenance

| Component | Source |
| --- | --- |
| TinyMCE runtime subset | https://github.com/tinymce/tinymce-dist/tree/c3b7b02cbf7bde14582c5e41eb0a82112ca52269 |
| TinyMCE upstream source (tag 8.11.0) | https://github.com/tinymce/tinymce/tree/472adf35a45153e271a261f6c0b68a54d2d2d30a |
| Language packs and translation tooling | https://github.com/mklkj/tinymce-i18n/tree/5081dc30a30a8597441ee692a690043d4d40f09f |

Audit on 2026-11-25 against Geeklog commit 4c46188627c09954a3c898552406ee9dcf71266c: all 61 files in vendor/ have identical Git blob IDs to the pinned upstream files. Runtime files match tinymce-dist; language JS files match langs8/; translation license and notice match the translation repository root. No vendor modifications were identified. This verifies provenance, not source completeness or legal compliance.

## Notices and licensing

- Keep vendor/license.md, vendor/notices.txt, vendor/langs/LICENSE.md and vendor/langs/NOTICE.md.
- The GPL v2 text is already included at public_html/docs/license in Geeklog; ensure release packaging retains it.
- TinyMCE upstream source license: GPL-2.0-or-later.
- The distribution notice lists DOMPurify 3.4.17 (MPL-2.0 OR Apache-2.0), PrismJS 1.30.0 (MIT) and prism-themes 1.9.0 (MIT). This is an upstream notice inventory, not proof that every library is included in the selected runtime subset. Verify actual bundled dependencies, their applicable license route, full notices and corresponding sources. In particular do not assume Apache-2.0 is compatible with GPL-2.0-only.
- Translation tooling and patches use MIT; language packs retain the applicable TinyMCE terms. The committed readable translation JS files and pinned translation tooling are relevant to the source distribution; confirm completeness.

## Release gate (not yet satisfied)

For any release distributing minified TinyMCE, provide complete corresponding machine-readable source and applicable license texts under GPL requirements. For online downloads, offer equivalent access to corresponding source alongside the binary archive, rather than relying only on upstream links. Keep a copy under Geeklog release control. Include pinned source, required build scripts/configuration, actual bundled dependency sources and applicable translation sources/patches; verify that the source can rebuild equivalent runtime files. Preserve the upstream notices. Check the release archive on fresh install and upgrade and verify source availability before publishing.

References:
- https://www.tiny.cloud/docs/tinymce/latest/license-key/
- https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
- https://www.gnu.org/licenses/old-licenses/gpl-2.0-faq.html

Do not mark redistribution compliance complete until the release maintainer has verified the source bundle and licensing. This checklist is technical guidance, not a legal opinion.
