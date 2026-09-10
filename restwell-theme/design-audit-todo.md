# Design audit change list — Restwell Retreats

Target: WordPress Playground http://127.0.0.1:9402  
Source: design-audit-restwell-2026-09-10 canvas · 10 Sep 2026

Tick only after Browser verification on Playground.

## P1 — this week

- [x] **P1** · `front-page.php` hero — USP lede (owner line) · S `[editorial]` · verified 390
- [x] **P1** · `front-page.php` — Cut home to 7 bands (hero→property→gallery→reviews→care tease→FAQ→enquire); removed paths/partners/comparison · L · verified
- [x] **P1** · sitewide CTA — Unify primary label to Enquire · S · verified
- [x] **P1** · `shared.css` — `scroll-padding-top` · S `[a11y]` · verified
- [x] **P1** · `availability-calendar.php` — Initial 2 months; lazy-build on Next; DOM 888 (was 2459) · L `[perf]` · verified
- [~] **P1** · care panels ×6 — Home tease done; other templates still have full panels · M `[editorial]`
- [x] **P1** · IA nav — Funding slug `funding-and-support` matches “Funding & Support” · S · verified 200
- [ ] **P1** · production ICS — Persist `restwell_ical_feed_url` in CRM settings · S

## P2 — craft

- [x] **P2** · `shared.css` `--type-h1` — 36px / weight 600 @390 · S · verified
- [x] **P2** · `shared.css` `.btn` — radius ~0.65rem · S `[style]` · verified
- [x] **P2** · `shared.css` hero ≤767 — Secondary text-link · S · verified
- [x] **P2** · `front-page.php` `#comparison` — Deleted with home cut · M · verified
- [x] **P2** · `template-how-it-works.php` — Continuity + CQC alts · S · verified
- [~] **P2** · `shared.css` `.subnav` — Already has scroll-shadow fades; re-check visually · S
- [x] **P2** · `shared.css` section rhythm — Compact tokens on gallery/care/FAQ · M · partial
- [ ] **P2** · `mid-cta.php` callers — Intent-specific H2s sitewide · S `[editorial]`
- [x] **P2** · `template-pricing.php` mid-cta — No period; Check availability · S · verified
- [x] **P2** · home `#partners` — Removed from home (lives on Our Story) · S · verified
- [x] **P2** · `shared.css` `.peak-dates` — Teal outline chip (not gold); open denser ≤639; orphan full-width ≥640; action stacks ≤430 vs scroll-top · S · verified 390/768/1280
- [ ] **P2** · `header.php` @900–1023 — Compact nav + Enquire chip · M
- [x] **P2** · cookie-banner — Compact ≤430 (~15% vh @390, was 25%) · M · verified
- [ ] **P2** · `header.php` mobile — Consider sticky Enquire thumb bar · M
- [ ] **P2** · `template-who-its-for.php` — Thin funding card grid to links · M `[editorial]`
- [ ] **P2** · `template-whitstable-guide.php` — Honesty limits before mid-CTA · S
- [ ] **P2** · FAQ pill-tabs — Scroll affordance matches subnav · S
- [ ] **P2** · testimonials — One large quote if cutting home length · M `[format]`
- [ ] **P2** · gallery home — Unify View photos vs tile affordance · S
- [ ] **P2** · 1024 gap — Spot-check card gutters 1024–1180 · S
- [x] **P2** · dark mode — Out of scope · S

## P3 — taste / verify

- [ ] **P3** · design tokens — Oversized mm numeral utility · M `[style]`
- [ ] **P3** · shadows — Single light source on cards · S `[taste]`
- [ ] **P3** · blog index — Featured scrim contrast @390 · S
- [ ] **P3** · enquire form — Autocomplete attrs audit · S
- [ ] **P3** · 320 stress — Re-check after cookie dismiss · S
- [ ] **P3** · 1920 — Optional wider editorial measure · S
- [ ] **P3** · 200% zoom — Overflow + cookie · M
- [ ] **P3** · prefers-reduced-motion — Gate future motion · S
