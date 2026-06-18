# Restwell Retreats - Comprehensive Codebase Audit (Rerun)

**Date:** 18 June 2026 (audit-90 remediation rerun)  
**Scope:** `/restwell-theme/` + `wp-content/mu-plugins/restwell-crm/` (PHP, JS, CSS, SEO/schema, analytics, security, UX/admin)  
**Audit mode:** Code-first rerun with live runtime spot-checks (homepage source, REST users endpoint)

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

Most recently completed remediation (audit-90 tasks 7–10):

1. `theme-setup.php`, `seo.php`, and CRM admin logic split into deterministic module loaders under `inc/theme-setup/`, `inc/seo/`, and `inc/crm/`.
2. Theme ops service layer added (`inc/services/`) with `Restwell_Crm_Gateway` and `Restwell_Enquiry_Service`; public form handlers route through adapters.
3. CRM admin query args and flash notices normalized for sanitization on touched paths.

Remaining high-impact risks are concentrated in:

1. Live GA4 DebugView verification and dashboard hardening against low-signal events.
2. Editorial intent refinement for residual “accessible holiday” overlap across home/accessibility/guide content.

---

## Updated Scorecard


| Domain                          | Score  | Status                                                                                               |
| ------------------------------- | ------ | ---------------------------------------------------------------------------------------------------- |
| Security foundations            | 93/100 | Strong — REST user-enumeration guard in `inc/security-rest.php`; live `GET /wp-json/wp/v2/users` returns **401** without auth |
| SEO technical                   | 92/100 | Strong — canonical/meta/social modularized (`inc/seo/*`, `inc/seo-social-meta.php`)                 |
| SEO content/schema              | 93/100 | Strong — JSON-LD on homepage (5 blocks live); template-specific entities in `inc/seo/jsonld.php`      |
| AEO / AI citation readiness     | 92/100 | Strong — TL;DR + freshness + schema supports extraction quality                                     |
| GEO readiness                   | 91/100 | Strong — `llms.txt` freshness and purpose summaries present                                          |
| Analytics                       | 91/100 | Strong — canonical events in `assets/js/main.js` + `ANALYTICS-EVENT-SCHEMA.md`; GA4 DebugView QA still open |
| Site architecture               | 92/100 | Strong — hub/spoke internal-link intent and page-role separation                                      |
| Keyword cannibalization control | 90/100 | Strong — funding/suitability/location intent boundaries improved; copy QA remains editorial           |
| Admin UX (code signals)         | 92/100 | Strong — keyboard/ARIA admin tabs, CRM sort `aria-sort`, sanitized admin query handling               |
| Front-end UX & accessibility    | 90/100 | Strong — semantics and interaction baselines across templates/admin                                 |
| Code quality / maintainability  | 94/100 | Strong — monoliths split: `theme-setup.php` (30 lines), `seo.php` (24 lines), CRM via `inc/crm/bootstrap.php` |
| WordPress standards             | 93/100 | Strong — escaping/sanitization pass on CRM admin + service boundaries                                 |
| Theme architecture              | 93/100 | Strong — deterministic include loaders in `functions.php` + focused `inc/*` modules                 |
| Plugin architecture boundary    | 92/100 | Strong — `inc/services/` adapters; hooks call `restwell_service_*` / `restwell_crm_ops_*`             |


---

## What Is Fixed (Verified)

### 1) Major schema coverage is in place

Verified in `inc/seo/jsonld.php` (loaded via `inc/seo.php`):

- `Organization` / `LocalBusiness` / `WebSite` / `WebPage`
- `BlogPosting`
- `FAQPage`
- `HowTo`
- `TouristDestination`
- `BreadcrumbList`
- Live homepage source: **5** `application/ld+json` blocks (18 Jun 2026 curl)

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

Verified in `inc/seo-social-meta.php`:

- `og:image:width`
- `og:image:height`
- `twitter:image:alt` (with attachment-alt/title fallback)

### 8) XML-RPC and author-enumeration hardening implemented

Verified in `functions.php` and `inc/redirects.php`:

- `add_filter( 'xmlrpc_enabled', '__return_false' );` (`functions.php`)
- `restwell_redirect_author_archives()` redirect policy for `is_author()` on public requests (`inc/redirects.php`)

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

### 18) Theme setup split into dedicated includes

Verified in `inc/theme-setup.php` loader + `inc/theme-setup/`:

- `meta-helpers.php`, `page-defaults.php`, `admin.php`, `logos.php`, `runner.php`, `legal-content.php`, `migrations.php`
- Parent file reduced to deterministic `require_once` chain (30 lines).

### 19) SEO concerns split into focused modules

Verified in `inc/seo.php` loader + `inc/seo/`:

- `meta-helpers.php`, `description.php`, `canonical.php`, `analytics.php`, `jsonld.php`
- Social OG/Twitter remains in `inc/seo-social-meta.php`.

### 20) CRM modules and service boundary implemented

Verified in `inc/crm/bootstrap.php`, `inc/crm/*.php`, and `inc/services/`:

- Mu-plugin `crm.php` loads theme `inc/crm/bootstrap.php` (11 modules).
- `Restwell_Crm_Gateway` + `Restwell_Enquiry_Service` registered in `inc/services/bootstrap.php`.
- Enquiry/FAQ handlers and CRM admin status transitions route through `restwell_service_*` / `restwell_crm_ops_*` wrappers.

---

## Highest Priority Open Issues

## Critical

No critical implementation gaps currently open from the latest hardening/SEO pass.

## High

1. **Run live GA4 verification pass**
  - Validate canonical events/params in DebugView and production explorations.
  - Confirm dashboards are mapped only to canonical event names.
2. **Continue editorial query-intent split**
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

- Large-file decomposition for `theme-setup`, `seo`, and CRM is **complete** (see `inc/theme-setup/`, `inc/seo/`, `inc/crm/`).
- CRM write/status paths route through `inc/services/` adapters (`restwell_crm_ops_*`, `restwell_service_*`).

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

- Authenticated editor/admin REST user access should be spot-checked after deploy (anonymous block verified live **401** on 18 Jun 2026).

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

## Sprint 2 (1-2 weeks)

1. Continue query-intent boundary cleanup for home/accessibility/guide cluster.
2. Publish a lightweight content QA checklist for TL;DR quality and freshness.

## Sprint 3 (2-4 weeks)

1. Spot-check authenticated REST `/wp/v2/users` for editor workflows after major WP/plugin updates.
2. Define medium-term plugin extraction path for any CRM ops still colocated in the theme monorepo layout.
3. Run live browser/admin UX verification pass for interaction ergonomics and empty states.

---

## Verification Notes

Repository evidence plus live spot-checks (18 Jun 2026):

- Homepage source: `og:image:width`, `twitter:image:alt`, local Phosphor CSS handles, 5× JSON-LD blocks.
- `GET https://restwellretreats.co.uk/wp-json/wp/v2/users` (no cookies): **HTTP 401**.
- PHP syntax lint: clean on all split modules and service classes.

Pair with GA4 DebugView and authenticated admin REST checks for full sign-off.