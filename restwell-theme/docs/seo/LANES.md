# SEO lanes

Rebuilt **13 Aug 2026** from live UK research + searcher journeys. These are **targets to write toward**, not a snapshot of today’s headings.

**Order:** research → one primary per URL (must fit that page’s job) → then tailor titles, metas, and copy. Current H1s do not block a phrase. A phrase that belongs on a *different* page does.

One primary per indexable URL. Other pages may mention the topic; they link to the owner.

`focus_keyphrase` in [`inc/seo-content-seed-meta.php`](../../inc/seo-content-seed-meta.php) is still the old map. Do not ship it until that file is updated.

**Language:** “respite” and “wheelchair friendly” are allowed. Never “fully accessible”. Not a care home, nursing home, or respite centre. Wheelchair-friendly claims sit next to millimetres and kit.

## What “fits the page” means

The page’s **job** has to be able to answer the query. We then change the copy so the phrase is actually on the page.

| Allowed | Not allowed |
| --- | --- |
| Home owns a seaside / cottage / coastal holiday phrase, then we say cottage and coast on Home (bungalow stays true in the body). | Resources owns `wet room` or `hoist`. That page is funding. |
| Accessibility owns wet room / hoist / wheelchair-accessible cottage specs. | Home owns a full spec sheet. |
| How it works owns booking + own carer / optional care. | How it works owns door widths. |
| Whitstable guide owns local days out. | Home owns “best seaside town in the UK”. |

If the job cannot answer the query, the phrase stays in [`uk-serp-2026-08-13.md`](uk-serp-2026-08-13.md). It is not a lane.

## Evidence this map uses

[`uk-serp-2026-08-13.md`](uk-serp-2026-08-13.md), [`uk-keywords-no-planner-2026-08-13.md`](uk-keywords-no-planner-2026-08-13.md), journeys in [`aug-research.md`](aug-research.md) Run B.

- Google rewrites the job to **disabled / accessible holiday cottages by the sea**.
- Kit Google already offers: **wet room**, **hoists and profile beds**.
- Trends (relative): `disabled holidays uk` is the large holiday phrase. We do not try to beat park/directory SERPs for that fat head.
- Unseeded Google never offered Whitstable. Town is destination proof, not the Home primary.
- `respite holiday by the sea` is a care-home SERP. Funding pages may say respite; they do not chase that SERP.
- Ubersuggest / Wordtracker volumes conflict. Phrase ideas only. No numbers in this file.

## Core money pages

| URL | Job (what the page is for) | Primary (write toward) | Copy we will add | Don’t own |
|-----|----------------------------|------------------------|------------------|-----------|
| `/` | One private house for an accessible / disabled holiday by the sea | `accessible holiday cottages by the sea` | Cottage + by the sea / coastal in H1 or first screen. Keep **bungalow** in the body (that is what it is). Whitstable as where, not the query. | Spec millimetres (→ `/accessibility/`); room tour (→ `/the-property/`); tariff; funding; local days-out depth |
| `/the-property/` | Bookable home: layout, rooms, how the house works | `accessible holiday bungalow` | Say bungalow + holiday in the heading. Whitstable as location. | Wet-room / hoist SWL statement (→ `/accessibility/`); “cottages by the sea” job (→ `/`) |
| `/accessibility/` | Access statement. The page after a listing burned them. | `disabled holiday cottages with wet room` | Keep cottage + wet room in the H1/intro. Name hoist and profiling beds on the page (Google already offers that phrase). | Booking story; by-the-sea job; days out |
| `/pricing/` | Tariff, deposits, same rate whoever is invoiced | `accessible holiday prices` | Prices / tariff in the heading. Location can stay in the body. | Who pays / DP / CHC (→ `/resources/`); Continuity process |
| `/how-it-works/` | Enquire → confirm → arrive. Own PA welcome. Care optional and separate. | `bring your own carer on holiday` | Make own carer / own PA a real section, not a leftover line on Home. | Door widths; tariff tables; funding law |
| `/who-its-for/` | Fit. Holiday not a placement. Families, carers, OTs. Not an LA short break. | `holidays for disabled adults and carers` | Audience in the H1. Point specs to `/accessibility/`, money to `/resources/`. | Full access statement; care-home respite SERP |
| `/resources/` | How a break might be paid for. No eligibility promises. | `funding an accessible holiday` | Keep funding / direct payments / grants. Do **not** add kit lists. | Bungalow rates; wet room; hoist; `respite holiday by the sea` |
| `/whitstable-area-guide/` | Destination after they want **this** house. Honest terrain. | `whitstable accessible days out` | Days out + access notes in the heading. Shingle vs Tankerton. | Property kit; national “best seaside town” (Google answers Bournemouth) |
| `/enquire/` | Conversion | `contact restwell` | Form, phone, email. | Product keywords |
| `/faq/` | Short answers + links to owners | `restwell faq` | Answers, then link out. | Primaries owned by hubs |
| `/blog/` | Editorial index | `accessible travel` | Index only. | Property / booking intent |

