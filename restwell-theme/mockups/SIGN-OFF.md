# Mockup design-system sign-off

Tickable checklist. Finish this before WordPress conversion / Tailwind teardown.

**Rule:** never hand-edit generated `*-concept.html` except for temporary review. Change `_build_mockups.py`, `shared.css`, or `shared.js`, then regenerate.

```bash
cd restwell-theme/mockups && python3 _build_mockups.py
# Serve from theme root so ../assets/images resolves (not from mockups/)
cd .. && python3 -m http.server 8765
# Open: http://localhost:8765/mockups/
```

---

## 0. Preconditions (fix first)

- [x] Bring homepage into `_build_mockups.py` `main()` (`interior=False`)
- [x] Regenerate writes `homepage-concept.html` from the builder
- [x] Move homepage gallery lightbox JS into `shared.js`
- [x] Align homepage mid-cta with helper (`mid-cta--plain` or document intentional photo variant in CSS)
- [x] Replace repeated `style=` in the builder with shared utility classes (patterns used 2+ times)

---

## 1. Regenerate

- [x] Run `python3 _build_mockups.py`
- [x] Confirm no hand-edited drift in concept HTML after regenerate

---

## 2. Structural checks

### Shared chrome

- [x] Header/footer only defined via `header()` / `footer()` in `_build_mockups.py`
- [x] No duplicate chrome blocks inside page bodies
- [x] Every `*-concept.html` includes `shared.css`, `shared.js`, `site-header`, `site-footer`
- [x] No page-local nav / FAQ / solidify scripts (only `shared.js`)
- [x] Active nav: `aria-current="page"` / `is-active` set via builder `active` key

### Shared bands

- [ ] Heroes cover three patterns: homepage hero (full-bleed + CTAs), interior `hero()` (`.hero--interior` — including property), policy/legal hero (same interior helper — privacy, terms, a11y-policy, and similar long-copy pages)
- [ ] Marketing pages that end with enquire use `mid_cta()` (see exemptions below)
- [ ] FAQ blocks use `faq_item()`
- [ ] Body sections use `.section-y` + `.band-*` (see allowed non-band namespaces below)
- [ ] Multi-section pages use `.section-head` (+ `.eyebrow` / `.lede`) — except FAQ intro (see below)
- [ ] Primary CTAs use `.btn*` (`.btn-gold`, `.btn-outline-*`, etc.); `.text-link` allowed for secondary links
- [ ] Spacing follows the system in `shared.css` (see **Spacing system** below) — `--space-*` / roles / component tokens only; no new raw padding/margin/gap rem in components; HTML has no `u-mt-*` space-step classes
- [ ] Type follows the system in `shared.css` (see **Type system** below) — roles / `--text-*` only; no new raw `font-size` rem in components
- [ ] Prefer zero `style=` in bodies; any leftovers listed and justified

**Mid-cta exempt:** enquire, privacy, terms, a11y-policy, 404, mockup index. Guest guide, blog, and blog-single: no mid-cta (primary actions already on-page — OTP/unlock, empty-state CTA, related posts + nav Enquire). Resources: ends with `band-teal` enquire CTAs (paperwork + conversation in one close).

**Exempt from section-head:** none currently required for resources (uses section-head + subnav like pricing). FAQ bands may use `.faq__intro` instead of `.section-head` (two-column FAQ layout on home / pricing / how-it-works).

**Allowed non-band namespaces:** homepage `.*` section classes (e.g. `.property`, `.gallery`, `.paths`) that still use `.section-y` / `.section-head`, plus shared `.care`.

### Type system

Canonical definition lives at the top of `shared.css` (beside spacing). Rules:

1. **Primitives** (`--text-2xs`…`--text-4xl`) — fixed size scale. Never invent new rem literals in components.
2. **Leading / weight** (`--leading-*`, `--weight-*`) — shared copy rhythm.
3. **Roles** (`--type-body-*`, `--type-lede-*`, `--type-eyebrow-*`, `--type-ui-*`, `--type-meta-size`, `--type-h1/h2/h3`, `--type-display*`) — what base elements and components consume. Prefer a role when the meaning matches.
4. **Base wiring** — `body`, `h1–h3`, `.eyebrow`, `.lede`, `.text-link`, `.btn` read roles only. Inline `.text-link` uses tight `text-decoration` underline (not a tall `border-bottom` box).
5. **Components** — `font-size: var(--text-*)` or a local token pointing at the scale (`--process-index-size: var(--text-4xl)`). Relative `em` on separators is OK.

### Spacing system

Canonical definition lives at the top of `shared.css`. Rules:

