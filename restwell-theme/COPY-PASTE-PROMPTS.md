# Copy-paste page prompts (Restwell theme)

Work **top to bottom**. For each numbered section, copy everything inside the **fenced block** into a new Cursor chat.

**SSOT (strategy + scoreboard):** [SEO-INTENT-ONPAGE-PLAN.md](SEO-INTENT-ONPAGE-PLAN.md) · [SEO-PROGRESS-MATRIX.md](SEO-PROGRESS-MATRIX.md)

**Paths:** `@restwell-theme/` = this theme folder. Invoke skills via **`/skill-name`** — see [SKILLS_GLOSSARY.md](SKILLS_GLOSSARY.md).

**Once per chat:** `@` every **Context** line plus any skill files you want loaded.

## Post-run sync (required)

After each template run:

1. Map outputs to P4 steps **A–G** (keywords → published/verified).
2. Append or update the URL row in **SEO-INTENT-ONPAGE-PLAN.md §13.1**.
3. Update **SEO-PROGRESS-MATRIX.md** symbols for that URL (A–G column).
4. Do **not** treat COPY-PASTE completion as done until the matrix reflects it.

## Template coverage

| File | Purpose |
|------|---------|
| `COPY-PASTE-PROMPTS.md` | **This file** — full prompts per page |
| `page-manifest.template.yaml` | Blank manifest for custom pages |
| `inc/page-meta-definitions.php` | Meta keys per template |
| Homepage field/schema reference | SSOT **§13.1 Home preset** (was `HOMEPAGE-PIPELINE-DELIVERABLE.md`) |

**Templates:** `front-page.php`, `template-property.php`, `template-accessibility.php`, `template-enquire.php`, `template-faq.php`, `template-how-it-works.php`, `template-who-its-for.php`, `template-whitstable-guide.php`, `template-resources.php`, `template-contact.php`; also `single.php`, `page-guest-guide.php` as separate runs.

**Suggested order:** Hubs (property, accessibility, how it works, enquire) → supporting (who it’s for, resources, FAQ, Whitstable guide, contact). Update `sibling_pages_for_seo` in each manifest as you finish pages.

**Done checklist (before next page):** Copy brief accepted · meta-key table complete · one H1 + sensible H2s · internal links listed · schema decision recorded · polish notes match theme · matrix write-back done.

---

## Work order (suggested)

1. Homepage — `front-page.php`
2. Property — `template-property.php`
3. Accessibility — `template-accessibility.php`
4. How it works — `template-how-it-works.php`
5. Enquire — `template-enquire.php`
6. Who it’s for — `template-who-its-for.php`
7. Resources — `template-resources.php`
8. FAQ — `template-faq.php`
9. Whitstable guide — `template-whitstable-guide.php`
10. Contact — `template-contact.php`
11. (Optional) Guest guide — `page-guest-guide.php`

---

## 1. Homepage

**Context:** `@restwell-theme/front-page.php` `@restwell-theme/inc/page-meta-definitions.php`

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

## Process (execute in order; brief plan first, then deliver)
1. /copywriting /copywriting — Copy Brief Summary + assumptions. If brief_pre_approved is false, STOP after the brief unless I say continue.
2. /copy-editing /copy-editing — Polish the draft.
3. /seo-meta-optimizer /wordpress-theme-classic-meta /seo-meta-optimizer /wordpress-theme-classic-meta — Copy deck keyed to post meta keys (table: key → proposed copy → factual/legal risk note if any).
4. /seo-structure-architect /seo-structure-architect — H1–H3, internal links, jumps.
5. /seo-cannibalization-detector /seo-cannibalization-detector — only if sibling_pages_for_seo is non-empty.
6. /seo-content-auditor /seo-content-auditor + /seo-authority-builder /seo-authority-builder — gaps + E-E-A-T in one pass.
7. /schema-markup /schema-markup — eligibility + minimal JSON-LD OR explicit "do not implement".
8. /restwell-page-polish — implementation notes (tokens from @restwell-theme/assets/css/input.css, sections, escaping, vs @restwell-theme/template-property.php).
9. /visual-frontend-audit /visual-frontend-audit — only if artifact_for_visual is not none; align with @restwell-theme/VISUAL-FRONTEND-AUDIT.md when relevant.

