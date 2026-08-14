# UK keywords without Planner — 13 Aug 2026

Substitute for Keyword Planner after Google Ads sign-in stalled. **Not volumes. Do not lock [`LANES.md`](LANES.md).**

In-app browser. Same evening as [`uk-serp-2026-08-13.md`](uk-serp-2026-08-13.md).

| Tool | What it can do | What it cannot |
| --- | --- | --- |
| [AlsoAsked](https://alsoasked.com/) | UK PAA trees (3 free/day) | Search volume |
| [Google Trends](https://trends.google.com/trends/explore?geo=GB) geo=GB | Relative interest 0–100 | Monthly searches |

---

## AlsoAsked (United Kingdom, English, Standard depth)

Country set to **United Kingdom** (`region=gb`). After each run the Location field flipped to **London** — AlsoAsked’s UK default, not a city we typed. Treat place questions as UK-plus-London-bias, not Maidstone.

Three free credits used. Timestamp on the first cached tree: **13 Aug 2026, 6:21 pm**.

### 1. `accessible holiday by the sea`

Live/cached tree (parent then children):

- Which seaside town is best for disabled people?
- Where can I find accessible holiday cottages by the sea?
  - Are there any accessible holiday cottages near the sea?
  - Where can I find fully accessible holidays in the UK? *(Google’s phrase — we still never write it)*
- Which Greek island is best for disabled people to visit? *(abroad leak)*
- Where to go on holiday with limited mobility?
  - Where is the best place to travel for people with limited mobility?
  - Which airline is best for disabled passengers?
- What are the best beaches in the UK for people with disabilities?

Greece / airline branches are AlsoAsked expanding a PAA node, not Restwell’s product.

**Whitstable:** not in the tree.

### 2. `wheelchair friendly seaside holiday`

- Which seaside town is best for disabled people?
  - Which beaches in the UK are wheelchair friendly?
  - Which UK towns are most wheelchair-friendly?
  - How do people in wheelchairs go to the beach?
  - What is the prettiest seaside town in the UK?
  - **Is Cromer disabled friendly?** *(unseeded town — Norfolk, not Kent)*
- What are the best holidays for wheelchair users?
- Which all-inclusive resorts are wheelchair friendly?
  - Does TUI offer wheelchair-accessible holidays?
  - Which hotel chain is best at assisting disabled travelers with mobility problems?
- Which country is wheelchair friendly for tourists? *(Spain / Europe children)*

**“Wheelchair friendly” is the PAA language.** “Wheelchair-accessible” appears on the TUI child. Parks/resorts/TUI sit next to town/beach questions.

**Whitstable:** not in the tree. **Cromer** is.

### 3. `respite holiday by the sea`

AlsoAsked: **“There are no People Also Ask results for this term.”** Credit refunded.

The same string **did** have PAA on live google.co.uk the same evening (see the SERP file). Prefer that page-1 log over AlsoAsked here. The empty AlsoAsked result still fits the split: this long-tail is thin and unstable as a “question” query.

---

## Google Trends — broader seeds (geo=GB)

The five unseeded job phrases were too thin (earlier pass). These five are the nearest **country-level** controls.

[Explore](https://trends.google.com/trends/explore?geo=GB&q=accessible%20holidays%20uk,wheelchair%20friendly%20holidays,wheelchair%20accessible%20holidays,disabled%20holidays%20uk,respite%20holiday%20uk): United Kingdom, past 12 months, all categories, Web Search. UI date **13 Aug 2026**.

**Average interest (relative, not searches/month)**

| Term | Average |
| --- | ---: |
| `disabled holidays uk` | 24 |
| `wheelchair accessible holidays` | 7 |
| `accessible holidays uk` | 4 |
| `wheelchair friendly holidays` | 1 |
| `respite holiday uk` | 1 |

`disabled holidays uk` is the only phrase with a regular spring/summer pulse (Feb–Aug 2026). `wheelchair accessible holidays` spikes in Apr–Jun 2026 (one week at 100). `wheelchair friendly holidays` and `respite holiday uk` are mostly flat with rare blips. **Relative only** — a 24 vs 1 is “larger than”, not “24 searches”.

**Subregions (breakdown on the page):** England, Scotland, Wales. No Kent/Whitstable line.

**Related queries (as shown)**

| Seed | Related |
| --- | --- |
| `accessible holidays uk` | Rising: `disabled holidays uk` +50% |
| `wheelchair friendly holidays` | Rising: `wheelchair friendly holidays uk` +90% |
| `wheelchair accessible holidays` | Top: `wheelchair accessible holidays uk` 100; `accessible holidays uk` 98; `disabled holidays` 37 |
| `disabled holidays uk` | Rising: `disabled access holidays uk` +100%; `holidays for disabled in uk` +60%; `holidays for the disabled uk` +50% |
| `respite holiday uk` | Not enough data |

---

## What this changes vs the SERP file

1. **Size order (Trends, GB, relative):** disabled holidays uk ≫ wheelchair accessible holidays > accessible holidays uk > wheelchair friendly holidays ≈ respite holiday uk.
2. **Friendly vs accessible:** live SERP/autocomplete treat both as real. Trends says **accessible** is the larger of the two *holiday* phrases. Do not drop “wheelchair friendly” from research — AlsoAsked and google.co.uk still use it.
3. **Unseeded towns added:** Cromer (AlsoAsked). Still no Whitstable.
4. **Respite** stays a different SERP; AlsoAsked could not even build a PAA tree for the seaside long-tail.

## Still not done

Planner closed as unavailable. Next volume-ish tools (forums): [`uk-tools-forums-2026-08-13.md`](uk-tools-forums-2026-08-13.md). Still open: GSC, enquiry language, children’s holiday-cottage journey (not LA short breaks).

No titles, metas, or lane rebuild from this file.
