# SEO Content Brief — The Property

Source page: `restwell-theme/template-property.php`

## 1. Keyword Strategy

SEO recommendations: work these naturally into the H1, H2s, body copy, image alt text, and the room-by-room subnav labels. This page's job is to *prove* accessibility with specifics (measurements, equipment names) — don't let keyword phrasing crowd out that detail, it's what actually converts.

- **Primary keyword:** "Accessible bungalow Whitstable" *(existing focus keyphrase — `inc/seo-content-seed-meta.php`, slug `the-property`)*
- **Secondary keywords:** "wheelchair accessible holiday cottage", "step-free bungalow Whitstable", "wet room holiday accommodation Kent", "ceiling track hoist holiday let"

Use the primary phrase in the H1/lede and once more around the Location section. Let secondary phrases land naturally in the section that actually matches them (wet room copy → "wet room holiday accommodation", bedroom copy → "ceiling track hoist holiday let") rather than forcing all five into the top of the page.

## 2. Content Structure & Enhancements

- **Bedrooms/Wet room (first two sections):** these do the heaviest keyword lifting since they're what a searcher scans first — keep the primary phrase's language ("accessible bungalow") echoed in the opening sentence of the Bedrooms section.
- **Room-by-room sections:** already strong — keep the bullet-like specificity (hoist brand, basin rotation, door widths) since exact-measurement content is what earns featured-snippet and AI-answer pickup for this keyword class, more than adjective density.
- **Photos section:** gallery alt text is already descriptive per-image — good, don't change, just make sure any new images follow the same "what it is + accessibility detail" pattern (e.g. not "IMG_04.jpg").
- **Optional care section:** short by design — it's a cross-link to the Care page, not competing content. Leave it lean.
- **Location section:** natural home for "step-free bungalow Whitstable" and a second mention of "Whitstable" near the King Charles III England Coast Path reference — already links out to the Whitstable guide, good internal-linking practice.

## 3. Technical SEO

- **Meta title (existing, in sync):** `Accessible Bungalow Whitstable | Restwell Retreats` — 51 characters, keyword at the start.
- **Meta description (existing, in sync):** `Accessible bungalow Whitstable: single-storey, step-free layout with room-by-room specs, inclusions and optional care for your party.` — 134 characters.
- **Headings:** single H1 (`Inside the accessible bungalow in Whitstable`) is unique to this page — good. Nine H2s follow the subnav order (Bedrooms → Location), each with its own `id` for anchor jumps — keep this 1:1 mapping when editing, the subnav's `href="#id"` depends on it.
- **Image alt text:** already strong sitewide practice on this page (e.g. "Amico ceiling track hoist in the accessible bedroom", "Level-access wet room shower with grab rails and fold-down seat") — genuinely descriptive, not keyword-stuffed. Model other pages on this one.
- **URL/slug:** live slug is `/the-property/` (see `inc/seo-content-seed-meta.php`).

## 4. User Experience & Conversion

- Nine `<img>` elements at `width="900" height="675"` with `loading="lazy"` already set — good for CLS and speed.
- Sticky subnav + scroll-spy (`data-toc`) already gives fast in-page navigation across nine sections — verified working during the responsive audit.
- Two CTAs at the close (`Enquire Now`, `Read accessibility details`) plus one CTA link inline in the Care section — good CTA density for a long page, no changes needed.
- Internal links present to Accessibility, Care, and Whitstable guide pages — keep these; they're exactly the kind of contextual internal linking that helps both users and crawlability.

## 5. Content Length

Current page is comfortably in the 800–1,200 word range once all nine room sections are counted — no padding needed. Resist adding filler paragraphs purely to hit a word count; this page's strength is specificity, not length.

---

## Example Outline

1. Inside the Accessible Bungalow in Whitstable (H1)
2. Ceiling Hoist and Adjustable Profiling Beds — Bedrooms (H2)
3. Roll-in Shower and Accessible Washroom — Wet Room (H2)
4. A Comfortable Place to Come Back To — Living Room (H2)
5. Wheel-Under Kitchen, Ready for Everyday Meals (H2)
6. Sunny Dining Space with Level Garden Access — Conservatory (H2)
7. Level Patio, Enclosed Garden, and Private Driveway — Outside (H2)
8. See More of the Bungalow — Photos (H2)
9. Care Support, Arranged Separately — Optional Care (H2)
10. A Quiet Whitstable Base Near the Coast Path — Location (H2)

## Meta Information

**Meta Title:** Accessible Bungalow Whitstable | Restwell Retreats
**Meta Description:** Accessible bungalow Whitstable: single-storey, step-free layout with room-by-room specs, inclusions and optional care for your party.
**Page title:** The Property
**Slug:** /the-property/

