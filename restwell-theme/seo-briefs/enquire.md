# SEO Content Brief — Enquire

Source page: `restwell-theme/template-enquire.php`

## 1. Keyword Strategy

SEO recommendations: this is a transactional, low-content page by design (a form, not an article) — keyword integration matters far less here than on content pages. The bulk of its ranking value comes from internal links pointing to it with descriptive anchor text ("Enquire Now" appears in the header/footer of every page site-wide), not from on-page copy density.

- **Primary keyword:** "Contact Restwell" *(existing focus keyphrase — `inc/seo-content-seed-meta.php`, slug `enquire`)*
- **Secondary keywords:** "accessible holiday enquiry Whitstable", "wheelchair accessible bungalow booking", "book accessible holiday home Kent"

Note: the seed meta title (`Contact & Enquire | Restwell | Restwell Retreats`) currently mentions "Restwell" twice — once as the mid-segment, once as the site-name suffix. Worth a light edit to `Contact & Enquire | Restwell Retreats` when this gets ported to the live theme; flagging here rather than changing it, since meta copy wasn't in scope for this brief.

## 2. Content Structure & Enhancements

- **Hero:** already states the practical value proposition ("No deposit until you decide. We reply within 48 hours") — good trust-building copy for a contact page, don't add keyword phrasing here at the expense of that clarity.
- **Multi-step form (About you → Your stay → Your needs):** this is the page's actual content — three logical groupings, required-field validation with inline error messaging (built and verified earlier this session), and a GDPR-appropriate consent checkbox separate from the optional marketing opt-in. No SEO action needed on the form itself; it's not crawlable/indexable content in the traditional sense.
- **Sidebar contact card:** phone, email, address, plus three contextual links (Funding & support, Who it's for, See the adapted bungalow) — this is useful internal linking from a high-authority page (enquire is linked from every page's header) toward supporting content. Keep it.
- **Success state:** confirms the 48-hour reply promise again — consistent messaging, no changes needed.

## 3. Technical SEO

- **Meta title (existing):** `Contact & Enquire | Restwell | Restwell Retreats` — 49 characters, but has the redundant double-brand issue noted above.
- **Meta description (existing, in sync):** `Contact Restwell by phone, email, or enquiry form for rates, availability, and access questions. We usually reply within 48 hours.` — 130 characters.
- **Headings:** single H1 ("Contact Restwell about your stay"), plus a second H2 ("Talk to us") on the sidebar card — correct, no duplicate H1s.
- **Form accessibility:** all required fields have `aria-describedby` pointing to a paired error message, `role="alert"` on error text so screen readers announce it, consent checkbox is `required` and separately labelled from the optional marketing checkbox — this is good practice generally, and also reduces abandoned-enquiry bounce rate, which is itself a soft ranking/UX signal.
- **URL/slug:** live slug is `/enquire/`.

## 4. User Experience & Conversion

- This is the site's primary conversion page — every "Enquire Now" CTA sitewide lands here.
- Multi-step form (built this session) reduces perceived effort vs. one long form — step indicator shows progress, Back/Continue gate on validation, inline errors flag exactly which field is blocking submission.
- No fake urgency, no forced account creation, explicit "no deposit until you decide" — matches the site's overall low-pressure positioning, which is itself a conversion strength for a care/accessibility audience wary of pushy sales patterns.

## 5. Content Length

Short by design — this is correct for a contact/form page. Don't add filler content; a bloated enquire page would hurt conversion for no SEO benefit, since this page ranks primarily through internal link equity, not on-page text volume.

---

## Example Outline

1. Contact Restwell About Your Stay (H1)
2. About You *(form step 1)*
3. Your Stay *(form step 2)*
4. Your Needs *(form step 3)*
5. Talk to Us *(H2, sidebar)*

## Meta Information

**Meta Title:** Contact & Enquire | Restwell Retreats *(suggest dropping the redundant middle "Restwell" from the current seed value)*
**Meta Description:** Contact Restwell by phone, email, or enquiry form for rates, availability, and access questions. We usually reply within 48 hours.
**Page title:** Enquire
**Slug:** /enquire/

---

## Page Copy (matches current mockup structure)

### Header
Nav: Home · The Bungalow (The Property, Accessibility, Pricing, How It Works) · Plan your trip (Who It's For, Whitstable, Funding & Support, Optional care) · FAQ · Blog
CTA: Enquire Now

### Section 1 — Hero
Breadcrumb: Home / Enquire
H1: Contact Restwell about your stay
Subheading: Share dates, access needs and funding contact. No deposit until you decide. We reply within 48 hours on most enquiries.

### Section 2 — Multi-step enquiry form
Step indicator: 1 About you · 2 Your stay · 3 Your needs

**Step 1 — About you:** Full name*, Email*, Phone*, Contact preference (Email/Phone/Either), Best time to call → Continue

**Step 2 — Your stay:** Arrival (optional), Departure (optional), Guests, Funding type (Self-funded / Local authority-KCC / NHS Continuing Healthcare / Direct payment-PHB / Not sure yet), "This enquiry is time-sensitive" checkbox → Back / Continue

**Step 3 — Your needs:** Care requirements, Accessibility needs, Message*, consent checkbox ("I agree to Restwell contacting me about this enquiry and to my information being handled as set out in the Privacy Policy *"), marketing opt-in checkbox ("Keep me updated about Restwell (optional)") → Back / Send enquiry

**Success state:** "We've got your enquiry" — We reply within 48 hours on most enquiries — call 01622 809881 if you'd rather talk it through. → Send another enquiry

### Section 3 — Sidebar
H2: Talk to us
Phone: 01622 809881
Email: hello@restwellretreats.co.uk
Property: Russell Drive, Whitstable, CT5 2RQ
Links: Funding & support · Who it's for · See the adapted bungalow

### Footer
Restwell · Sister company: Continuity of Care Services · CQC inspection profile · Accessible holidays, Whitstable, Kent
Footer links: FAQ · Privacy Policy · Terms & Conditions · Website accessibility
Copyright: © 2026 Homely Housing Investments Ltd t/a Restwell Retreats. All rights reserved.
