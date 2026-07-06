# Copy-paste page manifests (Restwell theme)

Per-page prompts only. **Workflow, sync rules, and the shared 9-step pipeline** live in [COPY-PASTE-PROCESS.md](COPY-PASTE-PROCESS.md) — `@` that file in every chat.

Work **top to bottom**. For each section, copy the fenced block into a new Cursor chat.

---

## 1. Homepage

**Context:** `@restwell-theme/front-page.php` `@restwell-theme/inc/page-meta-definitions.php` `@restwell-theme/COPY-PASTE-PROCESS.md`

```
Run the full page pipeline for THIS PAGE ONLY.

## Page manifest
page_id: Homepage
template_file: @restwell-theme/front-page.php
wp_path: /

primary_goal: Drive enquiries and property exploration for accessible Whitstable stays.
primary_cta: See the property → @restwell-theme/template-property.php
secondary_cta: Enquire about dates → @restwell-theme/template-enquire.php

audience: Disabled guests, families, carers, comparing accessible stays.
main_objection: "Accessible" accommodation that is not actually suitable.
proof_available: Use existing on-page facts only; no new testimonials unless real.

meta_prefix_or_notes: hero_eyebrow, hero_heading (if used), hero_subheading, hero_cta_*, hero_media_id; what_restwell_*; intro_body; who_*; property_*; why_item*; why_heading; trust_*; testimonial_*; cta_* — see @restwell-theme/front-page.php and definitions.

brief_pre_approved: true
approved_brief:
  - One primary story: private adapted coastal home, optional CQC care, honest access.
  - CTAs: property first, enquire second.

sibling_pages_for_seo:
  - @restwell-theme/template-property.php
  - @restwell-theme/template-accessibility.php
  - @restwell-theme/template-enquire.php
  - @restwell-theme/template-who-its-for.php

include_site_wide_seo_audit: false
artifact_for_visual: none

## Process
@restwell-theme/COPY-PASTE-PROCESS.md — execute §Page pipeline (steps 1–9).

### Process overrides
- Step 8: reference standard @restwell-theme/template-property.php for layout patterns.
```

---

## 2. Property

**Context:** `@restwell-theme/template-property.php` `@restwell-theme/inc/page-meta-definitions.php` `@restwell-theme/COPY-PASTE-PROCESS.md`

```
Run the full page pipeline for THIS PAGE ONLY.

## Page manifest
page_id: The property
template_file: @restwell-theme/template-property.php
wp_path: /the-property/

primary_goal: Help visitors understand the home and convert to enquiry with accurate access detail.
primary_cta: Enquire about dates → @restwell-theme/template-enquire.php
secondary_cta: Accessibility detail → @restwell-theme/template-accessibility.php

audience: Guests and professionals judging fit before booking.
main_objection: Mistrust after bad "accessible" claims elsewhere.
proof_available: Published measurements and verified features only.

meta_prefix_or_notes: prop_* keys throughout (hero, home cards, dignity, features, accessibility, comparison, gallery, practical, nearby, CTA). Full list in @restwell-theme/inc/page-meta-definitions.php (property template).

brief_pre_approved: true
approved_brief:
  - Lead with verified access and dignity of layout; enquiry when ready.

sibling_pages_for_seo:
  - @restwell-theme/front-page.php
  - @restwell-theme/template-accessibility.php
  - @restwell-theme/template-enquire.php
  - @restwell-theme/template-who-its-for.php

include_site_wide_seo_audit: false
artifact_for_visual: none

## Process
@restwell-theme/COPY-PASTE-PROCESS.md — execute §Page pipeline (steps 1–9).

### Process overrides
- Step 7: note VacationRental/address fields if present.
- Step 8: reference standard @restwell-theme/template-property.php.
```

---

## 3. Accessibility

**Context:** `@restwell-theme/template-accessibility.php` `@restwell-theme/COPY-PASTE-PROCESS.md`

