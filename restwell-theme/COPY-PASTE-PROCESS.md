# COPY-PASTE page pipeline (workflow)

**Scope:** How to run template-level SEO/copy passes. Per-page manifests live in [COPY-PASTE-PROMPTS.md](COPY-PASTE-PROMPTS.md).

**Strategy + scoreboard (read first):** [SEO-INTENT-ONPAGE-PLAN.md](SEO-INTENT-ONPAGE-PLAN.md) · [SEO-PROGRESS-MATRIX.md](SEO-PROGRESS-MATRIX.md)

**Skills:** Invoke via **`/skill-name`** only — see [SKILLS_GLOSSARY.md](SKILLS_GLOSSARY.md). Do not paste absolute skill paths into chats.

**Paths:** `@restwell-theme/` = this theme folder.

---

## How to run

1. Work **top to bottom** in [COPY-PASTE-PROMPTS.md](COPY-PASTE-PROMPTS.md).
2. For each page, copy the fenced block into a new Cursor chat.
3. **`@` every Context line** plus [COPY-PASTE-PROCESS.md](COPY-PASTE-PROCESS.md) (this file).
4. Execute **§Page pipeline** below unless the manifest specifies **§Guest guide pipeline** or **§Process overrides**.

**Optional two-phase runs:** Phase A = steps 1–4 + meta table; Phase B = steps 5–9 using saved meta table.

---

## Post-run sync (required)

After each template run:

1. Map outputs to P4 steps **A–G** (keywords → published/verified).
2. Append or update the URL row in **SEO-INTENT-ONPAGE-PLAN.md §13.1**.
3. Update **SEO-PROGRESS-MATRIX.md** symbols for that URL (A–G column).
4. Do **not** treat COPY-PASTE completion as done until the matrix reflects it.

---

## Template coverage

| File | Purpose |
|------|---------|
| [COPY-PASTE-PROCESS.md](COPY-PASTE-PROCESS.md) | **This file** — workflow, sync rules, shared process block |
| [COPY-PASTE-PROMPTS.md](COPY-PASTE-PROMPTS.md) | Per-page manifests (copy into chat) |
| `page-manifest.template.yaml` | Blank manifest for custom pages |
| `inc/page-meta-definitions.php` | Meta keys per template |
| Homepage field/schema reference | SSOT **§13.1 Home preset** |

**Templates:** `front-page.php`, `template-property.php`, `template-accessibility.php`, `template-enquire.php`, `template-faq.php`, `template-how-it-works.php`, `template-who-its-for.php`, `template-whitstable-guide.php`, `template-resources.php`, `template-contact.php`; also `single.php`, `page-guest-guide.php` as separate runs.

**Suggested order:** Hubs (property, accessibility, how it works, enquire) → supporting (who it's for, resources, FAQ, Whitstable guide, contact). Update `sibling_pages_for_seo` in each manifest as you finish pages.

**Done checklist (before next page):** Copy brief accepted · meta-key table complete · one H1 + sensible H2s · internal links listed · schema decision recorded · polish notes match theme · matrix write-back done.

---

## Work order (suggested)

1. Homepage — `front-page.php`
2. Property — `template-property.php`
3. Accessibility — `template-accessibility.php`
4. How it works — `template-how-it-works.php`
5. Enquire — `template-enquire.php`
6. Who it's for — `template-who-its-for.php`
7. Resources — `template-resources.php`
8. FAQ — `template-faq.php`
9. Whitstable guide — `template-whitstable-guide.php`
10. Contact — `template-contact.php`
11. (Optional) Guest guide — `page-guest-guide.php`

---

## Page pipeline (steps 1–9)

Include this block by reference from each manifest (`@restwell-theme/COPY-PASTE-PROCESS.md`). Execute in order; brief plan first, then deliver.

```
## Process (execute in order; brief plan first, then deliver)
1. /copywriting — Copy Brief Summary + assumptions. If brief_pre_approved is false, STOP after the brief unless I say continue.
2. /copy-editing — Polish the draft.
3. /seo-meta-optimizer /wordpress-theme-classic-meta — Copy deck keyed to post meta keys (table: key → proposed copy → factual/legal risk note if any).
4. /seo-structure-architect — H1–H3, internal links, jumps.
5. /seo-cannibalization-detector — only if sibling_pages_for_seo is non-empty.
6. /seo-content-auditor + /seo-authority-builder — gaps + E-E-A-T in one pass.
7. /schema-markup — eligibility + minimal JSON-LD OR explicit "do not implement".
8. /restwell-page-polish — implementation notes (tokens from @restwell-theme/assets/css/input.css, sections, escaping).
9. /visual-frontend-audit — only if artifact_for_visual is not none; align with @restwell-theme/VISUAL-FRONTEND-AUDIT.md when relevant.

Constraints: work only under @restwell-theme ; no fabricated proof; escape all output; no inline script/style.

## Output format
1) Plan 2) Brief (if needed) 3) Meta-key table 4) SEO 5) Schema 6) Polish checklist 7) Visual (if any)
```

Apply any **§Process overrides** from the page manifest after loading this block.

---

## Guest guide pipeline (operational)

For `page-guest-guide.php` only — not public SEO.

```
## Process
1. /copy-editing — clarity, scannability, consistency.
2. /restwell-page-polish — layout/accessibility of blocks only; no marketing fluff.
3. Do NOT invent policies, numbers, or WiFi credentials; flag placeholders.

Constraints: @restwell-theme only; escape output; treat sensitive fields as sensitive.

## Output format
1) Edited copy table by meta key 2) List of items needing human verification 3) Polish notes
```

---

## Visual pass (any page)

**Context:** `@restwell-theme/VISUAL-FRONTEND-AUDIT.md` + relevant template

```
Run /visual-frontend-audit only for this page.

Page URL: PASTE_URL
Template: @restwell-theme/PASTE_TEMPLATE_FILE.php

Check against @restwell-theme/VISUAL-FRONTEND-AUDIT.md and /restwell-page-polish patterns. Output: severity-tagged issues, concrete fixes (classes/tokens), and quick wins.
```

---

## Site-wide SEO audit (optional)

```
Run /seo-audit scope: site-wide Restwell theme.

Constraints: Evidence-based; no implementation unless I ask. Reference @restwell-theme/ templates and @restwell-theme/inc/seo*.php only as needed.

Output: prioritized findings, SEO Health Index per seo-audit skill, and action list.
```
