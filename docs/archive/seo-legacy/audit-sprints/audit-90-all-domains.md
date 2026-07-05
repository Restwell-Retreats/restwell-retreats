> **Archived 2026-07-05.** Superseded by [`restwell-theme/SEO-INTENT-ONPAGE-PLAN.md`](../restwell-theme/SEO-INTENT-ONPAGE-PLAN.md) (site SEO SSOT), [`FRONT-PAGE-OPTIMIZATION.md`](../FRONT-PAGE-OPTIMIZATION.md) (homepage), and/or [`restwell-theme/AUDIT.md`](../restwell-theme/AUDIT.md). Open work: SSOT §11.6 / §16 and AUDIT sprint plan. Do not execute tasks from this file.

# Audit 90+ Remediation Plan

## Goal
Raise every domain in `restwell-theme/AUDIT.md` to at least 90/100 with code-backed improvements and verification evidence.

## Tasks
- [x] Task 1: Add REST user-enumeration hardening in `restwell-theme/functions.php` or a dedicated `inc/security-rest.php` include using `rest_authentication_errors` for unauthenticated `/wp/v2/users` listing requests (skills: `security-auditor`, `code-review-checklist`) -> Verify: code contains the guard, authenticated editor/admin requests still work, anonymous `/wp-json/wp/v2/users` returns blocked response.
- [x] Task 2: Expand schema quality in `restwell-theme/inc/seo.php` to close remaining content/schema gaps (skills: `schema-markup`, `seo-audit`) -> Verify: page source includes valid JSON-LD for all core templates with no duplicate/conflicting primary entities.
- [x] Task 3: Strengthen GEO/AEO extraction signals by adding concise TL;DR/editorial governance for all high-intent templates and aligning `llms.txt` page-purpose + freshness policy (skills: `geo-fundamentals`, `seo-fundamentals`) -> Verify: all target templates render TL;DR after H1 and `llms.txt` has current `Last-Updated` plus accurate page summaries.
- [x] Task 4: Complete analytics implementation quality by adding an event QA helper doc and enforcing schema adherence in `assets/js/main.js` (skills: `analytics-tracking`, `code-review-checklist`) -> Verify: events in code match `ANALYTICS-EVENT-SCHEMA.md` exactly and no non-canonical event names remain.
- [x] Task 5: Execute editorial cannibalization cleanup in `inc/seo-content-seed.php` + key templates (`front-page.php`, `template-accessibility.php`, `template-whitstable-guide.php`) to separate intent clusters (skills: `seo-audit`, `seo-fundamentals`) -> Verify: unique keyphrase/meta intent per target page and explicit hub/spoke internal links for funding, suitability, and location content.
- [x] Task 6: Improve admin UX/accessibility in admin UI files (`assets/js/admin-meta-fields.js`, `assets/css/admin-meta-fields.css`, related admin PHP) with robust sort state, focus flow, and interaction clarity (skills: `accessibility-compliance-accessibility-audit`) -> Verify: sortable controls expose correct `aria-sort`, keyboard interaction works end-to-end, and no focus traps/regressions.
- [x] Task 7: Refactor oversized files by splitting concerns from `inc/theme-setup.php`, `inc/seo.php`, and `inc/crm.php` into focused includes under `restwell-theme/inc/` (skills: `code-review-checklist`, `web-performance-optimization`) -> Verify: each original file shrinks materially, behavior unchanged, and includes are loaded in deterministic order.
- [x] Task 8: Improve theme/plugin architecture boundary by introducing an ops service layer interface (theme-side adapter + isolated domain modules) so business logic is no longer tightly coupled to template lifecycle (skills: `wordpress-theme-classic-meta`, `code-review-checklist`) -> Verify: CRM/business actions route through service functions instead of direct template coupling; boundaries documented in code comments.
- [x] Task 9: Raise WordPress standards consistency by auditing touched files for escaping/sanitization and normalizing any misses (skills: `code-review-checklist`, `wordpress-theme-classic-meta`) -> Verify: no unescaped output in modified paths; input handling uses appropriate sanitizers.
- [x] Task 10: Refresh `restwell-theme/AUDIT.md` with rerun evidence, updated scorecard (all domains >= 90 target), and residual risks if any (skills: `seo-audit`, `security-auditor`, `analytics-tracking`) -> Verify: every domain row is updated from repository evidence and open issues list matches actual unresolved items only.

