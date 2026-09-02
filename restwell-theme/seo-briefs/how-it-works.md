# SEO Content Brief — How It Works

Source page: `restwell-theme/template-how-it-works.php`

## 1. Keyword Strategy

SEO recommendations: this page targets process/booking-intent searches ("how do I book an accessible holiday") rather than descriptive ones — the four-step structure itself is the content that should carry the keyword, not adjective-heavy prose. The seed keyphrase is intentionally broad; use it once near the top and let the process steps do the rest of the work in plain, specific language.

- **Primary keyword:** "Accessible stay" *(existing focus keyphrase — `inc/seo-content-seed-meta.php`, slug `how-it-works`)*
- **Secondary keywords:** "how to book accessible holiday accommodation", "accessible bungalow booking process", "step-free holiday check-in Kent"

## 2. Content Structure & Enhancements

- **Four-step process (Enquire → Confirm → Deposit → Arrive):** clear, numbered, no online-checkout maze — this directly answers "how does booking work" queries and is a strong candidate for `HowTo` structured data (see Technical SEO).
- **Arrival day section:** specific operational detail (key-safe from 3pm, departure by 10am, level driveway) — this kind of concrete logistics content is exactly what reduces pre-booking questions and also reads well as a featured-snippet answer to "what time can I check in."
- **Optional care section:** same recurring sitewide message (care available, never bundled) with the Continuity/CQC branding — consistent with Property, Who It's For, and Care pages. Don't rewrite; the repetition across pages is contextual, not duplicate content, since each instance sits in a different decision point in the user's journey.
- **FAQ (5 questions):** tightly scoped to booking mechanics (how to book, how to pay, can a local authority book, arrival time, optional care) — appropriately narrow for this page since broader funding/suitability questions are correctly deferred to Resources and Who It's For via internal links.

## 3. Technical SEO

- **Meta title (existing, in sync):** `Accessible Stay Booking Process | Restwell Retreats` — 51 characters.
- **Meta description (existing, in sync):** `An accessible stay with Restwell starts at enquiry: share access needs, confirm dates, add optional CQC-regulated care, then arrive ready.` — 138 characters.
- **Headings:** single H1, clean H2 ladder (Process → Arrival day → Optional care → Before you enquire FAQ).
- **Structured data opportunity:** the four-step process list (`process-list` with numbered index `01`–`04`, each with a heading and description) is well-suited to `HowTo` schema if/when JSON-LD is extended to this page — currently this page has none. Lower priority than the FAQ page's missing `FAQPage` schema, but worth flagging since the content is already shaped correctly for it.
- **URL/slug:** live slug is `/how-it-works/`.

## 4. User Experience & Conversion

- Sticky subnav + scroll-spy (Process/Arrival/Care/FAQ) — verified working during the responsive audit, no overflow or mobile step-spacing issues.
- No mid-hero clutter — process steps get full visual priority.
- Mid-CTA closes with "Send dates and access needs" + a secondary link to View the property, giving readers who aren't ready to enquire yet a lower-commitment next step.

## 5. Content Length

Moderate length, appropriate for a process-explainer page — the four-step list plus arrival/care sections plus five FAQ answers likely sits around 600–800 words, which is right-sized for this content type. No padding needed.

---

## Example Outline

1. How an Accessible Stay Works (H1)
2. Enquire, Confirm, Deposit, Arrive — Process (H2)
3. Key-Safe from 3pm — Arrival Day (H2)
4. Add Care Only If You Need It — Optional Care (H2)
5. Before You Enquire — Booking FAQ (H2)

## Meta Information

**Meta Title:** Accessible Stay Booking Process | Restwell Retreats
**Meta Description:** An accessible stay with Restwell starts at enquiry: share access needs, confirm dates, add optional CQC-regulated care, then arrive ready.
**Page title:** How It Works
**Slug:** /how-it-works/

---

## Page Copy (matches current mockup structure)

### Header
Nav: Home · The Bungalow (The Property, Accessibility, Pricing, How It Works) · Plan your trip (Who It's For, Whitstable, Funding & Support, Optional care) · FAQ · Blog
CTA: Enquire Now

### Section 1 — Hero
Breadcrumb: Home / How It Works
H1: How an accessible stay works
Subheading: Share dates and access needs, confirm what's in the house, add Continuity care only if you want it, then key-safe arrival from 3pm.

### Subnav
Process · Arrival · Care · FAQ

### Section 2 — Process
Eyebrow: How it works
H2: Enquire, confirm, deposit, arrive
Lede: Four steps from first message to key-safe arrival. No online checkout. You only pay a deposit once dates are agreed.
Step 01 — Enquire: Tell us your travel dates, who's coming, and what equipment you need.
Step 02 — Confirm: We'll set up the house and equipment for your group. If you want, we can also start a Continuity care conversation using the same number.
Step 03 — Deposit: Pay a 50% deposit to reserve your bungalow. The rest is due one week before you arrive.
Step 04 — Arrive: Arrive any time after 3pm and use the key-safe. The step-free house and all your equipment will be ready for your group.

### Section 3 — Arrival day
Eyebrow: Arrival day
H2: Key-safe from 3pm
Lede: No reception desk. Park on the driveway, open the key-safe, and settle into a house already set for your party.
Check-in: From 3pm via the key-safe · departure by 10am
Parking: Level driveway for two cars, including accessible vehicles
Ready for you: Step-free routes and kit set from your enquiry · guest notes after dates are confirmed
Links: Tour the property · Door widths and kit notes

### Section 4 — Optional care
Eyebrow: Optional care
H2: Add care only if you need it
Lede: Ask about Continuity of Care Services when you enquire — or bring your own team. Care is never bundled into the bungalow rate.
Types: Personal care (washing, dressing and daily routines on agreed times) · Visiting care (short daytime visits, or support for a promenade or town trip) · Mobility and hoisting (transfers with the on-site ceiling track and wet-room kit)
Note: We add nothing until you agree the support package.
Links: How optional care works · See care guide rates

### Section 5 — Before you enquire FAQ (5 questions, two columns)
1. How do I book a stay?
2. How can I pay for the bungalow?
3. Can a local authority or NHS team book for me?
4. What time can we arrive?
5. Can I arrange optional care with the stay?

### Section 6 — Mid CTA
Heading: Send dates and access needs
Body: We'll reply with measurements, equipment notes, and your next steps.
Primary CTA: Enquire Now
Secondary CTA: View the property

### Footer
Restwell · Sister company: Continuity of Care Services · CQC inspection profile · Accessible holidays, Whitstable, Kent
Footer links: FAQ · Privacy Policy · Terms & Conditions · Website accessibility
Copyright: © 2026 Homely Housing Investments Ltd t/a Restwell Retreats. All rights reserved.