1. **Primitives** (`--space-1`…`--space-20`) — fixed 4px grid. Use for component gaps/pads. Never remap in `@media`. Never invent off-grid rem (`0.65rem`, `1.1rem`) — pick the nearest step.
2. **Rhythm ladder** (`--rhythm-*-0`…`3`, plus `*-dense`) — page-structure values. Edit numbers only here.
3. **Semantic roles** (`--section-y*`, `--section-after-head`, `--section-stack-gap`, `--section-head-gap`, `--grid-gap`, `--panel-pad`, `--rw-gutter-x`, `--hero-pad-*`, `--hero-*-gap`) — what CSS consumes. Point at ladder steps.
4. **Component tokens** — define `--component-*` on the component root; consume via `gap` / `padding` / `margin`. In `@media`, remap the token (`--split-gap: var(--space-10)`), never sprinkle `padding-block: 2rem`.
5. **Density** — `body.page--interior` remaps roles to denser steps below `md`, then rejoins the shared ladder at `768px` / `1024px`.
6. **Breakpoints (spacing only):** default `<640` · `sm ≥640` · `md ≥768` · `lg ≥1024`. Column breaks (`700` / `900` / etc.) are layout, not spacing steps.
7. **HTML:** `.section-y` / `--compact` / `--cta` + `.section-head*` + sibling follow-ons (or `.section-follow` if a pair is missing). Never a space-step class (`u-mt-8`). Page-structure gaps consume `--section-stack-gap` so they remap with the ladder.
8. **Allowed non-scale:** `0` / `auto`, hairline `±1px`, relative `em` tied to type, safe-area `env()`, and layout measures (`min()`, `svh`, radii, icon boxes).

```css
/* ✅ token remap */  .split { --split-gap: var(--space-5); gap: var(--split-gap); }
/* ✅ in media */     @media (min-width: 900px) { .split { --split-gap: var(--space-10); } }
/* ❌ property override */ @media (min-width: 900px) { .split { gap: 2.5rem; } }
```

### Interaction wiring

- [ ] FAQ pages have `[data-faq-accordion]`
- [ ] FAQ category pills use `[data-faq-filters]`
- [ ] Header markup matches `shared.js` selectors (`.nav__trigger`, `#mobile-nav`, `.nav-toggle`, `.site-header`)
- [ ] Gallery lightbox comes from `shared.js` (homepage, property, accessibility — no page-local script)

### Grep audit (after regenerate)

```bash
rg -L "site-header|site-footer|shared\\.css|shared\\.js" restwell-theme/mockups/*-concept.html
rg -n "def header|def footer|def hero|def mid_cta|def faq_item" restwell-theme/mockups/_build_mockups.py
rg -n "<style|<script" restwell-theme/mockups/*-concept.html
```

- [ ] Chrome grep clean (no missing files)
- [ ] Helpers still defined in builder
- [ ] No unexpected `<style>` / `<script>` in generated HTML (lightbox must not be inline)

---

## 3. Page section-order audits

For each page: one job per section · intentional band rhythm · stable anchors · clear end CTA · no hero clutter.

**Pass = desktop + responsive.** A page is only **Pass / finalised** when section-order is good **and** it has been checked at **375 · 768 · 1024 · 1280** (no horizontal scroll, hero/header clear, bands stack, CTAs usable, key interactions work on touch widths). Use **Fix** if any breakpoint fails.

### Design constraints (homepage + marketing surfaces)

Leave-list from credibility critique — do not regress:

- [ ] No seasonal or detached hero badges / chips
- [ ] No “Book” / “Check availability” language on marketing CTAs (enquire / view property / access statement)
- [ ] No Unsplash or non-Restwell hero / gallery imagery — local `assets/images/bungalow/` or `stock/` only
- [ ] No icon-placeholder partner grids — real partner logos only
- [ ] No generic hotel value pillars (space / privacy / comforts without access differentiation)
- [ ] Path cards OK (two next steps); speech-bubble or heavy panel testimonial cards not — plain quote + attribution
- [ ] Single-property framing only — no multi-property “find the house”

### Client ready bar (reference pages)

These four are the visual standard. Bring other concepts up to them — not “polished in place.”

- Homepage (marketing exception)
- Property
- Pricing
- Optional care (interior template with Pricing)

### Priority

Format: **Pass** only if design + **375 / 768 / 1024 / 1280** all good. Note Fix + breakpoint if not.

- [x] Homepage — Pass · R: Pass
- [x] Property — Pass · R: Pass (390 / 768 / 1024 / 1280; photo room splits, gallery, light care trust row, location; SEO H1)
- [x] Pricing — Pass · R: Pass
- [x] Optional care — Pass · R: Pass

### Next

