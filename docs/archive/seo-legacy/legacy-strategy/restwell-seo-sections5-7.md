> **Archived 2026-07-05.** Superseded by [`restwell-theme/SEO-INTENT-ONPAGE-PLAN.md`](../restwell-theme/SEO-INTENT-ONPAGE-PLAN.md) (site SEO SSOT), [`FRONT-PAGE-OPTIMIZATION.md`](../FRONT-PAGE-OPTIMIZATION.md) (homepage), and/or [`restwell-theme/AUDIT.md`](../restwell-theme/AUDIT.md). Open work: SSOT §11.6 / §16 and AUDIT sprint plan. Do not execute tasks from this file.

# Restwell Retreats — SEO Sections 5–7

---

# SECTION 5 — INTERNAL LINKING STRATEGY

---

## Core Page Cross-Links

| Source Page | Target Page | Suggested Anchor Text | Context / Rationale |
|------------|-------------|----------------------|---------------------|
| Homepage | The Property | "a comfortable, well-equipped bungalow" | Intro paragraph — natural description link |
| Homepage | Accessibility Features | "ceiling track hoist, profiling bed, roll-in shower" | Equipment mention in "What's here" block |
| Homepage | Location Guide | "Whitstable is oysters and sea air" | Opening paragraph or Location block |
| Homepage | Who It's For | "occupational therapists and case managers" | Who Stays With Us block |
| Homepage | Booking | "Check availability" or "get in touch" | CTA block |
| The Property | Accessibility Features | "full accessibility specification" | After equipment mentions — for OTs wanting detail |
| The Property | Location Guide | "five minutes from the seafront" | Location context within property description |
| The Property | Booking | "book your stay" or "check availability" | End-of-page CTA |
| Accessibility Features | The Property | "see the full property" | After spec detail — link to the lifestyle context |
| Accessibility Features | Who It's For (OT section) | "for occupational therapists assessing suitability" | Professional audience cross-reference |
| Accessibility Features | FAQ | "common questions about our equipment" | Supporting content link |
| Accessibility Features | Booking | "talk through your needs before booking" | CTA — emphasises pre-booking conversation |
| Who It's For | Accessibility Features | "full equipment and access specification" | OT/commissioner section needs this link |
| Who It's For | Booking | "enquire about availability" | Each audience section should end with a CTA |
| Who It's For | FAQ | "how funding works" | Commissioner section — link to funding FAQ |
| Who It's For | The Property | "see the property" | Family section — link to the experience-focused page |
| Location Guide | The Property | "the property" or "back at the bungalow" | Natural reference within getting around info |
| Location Guide | Booking | "book your Kent coast holiday" | End-of-page CTA |
| Booking | The Property | "see the property" | Within "What's included" |
| Booking | Accessibility Features | "full accessibility details" | Within "What to tell us" |
| Booking | FAQ | "cancellation policy" or "funding questions" | Policy cross-references |
| FAQ | Accessibility Features | "see our full accessibility specification" | Answer to equipment questions |
| FAQ | Booking | "get in touch to book" | Answer to booking process questions |
| FAQ | The Property | "about the bungalow" | Answer to property questions |
| FAQ | Who It's For | "how we work with commissioners" | Answer to funding questions |
| Contact | Booking | "ready to book?" | Contextual link for guests who land on contact first |
| Contact | FAQ | "check our FAQ first" | Reduce unnecessary enquiries |

---

## Blog → Core Page Links (with 5 Blog Topic Ideas)

| Blog Post Topic | Target Keyword | Internal Link Targets | Anchor Text Ideas |
|----------------|---------------|----------------------|-------------------|
| "What happened to Revitalise — and where to find accessible holidays now" | Revitalise alternatives, accessible respite holiday | Homepage, Who It's For, Booking | "accessible holiday accommodation in Kent", "book an accessible break" |
| "How to use your direct payment for a holiday" | direct payment holiday disabled, personal budget holiday | Who It's For (commissioner section), Booking, FAQ | "properties that accept direct payments", "enquire about funded stays" |
| "A guide to accessible beaches in Kent" | accessible beaches Kent, wheelchair friendly beach Kent | Location Guide, The Property, Booking | "our base in Whitstable", "accessible coastal holiday" |
| "What to look for when booking an accessible holiday cottage" | accessible holiday cottage checklist, what to ask | Accessibility Features, The Property, FAQ | "our full accessibility specification", "what we provide" |
| "Whitstable in winter — why the Kent coast is worth visiting year-round" | Whitstable winter holiday, off-season Kent coast | Location Guide, Booking, The Property | "a winter break in Whitstable", "book a short break" |