**Supporting mentions (not extra URLs).** Home may also say wheelchair friendly (with a link to millimetres). Accessibility must keep **hoist** and **profiling beds** on the spec page. Who / How it works may say respite if they also say bungalow + optional Continuity.

## Care (planned)

| URL | Job | Primary when the slug ships | Don’t own |
|-----|-----|-----------------------------|-----------|
| Mockup `care-concept`; slug still unlocked | Optional Continuity, CQC Good, never bundled | `paying for care on holiday` | Bungalow rates; booking steps; care-home SERP |

Until then: teasers only. Add `focus_keyphrase` only when the slug is locked.

## Guides we keep (job already matches research)

| URL | Job | Primary | Hub |
|-----|-----|---------|-----|
| `/accessible-beaches-coastal-walks-kent/` | Honest coast: shingle vs promenade | `accessible beaches kent` | Whitstable guide |
| `/direct-payment-holiday-accommodation/` | Can a DP pay for the holiday / the PA | `can I use direct payments for a holiday` | Resources |
| `/revitalise-alternatives-accessible-holidays/` | Centres closed Nov 2024 | `revitalise alternatives` | Resources / Who |
| `/how-to-choose-accessible-self-catering-holiday/` | Burned-listing checklist | `how to choose accessible self catering` | Home / Accessibility |
| `/how-to-read-holiday-cottage-access-statement/` | How to read a spec | `holiday cottage access statement` | Accessibility |

## Not a ranking lane

These jobs do not get a competing primary. Do not write more of them for SEO. Fold facts into the owner above.

**Local mill.** Parking, trains, eating out, Changing Places, quieter times, fatigue-friendly day. → Whitstable guide (and the beaches post).

**Funding mill.** CHC explainer, personal-budget Care Act, commissioner checklist. → Resources + Pricing (invoice split only).

**Respite-rights long-form.** `/carers-respite-holiday-guide/` must not chase `respite holiday by the sea`. Fit → Who. Money → Resources.

**Trip-prep mill.** Packing, mobility hire, insurance, care-worker backup. → FAQ.

## Utility / legal

| URL | Primary | Notes |
|-----|---------|-------|
| `/guest-guide/` | `restwell guest guide` | Prefer `noindex` |
| `/privacy-policy/` | `restwell privacy` | Compliance |
| `/terms-and-conditions/` | `restwell terms` | Compliance |
| `/accessibility-policy/` | `restwell website accessibility` | Website WCAG — not property access |

## Phrases with no fitting page

| People type | Why it is not a lane |
| --- | --- |
| `disabled holidays uk` | Park / directory / all-inclusive SERP. We are one house. |
| `respite holiday by the sea` | Charities and care homes. Wrong job for every money page. |
| `accessible coastal cottage` | Same job as Home’s primary. Use it in Home copy; do not give it a second URL. |

## Conflict checks

1. **Home vs Accessibility** — Home = seaside holiday cottage job. Accessibility = wet room / hoist / beds / mm. Not two holidays landings.
2. **Home vs Property** — Cottage-by-the-sea vs this bungalow’s rooms.
3. **Property vs Accessibility** — Tour vs spec sheet.
4. **How it works vs Who** — How you book / own carer vs whether this stay fits.
5. **Pricing vs Resources** — £ vs who might pay.
6. **Resources vs kit** — Funding never owns wet room, hoist, or cottage-by-the-sea.
7. **Whitstable guide vs beaches** — Stay/local hub vs Kent beaches honesty.
8. **Website accessibility policy ≠** `/accessibility/`.

## What this file does not do

- No invented monthly volumes.
- No titles, metas, or body rewrites until you ask (next: P4 `/seo-keyword-strategist` then `/seo-meta-optimizer` / `/seo-content-writer`).
- No new URLs.
- No HowTo / FAQ rich-result plan.
