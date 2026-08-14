# Keywords Everywhere capture — 13 Aug 2026

Ellie has KE but **cannot use it (paid)** as of 13 Aug 2026 evening. Sheet kept as the phrase list only. Do not ask for a KE export. **Do not lock [`LANES.md`](LANES.md) from empty cells.**

Forums: KE uses the same dataset as Keyword Planner ([r/SEO, Sep 2025](https://old.reddit.com/r/SEO/comments/1nf69kg/keywords_everywhere_alternative_not_semrush/)). Expect ranges and a lot of **0** on long-tail.

---

## Settings (do this first)

| Setting | Value |
| --- | --- |
| Country | **United Kingdom** — not United States, not London, not Kent |
| Currency | GBP |
| Data | Google / Keyword Planner source if KE offers a choice (not clickstream-only) |
| Date | Write the UI date on the export |

Bulk tool (faster than 40 SERPs): KE → Keyword Researcher / Bulk analysis → paste the phrases below, one per line.

Record for each: **volume** (or range), **CPC** if shown, **competition** if shown. Leave blank if KE shows nothing. A zero is a result — write `0`.

---

## Paste list (one per line)

```
accessible holiday by the sea
wheelchair friendly seaside holiday
accessible holiday cottage coast
disabled holiday seaside UK
respite holiday by the sea
disabled holidays uk
wheelchair accessible holidays
accessible holidays uk
wheelchair friendly holidays
respite holiday uk
disabled holiday cottages by the sea
accessible holiday cottages by the sea
wheelchair friendly holidays uk
wheelchair friendly beach holidays
accessible holiday cottage uk
disabled seaside holidays
disabled beach holidays uk
respite holiday for carers
disabled holiday cottages with wet room UK
disabled holidays with hoists and profile beds UK
wheelchair friendly accommodation
wheelchair accessible beach holidays
wheelchair adapted holidays uk
accessible holiday cottage whitstable
wheelchair friendly holiday whitstable
self catering disabled holidays uk
disabled holiday bungalows uk with wet room
holidays for disabled in uk
```

Last two are **seeded town** checks. Unseeded Google never offered Whitstable; we only want to know if KE still prints a number when the town is typed.

---

## Results

*Empty until Ellie pastes KE output. Do not invent numbers.*

| Phrase | Group | Vol | CPC | Comp | Notes |
| --- | --- | --- | --- | --- | --- |
| accessible holiday by the sea | job seed | | | | |
| wheelchair friendly seaside holiday | job seed | | | | |
| accessible holiday cottage coast | job seed | | | | |
| disabled holiday seaside UK | job seed | | | | |
| respite holiday by the sea | job seed | | | | |
| disabled holidays uk | Trends control | | | | Trends avg 24 |
| wheelchair accessible holidays | Trends control | | | | Trends avg 7 |
| accessible holidays uk | Trends control | | | | Trends avg 4 |
| wheelchair friendly holidays | Trends control | | | | Trends avg 1 |
| respite holiday uk | Trends control | | | | Trends avg 1 |
| disabled holiday cottages by the sea | autocomplete rewrite | | | | |
| accessible holiday cottages by the sea | autocomplete rewrite | | | | |
| wheelchair friendly holidays uk | autocomplete rewrite | | | | |
| wheelchair friendly beach holidays | autocomplete rewrite | | | | |
| accessible holiday cottage uk | autocomplete rewrite | | | | |
| disabled seaside holidays | autocomplete rewrite | | | | |
| disabled beach holidays uk | autocomplete rewrite | | | | |
| respite holiday for carers | autocomplete rewrite | | | | |
| disabled holiday cottages with wet room UK | kit related | | | | Live related |
| disabled holidays with hoists and profile beds UK | kit related | | | | Live related |
| wheelchair friendly accommodation | live related | | | | |
| wheelchair accessible beach holidays | live related | | | | |
| wheelchair adapted holidays uk | live related | | | | |
| accessible holiday cottage whitstable | seeded town | | | | |
| wheelchair friendly holiday whitstable | seeded town | | | | |
| self catering disabled holidays uk | Wordtracker UK idea | | | | WT vol 75 |
| disabled holiday bungalows uk with wet room | Wordtracker UK idea | | | | WT vol 24 |
| holidays for disabled in uk | Wordtracker UK idea | | | | WT vol 48 |

---

## After paste

Compare Trends order (`disabled holidays uk` larger than accessible, accessible larger than friendly) to KE volumes. If KE is all zeros on job seeds, that matches the forum warning — do not invent demand. Still do not rebuild lanes until this table has real cells.
