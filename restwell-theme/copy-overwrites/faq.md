# FAQ `/faq/`

**Layer:** `faq_heading` `faq_intro` · `template-faq.php`. The JSON-LD must contain exactly the same questions and answers as the visible accordion, not schema-only extras. Answer first, then link to the page that owns the subject. Voice: the Welcome Guide.

## Title

Restwell FAQ: the questions guests ask before booking

## Meta description

The Restwell FAQ answers what people ask before they book. It covers door widths, hoists, home care, prices and who can pay.

## H1 (`faq_heading`)

FAQ: the questions people ask before they book

## Intro (`faq_intro`)

These are the things people ask us most before they book. Each answer is short and links to the page with more detail.

## The questions

Source: `restwell_get_faq_page_default_pairs()` in `inc/seo/jsonld-faq.php`. The link sits inside the last sentence of the answer.

1. **Is Restwell a care home or a respite centre?**
   No, Restwell is a private bungalow that you rent as a holiday, with no staff on site. If you’d like home care, our sister company, Continuity of Care Services, can provide it. Your funder may call the break respite on their paperwork, and that’s fine.

2. **Can we book just one night?**
   Yes, the minimum stay is one night. You can book anything from a single night to a full week or more. The nightly and weekly rates are on Prices and dates. (Prices and dates → `/pricing/`)

3. **What are the door widths, and will my wheelchair fit?**
   The bungalow is all on one level and step-free throughout. The front door has a 965mm clear opening, and the doors inside are 926mm. Every figure is in the access statement, and we’ll measure anything that isn’t. (access statement → `/accessibility/`)

4. **Is there a hoist, and what’s it rated to?**
   Yes, a ceiling track hoist covers the main bedroom, and a mobile hoist works in any room. Both are rated to 180kg and examined under LOLER every six months. Please bring your own slings, because a sling needs to fit the person using it.

5. **Can we have two profiling beds?**
   Yes, we have two profiling beds. We set the accessible bedroom up with one or both, depending on who needs them. Tell us when you book and it’ll be ready when you arrive.

6. **How many people does it sleep?**
   Up to five. There are two bedrooms and a double sofa bed in the conservatory. Our safety checks are based on five people, so we can’t go above that.

7. **Can we add care to our booking?**
   Yes, our sister company, Continuity of Care Services, can come in during your stay, from morning visits to nurse-led support. Mention it on your enquiry, and they’ll quote once you’ve talked it through. There’s more on the Optional care page. (Optional care → `/optional-care/`)

8. **How far ahead do we need to arrange care?**
   The sooner you ask, the more likely we can say yes. We don’t publish a lead time, because it depends on what you need and who’s free that week. We’d rather give you a real answer quickly than a number we’ve made up.

9. **Can we bring our own carer or PA?**
   Of course. Plenty of guests bring their own carer or PA, and the second bedroom gives them somewhere proper to sleep. If you’d like to talk through who sleeps where, we’re happy to help.

10. **How far is the bungalow from the seafront?**
   It’s about ten minutes on foot from the driveway to the seafront. Tankerton promenade takes longer: JoJo’s is about twenty minutes, as you head down to the sea and then west. The Whitstable guide has the step-free routes. (Whitstable guide → `/whitstable-area-guide/`)

11. **What does it cost, and what’s included?**
   A week is £1,300 off-peak and £1,400 in peak season, with the access equipment, linen, towels and parking included. A 50% deposit holds your dates and the rest is due a week before you arrive. Every rate is on Prices and dates. (Prices and dates → `/pricing/`)

12. **Can a council or the NHS pay?**
   We can invoice you, a local authority, the NHS or a grant body. We can’t promise your care package will cover a holiday, because that’s for your social worker or case manager. Funding and support explains how it usually works. (Funding and support → `/funding-and-support/`)

13. **Can we use direct payments?**
   Some guests do, either for the stay or for a PA’s time. The rules vary from area to area, so it’s best to start with your own care team. Our guide to direct payments explains more. (guide to direct payments → `/direct-payment-holiday-accommodation/`)

14. **Are dogs allowed?**
   Yes, with a little notice so we can do a quick risk assessment first. Assistance dogs are welcome on the same terms.

15. **What time is check-in?**
   Check-in is from 3pm, check-out is by 11am, and we send the key safe code beforehand. If you need longer for personal care or transport, let us know a few days ahead. How it works covers arrival day in full. (How it works → `/how-it-works/`)

## Ask us directly (side panel)

We aim to reply within 48 hours. If you’d rather talk, call us on 01622 809881.

After sending: Thank you, we’ve got your question. We aim to reply within 48 hours.

## CTA

H2: Ask about your dates

Tell us when you’d like to come and what you need. We aim to reply within 48 hours, or you can call 01622 809881 if you’d rather talk it through.

## Do not

- Duplicate the cancellation terms here. Terms and Conditions owns the legal wording.
- Publish a care lead time.
- Claim any particular dates are available.
- Write “fully accessible”, in the visible copy or the schema.
