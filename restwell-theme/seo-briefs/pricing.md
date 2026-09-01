# SEO Content Brief — Pricing

Source page: `restwell-theme/mockups/pricing-concept.html`

## 1. Keyword Strategy

SEO recommendations: pricing pages tend to rank on transactional intent ("how much does X cost") rather than descriptive intent — the numbers themselves (tables, per-hour rates) are the content that matters most here. Keyword phrasing should sit in the surrounding copy, never inside the tables.

- **Primary keyword:** "Accessible holiday pricing Whitstable" *(existing focus keyphrase — `inc/seo-content-seed-meta.php`, slug `pricing`)*
- **Secondary keywords:** "step-free holiday home rates Kent", "wheelchair accessible self-catering pricing", "NHS CHC funded holiday accommodation", "disabled holiday rates Whitstable"

This page is already well aligned — meta title, meta description and H1 are in sync with the researched keyphrase (confirmed against `inc/seo-content-seed-meta.php` during the earlier site SEO audit). No urgent rewrite needed; the notes below are refinements, not fixes.

## 2. Content Structure & Enhancements

- **Rates table:** exact figures (£1,300/£1,400 full week, per-night breakdowns, example stays) — this is exactly the kind of structured, numeric content that gets pulled into AI-generated price comparisons and featured snippets. Don't touch it for keyword reasons.
- **Peak season dates (`<details>`):** good progressive-disclosure pattern, keeps the page scannable while still indexable (collapsed `<details>` content is crawlable).
- **Payment section:** three-step "50% deposit → balance before arrival → no extras" is honest and specific (explicitly no damage deposit, no cleaning fee) — this kind of transparency is a trust signal search engines and AI answers increasingly weight for YMYL-adjacent travel/care content.
- **Optional care rates:** per-hour figures plus CQC/partner branding — good E-E-A-T signal (named regulated partner, visible rating). "NHS CHC funded holiday accommodation" fits naturally near the funding-route mention in the rates lede.
- **Pricing FAQ:** four tight questions all reinforcing "funding doesn't change the price" — strong differentiator, most competitor sites obscure this. Keep as-is.

## 3. Technical SEO

- **Meta title (existing, in sync):** `Accessible Holiday Pricing in Whitstable | Restwell Retreats` — 60 characters (at the upper boundary, don't extend it).
- **Meta description (existing, in sync):** `How pricing works for an accessible self-catering break at Restwell in Whitstable, with private, case-managed and NHS CHC funding routes and deposits explained.` — 160 characters (also at the boundary).
- **Headings:** single H1, four H2s (Rates → Payment → Optional care → Pricing FAQ), each table has a proper `<caption class="sr-only">` describing its contents — good accessible-table practice that doubles as extra crawlable context.
- **Data tables:** `scope="col"`/`scope="row"` used correctly, `data-label` attributes present for responsive card-collapse — verified working correctly during the responsive audit.
- **Image alt text:** partner logos have descriptive alt (`"Continuity of Care Services"`, `"CQC rating Good — Continuity of Care Services"`) rather than generic "logo" — good practice.
- **URL/slug:** live slug is `/pricing/`.

## 4. User Experience & Conversion

- Sticky subnav + scroll-spy (Rates/Payment/Optional care/FAQ) — verified working during the responsive audit.
- `<details>` for peak dates keeps the primary rates table short on first view without hiding the information from search engines.
- Mid-CTA offers both "Enquire Now" and "How booking works" (links to How It Works) — good secondary path.
- Cross-links to Property, Accessibility, Funding & Support, Terms, Care, and How It Works — this page is a strong internal-linking hub; don't remove any of these.

## 5. Content Length

Shorter than the room-by-room pages by design — pricing pages convert on clarity and scannability, not word count. Current length is appropriate; don't pad it.

---

## Example Outline

1. Accessible Holiday Pricing in Whitstable (H1)
2. What a Stay Costs — Rates (H2)
3. How Payment Works (H2)
4. Optional Care While You Stay (H2)
5. Pricing FAQ (H2)

## Meta Information

**Meta Title:** Accessible Holiday Pricing in Whitstable | Restwell Retreats
**Meta Description:** How pricing works for an accessible self-catering break at Restwell in Whitstable, with private, case-managed and NHS CHC funding routes and deposits explained.
**Page title:** Pricing
**Slug:** /pricing/

---

## Page Copy (matches current mockup structure)

### Header
Nav: Home · The Bungalow (The Property, Accessibility, Pricing, How It Works) · Plan your trip (Who It's For, Whitstable, Funding & Support, Optional care) · FAQ · Blog
CTA: Enquire Now

### Section 1 — Hero
Breadcrumb: Home / Pricing
H1: Accessible holiday pricing in Whitstable
Subheading: Whole-house bungalow rates, optional Continuity care guides, and the same tariff whoever we invoice.

### Subnav
Rates · Payment · Optional care · FAQ

### Section 2 — Rates
Eyebrow: Bungalow rates
H2: What a stay costs
Lede: Whole bungalow, sleeps five. Midweek (Mon–Thu) and weekend (Fri–Sun) nights are priced differently; optional care is separate.
Table: Full week (7 nights) £1,300 off-peak / £1,400 peak · Weekend night (Fri–Sun) £235 / £255 · Midweek night (Mon–Thu) £185 / £200
Example stays: Weekend (3 nights) £705/£765 · Midweek (4 nights) £740/£800 · Long weekend (4 nights) £890/£965
Follow line: Rooms and capacity on the property page; kit and measurements in the access details.
Peak season dates (collapsed): Summer 2026, Autumn half-term, Christmas, February half-term, Easter, Spring bank holiday, Summer 2027

### Section 3 — Payment
Eyebrow: Deposits and balance
H2: How payment works
Lede: BACS or card. Same rates on every funding route — Funding & Support covers who we invoice.
Step 01 — 50% deposit: Secures your dates and takes the bungalow off the calendar.
Step 02 — Balance before arrival: Due no later than one week before you arrive.
Step 03 — No extras: No damage deposit and no end-of-stay cleaning fee.
Note: If plans change, the terms and cancellation policy set out what happens next.

### Section 4 — Optional care rates
Eyebrow: Guide rates
H2: Optional care while you stay
Lede: Guide rates from Continuity, billed separately from the bungalow. Your care cost depends on the hours and tasks you need; Continuity quotes that once you have spoken.
Table: Daytime personal care (per hour) £34.65 weekday / £41.25 weekend · Overnight personal care (per hour) £40.15 / £46.75 · Sleep-in night £230.94 both · Waking night £307.62 both
Partner branding: Continuity of Care Services · CQC rating Good
Note: Bank holidays and complex care may cost more. Next review: 1 September 2026.
Primary CTA: Enquire about care
Secondary CTA: How optional care works

### Section 5 — Pricing FAQ
1. Is care included in the bungalow price?
2. Are there extra charges for equipment?
3. Do prices change with funding?
4. When do care guide rates go up?

### Section 6 — Mid CTA
Heading: Enquire about dates and care
Body: Tell us arrival dates, access needs and whether you want Continuity support — no deposit until you decide.
Primary CTA: Enquire Now
Secondary CTA: How booking works

### Footer
Restwell · Sister company: Continuity of Care Services · CQC inspection profile · Accessible holidays, Whitstable, Kent
Footer links: FAQ · Privacy Policy · Terms & Conditions · Website accessibility
Copyright: © 2026 Homely Housing Investments Ltd t/a Restwell Retreats. All rights reserved.
