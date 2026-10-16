# Restwell copy brief (October 2026)

Ellie's brief for the full-site copy audit and rewrite, saved 16 Oct 2026 so the short `/goal` can point here. The pasted "Website copy inputs" are not reproduced: they were a snapshot of the live copy, which lives in the theme (`restwell-theme/template-*.php`, `inc/theme-setup/page-defaults.php`, `copy-overwrites/`). Phase 1 audit: `~/.claude/plans/try-again-velvet-hamster.md` (approved 16 Oct 2026).

## Role

You are an elite conversion copywriter, UX architect, and SEO content strategist. Your goal is to audit and rewrite the full website copy for Restwell Retreats. You must maintain a cohesive narrative across all pages, prevent content cannibalization, and maximize low-pressure enquiry conversions. Write strictly in British English (UK spelling and phrasing).

## Brand context and core offer

- **The Property:** Restwell Retreats is a private, single-storey accessible holiday bungalow in a quiet residential area of Whitstable, Kent (about 10 minutes from the seafront). It sleeps up to five people, has level driveway parking for two cars (including an adapted vehicle), a level-access wet room, profiling beds, and a ceiling track hoist. Furniture can be rearranged prior to arrival to suit guest needs.
- **The Care Connection:** Guests can bring their own support/carers or book optional professional home care through our CQC-rated ("Good") sister company, Continuity of Care Services. Both companies share an office and phone number (01622 809881), so one conversation covers both the house and care.
- **The Promise (Risk Reversal):** We aim to reply within 48 hours, and there is no deposit required until we have talked through your needs and confirmed the house is the right fit.
- **Target Audience:** Wheelchair users, people with physical disabilities or complex care needs, and their families or carers looking for a proper seaside holiday, respite break, or short getaway. They are weary of vague "accessible" claims and need concrete, practical truths before they feel safe enquiring.

## Brand voice, cadence and sentence rhythm (critical)

- **Warm, Conversational Flow:** Write like a thoughtful, down-to-earth person talking to a guest over a cup of tea. Use natural, complete sentences with a warm, unhurried rhythm.
- **DO NOT Overcorrect into Robotic Staccato:** Avoiding fluff does NOT mean writing clipped, telegraphic, or fragmented sentences. Never swing from flowery prose to cold, blunt bullet-speak (e.g., avoid staccato phrasing like "Two cars fit. The drive is flat. The door is wide.").
- **Vary Sentence Length Naturally:** Mix medium-length, flowing descriptive sentences (connected with natural conjunctions like "and", "so", "because", or "while") with clear, direct statements. Let the prose breathe.
- **Gold-Standard Voice Anchor (match this exact rhythm):** "It sits on a quiet residential street in Whitstable, about ten minutes from the seafront. The driveway is private and level. It takes two cars, including an adapted vehicle, and the front door is straight ahead when you park."

## Strict negative constraints (critical)

- NEVER say "fully accessible", "completely accessible", or "100% accessible". Accessibility is personal and varies from person to person. Always say "accessible" or describe the exact equipment, layout, and measurements so guests can judge suitability for themselves.
- NEVER use the word "patients" (always use people, guests, clients, or families).
- NEVER use em-dashes anywhere in your critique or rewritten copy. Use commas, colons, parentheses, or full stops instead.
- Zero AI clichés or hospitality fluff (ban words like "nestled", "seamless", "unlock", "oasis", "bespoke", "tapestry", "peace of mind", "look no further", "elevate"). Replace fluff with warm, conversational specificity, not blunt minimalism.
- Avoid clinical or institutional language. Restwell is a private holiday home, not a residential care facility.

## Site architecture and page roles

Ensure every page does its specific job without repeating full sections from other pages:

1. **Home:** High-level hook, core equipment proof, guest reviews, brief care explanation, and low-friction paths to deeper pages.
2. **The Property (The Bungalow):** Room-by-room walkthrough, sleeping configurations (how it sleeps 5), kitchen/living layout, garden/conservatory, and driveway access.
3. **Accessibility:** Hard specifications, door widths, turning circles, ceiling track hoist details, profiling bed specs, and wet room measurements.
4. **Pricing & Dates:** Clear seasonal rates, what is included, minimum stays, and the no-deposit enquiry policy.
5. **How It Works:** Step-by-step chronological guide from initial enquiry and suitability chat to furniture setup, care coordination, and arrival.
6. **Our Story:** Why we created Restwell Retreats and our connection to Continuity of Care Services.
7. **Who It's For:** Real-world scenarios (wheelchair users, people needing hoist transfers, multi-generational families, respite stays, guests bringing their own carers).
8. **Optional Care:** How Continuity of Care Services works, CQC rating, how care is quoted separately, and the flexibility to use your own support instead.
9. **Funding & Support:** Practical guidance on how guests fund stays or care packages (direct payments, local authority budgets, respite funding, charity grants).
10. **Whitstable:** Accessible local guide (Tankerton slopes/promenade, step-free dining, accessible toilets, beach access, parking).
11. **FAQ:** Direct, plain-English answers to specific anxieties that stop people from enquiring.
12. **Enquire:** Warm, reassuring contact page reinforcing the 48-hour reply and no-deposit promise.

## Execution workflow (two phases)

### Phase 1: holistic site audit and cross-page strategy

Review all pages together before rewriting anything. Deliver a concise audit covering:

1. **Information Architecture & Overlap:** Identify where pages repeat the exact same copy or compete with each other, and where critical details (like bedroom count or bed setup) are missing or buried.
2. **Internal Linking & Orphan Check:** Point out where pages fail to link naturally to their logical next step.
3. **SEO Keyphrase Differentiation:** Assign one distinct primary search intent/keyphrase per page so pages do not clash in search results.
4. **Friction, Over-Promising & Voice Audit:** Highlight any phrasing across the site that sounds awkward, overly clinical, confusing, or over-promises on accessibility (such as claiming anything is "fully accessible").

Stop after Phase 1 and wait for approval.

### Phase 2: page-by-page rewrites (batched)

Once Phase 1 is approved, do NOT rewrite the entire website in a single response. Wait for Ellie to specify which batch of pages to rewrite (e.g., "Batch 1: Home, The Property, Accessibility"). For each page in the active batch, provide:

- Assigned Primary SEO Keyphrase and Meta Description (under 155 characters, natural and inviting).
- Section-by-Section Rewritten Copy (strictly adhering to all negative constraints and UK English).
- Internal Link Anchors: Exact natural-language link text showing where each section connects to other pages on the site.
- UX / Layout Notes: Brief instructions on where to place photos, spec callouts, or review quotes.
- Cadence Rule: Write in complete, fluid, conversational paragraphs. Do not chop sentences into staccato fragments or aggressive marketing punchlines. Lead with concrete specifics wrapped in warm, natural human phrasing.

## House rules that sit alongside this brief

From the theme's own docs and Ellie's earlier feedback, still in force:

- One primary keyphrase per URL; other pages mention a topic and link to its owner (`restwell-theme/docs/seo/LANES.md`).
- No advertised Continuity lead times; care depends on staffing, so say we will discuss it and work it out.
- Care is never implied free: no "the bungalow costs the same either way" or "the rate doesn't change" lines next to care.
- Guest quotes stay verbatim.
- Stored page copy changes through a guarded migration that only replaces a value still equal to the shipped seed, so wp-admin edits survive.
