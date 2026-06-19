# Critical Audit Fixes

## Goal
Close all **Critical** items listed in `restwell-theme/AUDIT.md` with code changes that are testable in one pass.

## Tasks
- [x] Task 1: Self-host Phosphor icon CSS/fonts in `restwell-theme/assets/` and switch `restwell-theme/inc/enqueue.php` to local `wp_enqueue_style` URLs only. -> Verify: search `inc/enqueue.php` has no `unpkg.com` URL and front-end icons still render.
- [x] Task 2: Add OG image dimensions in `restwell-theme/inc/seo-social-meta.php` (`og:image:width`, `og:image:height`) by resolving attachment metadata when OG image exists. -> Verify: page source contains both OG dimension tags on home and one interior page.
- [x] Task 3: Add `twitter:image:alt` in `restwell-theme/inc/seo-social-meta.php` using image alt meta with a safe fallback (site/title text). -> Verify: page source contains `twitter:image:alt` when social image is present.
- [x] Task 4: Add XML-RPC hardening in `restwell-theme/functions.php` (or a dedicated include) with `add_filter( 'xmlrpc_enabled', '__return_false' )`. -> Verify: code present and no PHP syntax errors.
- [x] Task 5: Add author archive enumeration mitigation in `restwell-theme/inc/redirects.php` by redirecting `is_author()` requests to home with 301. -> Verify: code path exists and does not run in admin/AJAX/REST contexts.
- [x] Task 6: Update `restwell-theme/AUDIT.md` Critical section to mark these items as fixed and move any follow-up work to High/Medium. -> Verify: `Highest Priority Open Issues -> Critical` reflects zero unresolved items for these three categories.
- [x] Task 7: Verification (LAST): run lint/syntax checks for changed PHP files and manually inspect generated head tags in source view. -> Verify: no new lints; expected meta tags present; icons load from local theme paths.

## Done When
- [x] No external icon CDN remains in `inc/enqueue.php`.
- [x] Social meta output includes `og:image:width`, `og:image:height`, and `twitter:image:alt`.
- [x] XML-RPC is explicitly disabled and author archive enumeration mitigation is implemented.
- [x] `restwell-theme/AUDIT.md` accurately reflects the new critical-item status.

## Notes
- Keep implementation minimal and WordPress-native (`restwell_` prefixes, escaped output, sanitized lookups).
- Do not alter behavior on admin, AJAX, or REST requests when adding redirect/hardening logic.