```
Run the full page pipeline for THIS PAGE ONLY.

## Page manifest
page_id: Accessibility
template_file: @restwell-theme/template-accessibility.php
wp_path: /accessibility/

primary_goal: Give decision-ready access detail and honest destination context.
primary_cta: Ask us anything → @restwell-theme/template-enquire.php
secondary_cta: none

audience: Wheelchair users, families, OTs comparing specifications.
main_objection: Hidden limitations or marketing fluff.
proof_available: Verified room-by-room and destination copy only.

meta_prefix_or_notes: acc_* (hero, room by room blocks, destination good/challenge/reality, CTA).

brief_pre_approved: true
approved_brief:
  - Honest, specific; Whitstable section avoids generic "accessible" labels.

sibling_pages_for_seo:
  - @restwell-theme/template-property.php
  - @restwell-theme/template-enquire.php
  - @restwell-theme/template-whitstable-guide.php

include_site_wide_seo_audit: false
artifact_for_visual: none

## Process
@restwell-theme/COPY-PASTE-PROCESS.md — execute §Page pipeline (steps 1–9).

### Process overrides
- Step 8: positive framing per /restwell-page-polish skill.
```

---

## 4. How it works

**Context:** `@restwell-theme/template-how-it-works.php` `@restwell-theme/template-parts/how-it-works-steps.php` `@restwell-theme/COPY-PASTE-PROCESS.md`

```
Run the full page pipeline for THIS PAGE ONLY.

## Page manifest
page_id: How it works
template_file: @restwell-theme/template-how-it-works.php
wp_path: /how-it-works/

primary_goal: Clarify booking and stay steps and reduce anxiety about the process.
primary_cta: Enquire about dates → @restwell-theme/template-enquire.php
secondary_cta: See the property → @restwell-theme/template-property.php

audience: First-time bookers and carers planning logistics.
main_objection: Process feels opaque or clinical.
proof_available: none beyond stated CQC partner facts if already in copy.

meta_prefix_or_notes: hiw_* (hero, steps, care CTA block, included, closing CTA, FAQ teaser).

brief_pre_approved: true
approved_brief:
  - Four-step clarity; optional care as choice not obligation.

sibling_pages_for_seo:
  - @restwell-theme/template-enquire.php
  - @restwell-theme/template-property.php
  - @restwell-theme/template-faq.php

include_site_wide_seo_audit: false
artifact_for_visual: none

## Process
@restwell-theme/COPY-PASTE-PROCESS.md — execute §Page pipeline (steps 1–9).
```

---

## 5. Enquire

**Context:** `@restwell-theme/template-enquire.php` `@restwell-theme/COPY-PASTE-PROCESS.md`

```
Run the full page pipeline for THIS PAGE ONLY.

## Page manifest
page_id: Enquire
template_file: @restwell-theme/template-enquire.php
wp_path: /enquire/

primary_goal: Start a low-pressure enquiry with clear expectations and trust.
primary_cta: Submit enquiry form (on-page) → @restwell-theme/template-enquire.php
secondary_cta: Direct email/phone as shown on page

audience: Anyone ready to ask dates or suitability questions.
main_objection: Fear of hard sell or commitment.
proof_available: Response-time expectations as stated; do not invent SLAs.

meta_prefix_or_notes: enq_* (hero, form headings, success messages, contact, response, no-pressure block).

brief_pre_approved: true
approved_brief:
  - Conversation not commitment; clarity on what happens after submit.

sibling_pages_for_seo:
  - @restwell-theme/template-property.php
  - @restwell-theme/template-accessibility.php
  - @restwell-theme/template-contact.php

include_site_wide_seo_audit: false
artifact_for_visual: none

## Process
@restwell-theme/COPY-PASTE-PROCESS.md — execute §Page pipeline (steps 1–9).

### Process overrides
- Step 8: form UX copy, escaping.
```

---

## 6. Who it's for

**Context:** `@restwell-theme/template-who-its-for.php` `@restwell-theme/COPY-PASTE-PROCESS.md`

