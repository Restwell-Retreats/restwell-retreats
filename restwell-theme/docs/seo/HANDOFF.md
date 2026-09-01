# Handoff — SEO research (13 Aug 2026)

Paste the block at the bottom as the first message in a new chat. @ this folder.

---

## Product (do not invent)

One private self-catering adapted bungalow in Whitstable. Whole house, sleeps 5. Enquiry-first. Optional care via sister company **Continuity of Care Services** (CQC Good, same phone) — never bundled; own carer/PA welcome; same bungalow tariff whoever is invoiced.

- Site: https://www.restwellretreats.co.uk/
- 101 Russell Drive, CT5 2RQ. what3words `///taker.paints.called`
- Owner Victoria Walker. Homely Housing Investments Ltd t/a Restwell Retreats. 01622 809881. hello@restwellretreats.co.uk
- Not infants/babies. All other ages OK, including disabled children and young people. That is a family holiday with kit, **not** an LA commissioned short-break placement.
- Stand aid is **AAL RS4**, not Arjo Sara Stedy (live site still wrong).
- Two profiling beds, layout tailored per guest. Accora CommunityBed confirmed; second bed make/model TBC. Mattresses: Roma Medical MATT 1; Accora Allevia Comfort FirmEdge (max 160kg); which-on-which TBC.
- Doors: porch outer 1720mm; front 965mm; internals 926mm (Bedrooms 1, 2, wet room); conservatory/rear French 1720mm; rear threshold ramp 2cm × 8cm.
- Portable fold-up ramps for front/days out: make/length/SWL/count TBC.
- Check-in 3pm key safe. Check-out: 10am vs 11am still inconsistent across HIW / Terms / Guest Guide — do not pick one in copy until Ellie confirms.
- ~10 min from seafront. Shingle beach is **not** a wheelchair route. Tankerton promenade is paved.
- Guest guide: prefer noindex.
- Rates (as last used in briefs): from £185/night; week from £1,300 off-peak / £1,400 peak. Confirm against live site before publishing.

**Audience:** people in the UK who want an accessible holiday by the sea.  
**Whitstable / Kent:** destination, not the customer, unless a page owns a local days-out lane.

## Copy language (owner, 2026-08-13)

- Allowed: **respite** (respite break / respite holiday). Pair with bungalow + optional Continuity. Not a respite centre or care home.
- Allowed: **wheelchair friendly**. Always with millimetres/kit. Not the only access claim.
- Banned: **fully accessible** / fully-accessible in Restwell-authored copy (titles, H1, body, meta, FAQ, alt, schema). Guest reviews stay verbatim, including that phrase.
- Banned: care home, nursing home, respite centre.

Rule file: `.cursor/rules/copy-voice.mdc`

## What already happened

Two Gemini Deep Research runs, tidied into [`aug-research.md`](aug-research.md). **Not copy. Not enough to lock [`LANES.md`](LANES.md).**

| Run | File / brief | Keep | Discard |
| --- | --- | --- | --- |
| **A** | Product + URL map ([`GEMINI-DEEP-RESEARCH.md`](GEMINI-DEEP-RESEARCH.md) — file may be missing; content was the first dump) | Directory kit nouns; competitor listing patterns; BYOS; millimetres; split invoice | “Kent broadly / Whitstable specifically” as strategy; writing titles from its URL map |
| **B** | Searcher journeys ([`GEMINI-SEARCHER-JOURNEY.md`](GEMINI-SEARCHER-JOURNEY.md)) | Five *people*; language table (searcher vs statutory vs listing); `respite` SERP ≠ `accessible holiday` SERP; DP often pays the PA not the cottage | SE/Kent frame; children’s LA short-breaks as Restwell’s product; invented Planner volumes; £450–£650/day from Reddit “what should I charge” [J27]; ADA as UK evidence |

Citations: Run A `[1]`–`[43]`. Run B `[J1]`–`[J37]`. Different source lists.

[`LANES.md`](LANES.md) rebuilt **13 Aug 2026** from the UK SERP + journeys (not Run A’s URL table). Titles/metas in `inc/seo-content-seed-meta.php` still have the old Whitstable primaries — do not ship them until that file is updated.

## What is missing (do this before locking lanes)

Not another Gemini market essay. Live **United Kingdom** Google evidence.