Constraints: work only under @restwell-theme ; no fabricated proof; escape all output; no inline script/style.

## Output format
1) Plan 2) Brief (if needed) 3) Meta-key table 4) SEO 5) Schema 6) Polish checklist 7) Visual (if any)
```

---

## 2. Property

**Context:** `@restwell-theme/template-property.php` `@restwell-theme/inc/page-meta-definitions.php`

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

## Process (execute in order; brief plan first, then deliver)
1. /copywriting /copywriting — Copy Brief Summary + assumptions. If brief_pre_approved is false, STOP after the brief unless I say continue.
2. /copy-editing /copy-editing — Polish the draft.
3. /seo-meta-optimizer /wordpress-theme-classic-meta /seo-meta-optimizer /wordpress-theme-classic-meta — Copy deck keyed to post meta keys (table: key → proposed copy → factual/legal risk note if any).
4. /seo-structure-architect /seo-structure-architect — H1–H3, internal links, jumps.
5. /seo-cannibalization-detector /seo-cannibalization-detector — only if sibling_pages_for_seo is non-empty.
6. /seo-content-auditor /seo-content-auditor + /seo-authority-builder /seo-authority-builder — gaps + E-E-A-T in one pass.
7. /schema-markup /schema-markup — eligibility + minimal JSON-LD OR explicit "do not implement" (note VacationRental/address fields if present).
8. /restwell-page-polish — implementation notes (tokens from @restwell-theme/assets/css/input.css, sections, escaping; reference standard @restwell-theme/template-property.php).
9. /visual-frontend-audit /visual-frontend-audit — only if artifact_for_visual is not none; align with @restwell-theme/VISUAL-FRONTEND-AUDIT.md when relevant.

Constraints: work only under @restwell-theme ; no fabricated proof; escape all output; no inline script/style.

## Output format
1) Plan 2) Brief (if needed) 3) Meta-key table 4) SEO 5) Schema 6) Polish checklist 7) Visual (if any)
```

---

## 3. Accessibility

**Context:** `@restwell-theme/template-accessibility.php`

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

## Process (execute in order; brief plan first, then deliver)
1. /copywriting /copywriting — Copy Brief Summary + assumptions. If brief_pre_approved is false, STOP after the brief unless I say continue.
2. /copy-editing /copy-editing — Polish the draft.
3. /seo-meta-optimizer /wordpress-theme-classic-meta /seo-meta-optimizer /wordpress-theme-classic-meta — Copy deck keyed to post meta keys (table: key → proposed copy → factual/legal risk note if any).
4. /seo-structure-architect /seo-structure-architect — H1–H3, internal links, jumps.
5. /seo-cannibalization-detector /seo-cannibalization-detector — only if sibling_pages_for_seo is non-empty.
6. /seo-content-auditor /seo-content-auditor + /seo-authority-builder /seo-authority-builder — gaps + E-E-A-T in one pass.
7. /schema-markup /schema-markup — eligibility + minimal JSON-LD OR explicit "do not implement".
8. /restwell-page-polish — implementation notes (tokens, sections, escaping, positive framing per skill).
9. /visual-frontend-audit /visual-frontend-audit — only if artifact_for_visual is not none; align with @restwell-theme/VISUAL-FRONTEND-AUDIT.md when relevant.

Constraints: work only under @restwell-theme ; no fabricated proof; escape all output; no inline script/style.