## Done When
- [x] All remediation tasks above are implemented and verified with code/runtime evidence.
- [x] `restwell-theme/AUDIT.md` reflects a current-state rerun with each domain at or above 90/100, or explicitly explains any blocked domain with concrete next action.
- [x] Verification artifacts exist for security hardening, schema output, analytics conformity, editorial intent split, and refactor integrity.

## Notes
- Prioritize critical path: Task 1 -> 2 -> 5 -> 7 -> 10.
- Keep all changes WordPress-native, with `restwell_` prefixes and no new frontend dependencies.
- Runtime validation (GA4 DebugView + page source checks) is mandatory before final score updates.

## Progress log
- 2026-04-22 (Batch 1 complete): Task 1-3 implemented in code.
  - Task 1 evidence: new `restwell-theme/inc/security-rest.php`, loaded via `restwell-theme/functions.php`, filter hook `rest_authentication_errors` with `/wp/v2/users` guard.
  - Task 2 evidence: `restwell-theme/inc/seo.php` now emits singular `WebPage` JSON-LD and links template-specific entities (`FAQPage`, `HowTo`, `TouristDestination`, `ContactPage`) via `mainEntityOfPage`.
  - Task 3 evidence: TL;DR added after H1 for `template-whitstable-guide.php`, `template-faq.php`, `template-enquire.php` (other high-intent templates already had it); `restwell-theme/llms.txt` updated with freshness policy and current `Last-Updated`.
  - Runtime follow-up still required: confirm anonymous `/wp-json/wp/v2/users` block behavior in environment; validate rendered page-source JSON-LD and TL;DR output in browser.
- 2026-04-22 (Batch 2 complete): Task 4-6 implemented in code.
  - Task 4 evidence: `restwell-theme/assets/js/main.js` now sends canonical event names with required params (`cta_location`, `cta_label`, `target_url`, `phone_number`, `email_address`) and `restwell-theme/ANALYTICS-QA-HELPER.md` added for repeatable DebugView checks.
  - Task 5 evidence: explicit hub/spoke internal linking added across `restwell-theme/inc/seo-content-seed.php`, `restwell-theme/front-page.php`, `restwell-theme/template-accessibility.php`, and `restwell-theme/template-whitstable-guide.php` to separate suitability, funding, and location intents.
  - Task 6 evidence: admin tab UX hardened in `restwell-theme/assets/js/admin-meta-fields.js` (ARIA tab semantics + arrow/home/end keyboard support), focus styling added in `restwell-theme/assets/css/admin-meta-fields.css`, sortable headers in `restwell-theme/inc/crm/enquiries.php` now expose `aria-sort` and screen-reader sort direction hints, plus visible focus for sort links in `restwell-theme/assets/css/admin-crm.css`.
- 2026-06-18 (Batch 3 complete): Task 7-10 implemented in code.
  - Task 7 evidence: `theme-setup.php` (30 lines), `seo.php` (24 lines), mu-plugin `crm.php` (22 lines) load `inc/theme-setup/*`, `inc/seo/*`, `inc/crm/*` respectively.
  - Task 8 evidence: `inc/services/bootstrap.php`, `class-restwell-crm-gateway.php`, `class-restwell-enquiry-service.php`; enquire/FAQ handlers + CRM admin hooks route through services.
  - Task 9 evidence: CRM admin `$_GET` sanitization normalized in `inc/crm/enquiries.php` and `dashboard.php`.
  - Task 10 evidence: `AUDIT.md` scorecard rerun (all domains ≥ 90); live checks — homepage JSON-LD ×5, REST users **401**, social meta tags present.
