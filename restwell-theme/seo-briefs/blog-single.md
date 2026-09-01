# SEO Content Brief — Blog Article Template

Source page: `restwell-theme/mockups/blog-single-concept.html`
Worked example used throughout: "Accessible beaches and promenades near Whitstable"

## 1. Keyword Strategy

**Note on scope:** unlike the other pages in this batch, blog articles don't have one fixed keyphrase in `inc/seo-content-seed-meta.php` — each post needs its own target, set per-article as it's written. This brief uses the existing worked-example article to show the pattern; apply the same approach (one primary phrase per article, tightly scoped to that article's actual topic) to every future post rather than reusing sitewide phrases like "accessible holiday Whitstable" on every article, which would just create keyword cannibalisation against the homepage and Property page.

- **This article's primary keyword (proposed):** "Accessible beaches Whitstable"
- **This article's secondary keywords (proposed):** "wheelchair friendly promenade Kent", "step-free beach access Whitstable", "Tankerton promenade wheelchair"
- **Pattern for future posts:** pick a keyword scoped to the specific place, activity or funding topic the post covers ("what to pack for an accessible coastal stay" → "accessible holiday packing list", "direct payments short overview" → "direct payments holiday accommodation") rather than a generic accessible-travel phrase already owned by another page.

## 2. Content Structure & Enhancements

- **Opening paragraph:** already leads with the practical recommendation ("aim for Whitstable's paved promenade — not the shingle") rather than throat-clearing — good, keep this pattern for future posts; the keyword should appear naturally in this first paragraph, not just the H1.
- **Three H2 sections (Start at Tankerton / Harbour and town / About the beach):** short, scannable, each answers one specific question a reader would have — good structure for both readability and potential featured-snippet pickup.
- **Honest limitations stated plainly** ("Harbour Street can be narrow, and some shop entrances are stepped," "the beach itself is shingle. Chairs don't roll well on it.") — this is the same trust-building pattern used across the rest of the site; don't let future posts drift toward generic "fully accessible!" marketing language.
- **Closing link-stack** to the full Whitstable guide and Property accessibility page — good practice, avoids the article trying to be the single source of truth for information that lives more completely elsewhere.
- **Tag row at the end (Whitstable / Access / Promenade):** three tags feels right; avoid over-tagging future posts past 3–4, since the tags aren't currently wired to filtering (see Technical SEO).

## 3. Technical SEO

- **Missing `Article`/`BlogPosting` schema:** this template has no JSON-LD at all — a real gap given the blog is explicitly a content-marketing play (per the site's `SEO-INTENT-ONPAGE-PLAN.md`). Add `BlogPosting` schema (headline, datePublished, author, image) once this becomes a live WordPress template, so posts are eligible for article rich results.
- **Meta title (this article, existing):** `Accessible Beaches Near Whitstable | Restwell` — 45 characters, room to be more descriptive without exceeding 60.
- **Meta description (this article, existing):** `Accessible beaches and promenades near Whitstable: Tankerton's level path, harbour limits, and why the shingle beach is not the wheelchair route.` — 149 characters.
- **Headings:** single H1, three H2s, no skips.
- **`blog-meta` byline:** shows category tag, read time, and "Restwell team" as author — reasonable for a house-voice blog without individual bylines; if specific writers are ever credited, that pairs naturally with the `author` field in `BlogPosting` schema above.
- **Related reading images:** all three had empty `alt=""` before this session — fixed and verified (now "Guest relaxing on the Whitstable seafront," "Whitstable seafront view from the promenade," "Step-free entrance to the Restwell bungalow"). Carry this fix into every future post that reuses this "Related reading" card pattern.
- **No mid-CTA on this page** — intentional per site design constraints (related posts + nav Enquire already serve that role). Don't add one when this becomes a live template.
- **URL/slug pattern:** individual posts will need their own slugs once live (e.g. `/blog/accessible-beaches-promenades-whitstable/` or similar) — not yet defined in the seed file since this is a template, not a fixed page.

## 4. User Experience & Conversion

- Breadcrumb correctly shows Blog / Article rather than Home / Article — keeps the reader oriented within the blog section specifically.
- Related reading cards use the same photo-plus-title pattern as the blog index (not yet upgraded to the overlay treatment built for the index this session) — worth revisiting for visual consistency once the index redesign is confirmed as the direction.
- `prose prose--wide` class gives a readable line measure for the article body — correct choice for long-form text.

## 5. Content Length

This worked example is short (~200 words) — reasonable for a quick, focused answer-style post, but future posts should vary in length by topic complexity rather than all matching this length. A funding-explainer post, for instance, will naturally run longer than a single-location access note like this one.

---

## Example Outline (this article)

1. Accessible Beaches and Promenades Near Whitstable (H1)
2. Start at Tankerton (H2)
3. Harbour and Town (H2)
4. About the Beach (H2)
5. Related Reading (H2)

## Meta Information (this article)

**Meta Title:** Accessible Beaches Near Whitstable | Restwell
**Meta Description:** Accessible beaches and promenades near Whitstable: Tankerton's level path, harbour limits, and why the shingle beach is not the wheelchair route.
**Page title:** Accessible beaches and promenades near Whitstable
**Slug:** /blog/accessible-beaches-promenades-whitstable/ *(proposed — not yet defined)*

---

## Page Copy (matches current mockup structure)

### Header
Nav: Home · The Bungalow (The Property, Accessibility, Pricing, How It Works) · Plan your trip (Who It's For, Whitstable, Funding & Support, Optional care) · FAQ · Blog
CTA: Enquire Now

### Section 1 — Hero
Breadcrumb: Blog / Article
H1: Accessible beaches and promenades near Whitstable
Subheading: Tankerton's level promenade, harbour limits, and why the shingle beach is not the wheelchair route.

### Section 2 — Article body
Meta: Area guide · 8 min read · Restwell team
Intro: If you use a wheelchair or mobility scooter, aim for Whitstable's paved promenade — not the shingle. Tankerton's seafront path is wide, level and long enough for a proper coastal outing from Restwell.

H2: Start at Tankerton
From Restwell, Tankerton promenade is about a 15-minute walk. The path is wide, level and surfaced for several miles. The grassy slopes above are steep; stay on the paved seafront route. Free parking is often available along Marine Parade at the top.

H2: Harbour and town
Harbour Street can be narrow, and some shop entrances are stepped. The harbour has a Changing Places toilet (RADAR key) and uneven surfaces in places. Take it steady, and call venues ahead if you need a table with step-free access.

H2: About the beach
The beach itself is shingle. Chairs don't roll well on it. Guests who want sea air without fighting the stones use the promenade above — the same route we map on the Whitstable guide.

Links: Full Whitstable guide · Property accessibility
Tags: Whitstable · Access · Promenade

### Section 3 — Related reading
H2: Related reading
Card: "What to pack" → blog-single (placeholder link)
Card: "Whitstable guide" → whitstable-guide-concept.html
Card: "The property" → property-concept.html

### Footer
Restwell · Sister company: Continuity of Care Services · CQC inspection profile · Accessible holidays, Whitstable, Kent
Footer links: FAQ · Privacy Policy · Terms & Conditions · Website accessibility
Copyright: © 2026 Homely Housing Investments Ltd t/a Restwell Retreats. All rights reserved.
