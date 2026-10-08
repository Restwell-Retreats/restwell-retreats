# Restwell Theme - Design System Notes

Short reference for typography, spacing, line length and contrast. The source of truth is the `:root` block and the governance comments at the top of `assets/css/shared.css`; this page summarises it. Rewritten 2 October 2026 (audit I41): the earlier version described `input.css` and `rw-section-y*` utilities, neither of which exists any more.

## Stylesheets

| File | Role |
|------|------|
| `assets/css/fonts.css` | Self-hosted Inter and Lora variable fonts (`font-display: swap`). |
| `assets/css/shared.css` | The design system: tokens, base elements, components, page sections. |
| `assets/css/shared-wp.css` | WordPress-specific glue (admin bar, core block output). |
| `assets/css/polish.css` | Small refinements layered after `shared.css`. |
| `assets/css/site.min.css` | **Built file.** The four above, concatenated in that order and minified by `tools/build-css.sh`. Production enqueues only this; `SCRIPT_DEBUG` loads the four sources. `tests/CssBundleTest.php` fails when it is stale, so run the build after any CSS edit. |

Tailwind is **not** loaded. Utility class names such as `pt-8`, `border-t` or `text-gray-600` in markup do nothing; use the components and tokens below.

## Typography

- **Families:** Inter for body and UI, Lora (semibold, never bold) for headings and display.
- **Size primitives:** `--text-2xs` (0.75rem) to `--text-3xl`. Body is `--text-base` (1.0625rem, 17px). Never render text below 0.75rem (12px).
- **Roles:** prefer `--type-body-*`, `--type-lede-*`, `--type-eyebrow-*`, `--type-ui-*`, `--type-meta-size` over raw primitives.
- **Headings:** `--type-h1`, `--type-h2`, `--type-h3` are rem + vw clamps (pure vw can fail WCAG 1.4.4). One H1 per page; no skipped levels.
- **Eyebrows:** `.eyebrow` (gold text, uppercase, `--type-eyebrow-tracking`); `.eyebrow--on-dark` on teal bands. Interior heroes all print one (`hero_eyebrow` meta, falling back to the page's section name).

### Line length

`--measure-text: 38rem` keeps running text at about 70–75 characters of Inter. It is in **rem**, not `ch` or `em`: `ch` is the width of "0" (wider than an average letter, so `70ch` ran ~88 characters), and `em` resolved differently in every element, which is how the site ended up with 34, 35, 36, 40 and 48rem measures side by side. `--rw-readable` and `--rw-measure-care` use the same 38rem. Do not introduce another prose width.

It is applied to `.prose` and `.prose--wide` text children, `.section-head .lede`, and the long component notes listed at the end of `shared.css`. Tables and figures inside `.prose--wide` may still use the full 44rem column.

Body copy is left-aligned. Centre only short CTA bands and `.section-head--center` titles, never a multi-line paragraph.

## Spacing system

Token-first and mobile-first. The layers are documented at the top of `shared.css`, and `tools/_check_spacing.py` enforces the governance (every `--rhythm-*` token justified, components consume tokens not literals, media queries remap tokens not properties).

1. **Primitives** `--space-1` (0.25rem) … `--space-20` (5rem): a fixed 4px grid for gaps, control padding and icons. Never remapped in media queries.
2. **Rhythm ladder** `--rhythm-*-0…3`: page-structure steps for default (<640), `sm` ≥640, `md` ≥768 and `lg` ≥1024. Edit values here only.
3. **Semantic roles**, which alias the active ladder step: `--section-y`, `--section-y-compact`, `--section-y-cta`, `--section-y-lead`, `--section-after-head`, `--section-head-gap`, `--section-stack-gap`, `--grid-gap`, `--panel-pad`, `--rw-gutter-x`, `--hero-*`.
4. **Component tokens**, defined on a component root (e.g. `--split-gap`, `--link-list-gap`).
5. **Density contexts:** `body.page--interior` points roles at denser steps on phones, then rejoins the ladder at `md`.

### Section classes

| Class | Use |
|-------|-----|
| `.section-y` | Default content band (`padding-block: var(--section-y)`). |
| `.section-y--compact` | Shorter bands: related links, further reading, FAQ footers. |
| `.section-y--cta` | Conversion bands, which take a little more air than body sections. |
| `.band-white`, `.band-subtle`, `.band-teal` | Band backgrounds; pair with one `.section-y*` class. |
| `.container`, `.container--sm`, `.container--md` | Page rail: max `--rw-max-page` (1200px), side padding `--rw-gutter-x` (24px on phones, fluid to 40px). |
| `.section-head`, `.section-head--tight`, `.section-head--center` | Eyebrow + heading + lede cluster, with gaps from `--section-head-gap` and `--section-after-head`. |
| `.section-follow` | A block that follows a section head, picking up the after-head step. |

Sibling rules already manage the top padding after a hero or a sticky subnav (`.hero + .section-y`, `.subnav + .section-y`), so don't add margin to compensate.

### Links and lists

- `.text-link` for inline calls to action, and `.link-list` for stacked related links (serif, hairline separators). `template-parts/related-guides.php`, `post-cluster-links.php` and `pricing-cross-links.php` all use `.link-list`.
- Inline links inside `.prose--wide` get a 44px minimum tap height (WCAG 2.5.8).

## Cards and panels

- A card is a white (or soft sand) surface, a `1px` hairline border in `--deep-teal` at ~10%, `--radius-lg`, and at most the faint shadow `0 8px 30px rgb(0 0 0 / 0.04)`.
- **No single-edge accent borders.** No `border-top`, `border-left` or `border-bottom` in a thick colour on one side of a card, callout or panel. With a radius they draw a crescent that curls round the corners, and they read as generated UI. Say what a card is with a marker (icon tile, tick, tinted circle), a heading or a tint, not a coloured edge. (Hairline dividers between rows, chevron arrows and the blog table-of-contents rail are fine.)

## Images

- Theme images go through `restwell_theme_image_url()`, which serves `assets/images/**/opt/<name>.webp`.
- `tools/generate-opt-webp.sh` builds those Opt files plus width variants (`<name>-480w`, `-800w`, `-1200w`, `-1920w`, and 160/320 for partner badges; never upscaled).
- `inc/responsive-images.php` adds `srcset` and `sizes` to every `<img>` printed by URL. Give an `<img>` an explicit `sizes` attribute when the layout is known (the logo, mosaics, small badges); otherwise heroes get `100vw` and lazy images get `sizes="auto, …"`.
- Every content image needs `alt` (empty for decorative), `width` and `height`.

## Interactive states

- **Focus:** a visible `:focus-visible` ring in `--deep-teal` (≥3:1 on white and sand). Never `outline: none` without a replacement.
- **Targets:** buttons, nav, FAQ summaries and footer links are ≥44px (`--tap-target`, 2.75rem; 2.25rem in the dense desktop footer).
- **Motion:** respect `prefers-reduced-motion` for anything non-essential.

## Copy standards

All default fallback strings in PHP templates follow the house rules:

- No em dashes (`—`) and no spaced hyphens used as dashes; use colons, commas or full stops.
- No "not X, it's Y" constructions; say what the thing is.
- No filler phrases ("in order to", "it's important to note").
- Headings carry the section's keyword or audience signal; never clever at the expense of clarity.
- Never "fully accessible" in Restwell's own voice (see `copy-overwrites/` and the voice notes).

Canonical page copy lives in `copy-overwrites/*.md`; SEO lane ownership lives in `docs/seo/LANES.md`.

## Customer journey (content alignment)

Content and placement follow the respite-care customer journey in the project root `respite_care_guide.md`: Awareness → Consideration → Enquiry → Decision → Booking/Stay → Post-stay. The homepage carries empathy and the headline promise, the property and accessibility pages carry evidence, and Enquire carries reassurance.
