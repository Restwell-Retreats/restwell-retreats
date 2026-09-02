# SEO Content Brief — Blog (Index)

Source page: `restwell-theme/index.php` (posts listing)

## 1. Keyword Strategy

SEO recommendations: this is a listing/hub page — its own on-page copy is thin by design (three post previews), so its SEO value comes mostly from (a) driving internal link equity to the individual articles, and (b) each article's own keyword targeting once written. Don't over-optimise the index page itself at the expense of the article titles being genuinely descriptive.

- **Primary keyword:** "Accessible travel" *(existing focus keyphrase — `inc/seo-content-seed-meta.php`, slug `blog`)*
- **Secondary keywords:** "accessible days out Kent", "wheelchair-friendly travel guides", "accessible holiday planning tips"

## 2. Content Structure & Enhancements

- **Featured post card:** rebuilt this session as a full-bleed photo with a scrim and overlaid title/excerpt/category tag, echoing the homepage hero's visual language. The category tag ("Area guide") and read time sit directly on the image — keep new post tags short and consistent with the existing set (Area guide / Planning / Funding) rather than inventing a new taxonomy per post.
- **Grid cards (2-up):** same tag-on-photo pattern at smaller scale. As more posts are added, this should grow to a proper multi-post grid — the current 3-post total is a placeholder set, not a ceiling.
- **No mid-CTA on this page** — intentional per the site's design constraints (blog's primary actions are already on-page: post links plus the nav's Enquire button). Don't add one when porting to the live template.
- **Post titles as the real keyword surface:** since the index page itself carries little unique copy, make sure every post's `<h2>`/`<h3>` title is written to double as its own on-page SEO title — "Accessible beaches and promenades near Whitstable" and "Direct payments and short breaks: a plain overview" both already do this well (specific place/topic, not generic "Read more").

## 3. Technical SEO

- **Meta title (existing, in sync):** `Accessible Travel Blog | Kent Stories | Restwell Retreats` — 57 characters.
- **Meta description (existing, in sync):** `Accessible travel and Kent coast guides: days out, planning tips, funding news, and stories from guests with disabilities and carers.` — 133 characters.
- **Headings:** single H1, no visible H2 on the index itself (post titles are H2/H3 inside their own `<article>`) — correct for a card-grid listing page.
- **Image alt text:** all three post images have descriptive alt (`"Whitstable coastline"`, `"Marina at sunset"`, `"Aerial view of Whitstable"`) — fixed and verified this session (the "related reading" equivalents on the article template previously had empty `alt=""`, now corrected).
- **Whole-card click target:** each post's photo is now a real link to the article (`aria-hidden="true" tabindex="-1"` so screen readers hit only the one real title link, not a duplicate) — this was a genuine UX bug fix this session, not just cosmetic; previously only the small title text was clickable.
- **URL/slug:** live slug is `/blog/`.

## 4. User Experience & Conversion

- Featured-card hover lifts the image with a soft shadow; title underlines and shifts to the gold accent on hover — verified working, consistent with the sitewide link-hover language.
- `data-reveal` staggered scroll-in on the grid cards.
- Mobile-specific note: the featured card uses a taller 3:4 aspect ratio below 700px (vs. 21:9 cinematic above it) specifically because a wrapped 3-line headline needs the room — don't collapse this back to a single fixed ratio if the layout gets revisited later.

## 5. Content Length

Not applicable in the traditional sense — this is a card-grid index. Length concerns apply to the individual articles it links to (see `blog-single.md`), not this page.

---

## Example Outline

1. Accessible Travel Guides (H1)
2. *(Featured post card + 2-up grid — no further H2s on this page)*

## Meta Information

**Meta Title:** Accessible Travel Blog | Kent Stories | Restwell Retreats
**Meta Description:** Accessible travel and Kent coast guides: days out, planning tips, funding news, and stories from guests with disabilities and carers.
**Page title:** Blog
**Slug:** /blog/

---

## Page Copy (matches current mockup structure)

### Header
Nav: Home · The Bungalow (The Property, Accessibility, Pricing, How It Works) · Plan your trip (Who It's For, Whitstable, Funding & Support, Optional care) · FAQ · Blog
CTA: Enquire Now

### Section 1 — Hero
Breadcrumb: Home / Blog
H1: Accessible travel guides
Subheading: Access notes for Whitstable and the Kent coast, written for wheelchair users, carers and people planning funded stays.

### Section 2 — Featured post
Tag: Area guide · 8 min read
Title: Accessible beaches and promenades near Whitstable
Excerpt: Where the paved coast works for chairs — and where shingle means choosing the promenade instead.

### Section 3 — Post grid (2-up)
Tag: Planning · 5 min read
Title: What to pack for an accessible coastal stay
Excerpt: A short list that assumes the hoist and wet room are already waiting.

Tag: Funding · 6 min read
Title: Direct payments and short breaks: a plain overview
Excerpt: How families and carers often start the conversation with their local authority.

### Footer
Restwell · Sister company: Continuity of Care Services · CQC inspection profile · Accessible holidays, Whitstable, Kent
Footer links: FAQ · Privacy Policy · Terms & Conditions · Website accessibility
Copyright: © 2026 Homely Housing Investments Ltd t/a Restwell Retreats. All rights reserved.
