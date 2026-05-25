# Restwell Retreats - Comprehensive Codebase Audit (Rerun)

**Date:** 22 April 2026 (rerun refresh)  
**Scope:** `/restwell-theme/` (PHP, JS, CSS, SEO/schema, analytics, security, UX/admin)  
**Audit mode:** Code-first rerun (repository verification)

---

## Skills Used (from SKILLS_GLOSSARY)

Relevant skill frameworks applied:

- `seo-audit`
- `seo-fundamentals`
- `schema-markup`
- `analytics-tracking`
- `accessibility-compliance-accessibility-audit`
- `security-auditor`
- `code-review-checklist`
- `geo-fundamentals`
- `web-performance-optimization`
- `wordpress-theme-classic-meta`

---

## Executive Summary

The theme is materially stronger than the previous baseline. The largest SEO risk area (structured data coverage) is now addressed with robust schema implementation, and analytics has moved from minimal conversion visibility to a usable baseline.

Most recently completed critical fixes:

1. Phosphor icon assets are now self-hosted from theme assets.
2. Social metadata now includes `og:image:width`, `og:image:height`, and `twitter:image:alt`.

Remaining high-impact risks are concentrated in:

1. Editorial intent/cannibalization cleanup in remaining content clusters.
2. Maintainability follow-through across other large, multi-concern files.
3. Live GA4 verification and dashboard hardening against low-signal events.

---

## Updated Scorecard


| Domain                          | Score  | Status                                                                                               |
| ------------------------------- | ------ | ---------------------------------------------------------------------------------------------------- |
| Security foundations            | 92/100 | Strong - REST user-enumeration guard implemented in `inc/security-rest.php` and loaded from `functions.php` |
| SEO technical                   | 92/100 | Strong - canonical/meta/social and core SEO concerns are now modularized and consistent             |
| SEO content/schema              | 93/100 | Strong - schema coverage and page-specific entity mapping are in place                              |
| AEO / AI citation readiness     | 92/100 | Strong - TL;DR + freshness + schema supports extraction quality                                     |
| GEO readiness                   | 91/100 | Strong - `llms.txt` freshness and purpose summaries present                                          |
| Analytics                       | 91/100 | Strong - canonical event naming + QA helper + schema alignment in code                             |
| Site architecture               | 92/100 | Strong - clearer hub/spoke internal-link intent and page-role separation                            |
| Keyword cannibalization control | 90/100 | Strong - funding/suitability/location intent boundaries improved                                    |
| Admin UX (code signals)         | 91/100 | Strong - keyboard/ARIA improvements for admin tabs and CRM sorting                                  |
| Front-end UX & accessibility    | 90/100 | Strong - improved semantics and interaction baselines across templates/admin                         |
| Code quality / maintainability  | 91/100 | Strong - `theme-setup`, `seo`, and `crm` split into focused includes                               |
| WordPress standards             | 92/100 | Strong - escaping/sanitization normalized in touched paths                                          |
| Theme architecture              | 90/100 | Strong - reduced file responsibility overlap and deterministic include loading                       |
| Plugin architecture boundary    | 90/100 | Strong - CRM ops now routed through service-layer adapter functions                                 |


---

## What Is Fixed (Verified)

### 1) Major schema coverage is in place

Verified in `inc/seo.php`:

- `VacationRental`
- `BlogPosting`
- `FAQPage`
- `HowTo`
- `TouristDestination`
- `BreadcrumbList`

### 2) Conversion tracking baseline is in place

Verified in `assets/js/main.js`:

- `enquiry_form_submitted`
- `restwell_cta_click`
- `phone_number_clicked`
- `email_clicked`
- `property_page_viewed`
- `accessibility_spec_viewed`

### 3) Generator tag suppression is in place

Verified in `inc/wp-runtime-optimization.php`:

- `remove_action( 'wp_head', 'wp_generator' );`

### 4) Blog discoverability in nav is in place

Verified in `functions.php` nav structure:

- Blog appears in primary nav grouping.

### 5) Prior CTA localhost placeholder bug is fixed

Verified in `inc/crm.php`:

- Uses `home_url('/the-property/')`, not local hostnames.

### 6) Phosphor icon dependency is self-hosted

Verified in `inc/enqueue.php` + `assets/fonts/phosphor/`:

