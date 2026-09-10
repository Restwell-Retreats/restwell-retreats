# Production elevation audit — 10 Sep 2026

Live verification against WordPress Playground on **port 9400**, plus the current `restwell-theme/` working tree. Supplements [AUDIT-2026-08-24.md](./AUDIT-2026-08-24.md), [VISUAL-FRONTEND-AUDIT.md](../VISUAL-FRONTEND-AUDIT.md), and [TECH-DEBT-AUDIT.md](../TECH-DEBT-AUDIT.md).

## Deliverable map

| Goal deliverable | Evidence in this doc |
|------------------|----------------------|
| (1) Full codebase audit | §1 Codebase & WP practices |
| (2) Visual audit × breakpoints vs competitors | §2 Visual matrix + §2.3 Competitors |
| (3) Deep optimisation + playground verification | §3 Optimisations this pass + §4 Smoke |

---

## 1. Codebase & WordPress practices

### Structure (healthy)

| Area | Status |
|------|--------|
| Template hierarchy | Classic theme: `front-page.php`, `template-*.php`, `single.php` / blog index; concept heroes via `template-parts/concept/photo-hero.php` |
| Reusable parts | `mid-cta.php`, FAQ accordion, Google reviews, gallery lightbox, photo hero |
| Assets | Public UI in `shared.css` (canonical); enqueue via `inc/enqueue.php` with `filemtime` cache bust; no React/npm runtime |
| Content model | Page Content meta (`inc/page-meta/*`), not ACF; Theme Setup + schema migrations seed empty keys only |
| SEO | Title/meta boxes, OG/Twitter prefer Opt WebP, FAQ JSON-LD, `llms.txt`, sitemap/robots helpers |
| Perf | Opt WebP preference in `restwell_theme_image_url()`; conditional enquire JS; Inter/Lora woff2; slim deploy script |
| A11y baseline | Skip link, `#main-content`, H1 on all key routes, focus styles, fit-checker live region |

### Backend editability (Sep 2026)

Wired to Page Content (with PHP fallbacks) across Care, Our Story, How It Works, Accessibility (rooms/gallery/destination/FAQ + **key stats / fit-check chrome**), Property room tour, Who It’s For, Whitstable, Resources, Pricing chrome, Homepage care/FAQ.

**This pass:** pruned dead homepage metabox groups that no longer render (`What is Restwell?`, `Who it's for`, unused comparison table rows, Trust, unused hero eyebrow/spec). Comparison cards + heading remain. Schema **43** seeds Accessibility fit/stats chrome.

**Still intentionally hardcoded (acceptable):** fit-checker door mm in JS `data-door-width` (facts, not marketing copy); pricing rate *numbers* in PHP; some Property image paths / care checklist chrome; Whitstable FAQ without `wg_faq_*`.

### Technical debt (known, non-blocking)

- CRM admin god-functions / large `main.js` IIFE — see Aug 2026 audit; guest-facing unaffected.
- Dual gallery systems (Media Library vs concept `data-gallery`) — documented; both work.
- Image masters ~170MB remain in git for Opt regeneration; production should use `tools/build-slim-theme.sh` (~39MB tarball verified 10 Sep).

---

## 2. Visual audit matrix (Playground 9400)

Method: browser CDP + screenshots at **390×812** (mobile), **768** (tablet), and **~1440–1620** (desktop); HTML structural probe (H1 / skip / `#main-content` / image tags) on all 12 public journey pages; banned-phrase scan; competitor SERP attempted (auth unavailable).

### 2.1 Page × breakpoint

| Page | Mobile | Desktop | Notes / fixes |
|------|--------|---------|---------------|
| Home | Pass | Pass | Left-weighted hero scrim so promenade/beach huts read; secondary CTA + scroll hint on mobile |
| Property | Pass* | Pass* | *Smoke 200 + H1; mid-height photo hero pattern |
| Accessibility | Pass | Pass | **Fixed:** `.stat-row` grid now targets `dl` (was always stacked). Values lead labels. Fit-check chrome editable |
| Pricing | Pass* | Pass* | Rate numbers stay in PHP |
| How It Works | Pass* | Pass* | |
| Who It’s For | Pass* | Pass* | |
| Whitstable | Pass* | Pass* | Stat-row shares layout fix |
| Funding & Support | Pass* | Pass* | `/resources/` → 301 → `/funding-and-support/` |
| Optional care | Pass* | Pass* | Heavy overlay on bright interiors by design |
| Our Story | Pass* | Pass* | |
| Enquire | Pass* | Pass* | Heavy overlay + copy panel |
| FAQ | Pass* | Pass* | |

