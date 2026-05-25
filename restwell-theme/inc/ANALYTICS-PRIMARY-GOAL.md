# Primary conversion goal (Restwell theme)

## Definition

**Primary success:** a visitor **starts the enquiry journey** (same intent whether they click through to the form or submit it).

**Recommended measurable events (pick one as “primary” in GA4):**

1. **`restwell_cta_click`** (Custom event) when any element with `data-cta` is activated. Parameter: `cta_id` (string), e.g. `cta-enquire`, `hero-primary`, `hero-secondary`.
2. **`generate_lead`** (GA4 recommended) on successful enquiry form submit, if you wire it on the thank-you step or server-side.

`data-cta` is present on homepage hero buttons, property link, and bottom CTA block. The theme pushes `restwell_cta_click` via `gtag` when GA4 is configured (see `assets/js/main.js`).

## GTM / GA4 setup (your workspace)

- Register custom parameter `cta_id` for event `restwell_cta_click` if you want explorations by placement.
- Mark **one** event as a **key event** (GA4) for reporting, not every micro-conversion.

## Message match (SEO/CRO)

Hero copy, meta title/description (`inc/seo-content-seed.php` slug `home`), and enquiry CTAs should promise the same thing: **accessible self-catering in Whitstable**, honest specs, optional CQC-regulated support, conversation before commitment.