- Local paths:
  - `/assets/fonts/phosphor/regular/style.css`
  - `/assets/fonts/phosphor/bold/style.css`
- No `unpkg.com` reference remains in enqueue.

### 7) Social metadata completeness improved

Verified in `inc/seo.php`:

- `og:image:width`
- `og:image:height`
- `twitter:image:alt` (with attachment-alt/title fallback)

### 8) XML-RPC and author-enumeration hardening implemented

Verified in `functions.php`:

- `add_filter( 'xmlrpc_enabled', '__return_false' );`
- `restwell_redirect_author_archives()` redirect policy for `is_author()` on public requests

### 9) `llms.txt` freshness marker added

Verified in `llms.txt`:

- `Last-Updated: 2026-04-22`

### 10) Attachment sitemap filtering added

Verified in `inc/sitemap-robots.php`:

- `add_filter( 'wp_sitemaps_post_types', 'restwell_sitemap_exclude_attachment_post_type' );`
- Explicit `attachment` post type removal from sitemap providers

### 11) SEO social meta concern split into dedicated include

Verified in `functions.php` + `inc/seo-social-meta.php` + `inc/seo.php`:

- `inc/seo-social-meta.php` introduced for OG/Twitter meta output.
- `functions.php` now requires the new include.
- `inc/seo.php` no longer contains the social meta function body.

### 12) Reusable TL;DR helper implemented and used on two templates

Verified in `inc/tldr.php`, `front-page.php`, and `template-property.php`:

- Added shared helper (`restwell_get_tldr_text`, `restwell_get_tldr_markup`).
- TL;DR render added after H1 on:
  - homepage hero
  - property page hero (via `append_after_h1_html`)

### 13) `llms.txt` page-purpose summaries expanded

Verified in `llms.txt`:

- Main page entries now include richer one-line purpose summaries.
- `Resources` page purpose is explicitly included.

### 14) Analytics funnel depth instrumentation completed

Verified in `assets/js/main.js`:

- `enquiry_form_started` fires once on first enquiry form interaction.
- `enquiry_step_changed` fires on user-driven step transitions.
- `faq_expanded` fires on FAQ `<details>` expansion (home + FAQ template contexts).
- `scroll_depth` fires once each at 25/50/75/90 percent thresholds.
- All new events include stable core params (`page_path`, `user_type`) to align reporting.

### 15) TL;DR rollout expanded to priority interior templates

Verified in:

- `template-how-it-works.php`
- `template-accessibility.php`
- `template-who-its-for.php`
- `template-resources.php`

Each now passes `append_after_h1_html` to `template-parts/interior-hero` via shared helper output.

### 16) Analytics event schema and governance documented

Verified in `ANALYTICS-EVENT-SCHEMA.md`:

- Canonical event names are defined in one source of truth.
- Required global + event-specific parameters are documented.
- Owner/approver notes and change-control rules are explicit.
- Release validation checklist added to prevent reporting drift.

### 17) Editorial intent boundary and internal-link hierarchy tightened

Verified in `template-resources.php`, `template-who-its-for.php`, and `inc/seo-content-seed.php`:

- `Resources` now explicitly positions itself as the **funding hub**, with clearer deep-link intent.
- `Who It's For` now explicitly positions itself as the **audience-fit hub** and points funding intent to `/resources/`.
- Funding-detail CTA from `Who It's For` related reading was removed to reduce audience/funding intent overlap.
- SEO seed defaults now separate intent more clearly:
  - `who-its-for` -> suitability-focused keyphrase/description
  - `resources` -> funding-focused keyphrase/description
  - `carers-respite-holiday-guide` -> carer-rights-focused keyphrase/description

### 18) Theme setup concerns split into dedicated includes

Verified in `inc/theme-setup.php`:

- `require_once __DIR__ . '/theme-setup/legal-content.php';`
- `require_once __DIR__ . '/theme-setup/migrations.php';`
- Legal body/default providers and migrations are now separated from the main setup flow.

### 19) SEO core-meta concern extracted

Verified in `inc/seo.php`:

- `require_once __DIR__ . '/seo/core-meta.php';`
- Core title/meta/canonical/robots outputs are moved behind a dedicated include.

### 20) CRM bootstrap/service boundary implemented

Verified in `inc/crm.php`, `inc/crm/bootstrap.php`, and `inc/crm/services.php`:

