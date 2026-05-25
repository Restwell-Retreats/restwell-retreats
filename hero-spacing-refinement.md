# Hero spacing refinement (mobile + rhythm)

## Goal

Apply the visual audit **quick wins**: consistent vertical rhythm inside the hero copy stack, slightly wider mobile gutters, and verified alignment with the header—without changing brand or photography treatment.

## Skills glossary reference

Invoke via **`/{folder-name}`** in Agent chat (see **`SKILLS_GLOSSARY.md`** — *How to reference skills in chat*). Curated rows below are copied from  
`/Users/elliesmith/Developer/Projects/FINALCTAIHOPE/cta-wp-theme/docs/SKILLS_GLOSSARY.md` (879 skills total; this plan uses a **subset** relevant to Restwell hero work).

| Slash | Use on this plan |
|--------|-------------------|
| `/plan-writing` | Structured breakdowns, dependencies, verification criteria (this document). |
| `/visual-frontend-audit` | Before/after aesthetic + spacing audit (screenshots, Gestalt, layout rhythm). |
| `/frontend-design` | Distinctive, production-grade UI craft when tuning hero spacing and hierarchy. |
| `/ui-skills` | Opinionated interface constraints while editing layout. |
| `/ui-ux-designer` | Design tokens, inclusive spacing, user-centered layout checks. |
| `/ui-ux-pro-max` | Optional: spacing, typography, responsive, accessibility topics in one pass. |
| `/tailwind-design-system` | Tailwind + design tokens + responsive patterns for `input.css` / utilities. |
| `/php-pro` | Idiomatic PHP when touching `front-page.php`. |
| `/wordpress-theme-classic-meta` | WordPress theme patterns (templates, meta, classic-style theme structure). |
| `/page-cro` | Homepage / hero CTA clarity and conversion-oriented spacing (diagnosis, not blind tweaks). |
| `/wcag-audit-patterns` | WCAG 2.2 checks after changing tap targets, contrast, or focus rings. |
| `/web-design-guidelines` | Review UI/UX against web interface guidelines post-change. |
| `/ui-visual-validator` | Screenshot / visual regression style verification that edits hit intent. |

**Not in glossary:** project-local **`/restwell-page-polish`** (`.cursor/skills/restwell-page-polish/`) — use for full Restwell template + SEO + a11y polish if scope expands beyond hero spacing.

## Tasks

- [x] **Unify the text stack** — Refactor `restwell-theme/front-page.php` hero so eyebrow + title + `#home-hero-lede` live in one wrapper using **flex + `gap`** (tokens: e.g. `var(--space-5)`), removing mixed `space-y-*` + eyebrow `mb-*` where redundant. Add supporting rules under `.hero.home-hero` in `restwell-theme/assets/css/input.css`. *Skills:* `/php-pro`, `/tailwind-design-system`, `/frontend-design`, `/ui-skills`. → Verify: DevTools shows equal steps between eyebrow / H1 / lede; no double margins.

- [x] **Widen mobile hero gutters** — In `input.css`, for `max-width: 639px` (or scoped `.hero.home-hero .relative.container`), set horizontal padding to **`max(var(--space-6), env(safe-area-inset-*))`** left/right. *Skills:* `/tailwind-design-system`, `/visual-frontend-audit`. → Verify: 375px viewport, text inset matches intent; safe-area on notched devices OK.

- [x] **Reconcile CTA cluster** — Confirm `.home-hero__copy { gap: var(--space-6) }` stays **larger** than `.home-hero__cta-stack { gap: var(--space-3) }`; adjust if the unified text stack changes density. *Skills:* `/page-cro`, `/ui-ux-designer`. → Verify: Primary + secondary read as one pair; clear pause after lede.

- [x] **Compile CSS** — From `restwell-theme/`: `npx tailwindcss -i ./assets/css/input.css -o ./assets/css/tailwind.css --minify`. *Skills:* `/tailwind-design-system`. → Verify: build succeeds; `tailwind.css` updated.

- [ ] **Browser pass** — 375 / 390 / 414 widths: header vs hero alignment; no overflow. *Skills:* `/web-design-guidelines`, `/wcag-audit-patterns`, `/ui-visual-validator`, optional `/visual-frontend-audit`. → Verify: screenshots or device check OK.

## Done When

- [x] Inner hero stack uses **one spacing system** (flex `gap` or documented tokens), not competing utilities.
- [x] Mobile hero horizontal inset is **at least `--space-6`** from viewport (plus safe-area).
- [ ] `tailwind.css` rebuilt and **homepage hero** looks balanced on a phone or responsive mode.

## Notes

- Optional: shorter `min-height` on small **height** viewports if content sits too low; document `--hero-*` in `restwell-theme/DESIGN-SYSTEM.md` if you add tokens.
- Full glossary path (local clone): `cta-wp-theme/docs/SKILLS_GLOSSARY.md`.