## Output format
1) Plan 2) Brief (if needed) 3) Meta-key table 4) SEO 5) Schema 6) Polish checklist 7) Visual (if any)
```

---

## 4. How it works

**Context:** `@restwell-theme/template-how-it-works.php` `@restwell-theme/template-parts/how-it-works-steps.php`

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

## Process (execute in order; brief plan first, then deliver)
1. /copywriting /copywriting — Copy Brief Summary + assumptions. If brief_pre_approved is false, STOP after the brief unless I say continue.
2. /copy-editing /copy-editing — Polish the draft.
3. /seo-meta-optimizer /wordpress-theme-classic-meta /seo-meta-optimizer /wordpress-theme-classic-meta — Copy deck keyed to post meta keys (table: key → proposed copy → factual/legal risk note if any).
4. /seo-structure-architect /seo-structure-architect — H1–H3, internal links, jumps.
5. /seo-cannibalization-detector /seo-cannibalization-detector — only if sibling_pages_for_seo is non-empty.
6. /seo-content-auditor /seo-content-auditor + /seo-authority-builder /seo-authority-builder — gaps + E-E-A-T in one pass.
7. /schema-markup /schema-markup — eligibility + minimal JSON-LD OR explicit "do not implement".
8. /restwell-page-polish — implementation notes (tokens, sections, escaping).
9. /visual-frontend-audit /visual-frontend-audit — only if artifact_for_visual is not none; align with @restwell-theme/VISUAL-FRONTEND-AUDIT.md when relevant.

Constraints: work only under @restwell-theme ; no fabricated proof; escape all output; no inline script/style.

## Output format
1) Plan 2) Brief (if needed) 3) Meta-key table 4) SEO 5) Schema 6) Polish checklist 7) Visual (if any)
```

---

## 5. Enquire

**Context:** `@restwell-theme/template-enquire.php`

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

## Process (execute in order; brief plan first, then deliver)
1. /copywriting /copywriting — Copy Brief Summary + assumptions. If brief_pre_approved is false, STOP after the brief unless I say continue.
2. /copy-editing /copy-editing — Polish the draft.
3. /seo-meta-optimizer /wordpress-theme-classic-meta /seo-meta-optimizer /wordpress-theme-classic-meta — Copy deck keyed to post meta keys (table: key → proposed copy → factual/legal risk note if any).
4. /seo-structure-architect /seo-structure-architect — H1–H3, internal links.
5. /seo-cannibalization-detector /seo-cannibalization-detector — only if sibling_pages_for_seo is non-empty.
6. /seo-content-auditor /seo-content-auditor + /seo-authority-builder /seo-authority-builder — gaps + E-E-A-T in one pass.
7. /schema-markup /schema-markup — eligibility + minimal JSON-LD OR explicit "do not implement".
8. /restwell-page-polish — implementation notes (form UX copy, escaping).
9. /visual-frontend-audit /visual-frontend-audit — only if artifact_for_visual is not none; align with @restwell-theme/VISUAL-FRONTEND-AUDIT.md when relevant.

Constraints: work only under @restwell-theme ; no fabricated proof; escape all output; no inline script/style.

## Output format
1) Plan 2) Brief (if needed) 3) Meta-key table 4) SEO 5) Schema 6) Polish checklist 7) Visual (if any)
```

---

## 6. Who it’s for

**Context:** `@restwell-theme/template-who-its-for.php`

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

## Process (execute in order; brief plan first, then deliver)
1. /copywriting /copywriting — Copy Brief Summary + assumptions. If brief_pre_approved is false, STOP after the brief unless I say continue.
2. /copy-editing /copy-editing — Polish the draft.
3. /seo-meta-optimizer /wordpress-theme-classic-meta /seo-meta-optimizer /wordpress-theme-classic-meta — Copy deck keyed to post meta keys (table: key → proposed copy → factual/legal risk note if any).
4. /seo-structure-architect /seo-structure-architect — H1–H3, internal links, sticky nav labels.
5. /seo-cannibalization-detector /seo-cannibalization-detector — only if sibling_pages_for_seo is non-empty.
6. /seo-content-auditor /seo-content-auditor + /seo-authority-builder /seo-authority-builder — gaps + E-E-A-T in one pass.
7. /schema-markup /schema-markup — eligibility + minimal JSON-LD OR explicit "do not implement".
8. /restwell-page-polish — implementation notes (tokens, persona cards, funding section).
9. /visual-frontend-audit /visual-frontend-audit — only if artifact_for_visual is not none; align with @restwell-theme/VISUAL-FRONTEND-AUDIT.md when relevant.

Constraints: work only under @restwell-theme ; no fabricated proof; escape all output; no inline script/style.

## Output format
1) Plan 2) Brief (if needed) 3) Meta-key table 4) SEO 5) Schema 6) Polish checklist 7) Visual (if any)
```

---

## 7. Resources

**Context:** `@restwell-theme/template-resources.php`

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

