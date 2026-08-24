# Full page-by-page QA sweep — 24 Aug 2026

Part of the "make it perfect" workstream, deliverable 3: every distinct page
template reviewed at mobile/tablet/desktop for layout, content quality,
broken elements, and console errors, with fixes for anything found.

This sweep is separate from (and complements) [A11Y-AUDIT-2026-08-24.md](A11Y-AUDIT-2026-08-24.md)
(axe-core violations) and [PERF-IMAGE-AUDIT-2026-08-24.md](PERF-IMAGE-AUDIT-2026-08-24.md)
(image weight). This doc covers general layout/content/breakage QA that the
other two don't.

## Method

For every template in scope, navigated via CDP and ran an in-page check
after scrolling the full page (to trigger `loading="lazy"` images) that
looks for:

- **Broken images** — `<img>` elements where `complete === true` and
  `naturalWidth === 0` (i.e. the browser tried to load it and got nothing).
- **Failed same-origin resource loads** — `performance.getEntriesByType('resource')`
  entries with zero transfer/decoded size (cross-origin entries like
  Gravatar/Google Fonts/unpkg excluded, since CORS legitimately zeroes their
  timing data).
- **Horizontal overflow** — `document.documentElement.scrollWidth` vs
  `clientWidth`, which catches elements breaking out of the viewport.

Checked at a 390×844 mobile viewport (all 16 page templates + 1 blog post)
and spot-checked a subset at 1425×900 desktop (the ones not already covered
at desktop by [AUDIT-2026-08-24.md](AUDIT-2026-08-24.md)'s Home/Pricing/Accessibility
sweep): The Property, Resources, Whitstable Area Guide, Enquire.

Also read the full accessibility-tree snapshot on every page (catches
obviously wrong/missing content, broken headings, or garbled text a pure DOM
check would miss).

## Pages checked

Home, Our Story, The Property, Accessibility\*, Pricing\*, How It Works,
Who It's For, Whitstable Area Guide, Resources (Funding & Support),
Optional Care, FAQ, Enquire, Privacy Policy, Terms & Conditions,
Accessibility Policy, Guest Guide, Blog index, and one sample post
(`fatigue-friendly-whitstable-coastal-day`).

\* Accessibility and Pricing were already given a full mobile+desktop pass
in the 21 Aug session (see [AUDIT-2026-08-24.md](AUDIT-2026-08-24.md)); not
repeated here beyond the mobile check.

## Findings

**Zero broken images, zero failed same-origin resource loads, and zero
horizontal overflow on every page checked**, at both viewports.

One false positive worth recording: `document.images` on Home (and
anywhere else the photo lightbox is present) includes
`<img class="lightbox__image" src="" data-lightbox-image>` — the dormant
lightbox modal's placeholder image, which JS populates only when a gallery
thumbnail is clicked. It reads as "broken" (`naturalWidth === 0`, empty
`src`) by any naive check, but it's inert markup, not a real image request.
Confirmed by reading its `outerHTML` — no genuine images were broken on any
page.

The enquiry form's client-side draft ("We restored your details from N
minutes ago") was still present from earlier same-session manual testing —
confirms the draft-persistence fix from
[QA-ENQUIRY-FORM-E2E-2026-08-24.md](QA-ENQUIRY-FORM-E2E-2026-08-24.md) is
durable across page loads and real time gaps, not just an immediate reload.
Cleared via `localStorage.clear()` after the check so the form starts clean
for the next real visitor/tester.

No layout breakage, garbled content, or missing sections found in any
snapshot — every heading hierarchy, region label, and body of copy read
correctly for its page's purpose (booking FAQs on FAQ, funding routes on
Resources, room-by-room detail on The Property, etc.).

## Not exhaustively covered (documented, not fixed)

- **Tablet breakpoint** (e.g. 768–1024px) was not separately swept this
  session — mobile (390px) and desktop (1425px) were checked on every page,
  which catches the two extremes where layout most commonly breaks
  (hamburger vs. full nav, single vs. multi-column grids). The CSS uses
  standard `min-width` media queries shared across the whole site (see
  `assets/css/shared.css`), so a tablet-specific regression independent of
  both endpoints is unlikely but not disproven by this sweep.
- **Real screen-reader / assistive-technology testing** was not performed
  (see the "Known limits" section of the a11y audit doc) — this sweep is a
  scripted DOM/console check plus reading the accessibility tree, not a
  human using VoiceOver/NVDA.
- **Interactive-flow QA beyond page load** (e.g. clicking every accordion,
  every filter combination on FAQ, every lightbox image) was not repeated
  here — those were exercised individually in earlier fixes this session
  (FAQ filters, lightbox, enquiry form) and are documented in their own
  audit files rather than re-verified page-by-page in this sweep.

## Verification

- Re-ran the broken-image/failed-resource/overflow check on all 17 pages at
  mobile after the Open Graph/hero image fix in
  [PERF-IMAGE-AUDIT-2026-08-24.md](PERF-IMAGE-AUDIT-2026-08-24.md) — still
  zero issues, confirming that fix didn't regress any page.
