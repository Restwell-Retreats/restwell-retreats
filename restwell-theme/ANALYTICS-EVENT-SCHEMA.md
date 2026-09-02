# Restwell Analytics Event Schema (GA4)

Last updated: 2026-09-01
Owner: Restwell marketing + theme maintainer
Scope: Theme-tracked frontend interaction events (`assets/js/main.js`; enquire/gallery/nav split files do not emit these)

---

## Purpose

This document defines canonical analytics events, required parameters, and governance rules so tracking stays stable over time and reporting does not drift.

---

## Canonical Event Names

Use these exact names (snake_case, lowercase):

- `enquiry_form_started`
- `enquiry_step_changed`
- `enquiry_form_submitted`
- `faq_expanded`
- `scroll_depth`
- `restwell_cta_click`
- `phone_number_clicked`
- `email_clicked`
- `property_page_viewed`
- `accessibility_spec_viewed`

Do not introduce near-duplicates (for example `form_start`, `faq_opened`, `ctaClick`).

---

## Required Parameters

### Global required params (all custom events)

- `page_path` (string): current pathname (for example `/who-its-for/`)
- `user_type` (string): currently `guest` for anonymous site users

### Event-specific required params

- `enquiry_step_changed`
  - `enquiry_step` (number: `1`, `2`, `3`)
- `faq_expanded`
  - `faq_category` (string; for example `about`, `funding`, `home`)
- `scroll_depth`
  - `scroll_percent` (number: one of `25`, `50`, `75`, `90`)
- `enquiry_form_submitted`
  - `source_page` (string pathname or `(direct)`)
- `restwell_cta_click`
  - `cta_id` (string)
  - `cta_location` (string)
  - `cta_label` (string)
  - `target_url` (string URL or path)
  - `cta_text` (string; dual-track alias of `cta_label` until reports migrate)
- `phone_number_clicked`
  - `phone_number` (string; from `tel:` href, not typed PII)
- `email_clicked`
  - `email_address` (string; from `mailto:` href, address only)

---

## Ownership Notes

- **Schema owner:** Theme maintainer (technical correctness and implementation).
- **Reporting owner:** Marketing/content owner (GA4 explorations and dashboard usage).
- **Change approver:** Site owner or delegated product/marketing lead.

No event naming or parameter changes should be merged without updating this file and confirming GA4 report compatibility.

---

## Governance Rules

1. **Canonical-first:** Reuse an existing event whenever intent matches.
2. **No ad-hoc params:** Add new params only when they are explicitly required for analysis.
3. **Keep types stable:** Do not change parameter type semantics once live.
4. **One-way migrations:** If renaming is unavoidable, dual-track old + new for one release, then remove old and annotate here.
5. **PR requirement:** Any analytics change must include:
   - code change
   - this file updated
   - one-line GA4 validation note in the PR description
   - confirmation that `consent_gated` still blocks gtag until analytics consent
6. **Debug verification:** Validate in GA4 DebugView after deploy before announcing complete.

`accessibility_spec_viewed` fires only when the pathname (trailing slashes stripped) is exactly `/accessibility`. It must not fire on `/accessibility-policy/`.

---

## Validation Checklist (per release)

- [ ] Events fire in GA4 DebugView with expected names.
- [ ] Required params are present on each event.
- [ ] No duplicate event names introduced for same user action.
- [ ] Dashboard/exploration filters still return expected results.
- [ ] This schema file matches production behavior.
