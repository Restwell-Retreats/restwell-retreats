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

## F. SEO execution plan (from [SEO-INTENT-ONPAGE-PLAN.md](SEO-INTENT-ONPAGE-PLAN.md) §1–§16 + §19)

Goal: execute the documented SEO strategy in a practical sequence across on-page, technical SEO, local SEO, internal linking, content, and authority building. Legacy root `restwell-seo-section*.md` files are archived under `docs/archive/seo-legacy/legacy-strategy/`.

- [ ] **F1 - Keep positioning tight (keyword focus + audience)**  
  Enforce "accessible + Whitstable/Kent coast + near Canterbury" as primary targets; avoid chasing broad generic holiday-let terms. Keep dual-audience language: families/carers plus OTs/case managers/commissioners.

- [ ] **F7 - Accessibility/equipment trust assets**  
  Publish and prominently link an up-to-date access statement PDF and any professional assessment resources from Accessibility, Who It's For, FAQ, and Enquire.

- [ ] **F9 - 12-month content cadence (section 10)**  
  Execute monthly blog/resource schedule across four pillars: Accessible Travel Guides, Funding & Access, For Professionals, Kent Coast Life.  
  Prioritise already identified high-opportunity topics (Revitalise alternatives, direct payments, accessible Kent beaches).

---

## G. SEO operating cadence (new-company mode: no social-proof dependency)

Goal: run SEO as a repeatable operating system with clear thresholds, ownership, and monthly outputs, without relying on reviews/testimonials yet.

- [ ] **G1 - KPI scorecard with hard thresholds (90-day + 12-month)**  
  Create `seo-scorecard.md` (or a sheet) with monthly targets and owners for: non-brand clicks, branded clicks, impressions, CTR on core pages, average position for top 20 target queries, enquiry conversions from organic, and GBP actions.  
  Add threshold actions, e.g. "if homepage CTR < 2.5% at >1,000 impressions/month, rewrite title/meta within 7 days."

- [ ] **G2 - Intent-to-conversion map per page cluster**  
  For each cluster/page type (core pages, funding/professional pages, blog posts), define: primary intent, required CTA, and conversion event expected (`enquiry_submit`, `click_to_call`, `email_click`).  
  Add this map to plan docs and enforce in content reviews before publishing.

- [ ] **G3 - Monthly indexation QA runbook**  
  On the first week of each month, run checks for: duplicate titles/descriptions, missing meta description, accidental noindex, canonical mismatch, orphan pages, thin pages, and sitemap inclusion errors.  
  Record findings + fixes in a dated log entry under `Deferred / parked` or a dedicated SEO log.

- [ ] **G4 - Cannibalisation and query-cluster review (monthly)**  
  In GSC, review overlapping pages for the same query themes (e.g. accessibility vs property vs who-it's-for).  
  For conflicts, choose one primary URL and execute one action: merge, re-target H1/meta, strengthen internal anchors, or add canonical where justified.

- [ ] **G5 - CTR optimisation sprint (monthly, top 5 pages)**  
  Pick the 5 URLs with highest impressions and below-target CTR.  
  Rewrite title/meta using doc-aligned intent language, publish, and measure after 28 days. Keep a changelog of before/after CTR and clicks.

- [ ] **G6 - Content freshness policy**  
  Add "review due" dates to all blog/resource content at publish time (+6 months).  
  At review, choose one outcome: refresh, consolidate, or deprecate. Ensure updated posts have refreshed internal links and metadata.

- [ ] **G7 - Backlink pipeline metrics (weekly)**  
  Track outreach in a simple pipeline: target, relevance tier, contact date, status, live URL, and referral traffic. See SSOT **§19.2–§19.3** for priority targets and directory checklist.  
  Weekly KPI: pitches sent, responses, links earned, and links from priority categories (accessibility, Kent tourism, professional/care).

- [ ] **G8 - Entity consistency control sheet**  
  Create one canonical business-facts source (brand name, address, phone, email, primary category, short/long description variants).  
  Use it for site copy, GBP, directories, and outreach bios to prevent NAP/category drift.

- [ ] **G9 - Competitor movement review (monthly)**  
  Track 5-10 direct/indirect competitors from SSOT **§8.1** (competitor landscape table).  
  Log new ranking pages, new backlinks, and new content themes; convert insights into one concrete monthly action on Restwell pages.

- [ ] **G10 - SEO-to-CRO checks for organic landing pages**  
  For top organic landing pages (`/`, `/accessibility`, `/who-its-for`, `/whitstable-area-guide`, `/resources`, top blog posts), verify CTA clarity, form path friction, and above-the-fold message match to query intent.  
  Ship at least one conversion-focused UX/copy improvement per month tied to organic-entry pages.

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
