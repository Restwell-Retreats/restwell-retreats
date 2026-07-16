> **Archived 2026-07-05.** Superseded by [`restwell-theme/SEO-INTENT-ONPAGE-PLAN.md`](../../../../restwell-theme/SEO-INTENT-ONPAGE-PLAN.md) (site SEO SSOT), [`restwell-theme/docs/FRONT-PAGE-OPTIMIZATION.md`](../../../../restwell-theme/docs/FRONT-PAGE-OPTIMIZATION.md) (homepage), and/or [`restwell-theme/docs/archive/AUDIT.md`](../../../../restwell-theme/docs/archive/AUDIT.md). Open work: SSOT §11.6 / §16 and AUDIT sprint plan. Do not execute tasks from this file.

# Per-page content and polish runs

**Ready-made prompts:** open **`COPY-PASTE-PROMPTS.md`** (manifests) + **`COPY-PASTE-PROCESS.md`** (workflow) — one copy-paste block per template, in suggested order. Use this file for custom manifests or YAML-only workflows.

## Files

| File | Purpose |
|------|--------|
| `COPY-PASTE-PROMPTS.md` | **Main:** full prompts per page (copy fence to Cursor). |
| `page-manifest.template.yaml` | Blank manifest for custom pages or chat paste. |
| `inc/page-meta-definitions.php` | Source of truth for meta keys per template. |
| `HOMEPAGE-PIPELINE-DELIVERABLE.md` | Consolidated Homepage pipeline output (brief, meta keys, SEO, schema, polish). |

## Template inventory (starting point)

- `template-property.php`
- `template-accessibility.php`
- `template-enquire.php`
- `template-faq.php`
- `template-how-it-works.php`
- `template-who-its-for.php`
- `template-whitstable-guide.php`
- `template-resources.php`
- `template-contact.php`

Also treat `front-page.php`, `single.php`, and other templates as separate runs when needed.

## Suggested page order

1. Hubs: property, accessibility, how it works, enquire.
2. Supporting: who it’s for, resources, FAQ, Whitstable guide, contact.

Update `sibling_pages_for_seo` in each manifest as you finish pages so overlap checks stay accurate.

## Master prompt (custom pages)

Use **`COPY-PASTE-PROMPTS.md`** for standard templates. For a one-off page, paste a filled `page-manifest.template.yaml` and the **Process** block from any section of `COPY-PASTE-PROMPTS.md`.

Attach skills: copywriting, copy-editing, restwell-page-polish, seo-structure-architect, seo-authority-builder, seo-cannibalization-detector, seo-content-auditor, schema-markup, visual-frontend-audit. Optional: `VISUAL-FRONTEND-AUDIT.md`.

Skip **seo-audit** (site-wide) on every page unless you are running the optional site-wide block at the end of `COPY-PASTE-PROMPTS.md`.

## Done checklist (before moving to the next page)

- [ ] Copy brief accepted or pre-approved
- [ ] Meta-key table covers this template’s editable strings
- [ ] One clear H1; H2s make sense; internal links listed
- [ ] Schema decision recorded
- [ ] Polish notes match theme patterns
- [ ] Visual follow-up only if an artifact was provided (or run a **live URL** pass in the IDE browser instead of a static artifact)

## Run log

### Homepage (`front-page.php`) — 2026-04-03

- **Local URL:** http://restwell.local/
- **Content/SEO pipeline:** Brief + meta-key table + heading map + schema stance completed in chat; optional **WP admin** paste of Page Content Fields / Search & Social was not done in-repo (editors can align to the saved meta table when needed).
- **Live visual (IDE browser):** Navigated, accessibility snapshot, scroll pass, viewport screenshots (hero, mid-page, bottom CTA + footer). Single **H1** present; **H2** sections follow intro → who → property → why → bottom CTA; **H3** on cards and feature grid as expected.
- **Polish / `VISUAL-FRONTEND-AUDIT` alignment:** Section spacing and typography read coherent; primary/secondary CTA order is **See the property** then **Enquire about dates** in hero and closing band. Header **Enquire Now** remains global nav CTA (expected).
- **Placeholders:** Property block image and CTA background image may still be unset — acceptable until final media is attached (`property_image_id`, `cta_image_id`). Hero media may show real imagery locally.
- **Code changes:** None required from this pass.

### Homepage — consolidated plan (`Homepage pipeline plus visual`)

- **Repo deliverable:** [`HOMEPAGE-PIPELINE-DELIVERABLE.md`](HOMEPAGE-PIPELINE-DELIVERABLE.md) — refreshed brief, meta key inventory, SEO/sibling notes, schema stance, polish vs `template-property.php`.
- **Optional CMS:** Not performed in-repo; editors may paste into Page Content Fields / Search & Social when aligning copy to the deliverable.
- **Live URL:** http://restwell.local/ — IDE browser snapshot confirms one H1, hero and footer **See the property** before **Enquire about dates**, full heading list in accessibility tree. Viewport screenshot captured; page scroll in automated browser was a no-op (full structure still verified via snapshot).
- **Visual audit:** Spacing/typography/CTA hierarchy consistent with `VISUAL-FRONTEND-AUDIT.md` and restwell-page-polish; no code defects filed. Placeholders for property/CTA images remain acceptable.

### Homepage — audit follow-up plan (2026-04-03)

- **Mandatory theme code:** None. Audits ([`PAGE-RUNS.md`](PAGE-RUNS.md) entries above, [`HOMEPAGE-PIPELINE-DELIVERABLE.md`](HOMEPAGE-PIPELINE-DELIVERABLE.md)) did not require fixes; follow-up work is **optional** (CMS, copy via meta, NAP verification, manual QA, design-token alignment).
- **Documentation:** Editor checklists and **LodgingBusiness** field sources are in deliverable §§8–10. **WP-only steps** (upload images, paste Search & Social / Page Content Fields) are not performed in-repo.
- **Code (optional):** `front-page.php` literal hexes that match `tailwind.config.js` / `input.css` tokens were mapped to theme utilities (`deep-teal`, `soft-sand`, `sea-glass`, `warm-gold`, etc.); body-secondary `#3a5a63` left unchanged (no matching token).
- **Manual full-page scroll + responsive (optional):** IDE browser: navigate + snapshot OK; `browser_scroll` still mostly ineffective (e.g. ~23px then no further scroll). **Human check recommended:** full vertical scroll and breakpoints ~768px / ~390px. Tailwind rebuild (`npm run build` in `restwell-theme/`) run after token class changes.

## Optional two-phase runs (save tokens)

- **Phase A:** Steps 1–4 + meta table only.
- **Phase B:** Steps 5–9 using the saved meta table.