```
Run the full page pipeline for THIS PAGE ONLY.

## Page manifest
page_id: Who it's for
template_file: @restwell-theme/template-who-its-for.php
wp_path: /who-its-for/

primary_goal: Match persona to reassurance and route to spec/accessibility or enquire.
primary_cta: Enquire → @restwell-theme/template-enquire.php
secondary_cta: Accessibility spec → @restwell-theme/template-accessibility.php

audience: Guests, carers, OTs, commissioners.
main_objection: Wrong fit or funding uncertainty.
proof_available: Care Act / pathway wording already in theme; flag any figure that needs verification.

meta_prefix_or_notes: wif_* — hero, audience, four personas (family, carers, OT, commissioners) with bodies and bullets, funding section, visual intro, process, CTA, related reading.

brief_pre_approved: true
approved_brief:
  - Persona-led; specifics over generic "accessible"; funding section legally careful.

sibling_pages_for_seo:
  - @restwell-theme/template-accessibility.php
  - @restwell-theme/template-enquire.php
  - @restwell-theme/template-property.php
  - @restwell-theme/template-resources.php

include_site_wide_seo_audit: false
artifact_for_visual: none

## Process
@restwell-theme/COPY-PASTE-PROCESS.md — execute §Page pipeline (steps 1–9).

### Process overrides
- Step 4: include sticky nav labels.
- Step 8: persona cards, funding section.
```

---

## 7. Resources

**Context:** `@restwell-theme/template-resources.php` `@restwell-theme/COPY-PASTE-PROCESS.md`

```
Run the full page pipeline for THIS PAGE ONLY.

## Page manifest
page_id: Resources
template_file: @restwell-theme/template-resources.php
wp_path: /resources/

primary_goal: Explain funding and support routes and encourage informed enquiry.
primary_cta: Get in touch → @restwell-theme/template-enquire.php
secondary_cta: none

audience: Guests and families navigating funding.
main_objection: Overwhelm or outdated figures.
proof_available: none — flag any numbers (e.g. capital limits) for manual verification against current rules.

meta_prefix_or_notes: res_* — hero, fund/grants/chc/complaints/contacts sections, CTA.

brief_pre_approved: true
approved_brief:
  - Signposting, not legal advice; date-sensitive facts flagged.

sibling_pages_for_seo:
  - @restwell-theme/template-who-its-for.php
  - @restwell-theme/template-enquire.php

include_site_wide_seo_audit: false
artifact_for_visual: none

## Process
@restwell-theme/COPY-PASTE-PROCESS.md — execute §Page pipeline (steps 1–9).
```

---

## 8. FAQ

**Context:** `@restwell-theme/template-faq.php` `@restwell-theme/COPY-PASTE-PROCESS.md`

```
Run the full page pipeline for THIS PAGE ONLY.

## Page manifest
page_id: FAQ
template_file: @restwell-theme/template-faq.php
wp_path: /faq/

primary_goal: Answer common questions and route to enquire for the rest.
primary_cta: Ask us → @restwell-theme/template-enquire.php
secondary_cta: none

audience: Researchers comparing options.
main_objection: Unanswered questions.
proof_available: FAQ content only; align with site facts.

meta_prefix_or_notes: faq_* — hero, list intro, CTA. (FAQ items may come from meta or loops — follow template.)

brief_pre_approved: true
approved_brief:
  - Snippet-friendly Q&A; consistent with other pages.

sibling_pages_for_seo:
  - @restwell-theme/template-how-it-works.php
  - @restwell-theme/template-accessibility.php
  - @restwell-theme/template-enquire.php

include_site_wide_seo_audit: false
artifact_for_visual: none

## Process
@restwell-theme/COPY-PASTE-PROCESS.md — execute §Page pipeline (steps 1–9).

### Process overrides
- Step 7: FAQPage only if visible Q&A match; else explain.
```

---

## 9. Whitstable guide

**Context:** `@restwell-theme/template-whitstable-guide.php` `@restwell-theme/COPY-PASTE-PROCESS.md`

