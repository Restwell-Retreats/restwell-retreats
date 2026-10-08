# Visual tick list — vibe-coded vs professional (5 Oct 2026)

Source: Playground on :9410. Legend: ✅ clean · 🔧 fixed this pass · 📝 judgement call for you · ⬜ only automated checks, not eyeballed at that width.

**Method.** Every page was swept automatically at 375 / 768 / 1280 px (overflow, broken images, text under 12px, tap targets, heading order, image dimensions, empty paragraphs). Then eyeballed at 390px, with desktop spot-checks on the home and accessibility pages.
Two automated hits were WP admin-bar artefacts (`.display-name`, offline gravatar), not real bugs. The "empty `<p>`" hits are intentional `aria-live` regions filled by JS.

**Verdict:** reads as designed, not generated. Consistent eyebrow → serif heading → body rhythm, one card language, one button set. What was left were density and spacing bugs, not style problems.

## Fixed this pass (CSS rebuilt, critical CSS rebuilt, phpunit 98/98, phpcs clean)
- [x] 🔧 Property, living room: 3rd/4th paragraphs had no gap (`.section-head--tight ~ .lede + .lede`)
- [x] 🔧 Property photo grid: odd count orphaned one photo; first photo now spans full width on phones
- [x] 🔧 Accessibility: heading skip H2→H4 (chair widths) is now an H3
- [x] 🔧 Accessibility equipment register: spec rows squeezed into ~70px value slivers on phones; label now stacks above value ≤479px
- [x] 🔧 Accessibility callouts: icon beside text left ~150px for copy; icon now stacks above ≤479px
- [x] 🔧 Pricing and sitewide: inline links in a sentence were `inline-flex` with a 44px min-height, which stretched every line (rates note was 108px for 3 lines, now 61px). Standalone link paragraphs keep the 44px target via `.text-link--standalone`

- [x] 🔧 Pricing care rates: the OVERNIGHT label sat 16px under the intro; now 24px
- [x] 🔧 Optional care, support cards: four cards in three columns at ~1024px left one orphan; now 2×2 until 1100px
- [x] 🔧 Blog index: nine cards in a two-column grid left a lone card above the pagination; page size is now 11 (1 featured + 10), set in `inc/blog-categories.php`
- [x] 🔧 Guest guide cards: `align-items: start` gave ragged heights and uneven row gaps; cards now stretch to equal height

## Checked, no change needed
- [x] Home reviews "ragged" quote: that is deliberate `text-wrap: pretty`, left alone
- [x] Whitstable guide small tap targets: they are title links and in-sentence links, not buttons; action pills are ≥40px
- [x] Enquire `<br>`s: label/value pairs in the contact card, intentional
- [x] Enquire "Continue" button: right-aligned on a stepped form is conventional

## 📝 Your call
- [ ] Home care tease is the only section with no eyebrow (`home_care_label` is empty by design: "empty = heading uses eyebrow style"). Add "Optional care" in the CRM field if you want it to match the others
- [ ] Whitstable guide: the Harbour and Old Neptune cards both use a lone-figure-on-a-pier photo, so they look like the same picture. Worth distinct images
- [ ] Our story and accessibility show large blank gaps on first paint where scroll-reveal hasn't fired yet (fine in use; only visible in screenshots)
- [x] Enquire form showed `Test Person`: that's the localStorage draft-restore feature in `enquire.js`, not a template default

## Page by page (by eye: mobile 390 / tablet 768–1024 / desktop 1024–1280)
Every page has now been looked at on a phone. Tablet and desktop were checked by eye on the pages below, plus an automated layout sweep (orphaned grid rows, over-long lines, clipped text) of 13 pages at 768, 1024 and 1280.

| Page | Mobile | Tablet / desktop |
|---|---|---|
| Home | ✅ | ✅ |
| The property | ✅ 🔧 | ✅ (tablet) |
| Our story | ✅ | ✅ |
| Accessibility | ✅ 🔧 | ✅ |
| Pricing | ✅ 🔧 | ✅ |
| How it works | ✅ | ✅ |
| Who it's for | ✅ | ✅ |
| Whitstable guide | ✅ | ✅ |
| Funding & support | ✅ | ✅ |
| Optional care | ✅ | ✅ 🔧 |
| Enquire | ✅ step 1 | ✅ step 1 |
| FAQ | ✅ | ✅ |
| Blog index | ✅ | ✅ 🔧 |
| Privacy / terms / accessibility policy | ✅ | ✅ |
| 404 | ✅ | ✅ |
| Guest guide | ✅ | ✅ 🔧 |

Not seen: enquire steps 2–3 and the success state; accessibility limits/destination/FAQ at phone width; photo-lightbox behaviour.