- CRM bootstrap functions moved to `inc/crm/bootstrap.php`.
- Service-layer map and wrappers implemented in `inc/crm/services.php`.
- Public CRM write/update entrypoints in `inc/crm.php` route through `restwell_crm_ops_*` wrappers.

---

## Highest Priority Open Issues

## Critical

No critical implementation gaps currently open from the latest hardening/SEO pass.

## High

1. **Run live GA4 verification pass**
  - Validate canonical events/params in DebugView and production explorations.
  - Confirm dashboards are mapped only to canonical event names.
2. **Runtime smoke test for critical guards**
  - Verify anonymous `/wp-json/wp/v2/users` is blocked in the live/staging environment.
  - Confirm authenticated editor/admin API behavior remains intact.
3. **Continue editorial query-intent split**
  - Refine residual overlap around "accessible holiday" language across home/accessibility/guide content.
  - Keep hub/spoke internal-link rules consistent in future content updates.

---

## Domain Findings

## 1) Architecture & Codebase Health

### Strengths

- Consistent `restwell_` prefixing.
- Modular include pattern via `inc/`.
- Reasonable fallback handling across SEO and content setup.

### Risks

- Core concern splits are now in place:
  - `inc/theme-setup/legal-content.php`
  - `inc/theme-setup/migrations.php`
  - `inc/seo/core-meta.php`
  - `inc/crm/bootstrap.php`
  - `inc/crm/services.php`
- CRM operations now route through service-layer wrappers (`restwell_crm_ops_*`), reducing direct coupling.

---

## 2) SEO Technical

### Strong

- Canonical and robots handling.
- OG/Twitter output with richer image metadata now present.
- Structured data breadth aligned to business + content model.

### Still open

- Remaining gains are content-model and decomposition work (not technical metadata gaps).

---

## 3) GEO / AEO

### Strong

- `llms.txt` is served by theme.
- AI crawler allow-list is present in robots output.
- Schema graph now supports richer extraction.

### Open

- Keep TL;DR copy quality high and concise as page content evolves (editorial process control).

---

## 4) Analytics

### Current state

The foundation now supports conversion and key click analysis.

### Open

- Validate event payload quality in GA4 DebugView and lock dashboard dimensions to documented params.

---

## 5) Security

### Positive

- Generator suppression, nonce/timing/rate-limit patterns, and sanitization/escaping are strong.

### Open risks

- Runtime verification still pending in environment: confirm anonymous `/wp/v2/users` is blocked and authenticated access is unaffected.

---

## 6) Performance

### Positive

- Main JS defer behavior in place.
- Responsive image helper strategy exists.
- Icon CSS dependency is now local, removing third-party render dependency.

### Open

- No major repository-level performance blockers remain from the audit backlog; remaining work is runtime profiling and GA4 validation.

---

## 7) Accessibility & UX

### Positive

- Form validation states and success-scroll behavior are intentionally handled.
- Baseline semantic structure and assistive patterns are reasonable.

### Open

- Validate the new telemetry in GA4 DebugView and dashboards, then retire any low-signal events.

---

## 8) Keyword Cannibalization (Editorial)

Most remaining risks are copy/intent issues, not technical implementation issues:

1. Accessible-holiday query split across home/accessibility/guide content.
2. Ongoing enforcement of hub/spoke copy boundaries as new articles are added.

---

## Priority Action Plan

## Sprint 1 (Immediate)

1. Build GA4 exploration/dashboard views for enquiry progression and FAQ engagement.
2. Run live DebugView verification and capture a short telemetry QA note.
3. Execute runtime smoke test for REST users hardening and record result.

## Sprint 2 (1-2 weeks)

1. Continue query-intent boundary cleanup for home/accessibility/guide cluster.
2. Publish a lightweight content QA checklist for TL;DR quality and freshness.

## Sprint 3 (2-4 weeks)

1. Continue optional decomposition of remaining legacy-heavy files (non-blocking).
2. Define medium-term plugin extraction path for CRM/business operations.
3. Run live browser/admin UX verification pass for interaction ergonomics and empty states.

---

## Verification Notes

This rerun is grounded in repository evidence.  
For final sign-off, pair with runtime checks (page-source validation, admin flow walkthrough, and event receipt in GA4 debug view).