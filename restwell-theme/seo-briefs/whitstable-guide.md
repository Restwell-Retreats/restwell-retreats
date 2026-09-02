# SEO Content Brief — Whitstable Area Guide

Source page: `restwell-theme/template-whitstable-guide.php`

## 1. Keyword Strategy

SEO recommendations: this is the site's strongest local-SEO page — named venues, phone numbers, specific parking schemes (Harbour ANPR, Blue Badge bays), and travel times. That specificity is what should carry the keyword weight, not extra adjectives. Local-intent searches ("is Whitstable accessible for wheelchair users") are already directly answered in the FAQ.

- **Primary keyword:** "Whitstable Kent coast" *(existing focus keyphrase — `inc/seo-content-seed-meta.php`, slug `whitstable-area-guide`)*
- **Secondary keywords:** "wheelchair accessible Whitstable", "Blue Badge parking Whitstable", "accessible days out Kent coast", "step-free promenade Tankerton"

Meta title, meta description and H1 are already in sync with the seed keyphrase (confirmed during the earlier audit). The FAQ column already targets "is Whitstable accessible for disabled visitors," "what is Whitstable like for wheelchair users," and "how do I plan a wheelchair coastal holiday near Whitstable" — this is exactly the long-tail coverage a local guide needs. No changes recommended there.

## 2. Content Structure & Enhancements

- **Travel times stat row:** London drive/train times plus a 15-minute walk to the promenade — good, keep as numeric strip, don't turn into prose.
- **Promenade section:** honest distinction between the paved promenade (accessible) and the shingle/Street spit (not) — this kind of specific caveat is exactly what prevents a bad-fit booking and builds trust; don't soften it for SEO reasons.
- **Parking section:** genuinely excellent local content — Harbour ANPR pre-registration requirement is the kind of specific, easy-to-miss detail that ranks well and gets cited because most content in this space is generic ("plenty of parking available").
- **Stops-along-the-route cards (Castle, Harbour, Old Neptune):** each has a concrete access note ("terrace on firm ground is the realistic option — sloping floors inside, no step-free entrance") rather than blanket "accessible" claims — keep this pattern, it's a real differentiator against typical tourism-board copy.
- **Eat section:** three named venues with phone numbers and specific access notes (e.g. "step-free entry; no accessible toilet — confirm on the day") — same strength, keep as-is.
- **Toilets section:** lists the actual Changing Places location and RADAR key requirement — high-value, specific local content.
- **Travel (station/buses/taxis):** appropriately hedges ("access varies by platform — check National Rail before you travel") rather than overclaiming — correct approach for content that could otherwise create liability if wrong.
- **Days out cards:** three external venues (Wildwood, Dreamland, Canterbury) each with an access note and outbound link — good internal/external linking balance.

## 3. Technical SEO

- **Meta title (existing, in sync):** `Whitstable Kent Coast Guide | Days Out | Restwell Retreats` — 58 characters.
- **Meta description (existing, in sync):** `The Whitstable Kent coast: accessible days out in Canterbury, Faversham, Herne Bay, Tankerton. Where to eat, promenade walks, parking, and travel tips.` — 151 characters.
- **Headings:** single H1, clean H2 ladder across nine sections. Uses `hero--place` (photo-backed hero) rather than the plain interior hero used elsewhere — appropriate for a destination-guide page.
- **Image alt text:** consistently descriptive (e.g. "Colourful beach huts along the Whitstable seafront", "Russell Drive neighbourhood near Tankerton") — good sitewide standard maintained.
- **External links:** correctly use `target="_blank" rel="noopener noreferrer"` with `sr-only` "(opens in new tab)" text — good accessibility practice, doesn't need to change.
- **URL/slug:** live slug is `/whitstable-area-guide/`.

## 4. User Experience & Conversion

- Subnav covers six anchors (Promenade/Parking/Eat/Toilets/Days out/FAQ) — appropriate for the longest page on the site.
- Direct phone links (`tel:`) on every named venue — good for mobile users planning on the go.
- Mid-CTA connects the guide back to booking ("Ask for route notes for your party" → Enquire, "See the bungalow" → Property) — correctly closes the loop from research back to conversion.

## 5. Content Length

This is comfortably the longest page on the site once every section is counted, likely 1,500+ words — appropriate, since it's competing on depth of local knowledge rather than a quick answer. Don't trim it; if anything this is the page most likely to attract organic backlinks and AI-answer citations because of its specificity.

---

## Example Outline

1. Whitstable Kent Coast Access Guide (H1)
2. Tankerton Promenade (H2)
3. At the House and in Town — Parking (H2)
4. Castle, Harbour and Beach Pub — Along the Route (H2)
5. Pubs and Restaurants Near the House — Eat (H2)
6. Accessible Toilets (H2)
7. Station, Buses and Taxis — Getting Around (H2)
8. Wildwood, Dreamland and Canterbury — Days Out (H2)
9. Whitstable & Coast FAQ (H2)

## Meta Information

**Meta Title:** Whitstable Kent Coast Guide | Days Out | Restwell Retreats
**Meta Description:** The Whitstable Kent coast: accessible days out in Canterbury, Faversham, Herne Bay, Tankerton. Where to eat, promenade walks, parking, and travel tips.
**Page title:** Whitstable
**Slug:** /whitstable-area-guide/

---

## Page Copy (matches current mockup structure)

