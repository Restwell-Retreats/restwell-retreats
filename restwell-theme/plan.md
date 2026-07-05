# Restwell Theme - Plan

Last updated: March 2026

This file lists **remaining and follow-up work**: technical hygiene, deployment, **customer journey**, **process reliability**, and **staff operations**. The March 2026 implementation roadmap (Plans 1-11) is shipped; it is not repeated here.

**Operational context:** Enquiries and notifications default to the shared mailbox **hello@restwellretreats.co.uk** (`restwell_enquiry_notify_email`). Booking is **not** a separate payments engine in the theme: staff move leads to **Booked** in the CRM (`rw_enquiries`), which triggers email and timestamps. There is **no** native Outlook or calendar sync today.

---

## Goal

Ship **SEO/performance** fixes and **analytics** (aligned with your existing cookie plugin - no cookie-plugin work in this plan), then improve the **end-to-end journey** (enquiry → CRM → email → guest guide), **operational reliability** (email, duplicates, measurement), and **staff efficiency** (single view of guest, reminders, accurate stay data, handoffs) - without boiling the ocean.

---

## A. Deployment & technical hygiene

- [ ] **Blog archive read-time** - In `index.php`, stop using `get_the_content()` in the loop for read-time only; use raw `post_content` (e.g. `get_post_field()` / `$post->post_content`) with `restwell_estimate_read_time()`. → Verify: archive read times unchanged; less CPU on large archives.

- [ ] **Fallback nav caching** - `restwell_get_primary_nav_links()` calls `get_page_by_path()` per slug when no menu assigned. Cache slug → permalink per request (static) or short transient. → Verify: at most one resolution path per slug per request.

- [ ] **Related posts query** - In `single.php`, use primary category **term ID** from `get_the_category()` for `WP_Query` `category__in`, not `get_category_by_slug( sanitize_title( name ) )`. → Verify: related posts match the real category.

---

## B. Customer journey

- [ ] **Post-enquiry expectations** - Strengthen acknowledgement and any on-page success copy: explicit **next step** and **response timeframe** (and urgent path if applicable). Touch `inc/emails.php` (ack template) and enquiry success messaging in `template-enquire.php` as needed. → Verify: guests know what happens next and when.