- [x] How it works — Pass · R: Pass (390 / 768 / 1024 / 1280; subnav, process/arrival/care, no middot dividers, mobile step spacing)
  - **Intentional redesign:** vertical numbered-list process layout replaces the live 4-col Tailwind card grid (`template-parts/how-it-works-steps.php`). That template-part will be **replaced**, not ported.
- [x] Accessibility — Pass · R: Pass (375 / 768 / 1024 / 1280; hero, spec table, gallery lightbox, mid-cta)
- [x] Who it’s for — Pass · R: Pass (375 / 768 / 1024 / 1280; hero, condition groups, care path, mid-cta)
- [x] Whitstable — Pass · R: Pass (375 / 768 / 1024 / 1280; hero--place, area cards, tips, mid-cta)
- [x] Resources — Pass · R: Pass (375 / 768 / 1024 / 1280; subnav, routes, directory, FAQ before band-teal close)
  - **Section order fix applied:** FAQ (`#faq`) now precedes band-teal paperwork CTA (`#help`) to match spec. Subnav reordered to match.
- [x] FAQ — Pass · R: Pass (375 / 768 / 1024 / 1280; accordion, filter pills, ask-a-question form visual)
- [x] Enquire — Pass · R: Pass (375 / 768 / 1024 / 1280; form layout, mid-cta exempt)

### Homepage trust-strip note

The live `template-parts/trust-strip.php` (homepage-only) is covered by the homepage `.care` section in the mockup — same content (care is optional, Continuity of Care Services, CQC) rendered in a richer consolidated layout. The `.care` section is an intentional redesign that absorbs the trust-strip. `template-parts/trust-strip.php` will be **replaced**, not ported separately.

### Later

- [x] Blog — Pass · R: Pass (375 / 768 / 1024 / 1280; post grid, empty state, no mid-cta per spec)
- [x] Blog single — Pass · R: Pass (375 / 768 / 1024 / 1280; hero, body, related posts, no mid-cta per spec)
- [x] Guest guide — Pass · R: Pass (375 / 768 / 1024 / 1280; OTP gate visual, guide content, no mid-cta per spec)
- [x] Privacy — Pass · R: Pass (375 / 768 / 1024 / 1280; legal layout, section structure)
- [x] Terms — Pass · R: Pass (375 / 768 / 1024 / 1280; legal layout, section structure)
- [x] Accessibility policy — Pass · R: Pass (375 / 768 / 1024 / 1280; legal layout, section structure)
- [x] 404 — Pass · R: Pass (375 / 768 / 1024 / 1280; error message, nav links)
- [x] Generic page — Pass · R: Pass (375 / 768 / 1024 / 1280; interior hero, body content)

---

## 4. Responsive QA (375 / 768 / 1024 / 1280)

Server: `http://localhost:8765`

### All pages / chrome

- [ ] 375 — sticky/solid header, logo, Enquire, no horizontal scroll
- [ ] 768 — same
- [ ] 1024 — same
- [ ] 1280 — same

### Mobile nav

- [ ] Open / close
- [ ] Focus usable
- [ ] Group labels readable
- [ ] Enquire in panel works

### Desktop nav

- [ ] “The Bungalow” dropdown open / close
- [ ] Click-outside closes
- [ ] Keyboard + `aria-expanded` correct

### Heroes

- [ ] Interior hero: crumbs + eyebrow + h1 + lede; padding clears header
- [ ] Homepage hero: full-bleed; CTAs usable; no overlay clutter

### Long pages

- [ ] Pricing: tables/cards stack; anchors reachable (all four widths)
- [ ] Property: room sections + gallery; lightbox on touch (all four widths)
- [ ] FAQ: accordion + filter pills; one open at a time (all four widths)

---

## 5. Interaction QA (`shared.js`)

Test on homepage + FAQ + one interior page + pricing:

- [ ] FAQ: only one item open; `hidden` / `aria-expanded` correct
- [ ] FAQ filters (faq page): show/hide by `data-cat`
- [ ] Desktop dropdown: toggle, escape/outside close
- [ ] Mobile nav: toggle (close on navigate if implemented)
- [ ] Header solidify: interior starts solid; homepage solidifies past hero
- [ ] Gallery lightbox: open / close / focus / Esc

---

## 6. Sign-off gate (before WordPress)

- [ ] Homepage generated from the builder like every other page
- [ ] Structural greps clean
- [ ] Every public page has Pass on section-order audit
- [ ] Responsive matrix done on home, property, pricing, FAQ, enquire at all four widths
- [ ] Interaction checklist green
- [ ] Design tokens/components only in `shared.css`; behaviour only in `shared.js`

**When all ticked:** port `shared.css` / `shared.js` → WP `header.php` / `footer.php` + template-parts (`interior-hero`, `section-head`, `mid-cta`, `faq-list`) → page templates from `body_*()`. No Tailwind for these surfaces.
