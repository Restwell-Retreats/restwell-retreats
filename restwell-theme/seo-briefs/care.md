# SEO Content Brief — Optional Care

Source page: `restwell-theme/mockups/care-concept.html`

## 1. Keyword Strategy

SEO recommendations: **flag before using —** unlike every other page in this batch, `care` has no entry in `inc/seo-content-seed-meta.php`. The keyword below is proposed from the page's own content and its existing `Service` schema (`serviceType: "Personal care support during a holiday stay"`), not pulled from prior research. Add it to the seed file once confirmed, rather than treating it as settled.

- **Primary keyword (proposed, not yet seeded):** "CQC-regulated holiday care Whitstable"
- **Secondary keywords (proposed):** "optional care accessible holiday", "respite care self-catering Kent", "bring your own carer holiday accommodation"

The current H1 ("Care during your stay, only if you want it") is strong, on-brand copy but doesn't carry a searchable phrase — same gap as the Accessibility page's hero. Consider whether a keyword-forward variant sacrifices too much of the reassuring "only if you want it" framing before changing it; this page's tone is doing real trust-building work for a nervous-about-care-costs audience.

## 2. Content Structure & Enhancements

- **Sister company intro:** clearly states "optional, not automatic" and "we add nothing until you agree the support package" — this directness is a genuine differentiator; most care-adjacent holiday accommodation sites are vague about whether care is forced or bundled. Keep the plain language.
- **Support options (4 personas: personal care / visiting care / overnight cover / mobility and hoisting):** good, specific, matches the equivalent list on How It Works and Who It's For — consistent sitewide vocabulary for these four care types.
- **Bring your own carer:** three concrete reassurances (no extra fee, separate sleeping space, room to park) — practical detail that a generic "carers welcome" page wouldn't include.
- **How care is arranged (3 steps):** correctly distinguishes this from the full booking process ("This is the care conversation specifically — see How It Works for the full booking journey") — avoids duplicating that page's content while still being self-contained.
- **CQC-regulated section:** genuinely strong E-E-A-T content — explains what CQC regulation actually means, names the specific rating, and explicitly invites the reader to verify independently ("read the published report yourself rather than take our word for it"). This kind of verifiable-claim framing is exactly what search engines and AI answer systems weight favourably for care/health-adjacent content.
- **For professionals section:** targets a distinct audience (OTs, case managers, commissioners) with funding-route and documentation specifics — good audience segmentation without duplicating the Resources page.
- **FAQ (5 questions):** tight and non-redundant with the rest of the page.

## 3. Technical SEO