---

## Footer Link Recommendations

**Primary footer nav:**
- The Property
- Accessibility
- Who It's For
- Whitstable Guide
- Booking
- FAQ
- Contact

**Footer utility links:**
- Privacy Policy
- Cancellation Policy
- Access Statement (PDF download)

**Footer content:**
- Address: 101 Russell Drive, Whitstable, CT5 2RQ
- Phone number
- Email
- "Part of The Continuity Group" with link to CCS website (cross-domain link equity)

---

## Hub-and-Spoke Structure

**Hub page:** Accessibility Features (`/accessibility`)

**Spoke pages:**
- FAQ answers about specific equipment
- Blog posts about accessible travel planning
- Blog posts about equipment and what to expect
- Access Statement PDF (linked from hub, also from Booking and Contact)

**Rationale:** The Accessibility Features page is the natural authority hub for all disability/access-related content. It should accumulate the most internal links from access-related blog content, FAQ answers, and property page references. This concentrates topical authority on the page most likely to rank for high-value terms like "holiday cottage with hoist Kent" and "wheelchair accessible holiday cottage Kent."

---

## Orphan Page Risks

| Potential Orphan | Risk Level | Fix |
|-----------------|-----------|-----|
| Individual blog posts | Medium | Ensure every post is linked from at least the blog index AND one core page |
| Cancellation Policy (standalone page) | High | Link from Booking page, FAQ, and footer |
| Access Statement PDF | Medium | Link from Accessibility page, Booking page, and Who It's For |
| Privacy Policy | Low | Footer link is sufficient |
| Any future testimonial/case study pages | High | Must be linked from Who It's For and Homepage |

---

---

# SECTION 6 — TECHNICAL SEO RECOMMENDATIONS

---

## Schema Markup (JSON-LD)

### 1. LodgingBusiness (Primary — goes on Homepage)

```json
{
  "@context": "https://schema.org",
  "@type": "LodgingBusiness",
  "name": "Restwell Retreats",
  "description": "A fully adapted, wheelchair accessible holiday bungalow in Whitstable, Kent. Ceiling track hoist, profiling bed, roll-in shower. A real seaside holiday for disabled guests and their families.",
  "url": "https://restwellretreats.co.uk",
  "telephone": "[PHONE NUMBER]",
  "email": "[EMAIL]",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "101 Russell Drive",
    "addressLocality": "Whitstable",
    "addressRegion": "Kent",
    "postalCode": "CT5 2RQ",
    "addressCountry": "GB"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": 51.3605,
    "longitude": 1.0258
  },
  "image": "[PROPERTY IMAGE URL]",
  "amenityFeature": [
    { "@type": "LocationFeatureSpecification", "name": "Wheelchair Accessible", "value": true },
    { "@type": "LocationFeatureSpecification", "name": "Ceiling Track Hoist", "value": true },
    { "@type": "LocationFeatureSpecification", "name": "Profiling Bed", "value": true },
    { "@type": "LocationFeatureSpecification", "name": "Roll-in Shower", "value": true },
    { "@type": "LocationFeatureSpecification", "name": "Step-free Access", "value": true },
    { "@type": "LocationFeatureSpecification", "name": "Adapted Parking", "value": true },
    { "@type": "LocationFeatureSpecification", "name": "Pet Friendly", "value": true },
    { "@type": "LocationFeatureSpecification", "name": "Wi-Fi", "value": true }
  ],
  "checkinTime": "15:00",
  "checkoutTime": "11:00",
  "petsAllowed": true,
  "smokingAllowed": false,
  "numberOfRooms": 1,
  "tourBookingPage": "https://restwellretreats.co.uk/booking",
  "sameAs": [
    "[FACEBOOK URL IF APPLICABLE]",
    "[INSTAGRAM URL IF APPLICABLE]"
  ]
}
```