## Process (execute in order; brief plan first, then deliver)
1. /copywriting /copywriting — Copy Brief Summary + assumptions. If brief_pre_approved is false, STOP after the brief unless I say continue.
2. /copy-editing /copy-editing — Polish the draft.
3. /seo-meta-optimizer /wordpress-theme-classic-meta /seo-meta-optimizer /wordpress-theme-classic-meta — Copy deck keyed to post meta keys (table: key → proposed copy → factual/legal risk note if any).
4. /seo-structure-architect /seo-structure-architect — H1–H3, internal links.
5. /seo-cannibalization-detector /seo-cannibalization-detector — only if sibling_pages_for_seo is non-empty.
6. /seo-content-auditor /seo-content-auditor + /seo-authority-builder /seo-authority-builder — gaps + E-E-A-T in one pass.
7. /schema-markup /schema-markup — eligibility + minimal JSON-LD OR explicit "do not implement".
8. /restwell-page-polish — implementation notes.
9. /visual-frontend-audit /visual-frontend-audit — only if artifact_for_visual is not none; align with @restwell-theme/VISUAL-FRONTEND-AUDIT.md when relevant.

Constraints: work only under @restwell-theme ; no fabricated proof; escape all output; no inline script/style.

## Output format
1) Plan 2) Brief (if needed) 3) Meta-key table 4) SEO 5) Schema 6) Polish checklist 7) Visual (if any)
```

---

## 8. FAQ

**Context:** `@restwell-theme/template-faq.php`

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

## Process (execute in order; brief plan first, then deliver)
1. /copywriting /copywriting — Copy Brief Summary + assumptions. If brief_pre_approved is false, STOP after the brief unless I say continue.
2. /copy-editing /copy-editing — Polish the draft.
3. /seo-meta-optimizer /wordpress-theme-classic-meta /seo-meta-optimizer /wordpress-theme-classic-meta — Copy deck keyed to post meta keys (table: key → proposed copy → factual/legal risk note if any).
4. /seo-structure-architect /seo-structure-architect — H1–H3, internal links.
5. /seo-cannibalization-detector /seo-cannibalization-detector — only if sibling_pages_for_seo is non-empty.
6. /seo-content-auditor /seo-content-auditor + /seo-authority-builder /seo-authority-builder — gaps + E-E-A-T in one pass.
7. /schema-markup /schema-markup — FAQPage only if visible Q&A match; else explain.
8. /restwell-page-polish — implementation notes.
9. /visual-frontend-audit /visual-frontend-audit — only if artifact_for_visual is not none; align with @restwell-theme/VISUAL-FRONTEND-AUDIT.md when relevant.

Constraints: work only under @restwell-theme ; no fabricated proof; escape all output; no inline script/style.

## Output format
1) Plan 2) Brief (if needed) 3) Meta-key table 4) SEO 5) Schema 6) Polish checklist 7) Visual (if any)
```

---

## 9. Whitstable guide

**Context:** `@restwell-theme/template-whitstable-guide.php`

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

## Process (execute in order; brief plan first, then deliver)
1. /copywriting /copywriting — Copy Brief Summary + assumptions. If brief_pre_approved is false, STOP after the brief unless I say continue.
2. /copy-editing /copy-editing — Polish the draft.
3. /seo-meta-optimizer /wordpress-theme-classic-meta /seo-meta-optimizer /wordpress-theme-classic-meta — Copy deck keyed to post meta keys (table: key → proposed copy → factual/legal risk note if any).
4. /seo-structure-architect /seo-structure-architect — H1–H3, internal links.
5. /seo-cannibalization-detector /seo-cannibalization-detector — only if sibling_pages_for_seo is non-empty.
6. /seo-content-auditor /seo-content-auditor + /seo-authority-builder /seo-authority-builder — gaps + E-E-A-T in one pass.
7. /schema-markup /schema-markup — eligibility + minimal JSON-LD OR explicit "do not implement".
8. /restwell-page-polish — implementation notes.
9. /visual-frontend-audit /visual-frontend-audit — only if artifact_for_visual is not none; align with @restwell-theme/VISUAL-FRONTEND-AUDIT.md when relevant.

