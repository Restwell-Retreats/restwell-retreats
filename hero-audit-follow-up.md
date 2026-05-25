# Hero audit follow-up (mobile rhythm, alignment, a11y)

## Goal

Close the gaps from the **combined screenshot audit** (visual + UI validator + Web Interface Guidelines themes): reliable **mobile gutters** and **header↔hero axis alignment**, **even vertical rhythm** (including lede→CTA), **intentional** secondary CTA treatment across breakpoints, **accessible** menu/CTAs (labels, focus, contrast), and a **logged-out** verification pass.

**Glossary:** invoke skills via **`/{folder-name}`** — see  
`/Users/elliesmith/Developer/Projects/FINALCTAIHOPE/cta-wp-theme/docs/SKILLS_GLOSSARY.md` (879 skills).

| Area | Skills to use |
|------|----------------|
| Layout & tokens | `/tailwind-design-system`, `/ui-ux-designer`, `/frontend-design` |
| WordPress templates / meta | `/php-pro`, `/wordpress-theme-classic-meta` |
| CTAs & conversion | `/page-cro` |
| Accessibility | `/wcag-audit-patterns`, `/accessibility-compliance-accessibility-audit` |
| Verification | `/visual-frontend-audit`, `/ui-visual-validator`, `/web-design-guidelines` |
| Images / LCP (if touching hero img attrs) | `/web-performance-optimization` |
| **Project-only (not in glossary):** full Restwell polish | `/restwell-page-polish` (`.cursor/skills/restwell-page-polish/`) |

## Tasks

- [x] **Trace grid on mobile** — In DevTools at **375px**, compare computed **left inset** of site header logo block vs hero copy block (`front-page.php` hero + header partial). Document whether mismatch is from `.container`, safe-area, or nested wrappers. → Verify: overlay or measure shows **same token** or a **documented intentional offset**. *Skills:* `/tailwind-design-system`, `/ui-ux-designer`. **Finding (code):** `@media (max-width: 768px) { .container { padding: 0 1rem; } }` forced **16px** gutters and dropped `max(..., safe-area)`; header used **1rem** while home hero (≤639px) used **`--space-6` (1.5rem)** — misaligned rails. See comment block above that rule in `input.css`.

- [x] **Fix hero horizontal inset** — Adjust `restwell-theme/assets/css/input.css` (and only templates if structure blocks padding) so **≤639px** hero content matches the audit target: **shared gutter** with header, **`max(var(--space-6), env(safe-area-inset-*))`** (or stronger if design chooses `--space-8` after review). Re-check **no double negative margins** on inner wrappers. → Verify: 375px logged-out screenshot: copy block not flush to edge; matches header axis. *Skills:* `/tailwind-design-system`, `/frontend-design`. **Done:** Replaced the 1rem shorthand with **`padding-left/right: max(var(--space-6), env(safe-area-inset-*))`** on `.container` for that breakpoint (no `padding` shorthand).

- [x] **Tighten vertical rhythm (lede → CTAs)** — Reduce the **oversized** gap between lede and primary CTA on small viewports without crushing desktop: target **one modular scale** (e.g. keep `.home-hero__text-stack` gap; tune **margin-top** on `.home-hero__cta-stack` or `.home-hero__copy` `gap` at `max-width: 639px` only). → Verify: eyebrow→H1→lede→CTA steps feel **even**; primary+secondary still read as a **pair** (`/page-cro`). *Skills:* `/page-cro`, `/ui-ux-designer`. **Done:** At `max-width: 639px`, `.hero.home-hero .home-hero__copy { gap: var(--space-5); }` (desktop unchanged at `space-6`).

- [ ] **Decide secondary CTA cross-breakpoint** — Either **document** “link on mobile / ghost pill on desktop” in `DESIGN-SYSTEM.md` (or comment in `input.css`) **or** unify to one component variant for parity. → Verify: written decision; both breakpoints match it. *Skills:* `/page-cro`, `/core-components`.

- [ ] **Secondary CTA contrast on photo** — If mobile stays underline-style, add **insurance** for WCAG: stronger local overlay, subtle **text-shadow**, or **ghost chip** on narrow only. → Verify: contrast check on lightest patch of beach/sky (automated tool or manual); logged-out mobile screenshot. *Skills:* `/wcag-audit-patterns`, `/accessibility-compliance-accessibility-audit`.

- [ ] **Header menu a11y (guidelines)** — Ensure mobile **hamburger** has **`aria-label`** (and `aria-expanded` if toggling), interactive elements have **`focus-visible`** styles (no bare `outline-none`). Touch target **≥44×44px**; **`touch-action: manipulation`** where the guidelines call for it. → Verify: keyboard Tab to menu; screen reader name; no focus loss; tap target feels comfortable. *Skills:* `/web-design-guidelines`, `/wcag-audit-patterns`, `/php-pro`, `/wordpress-theme-classic-meta`, `/screen-reader-testing` (optional deep pass).

- [ ] **Hero image attributes (optional but recommended)** — If hero `<img>` lacks **width/height** or LCP hints, add dimensions + **`fetchpriority="high"`** / loading as already in template — align with performance guidelines. → Verify: no CLS on load; Lighthouse LCP hint. *Skills:* `/web-performance-optimization`.

- [x] **Rebuild CSS** — From `restwell-theme/`: `npx tailwindcss -i ./assets/css/input.css -o ./assets/css/tailwind.css --minify`. → Verify: command exits 0. *Skills:* `/tailwind-design-system`. *(Rebuilt after batch 1 CSS edits.)*

- [ ] **Final verification pass** — **Logged-out** mobile **375 / 390 / 414** + desktop: header↔hero alignment, rhythm, horizontal **overflow**, focus ring on menu; on a **notched** device or simulator, confirm **safe-area** does not clip content. → Verify: screenshots or device check; optional `/visual-frontend-audit` + `/ui-visual-validator` pass on exports. *Skills:* `/visual-frontend-audit`, `/ui-visual-validator`, `/web-design-guidelines`.

## Done When

- [x] Mobile hero **gutter** and **header alignment** read intentional, not “squeeze.” *(CSS aligned — confirm in browser.)*
- [x] **Vertical rhythm** no longer dominated by a huge **lede→button** gap on small screens (unless explicitly chosen). *(639px `home-hero__copy` gap → `space-5` — confirm in browser.)*
- [ ] **Secondary CTA** behaviour is **decided** and **consistent** with that decision.
- [ ] **Contrast + focus + menu label** meet the bar you set with `/wcag-audit-patterns`.
- [ ] `tailwind.css` rebuilt; **logged-out** checks complete.

## Notes

- **Canonical logo lockup:** *Restwell by Continuity of Care Services* — used for logo `alt` / `aria-label` via `restwell_site_brand_lockup()` in `inc/theme-setup.php` (screenshot “Coastway” was a misread; replace logo **image file** in Media Library if the artwork still says something else).
- **Strategic (post-MVP):** optional **scrim** or gradient band behind the copy column for contrast without flattening the whole photo — only if `/wcag-audit-patterns` still flags edge cases after task 5.
- **Tokens:** if hero spacing stabilises, add **`--hero-*`** (or document existing vars) in `restwell-theme/DESIGN-SYSTEM.md` so mobile/desktop don’t drift — use `/tailwind-design-system` + `/ui-ux-designer`.
- Full glossary path: `cta-wp-theme/docs/SKILLS_GLOSSARY.md` (local clone).
