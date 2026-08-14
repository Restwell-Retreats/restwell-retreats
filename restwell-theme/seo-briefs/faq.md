# SEO Content Brief — FAQ

Source page: `restwell-theme/mockups/faq-concept.html`

## 1. Keyword Strategy

SEO recommendations: this page is the site's single biggest missed structured-data opportunity (see Technical SEO below) — fix that before touching the copy. On-page keyword integration matters less here than making sure the 10 Q&A pairs are machine-readable as `FAQPage` schema, since that's what actually earns rich-result and AI-answer pickup for a page like this.

- **Primary keyword:** "Accessible holiday FAQ Whitstable" *(existing focus keyphrase — `inc/seo-content-seed-meta.php`, slug `faq`)*
- **Secondary keywords:** "wheelchair accessible holiday questions", "accessible bungalow booking FAQ", "disabled holiday accommodation questions Kent"

## 2. Content Structure & Enhancements

- **Category filter pills (All / About the property / Booking & dates / Care & support / The local area / Funding & payments):** good UX pattern, but be aware filtering only shows/hides — it doesn't change the URL, so this doesn't create separately indexable category views. That's fine for UX; just don't expect the filter categories themselves to rank independently.
- **Good practice already in place — cross-linking instead of duplicating:** several answers deliberately link out rather than repeat content ("On the Accessibility page. We keep those answers there so they aren't copied across the site.") — this avoids content cannibalisation between FAQ and the pages it references (Accessibility, Care, Pricing, Whitstable guide, Who It's For, Resources). Don't change this pattern even though it means some answers here are short.
- **"Ask us directly" form:** lower-priority form (no consent checkbox, unlike Enquire — reasonable since it's a general question, not the accessibility/care data the Enquire form collects). No SEO action needed.

## 3. Technical SEO — priority fix

- **Missing `FAQPage` structured data:** this page has zero JSON-LD despite being purpose-built around 10 question/answer pairs — the single clearest structured-data gap on the entire site (confirmed during the earlier technical SEO audit). Both the homepage and the Care page already implement `FAQPage` schema for a handful of questions each; this page should get the full pattern for all 10, since it's the dedicated FAQ hub and the highest-value candidate for FAQ rich results.
- **Meta title (existing, in sync):** `Accessible Holiday FAQs | Restwell Retreats` — 52 characters.
- **Meta description (existing, in sync):** `Short answers on the bungalow, access, bookings, care, funding and the local area — with links to the full detail where it matters.` — 131 characters. *(Note: the seed file's version differs slightly — "Quick answers on bookings, assistance dogs, parking and access details..." — worth reconciling which is current before this ships; flagging per the "seed file may be outdated" note rather than picking one.)*
- **Headings:** single H1, no visible H2 before the FAQ list (filter pills sit directly under the hero) — consider adding an `sr-only` H2 above the accordion for heading-hierarchy completeness, matching the pattern already used for the testimonial section on the Who It's For page.
- **Accordion markup:** `aria-expanded`, `hidden` panels, `role="region"` all correctly implemented — verified working during the responsive audit (single-open-at-a-time behaviour, filter pills correctly show/hide by `data-cat`).
- **URL/slug:** live slug is `/faq/`.

## 4. User Experience & Conversion

- Two-column accordion layout with category filtering — verified no overflow or interaction issues across breakpoints during the responsive audit.
- "Ask us directly" fallback form gives a path for questions not covered — good, keeps the page from being a dead end.
- Mid-CTA closes with both phone number and enquire links.

## 5. Content Length

10 short Q&A pairs plus a fallback form — appropriately concise for a FAQ hub whose job is fast answers with links to deeper content, not to be the deep content itself.

---

## Example Outline

1. Restwell Accessible Holiday FAQs (H1)
2. *(FAQ accordion, 10 questions across 6 categories)*
3. Ask Us Directly (H2)

## Meta Information

**Meta Title:** Accessible Holiday FAQs | Restwell Retreats
**Meta Description:** Short answers on the bungalow, access, bookings, care, funding and the local area — with links to the full detail where it matters.
**Page title:** FAQ
**Slug:** /faq/

---

## Page Copy (matches current mockup structure)

### Header
Nav: Home · The Bungalow (The Property, Accessibility, Pricing, How It Works) · Plan your trip (Who It's For, Whitstable, Funding & Support, Optional care) · FAQ · Blog
CTA: Enquire Now

### Section 1 — Hero
Breadcrumb: Home / FAQ
H1: Restwell accessible holiday FAQs
Subheading: Short answers on the bungalow, access, bookings, care, funding and the local area — with links to the full detail where it matters.

### Section 2 — FAQ accordion
Filters: All · About the property · Booking & dates · Care & support · The local area · Funding & payments

1. Is Restwell open for bookings? *(booking)* — Yes — we take bookings for 2026 and 2027. Send dates and access needs via the enquire form.
2. Do you allow assistance dogs? *(property)* — Yes. The bungalow is dog-friendly and welcomes assistance dogs. Please tell us in advance so we can complete a risk assessment. Water bowls and a toileting area are provided.
3. Is parking available at the bungalow? *(property)* — Yes — driveway parking for two cars on a level surface. Adapted vehicles with ramps or side lifts usually fit; tell us your vehicle length when you enquire. Overflow often works on the street outside; check signs on arrival.
4. Where are hoist, wet-room and door-width details? *(property)* — On the Accessibility page. We keep those answers there so they aren't copied across the site.
5. How do I arrange optional CQC care? *(care)* — See Care during your stay for arranging Continuity of Care Services. Care is never bundled into the bungalow rate — guide figures live on Pricing.
6. Is there a step-free train to Whitstable? *(area)* — Whitstable station has step-free access to both platforms via separate street-level entrances. It's a short taxi ride from the bungalow — there's a taxi office by the station exit. Ask us about accessible taxi notice periods.
7. Is there a Changing Places or RADAR toilet nearby? *(area)* — Yes — at Whitstable Harbour on Harbour Road. A RADAR key is required. More local routes are on the Whitstable guide.
8. Can funding change the bungalow price? *(funding)* — No. Same published rates for every guest — only who we invoice changes. Pathway questions (CHC, direct payments, personal budgets) are answered on Funding & Support.
9. How does bungalow payment work? *(funding)* — 50% deposit to secure dates; balance due one week before arrival. BACS or card. See Pricing for the full payment steps.
10. Cottage stay or care-home respite — which is right? *(care)* — That suitability comparison lives on Who It's For, with complex-care planning checklists there too.

### Section 3 — Ask us directly
Eyebrow: Not on the list?
H2: Ask us directly
Form: Name, Email, Your question → Send question

### Section 4 — Mid CTA
Heading: Send dates and access needs
Body: We reply within 48 hours on most enquiries — phone 01622 809881 if you need to talk it through.
Primary CTA: Enquire Now
Secondary CTA: Go to enquire form

### Footer
Restwell · Care partner: Continuity of Care Services · CQC inspection profile · Accessible holidays, Whitstable, Kent
Footer links: FAQ · Privacy Policy · Terms & Conditions · Website accessibility
Copyright: © 2026 Homely Housing Investments Ltd t/a Restwell Retreats. All rights reserved.