- [ ] **Duplicate submissions** - `restwell_crm_save_enquiry()` skips a new row when the same email submits again within the duplicate window; the guest may still receive an ack. Align **guest-facing copy** (“we already have your enquiry”) and **CRM** (surface link to existing enquiry # or forced note on duplicate attempt). → Verify: no confused guests or orphan expectations.

- [ ] **Guest guide UX** - Add **resend OTP** (or clear “request new code”) and **expiry copy** (30 minutes) in UI/emails. Optional later: magic link as alternative to OTP (new token endpoints + security review). → Verify: fewer “I didn’t get the code” support tickets.

- [ ] **Enquiry form resilience** - Optional: **draft/save progress** (e.g. `localStorage`) + beforeunload warning for long forms. → Verify: refresh doesn’t wipe multi-step progress where implemented.

- [ ] **Pricing stays enquiry-only** - **No** public rates page or calendar; quotes go through the enquiry flow only. Optional copy tweaks elsewhere (FAQ, property page) to **set expectations** (“we’ll confirm availability and discuss rates when we reply”) without publishing prices. → Verify: messaging matches enquiry-only model; no drift toward a pricing template.

---

## C. Process & reliability

- [ ] **Email deliverability (deployment)** - SPF/DKIM/DMARC; SMTP plugin or transactional provider (SendGrid, Postmark, etc.). `wp_mail` alone is fragile in production. All paths (enquiry notify, ack, OTP, CRM-triggered mail) should be covered. → Verify: mail to **hello@** and to guests arrives reliably; bounces monitored.

- [ ] **Transactional copy in the shared inbox** - Optional: **Bcc** or internal copy to **hello@** on booking-confirmation (and other guest-only templates) if the team wants every confirmation archived alongside CRM, without changing Reply-To behaviour on guest-facing threads. → Verify: no duplicate guest confusion; privacy OK.

- [ ] **Mail failure visibility** - If staying on `wp_mail`, add **logging** or provider webhooks for failures; optional **queue/retry** for critical mails. → Verify: staff can see when email didn’t send.

- [ ] **Abuse / rate limits** - Honeypot exists; add **rate limiting** on enquiry + OTP (plugin, WAF, or light IP/throttle in theme). → Verify: burst spam doesn’t overwhelm inbox or DB.

---

## D. Staff operations

- [ ] **Stay dates authoritative in CRM** - `date_from` / `date_to` exist on `rw_enquiries` (from the enquiry form) but are not surfaced on the admin enquiry detail screen (only `preferred_dates` text). **Show and allow editing** of structured stay dates for booked leads so exports, reminders, and any future calendar feed match reality. → Verify: “Booked” rows have trusted dates without relying on free text alone.

- [ ] **Outlook / team calendar (optional initiative)** - No in-theme PMS. Logical sequence: (1) structured dates as above; (2) **private iCal URL** (token-guarded) listing booked stays for Outlook “subscribe to internet calendar” - one-way, refresh not real-time; or (3) **Power Automate** / **Microsoft Graph** if events must appear instantly or two-way. Manual Outlook blocks remain valid at low volume. → Verify: owner chosen; security model for any public URL documented.

- [ ] **Single view of guest** - **Link** `rw_enquiries` and `rw_guests` by email in admin UI: from enquiry detail, show guest row + guide sent / `confirmed_at`; from guest list, link to latest enquiry. → Verify: one place answers “who is this person?”

- [ ] **“Booked - guide not sent” workflow** - Dashboard already lists these; add **one-click** action: open guest add flow, prefill email, or send template with guide link. → Verify: fewer manual copy-paste steps.

- [ ] **Stale enquiry nags** - Superseded by **Section E / Step 4** (hourly stale-`new` reminders with 24h idempotency). Keep this item only for a later **daily digest summary** layer if still needed. → Verify: no duplicate reminder systems are active unintentionally.

- [ ] **Quality & speed** - **Canned reply snippets** or per-status **checklists** (process doc or tiny admin notes field template). Assignee is handled in **Section E / Step 1**; keep this item focused on response consistency. → Verify: team uses one playbook.

- [ ] **Reporting** - CSV export exists; optional **monthly funnel** (export + sheet) or simple admin report (counts by status, conversion). → Verify: leadership can answer volume and stage mix.

---

## E. CRM operations uplift (execution order)

Goal: make CRM ownership, team workflow, and stale-lead follow-up reliable for day-to-day operations.

- [ ] **Step 3 - Front-end team dashboard** - Build `/dashboard/` as login-protected + capability-gated mobile-first lead workspace reusing the same quick-action backend as Step 2. Include filters (`Mine`, `Unassigned`, `All`, status-based), urgency/SLA indicators, and keyboard-safe controls. → Verify: staff can process leads from mobile without wp-admin; dashboard actions produce identical results to admin list actions.

- [ ] **Step 4 - Auto-reminder system** - Hourly cron process for stale leads where `status = 'new'` and age >= 18h; nudge only when `last_reminder_at` is null or older than 24h; update `last_reminder_at` after send. Include fallback recipient for unassigned leads and dry-run mode for rollout validation. → Verify: each eligible lead is reminded at most once per 24h; dry-run produces auditable logs/notes; no reminders sent for non-`new` leads.

- [ ] **Step 5 - Outlook sync (deferred by threshold)** - Keep deferred unless direct-email volume justifies complexity. Preferred later path: Power Automate flow (`hello@` inbound -> webhook -> match sender -> append note/create lead). → Verify: trigger criterion documented (for example, sustained unlogged inbound volume), and no core CRM dependency blocks Steps 1-4.

---

## F. SEO execution plan

**Canonical playbook:** [SEO-INTENT-ONPAGE-PLAN.md](SEO-INTENT-ONPAGE-PLAN.md) §1–§16 + **§19** (GBP / authority). Legacy `restwell-seo-section*.md` → `docs/archive/seo-legacy/legacy-strategy/`.

| Checkbox | Pointer |
|----------|---------|
| **F1** Positioning (accessible + Whitstable/Kent + dual audience) | SSOT **§1.1–§1.2**, **§2.1** seeds |
| **F7** Access statement PDF + trust assets | [AUDIT.md](AUDIT.md) High #3 · SSOT **§16 B5** |
| **F9** 12-month content cadence | SSOT **§16 B3** (reconciled calendar) · blog seeds in `inc/seo-content-seed-blog-cluster-*.php` |

---

## G. SEO operating cadence

**Monthly ritual:** SSOT **§16 B6** + **§11.5–§11.6** (GSC compare). **Open technical/editorial items:** [AUDIT.md](AUDIT.md).

| Item | Pointer |
|------|---------|
| **G1** KPI scorecard + thresholds | Optional `docs/seo-scorecard.md` — defer until G1 prioritised; interim: **§11.2** GSC table |
| **G2** Intent-to-conversion map | SSOT **§16 B2** intent map + [inc/ANALYTICS-PRIMARY-GOAL.md](inc/ANALYTICS-PRIMARY-GOAL.md) |
| **G3** Monthly indexation QA | SSOT **§17** Track A + **§11.6** measurement log |
| **G4** Cannibalisation review | SSOT **§16 B2** · [AUDIT.md](AUDIT.md) §8 |
| **G5** CTR sprint (top 5 URLs) | SSOT **§16 B6** one-pager · [AUDIT.md](AUDIT.md) High #5 |
| **G6** Content freshness policy | SSOT **§16 B5** trust log + B3 review dates |
| **G7** Backlink pipeline | SSOT **§19.2–§19.3** |
| **G8** Entity consistency (NAP) | SSOT **§19.1** GBP + LodgingBusiness sources in **§13.1 Home preset** |
| **G9** Competitor review | SSOT **§8.1** competitor table |
| **G10** SEO-to-CRO on organic landings | [inc/ANALYTICS-PRIMARY-GOAL.md](inc/ANALYTICS-PRIMARY-GOAL.md) · FRONT-PAGE handoff at repo root |

---

## Priority (when time is tight)

| Priority | Item | Area |
|----------|------|------|
| 1 | E3: Front-end team dashboard | CRM Ops |
| 2 | E4: Auto-reminder system (idempotent) | CRM Ops |
| 3 | SMTP / deliverability | Process |
| 4 | Duplicate enquiry UX + CRM visibility | Journey |
| 5 | Stay dates in CRM (show/edit) | Staff - prerequisite for calendar/export |
| 6 | Link enquiry ↔ guest + guide workflow | Staff |
| 7 | Guest guide: resend + expiry copy | Journey |
| 8 | Archive read-time, nav cache, related posts | Technical |
| 9 | F7/F9 + G1/G3/G5 (SEO execution cadence) | SEO |
| A | E5: Outlook sync (deferred threshold) | CRM Ops - optional |

---

## Done when

- [ ] CRM Ops Steps **E3-E4** are shipped with verification criteria met (dashboard parity and reminder idempotency).
- [ ] Core technical items in section A are done or explicitly deferred below.
- [ ] At least one **journey** and one **staff** item above are shipped or consciously parked with a one-line note in **Deferred / parked**.

---

## Deferred / parked

_Add dated notes here if you skip items on purpose._

---

## Notes

- **Shared mailbox:** **hello@restwellretreats.co.uk** is the default for new enquiry notifications and appears in HTML footers / ack Reply-To; CRM settings can override `restwell_enquiry_notify_email`.
- **Cookies:** Handled by an existing site plugin - this plan does **not** include installing or configuring a cookie banner or consent plugin.
- **Font Awesome:** Self-hosted; no external CDN.
- **Privacy / Terms:** Seeded via `restwell_seed_legal_pages_content()` on theme setup; existing empty pages may need manual seed or re-run setup.
- **SEO meta box:** `inc/seo-admin.php`; template SEO keys removed from `inc/page-meta-definitions.php` where duplicated.
