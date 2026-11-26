# Language checker (#1180)

Run from any directory using the path to the checker:

    php tools/language-check/check.php --all
    php tools/language-check/check.php --all --identical
    php tools/language-check/test.php

The checker is read-only and uses PHP tokenization rather than including language files. It compares direct array keys against the matching English reference (UTF-8 or legacy), reports missing, obsolete, duplicate and empty entries, literal printf and numeric-brace placeholders, PHP syntax and UTF-8 validity. Optional identical-English findings are informational, not proof of missing translation. Existing intentionally empty English entries are not flagged as empty translations.

Dynamic expressions and nested array values (including translated configuration option labels) are not compared at value level. Unsupported placeholder formats and suspicious escape sequences require manual review; deeper validation is a later step. The tool does not generate or change translations.

Default exit status is informational; --strict fails on syntax/UTF-8 errors only. CI runs fixtures and uploads an informational report, without failing on existing translation findings. Future synchronization requires human review.
