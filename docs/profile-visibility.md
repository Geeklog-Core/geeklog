# User profile visibility (Geeklog Core)

Issue: https://github.com/Geeklog-Core/geeklog/issues/1255

The Core setting **User Profile Visibility** is available under **Configuration → Users and Submissions → Login Settings**. It is separate from `profileloginrequired`.

| Setting | Anonymous | Registered user viewing another user | Owner | Administrator with `user.edit` |
| --- | --- | --- | --- | --- |
| Public (0; default) | Allowed unless existing login-required policy denies | Allowed | Allowed | Allowed |
| Registered Users (1) | Login required | Allowed | Allowed | Allowed |
| Owner and Administrators (2) | Denied | Forbidden (HTTP 403) | Allowed | Allowed |

The default is **Public (0)** to preserve previous website behavior. The `profileloginrequired` and general `loginrequired` settings are still honored first, so enabling this feature never weakens an existing login requirement.

## Scope and implementation

Geeklog enforces the authorization in the shared `USER_showProfile()` path of `system/lib-user.php`. This protects both `users.php?mode=profile&uid=...` and `users.php?mode=user&username=...` (and other callers of the renderer), before a target's profile information or plugin blocks are fetched. Unauthorized signed-in viewers receive HTTP 403. Normal Core profile editing and site-user administration are not altered.

The option is included in the fresh Core configuration and is added during the Core upgrade flow if absent. Existing administrator-selected values are never overwritten. Older installations that have not run this upgrade retain the public default until the option is registered.

**Scope boundary:** This only protects the public profile rendering path. It does not replace a privacy audit of other endpoints (user directories, user search, public story bylines/comments, contact forms, plugin APIs or feeds) that might separately expose usernames or member data.

## Regression tests

`php tests/profile_visibility_policy.php` exercises missing/default configuration, anonymous access, registered access, own profile, another member, an administrator with `user.edit`, and unsupported configuration values. The branch's GitHub Actions workflow runs this test and PHP lint on PHP 7.4, 8.2 and 8.3.

## Staging acceptance

1. Upgrade a Geeklog 2.2.2 test installation with a database backup and verify the new configuration dropdown is present. If testing by merely copying PHP files (without running the Core upgrade step), the new configuration value may not yet exist.
2. Set **Owner and Administrators**.
3. Sign in as user A, open user A's own public profile (allowed), then user B's by UID and username (both HTTP 403).
4. Sign in as a user with `user.edit`, open user B's profile (allowed).
5. Sign out and check that a profile cannot be viewed.
6. Set **Public** and verify original behavior returns.

No database schema change is required; this adds a Core configuration record only.
