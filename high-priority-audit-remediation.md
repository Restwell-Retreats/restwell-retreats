# High Priority Audit Remediation

## Goal
Ship a focused remediation pass across the 8 high-priority audit domains using selected skill frameworks from `SKILLS_GLOSSARY.md`.

## Selected Skills
- `code-review-checklist` (safe implementation quality gate)
- `seo-audit` + `seo-fundamentals` (technical SEO changes and validation)
- `schema-markup` + `geo-fundamentals` (AEO/GEO readiness)
- `analytics-tracking` (event taxonomy and implementation)
- `security-auditor` (theme-level hardening checks)
- `web-performance-optimization` (asset/runtime improvements)
- `accessibility-compliance-accessibility-audit` (WCAG-focused UX checks)

## Tasks
- [x] Task 1: **Architecture & Codebase Health** - split one large concern from `inc/seo.php` into a new include (e.g. social meta helpers) and wire via `functions.php` include order. -> Verify: grep shows new include file + `functions.php` require, no removed functionality in `inc/seo.php`.
- [x] Task 2: **SEO Technical** - add reusable TL;DR block support (meta field + render pattern) and implement on two priority templates (`front-page.php` and one interior template). -> Verify: page source shows TL;DR text directly after primary H1 section in both templates.
- [x] Task 3: **GEO / AEO** - extend `llms.txt` with concise page-purpose summaries for top pages (home/property/how-it-works/resources/faq). -> Verify: `llms.txt` contains one-line purpose summaries for each listed page plus existing freshness marker.
- [ ] Task 4: **Analytics** - add `enquiry_form_started`, `faq_expanded`, and `scroll_depth` in `assets/js/main.js` with consistent event params (`page_path`, `user_type`). -> Verify: code contains the three event names and shared parameter keys.
- [ ] Task 5: **Security** - add lightweight request hardening for user enumeration via REST users endpoint (deny unauthenticated listing) in theme-safe hook. -> Verify: code contains `rest_authentication_errors` (or equivalent) guard scoped to user listing endpoints.
- [ ] Task 6: **Performance** - add font preloading for self-hosted Phosphor WOFF2 files and ensure no duplicate icon CSS enqueues. -> Verify: one enqueue path per icon weight and preload hooks output local `.woff2` URLs.
- [ ] Task 7: **Accessibility & UX** - add `aria-sort` state updates for sortable admin enquiry headers and ensure FAQ toggle controls expose expanded state. -> Verify: relevant markup/scripts contain `aria-sort` and `aria-expanded` updates.
- [ ] Task 8: **Keyword Cannibalization (Editorial)** - update target page metadata/content seeds to enforce intent split (Who It's For vs Carers post; Resources vs funding posts) and add linking rule notes in `AUDIT.md`. -> Verify: changed keyphrases/meta descriptions in source and explicit hub/spoke guidance in `AUDIT.md`.
- [ ] Task 9: **Audit Refresh** - update `restwell-theme/AUDIT.md` scores, open issues, and action plan based on completed work above. -> Verify: all 8 domains include current status and no stale references to fixed items.
- [ ] Task 10: **Verification (LAST)** - run lint/diagnostic pass on touched files and perform a manual source-check checklist (events, meta tags, llms entries, hardening hooks). -> Verify: no new diagnostics introduced and checklist items all pass.

## Done When
- [ ] All 8 high-priority domains have at least one implemented, verified improvement.
- [ ] `restwell-theme/AUDIT.md` matches repository reality and high-priority backlog is reduced to remaining non-implemented items only.
- [ ] Tracking/security/SEO/GEO changes are visible in code and discoverable by simple grep checks.

## Notes
- Keep changes WordPress-native (`restwell_` prefix, escaped output, no new dependencies).
- Preserve behavior on admin/AJAX/REST contexts when adding frontend redirects or request guards.