Constraints: work only under @restwell-theme ; no fabricated proof; escape all output; no inline script/style.

## Output format
1) Plan 2) Brief (if needed) 3) Meta-key table 4) SEO 5) Schema 6) Polish checklist 7) Visual (if any)
```

---

## 10. Contact

**Context:** `@restwell-theme/template-contact.php`

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

## Process (execute in order; brief plan first, then deliver)
1. /copywriting /copywriting — Copy Brief Summary + assumptions. If brief_pre_approved is false, STOP after the brief unless I say continue.
2. /copy-editing /copy-editing — Polish the draft.
3. /seo-meta-optimizer /wordpress-theme-classic-meta /seo-meta-optimizer /wordpress-theme-classic-meta — Copy deck keyed to post meta keys (table: key → proposed copy → factual/legal risk note if any).
4. /seo-structure-architect /seo-structure-architect — H1–H3, internal links.
5. /seo-cannibalization-detector /seo-cannibalization-detector — only if sibling_pages_for_seo is non-empty.
6. /seo-content-auditor /seo-content-auditor + /seo-authority-builder /seo-authority-builder — gaps + E-E-A-T in one pass.
7. /schema-markup /schema-markup — LocalBusiness/Organization only if visible NAP matches; else explain.
8. /restwell-page-polish — implementation notes.
9. /visual-frontend-audit /visual-frontend-audit — only if artifact_for_visual is not none; align with @restwell-theme/VISUAL-FRONTEND-AUDIT.md when relevant.

Constraints: work only under @restwell-theme ; no fabricated proof; escape all output; no inline script/style.

## Output format
1) Plan 2) Brief (if needed) 3) Meta-key table 4) SEO 5) Schema 6) Polish checklist 7) Visual (if any)
```

---

## 11. Optional: Guest guide (operational / privacy)

**Context:** `@restwell-theme/page-guest-guide.php`

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
1. /copy-editing /copy-editing — clarity, scannability, consistency.
2. /restwell-page-polish — layout/accessibility of blocks only; no marketing fluff.
3. Do NOT invent policies, numbers, or WiFi credentials; flag placeholders.

Constraints: @restwell-theme only; escape output; treat sensitive fields as sensitive.

## Output format
1) Edited copy table by meta key 2) List of items needing human verification 3) Polish notes
```

---

## Visual pass (any page)

**Context:** `@restwell-theme/VISUAL-FRONTEND-AUDIT.md` + relevant template (e.g. `@restwell-theme/template-property.php`)

```
Run /visual-frontend-audit /visual-frontend-audit only for this page.

Page URL: PASTE_URL
Template: @restwell-theme/PASTE_TEMPLATE_FILE.php

Check against @restwell-theme/VISUAL-FRONTEND-AUDIT.md and /restwell-page-polish patterns. Output: severity-tagged issues, concrete fixes (classes/tokens), and quick wins.
```

---

## Site-wide SEO audit (optional)

```
Run /seo-audit /seo-audit scope: site-wide Restwell theme.

Constraints: Evidence-based; no implementation unless I ask. Reference @restwell-theme/ templates and @restwell-theme/inc/seo*.php only as needed.

Output: prioritized findings, SEO Health Index per seo-audit skill, and action list.
```

---

## Run log (homepage — historical)

*Merged from archived `PAGE-RUNS.md` (2026-07-05). Sync new runs to §13.1 + matrix.*

### Homepage (`front-page.php`) — 2026-04-03

- **Local URL:** http://restwell.local/
- **Pipeline:** Brief + meta-key table + heading map + schema stance completed; WP admin paste optional.
- **Visual:** Single H1; H2 order intro → who → property → why → CTA; CTA order **See the property** then **Enquire about dates**.
- **Placeholders:** `property_image_id`, `cta_image_id` acceptable until final media.

### Homepage — consolidated pipeline (2026-04)

- Field/schema reference now in SSOT **§13.1 Home preset** (archived `HOMEPAGE-PIPELINE-DELIVERABLE.md`).
- LodgingBusiness NAP sources: verify against admin options and `inc/seo.php`.

**Optional two-phase runs:** Phase A = steps 1–4 + meta table; Phase B = steps 5–9 using saved meta table.
