# Spacing system follow-ups

## Goal

Close the gaps between the token-first spacing system and remaining hardcoded or ad-hoc vertical spacing so rhythm stays consistent and documented.

## Tasks

- [ ] **Tokenize `.section-label` and `.section-heading` margins** — In `restwell-theme/assets/css/input.css`, replace `margin-bottom: 0.75rem` / `1.5rem` with `var(--space-3)` and `var(--space-6)`. → Verify: grep those selectors; no raw `rem` margins on those rules.

- [ ] **Document `rw-gap-grid` vs `rw-gap-grid-lg`** — Add 1–2 sentences under **Grids and gutters** in `restwell-theme/DESIGN-SYSTEM.md` (why the lg variant skips `--rw-grid-gap-md`). → Verify: doc mentions both classes and when to use each.

- [ ] **Decide on title-margin vs section `sm` tier** — Either add a short note in `DESIGN-SYSTEM.md` that `.rw-section-head` / `.rw-mb-section` step only at `md`/`lg` on purpose, or add a `@media (min-width: 640px)` token step for `--rw-section-after-head*` if you want lockstep with section padding. → Verify: decision is written down; code matches the decision.

- [ ] **Migrate stray section `py-*` shells** — Replace `py-10 md:py-12` (Whitstable guide), `py-16` (blog index empty/block), `py-12` (property empty state) with `rw-section-y` / `rw-section-y--compact` or the documented inner-padding pattern. → Verify: those files no longer use those raw `py-*` for section-level rhythm; visual check on those templates.

- [ ] **Optional: clarify micro-layout in the doc** — One paragraph in `DESIGN-SYSTEM.md`: tables/dense UI may keep arbitrary `py-*` / pixel values; section shells and editorial stacks stay token-first. → Verify: paragraph exists; examples match team intent.

## Done When

- [ ] Label/heading margins use spacing tokens.
- [ ] Grid gap utilities are documented (including the lg ladder).
- [ ] Title-to-content spacing policy is explicit (two breakpoints vs four).
- [ ] Known template drift cases use `rw-section-y*` (or documented exception).

## Notes

- Rebuild Tailwind output if your workflow compiles `input.css` → `tailwind.css` after CSS edits.
- Scope this pass to the files already called out; a full-repo `py-*` audit can be a separate task.