```
Run the full page pipeline for THIS PAGE ONLY.

## Page manifest
page_id: Whitstable guide
template_file: @restwell-theme/template-whitstable-guide.php
wp_path: /whitstable-area-guide/

primary_goal: Practical local planning with honest access context; support property and enquiry goals.
primary_cta: Enquire about dates → @restwell-theme/template-enquire.php
secondary_cta: See the property → @restwell-theme/template-property.php

audience: Guests planning days out and routes.
main_objection: Generic "accessible" destination claims.
proof_available: Route and surface descriptions; no invented venue access.

meta_prefix_or_notes: wg_* — hero, expandable sections (about, towns, getting here, getting around), access, spotlight, related, planning, eating, CTA.

brief_pre_approved: true
approved_brief:
  - Practical and honest; avoid crowded marketing adjectives.

sibling_pages_for_seo:
  - @restwell-theme/template-accessibility.php
  - @restwell-theme/template-property.php

include_site_wide_seo_audit: false
artifact_for_visual: none

## Process
@restwell-theme/COPY-PASTE-PROCESS.md — execute §Page pipeline (steps 1–9).
```

---

## 10. Contact

**Context:** `@restwell-theme/template-contact.php` `@restwell-theme/COPY-PASTE-PROCESS.md`

```
Run the full page pipeline for THIS PAGE ONLY.

## Page manifest
page_id: Contact
template_file: @restwell-theme/template-contact.php
wp_path: /contact/

primary_goal: Clear contact routes and professional reassurance.
primary_cta: Go to enquiry form → @restwell-theme/template-enquire.php
secondary_cta: Phone/email as on page

audience: Quick questions and professionals needing specs.
main_objection: Unclear response times or wrong channel.
proof_available: Use existing phone/email/hours only.

meta_prefix_or_notes: contact_* — hero, phone, email, address, hours, professionals block, CTA to form.

brief_pre_approved: true
approved_brief:
  - Short, direct; professionals section precise.

sibling_pages_for_seo:
  - @restwell-theme/template-enquire.php
  - @restwell-theme/template-who-its-for.php

include_site_wide_seo_audit: false
artifact_for_visual: none

## Process
@restwell-theme/COPY-PASTE-PROCESS.md — execute §Page pipeline (steps 1–9).

### Process overrides
- Step 7: LocalBusiness/Organization only if visible NAP matches; else explain.
```

---

## 11. Optional: Guest guide (operational / privacy)

**Context:** `@restwell-theme/page-guest-guide.php` `@restwell-theme/COPY-PASTE-PROCESS.md`

Use for **in-house guest copy** — not public SEO.

```
Run a focused clarity and polish pass for THIS PAGE ONLY (operational guest guide).

## Page manifest
page_id: Guest guide
template_file: @restwell-theme/page-guest-guide.php
wp_path: (private or logged-in — do not assume public indexing)

primary_goal: Clear arrival, safety, and house info for guests already booked.
primary_cta: n/a (informational)
primary concern: Accuracy and safety; no SEO gaming.

meta_prefix_or_notes: gg_* — welcome, address, check-in/out, keysafe, WiFi, parking, host, rules, local, emergency numbers, maintenance contacts.

brief_pre_approved: true

## Process
@restwell-theme/COPY-PASTE-PROCESS.md — execute §Guest guide pipeline.
```

---

## Run log (homepage — historical)

*Merged from archived `PAGE-RUNS.md` (2026-07-05). Sync new runs to SSOT §13.1 + [SEO-PROGRESS-MATRIX.md](SEO-PROGRESS-MATRIX.md) per [COPY-PASTE-PROCESS.md](COPY-PASTE-PROCESS.md).*

### Homepage (`front-page.php`) — 2026-04-03

- **Local URL:** http://restwell.local/
- **Pipeline:** Brief + meta-key table + heading map + schema stance completed; WP admin paste optional.
- **Visual:** Single H1; H2 order intro → who → property → why → CTA; CTA order **See the property** then **Enquire about dates**.
- **Placeholders:** `property_image_id`, `cta_image_id` acceptable until final media.

### Homepage — consolidated pipeline (2026-04)

- Field/schema reference now in SSOT **§13.1 Home preset** (archived `HOMEPAGE-PIPELINE-DELIVERABLE.md`).
- LodgingBusiness NAP sources: verify against admin options and `inc/seo.php`.