[NEEDS VERIFICATION: Exact latitude/longitude — I've estimated from CT5 2RQ. Phone, email, and social URLs to be added. Number of bedrooms to confirm.]

---

### 2. FAQPage (Goes on FAQ page)

```json
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "Is the property fully wheelchair accessible?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. The bungalow is fully wheelchair accessible throughout, with level threshold access, a front door width of 965mm, internal doors at 926mm, a ceiling track hoist, profiling bed, and a roll-in wet room shower."
      }
    },
    {
      "@type": "Question",
      "name": "Can my carer or support worker stay with me?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. The property can accommodate carers alongside guests. Please let us know when booking how many people will be staying so we can ensure the sleeping arrangements work for everyone."
      }
    },
    {
      "@type": "Question",
      "name": "Can I use my direct payment or personal budget to pay for a stay?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. We welcome guests whose stays are funded through direct payments, personal budgets, or continuing healthcare (CHC) arrangements. Please get in touch to discuss your specific funding situation."
      }
    },
    {
      "@type": "Question",
      "name": "Can I bring my dog?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. Dogs are welcome, including assistance dogs. Please let us know in advance so we can prepare the property. We have a dog policy that we will share with you before your stay."
      }
    },
    {
      "@type": "Question",
      "name": "How far is the property from the beach?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "The Whitstable seafront is approximately 5-10 minutes by car or 20-30 minutes on foot. The Stagecoach 400 bus also runs regularly from a stop near the property to the beach and harbour area."
      }
    }
  ]
}
```

---

### 3. BreadcrumbList (All pages)

```json
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "https://restwellretreats.co.uk"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "The Property",
      "item": "https://restwellretreats.co.uk/the-property"
    }
  ]
}
```

Implement dynamically in the PHP theme — generate breadcrumb schema based on the current page's position in the site hierarchy.

---

### 4. LocalBusiness (Supplementary — or use instead of LodgingBusiness if Google prefers)

Not needed separately. `LodgingBusiness` is a subtype of `LocalBusiness` and inherits all its properties. Using both would be redundant. Stick with `LodgingBusiness`.

---

### 5. Review / AggregateRating

**Don't implement yet.** Only add Review schema when you have genuine, verifiable reviews. Google penalises self-generated review markup. Once you have Google reviews via GBP, those will display automatically in search. If you later add a testimonials page with verified guest reviews, you could add Review schema then — but GBP reviews are more trusted by Google.

---

## Page Speed Priorities

For a classic PHP WordPress theme with no page builder, you're already ahead of most WordPress sites. Focus on:

1. **Images:** Serve WebP format with fallbacks. Use `srcset` and `sizes` attributes for responsive images. Lazy-load all images below the fold (`loading="lazy"`). Compress aggressively — property photos should be under 200KB each at display resolution. Consider generating multiple sizes in your theme's `functions.php` via `add_image_size()`.

2. **Fonts:** Use system fonts or limit to 2 web fonts max (Lora + Inter per brand spec). Self-host font files rather than loading from Google Fonts CDN — eliminates a render-blocking request and a third-party connection. Subset fonts to Latin characters only. Use `font-display: swap`.

3. **CSS/JS:** With no build tools, keep CSS in a single minified stylesheet. Inline critical CSS for above-the-fold content if feasible. Defer any JavaScript that isn't essential for initial render. Avoid jQuery unless WordPress core forces it.

4. **No heavy plugins:** This is your biggest advantage. Avoid Yoast/RankMath's full plugin (the SEO meta fields are useful but the frontend output is bloated — consider implementing schema and meta tags directly in theme code instead). Avoid any plugin that injects CSS/JS on the frontend. If you need a contact form, use a lightweight one (WPForms Lite or hand-code it).

5. **Server:** Use a caching plugin (WP Super Cache or similar lightweight option). Enable Gzip/Brotli compression. Set long cache headers for static assets.

---

## Core Web Vitals

| Metric | Target | Key Actions |
|--------|--------|-------------|
| **LCP** (Largest Contentful Paint) | < 2.5s | Optimise hero image (preload it, serve correct size, WebP). Avoid layout shifts from font loading. |
| **INP** (Interaction to Next Paint) | < 200ms | Minimal JS = minimal risk here. Avoid heavy click handlers. |
| **CLS** (Cumulative Layout Shift) | < 0.1 | Set explicit `width` and `height` on all images. Avoid dynamically injected content above the fold. Don't use web fonts without `font-display: swap`. |

---

## XML Sitemap

Structure:

```
sitemap.xml (index)
├── sitemap-pages.xml (all core pages — ~8-9 URLs)
├── sitemap-posts.xml (blog posts — grows over time)
└── sitemap-images.xml (optional — property photos with descriptive captions)
```

If not using a plugin, generate the sitemap with a simple PHP script in the theme that queries published pages and posts. Submit to Google Search Console on launch.

**Include:** All core pages, blog posts, the blog index.
**Exclude:** Tag/category archives (unless you have a deliberate taxonomy strategy), author pages, search results, any utility pages (privacy policy, cancellation policy — these don't need indexing but excluding them from sitemap is enough).

---

## Robots.txt

```
User-agent: *
Allow: /

Disallow: /wp-admin/
Allow: /wp-admin/admin-ajax.php

Sitemap: https://restwellretreats.co.uk/sitemap.xml
```

Keep it simple. Don't block CSS/JS files (Google needs them to render pages). Don't block `/wp-content/uploads/` (your images need indexing).

---

## Canonical Tags

Implement `<link rel="canonical" href="...">` on every page, pointing to itself. This is standard and prevents duplicate content issues from query string parameters (e.g. UTM tracking codes, pagination).

**Specific cases:**
- If you use a booking/calendar system that generates URLs with date parameters (e.g. `/booking?date=2026-04-15`), canonicalise all variants back to `/booking`.
- If blog posts can be accessed via both `/blog/post-slug` and a category path like `/blog/category/post-slug`, canonicalise to the shorter URL.
- The homepage should canonicalise to `https://restwellretreats.co.uk/` (with trailing slash, HTTPS, no www — pick one format and enforce it via redirect).

---

## Hreflang

**Not needed.** This is an English-language site serving a UK audience. Hreflang is only necessary for multilingual or multi-regional sites (e.g. separate en-GB and en-US versions). Skip it entirely.

---

## Heading Hierarchy Rules

Enforce these across the theme:

1. **One H1 per page.** No exceptions. The H1 should be the page title visible on the page (not the `<title>` tag — that's separate).
2. **H2s for major sections.** Don't skip from H1 to H3.
3. **H3s for sub-sections within an H2 block.** Use sparingly.
4. **Never use headings for visual styling.** If you want big bold text that isn't a section heading, style a `<p>` or `<span>` instead. Screen readers use heading hierarchy for navigation.
5. **Blog posts:** H1 = post title. H2s = major sections. H3s = sub-points. Writers (you) should follow this consistently.
6. **Sidebar/footer headings:** These should be H3 or lower, or styled `<span>` elements — never H1 or H2, as they'd break the page's heading hierarchy.

In the PHP theme, enforce the H1 output from the template (not from the WordPress editor) so it's always structurally correct.

---

---

# SECTION 7 — GOOGLE BUSINESS PROFILE OPTIMISATION

---

## Business Category Recommendations

| Type | Category |
|------|----------|
| **Primary** | Holiday rental |
| **Secondary 1** | Vacation home rental agency |
| **Secondary 2** | Cottage rental |

**Note:** Google doesn't have a specific "accessible holiday accommodation" category. "Holiday rental" is the closest primary. Adding "Cottage rental" as secondary captures slightly different search behaviour. Don't add "Disabled persons service" or similar — it miscategorises the business and could trigger the wrong kind of search results.

---

## Business Description (750 character max)

> Restwell Retreats is a fully adapted holiday bungalow in Whitstable on the Kent coast. The property is wheelchair accessible throughout, with a ceiling track hoist, profiling bed, roll-in shower, wide doorways, and step-free access from parking to every room. It is a genuine holiday home — not a care facility. Guests include families, couples, and individuals who need accessible accommodation and want a real seaside break. Carers and support workers are welcome. We accept bookings from individuals, occupational therapists, case managers, and local authority commissioners. Assistance dogs and pets are welcome. Whitstable is eight miles from Canterbury and an hour and a half from London by train.

*Character count: 698*

---

## Services List

| Service | Description |
|---------|-------------|
| Accessible holiday accommodation | Fully wheelchair accessible self-catering bungalow with ceiling track hoist, profiling bed, and roll-in shower. |
| Short breaks | Stays of 2+ nights available throughout the year. Flexible check-in/out for guests with accessibility needs. |
| Self-catering holiday let | Fully equipped kitchen, Wi-Fi, parking for adapted vehicles. Everything you need for an independent break. |
| Dog-friendly stays | Dogs welcome including assistance dogs. Advance notice required. |
| Respite and funded stays | We welcome guests whose stays are funded via direct payments, personal budgets, or local authority commissioning. |

---

## Q&A Seeds (Pre-populate on GBP)

**Q1:** Is the property suitable for a powered wheelchair?
**A1:** Yes. The bungalow has level threshold access throughout, a front door width of 965mm, and internal doors at 926mm. There is parking right outside with step-free access to the entrance, and all rooms are on one level with space to manoeuvre.

**Q2:** Can my carer or support worker stay with me?
**A2:** Absolutely. The property can accommodate carers alongside guests. Just let us know when you book so we can make sure the sleeping arrangements work for everyone.

**Q3:** Is the beach accessible from the property?
**A3:** The Whitstable seafront is about 5–10 minutes by car. The promenade at Tankerton is largely flat and paved, making it accessible for wheelchair users. Getting onto the shingle beach itself requires a slope onto pebbles, so it depends on your equipment. The 400 bus also runs from near the property to the beach area.

**Q4:** Do you accept direct payments or local authority funding?
**A4:** Yes. We welcome guests whose stays are funded through direct payments, personal budgets, or continuing healthcare (CHC) arrangements. Get in touch and we can discuss your situation.

**Q5:** Is the property available over Christmas / New Year?
**A5:** We take bookings throughout the year, including holiday periods. Availability varies so please enquire as early as possible for peak dates.

---

## GBP Post Templates

### Post 1 — Awareness

**Image suggestion:** Wide shot of the bungalow exterior or a Whitstable seafront view

**Text:**
Restwell Retreats is a fully adapted holiday bungalow in Whitstable, Kent — five minutes from the seafront. Ceiling track hoist, profiling bed, roll-in shower, step-free throughout. A proper seaside holiday in a property that actually works for you.

**CTA button:** Learn more → restwellretreats.co.uk

---

### Post 2 — Consideration

**Image suggestion:** Interior shot — living area or bedroom showing the space and comfort

**Text:**
Looking for an accessible self-catering break on the Kent coast? Our bungalow in Whitstable is wheelchair accessible throughout, with parking for adapted vehicles and room for carers. Canterbury is 8 miles away. London is 90 minutes by train. Dogs welcome.

**CTA button:** Book now → restwellretreats.co.uk/booking

---

### Post 3 — Booking / Seasonal

**Image suggestion:** Whitstable harbour or beach in relevant season

**Text:**
Summer availability now open at Restwell Retreats. Whitstable's oyster festival, harbour walks, and seafood — all from a fully accessible base. Short breaks and weekly stays available. Book direct for the best rate.

**CTA button:** Book now → restwellretreats.co.uk/booking

---

## Review Response Templates

### Template 1 — Warm positive review

> Thank you so much — it means a lot to hear that you had a good stay. Whitstable is a special place and we're glad the bungalow worked well for you. We hope to see you back on the Kent coast soon.

### Template 2 — Positive review mentioning accessibility specifically

> Thank you for taking the time to leave a review. We're really pleased the accessibility features worked well for you — that's exactly what we've set out to do. If there's anything we can improve for next time, we're always happy to hear feedback. Hope to welcome you again.

### Template 3 — Positive review mentioning carer/family stay

> Thank you — it's wonderful to hear that the whole group had a good break. We know how much it matters to find somewhere that works for everyone, and we're glad Restwell delivered. See you next time.

---

## Photo Strategy

### Categories to upload (with alt text approach)

| Photo Category | Alt Text Approach | Priority |
|---------------|-------------------|----------|
| Exterior — front of property | "Accessible holiday bungalow exterior, 101 Russell Drive, Whitstable" | **High** |
| Entrance — showing level access | "Step-free entrance to Restwell Retreats holiday bungalow" | **High** |
| Living area — wide shot | "Open plan living area in adapted holiday bungalow, Whitstable" | **High** |
| Bedroom — showing profiling bed | "Bedroom with profiling bed at Restwell Retreats accessible holiday let" | **High** |
| Bathroom — roll-in shower | "Roll-in wet room shower with grab rails at Restwell Retreats" | **High** |
| Bathroom — wider view | "Accessible bathroom with roll-in shower, adapted holiday bungalow Kent" | **Medium** |
| Kitchen | "Kitchen in self-catering accessible holiday bungalow, Whitstable" | **Medium** |
| Parking area | "Parking for adapted vehicles at Restwell Retreats, Whitstable" | **Medium** |
| Doorway width shot | "Wide internal doorway (926mm) in wheelchair accessible holiday cottage" | **Medium** |
| Ceiling hoist | "Ceiling track hoist in bedroom, Restwell Retreats accessible accommodation" | **Medium** |
| Local area — Whitstable seafront | "Whitstable seafront near Restwell Retreats accessible holiday let" | **Low** |
| Local area — harbour | "Whitstable harbour, five minutes from Restwell Retreats" | **Low** |

**Guidelines:**
- Upload at least 10 photos to GBP before launch.
- Prioritise interior accessibility shots — these are what OTs and families assess from.
- Use natural lighting. Avoid wide-angle distortion that makes rooms look larger than they are.
- Don't use stock photos. Ever.
- Update seasonally — a winter exterior shot, a summer garden shot. Fresh photos signal an active listing.
