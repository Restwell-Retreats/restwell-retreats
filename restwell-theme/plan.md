# Restwell Theme — Plan index

Last updated: March 2026

This file is the **hub** for remaining and follow-up work. Each concern has its own doc — details live there; this file links and sets cross-cutting priority only.

The March 2026 implementation roadmap (Plans 1–11) is shipped; it is not repeated here.

---

## Goal

Ship **SEO/performance** fixes and **analytics** (aligned with your existing cookie plugin — no cookie-plugin work in this plan), then improve the **end-to-end journey** (enquiry → CRM → email → guest guide), **operational reliability** (email, duplicates, measurement), and **staff efficiency** (single view of guest, reminders, accurate stay data, handoffs) — without boiling the ocean.

---

## Doc map (one concern per file)

| Concern | Doc | Sections |
|---------|-----|----------|
| **CRM, journey, staff, deployment** | [plan-crm-ops.md](plan-crm-ops.md) | A–E |
| **SEO execution + monthly cadence** | [plan-seo-ops.md](plan-seo-ops.md) | F–G |
| **SEO strategy + per-URL specs** | [SEO-INTENT-ONPAGE-PLAN.md](SEO-INTENT-ONPAGE-PLAN.md) | SSOT §1–§19 |
| **SEO scoreboard** | [SEO-PROGRESS-MATRIX.md](SEO-PROGRESS-MATRIX.md) | Symbols A–G |
| **Template COPY-PASTE workflow** | [COPY-PASTE-PROCESS.md](COPY-PASTE-PROCESS.md) | Process + sync |
| **Template COPY-PASTE manifests** | [COPY-PASTE-PROMPTS.md](COPY-PASTE-PROMPTS.md) | Per-page blocks |

---

## A. Deployment & technical hygiene

- [ ] **Front page — mobile menu button** - Verify hamburger button is ≥ 44×44px with visible tap target on real device. → Verify: Chrome DevTools + real mobile test.
- [ ] **Front page — scroll-to-top button** - Add fixed scroll-to-top button in bottom-right at scroll depth > 50% for long mobile pages. → Verify: Appears on scroll, smooth scroll to top.
- [ ] **Front page — low-end Android test** - Test on simulated slow 4x CPU throttling in DevTools; confirm acceptable performance. → Verify: No jank, page loads in < 5s on slow 3G simulation.
- [ ] **GA4 live verification** - Run DebugView pass; confirm canonical events/params firing; lock dashboard dimensions to documented event names in [ANALYTICS-EVENT-SCHEMA.md](ANALYTICS-EVENT-SCHEMA.md) → Verify: All enquiry funnel events confirmed in GA4.
- [ ] **REST hardening smoke test** - Confirm `curl -sI …/wp-json/wp/v2/users` without cookies → `401` on live/staging. → Verify: Authenticated editor access still intact.
- [ ] **Editorial intent split** - Refine residual overlap around "accessible holiday" language across home/accessibility/guide content cluster. → Verify: No cannibalisation between core pages.

---

## Priority (when time is tight)

Combined view — see linked docs for verification criteria.

| Priority | Item | Track | Detail |
|----------|------|-------|--------|
| 1 | E3: Front-end team dashboard | CRM | [plan-crm-ops.md §E](plan-crm-ops.md#e-crm-operations-uplift-execution-order) |
| 2 | E4: Auto-reminder system (idempotent) | CRM | [plan-crm-ops.md §E](plan-crm-ops.md#e-crm-operations-uplift-execution-order) |
| 3 | SMTP / deliverability | CRM | [plan-crm-ops.md §C](plan-crm-ops.md#c-process--reliability) |
| 4 | Duplicate enquiry UX + CRM visibility | CRM | [plan-crm-ops.md §B](plan-crm-ops.md#b-customer-journey) |
| 5 | Stay dates in CRM (show/edit) | CRM | [plan-crm-ops.md §D](plan-crm-ops.md#d-staff-operations) |
| 6 | Link enquiry ↔ guest + guide workflow | CRM | [plan-crm-ops.md §D](plan-crm-ops.md#d-staff-operations) |
| 7 | Guest guide: resend + expiry copy | CRM | [plan-crm-ops.md §B](plan-crm-ops.md#b-customer-journey) |
| 8 | Archive read-time, nav cache, related posts | CRM | [plan-crm-ops.md §A](plan-crm-ops.md#a-deployment--technical-hygiene) |
| 9 | F7/F9 + G1/G3/G5 (SEO execution cadence) | SEO | [plan-seo-ops.md](plan-seo-ops.md) |
| A | E5: Outlook sync (deferred threshold) | CRM | [plan-crm-ops.md §E](plan-crm-ops.md#e-crm-operations-uplift-execution-order) |

---

## Done when

- [ ] [plan-crm-ops.md](plan-crm-ops.md) **Done when (CRM track)** — all items checked or parked below.
- [ ] [plan-seo-ops.md](plan-seo-ops.md) **Done when (SEO track)** — all items checked or parked below.

---

## Deferred / parked

_Add dated notes here if you skip items on purpose._

---

## Notes

- **Shared mailbox:** **hello@restwellretreats.co.uk** is the default for new enquiry notifications and appears in HTML footers / ack Reply-To; CRM settings can override `restwell_enquiry_notify_email`.
- **Cookies:** Handled by an existing site plugin — this plan does **not** include installing or configuring a cookie banner or consent plugin.
- **Font Awesome:** Self-hosted; no external CDN.
- **Privacy / Terms:** Seeded via `restwell_seed_legal_pages_content()` on theme setup; existing empty pages may need manual seed or re-run setup.
- **SEO meta box:** `inc/seo-admin.php`; template SEO keys removed from `inc/page-meta-definitions.php` where duplicated.