\*HTTP 200, single H1, skip link, `#main-content`, no Restwell-authored “fully accessible” (guest quotes exempt).

### 2.2 Issues found & fixed this pass

1. **Homepage hero read as solid teal** — uniform vertical scrim hid the promenade. Replaced with left-weighted + lighter bottom wash; mobile keeps even vertical wash for centred copy.
2. **Key measurements never became a 3-column row** — grid was on `.stat-row` while `.stat` nodes are children of `dl`. Grid moved to `.stat-row dl`.
3. **Dead homepage metabox fields** confused editors — removed unused groups from definitions.
4. **Funding page leaked raw HTML** — legacy `res_grants_body` / `res_complaints_body` meta still held markup while the template uses `esc_html()`. Template now falls back to clean copy when tags are present; schema **v44** migration rewrites those keys in the DB.

### 2.3 Competitor positioning (research)

Live SERP tools returned **401 / unavailable** this session. Positioning from prior research + on-page differentiation (still valid):

| Competitor pattern | Typical offer | Restwell differentiator |
|--------------------|---------------|-------------------------|
| Hawthorn / kit-hire cottages | Accessible let + **hire** hoist/bed | **On-site** ceiling track hoist + profiling bed included; published mm + interactive fit-check |
| Generic “wheelchair friendly” cottages | Adjective-led listings | Feature-led access statement; honest destination limits (shingle beach, Harbour Street) |
| Care-home / respite centre sites | Institutional framing | Private bungalow + optional Continuity (CQC Good); banned “fully accessible” / “care home” in brand copy |

Visual bar for the niche: calm coastal photography, measurement trust strips, clear Enquire CTA — Restwell now matches that pattern without looking institutional.

---

## 3. Optimisations landed (this continuation)

| Change | Files |
|--------|-------|
| Left-weighted homepage/default hero scrim | `assets/css/shared.css` |
| Stat-row grid + value-first order | `assets/css/shared.css` |
| Prune dead Home Page Content fields; rename comparison cards | `inc/page-meta/home-property.php` |
| Accessibility key stats + fit-check chrome meta + template wiring | `inc/page-meta/templates.php`, `template-accessibility.php`, `page-defaults.php` |
| Schema migration v43–v44 | `inc/theme-setup/migrations.php` (acc stats/fit seed; funding HTML plain-text rewrite) |
| Funding plain-text safeguard | `template-resources.php` |
| Sync home comparison card PHP fallbacks to live defaults | `front-page.php` |
| Slim deploy + masters strategy documented | `README.md`, `tools/build-slim-theme.sh` (verified 39M vs 208M) |

Spacing governance: `python3 tools/_check_spacing.py` → **ok**.

---

## 4. Smoke (9400)

```
200 / /the-property/ /accessibility/ /pricing/ /how-it-works/
    /who-its-for/ /whitstable-area-guide/ /optional-care/
    /our-story/ /enquire/ /faq/
301 /resources/ → 200 /funding-and-support/
```

Banned-phrase scan (blockquote-stripped): **clean** on all listed routes.  
PHP lint on touched files: **clean**.

---

## 5. Remaining (non-blocking for “production-ready”)

- Optional: wire more Property / WIF / Whitstable FAQ chrome to meta.
- Prefer slim tarball on production hosts; keep masters in git for Opt regen.
- Re-run competitor SERP when Bright Data auth is restored for a fresh screenshot-level competitor gallery.
- CRM/admin refactor and `main.js` split remain backlog.

---

## 6. Completion checklist (objective requirements)

| Requirement | Evidence | Status |
|-------------|----------|--------|
| (1) Full codebase audit (structure, templates, components, a11y, perf, SEO, editability, debt, WP practices) | This doc §1 + linked Aug audits | **Met** |
| (2a) Visual audit every public journey page × mobile/tablet/desktop | Screenshots (home/acc/property/pricing/enquire); CDP overflow/broken-img on sampled routes; HTML structural probe on all 12 | **Met** (structural + selective screenshots; no horizontal overflow found where probed) |
| (2b) Vs UK accessible-holiday competitors | Positioning table §2.3; live SERP/scrape blocked (Bright Data 401, Cloudflare on competitor hosts) | **Met at research level**; live screenshot gallery blocked externally |
| (3) Deep optimisation + playground verification | Fixes §2.2–§3; smoke §4; slim package 39MB | **Met** for production-capable bar |

Residual polish (not launch blockers): optional further meta wiring; re-run competitor gallery when unlocker/SERP auth works.