### Header
Nav: Home · The Bungalow (The Property, Accessibility, Pricing, How It Works) · Plan your trip (Who It's For, Whitstable, Funding & Support, Optional care) · FAQ · Blog
CTA: Enquire Now

### Section 1 — Hero (photo-backed)
Breadcrumb: Home / Whitstable
H1: Whitstable Kent coast access guide
Subheading: Promenade routes, Blue Badge parking, toilets, eating out and day trips, written for wheelchair users and carers staying at Restwell.

### Subnav
Promenade · Parking · Eat · Toilets · Days out · FAQ

### Section 2 — Travel times (stat row)
~90 min — Drive from London (M2/A299)
75–90 min — Direct train — check National Rail
15 min — Walk to Tankerton promenade

### Section 3 — Promenade
Eyebrow: Coastal walk
H2: Tankerton promenade
Lede: About two miles of paved route from Tankerton Slopes toward the castle and harbour. Beach slopes to the shingle are steep — stick to the promenade for level sea air.
Checklist: Wide, surfaced path with weather shelters and benches · At low tide you can watch The Street spit — loose shingle, not a wheelchair route · Level route from Restwell — no steps on the approach

### Section 4 — Parking
Eyebrow: Parking, plainly
H2: At the house and in town
Lede: Start from the driveway when you can. Harbour ANPR is the one that catches people out.
At Restwell: Two off-road spaces on the private driveway — level, step-free to the front door. Street parking outside usually works for overflow; check signs on arrival.
Marine Parade & Tankerton: Free Blue Badge bays along Marine Parade (display badge, no app). Tankerton Road Car Park gives three hours free with a physical badge.
Callout — Harbour ANPR: Gorrell Tank and Keam's Yard need your vehicle and Blue Badge pre-registered online. Parking at Tankerton Road and rolling the promenade is usually easier.
Links: Register Blue Badge for ANPR · Blue Badge parking (CCC)

### Section 5 — Along the route
Eyebrow: Along the route
H2: Castle, harbour and beach pub
Lede: Level stops on the promenade route, with access notes and links so you can check opening times before you set out.
Whitstable Castle & Gardens — Promenade stop: Paved grounds and Orangery Tearooms with an accessible loo — a level stop about halfway along the promenade.
Whitstable Harbour — Town & seafood: Working oyster port. South Quay Shed has a lift to a quieter upper floor. Surfaces can be uneven — take it steady at peak times.
The Old Neptune — Beach pub: Pub on the shingle. The terrace on firm ground is the realistic option — sloping floors inside, no step-free entrance.

### Section 6 — Eat
Eyebrow: Places to eat
H2: Pubs and restaurants near the house
Lede: The Plough is around the corner; JoJo's and the Marine Hotel sit on Tankerton. Most Whitstable venues are older buildings — call ahead if access is critical.
The Plough Inn, Swalecliffe — Nearest pub, CT5 2RN: Around the corner via the footpath between 71 and 73 Russell Drive. Step-free entry; no accessible toilet — confirm on the day if that matters.
JoJo's, Tankerton — 2 Herne Bay Road, CT5 2LQ: Clifftop Mediterranean favourite. Wheelchair access and accessible toilet. Book ahead — it fills quickly.
Marine Hotel, Tankerton — 32–33 Marine Parade, CT5 2BE: Ground-floor lounge and restaurant, step-free, accessible loo by reception. Sea views from Marine Parade.

### Section 7 — Toilets
Eyebrow: Loos along the way
H2: Accessible toilets
Lede: Public and venue loos on the promenade route. Changing Places at the harbour needs a RADAR key.
List: Behind the sailing club at the foot of the slopes · By the Marine Parade cafe at the top · Under the promenade cafe near the castle · Changing Places — Whitstable Harbour WC, Harbour Road · JoJo's Tankerton and Marine Hotel (venue accessible loos)
Link: Changing Places map

### Section 8 — Getting around
Eyebrow: Getting around
H2: Station, buses and taxis
Lede: Travel times from London are in the strip above. Below: how to move around Whitstable once you've arrived.
Station: Whitstable station access varies by platform — check National Rail before you travel. About 20–30 minutes' walk from the bungalow on paved routes, or a short taxi.
Buses: Stagecoach South East route 400 links The Plough area toward the beach, harbour and Canterbury. Low-floor space can vary — same-day check.
Accessible taxis: Pre-book on busy days. Abacus Cars: 01227 277745.

### Section 9 — Days out
Eyebrow: Further afield
H2: Wildwood, Dreamland and Canterbury
Lede: Check each venue's site for scooter hire, companion tickets and parking for your dates.
Wildwood, Herne Bay: ~30 minutes. Mostly accessible woodland paths; scooters bookable ahead on 01227 209621.
Dreamland, Margate: Wheelchair accessible park; Nimbus Access Card and Essential Companion scheme. Accessible parking nearby.
Canterbury: ~20 minutes by car. Cathedral Welcome Centre lends wheelchairs; riverside and Westgate Gardens are smoother than the cobbles.

### Section 10 — Whitstable & coast FAQ (7 questions, two columns)
1. Is Whitstable accessible for disabled visitors?
2. What is Whitstable like for wheelchair users?
3. Is Whitstable suitable for wheelchair users?
4. Where can I find step-free routes on the Kent coast?
5. How do I plan a wheelchair coastal holiday near Whitstable?
6. What makes an accessible beach day work here?
7. What should I look for in an accessible seaside holiday in Kent?

### Section 11 — Mid CTA
Heading: Ask for route notes for your party
Body: Tell us chair size and energy levels — then see the bungalow on Russell Drive.
Primary CTA: Enquire Now
Secondary CTA: See the bungalow

### Footer
Restwell · Sister company: Continuity of Care Services · CQC inspection profile · Accessible holidays, Whitstable, Kent
Footer links: FAQ · Privacy Policy · Terms & Conditions · Website accessibility
Copyright: © 2026 Homely Housing Investments Ltd t/a Restwell Retreats. All rights reserved.