---

## Page Copy (matches current mockup structure)

### Header
Nav: Home · The Bungalow (The Property, Accessibility, Pricing, How It Works) · Plan your trip (Who It's For, Whitstable, Funding & Support, Optional care) · FAQ · Blog
CTA: Enquire Now

### Section 1 — Hero
Breadcrumb: Home / The Property
H1: Inside the accessible bungalow in Whitstable
Subheading: A room-by-room look at Restwell: the bedrooms, wet room, living spaces, kitchen, garden and access equipment already in place.

### Subnav
Bedrooms · Wet room · Living · Kitchen · Conservatory · Outside · Photos · Care · Location

### Section 2 — Bedrooms
Eyebrow: Bedrooms
H2: Ceiling hoist and adjustable profiling beds
Lede: The accessible bedroom is set up for comfortable transfers and restful nights, with a full-room ceiling track hoist and one or two adjustable profiling beds.
Body: A second double bedroom sits next door, and the conservatory has a double sofa bed for occasional overnight stays. A mobile hoist and stand-aid, often known as a Sara Stedy, are also available.
CTA: Door widths and equipment notes → Accessibility page

### Section 3 — Wet room
Eyebrow: Wet room
H2: Roll-in shower and accessible washroom
Lede: The step-free wet room includes a roll-in shower, grab rails, shower and commode chairs, a tilt-in-space chair, a height-adjustable 180° spin wash basin, and a Geberit AquaClean wash-dry WC.
Body: It's designed to make washing, toileting, and transfers more manageable during your stay.

### Section 4 — Living
Eyebrow: Living room
H2: A comfortable place to come back to
Lede: After time by the sea, the living room gives everyone space to settle in.
Body: There's a rise-and-recline armchair, a sofa with pull-out footrests, and a TV with Netflix. The open-plan layout helps wheelchair users, family members, and carers move around without the room feeling crowded.

### Section 5 — Kitchen
Eyebrow: Kitchen
H2: Wheel-under kitchen, ready for everyday meals
Lede: The kitchen includes a lowered wheel-under worksurface, slide-under oven, microwave, fridge, dishwasher, plates, cutlery, utensils, and cooking basics.
Body: It's practical for simple breakfasts, family meals, and relaxed evenings in.

### Section 6 — Conservatory
Eyebrow: Conservatory
H2: Sunny dining space with level garden access
Lede: The conservatory is a bright extra room for eating, reading, or looking out onto the garden.
Body: It has a fold-out dining table, a double sofa bed, level access to the patio, and laundry cupboards with a washing machine and tumble dryer.

### Section 7 — Outside
Eyebrow: Outside
H2: Level patio, enclosed garden, and private driveway
Lede: French doors open onto a level patio through a non-slip threshold ramp.
Body: The fully enclosed, dog-friendly garden has outdoor seating, a BBQ, and fairy lights, so you can eat outside or let the dog out safely. At the front, the resin-bound level-access driveway has parking for two cars and has been tested with two wheelchair accessible vehicles. Portable ramps are stored in the outdoor box beside the front door, ready to use around the property or take out during your stay.

### Section 8 — Photos
Eyebrow: Photos
H2: See more of the bungalow
Gallery: 9 images, each with descriptive alt text (wet room shower, bedroom hoist, second bedroom, kitchen, living room, armchair, conservatory doors, garden, entrance)

### Section 9 — Optional care
Eyebrow: Optional care
H2: Care support, arranged separately
Lede: Professional care support is available on site through Continuity, our CQC-regulated sister company.
Body: Care is optional, arranged separately, and never bundled into the bungalow rate. If you'd like support during your stay, we can explain how it works before you book.
CTA: How optional care works → Care page

### Section 10 — Location
Eyebrow: Location
H2: A quiet Whitstable base near the coast path
Lede: The bungalow sits on a quiet street, a short walk from The Plough pub and around 10–15 minutes from Tankerton promenade.
Body: The beach is shingle, but the wide, paved promenade offers a step-free route along the coast and forms part of the King Charles III England Coast Path. For practical route notes, local recommendations, and access information, read our Whitstable accessibility guide.

### Section 11 — Mid CTA
Heading: Ready to check availability?
Body: Tell us your preferred dates, group size, and any access or equipment needs. We'll reply with availability, measurements, equipment details, and next steps.
Primary CTA: Enquire Now
Secondary CTA: Read accessibility details

### Footer
Restwell · Sister company: Continuity of Care Services · CQC inspection profile · Accessible holidays, Whitstable, Kent
Footer links: FAQ · Privacy Policy · Terms & Conditions · Website accessibility
Copyright: © 2026 Homely Housing Investments Ltd t/a Restwell Retreats. All rights reserved.
