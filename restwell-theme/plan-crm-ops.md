# CRM & operations plan

Last updated: March 2026

**Parent index:** [plan.md](plan.md)

Remaining work for **deployment hygiene**, **customer journey**, **process reliability**, **staff operations**, and **CRM uplift**. The March 2026 implementation roadmap (Plans 1–11) is shipped; it is not repeated here.

**Operational context:** Enquiries and notifications default to **hello@restwellretreats.co.uk** (`restwell_enquiry_notify_email`). Booking is **not** a separate payments engine in the theme: staff move leads to **Booked** in the CRM (`rw_enquiries`), which triggers email and timestamps. There is **no** native Outlook or calendar sync today.

---

## A. Deployment & technical hygiene

- [x] **Blog archive read-time** — Single posts already use `get_post_field( 'post_content' )` with `restwell_estimate_read_time()` (`single.php`). Blog index is still concept-static (no loop/`get_the_content()` for read-time). → Verify: single read times unchanged.

- [x] **Fallback nav caching** — `restwell_nav_resolve_page_url()` caches slug → permalink per request (`inc/nav.php`). → Verify: at most one `get_page_by_path` per slug per request.

- [x] **Related posts query** — `single.php` uses `restwell_get_primary_category_id()` → `category__in` (not slug lookup). → Verify: related posts match the real primary category.

---

## B. Customer journey

- [x] **Post-enquiry expectations** — Success variants (default / urgent / duplicate / mail_warn) + ack email next steps (`template-enquire.php`, mu-plugin emails). → Verify: guests know what happens next and when.

- [x] **Duplicate submissions** — Silent success with distinct copy; CRM note on existing enquiry; no duplicate emails (`enquire-handler.php` + `template-enquire.php`). → Verify: no confused guests or orphan expectations.

- [x] **Guest guide UX** — Resend OTP + 30-minute expiry countdown in UI and email (`page-guest-guide.php`, `emails.php`). → Verify: fewer “I didn’t get the code” support tickets.

- [ ] **Enquiry form resilience** — Optional: **draft/save progress** (e.g. `localStorage`) + beforeunload warning for long forms. → Verify: refresh doesn’t wipe multi-step progress where implemented.

- [x] **Pricing page shipped** — Public rates at `/pricing/` (`template-pricing.php` + `restwell_get_pricing()`). Enquiry remains the conversion CTA; calculator and PDF fee sheet are follow-ons. (Supersedes the old enquiry-only rates stance.)

---

## C. Process & reliability

- [ ] **Email deliverability (deployment)** — SPF/DKIM/DMARC; SMTP plugin or transactional provider (SendGrid, Postmark, etc.). `wp_mail` alone is fragile in production. All paths (enquiry notify, ack, OTP, CRM-triggered mail) should be covered. → Verify: mail to **hello@** and to guests arrives reliably; bounces monitored.

- [ ] **Transactional copy in the shared inbox** — Optional: **Bcc** or internal copy to **hello@** on booking-confirmation (and other guest-only templates) if the team wants every confirmation archived alongside CRM, without changing Reply-To behaviour on guest-facing threads. → Verify: no duplicate guest confusion; privacy OK.

- [ ] **Mail failure visibility** — If staying on `wp_mail`, add **logging** or provider webhooks for failures; optional **queue/retry** for critical mails. → Verify: staff can see when email didn’t send.

- [x] **Abuse / rate limits** — Honeypot + timing + IP throttle on enquire (`form-notify.php`). → Verify: burst spam doesn’t overwhelm inbox or DB.

---

## D. Staff operations

- [x] **Stay dates authoritative in CRM** — Structured `date_from` / `date_to` shown and editable on enquiry detail. → Verify: “Booked” rows have trusted dates without relying on free text alone.

- [ ] **Outlook / team calendar (optional initiative)** — No in-theme PMS. Logical sequence: (1) structured dates as above; (2) **private iCal URL** (token-guarded) listing booked stays for Outlook “subscribe to internet calendar” — one-way, refresh not real-time; or (3) **Power Automate** / **Microsoft Graph** if events must appear instantly or two-way. Manual Outlook blocks remain valid at low volume. → Verify: owner chosen; security model for any public URL documented.

- [x] **Single view of guest** — Enquiry detail shows linked guest-guide row (sent / confirmed); guest list links to enquiry `#id` when set. → Verify: one place answers “who is this person?”

- [x] **“Booked - guide not sent” workflow** — Dashboard + enquiry detail **Add to Guest Guide** with prefill. → Verify: fewer manual copy-paste steps.

- [ ] **Stale enquiry nags** — Superseded by **Section E / Step 4** (hourly stale-`new` reminders with 24h idempotency). Keep this item only for a later **daily digest summary** layer if still needed. → Verify: no duplicate reminder systems are active unintentionally.

- [ ] **Quality & speed** — **Canned reply snippets** or per-status **checklists** (process doc or tiny admin notes field template). Assignee is handled in **Section E / Step 1**; keep this item focused on response consistency. → Verify: team uses one playbook.

- [ ] **Reporting** — CSV export exists; optional **monthly funnel** (export + sheet) or simple admin report (counts by status, conversion). → Verify: leadership can answer volume and stage mix.

---

## E. CRM operations uplift (execution order)

Goal: make CRM ownership, team workflow, and stale-lead follow-up reliable for day-to-day operations.

- [x] **Step 3 — Front-end team dashboard (phased)** — **Phase 1 shipped:** mobile-first wp-admin CRM (base = cards / sticky filters / 44px taps; `min-width: 783px` restores tables; stats 1→2→4 cols at 481 / 1101) via `admin-crm.css`. Reuses existing `restwell_lead_action` AJAX. **Phase 2 parked:** public `/dashboard/` with Mine/Unassigned only after assignment exists and phone triage is a recurring need. → Verify: staff can triage from a phone in wp-admin without a parallel front-end surface.

- [x] **Step 4 — Auto-reminder system** — Hourly cron for stale `new` leads (`crm-reminders.php`) with dry-run filter. → Verify: each eligible lead is reminded at most once per 24h; no reminders for non-`new` leads.

- [ ] **Step 5 — Outlook sync (deferred by threshold)** — Keep deferred unless direct-email volume justifies complexity. Preferred later path: Power Automate flow (`hello@` inbound → webhook → match sender → append note/create lead). → Verify: trigger criterion documented (for example, sustained unlogged inbound volume), and no core CRM dependency blocks Steps 1–4.

---

## Priority (CRM track)

| Priority | Item | Area |
|----------|------|------|
| 1 | E3 Phase 1: phone-first wp-admin CRM (done); `/dashboard/` parked | CRM Ops |
| 2 | E4: Auto-reminder system (idempotent) | CRM Ops |
| 3 | SMTP / deliverability | Process |
| 4 | Duplicate enquiry UX + CRM visibility | Journey |
| 5 | Stay dates in CRM (show/edit) | Staff — prerequisite for calendar/export |
| 6 | Link enquiry ↔ guest + guide workflow | Staff |
| 7 | Guest guide: resend + expiry copy | Journey |
| 8 | Archive read-time, nav cache, related posts | Technical |
| A | E5: Outlook sync (deferred threshold) | CRM Ops — optional |

---

## Done when (CRM track)

- [x] CRM Ops Step **E4** shipped; **E3 Phase 1** (phone-first wp-admin) shipped — public `/dashboard/` remains parked until mobile triage is a stated recurring need.
- [ ] Core technical items in section A are done or explicitly deferred in [plan.md](plan.md) **Deferred / parked**.
- [ ] At least one **journey** and one **staff** item above are shipped or consciously parked with a one-line note.
