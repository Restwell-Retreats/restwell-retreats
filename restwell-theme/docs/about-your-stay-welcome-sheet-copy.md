# About your stay — welcome sheet (template map)

**Document type:** Single-sided **printed welcome sheet** for the property (often left on a table or handed over at keys).  
**Moment in the journey:** Guest has **booked and paid**; this is **day one of the stay**. Copy sells nothing. It orients, reduces friction, and gives one clear escalation path if the building does not match what was promised.  
**Claim discipline:** Facts trace to `inc/seo-content-seed.php` and `template-property.php` defaults unless your live WordPress fields say otherwise. Update paste blocks when CMS copy drifts.

---

## Copy brief (arrival day, post-payment)

- **Job of this sheet:** Help someone who is already inside (or about to be) find their feet: what the house is, what is within reach in Whitstable, where level coast is, how Wi‑Fi works, who to call if something is wrong.  
- **Reader:** Guest plus anyone supporting them; tired, carrying bags, possibly managing equipment.  
- **Awareness:** Product- and stay-aware. They need **confidence and coordinates**, not reasons to book.  
- **Primary action:** If the property, beds, or kit **do not match the booking confirmation**, contact us using the **phone or email on that confirmation** before you force a workaround.  
- **Secondary action:** Join Wi‑Fi; use confirmation contacts if the join fails.  
- **Voice contract (copy-editing, voice sweep):** Second person **you / your**, short declarative sentences, **we** only where a human team is implied (support line). No brochure cadence, no urgency to purchase.

---

## Voice and editing notes (how this was tightened)

| Sweep | What changed for arrival-day print |
|-------|-------------------------------------|
| **Clarity** | Removed in-jokes and metaphors that required a second read (“catalogue / order”, “bricks and confirmation”). Plain condition + verb + contact. |
| **So what** | Each facility line ties to **your evening or your trip tomorrow** (settle tonight, level walk tomorrow), not to “choosing Restwell”. |
| **Prove it** | No response-time promises, no “most guests”. Tankerton and parking lines stay tied to published seed wording. |
| **Zero risk** | Mismatch path and Wi‑Fi failure path both land on **the same confirmation footer** so nobody hunts for a second number. |

---

## 1. Template regions (documentation)

| # | Region in artwork | Paste from | Notes |
|---|---------------------|--------------|--------|
| 1 | Left vertical accent | *(none)* | Design only. |
| 2 | Main title, top left | § Title | |
| 3 | Left column, paragraph 1 | § Left column, paragraph 1 | |
| 4 | Left column, paragraph 2 | § Left column, paragraph 2 | |
| 5 | Right column, paragraph 1 | § Right column, paragraph 1 | |
| 6 | Wi‑Fi callout | § Wi‑Fi callout | Real SSID and password before print. |
| 7 | Hero image | § Hero image | |
| 8 | Vertical type on photo | § Vertical type on photo | |

**Assembly:** Typeset regions 2–6, proof, then place image and check vertical type for safe bleed.

---

## Title

About Your Stay

---

## Left column, paragraph 1

Welcome. The whole property is yours: your party only, no shared corridors, no other guests. Restwell is a self-catering bungalow on a quiet residential street in Whitstable, about five minutes’ drive from the town centre and seafront. The harbour, independent shops, and seafood are the heart of the town.

---

## Left column, paragraph 2

You are on the ground floor with step-free routes and doorways wide enough for wheelchair work. A private garden sits beyond level paving. One wet room with a roll-in shower and level-access rails, as the property page describes. Beds and linen should match the party size and equipment named on your booking confirmation. If what you see differs from that paper, ring the number printed on it before you shift heavy kit or furniture alone.

---

## Right column, paragraph 1

Ceiling track hoist, profiling bed, and level ground-floor access apply to your stay only as your confirmation lists them. Off-street parking suitable for adapted vehicles is what we publish for this address in the Whitstable area guide. For long level sea air without crossing loose shingle under wheels, head east from the centre to Tankerton: the promenade there is smooth and level for several miles, suited to powered and manual wheelchairs in the same guide, and it connects back toward Whitstable seafront. Anything in the house disagrees with your confirmation? Use the phone number on that confirmation first. Say so while the bags are still in the hall. We correct our own setup errors when you show us the mismatch.

---

## Wi‑Fi callout

**WIFI INFORMATION**

Network: `[YOUR NETWORK NAME]`  
Password: `[YOUR PASSWORD]`

Type both fields exactly. If the device still refuses the join after two careful tries, use the phone or email on your booking confirmation. Same contacts for Wi‑Fi, heating, keys, and equipment questions during your stay.

---

## Hero image

**Asset:** Your photograph, licenced.  
**Crop:** Per your layout master.  
**Caption (optional):** Level promenade at Tankerton, east of Whitstable, for miles of coast without taking a chair across loose shingle.

---

## Vertical type on photo

Keep the template **About** on the photograph unless the artwork is being redesigned as a set.

---

## Quality gate (pre-export)

- [ ] Reads like **day-one arrival**, not a booking advert.  
- [ ] Title is **About Your Stay**.  
- [ ] Three body paragraphs in the correct columns.  
- [ ] Hoist, bed, wet room, and parking lines still match **this guest’s** confirmation and live site copy.  
- [ ] Wi‑Fi credentials real; support contacts identical to the booking confirmation footer.  
- [ ] If your editor has changed drive times or Tankerton copy on the live site, paste the **current** sentences here before you print.

---

## Traceability (documentation)

| Claim in sheet | Stated in repo (default / seed) |
|----------------|----------------------------------|
| Whole property, your party, no shared corridors / other guests | `$prop_overview_body` default in `template-property.php` |
| Self-catering bungalow, quiet residential street, ~5 min drive to centre and seafront | `restwell_get_who_its_for_page_html()`; `restwell_get_whitstable_guide_page_html()` |
| Harbour, shops, seafood as heart of town | `restwell_get_whitstable_guide_page_html()` |
| Step-free ground floor, wide doorways | `prop_home_1_body` default; accessibility defaults |
| Private garden, level paving | `prop_home_2_body` default |
| Wet room, roll-in shower, rails | Feature defaults; property page copy |
| Party size / confirmation | `restwell_get_who_its_for_page_html()` |
| Hoist, profiling bed, level ground floor | Property hero default; FAQ / SEO strings in `seo-content-seed.php` |
| Off-street parking, adapted vehicles | `restwell_get_whitstable_guide_page_html()` |
| Tankerton east of centre, smooth level promenade, miles, wheelchairs, connects to seafront | `restwell_get_whitstable_guide_page_html()`; `restwell_get_blog_post_beaches_kent_html()` |

**Not printed here unless you add them from live meta:** exact bedroom counts, bed types, “15 minutes’ flat walk / 7 minutes’ drive” lines from `prop_distances` defaults (`template-property.php`). Pull those in only when they match what you publish today.

---

## Source note

Internal layout doc only. Sync with `template-property.php` and seeded Whitstable copy when facts change.