- **This page already has the best structured data on the site** — `BreadcrumbList`, `Service` (with `provider`, `areaServed`, `sameAs` linking to the CQC profile), and `FAQPage` all implemented via JSON-LD. Use this page as the template when extending schema to Property, How It Works, or the FAQ hub.
- **Meta title (existing):** `Care During Your Stay | Accessible Holidays | Restwell Retreats` — 65 characters, slightly over the 60-char guideline; consider trimming if this gets formally seeded.
- **Meta description (existing):** `Optional, CQC-regulated care during your self-catering stay in Whitstable, arranged through Continuity of Care Services. Or bring your own carer. Ask us.` — 158 characters, within range.
- **Headings:** single H1, seven H2s across the subnav sections (About → Support → Own carer → Steps → CQC → Professionals → FAQ) — clean ladder, no skips.
- **Live slug (from the page's own JSON-LD):** `/care-during-your-stay/` — note this differs from the mockup filename `care-concept.html`; use the JSON-LD value as the source of truth for the live URL, not the filename pattern.

## 4. User Experience & Conversion

- Sticky subnav with seven anchors — appropriate for the longest single-topic page after Accessibility and Whitstable.
- Partner branding (Continuity of Care Services logo + CQC "Good" rating image) appears twice — once near the top, once implicitly reinforced via the CQC section's outbound link — consistent trust signal placement.
- Mid-CTA offers "Ask about care with your enquiry" plus a direct link to guide rates — good low-friction secondary path for price-sensitive readers.

## 5. Content Length

Long — seven substantive sections plus a 5-question FAQ, likely 900–1,100 words. Appropriate for a page doing real reassurance and compliance-communication work around a sensitive topic (arranging care during a holiday); don't shorten it to hit a generic target.

---

## Example Outline

1. Care During Your Stay, Only If You Want It (H1)
2. One Conversation If You Need Both the Bungalow and Care (H2)
3. What Support Looks Like (H2)
4. Bringing Your Own Carer (H2)
5. How Care Is Arranged (H2)
6. What CQC-Regulated Means (H2)
7. For OTs, Case Managers and Commissioners (H2)
8. Optional Care FAQ (H2)

## Meta Information

**Meta Title:** Care During Your Stay | Accessible Holidays | Restwell Retreats
**Meta Description:** Optional, CQC-regulated care during your self-catering stay in Whitstable, arranged through Continuity of Care Services. Or bring your own carer. Ask us.
**Page title:** Optional Care
**Slug:** /care-during-your-stay/ *(from page's own JSON-LD, not yet in seed-meta.php)*

---

## Page Copy (matches current mockup structure)

### Header
Nav: Home · The Bungalow (The Property, Accessibility, Pricing, How It Works) · Plan your trip (Who It's For, Whitstable, Funding & Support, Optional care) · FAQ · Blog
CTA: Enquire Now

### Section 1 — Hero
Breadcrumb: Home / Care during your stay
H1: Care during your stay, only if you want it
Subheading: Optional, CQC-regulated care from Continuity of Care Services, arranged separately when you enquire — or bring your own carer. Never built into the bungalow rate.

### Subnav
About · Support · Own carer · Steps · CQC · Professionals · FAQ

### Section 2 — Sister company
Eyebrow: Sister company
H2: One conversation if you need both the bungalow and care
Optional, not automatic: We only introduce Continuity if you ask. Care is never forced into the bungalow rate.
Ask when you enquire: Dates, access needs and care can sit in one conversation on 01622 809881.
Bring your own team: Familiar carers are welcome — the layout works with visiting Continuity staff or your own rota.
Note: We add nothing until you agree the support package.
Partner branding: Continuity of Care Services · CQC rating Good

### Section 3 — Support options
Eyebrow: Support options
H2: What support looks like
Personal care: Support with washing, dressing and daily routines on your schedule.
Visiting care: Short daytime visits, or support for a promenade or town trip.
Overnight cover: Sleep-in or waking night support when daytime visits are not enough.
Mobility and hoisting: Transfers with trained carers, using the ceiling track and wet-room kit already in the house.

### Section 4 — Bringing your own carer
Eyebrow: Your own team
H2: Bringing your own carer
No extra fee: Bring your own carer or PA at no extra charge — the bungalow rate is the same either way.
Separate sleeping space: The second double bedroom, or the conservatory's double sofa bed, keeps your carer's sleeping space away from yours.
Room to park: The driveway holds two cars, so a carer's vehicle can park alongside yours.

### Section 5 — How care is arranged
Eyebrow: Getting started
H2: How care is arranged
Lede: This is the care conversation specifically — see How It Works for the full booking journey from enquiry to arrival.
Step 01 — Enquire as usual: Share dates, access needs, and any support you think would help. Call 01622 809881 or use the enquire form. No separate care booking maze.
Step 02 — Agree tasks and hours: If care is needed, Continuity confirms what is possible and what it costs. Many packages settle on the first call; a short follow-up covers overnight or complex rotas.
Step 03 — Guide rates, then your figure: Guide rates live on Pricing. Continuity quotes your care cost once hours and tasks are agreed.

### Section 6 — CQC-regulated
Eyebrow: Regulation
H2: What CQC-regulated means
Body: The Care Quality Commission (CQC) inspects and rates health and social care providers in England against standards of safety, effectiveness and leadership. Continuity of Care Services holds a CQC rating of Good — read the published report yourself rather than take our word for it. Restwell is the accommodation, not the regulated care provider. When care is arranged during your stay, Continuity of Care Services delivers it under that CQC registration — the accountability of a regulated provider, not an informal or unregistered introduction.
Link: Read the CQC inspection profile

### Section 7 — For professionals
Eyebrow: For professionals
H2: For OTs, case managers and commissioners
Lede: Restwell and Continuity can support a funded short break with care alongside it — here's what each side provides. See Who It's For for guest, carer and professional-referrer suitability at a glance.
Access evidence: Published door widths, hoist and wet-room specs — we'll measure unpublished clearances on request.
Care documentation: Continuity confirms the care plan and cost once hours and tasks are agreed — the detail a funding panel needs to approve a break.
Funding routes: Care Act short breaks, direct payments, personal health budgets or NHS CHC — the bungalow rate is the same whoever we invoice.
One number for both: Restwell and Continuity share 01622 809881, so access needs and a care conversation can happen in one call.

### Section 8 — Optional care FAQ (5 questions, two columns)
1. Do I have to book care?
2. Is Restwell a care home?
3. Do I book care separately?
4. Can I bring my own carers?
5. Where do I see guide rates?

### Section 9 — Mid CTA
Heading: Ask about care with your enquiry
Body: Share your dates and what support would help.
Primary CTA: Enquire Now
Secondary CTA: See guide rates

### Footer
Restwell · Sister company: Continuity of Care Services · CQC inspection profile · Accessible holidays, Whitstable, Kent
Footer links: FAQ · Privacy Policy · Terms & Conditions · Website accessibility
Copyright: © 2026 Homely Housing Investments Ltd t/a Restwell Retreats. All rights reserved.