1. Dated **google.co.uk** pass. Region: **United Kingdom** (not London, not Kent). Autocomplete (type, don’t Enter), People Also Ask, Related, page 1. Note whether Restwell appears. **Done 13 Aug 2026** — [`uk-serp-2026-08-13.md`](uk-serp-2026-08-13.md). Caveat: IP city was Maidstone; country was UK. Restwell absent on all five page-1s. Whitstable never offered unseeded.
2. **Keyword Planner** — **unavailable** (no Ads). **Keywords Everywhere** — Ellie has it but **cannot use (paid)** as of 13 Aug 2026 evening. Do not ask again. AlsoAsked + Trends: [`uk-keywords-no-planner-2026-08-13.md`](uk-keywords-no-planner-2026-08-13.md). Wordtracker / Ubersuggest peeks (proprietary, conflicting volumes): [`uk-tools-forums-2026-08-13.md`](uk-tools-forums-2026-08-13.md).
3. Whether **wheelchair friendly** actually appears in those SERPs vs wheelchair accessible. **Both appear** (see the 13 Aug file).
4. Unseeded place: start from the *job*, see if Google offers a town without being typed. **Yes** — Bournemouth, North Berwick, and other coasts; not Whitstable. Kent Coast only as caravans in one AI Overview.
   - `accessible holiday by the sea`
   - `wheelchair friendly seaside holiday`
   - `accessible holiday cottage coast`
   - `disabled holiday seaside UK`
   - `respite holiday by the sea`
5. Enquiry language (form/email/phone) if Victoria can share it. GSC will be thin (launched April 2026).
6. Parents of disabled children searching for a **holiday cottage** (not council short breaks) — Run B mashed those.

**Do not collect more of:** directory filter URLs, council short-breaks PDFs, a third operator memo from Restwell’s kit list.

Free tools we can actually use: google.co.uk, [trends.google.com](https://trends.google.com) (geo=GB), [alsoasked.com](https://alsoasked.com) (3/day, set UK), Search Console (if they share it), Perplexity (quote AI answers, don’t summarise). Forum-named next steps (KE / Mangools / Keysearch): [`uk-tools-forums-2026-08-13.md`](uk-tools-forums-2026-08-13.md). No Planner.

## How to work in Cursor

- Theme only: write/edit inside `restwell-theme/`. Vanilla PHP/HTML/CSS/JS. No React, no npm.
- **In-app browser:** use Cursor’s browser MCP (`cursor-ide-browser`, `browser_navigate` with `position: "active"`). Do **not** `open` URLs in Safari/Chrome. 13 Aug 2026 pass used the in-app browser.
- Notion hub (facts): https://app.notion.com/p/Restwell-Retreats-5a026f337a084357804c679b04eade39
- Equipment register: https://app.notion.com/p/82676e5789b340d1b29ca7f485ffc709

## Next chat — do / don’t

**Do (after the user asks to lock lanes, or pastes GSC / KE captures):**

1. Rebuild `LANES.md` from journeys + live SERP, not from Run A’s URL table.
2. Then titles/metas in `inc/seo-content-seed-meta.php`.
3. Skills if the user @s this folder: cannibalization detector, keyword research, seo-plan. Then linking/schema **after** lanes. No HowTo schema. No FAQ rich-result plan.

**Don’t:** lock lanes from `aug-research.md` alone; write copy yet; hreflang; React landing-page generator; 8–15 blog cluster mill; treat `SEO-INTENT-ONPAGE-PLAN.md` as the daily brief; execute `docs/archive/seo-legacy/`.

**Care URL** still unseeded in `LANES.md`. Add `focus_keyphrase` only when the slug is locked.

---

## First message for the new chat

```text
@restwell-theme/docs/seo

Continue Restwell SEO from docs/seo/HANDOFF.md.

Restwell is one private adapted holiday bungalow in Whitstable. Audience = UK people who want an accessible holiday by the sea. Town is the destination, not the customer.

Copy (2026-08-13): respite and wheelchair friendly allowed (with mm/kit). Never “fully accessible” in Restwell-authored copy. Guest reviews stay verbatim. Not a care home / nursing home / respite centre.

Two Gemini runs are tidied in aug-research.md. Live UK SERP is in uk-serp-2026-08-13.md. AlsoAsked + Trends in uk-keywords-no-planner-2026-08-13.md. Forum tool list in uk-tools-forums-2026-08-13.md.

Keyword Planner is unavailable (no Ads). Do not ask for it. Do not lock LANES.md from Gemini alone.

Use Cursor’s in-app browser (browser MCP, visible). Do not open the system browser.

Only edit restwell-theme/. Do not write copy or rebuild lanes until asked (or I paste GSC / Keywords Everywhere captures).
```
