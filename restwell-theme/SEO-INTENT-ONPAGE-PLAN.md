# Unified SEO / AEO / GEO plan - Restwell Retreats

**This file is the single source of truth** for organic strategy, measurement, keyword/cluster design, on-page execution, AI/GEO checks, and monthly rituals. Everything else defers here.

**Goal:** One sequenced playbook for **strategy → keyword & cluster design → per-URL titles/meta/ H1s → snippet & body optimization → AI/GEO layer → competitor-style pages → measurement** - using slash skills consistently.

**Related (reference only):** [SKILLS_GLOSSARY.md](SKILLS_GLOSSARY.md) - slash skill names · **[SEO-PROGRESS-MATRIX.md](SEO-PROGRESS-MATRIX.md)** - at-a-glance progress (global prompts, plan spine, §15 mirror, B-tracks, **P4 URL × A–G**).


### 0.1 Documentation map (living vs archived)

| Track | Living docs | Archived |
|-------|-------------|----------|
| **SSOT P1–P10** | This file + [SEO-PROGRESS-MATRIX.md](SEO-PROGRESS-MATRIX.md) | — |
| **Template COPY-PASTE** | [COPY-PASTE-PROCESS.md](COPY-PASTE-PROCESS.md) (workflow) + [COPY-PASTE-PROMPTS.md](COPY-PASTE-PROMPTS.md) (manifests); **post-run sync required** → §13.1 + matrix | [PAGE-RUNS.md](../docs/archive/seo-legacy/prompt-stubs/PAGE-RUNS.md) |
| **Ops plans** | [plan.md](plan.md) (index) · [plan-crm-ops.md](plan-crm-ops.md) · [plan-seo-ops.md](plan-seo-ops.md) | — |
| **Homepage** | [FRONT-PAGE-OPTIMIZATION.md](../FRONT-PAGE-OPTIMIZATION.md) | `docs/archive/seo-legacy/homepage/` |
| **Audit / technical** | [AUDIT.md](AUDIT.md) | `docs/archive/seo-legacy/audit-sprints/` |
| **Legacy strategy** | Absorbed into §2–§8, §16, §19 | `docs/archive/seo-legacy/legacy-strategy/` |
| **§2.6 evidence runs** | [`docs/seo-runs/`](../../docs/seo-runs/) | Index in **§2.6** below |
| **Media SEO** | [MEDIA-SEO-DETAILS.md](MEDIA-SEO-DETAILS.md) | [MEDIA-OPTIMIZATION-TODO.md](../docs/archive/seo-legacy/prompt-stubs/MEDIA-OPTIMIZATION-TODO.md) |
| **Skills index** | [SKILLS_GLOSSARY.md](SKILLS_GLOSSARY.md) (§18 curated subset) | — |

Full merge/archive checklist: [docs/SEO-DOC-CONSOLIDATION-CHECKLIST.md](../docs/SEO-DOC-CONSOLIDATION-CHECKLIST.md).

---

## Progress dashboard (moved)

**Full scoreboard:** edit **[SEO-PROGRESS-MATRIX.md](SEO-PROGRESS-MATRIX.md)** only (single place for matrices). Cursor prompts must update it after each write-back; rules are in that file’s **Sync rules** header and in **Matrix write-back (required)** below.

**§13.1** in this document remains the detailed per-URL audit trail; the matrix holds **symbols only** (`. ~ x`, checkboxes) so you can scan progress in one file.

---

## How to run this in Cursor (skill order)

**Parallel track:** Template-level runs use [COPY-PASTE-PROCESS.md](COPY-PASTE-PROCESS.md) + [COPY-PASTE-PROMPTS.md](COPY-PASTE-PROMPTS.md). After each COPY-PASTE run, map outputs to P4 steps A–G and write back to **§13.1** + [SEO-PROGRESS-MATRIX.md](SEO-PROGRESS-MATRIX.md) (same rules as P4 prompts below).


Invoke skills **in the phase order below** (optimised for dependencies). Crosswalk:


| Your skill                  | Phase in this doc              |
| --------------------------- | ------------------------------ |
| `/seo-plan`                 | §1 Strategic frame             |
| `/seo-aeo-keyword-research` | §2 Keyword & AEO research      |
| `/seo-aeo-content-cluster`  | §3 Topic cluster               |
| `/context-optimization`     | §0 Context budget              |
| `/seo-keyword-strategist`   | §4 Step A                      |
| `/seo-meta-optimizer`       | §4 Step B                      |
| `/seo-snippet-hunter`       | §4 Step D                      |
| `/seo-content-writer`       | §4 Step E                      |
| `/content-creator`          | §5 Voice & editorial rhythm    |
| `/ai-seo`                   | §6 AI search & extractability  |
| `/seo-geo`                  | §7 GEO & technical AI surfaces |
| `/seo-competitor-pages`     | §8 Comparison & alternatives   |
| `/seo-dataforseo`           | §9 Live data (optional)        |
| `/growth-engine`            | §10 Growth metrics             |


Also use: `/seo-structure-architect` (headings), `/seo-cannibalization-detector` (overlap), `/schema-markup` (structured data), `/seo-content-planner` (calendar), `/seo-audit`, `/seo-fundamentals`, `/geo-fundamentals` as needed in §16. For **P2**, plan time for **§2.0**: live SERP or `/seo-dataforseo` / web search MCP when available; shallow lists alone are not enough.

### Copy-paste prompts for Cursor (research + updates)

**Plug-and-play:** Each step is a single fenced **text** code block (triple backticks with the word `text`). Copy the **entire** block (from the opening fence to the closing fence) into Cursor as **your** message to the agent. Session context plus **Goal for this turn** are written for the model to read. **P4 only:** edit **Batch paths** in the block (one `- /path/` per line; homepage `- /`; **1–8 paths** per turn). **Every step** (except the optional PHP-only block) must end with the agent **saving into** `SEO-INTENT-ONPAGE-PLAN.md` at the section named in **Write findings into this plan** for that prompt, **and updating** `SEO-PROGRESS-MATRIX.md` per **Matrix write-back (required)** below.

### What is for you vs for the AI


| Role               | Meaning                                                                                                                                                                                                                                                                                                                                                                             |
| ------------------ | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **You (human)**    | Edit **Current phase**, **Goal for this turn**, and **Batch paths (this run)** inside each **P4** fenced block (one `- /path/` per line; one URL = a batch of one). Anything in `**[Editor note: …]`** is for **you only**: fix the value if needed, then **delete the whole `[Editor note: …]` segment** before you paste, so the AI is not asked to follow editor-only reminders. |
| **The AI (agent)** | Everything else inside the fence after you send it: business lines, **Constraints**, **Write-back**, **Task**, and the closing instructions. The model should follow those literally.                                                                                                                                                                                               |
| **Paste zones**    | Lines starting with `--- Editor:` mean **you** add content **on the next lines** (draft, GSC export, approved table). After pasting, you may delete the whole `--- Editor: … ---` line for a cleaner prompt (optional).                                                                                                                                                             |


**Customize:** In practice, only **Current phase**, **Goal**, and **Batch paths** (and any paste zones) usually need your touch on **P4**. Strip all `[Editor note: …]` text before sending.

**Rules:** Workspace `restwell-theme/` only; `.cursorrules` applies. Do not paste whole `front-page.php` / `seo.php` - point to paths; paste **≤400 words** of body only when a block asks for pasted copy.

### Global fact and style constraints (all Cursor blocks)

Applies to every agent answer written into this plan and to titles, meta, FAQ drafts, and body suggestions implied by these prompts.

1. **No fabrication:** Do not invent property facts (layout, equipment coverage, distances, policies, NHS wording). Use only what is **verbatim or clearly implied** in repo files (`template-*.php`, `template-parts/`, `inc/`, ACF-backed strings) or text the editor pasted in the same thread. If a detail is not in the source, write `Confirm in WP: …` instead of guessing. Example: do not describe a hoist as running through the whole property unless the source states that scope (bedroom-only stays bedroom-only).
2. **Banned phrase:** Never use `fully accessible` in any form (headings, body, meta, FAQs, tables).
3. **No em dash in agent outputs:** Do not use the Unicode em dash character (U+2014) in anything you append or suggest for publish. Use commas, colons, parentheses, or a normal ASCII hyphen. (This plan is being normalized the same way in copy-paste blocks so prompts model the rule.)
4. `**/avoid-ai-writing`:** Before saving customer-facing strings, self-check against `/avoid-ai-writing` (remove AI-isms, empty intensifiers, template transitions, promotional filler); rewrite in plain British English.

### Write findings into this plan (required)

Unless a block says **PHP edits only**, the agent must **edit and save** `SEO-INTENT-ONPAGE-PLAN.md` **and** `SEO-PROGRESS-MATRIX.md` in this theme folder so research, decisions, and **progress symbols** stay in sync - not only in chat. Use **ISO date** (`YYYY-MM-DD`) in new `####` run headings in the plan. Preserve existing markdown tables (valid `|` rows); append new rows rather than deleting history unless you are correcting an error.


| Prompt                | Where to write in `SEO-INTENT-ONPAGE-PLAN.md`                                                                                                                                                                                                                                                                                                                                                        |
| --------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **P1**                | End of **§1**: append `#### Agent strategic run - YYYY-MM-DD` (positioning, 90-day priorities, risks). Fill **§1.2 KPI table** cells only when you have real numbers; otherwise leave blank or `TBD`.                                                                                                                                                                                                |
| **P2**                | **§2.6**: append dated run with **Research brief** (files read, SERP or tool notes, PAA themes, competitor snapshot) **then** Tier 1/2/3 tables (with **Evidence** column per §2.0), AEO table (`Question` | `Answer format` | `Notes`), cannibalization bullets, content map (`Keyword` | `URL` | `Type`); **Gap** subsection if any tier is under §2.0 row targets; **Next validation** paragraph. |
| **P2 (PHP optional)** | Theme PHP **and** a one-line note at end of that **§2.6** run: files touched.                                                                                                                                                                                                                                                                                                                        |
| **P3**                | **§3.5** cluster run (articles table + link tree). Add rows to **§16 B3** 90-day backlog table where empty.                                                                                                                                                                                                                                                                                          |
| **P4 Step A–E**       | **§13.1**: add or update the **table row** for **each path** listed under **Batch paths** in that prompt.                                                                                                                                                                                                                                                                                            |
| **P4 Step F**         | **§16 B2** intent map: for **each** path in **Batch paths**, compare to **Comparison anchor** and add or fix rows.                                                                                                                                                                                                                                                                                   |
| **P4 Step G**         | **§13.1** for **each** path in **Batch paths**: set **Published / verified** notes and date; add under **§11.6** per path if relevant.                                                                                                                                                                                                                                                               |
| **P5**                | **§13.1** Notes column for that URL **or** append `#### Agent voice run - YYYY-MM-DD` under **§5** with editor bullets (do not paste huge full drafts into the plan - summarize; full copy can stay in WP).                                                                                                                                                                                          |
| **P6**                | **§6.3**: append dated pass/fail table vs §6.1 + two AI Overview test queries.                                                                                                                                                                                                                                                                                                                       |
| **P7**                | **§7.1**: append dated findings list (severity + file path).                                                                                                                                                                                                                                                                                                                                         |
| **P8**                | **§8.1**: append dated H1/H2 + FAQ outline + comparison table headers.                                                                                                                                                                                                                                                                                                                               |
| **P9**                | **§9.1**: append metrics table for the keyword batch (or manual SERP steps if no API).                                                                                                                                                                                                                                                                                                               |
| **P10**               | **§11.6** monthly bullets + **§1.2** / **§11.2** cell updates if new numbers; optional **§16 B6** one-liner experiment.                                                                                                                                                                                                                                                                              |


### Matrix write-back (required)

After the plan edit in the same agent turn, **edit and save** [SEO-PROGRESS-MATRIX.md](SEO-PROGRESS-MATRIX.md): set **Meta → Last updated** to today (ISO). Apply **only** the cells for the prompt you ran (follow **Sync rules** in that file if in doubt).


| Prompt                | Updates in `SEO-PROGRESS-MATRIX.md`                                                                                                                                                                                                               |
| --------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **P1**                | **Section 1** (Global prompts): P1 → `[x]`. **Section 2** (Plan spine): row **§1** → `x`; set **Last pass (ISO)**. **Meta:** Last updated.                                                                                                        |
| **P2**                | **Section 1:** P2 → `[x]`. **Section 2:** rows **§2** and **§2.0** → `x` or `~` (use `~` on §2.0 if plan §2.0 targets not met; `~` on §2 if Gap/Next validation still open). **Last pass** for §2 and §2.0 as applicable. **Meta:** Last updated. |
| **P2 (PHP optional)** | **Section 2:** row **§2** → `~` if only PHP plus one-line §2.6 note; **§2.0** unchanged unless the same run refreshed §2.0 evidence. **Meta:** Last updated.                                                                                      |
| **P3**                | **Section 1:** P3 → `[x]`. **Section 2:** row **§3** → `x`. **Section 4** (B-tracks): B3 if backlog changed. **Meta:** Last updated.                                                                                                              |
| **P4 Step A**         | **Section 5:** for **each** Path in **Batch paths**, column **A** → `x` or `~`. **Section 2:** rows **§4** and **§13** → at least `~`. **Meta:** Last updated.                                                                                    |
| **P4 Step B**         | **Section 5:** for **each** Path in **Batch paths**, column **B** → `x` or `~`. **Meta:** Last updated.                                                                                                                                           |
| **P4 Step C**         | **Section 5:** for **each** Path in **Batch paths**, column **C** → `x` or `~`. **Meta:** Last updated.                                                                                                                                           |
| **P4 Step D**         | **Section 5:** for **each** Path in **Batch paths**, column **D** → `x` or `~`. **Meta:** Last updated.                                                                                                                                           |
| **P4 Step E**         | **Section 5:** for **each** Path in **Batch paths**, column **E** → `x` or `~`. **Meta:** Last updated.                                                                                                                                           |
| **P4 Step F**         | **Section 5:** column **F** → `x` or `~` for **each** path in **Batch paths** and for **Comparison anchor** if it has a matrix row. **Section 4:** B2 row → `x` if intent map updated. **Meta:** Last updated.                                    |
| **P4 Step G**         | **Section 5:** for **each** Path in **Batch paths**, column **G** → `x`. **Section 2:** row **§11** → `~` if §11.6 got dated lines. **Section 3:** mirror §15 “§13 worksheet” row if appropriate. **Meta:** Last updated + optional G count.      |
| **P5**                | **Section 1:** P5 → `[x]`. **Section 2:** row **§5** → `x` or `~`. **Meta:** Last updated.                                                                                                                                                        |
| **P6**                | **Section 1:** P6 → `[x]`. **Section 2:** row **§6** → `x` or `~`. **Section 3:** “§6–7 spot-check” row if this run covers it. **Meta:** Last updated.                                                                                            |
| **P7**                | **Section 1:** P7 → `[x]`. **Section 2:** row **§7** → `x` or `~`. **Section 3:** “§6–7 spot-check” row if applicable. **Meta:** Last updated.                                                                                                    |
| **P8**                | **Section 1:** P8 → `[x]`. **Section 2:** row **§8** → `x` or `~`. **Section 3:** “Comparison/alternatives” row if applicable. **Meta:** Last updated.                                                                                            |
| **P9**                | **Section 1:** P9 → `[x]`. **Section 2:** row **§9** → `x` or `~`. **Meta:** Last updated.                                                                                                                                                        |
| **P10**               | **Section 1:** P10 → `[x]`. **Section 2:** rows **§10** and **§11** → `x` or `~`. **Section 3:** mirror §11.2 / B6 / KPI checklist rows if you changed them. **Meta:** Last updated.                                                              |


**Session context pattern (repeated in each block):**


| Field                 | Default in blocks below    | When to change (you)                                                                                                              |
| --------------------- | -------------------------- | --------------------------------------------------------------------------------------------------------------------------------- |
| Current phase         | `Foundation - Weeks 1–4`   | You are in Expansion / Scale (see §1.3).                                                                                          |
| Batch paths (P4 only) | Example list in each block | Replace with your paths: one `- /path/` per line (homepage = `- /`). Same **Step letter** for every line. **1–8 paths** per turn. |
| Goal for this turn    | One sentence per step      | You need a narrower outcome (e.g. “titles only”).                                                                                 |


---

#### P1 - Strategic frame (`/seo-plan`)

```text
Context for this session:
- Source of truth: SEO-INTENT-ONPAGE-PLAN.md (this repo, restwell-theme).
- Business: Accessible self-catering holiday accommodation, Whitstable area, Kent, UK.
- Audience: Disabled people and families, carers, commissioners, funding-aware bookers.
- Current phase: Foundation - Weeks 1–4 (strategic alignment). [Editor note: change this line if not default, then delete this note.]
- Active URL or pillar: Site-wide planning (no single URL). [Editor note: change this line if not default, then delete this note.]
- Goal for this turn: Deliver a concise strategic framing pack from §1 - positioning one-liner, five 90-day organic priorities tied to §1.3, risks (YMYL/funding), and which §1.2 KPI cells to fill first - then **write it into** `SEO-INTENT-ONPAGE-PLAN.md` (see **§How to run → Write findings into this plan** table for **P1**).

Constraints:
- WordPress theme only; follow .cursorrules (escape output, ACF fallbacks, no React/npm).
- **Facts:** No invented property or equipment scope; use repo files or editor-pasted text only. If unsure, write `Confirm in WP: …` (example: do not claim hoist coverage beyond what the source states).
- **Banned phrase:** Never use `fully accessible` anywhere (titles, meta, body, FAQs).
- **Punctuation:** Do not output Unicode em dash (U+2014); use commas, colons, parentheses, or ASCII hyphen in everything you add to the plan or suggest for publish.
- **Prose:** Self-check customer-facing strings with `/avoid-ai-writing` before saving.

Write-back (required):
1. Edit `SEO-INTENT-ONPAGE-PLAN.md` at the repo path for this theme.
2. After **§1.3** (or end of §1), append `#### Agent strategic run - YYYY-MM-DD` with: (a) positioning one-liner, (b) five 90-day bullets, (c) risks, (d) KPI guidance.
3. In **§1.2 KPI table**, fill cells only when you have real values; use blank or `TBD` for unknowns; do not invent metrics.
4. Edit `SEO-PROGRESS-MATRIX.md` per **Matrix write-back** for **P1** (Global P1, Plan spine §1, Meta last updated).

Task:
Using SEO-INTENT-ONPAGE-PLAN.md §1 as the checklist, produce the content above, then save **both** markdown files (`SEO-INTENT-ONPAGE-PLAN.md` and `SEO-PROGRESS-MATRIX.md`).

Do not edit PHP theme files in this turn.
```

---

#### P2 - Keyword & AEO research (`/seo-aeo-keyword-research`)

**Default pillar:** `/resources/`. For **The Property** commercial core instead, change *Active URL* to `/the-property/` and ask the model to bias seeds toward Whitstable + booking + cottage wording; for **Accessibility** specs, use `/accessibility/` and hoist/wet-room seeds first.

```text
Context for this session:
- Source of truth: SEO-INTENT-ONPAGE-PLAN.md (this repo, restwell-theme).
- Business: Accessible self-catering holiday accommodation, Whitstable area, Kent, UK.
- Audience: Disabled people and families, carers, commissioners, funding-aware bookers.
- Current phase: Foundation - keyword & AEO research (quarterly refresh later). [Editor note: change this line if not default, then delete this note.]
- Active URL or pillar: /resources/ - funding & navigation hub. [Editor note: if your pillar is /the-property/ or /accessibility/, change this line, then delete this note.]
- Goal for this turn: Run **§2.0 depth research** (repo + SERP or tools), then produce Tier 1/2/3 lists with **Evidence** column, ≥5 AEO questions, cannibalization ownership, Tier 1–2 content map, and a **Gap** note if targets are not met - then **append everything to** `SEO-INTENT-ONPAGE-PLAN.md` **§2.6** (see Write-back table **P2**).

Constraints:
- WordPress theme only; follow .cursorrules.
- **Research depth:** Follow **§2.0** in `SEO-INTENT-ONPAGE-PLAN.md`. Invoke **`/seo-aeo-keyword-research`** for methodology; combine with **live UK SERPs**, **`/seo-dataforseo`**, or **web search MCP** when the session supports it. Tables must be **evidence-led** (Evidence column), not filler from memory alone.
- **Facts:** No invented property or equipment scope; use repo files or editor-pasted text only. If unsure, write `Confirm in WP: …` (example: do not claim hoist coverage beyond what the source states).
- **Banned phrase:** Never use `fully accessible` anywhere (titles, meta, body, FAQs).
- **Punctuation:** Do not output Unicode em dash (U+2014); use commas, colons, parentheses, or ASCII hyphen in everything you add to the plan or suggest for publish.
- **Prose:** Self-check customer-facing strings with `/avoid-ai-writing` before saving.

Write-back (required):
1. Edit `SEO-INTENT-ONPAGE-PLAN.md`.
2. Under **§2.6**, append `#### Run - YYYY-MM-DD - <Active pillar path>` in this order: (1) **Research brief** (bullets: files read with paths; SERP or tool pass summary; PAA themes; 3+ competitor or result-type notes for ≥1 head query); (2) tier tables with **Evidence** column per §2.0; (3) AEO table; (4) cannibalization bullets; (5) content map; (6) **Gap** subsection if below §2.0 row targets (say exactly what to run next). End with **Next validation** (what to confirm in Ahrefs, Semrush, or `/seo-dataforseo` before locking primaries).
3. Edit `SEO-PROGRESS-MATRIX.md` per **Matrix write-back** for **P2** (and **Meta** last updated).

Task:
Follow **§2.0 Research depth** in `SEO-INTENT-ONPAGE-PLAN.md`, then execute for the pillar named above.

Research protocol (complete before the tables; write the brief into the plan first):

1. **Repo pass (required):** Read the pillar route’s templates and SEO seed files (name each path you opened). Pull **actual on-page phrases** that support keyword choices. Do **not** add property or policy claims that are not in those sources (use `Confirm in WP: …` when copy is missing).

2. **SERP or market pass (required):** For **≥3** queries (pick from seeds below or your Tier 1 candidates), do at least one of: live **google.co.uk** spot-check (logged out or neutral window), **`/seo-dataforseo`**, or another **web / search MCP** available in the session. For each query record: **top 3 result types** (e.g. OTA, national brand, local property site, guide), and **one People Also Ask or related-search theme**. If no tool or browser is available, write **`SERP check TBD - editor`** and list the exact queries + steps for the human (UK, mobile + desktop).

3. **Expansion:** Build tiers per §2.1–§2.2. **Target row counts** (if you cannot justify a row, do not pad with vague synonyms; instead list the gap): Tier 1 **≥6**, Tier 2 **≥8**, Tier 3 **≥5**.

4. **AEO:** **≥5** questions with answer format and **one line each on why it is winnable** (snippet gap, weak SERP answers, or tie to Restwell page).

5. **Cannibalization:** **≥4** bullets mapping **keyword themes → owning URL** using §2.4 and **§16 B2** logic.

6. **Evidence column:** On every tier table add column **Evidence** with one of: `SERP spot-check YYYY-MM-DD`, `DataForSEO (metric + date)`, `Theme copy (quote short phrase)`, `Hypothesis - validate with ___`.

Seeds (use 3–5 as core; expand with close variants):
- accessible self catering Kent
- accessible holiday cottage Whitstable
- CHC respite holiday / NHS continuing healthcare holiday (YMYL - careful)
- direct payment holiday accommodation
- hoist tracking wet room accessible cottage
- accessible coastal holiday Kent
- wheelchair accessible holiday let Kent
- carer respite break self catering UK

Think step by step (repo, then SERP/tools, then tables). Save `SEO-INTENT-ONPAGE-PLAN.md` and `SEO-PROGRESS-MATRIX.md` (Matrix write-back **P2**).

Do not edit PHP in this message (use the optional PHP block separately).
```

**Optional second paste - apply approved research to PHP**

```text
Context for this session:
- Source of truth: SEO-INTENT-ONPAGE-PLAN.md (this repo, restwell-theme).
- Business: Accessible self-catering holiday accommodation, Whitstable area, Kent, UK.
- Audience: Disabled people and families, carers, commissioners, funding-aware bookers.
- Current phase: Foundation - implement approved keyword/AEO seeds in theme PHP. [Editor note: change this line if not default, then delete this note.]
- Active URL or pillar: Same pillar as the research message immediately above (e.g. /resources/). [Editor note: change this line if not default, then delete this note.]
- Goal for this turn: Merge the last approved keyword/AEO table from this thread into existing PHP definitions without breaking arrays or WordPress escaping conventions, and **note** the change in `SEO-INTENT-ONPAGE-PLAN.md` **§2.6** (one line: files touched + date).

Constraints:
- WordPress theme only; follow .cursorrules; no inline scripts in templates.
- **Facts:** No invented property or equipment scope; use repo files or editor-pasted text only. If unsure, write `Confirm in WP: …` (example: do not claim hoist coverage beyond what the source states).
- **Banned phrase:** Never use `fully accessible` anywhere (titles, meta, body, FAQs).
- **Punctuation:** Do not output Unicode em dash (U+2014); use commas, colons, parentheses, or ASCII hyphen in everything you add to the plan or suggest for publish.
- **Prose:** Self-check customer-facing strings with `/avoid-ai-writing` before saving.

Task:
Apply the agreed outputs. If the approved table or bullet list is **not** visible earlier in this same Cursor thread, the **editor** must paste it under the dashed line below **before** sending this block to the AI.

Targets (edit only what already exists):
- inc/seo-content-seed-blog-cluster-a.php and/or other inc/seo-content-seed*.php if relevant
- inc/page-meta-definitions.php or inc/seo.php if titles/meta/H1 seeds need alignment

Rules:
- Preserve existing arrays/structure; match naming style; sanitize strings.

Then edit `SEO-INTENT-ONPAGE-PLAN.md` §2.6 latest run: append one bullet line `PHP updated: <files>` with date. Edit `SEO-PROGRESS-MATRIX.md` per **Matrix write-back** for **P2 (PHP optional)**.

--- Editor: paste approved table or bullet list from the prior message below (you may delete this whole line after pasting) ---
```

---

#### P3 - Topic cluster (`/seo-aeo-content-cluster`)

```text
Context for this session:
- Source of truth: SEO-INTENT-ONPAGE-PLAN.md (this repo, restwell-theme).
- Business: Accessible self-catering holiday accommodation, Whitstable area, Kent, UK.
- Audience: Disabled people and families, carers, commissioners, funding-aware bookers.
- Current phase: Foundation - topic cluster design. [Editor note: change this line if not default, then delete this note.]
- Active URL or pillar: /resources/ (pillar hub). [Editor note: if your hub is another slug (e.g. /how-to-choose-accessible-self-catering-holiday/), change this line, then delete this note.]
- Goal for this turn: Produce a cluster plan - unique primary per article with P1|P2|P3, suggested slugs, internal link tree per §3.3, two AEO-priority pieces, and §3.4 content gaps - then **write it into** `SEO-INTENT-ONPAGE-PLAN.md` **§3.5** and extend **§16 B3** backlog rows (Write-back **P3**).

Constraints:
- WordPress theme only; follow .cursorrules.
- **Facts:** No invented property or equipment scope; use repo files or editor-pasted text only. If unsure, write `Confirm in WP: …` (example: do not claim hoist coverage beyond what the source states).
- **Banned phrase:** Never use `fully accessible` anywhere (titles, meta, body, FAQs).
- **Punctuation:** Do not output Unicode em dash (U+2014); use commas, colons, parentheses, or ASCII hyphen in everything you add to the plan or suggest for publish.
- **Prose:** Self-check customer-facing strings with `/avoid-ai-writing` before saving.

Write-back (required):
1. Edit `SEO-INTENT-ONPAGE-PLAN.md`.
2. Under **§3.5**, append `#### Cluster run - YYYY-MM-DD - <pillar path>` with article table, link tree, AEO-priority lines, gaps.
3. Add rows to **§16 B3** `90-day backlog` table for new dated work (fill `Week`, `Deliverable`, `Target keyword / intent`, `Owner` where you can).
4. Edit `SEO-PROGRESS-MATRIX.md` per **Matrix write-back** for **P3**.

Task:
Build or refine the topic cluster using SEO-INTENT-ONPAGE-PLAN.md §3 for the pillar above.

Deliver:
1. List of cluster articles with **unique primary keyword** each, priority P1|P2|P3, suggested slug.
2. Internal link tree (pillar ↔ posts) per §3.3.
3. Two **AEO-priority** pieces flagged (question title + format).
4. Content gaps vs §3.4 (questions competitors skip).

Save **both** `SEO-INTENT-ONPAGE-PLAN.md` and `SEO-PROGRESS-MATRIX.md` after edits.
```

---

#### P4 - Per-URL pipeline (**batch paths only**)

**How it works:** Each Step **A–G** below is a **batch** prompt. You list **one or more** paths under **Batch paths (this run)** (same Markdown list style as the examples: `- /path/` per line). Homepage = `- /`. **Cap: 8 paths per turn.** The agent runs **that step letter for every listed path** in one save. One URL only? Use a **batch of one** (a single `- /your-path/` line).

**Templates and defaults:** Resolve theme file, page type, and suggested focus phrases from **P4 - Per-URL preset catalog** (master table). You do **not** need to paste eight **Preset pack** blocks when batching; the table columns are enough.

**Step A - Intent & vocabulary (`/seo-keyword-strategist`)**

```text
Context for this session:
- Source of truth: SEO-INTENT-ONPAGE-PLAN.md (this repo, restwell-theme).
- Business: Accessible self-catering holiday accommodation, Whitstable area, Kent, UK.
- Audience: Disabled people and families, carers, commissioners, funding-aware bookers.
- Current phase: Foundation - Per-URL Step A (intent & vocabulary). [Editor note: change if not default, then delete this note.]
- Batch paths (this run) — replace with your list (1–8 paths):
  - /faq/
  - /guest-guide/
- Goal for this turn: For **each path** in **Batch paths**, derive primary keyword, 3–5 secondaries, LSI/entities, intent label, and cannibalization warnings by reading that path's theme source (see preset catalog master table), then **record in** `SEO-INTENT-ONPAGE-PLAN.md` **§13.1** (new or updated row per path) and optional **§4.1** (Write-back **P4 Step A**).

Constraints:
- WordPress theme only; follow .cursorrules.
- **Facts:** No invented property or equipment scope; use repo files or editor-pasted text only. If unsure, write `Confirm in WP: …` (example: do not claim hoist coverage beyond what the source states).
- **Banned phrase:** Never use `fully accessible` anywhere (titles, meta, body, FAQs).
- **Punctuation:** Do not output Unicode em dash (U+2014); use commas, colons, parentheses, or ASCII hyphen in everything you add to the plan or suggest for publish.
- **Prose:** Self-check customer-facing strings with `/avoid-ai-writing` before saving.

Write-back (required):
1. Edit `SEO-INTENT-ONPAGE-PLAN.md`.
2. In **§13.1**, for **each** path in **Batch paths**: add/update that row: `Run date`, `Tier`, `Primary`, `Secondaries`, intent notes in `Body / links notes` or a tight `H1 / H2 summary` cell.
3. Optionally append `####` block(s) under **§4.1** summarizing Step A (one dated heading with sub-bullets per path is fine).
4. Edit `SEO-PROGRESS-MATRIX.md` per **Matrix write-back** for **P4 Step A**: column **A** → `x` or `~` for **each** Path row (homepage = `/`).

Task:
Act as SEO keyword strategist.

For **each** path in **Batch paths**:
1. One **primary** keyword (exact phrase) justified by on-page copy in repo for that path.
2. 3–5 **secondary** keywords.
3. LSI / entity terms to weave naturally.
4. Intent classification + note if another Restwell URL could steal the same primary (cannibalization).

Output as tight bullet lists in the plan table cells (short text), then one line per path if needed: “do not also target ___ on URL ___”.

If copy is missing in templates, say what the editor should add in WP rather than inventing claims.

Save `SEO-INTENT-ONPAGE-PLAN.md` and `SEO-PROGRESS-MATRIX.md` after completing **Write-back** above.
```

**Step B - Title & meta (`/seo-meta-optimizer`)**

```text
Context for this session:
- Source of truth: SEO-INTENT-ONPAGE-PLAN.md (this repo, restwell-theme).
- Business: Accessible self-catering holiday accommodation, Whitstable area, Kent, UK.
- Audience: Disabled people and families, carers, commissioners, funding-aware bookers.
- Current phase: Foundation - Per-URL Step B (title & meta). [Editor note: change if not default, then delete this note.]
- Batch paths (this run) — replace with your list (1–8 paths):
  - /faq/
  - /guest-guide/
- Goal for this turn: For **each path** in **Batch paths**, produce three title and three meta description variants using keywords from **§13.1** (Step A) or the **P4 preset catalog** default focus for that path - recommend one pick with rationale - then **log in** `SEO-INTENT-ONPAGE-PLAN.md` **§13.1** per path (Write-back **P4 Step B**). Do not edit `inc/seo.php` until human confirms in a follow-up.

Constraints:
- WordPress theme only; follow .cursorrules.
- **Facts:** No invented property or equipment scope; use repo files or editor-pasted text only. If unsure, write `Confirm in WP: …` (example: do not claim hoist coverage beyond what the source states).
- **Banned phrase:** Never use `fully accessible` anywhere (titles, meta, body, FAQs).
- **Punctuation:** Do not output Unicode em dash (U+2014); use commas, colons, parentheses, or ASCII hyphen in everything you add to the plan or suggest for publish.
- **Prose:** Self-check customer-facing strings with `/avoid-ai-writing` before saving.

Write-back (required):
1. Edit `SEO-INTENT-ONPAGE-PLAN.md` **§13.1** for **each** path in **Batch paths**: fill `Title (chosen)` and `Meta (chosen)` with the recommended pick; put runner-up titles/metas in `Body / links notes` or append under **§4.1** as `#### Step B - YYYY-MM-DD`.
2. Edit `SEO-PROGRESS-MATRIX.md` per **Matrix write-back** for **P4 Step B**: column **B** for **each** Path row.

Task:
Generate search titles and meta descriptions **for each path** in **Batch paths**.

For **each** path:
- Read USPs from theme copy (repo) for that path; do not invent equipment scope.
- Brand rule: append brand at end unless homepage (`/`).

Deliver per path:
- 3 title variants (~50–60 chars; primary in first ~30 chars).
- 3 meta description variants (~150–160 chars; benefit + keyword + one CTA).
- Recommended pick + one-line rationale.

Save `SEO-INTENT-ONPAGE-PLAN.md` and `SEO-PROGRESS-MATRIX.md` after completing **Write-back** above.
```

**Step C - Headings (`/seo-structure-architect`)**

```text
Context for this session:
- Source of truth: SEO-INTENT-ONPAGE-PLAN.md (this repo, restwell-theme).
- Business: Accessible self-catering holiday accommodation, Whitstable area, Kent, UK.
- Audience: Disabled people and families, carers, commissioners, funding-aware bookers.
- Current phase: Foundation - Per-URL Step C (H1/H2). [Editor note: change if not default, then delete this note.]
- Batch paths (this run) — replace with your list (1–8 paths):
  - /faq/
  - /guest-guide/
- Goal for this turn: For **each path** in **Batch paths**, propose one H1 and an ordered H2/H3 outline aligned to Step A keywords and §2.3 AEO-style questions - then **store in** `SEO-INTENT-ONPAGE-PLAN.md` **§13.1** `H1 / H2 summary` (and optional **§4.1**) - Write-back **P4 Step C**.

Constraints:
- WordPress theme only; follow .cursorrules.
- **Facts:** No invented property or equipment scope; use repo files or editor-pasted text only. If unsure, write `Confirm in WP: …` (example: do not claim hoist coverage beyond what the source states).
- **Banned phrase:** Never use `fully accessible` anywhere (titles, meta, body, FAQs).
- **Punctuation:** Do not output Unicode em dash (U+2014); use commas, colons, parentheses, or ASCII hyphen in everything you add to the plan or suggest for publish.
- **Prose:** Self-check customer-facing strings with `/avoid-ai-writing` before saving.

Write-back (required):
1. Edit `SEO-INTENT-ONPAGE-PLAN.md` **§13.1** for **each** path in **Batch paths**: compact H1 + H2 list in the `H1 / H2 summary` column.
2. Edit `SEO-PROGRESS-MATRIX.md` per **Matrix write-back** for **P4 Step C**: column **C** for **each** Path row.

Task:
For **each** path in **Batch paths**: propose H1 + H2 outline aligned to that URL's Step A keywords and §2.3 AEO questions.

Rules:
- Exactly one H1 per path; H2s mirror questions and intent.
- Short section labels.

Output: ordered list H1 → H2 → H3 where needed (inside each row's table cell or under §4.1 per path).

Save `SEO-INTENT-ONPAGE-PLAN.md` and `SEO-PROGRESS-MATRIX.md` after completing **Write-back** above.
```

**Step D - Snippets & FAQ (`/seo-snippet-hunter`)**

```text
Context for this session:
- Source of truth: SEO-INTENT-ONPAGE-PLAN.md (this repo, restwell-theme).
- Business: Accessible self-catering holiday accommodation, Whitstable area, Kent, UK.
- Audience: Disabled people and families, carers, commissioners, funding-aware bookers.
- Current phase: Foundation - Per-URL Step D (snippets & FAQ). [Editor note: change if not default, then delete this note.]
- Batch paths (this run) — replace with your list (1–8 paths):
  - /faq/
  - /guest-guide/
- Goal for this turn: For **each path** in **Batch paths**, draft **4–6** snippet-grade FAQ Q&A pairs derived from that page's template copy and intent - then **append to** `SEO-INTENT-ONPAGE-PLAN.md` **§13.1** `Snippets / FAQ summary` (≤80 words per answer in cells, or tight bullets) - Write-back **P4 Step D**.

Constraints:
- WordPress theme only; follow .cursorrules.
- **Facts:** No invented property or equipment scope; use repo files or editor-pasted text only. If unsure, write `Confirm in WP: …` (example: do not claim hoist coverage beyond what the source states).
- **Banned phrase:** Never use `fully accessible` anywhere (titles, meta, body, FAQs).
- **Punctuation:** Do not output Unicode em dash (U+2014); use commas, colons, parentheses, or ASCII hyphen in everything you add to the plan or suggest for publish.
- **Prose:** Self-check customer-facing strings with `/avoid-ai-writing` before saving.

Write-back (required):
1. Edit `SEO-INTENT-ONPAGE-PLAN.md` **§13.1** for **each** path in **Batch paths**: fill `Snippets / FAQ summary` with Q→heading→short answer bullets.
2. Note JSON-LD / theme file path for FAQ if found (same cell or §4.1).
3. Edit `SEO-PROGRESS-MATRIX.md` per **Matrix write-back** for **P4 Step D**: column **D** for **each** Path row.

Task:
For **each** path in **Batch paths**:
1. Derive 4–6 questions a searcher would ask **for that URL's intent** (use template headings, body strings, and page type from preset catalog).
2. Per question: 40–60 word paragraph; answer in **first sentence**; mirror question words in the suggested heading line.
3. If any answer needs a comparison, give table column headers + three row labels only.

Search the theme for existing FAQPage or FAQ-related JSON-LD and cite file path if found.

Save `SEO-INTENT-ONPAGE-PLAN.md` and `SEO-PROGRESS-MATRIX.md` after completing **Write-back** above.
```

**Step E - Body polish (`/seo-content-writer`)**

```text
Context for this session:
- Source of truth: SEO-INTENT-ONPAGE-PLAN.md (this repo, restwell-theme).
- Business: Accessible self-catering holiday accommodation, Whitstable area, Kent, UK.
- Audience: Disabled people and families, carers, commissioners, funding-aware bookers.
- Current phase: Foundation - Per-URL Step E (body polish). [Editor note: change if not default, then delete this note.]
- Batch paths (this run) — replace with your list (1–8 paths):
  - /faq/
  - /guest-guide/
- Goal for this turn: For **each path** in **Batch paths**, tighten body copy and suggest internal links from **repo template text** unless the Editor paste zone has `### /path/` excerpts. **Log** a short outcome in `SEO-INTENT-ONPAGE-PLAN.md` **§13.1** `Body / links notes` (≤400 characters or tight bullets per path; do not paste huge HTML into the plan) - Write-back **P4 Step E**. Apply PHP/WP only if I say so in a follow-up.

Constraints:
- WordPress theme only; follow .cursorrules.
- **Facts:** No invented property or equipment scope; use repo files or editor-pasted text only. If unsure, write `Confirm in WP: …` (example: do not claim hoist coverage beyond what the source states).
- **Banned phrase:** Never use `fully accessible` anywhere (titles, meta, body, FAQs).
- **Punctuation:** Do not output Unicode em dash (U+2014); use commas, colons, parentheses, or ASCII hyphen in everything you add to the plan or suggest for publish.
- **Prose:** Self-check customer-facing strings with `/avoid-ai-writing` before saving.

Write-back (required):
1. Edit `SEO-INTENT-ONPAGE-PLAN.md` **§13.1** for **each** path in **Batch paths**: `Body / links notes` = summary + internal link targets (anchors).
2. Put **full revised drafts** in chat below your edit summary (one section per path, labeled by path) when Editor paste zone supplied polished copy; otherwise chat may be outline-only per path.
3. Edit `SEO-PROGRESS-MATRIX.md` per **Matrix write-back** for **P4 Step E**: column **E** for **each** Path row.

Task:
For **each** path in **Batch paths**:
- If the Editor paste zone below has a `### /path/` section, polish **only** that pasted block for that path.
- Otherwise read the theme template(s) for that path and produce: intro hook suggestion (50–100 words max in chat), specificity bullets, and 2–4 internal link suggestions with varied anchors.

Goals:
- Specifics (access features, booking realism); calm YMYL tone for funding-adjacent lines.

Save `SEO-INTENT-ONPAGE-PLAN.md` and `SEO-PROGRESS-MATRIX.md` after completing **Write-back** above.

--- Editor: optional pasted drafts (use `### /slug/` per path); delete this line when done ---
```

**Step F - Cannibalization sweep (`/seo-cannibalization-detector`)**

```text
Context for this session:
- Source of truth: SEO-INTENT-ONPAGE-PLAN.md (this repo, restwell-theme).
- Business: Accessible self-catering holiday accommodation, Whitstable area, Kent, UK.
- Audience: Disabled people and families, carers, commissioners, funding-aware bookers.
- Current phase: Foundation - cannibalization check. [Editor note: change if not default, then delete this note.]
- Batch paths (this run) — paths to evaluate (1–8 paths):
  - /faq/
  - /guest-guide/
- Comparison anchor (required): /resources/
- Goal for this turn: For **each path** in **Batch paths**, compare that path to **Comparison anchor** for overlapping primary intent and keyword cannibalization; **record verdict + actions in** `SEO-INTENT-ONPAGE-PLAN.md` **§16 B2** (Write-back **P4 Step F**). Optional one line in **§13.1** Notes per URL.

Constraints:
- WordPress theme only; follow .cursorrules.
- **Facts:** No invented property or equipment scope; use repo files or editor-pasted text only. If unsure, write `Confirm in WP: …` (example: do not claim hoist coverage beyond what the source states).
- **Banned phrase:** Never use `fully accessible` anywhere (titles, meta, body, FAQs).
- **Punctuation:** Do not output Unicode em dash (U+2014); use commas, colons, parentheses, or ASCII hyphen in everything you add to the plan or suggest for publish.
- **Prose:** Self-check customer-facing strings with `/avoid-ai-writing` before saving.

Write-back (required):
1. Edit `SEO-INTENT-ONPAGE-PLAN.md` **§16 B2** table `Intent / theme` \| `Primary URL` \| `Competing URLs` \| `Action` - one row (or update) per **(batch path vs Comparison anchor)** pair as needed.
2. Touch **§13.1** only if you add short cross-reference notes.
3. Edit `SEO-PROGRESS-MATRIX.md` per **Matrix write-back** for **P4 Step F**: column **F** for **each** path in **Batch paths** and for **Comparison anchor** if it has a matrix row; **Section 4** B2 if intent map updated.

Task:
For **each** path in **Batch paths** vs **Comparison anchor**:
1. Overlap verdict (safe | risky | consolidate).
2. If risky: which URL should own which primary; what to change in H1/title focus on the weaker page.
3. Internal link instruction (who links to whom, anchor guidance).

Save `SEO-INTENT-ONPAGE-PLAN.md` and `SEO-PROGRESS-MATRIX.md` after completing **Write-back** above. No PHP edits unless I request apply.
```

**Step G - Publish verify**

```text
Context for this session:
- Source of truth: SEO-INTENT-ONPAGE-PLAN.md (this repo, restwell-theme).
- Business: Accessible self-catering holiday accommodation, Whitstable area, Kent, UK.
- Audience: Disabled people and families, carers, commissioners, funding-aware bookers.
- Current phase: Foundation - post-publish verification. [Editor note: change if not default, then delete this note.]
- Batch paths (this run) — replace with your list (1–8 paths) after WP save:
  - /faq/
  - /guest-guide/
- Goal for this turn: Post-publish verification checklist and **log completion** in `SEO-INTENT-ONPAGE-PLAN.md` **§13.1** `Published / verified` for **each path** in **Batch paths**, plus dated lines under **§11.6** per path if relevant - Write-back **P4 Step G**. No PHP.

Constraints:
- WordPress theme only; follow .cursorrules.
- **Facts:** No invented property or equipment scope; use repo files or editor-pasted text only. If unsure, write `Confirm in WP: …` (example: do not claim hoist coverage beyond what the source states).
- **Banned phrase:** Never use `fully accessible` anywhere (titles, meta, body, FAQs).
- **Punctuation:** Do not output Unicode em dash (U+2014); use commas, colons, parentheses, or ASCII hyphen in everything you add to the plan or suggest for publish.
- **Prose:** Self-check customer-facing strings with `/avoid-ai-writing` before saving.

Write-back (required):
1. Edit `SEO-INTENT-ONPAGE-PLAN.md` **§13.1** for **each** path in **Batch paths**: `Published / verified` = date + checklist OK / pending items.
2. Under **§11.6**, append `#### Verify - YYYY-MM-DD - <path>` per path with bullets: view-source OK, mobile SERP note, GSC follow-up reminder.
3. Edit `SEO-PROGRESS-MATRIX.md` per **Matrix write-back** for **P4 Step G**: column **G** for **each** Path row; **Meta**.

Task:
Give a post-publish verification checklist for **each path** in **Batch paths** after WP save.

Include: view-source checks (title, meta, og:title/description), one mobile SERP preview sanity check, what to log in §11 / worksheet.

Save both markdown files (`SEO-INTENT-ONPAGE-PLAN.md` and `SEO-PROGRESS-MATRIX.md`).
```

#### P4 - Per-URL preset catalog (full site coverage)

Use this catalog with **P4 Step A through G** above. **P4 is batch-paths only:** list paths under **Batch paths** in the step block (one URL = one line). Use the **Master table** below for Path, Theme file, Page type, and Default focus per line. Optional: paste one **Preset pack** block from this section into your message if you want extra URL-specific narrative for a small batch; not required when the table is enough. Run **P2** first when the keyword row or SERP set is stale. After each step, update **[SEO-PROGRESS-MATRIX.md](SEO-PROGRESS-MATRIX.md)** per **Matrix write-back** in the main plan.

**Origin placeholder:** Replace `https://restwellretreats.co.uk` with your live site origin if it differs (staging, alternate domain).

**Surfaces outside this catalog:** WordPress **single posts** under `/blog/...` use `single.php`: add each post slug under **Batch paths** for the step you are running (batch of one or many). **Search** `/?s=` and **404** are thin SEO surfaces; optional P4 only if you add meaningful copy.

##### Master table (paths, templates, default focus keyphrases)


| Path                                               | Theme file (primary)                        | Page type               | Intent (one line)                                                            | Default focus (from `inc/seo-content-seed.php`; confirm in WP) |
| -------------------------------------------------- | ------------------------------------------- | ----------------------- | ---------------------------------------------------------------------------- | -------------------------------------------------------------- |
| `/`                                                | `front-page.php`                            | Home / brand + booking  | Win branded Whitstable accessible stay queries without over-claiming kit.    | accessible holidays whitstable                                 |
| `/the-property/`                                   | `template-property.php`                     | Commercial PDP-style    | Prove layout, kit, and booking path for adapted bungalow intent.             | adapted bungalow whitstable                                    |
| `/accessibility/`                                  | `template-accessibility.php`                | Trust / spec hub        | Answer access-statement and equipment questions with measurable language.    | wheelchair accessible holiday cottage                          |
| `/enquire/`                                        | `template-enquire.php`                      | Conversion / contact    | Capture enquiries; clarify response time and what to send for access checks. | contact restwell                                               |
| `/contact/`                                        | `template-contact.php`                      | Contact / reassurance   | Phone, email, post; professional referral lane without inventing policy.     | (set in WP; suggest `contact restwell`)                        |
| `/resources/`                                      | `template-resources.php`                    | Funding hub / pillar    | Route funding questions to the right guides; keep hub scannable.             | holiday care funding kent                                      |
| `/how-it-works/`                                   | `template-how-it-works.php`                 | Journey explainer       | De-risk booking steps, care option, and cancellation realism.                | accessible stay                                                |
| `/who-its-for/`                                    | `template-who-its-for.php`                  | Audience fit            | Match guest types to suitability and hand off to funding or property pages.  | accessible stay suitability                                    |
| `/whitstable-area-guide/`                          | `template-whitstable-guide.php`             | Local pillar            | Own Whitstable coast planning without fabricating venue access.              | whitstable kent coast                                          |
| `/faq/`                                            | `template-faq.php`                          | FAQ / support           | Pre-empt booking and access objections; keep answers short.                  | restwell booking questions                                     |
| `/blog/`                                           | `index.php` (posts index; Reading settings) | Blog hub                | Segment topics; point to money pages with varied anchors.                    | accessible travel                                              |
| `/guest-guide/`                                    | `page-guest-guide.php`                      | Gated guest utility     | Post-booking clarity; minimal SEO pressure unless you open it up.            | restwell guest guide                                           |
| `/accessible-beaches-coastal-walks-kent/`          | `page.php` (seeded guide)                   | Local long-tail         | Beach day realism for Kent; cite changing facilities honestly.               | accessible beaches kent                                        |
| `/direct-payment-holiday-accommodation/`           | `page.php` (seeded guide)                   | Funding long-tail       | Split care vs accommodation wording; YMYL-adjacent care.                     | direct payment for holiday                                     |
| `/revitalise-alternatives-accessible-holidays/`    | `page.php` (seeded guide)                   | News / competitor pivot | Explain Revitalise change factually; own alternative positioning calmly.     | revitalise                                                     |
| `/how-to-choose-accessible-self-catering-holiday/` | `page.php` (seeded guide)                   | Decision guide          | Checklist framing; link to access statement and property specs.              | accessible self-catering holiday                               |
| `/carers-respite-holiday-guide/`                   | `page.php` (seeded guide)                   | Carer rights            | Legal tone without giving legal advice; routes to respite.                   | carer assessment respite rights                                |
| `/what-to-pack-accessible-self-catering-uk/`       | `page.php` (seeded guide)                   | Practical packing       | Reduce anxiety; tie kit list to hoist and wet room reality.                  | accessible holiday packing list uk                             |
| `/accessible-parking-whitstable-tankerton/`        | `page.php` (seeded guide)                   | Local logistics         | Parking and drop-off realism; seasonal crowding.                             | accessible parking whitstable                                  |
| `/chc-respite-holiday-accommodation-uk/`           | `page.php` (seeded guide)                   | NHS funding             | CHC vs lodging clarity; panel paperwork angle.                               | chc respite holiday accommodation                              |
| `/hire-mobility-scooter-equipment-uk-holiday/`     | `page.php` (seeded guide)                   | Equipment hire          | Hire handover checklist; insurance prompts.                                  | hire mobility equipment uk holiday                             |
| `/accessible-train-travel-whitstable-kent/`        | `page.php` (seeded guide)                   | Transport               | Passenger Assist, gaps, backup plans.                                        | accessible train travel whitstable                             |
| `/travel-insurance-disability-uk-self-catering/`   | `page.php` (seeded guide)                   | Insurance YMYL          | Questions for brokers; no product picks unless editor supplies.              | travel insurance disability uk self catering                   |
| `/commissioner-checklist-accessible-respite-stay/` | `page.php` (seeded guide)                   | Commissioner            | Audit-ready checklist tone; link to property and access pages.               | commissioner accessible respite stay                           |
| `/personal-budget-short-break-care-act/`           | `page.php` (seeded guide)                   | Care Act budgets        | Receipts and splits; defer to LA wording where needed.                       | personal budget short break care act                           |
| `/accessible-eating-out-whitstable-kent/`          | `page.php` (seeded guide)                   | Local dining access     | Step-free and toilet route realism; avoid stale venue claims.                | accessible eating out whitstable                               |
| `/changing-places-toilets-kent-coast-days-out/`    | `page.php` (seeded guide)                   | CP / toilets            | Define CP vs standard; map day-out stops without inventing hours.            | changing places toilets kent coast                             |
| `/quieter-times-whitstable-low-crowd-access/`      | `page.php` (seeded guide)                   | Timing / sensory        | Crowd and tide patterns; fatigue-friendly pacing.                            | quieter times whitstable visit                                 |
| `/holiday-backup-plan-care-worker-change/`         | `page.php` (seeded guide)                   | Contingency             | Backup plans for care disruption; calm operational tone.                     | holiday backup plan care worker                                |
| `/how-to-read-holiday-cottage-access-statement/`   | `page.php` (seeded guide)                   | Education               | Decode listings; hoist proof questions for OTs.                              | holiday cottage access statement                               |
| `/fatigue-friendly-whitstable-coastal-day/`        | `page.php` (seeded guide)                   | Pacing                  | Low-energy coastal day structure.                                            | fatigue friendly whitstable coastal day                        |
| `/privacy-policy/`                                 | `template-privacy-policy.php`               | Legal                   | Data collection, cookies, retention; no marketing fluff.                     | restwell privacy                                               |
| `/terms-and-conditions/`                           | `template-terms-and-conditions.php`         | Legal                   | Deposits, cancellations, guest duties; align with live PDF or page.          | restwell terms                                                 |
| `/accessibility-policy/`                           | `template-accessibility-policy.php`         | Site a11y statement     | WCAG approach for the **website**, not the cottage.                          | restwell website accessibility                                 |


##### Preset pack blocks (copy into P4 Step A context, then repeat in B-G)

###### Home `/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/
- Template / source file: front-page.php (front page template)
- Page type: Home - brand plus booking entry
- Goal for this URL: Rank for Whitstable accessible self-catering intent while keeping equipment claims tied to verified copy only.
```

###### The property `/the-property/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/the-property/
- Template / source file: template-property.php
- Page type: Commercial property detail
- Goal for this URL: Convert adapted-bungalow and hoist-led queries with specs readers can verify before deposit.
```

###### Accessibility `/accessibility/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/accessibility/
- Template / source file: template-accessibility.php
- Page type: Access statement hub
- Goal for this URL: Own wheelchair accessible cottage queries with measurable language and downloads, no scope creep beyond source material.
```

###### Enquire `/enquire/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/enquire/
- Template / source file: template-enquire.php
- Page type: Lead form surface
- Goal for this URL: Maximize completed enquiries with clear timelines, required info for access checks, and honest limits.
```

###### Contact `/contact/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/contact/
- Template / source file: template-contact.php
- Page type: Contact and reassurance
- Goal for this URL: Make phone, email, and post routes obvious; separate guest vs professional paths without inventing SLA beyond theme defaults.
```

###### Resources hub `/resources/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/resources/
- Template / source file: template-resources.php
- Page type: Funding and guide hub
- Goal for this URL: Route funding intents to the correct long-tail guides with varied internal anchors and scannable sections.
```

###### How it works `/how-it-works/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/how-it-works/
- Template / source file: template-how-it-works.php
- Page type: Booking journey explainer
- Goal for this URL: Reduce pre-booking anxiety with ordered steps, care option clarity, and cancellation realism.
```

###### Who it is for `/who-its-for/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/who-its-for/
- Template / source file: template-who-its-for.php
- Page type: Audience fit and referrals
- Goal for this URL: Help commissioners, families, and carers self-select fit and jump to funding or property proof.
```

###### Whitstable area guide `/whitstable-area-guide/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/whitstable-area-guide/
- Template / source file: template-whitstable-guide.php
- Page type: Local pillar
- Goal for this URL: Capture coast planning queries while avoiding stale or invented venue access claims.
```

###### FAQ `/faq/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/faq/
- Template / source file: template-faq.php
- Page type: FAQ support
- Goal for this URL: Answer high-friction booking questions succinctly and align FAQ schema with on-page wording.
```

###### Blog index `/blog/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/blog/
- Template / source file: index.php (posts index; confirm Posts page in WP Reading settings)
- Page type: Content hub
- Goal for this URL: Organize clusters, surface pillar internal links, and keep hub intro distinct from home.
```

###### Guest guide `/guest-guide/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/guest-guide/
- Template / source file: page-guest-guide.php (OTP gated)
- Page type: Post-booking utility
- Goal for this URL: Keep guest logistics accurate; treat SEO as secondary unless the page is opened to crawlers.
```

###### Accessible beaches Kent `/accessible-beaches-coastal-walks-kent/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/accessible-beaches-coastal-walks-kent/
- Template / source file: page.php (seeded long-form in WP)
- Page type: Local long-tail guide
- Goal for this URL: Win accessible beaches Kent intent with realistic access notes and external citations where required.
```

###### Direct payment holiday `/direct-payment-holiday-accommodation/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/direct-payment-holiday-accommodation/
- Template / source file: page.php (seeded long-form in WP)
- Page type: Funding guide
- Goal for this URL: Clarify direct payment for holiday stays vs care spend without giving personalised financial advice.
```

###### Revitalise alternatives `/revitalise-alternatives-accessible-holidays/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/revitalise-alternatives-accessible-holidays/
- Template / source file: page.php (seeded long-form in WP)
- Page type: Competitor or news pivot
- Goal for this URL: Explain Revitalise centre changes factually and position Restwell as one calm alternative, not a pile-on.
```

###### Choose accessible self-catering `/how-to-choose-accessible-self-catering-holiday/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/how-to-choose-accessible-self-catering-holiday/
- Template / source file: page.php (seeded long-form in WP)
- Page type: Decision checklist
- Goal for this URL: Give a verifier checklist (hoist, doors, wet room) that points back to property and access pages.
```

###### Carers respite guide `/carers-respite-holiday-guide/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/carers-respite-holiday-guide/
- Template / source file: page.php (seeded long-form in WP)
- Page type: Carer support guide
- Goal for this URL: Cover carer assessment and respite rights at a high level and link to funding hub pages.
```

###### Packing list UK `/what-to-pack-accessible-self-catering-uk/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/what-to-pack-accessible-self-catering-uk/
- Template / source file: page.php (seeded long-form in WP)
- Page type: Practical checklist
- Goal for this URL: Reduce travel anxiety with hoist-adjacent packing prompts tied to real equipment categories only.
```

###### Accessible parking Whitstable `/accessible-parking-whitstable-tankerton/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/accessible-parking-whitstable-tankerton/
- Template / source file: page.php (seeded long-form in WP)
- Page type: Local logistics
- Goal for this URL: Answer Blue Badge and drop-off queries with seasonal crowding honesty.
```

###### CHC respite UK `/chc-respite-holiday-accommodation-uk/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/chc-respite-holiday-accommodation-uk/
- Template / source file: page.php (seeded long-form in WP)
- Page type: NHS funding explainer
- Goal for this URL: Explain CHC respite holiday accommodation framing for panels without inventing eligibility outcomes.
```

###### Hire mobility equipment `/hire-mobility-scooter-equipment-uk-holiday/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/hire-mobility-scooter-equipment-uk-holiday/
- Template / source file: page.php (seeded long-form in WP)
- Page type: Equipment hire guide
- Goal for this URL: Cover measurements, insurance, and handover photos; no supplier claims without editor evidence.
```

###### Accessible train travel `/accessible-train-travel-whitstable-kent/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/accessible-train-travel-whitstable-kent/
- Template / source file: page.php (seeded long-form in WP)
- Page type: Transport guide
- Goal for this URL: Passenger Assist and connection realism for Whitstable access by rail.
```

###### Travel insurance disability `/travel-insurance-disability-uk-self-catering/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/travel-insurance-disability-uk-self-catering/
- Template / source file: page.php (seeded long-form in WP)
- Page type: Insurance YMYL
- Goal for this URL: List broker questions and coverage angles; do not recommend specific products unless editor supplies.
```

###### Commissioner checklist `/commissioner-checklist-accessible-respite-stay/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/commissioner-checklist-accessible-respite-stay/
- Template / source file: page.php (seeded long-form in WP)
- Page type: Commissioner audit aid
- Goal for this URL: Provide checklist framing for accessible respite stays with links to proof pages, not invented certificates.
```

###### Personal budget short break `/personal-budget-short-break-care-act/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/personal-budget-short-break-care-act/
- Template / source file: page.php (seeded long-form in WP)
- Page type: Care Act budgets
- Goal for this URL: Explain personal budget short break splits under the Care Act with receipt discipline language.
```

###### Accessible eating out `/accessible-eating-out-whitstable-kent/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/accessible-eating-out-whitstable-kent/
- Template / source file: page.php (seeded long-form in WP)
- Page type: Local dining access
- Goal for this URL: Cover step-free and toilet-route thinking for Whitstable without dated venue specifics unless verified.
```

###### Changing Places Kent coast `/changing-places-toilets-kent-coast-days-out/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/changing-places-toilets-kent-coast-days-out/
- Template / source file: page.php (seeded long-form in WP)
- Page type: Toilet infrastructure guide
- Goal for this URL: Differentiate Changing Places from standard accessible loos and map day-out stops cautiously.
```

###### Quieter times Whitstable `/quieter-times-whitstable-low-crowd-access/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/quieter-times-whitstable-low-crowd-access/
- Template / source file: page.php (seeded long-form in WP)
- Page type: Timing and sensory
- Goal for this URL: Give low-crowd and fatigue-friendly visit timing without guaranteeing quiet.
```

###### Holiday backup plan `/holiday-backup-plan-care-worker-change/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/holiday-backup-plan-care-worker-change/
- Template / source file: page.php (seeded long-form in WP)
- Page type: Contingency planning
- Goal for this URL: Help families plan holiday backup plans when care workers change, with escalation realism.
```

###### Read access statement `/how-to-read-holiday-cottage-access-statement/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/how-to-read-holiday-cottage-access-statement/
- Template / source file: page.php (seeded long-form in WP)
- Page type: Education for OTs and families
- Goal for this URL: Teach how to read holiday cottage access statements and which measurements to insist on.
```

###### Fatigue-friendly coastal day `/fatigue-friendly-whitstable-coastal-day/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/fatigue-friendly-whitstable-coastal-day/
- Template / source file: page.php (seeded long-form in WP)
- Page type: Pacing guide
- Goal for this URL: Structure a low-energy Whitstable coastal day with sensory load awareness.
```

###### Privacy policy `/privacy-policy/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/privacy-policy/
- Template / source file: template-privacy-policy.php
- Page type: Legal policy / privacy notice
- Goal for this URL: Explain what personal data Restwell collects, why it is used, cookie handling, retention, sharing, and UK GDPR rights in plain English.
```

###### Terms and conditions `/terms-and-conditions/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/terms-and-conditions/
- Template / source file: template-terms-and-conditions.php
- Page type: Legal policy
- Goal for this URL: Align booking, deposit, and cancellation language with the live legal text editors maintain.
```

###### Website accessibility statement `/accessibility-policy/`

```text
- Active URL or pillar: https://restwellretreats.co.uk/accessibility-policy/
- Template / source file: template-accessibility-policy.php
- Page type: Site accessibility statement (web only)
- Goal for this URL: Describe WCAG-oriented site testing and feedback routes without conflating with cottage access.
```

---

#### P5 - Voice pass (`/content-creator`)

```text
Context for this session:
- Source of truth: SEO-INTENT-ONPAGE-PLAN.md (this repo, restwell-theme).
- Business: Accessible self-catering holiday accommodation, Whitstable area, Kent, UK.
- Audience: Disabled people and families, carers, commissioners, funding-aware bookers.
- Current phase: Foundation - editorial voice pass. [Editor note: change this line if not default, then delete this note.]
- Active URL or pillar: Paste-driven (draft goes under the dashed Editor line in this block). [Editor note: add a short label for the log if you want, then delete this note.]
- Goal for this turn: Run a calm, precise, non-alarmist Restwell voice pass on the pasted draft - then **append editor bullets + short “after” summary** to `SEO-INTENT-ONPAGE-PLAN.md` **§13.1** `Body / links notes` (or `#### Agent voice run - YYYY-MM-DD` under **§5**) - Write-back **P5**. Do not paste the full long draft into the plan.

Constraints:
- WordPress theme only; follow .cursorrules.
- **Facts:** No invented property or equipment scope; use repo files or editor-pasted text only. If unsure, write `Confirm in WP: …` (example: do not claim hoist coverage beyond what the source states).
- **Banned phrase:** Never use `fully accessible` anywhere (titles, meta, body, FAQs).
- **Punctuation:** Do not output Unicode em dash (U+2014); use commas, colons, parentheses, or ASCII hyphen in everything you add to the plan or suggest for publish.
- **Prose:** Self-check customer-facing strings with `/avoid-ai-writing` before saving.

Write-back (required):
1. Edit `SEO-INTENT-ONPAGE-PLAN.md`: log **3 editor notes** + **1–2 sentence summary of changes** tied to the URL (§13.1 or §5 voice run heading).
2. Put the **full edited draft** in chat for copy into WP.
3. Edit `SEO-PROGRESS-MATRIX.md` per **Matrix write-back** for **P5**.

Task:
Voice and clarity pass for Restwell.

Tasks:
1. Flag any unverifiable medical/legal/funding claims.
2. Tighten redundancy; keep UK spelling.
3. Return edited paragraph(s) in chat, then save **both** `SEO-INTENT-ONPAGE-PLAN.md` and `SEO-PROGRESS-MATRIX.md` (Write-back step 3 already updates the matrix).

Per SEO-INTENT-ONPAGE-PLAN.md §5: if tone conflicts with caution, caution wins.

--- Editor: paste the draft you want edited below (you may delete this whole line after pasting) ---
```

---

#### P6 - AI extractability (`/ai-seo`)

```text
Context for this session:
- Source of truth: SEO-INTENT-ONPAGE-PLAN.md (this repo, restwell-theme).
- Business: Accessible self-catering holiday accommodation, Whitstable area, Kent, UK.
- Audience: Disabled people and families, carers, commissioners, funding-aware bookers.
- Current phase: Foundation - AI extractability audit. [Editor note: change this line if not default, then delete this note.]
- Active URL or pillar: /accessibility/ (read from theme templates). [Editor note: change this line if not default, then delete this note.]
- Goal for this turn: Audit this URL against §6.1 extractability - then **append the pass/fail table to** `SEO-INTENT-ONPAGE-PLAN.md` **§6.3** - Write-back **P6**. Theme PHP only if I say “apply fixes”.

Constraints:
- WordPress theme only; follow .cursorrules.
- **Facts:** No invented property or equipment scope; use repo files or editor-pasted text only. If unsure, write `Confirm in WP: …` (example: do not claim hoist coverage beyond what the source states).
- **Banned phrase:** Never use `fully accessible` anywhere (titles, meta, body, FAQs).
- **Punctuation:** Do not output Unicode em dash (U+2014); use commas, colons, parentheses, or ASCII hyphen in everything you add to the plan or suggest for publish.
- **Prose:** Self-check customer-facing strings with `/avoid-ai-writing` before saving.

Write-back (required):
1. Edit `SEO-INTENT-ONPAGE-PLAN.md` **§6.3**: append `#### Extractability - YYYY-MM-DD - <URL>` with table: Check (from §6.1) \| Pass/Fail \| Fix \| Notes.
2. Add two **AI Overview test queries** as bullets under that heading.
3. Edit `SEO-PROGRESS-MATRIX.md` per **Matrix write-back** for **P6**.

Task:
Audit extractability for this URL against SEO-INTENT-ONPAGE-PLAN.md §6.1 table.

Save both markdown files. Theme edits only if I say "apply fixes".
```

---

#### P7 - GEO / technical AI (`/seo-geo`)

```text
Context for this session:
- Source of truth: SEO-INTENT-ONPAGE-PLAN.md (this repo, restwell-theme).
- Business: Accessible self-catering holiday accommodation, Whitstable area, Kent, UK.
- Audience: Disabled people and families, carers, commissioners, funding-aware bookers.
- Current phase: Foundation - GEO & AI-surface sanity check. [Editor note: change this line if not default, then delete this note.]
- Active URL or pillar: Public marketing templates + inc/seo*.php (read-only pass). [Editor note: change this line if not default, then delete this note.]
- Goal for this turn: List GEO/AI crawler risks with severity and paths - then **append to** `SEO-INTENT-ONPAGE-PLAN.md` **§7.1** - Write-back **P7**. Apply PHP only if I say “apply”.

Constraints:
- WordPress theme only; follow .cursorrules.
- **Facts:** No invented property or equipment scope; use repo files or editor-pasted text only. If unsure, write `Confirm in WP: …` (example: do not claim hoist coverage beyond what the source states).
- **Banned phrase:** Never use `fully accessible` anywhere (titles, meta, body, FAQs).
- **Punctuation:** Do not output Unicode em dash (U+2014); use commas, colons, parentheses, or ASCII hyphen in everything you add to the plan or suggest for publish.
- **Prose:** Self-check customer-facing strings with `/avoid-ai-writing` before saving.

Write-back (required):
1. Edit `SEO-INTENT-ONPAGE-PLAN.md` **§7.1**: append `#### GEO run - YYYY-MM-DD` with bullets `H/M/L: finding; path`.
2. Edit `SEO-PROGRESS-MATRIX.md` per **Matrix write-back** for **P7**.

Task:
GEO + AI crawler sanity check for this WordPress theme (read-only unless I say apply).

Scope: public marketing URLs only; note llms.txt, schema duplication risk, SSR vs client-only content for core SEO text.

Reference SEO-INTENT-ONPAGE-PLAN.md §7. List findings severity (high/med/low) and file paths.

Save `SEO-INTENT-ONPAGE-PLAN.md` and `SEO-PROGRESS-MATRIX.md` after completing **Write-back** above.
```

---

#### P8 - Competitor / alternatives page (`/seo-competitor-pages`)

```text
Context for this session:
- Source of truth: SEO-INTENT-ONPAGE-PLAN.md (this repo, restwell-theme).
- Business: Accessible self-catering holiday accommodation, Whitstable area, Kent, UK.
- Audience: Disabled people and families, carers, commissioners, funding-aware bookers.
- Current phase: Foundation - comparison / alternatives page angle. [Editor note: change this line if not default, then delete this note.]
- Active URL or pillar: /revitalise-alternatives-accessible-holidays/ (or your live “vs / alternatives” URL). [Editor note: set the real URL, then delete this note.]
- Goal for this turn: Produce defensible comparison positioning - then **append to** `SEO-INTENT-ONPAGE-PLAN.md` **§8.1** - Write-back **P8**. Template PHP only if I ask.

Constraints:
- WordPress theme only; follow .cursorrules.
- **Facts:** No invented property or equipment scope; use repo files or editor-pasted text only. If unsure, write `Confirm in WP: …` (example: do not claim hoist coverage beyond what the source states).
- **Banned phrase:** Never use `fully accessible` anywhere (titles, meta, body, FAQs).
- **Punctuation:** Do not output Unicode em dash (U+2014); use commas, colons, parentheses, or ASCII hyphen in everything you add to the plan or suggest for publish.
- **Prose:** Self-check customer-facing strings with `/avoid-ai-writing` before saving.

Write-back (required):
1. Edit `SEO-INTENT-ONPAGE-PLAN.md` **§8.1**: append `#### Comparison run - YYYY-MM-DD - <URL>` with H1, H2s, table plan, FAQs.
2. Edit `SEO-PROGRESS-MATRIX.md` per **Matrix write-back** for **P8**.

Task:
Improve the comparison/alternatives angle for the URL above.

Optional context (paste SERP or competitor names under line if helpful):
--- Editor (optional): paste competitor names or SERP notes below ---

Deliver:
1. H1 angle + 3 H2s that are defensible (facts, not attacks).
2. Comparison table outline (us vs generic OTA vs charity/respite) with neutral wording.
3. FAQ questions (AEO) that reduce legal/reputational risk.

Save `SEO-INTENT-ONPAGE-PLAN.md` and `SEO-PROGRESS-MATRIX.md` after completing **Write-back** above.
```

---

#### P9 - Live SEO data (optional - `/seo-dataforseo`)

```text
Context for this session:
- Source of truth: SEO-INTENT-ONPAGE-PLAN.md (this repo, restwell-theme).
- Business: Accessible self-catering holiday accommodation, Whitstable area, Kent, UK.
- Audience: Disabled people and families, carers, commissioners, funding-aware bookers.
- Current phase: Foundation - live keyword metrics pass. [Editor note: change this line if not default, then delete this note.]
- Active URL or pillar: Keyword batch from §2.1 (below). [Editor note: if you replace the keyword list in Task, align this line, then delete this note.]
- Goal for this turn: Produce keyword metrics table (or manual SERP steps if no API) - then **append to** `SEO-INTENT-ONPAGE-PLAN.md` **§9.1** - Write-back **P9**.

Constraints:
- WordPress theme only; follow .cursorrules.
- **Facts:** No invented property or equipment scope; use repo files or editor-pasted text only. If unsure, write `Confirm in WP: …` (example: do not claim hoist coverage beyond what the source states).
- **Banned phrase:** Never use `fully accessible` anywhere (titles, meta, body, FAQs).
- **Punctuation:** Do not output Unicode em dash (U+2014); use commas, colons, parentheses, or ASCII hyphen in everything you add to the plan or suggest for publish.
- **Prose:** Self-check customer-facing strings with `/avoid-ai-writing` before saving.

Write-back (required):
1. Edit `SEO-INTENT-ONPAGE-PLAN.md` **§9.1**: append `#### Metrics - YYYY-MM-DD` with the results table or manual check steps.
2. Edit `SEO-PROGRESS-MATRIX.md` per **Matrix write-back** for **P9**.

Task:
For this keyword list (comma-separated), return: keyword | volume est | difficulty est | intent | recommended tier | note.

Keywords:
accessible self catering Kent, accessible holiday cottage Whitstable, direct payment holiday accommodation, NHS continuing healthcare holiday respite, hoist tracking wet room accessible cottage, wheelchair accessible holiday let Kent, carer respite break self catering UK

If no live API available, say so and give **manual SERP check steps** (incognito, UK locale, mobile + desktop) - still append those steps under §9.1.

Save `SEO-INTENT-ONPAGE-PLAN.md` and `SEO-PROGRESS-MATRIX.md` after completing **Write-back** above.
```

---

#### P10 - Measurement / growth check (`/growth-engine` + §11)

```text
Context for this session:
- Source of truth: SEO-INTENT-ONPAGE-PLAN.md (this repo, restwell-theme).
- Business: Accessible self-catering holiday accommodation, Whitstable area, Kent, UK.
- Audience: Disabled people and families, carers, commissioners, funding-aware bookers.
- Current phase: Monthly - organic performance check-in. [Editor note: add month or quarter label if useful, then delete this note.]
- Active URL or pillar: Google Search Console top queries or pages (optional). [Editor note: paste a small export under the dashed Editor line at the end if you have one, then delete this note.]
- Goal for this turn: Summarize organic performance and next experiments - then **append to** `SEO-INTENT-ONPAGE-PLAN.md` **§11.6** and update **§1.2** / **§11.2** cells when new numbers exist - Write-back **P10**.

Constraints:
- WordPress theme only; follow .cursorrules.
- **Facts:** No invented property or equipment scope; use repo files or editor-pasted text only. If unsure, write `Confirm in WP: …` (example: do not claim hoist coverage beyond what the source states).
- **Banned phrase:** Never use `fully accessible` anywhere (titles, meta, body, FAQs).
- **Punctuation:** Do not output Unicode em dash (U+2014); use commas, colons, parentheses, or ASCII hyphen in everything you add to the plan or suggest for publish.
- **Prose:** Self-check customer-facing strings with `/avoid-ai-writing` before saving.

Write-back (required):
1. Edit `SEO-INTENT-ONPAGE-PLAN.md` **§11.6**: append `#### Measurement - YYYY-MM-DD` with five bullets, one experiment, KPI notes.
2. If the prompt includes GSC rows, add a **small markdown table** under that heading (top queries or pages only).
3. Update **§1.2** and/or **§11.2** numeric cells when you have new figures; otherwise leave unchanged.
4. Edit `SEO-PROGRESS-MATRIX.md` per **Matrix write-back** for **P10**.

Task:
Monthly organic check-in for Restwell using SEO-INTENT-ONPAGE-PLAN.md §10–§11.

Tasks:
1. 5 bullets: trends, surprises, pages to fix first (if no paste: say what to pull from GSC UI and still log that in §11.6).
2. Suggest one **experiment** (title test, new FAQ, internal link) for the top underperforming URL.
3. What to add next month to §1.2 KPI table.

Save `SEO-INTENT-ONPAGE-PLAN.md` and `SEO-PROGRESS-MATRIX.md` after completing **Write-back** above.

--- Editor (optional): paste GSC Queries or Pages export (about 15 rows) below ---
```

---

## 0. Context budget (`/context-optimization`)

**Objective:** Keep agent sessions effective - high signal, low noise.

**Stable prefix (paste first every session):**

1. Link or paste **this file** (`SEO-INTENT-ONPAGE-PLAN.md`).
2. Link or paste **[SEO-PROGRESS-MATRIX.md](SEO-PROGRESS-MATRIX.md)** when reporting status or updating progress.
3. One sentence: **business** (accessible self-catering, Whitstable, UK).
4. **Current phase** (e.g. “Week 1 P1 URLs only”).
5. **URL + goal** (e.g. `/accessibility/` - improve CTR).

**What to paste per task:**


| Task                    | Paste                                                                                                                                                                                                                                              |
| ----------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Keyword strategist      | Hero + **first ~400 words** + H2 list (not whole theme file tree).                                                                                                                                                                                 |
| Meta optimizer          | Primary + 3 secondary keywords + 2 USPs + character limits.                                                                                                                                                                                        |
| Cluster / research (P2) | Pillar URL + **3–5 seed terms** + audience. For **§2.0** depth, run P2 in a session where the agent can open **google.co.uk** SERPs and/or `**/seo-dataforseo`** (or paste a tiny SERP note export under `--- Editor:` if you already ran checks). |
| Snippet hunter          | Section heading + rough answer draft OR competitor snippet example.                                                                                                                                                                                |


**Do not paste:** Entire `front-page.php`, whole `seo.php`, or duplicate baseline tables every turn - **point to repo paths** instead.

**Compaction rule:** If context > ~70% full, replace old tool dumps with “Summary: …” bullet lines and keep only the active URL’s worksheet row.

**Cursor prompts:** Ready-made **single-paste** blocks live under **§How to run this in Cursor → Copy-paste prompts** (**P1–P10**). Each run **updates this file** (see **Write findings into this plan**). Paste **only** the block for your phase (e.g. **P2** for §2 research). Read **What is for you vs for the AI** there first: remove `**[Editor note: …]`** segments before sending (they are reminders for you, not instructions to the model), and add content under `**--- Editor:**` lines when a step needs a paste. Those blocks also embed **Global fact and style constraints** (no invented facts, no `fully accessible`, no em dash in outputs, `/avoid-ai-writing` pass).

---

## 1. Strategic frame (`/seo-plan`)

### 1.1 Discovery (Restwell - fixed context)


| Field         | Value                                                                                                        |
| ------------- | ------------------------------------------------------------------------------------------------------------ |
| Business      | Accessible holiday accommodation (self-catering), Whitstable area, Kent                                      |
| Audience      | Disabled people & families, carers, commissioners, funding-aware bookers                                     |
| Competitors   | Generic OTAs, other accessible stays, charity/respite providers (benchmark SERPs manually or via DataForSEO) |
| Site maturity | New domain - **Pages** report > **Queries**; research-led optimization                                       |


### 1.2 KPI table (fill as data arrives)


| Metric                           | Baseline                                                                                            | 3 mo | 6 mo | 12 mo |
| -------------------------------- | --------------------------------------------------------------------------------------------------- | ---- | ---- | ----- |
| Organic clicks (GSC)             | **§11.2** snapshot **2026-05-10**: 10 clicks (all on `/`); 53 impressions summed across listed URLs | TBD  | TBD  | TBD   |
| Indexed key URLs                 | TBD                                                                                                 | TBD  | TBD  | TBD   |
| Enquiry conversions (GA4)        | TBD                                                                                                 | TBD  | TBD  | TBD   |
| AI citation spot-checks (manual) | TBD                                                                                                 | TBD  | TBD  | TBD   |


### 1.3 Implementation phases (aligned to this doc)


| Phase          | Weeks   | Focus                                                                 |
| -------------- | ------- | --------------------------------------------------------------------- |
| **Foundation** | 1–4     | P1–P2 URLs: titles, meta, H1, internal links, snippet blocks          |
| **Expansion**  | 5–12    | Cluster Priority 1 articles live; pillar refreshed; link map enforced |
| **Scale**      | 13–24   | Priority 2–3 cluster; GEO/AI audits on top pages                      |
| **Authority**  | 7–12 mo | E-E-A-T refreshes, PR/mentions (**§16 B5**), comparison pages updated |


#### Agent strategic run - 2026-05-10

**(a) Positioning one-liner**

Accessible self-catering breaks near Whitstable, Kent, built around plain-spoken accessibility detail for disabled guests, families, carers, and commissioners who need funding-aware, inspectable booking paths.

**(b) Five 90-day organic priorities (aligned to §1.3 Foundation → early Expansion)**

1. **Foundation (Weeks 1–4):** Ship titles, meta, H1s, internal links, and snippet-ready blocks on **P1–P2 URLs** per this doc, prioritising URLs that already earn impressions in **§11.2** (`/accessibility/`, `/enquire/`, then `/the-property/`).
2. **Funding hub discipline:** Keep CHC, NHS-adjacent, and direct payment angles on **one authoritative guide per angle** under `/resources/` (or the agreed single URL); avoid thin duplicates. Use cautious wording and official citations where facts matter (**Confirm in WP:** any eligibility examples).
3. **Specs credibility:** State hoist, wet room, and layout facts only as they appear in WP or repo-backed copy; where detail is missing for commissioners, use **Confirm in WP:** instead of stretching claims.
4. **Expansion entry (Weeks 5–12):** When **§2.6** research is locked, publish **Tier 1 / cluster Priority 1** articles with **one primary keyword each**, then enforce the internal link map (**§16 B2**) so county vs Whitstable commercial intent does not cannibalise.
5. **Measurement habit:** Monthly GSC export → update **§11.2** → roll comparable totals into **§1.2** organic row (**P10**). **Confirm in WP:** GA4 enquiry events before setting conversion targets.

**(c) Risks (YMYL / funding / trust)**

- **Funding and NHS/CHC queries** are sensitive: avoid legal or medical advice, implied eligibility guarantees, or budget promises. Point to official sources for rules that change.
- **Mis-stated accessibility** erodes trust with carers and commissioners and invites complaints: tie copy to verified equipment and layout scope only.
- **Duplicate or overlapping guides** on the same funding topic weaken rankings and confuse AI summaries; keep one clear owner URL per primary intent (**§2.4**).
- **Commercial vs informational overlap** (Kent-wide discovery vs Whitstable booking intent): if both compete internally, resolve with distinct H1 angles or consolidated internal linking (**§2.1** cannibalization note).

**(d) KPI guidance (which §1.2 cells to fill first)**

1. **Organic clicks (GSC):** Baseline now uses **§11.2** (**2026-05-10**). Next updates: same row **3 mo / 6 mo / 12 mo** only after dated exports (relative to consistent filter windows); do not invent targets.
2. **Indexed key URLs:** Fill **Baseline** when Search Console **Pages** or URL Inspection confirms indexing for the agreed P1 URL list (**§12**); until then leave **TBD**.
3. **Enquiry conversions (GA4):** Leave **TBD** until **Confirm in WP:** enquiry thank-you or form events are named and testable; then set baseline month before optimisation targets.
4. **AI citation spot-checks:** Fill **Baseline** as a count or date-stamped note once the first manual **§6** pass runs on priority URLs; quarterlies thereafter.

---

## 2. Keyword & AEO research (`/seo-aeo-keyword-research`)

Run **once per major pillar topic**, then refresh quarterly. **Cursor:** paste **§How to run → Copy-paste prompts P2**; the agent must follow **§2.0** (repo + SERP or tools + evidence labelling), then **append results to §2.6** in this file. Use the optional PHP block after P2 for `inc/seo-content-seed*.php` etc., then add a one-line **PHP updated** note in the latest §2.6 run.

### 2.0 Research depth (required for every P2 run)

**Thorough** research here means **evidence-backed** keyword choices someone else can audit, not a long list copied from memory.


| Layer            | Requirement                                                                                                                                                                                                                                                                                                                  |
| ---------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Theme**        | Open the pillar’s templates and `inc/seo-content-seed*.php`, `inc/page-meta-definitions.php`, `inc/seo.php` as relevant. In the §2.6 **Research brief**, **list file paths** you read and tie Tier 1 picks to **phrases present in source** or mark `Confirm in WP: …` when copy is missing.                                 |
| **SERP / tools** | For **≥3** queries, capture a **UK** SERP snapshot (logged-out `google.co.uk` or neutral window) **or** use `**/seo-dataforseo`** **or** another **web / search** skill or MCP available in the session. If none are available, write `**SERP check TBD - editor`** plus **exact queries** and steps (UK, mobile + desktop). |
| **Competition**  | For **≥1** head query, name **≥3** distinct **result types** winning page 1 (OTA, national brand, local property site, charity, guide-only, etc.) and state a **gap** Restwell can own **without** inventing property facts.                                                                                                 |
| **Volume**       | Target **≥6** Tier 1, **≥8** Tier 2, **≥5** Tier 3 rows **only when defensible**. If thin, add a **Gap** subsection (what to search next) instead of padding with generic synonyms. AEO **≥5** with a **winnability** note each. Cannibalization **≥4** bullets.                                                             |


**Tier tables:** include an **Evidence** column on each tier table (values such as `Theme copy: "…"`, `SERP spot-check YYYY-MM-DD`, `DataForSEO (metric + date)`, `Hypothesis - validate with ___`).

**§2.6 layout:** under each `#### Run - …` heading, order **Research brief** bullets first, then tables, optional **Gap**, then **Next validation** (what Ahrefs, Semrush, or `/seo-dataforseo` must confirm before primaries are locked).

### 2.1 Seed keywords (anchor set for `/seo-aeo-keyword-research`)

Use **3–5 seeds per pillar run** (below is one Restwell territory set). After expansion, sort into **Tier 1 / 2 / 3** (see §2.2), add **≥5 AEO questions** per pillar (§2.3), run **cannibalization** (§2.4), then hand off **Tier 1–2 → URL → format** (§2.5). **Validate volume + difficulty** in Ahrefs, Semrush, or `/seo-dataforseo` before locking primaries - skill rule: Tier 1 targets should skew to **difficulty below ~45** where possible, not volume alone.


| Seed                                                    | Role                        | Intent                      | Tier (hypothesis) | Own on / cannibalization note                                                                                                   |
| ------------------------------------------------------- | --------------------------- | --------------------------- | ----------------- | ------------------------------------------------------------------------------------------------------------------------------- |
| accessible self catering Kent                           | Geo + product               | Mixed commercial + research | 1–2               | Hub or county angle vs `/the-property/` - **one** primary commercial owner; others support with distinct H1s                    |
| accessible holiday cottage Whitstable                   | Local commercial            | Commercial / transactional  | 1                 | Concentrate “Whitstable + cottage” on **The Property** path; avoid second commercial URL with same primary                      |
| CHC respite holiday / NHS continuing healthcare holiday | Funding-adjacent (**YMYL**) | Informational               | 2                 | **Single** authoritative guide under `/resources/` (or one dedicated long URL); no thin CHC/NHS duplicates across cluster posts |
| direct payment holiday accommodation                    | High-intent funding         | Informational → commercial  | 1                 | DP explainer pillar; internal links to enquiry/booking; don’t split same primary across two guides                              |
| hoist tracking wet room accessible cottage              | Spec-led long-tail          | Commercial comparison       | 1                 | Primary depth on `/accessibility/`; blog only for “how to verify hoist compatibility” **if** H1 differs                         |


**Adjacent seeds** (add in first expansion pass - audience vocabulary beyond head terms):


| Seed                                   | Role                                                          |
| -------------------------------------- | ------------------------------------------------------------- |
| accessible coastal holiday Kent        | Geo + occasion (coast/town)                                   |
| wheelchair accessible holiday let Kent | Product synonym + geo                                         |
| carer respite break self catering UK   | Carer-led discovery (wider geo; link down to Kent/Whitstable) |


**Cannibalization pre-check (skill Step 4):** Rows 1–2 both map to “accessible stay + Kent/Whitstable”. Differentiate by **intent** (county discovery vs book-this-town) or **consolidate** internal links to one money URL. Rows 3–4 both funding - separate by **query** (CHC system vs direct payment mechanism), not by repeating the same definition blocks.

### 2.2 Tiers


| Tier  | When to target                                 | Restwell examples                                                        |
| ----- | ---------------------------------------------- | ------------------------------------------------------------------------ |
| **1** | Ship first - moderate difficulty, clear intent | DP guide, carers guide, “choose accessible cottage”, accessibility specs |
| **2** | After Tier 1 indexed                           | Blog clusters (mobility hire, CHC paperwork angles)                      |
| **3** | Long-term                                      | Head “accessible holidays UK” style terms                                |


### 2.3 AEO question keywords (minimum 5 per pillar)

For each seed topic, output **question → answer format**:


| AEO-style query     | Suggested format                              |
| ------------------- | --------------------------------------------- |
| What is …           | Definition sentence (first line), 40–60 words |
| How to …            | Numbered steps                                |
| X vs Y              | Comparison table                              |
| How much / who pays | Short paragraph + cite official source        |


Use these in **FAQ sections**, **H2/H3 questions**, and (where appropriate) `FAQPage`-eligible markup per theme/schema rules.

### 2.4 Cannibalization check

- Assign **one primary URL per commercial intent** (full map template in **§16 B2**).
- If two URLs target the same phrase, **differentiate** H1+angle or **consolidate** internal links to a single primary.

### 2.5 Content map output (hand to cluster step)

```
Tier 1 keyword → intended URL → content type (pillar / guide / post)
```

### 2.6 Agent keyword & AEO run log (Cursor)

*Append one dated `#### Run - YYYY-MM-DD - <pillar path>` subsection per research session. Each run must start with a **Research brief** (§2.0), then tier tables with **Evidence** column, then other tables. Use valid markdown pipe rows. Do not delete prior runs.*

**Canonical runs (read these first)**

- `**/resources/` (current §2.0 spec):** The audit source of truth is `**#### Run - 2026-05-10 - /resources/ - §2.0 evidence pass*`*. The `**#### Run - 2026-05-10 - /resources/ - legacy outline**` block that appears **first** under this index is **historical** (pre-Evidence layout); keep for narrative only.
- **Other URLs:** Subsequent `#### Run - 2026-05-10 - …` entries use the §2.0 brief + Evidence pattern unless the heading says **legacy**.

**Workspace constraint (this Cursor repo session, repeated in many runs):** **DataForSEO** MCP was not available; **KD, volume, and bulk PAA exports stay TBD** until Ahrefs, Semrush, or DataForSEO. **Live logged-out `google.co.uk` (mobile + desktop)** SERPs were not captured; evidence tagged **Web search snapshot** is **not** position-level. Follow each run's **Next validation** for editor or tool follow-up.


**Evidence run archive (extracted 2026-07-05):** Full `#### Run - …` subsections live in [`docs/seo-runs/2026-05-10-evidence-runs.md`](../../docs/seo-runs/2026-05-10-evidence-runs.md). Append **new** runs to that file or create `docs/seo-runs/YYYY-MM-DD-<topic>.md` and add a row below.

| Batch | File | URLs covered |
|-------|------|-------------|
| 2026-05-10 evidence pass | [2026-05-10-evidence-runs.md](../../docs/seo-runs/2026-05-10-evidence-runs.md) | All §2.6 runs through blog hub |

*Do not duplicate tier tables here — edit the archive file and summarize deltas in a one-line note if needed.*

## 3. Topic cluster (`/seo-aeo-content-cluster`)

### 3.1 Pillar pages (anchors - adjust word counts in WP)


| Pillar URL                                         | Primary job                     | Word target           |
| -------------------------------------------------- | ------------------------------- | --------------------- |
| `/resources/`                                      | Funding & system navigation hub | 2500–4000 (editorial) |
| `/how-to-choose-accessible-self-catering-holiday/` | Comparator / education          | 2500–4000             |
| `/the-property/`                                   | Commercial core                 | Strong specs + trust  |
| `/accessibility/`                                  | Spec credibility                | Detailed, scannable   |


### 3.2 Cluster articles (8–15 items - Priority 1 / 2 / 3)

**Priority 1 (write / polish first):** clear intent, aligns with Tier 1 keywords - e.g. DP holiday page, carers respite guide, CHC-related blog, mobility hire post, packing/insurance guides (match existing seeds in `inc/seo-content-seed*.php`).

**Priority 2:** medium-volume long-tail - seasonal Kent content, deeper NHS wording explainers.

**Priority 3:** low volume, **high conversion** - e.g. enquiry-adjacent reassurance, “what to send before booking”.

**Rules:**

- **Unique target keyword** per article - no semantic duplicate ownership.
- **Every cluster article links up** to its pillar; **no orphans**.
- Include **≥1 FAQ-heavy** and **≥1 comparison** piece per cluster where relevant.
- Flag **2 AEO-priority** pieces per cluster (“What is …”, comparison table).

### 3.3 Internal link map (tree)

```
Pillar (/resources/ or /how-to-choose…/)
  |- Cluster A (blog)
  |- Cluster B (blog)
  |- Cluster C (guide page)
Cluster A ↔ Cluster B (only if distinct intent)
```

Document concrete URLs and dates in **§16 B3** backlog tables.

### 3.4 Content gap / AEO angles

Ask in research session: *What questions do competitors skip* (paperwork realism, hoist compatibility, commissioner language)? Use for **direct-answer** paragraphs and FAQs.

### 3.5 Agent cluster run log (Cursor)

*Append `#### Cluster run - YYYY-MM-DD - <pillar path>` with: cluster article list (`URL or slug`  `Primary kw`  `P1\|P2\|P3`), internal link bullet tree, two AEO-priority lines, content-gap bullets. Extend **§16 B3** backlog rows when you add dated work.*

#### Cluster run - 2026-05-10 - template-who-its-for.php (`/who-its-for/`)

**Pillar:** `/who-its-for/` | **Suggested primary keyword:** `accessible stay suitability` | **Role:** Audience-fit hub (guests, carers, OT or case manager, commissioners); links out to funding hub, local guides, and spec page per `template-who-its-for.php` related reading.

**Cluster articles** (unique primary per URL; no semantic duplicate ownership with `/how-to-choose-accessible-self-catering-holiday/` comparator pillar)


| Article slug                                       | Primary keyword (unique)                                            | Priority |
| -------------------------------------------------- | ------------------------------------------------------------------- | -------- |
| `/accessibility/`                                  | wheelchair accessible holiday let measurements wet room hoist specs | P1       |
| `/direct-payment-holiday-accommodation/`           | direct payment holiday accommodation self catering UK               | P1       |
| `/carers-respite-holiday-guide/`                   | carers respite holiday self catering UK                             | P1       |
| `/commissioner-checklist-accessible-respite-stay/` | commissioner checklist funded respite accommodation documentation   | P1       |
| `/resources/`                                      | disability holiday funding support hub UK short breaks              | P2       |
| `/chc-respite-holiday-accommodation-uk/`           | NHS continuing healthcare respite holiday accommodation UK          | P2       |
| `/personal-budget-short-break-care-act/`           | personal budget short break Care Act assessment route               | P2       |
| `/how-to-read-holiday-cottage-access-statement/`   | how to read holiday cottage accessibility statement UK              | P2       |
| `/whitstable-area-guide/`                          | Whitstable Tankerton accessible coastal stay guide                  | P2       |
| `/accessible-beaches-coastal-walks-kent/`          | accessible beaches coastal walks Kent wheelchair                    | P2       |
| `/revitalise-alternatives-accessible-holidays/`    | Revitalise alternatives accessible respite holidays UK comparison   | P2       |
| `/hire-mobility-scooter-equipment-uk-holiday/`     | hire mobility scooter holiday UK self catering                      | P3       |
| `/faq/`                                            | Restwell accessible self catering booking FAQs                      | P3       |


**Internal link tree** (§3.3; every cluster node links up to `/who-its-for/` at least once where editorially natural, plus hub and spec paths below)

```
/who-its-for/  (pillar)
  |-- /accessibility/
  |-- /resources/
  |-- /direct-payment-holiday-accommodation/
  |-- /carers-respite-holiday-guide/
  |-- /commissioner-checklist-accessible-respite-stay/
  |-- /chc-respite-holiday-accommodation-uk/
  |-- /personal-budget-short-break-care-act/
  |-- /how-to-read-holiday-cottage-access-statement/
  |-- /whitstable-area-guide/
  |-- /accessible-beaches-coastal-walks-kent/
  |-- /revitalise-alternatives-accessible-holidays/
  |-- /hire-mobility-scooter-equipment-uk-holiday/
  |-- /faq/

/resources/  (funding hub)
  |-- -> /who-its-for/  (audience routing)
  |-- -> /direct-payment-holiday-accommodation/, /chc-respite-holiday-accommodation-uk/, /personal-budget-short-break-care-act/  (deep guides)

/carers-respite-holiday-guide/  <->  /faq/  (Carer's Assessment snippet vs long-form; distinct intents)

/commissioner-checklist-accessible-respite-stay/  ->  /chc-respite-holiday-accommodation-uk/  (CHC paperwork overlap, separate primaries)

/whitstable-area-guide/  <->  /accessible-beaches-coastal-walks-kent/  (local stay cluster)

/how-to-read-holiday-cottage-access-statement/  ->  /accessibility/  (process vs measured facts)
```

**Two AEO-priority pieces** (direct-answer or extraction-friendly)

1. `**/faq/`** | Question-led blocks (examples aligned to `template-who-its-for.php` copy): *What is a Carer's Assessment under the Care Act 2014?* | Format: 40 to 60 word answer plus link to `/carers-respite-holiday-guide/`.
2. `**/commissioner-checklist-accessible-respite-stay/*`* | *What paperwork do commissioners need for a funded adapted respite stay?* | Format: checklist H2 and bullet list (matches commissioner bullets on pillar; avoid duplicating full YMYL outcomes).

**Content gaps vs §3.4** (questions many competitor listings skip; keep facts repo-verified)

- **Hoist and sling compatibility:** Guests often ask sling type, safe working load, and compatibility with their loop tapes. **Confirm in WP:** publish only what `/accessibility/` and enquiry replies commit to (do not expand hoist coverage beyond source).
- **Direct payment invoicing fields:** What line items or references LA finance teams expect on an invoice for respite accommodation. Competitors rarely spell this out; needs verified process copy or **Confirm in WP** before claiming.
- **Kent LA timeline realism:** Rough order of steps from assessment to payment for short breaks (not legal advice). High YMYL; signpost KCC and defer dates that drift yearly.
- **Mid-stay care roster change:** Risk when a named worker drops out. Cross-link existing `/holiday-backup-plan-care-worker-change/` from carers and FAQ flows if not already prominent from `/who-its-for/`.
- **Sensory or neurodiversity planning:** Low competitor specificity for self-catering near busy harbours. Possible future cluster angle only if editorial scope is approved (not asserted in current theme defaults).

#### Cluster run - 2026-05-10 - Seeded long-forms cluster (`page.php`, 15 URLs)

**Pillars (dual hub):** `/resources/` (funding, YMYL navigation) and `/how-to-choose-accessible-self-catering-holiday/` (comparator and trip planning). **Local parent:** `/whitstable-area-guide/` for Kent coast logistics posts (§16 B2). Cross-link to `/accessibility/` (spec facts), `/the-property/`, `/enquire/` where editorially natural. Property kit and hoist scope: **Confirm in WP** before expanding beyond theme copy.

**Cluster articles** (one owning primary keyword per URL; slugs match seeded routes)


| Suggested slug                                     | Primary keyword (unique)                                           | Priority |
| -------------------------------------------------- | ------------------------------------------------------------------ | -------- |
| `/chc-respite-holiday-accommodation-uk/`           | NHS continuing healthcare respite holiday accommodation UK         | P1       |
| `/commissioner-checklist-accessible-respite-stay/` | commissioner checklist funded respite adapted accommodation UK     | P1       |
| `/what-to-pack-accessible-self-catering-uk/`       | accessible self catering holiday packing list UK                   | P1       |
| `/accessible-parking-whitstable-tankerton/`        | disabled parking Whitstable Tankerton Blue Badge bays              | P1       |
| `/revitalise-alternatives-accessible-holidays/`    | Revitalise alternatives accessible respite holidays UK comparison  | P1       |
| `/hire-mobility-scooter-equipment-uk-holiday/`     | mobility equipment hire holiday UK self catering scooter           | P1       |
| `/travel-insurance-disability-uk-self-catering/`   | travel insurance pre-existing disability UK self catering holiday  | P2       |
| `/personal-budget-short-break-care-act/`           | personal budget short break Care Act direct payment respite        | P2       |
| `/accessible-train-travel-whitstable-kent/`        | wheelchair accessible train travel Whitstable Kent rail assistance | P2       |
| `/accessible-eating-out-whitstable-kent/`          | wheelchair accessible restaurants cafes Whitstable Kent            | P2       |
| `/changing-places-toilets-kent-coast-days-out/`    | Changing Places toilets Kent coast day trips accessibility         | P2       |
| `/quieter-times-whitstable-low-crowd-access/`      | quiet times Whitstable low crowds sensory friendly visit           | P2       |
| `/how-to-read-holiday-cottage-access-statement/`   | how to read holiday cottage accessibility statement UK             | P2       |
| `/holiday-backup-plan-care-worker-change/`         | respite holiday backup plan care worker roster change              | P3       |
| `/fatigue-friendly-whitstable-coastal-day/`        | fatigue friendly coastal day Whitstable pacing rest stops          | P3       |


**Internal link tree** (§3.3; each cluster URL links up to at least one pillar or `/whitstable-area-guide/`; no orphans)

```
/resources/
  |-- /chc-respite-holiday-accommodation-uk/
  |-- /commissioner-checklist-accessible-respite-stay/
  |-- /personal-budget-short-break-care-act/
  |-- /travel-insurance-disability-uk-self-catering/
  |-- /holiday-backup-plan-care-worker-change/
  |-- -> /how-to-choose-accessible-self-catering-holiday/

/how-to-choose-accessible-self-catering-holiday/
  |-- /what-to-pack-accessible-self-catering-uk/
  |-- /how-to-read-holiday-cottage-access-statement/
  |-- /hire-mobility-scooter-equipment-uk-holiday/
  |-- /revitalise-alternatives-accessible-holidays/
  |-- -> /resources/
  |-- -> /accessibility/
  |-- -> /the-property/

/whitstable-area-guide/
  |-- /accessible-parking-whitstable-tankerton/
  |-- /accessible-train-travel-whitstable-kent/
  |-- /accessible-eating-out-whitstable-kent/
  |-- /changing-places-toilets-kent-coast-days-out/
  |-- /quieter-times-whitstable-low-crowd-access/
  |-- /fatigue-friendly-whitstable-coastal-day/

/chc-respite-holiday-accommodation-uk/  ->  /commissioner-checklist-accessible-respite-stay/  (related YMYL; distinct primaries)

/what-to-pack-accessible-self-catering-uk/  ->  /travel-insurance-disability-uk-self-catering/

/hire-mobility-scooter-equipment-uk-holiday/  <->  /accessible-train-travel-whitstable-kent/

/how-to-read-holiday-cottage-access-statement/  ->  /accessibility/  (process vs measured specs)

/revitalise-alternatives-accessible-holidays/  ->  /carers-respite-holiday-guide/  (comparison vs generic respite guide; keep separate primaries)
```

**Two AEO-priority pieces**

1. `**/how-to-read-holiday-cottage-access-statement/`** | User question: *What is a holiday cottage accessibility statement?* | Format: definition in the first paragraph, then a short checklist section and a link to `/accessibility/` for Restwell-specific measurements (**Confirm in WP** for any numbers).
2. `**/chc-respite-holiday-accommodation-uk/*`* | User question: *Can NHS Continuing Healthcare fund respite holiday accommodation?* | Format: direct answer opening (40 to 60 words), plain-language caveats, signpost official NHS or LA sources; avoid outcomes you cannot verify (**Confirm in WP** for site positioning).

**Content gaps vs §3.4** (angles many OTAs and generic guides under-answer)

- **Rail assistance lead times and operator variance:** Southeastern assistance booking practicalities versus generic “phone ahead” advice. **Confirm in WP:** numbers and links before stating cut-off times.
- **Street-level parking truth:** Which stretches still need a walk from bay to seafront in Tankerton or Whitstable when kerbs or surfaces matter. Competitors rarely map this; verify on the ground or label as **Confirm in WP**.
- **Insurance and hired mobility kit:** Disclosure wording when hiring scooters or bringing NHS-owned equipment; not legal advice; tie to `/travel-insurance-disability-uk-self-catering/` and insurer T and Cs.
- **Commissioner vs social worker vocabulary:** Plain mapping of who signs what for a funded short break (roles vary by council). Useful for `/commissioner-checklist-accessible-respite-stay/` without inventing local process.
- **Changing Places plus onward route:** Which venues pair a toilet stop with step-free coffee or lunch nearby (partially covered by eating-out URL; keep primaries split).

#### Cluster run - 2026-05-10 - Legal trio (`template-privacy-policy.php`, `template-terms-and-conditions.php`, `template-accessibility-policy.php`)

**Pillars (trust hub - theme defaults in `inc/theme-setup.php`)**


| Pillar URL               | Primary keyword (SEO seed - see `inc/seo-content-seed.php`) | Role                                                                                                                                                                                                                                                                   |
| ------------------------ | ----------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `/privacy-policy/`       | `restwell privacy`                                          | Data controller, enquiry fields, Continuity of Care Services sharing when care is agreed, GA4 cookies with consent controls, retention up to three years, UK GDPR rights and ICO                                                                                       |
| `/terms-and-conditions/` | `restwell terms`                                            | Booking confirmation, payments (deposit, balance six weeks before arrival, BACS and card), cancellation tiers, accessibility reliance at booking, exceptional circumstances, optional care introduction, equipment use and hoist, dogs with notice and risk assessment |
| `/accessibility-policy/` | `restwell website accessibility`                            | WCAG 2.2 Level AA aim where reasonably practicable; testing; third-party embed limits; points to `/accessibility/` for property specification (website versus bricks and mortar); forty-eight hour reply aim; EHRC signpost                                            |


**Cluster articles** (one owning primary per URL; supporting pieces only - do not reuse pillar seed phrases as cluster primaries)


| Suggested slug                                           | Primary keyword (unique)                                                                   | Priority |
| -------------------------------------------------------- | ------------------------------------------------------------------------------------------ | -------- |
| `/website-accessibility-statement-vs-property-access/`   | website accessibility statement versus property accessibility specification UK holiday let | P1       |
| `/health-information-enquiry-form-uk-gdpr/`              | UK GDPR health information holiday enquiry form lawful basis                               | P1       |
| `/care-partner-data-share-booking-continuity/`           | Continuity of Care Services personal data booking introduction                             | P1       |
| `/cancellation-evidence-medical-care-emergency-holiday/` | medical cancellation evidence holiday booking doctor letter UK adapted stay                | P2       |
| `/deposit-and-balance-payment-timing-self-catering/`     | self catering booking balance due six weeks before arrival UK                              | P2       |
| `/cookie-controls-google-analytics-holiday-site/`        | cookie consent Google Analytics 4 small tourism website UK                                 | P2       |
| `/data-retention-booking-records-three-years/`           | booking and enquiry records retention three years UK GDPR self catering                    | P2       |
| `/ico-subject-access-request-small-provider/`            | ICO subject access request holiday accommodation provider UK                               | P2       |
| `/assistance-dogs-advance-notice-adapted-stay/`          | assistance dogs holiday accommodation advance notice risk assessment UK                    | P3       |
| `/report-accessibility-equipment-fault-during-stay/`     | report hoist or accessibility equipment fault during holiday stay                          | P3       |
| `/third-party-embed-accessibility-limits-maps-video/`    | embedded maps video accessibility limits holiday website UK                                | P3       |


**Internal link tree** (§3.3; each supporting URL links up to at least one pillar; no orphans)

```
/privacy-policy/
  |-- /health-information-enquiry-form-uk-gdpr/
  |-- /care-partner-data-share-booking-continuity/
  |-- /data-retention-booking-records-three-years/
  |-- /cookie-controls-google-analytics-holiday-site/
  |-- /ico-subject-access-request-small-provider/

/terms-and-conditions/
  |-- /cancellation-evidence-medical-care-emergency-holiday/
  |-- /deposit-and-balance-payment-timing-self-catering/
  |-- /assistance-dogs-advance-notice-adapted-stay/
  |-- /report-accessibility-equipment-fault-during-stay/

/accessibility-policy/
  |-- /website-accessibility-statement-vs-property-access/
  |-- /third-party-embed-accessibility-limits-maps-video/
  |-- -> /accessibility/  (property specification - distinct primary)

/privacy-policy/  <->  /terms-and-conditions/  <->  /accessibility-policy/  (legal trio navigation)

/website-accessibility-statement-vs-property-access/  ->  /accessibility-policy/  +  /accessibility/

/cancellation-evidence-medical-care-emergency-holiday/  ->  /travel-insurance-disability-uk-self-catering/  (Seeded cluster URL - insurance angle; separate primary)

/enquire/  ->  /privacy-policy/  +  /terms-and-conditions/  (transparent routing where editorially natural)
```

**Two AEO-priority pieces**

1. `**/website-accessibility-statement-vs-property-access/`** | Question: *What is the difference between a website accessibility statement and a property accessibility specification?* | Format: definitional opening, comparison table, links to `/accessibility-policy/` and `/accessibility/` (quote measurements only after **Confirm in WP**).
2. `**/health-information-enquiry-form-uk-gdpr/*`* | Question: *What happens to health or care details you include on a holiday enquiry form?* | Format: forty to sixty word direct answer first, then bullets aligned to theme privacy defaults (legitimate interests, contract performance if you book, optional share with Continuity of Care Services when care is agreed).

**Content gaps vs §3.4** (questions competitors and generic OTAs often skip)

- **Payment processor and card storage:** Terms allow BACS and card; privacy defaults do not name a processor or PCI wording. **Confirm in WP** before claiming where card data sits or who processes it.
- **Joint controller or processor:** Whether a council or NHS team forwarding plans counts as a joint controller with the host. High YMYL; flag only unless counsel-approved wording exists.
- **SAR turnaround promise:** ICO guidance applies; avoid fixed calendar-day promises unless an internal SLA is published.
- **EHRC versus ICO routing:** Accessibility policy sends people to EHRC for formal complaints after an unsatisfactory response on digital access; data complaints still sit with ICO. Few sites map both routes next to each other.
- **Out-of-hours equipment fault:** Terms ask for prompt reporting; competitors rarely spell escalation for hoist or track faults overnight. Align `/report-accessibility-equipment-fault-during-stay/` with real contact paths (**Confirm in WP** for any twenty-four-hour claim).

#### Cluster run - 2026-05-10 - / (homepage)

**Pillar:** `/` (homepage) | **Suggested primary keyword:** `accessible holidays Whitstable Kent` | **Role:** Brand-and-category landing that funnels first-touch visitors to the commercial core (`/the-property/`), the spec page (`/accessibility/`), the booking journey (`/how-it-works/`), and the conversion form (`/enquire/`). Anchored to existing on-page sections in `front-page.php`: hero H1 "Accessible Holidays in Whitstable, Kent", hero subheading "Adapted bungalow for guests, families, and carers with whole-property booking", comparison band "Restwell vs. a typical hotel stay" with seeded rows in `inc/theme-setup.php` (Privacy: whole property vs shared spaces; Equipment: bedroom ceiling hoist, profiling bed; Care: optional, your choice; Kitchen: full self-catering), and trust line "Support from Continuity of Care Services · CQC regulated".

This cluster is the **commercial-discovery and conversion** layer. It does **not** re-claim primary-keyword ownership for URLs already locked in the `/who-its-for/` cluster run (`2026-05-10`), the seeded long-forms cluster run (`2026-05-10`), or the `/resources/` research run in **§2.6**. Where a URL has a locked primary, this run lists the existing primary and treats the URL as a supporting node only.

**Cluster articles** (mix of P1 commercial pillars, P2 consideration, P3 trust and reference; 13 URLs)


| Article slug                                                | Primary keyword (unique)                                                                | Priority |
| ----------------------------------------------------------- | --------------------------------------------------------------------------------------- | -------- |
| `/the-property/`                                            | adapted bungalow whole property booking Whitstable                                      | P1       |
| `/enquire/`                                                 | accessible self catering enquiry Whitstable Kent                                        | P1       |
| `/how-it-works/`                                            | accessible holiday booking process Kent enquiry to arrival                              | P1       |
| `/how-to-choose-accessible-self-catering-holiday/`          | how to choose accessible self catering holiday UK                                       | P1       |
| `/restwell-vs-accessible-hotel-room-uk/` (NEW slug)         | whole property accessible cottage vs accessible hotel room UK comparison                | P2       |
| `/whats-included-accessible-self-catering-stay/` (NEW slug) | what is included in an accessible self catering holiday UK                              | P2       |
| `/who-its-for/`                                             | accessible stay suitability (locked 2026-05-10)                                         | P2       |
| `/whitstable-area-guide/`                                   | Whitstable Tankerton accessible coastal stay guide (locked 2026-05-10)                  | P2       |
| `/resources/`                                               | disability holiday funding support hub UK short breaks (locked 2026-05-10)              | P2       |
| `/care-support-partner-kent-cqc/` (NEW slug)                | optional on site care support holiday Kent CQC regulated                                | P3       |
| `/blog/`                                                    | accessible holiday Whitstable Kent guides blog index                                    | P3       |
| `/faq/`                                                     | Restwell accessible self catering booking FAQs (locked 2026-05-10)                      | P3       |
| `/accessibility/`                                           | wheelchair accessible holiday let measurements wet room hoist specs (locked 2026-05-10) | P3       |


**Internal link tree** (§3.3; every cluster node links up to `/` at least once via header navigation plus at least one in-body cross-link from a parent node)

```
/  (pillar = homepage)
  |-- /the-property/                                    (commercial core; hero CTA "View the property")
  |-- /accessibility/                                   (spec credibility)
  |-- /how-it-works/                                    (journey: enquiry to arrival)
  |-- /enquire/                                         (conversion; hero CTA "Send an enquiry")
  |-- /how-to-choose-accessible-self-catering-holiday/  (comparator pillar; education)
  |-- /restwell-vs-accessible-hotel-room-uk/            (NEW; AEO comparison, mirrors home comparison band)
  |-- /whats-included-accessible-self-catering-stay/    (NEW; AEO what-is, mirrors hero "Adapted bungalow… whole-property booking")
  |-- /who-its-for/                                     (audience hub; routes into existing /who-its-for/ cluster)
  |-- /whitstable-area-guide/                           (area hub; "Town, harbour & coast")
  |-- /resources/                                       (funding hub)
  |-- /care-support-partner-kent-cqc/                   (NEW; trust + Continuity of Care Services scope)
  |-- /blog/                                            (editorial hub; surfaces cluster posts)
  |-- /faq/                                             (FAQ hub)

/the-property/  <->  /accessibility/                                                 (commercial story <-> measured spec, both ways)
/the-property/   ->  /enquire/                                                       (commercial close)
/how-it-works/   ->  /enquire/                                                       (Step 1 "Get in touch" closes to enquiry)
/how-it-works/   ->  /care-support-partner-kent-cqc/                                 (Step 3 "Arrange support if needed" deep link)
/restwell-vs-accessible-hotel-room-uk/    ->  /the-property/, /enquire/              (comparison closes to commercial)
/restwell-vs-accessible-hotel-room-uk/    <->  /how-to-choose-accessible-self-catering-holiday/  (comparator family; distinct intents: vs hotel vs general checklist)
/whats-included-accessible-self-catering-stay/   ->  /the-property/, /accessibility/, /how-it-works/  (what-is routes to spec + journey)
/who-its-for/    ->  /resources/, /accessibility/, /carers-respite-holiday-guide/, /commissioner-checklist-accessible-respite-stay/  (existing /who-its-for/ cluster, locked 2026-05-10)
/whitstable-area-guide/  <->  /accessible-beaches-coastal-walks-kent/                (local cluster, already linked)
/resources/      ->  /direct-payment-holiday-accommodation/, /chc-respite-holiday-accommodation-uk/, /personal-budget-short-break-care-act/  (deep funding guides)
/care-support-partner-kent-cqc/  ->  /how-it-works/, /enquire/                       (Confirm in WP: scope must come from Step 3 + partner copy; do not invent care plan tiers)
/blog/           ->  Tier 1 / Priority 1 blog cluster posts already wired in `inc/seo-content-seed-blog-cluster-a.php`
/faq/            ->  /how-it-works/, /resources/, /enquire/                          (signposts; FAQ must not steal primaries; align with §16 B2)
```

No orphans: every cluster article links up to `/` at least once and has at least one peer cross-link above.

**Two AEO-priority pieces** (direct-answer or extraction-friendly; flagged for early publishing because the question and table formats have the highest AI-Overview lift)

1. `**/restwell-vs-accessible-hotel-room-uk/`** | *Whole-property accessible cottage vs accessible hotel room: which suits a disabled family or carer team?* | Format: 40 to 60 word direct-answer paragraph first, then a comparison `<table>` with criteria column matching the homepage seed (Privacy: whole property vs shared spaces; Equipment: **bedroom** ceiling hoist, profiling bed vs limited; Care: optional, your choice vs fixed or none; Kitchen: full self-catering vs none or limited), then short FAQ block. **Confirm in WP:** keep the equipment row scoped to bedroom hoist as the seed states; do not extend hoist coverage in the comparison.
2. `**/whats-included-accessible-self-catering-stay/*`* | *What is included in an accessible self-catering stay at Restwell?* | Format: 40 to 60 word definition first sentence, then a bullet list pulled from `template-how-it-works.php` defaults (bed linen and towels, welcome pack, full kitchen, private garden, fast Wi-Fi, accessible parking) followed by a separate access-kit bullet list pulled from `/accessibility/`. Keep the access-kit list to repo-verified items only; use `Confirm in WP:` placeholders for any equipment claim not present on `/accessibility/`.

**Content gaps vs §3.4** (questions many competitor cottage and OTA listings skip; keep facts repo-verified)

- **Whole-property booking impact for hoist users and carer teams:** Multi-unit OTAs and accessible-room hotels rarely answer the practical question of single-party use (predictable corridors, no shared kitchen, carer can move freely overnight). The hero already states "whole-property booking", so the new comparison page can answer this directly without inventing scope.
- **Realistic 48 hour reply window vs instant-quote portals:** Hero microcopy "Usually reply within 48 hours · No obligation" is a differentiator. Few competitors front this. Add a question-led FAQ block on `/enquire/` and `/faq/` answering "How quickly does Restwell reply to an enquiry?" using the 48 hour wording verbatim.
- **What "optional care support" actually means:** Many accessible properties either bundle care silently or stay vague. Restwell pairs the property with Continuity of Care Services (CQC-regulated). The new `/care-support-partner-kent-cqc/` page should answer "Can I bring my own carer or use Restwell's care partner?" using only what `template-how-it-works.php` Step 3 and `front-page.php` trust copy already commit to. **Confirm in WP:** do not invent service tiers, response times, or pricing structures.
- **Adapted bungalow vs converted hotel room or upper-floor adapted suite:** Single-storey, step-free, bedroom ceiling hoist, profiling bed: this scope sits in the homepage seed and is rarely matched by hotel chains. The comparison page should keep claims to that scope (no whole-property hoist coverage unless `/accessibility/` confirms it).
- **Booking sequence for funded stays:** First-time funded bookers (DP, CHC, commissioner) often skip homepage comparators because they need paperwork first. Add a single-line signpost from the homepage funding teaser to `/resources/`, and from `/how-it-works/` Step 1 to `/resources/`, for the funded-booker route. Avoid duplicating funding YMYL on the homepage; route depth to the existing `/resources/` cluster.
- **Pre-deposit checklist for disabled guests:** Door widths, sling tape compatibility, parking width at the property, mid-stay carer contingency, what to send before paying. Most competitor pages avoid this. **Future cluster article candidate** under a `/the-property/`-adjacent slot once `/accessibility/` measured facts are confirmed in WP. Flag now; do not draft until source is locked.

---

## 4. Per-URL pipeline (repeat for P1 → P4)

Order: **keyword strategist → meta optimizer → headings → snippets → body polish → links → publish.**

**Global guardrails (human editors too):** Use only verifiable facts from the theme or WP (do not invent equipment scope, e.g. hoist coverage). Never use `fully accessible`. Avoid Unicode em dash (U+2014) in new titles, meta, and body. Self-check prose with `/avoid-ai-writing`. Full wording lives under **§How to run → Global fact and style constraints**.

### Step A - Intent & vocabulary (`/seo-keyword-strategist`)

1. Page type + primary intent (commercial / informational / transactional).
2. Paste hero + ~400 words → run skill.
3. Capture: **primary** (one), **secondary** (3–5), **LSI list**, **entities**, **density notes** (stay ~**0.5–1.5%** primary in final body).
4. Flag **over-optimization** if repetition feels mechanical.

### Step B - Title & meta (`/seo-meta-optimizer`)

1. Input: Step A keywords + 2 USPs + brand rule (brand usually **end**, except homepage).
2. **Title:** ~50–60 chars; primary in **first ~30** chars; mobile-safe truncation.
3. **Meta:** ~150–160 chars; benefit + keyword + one CTA; **no** clutter unicode required.
4. Deliver **3 title + 3 description variants**; pick one; log alternates on worksheet.

### Step C - H1 & H2 (`/seo-structure-architect`)

1. **Single H1**; may differ slightly from title for readability.
2. **H2s** mirror questions from Step A + AEO list (§2.3).
3. Short paragraphs; one idea per paragraph for AI/search extraction.

### Step D - Snippet & FAQ blocks (`/seo-snippet-hunter`)

For each high-value question:

- **Paragraph snippet:** **40–60 words**; answer in **first sentence**; question mirrored in heading.
- **Lists:** numbered for processes; bullets for criteria.
- **Tables:** specs, funding comparisons, “what we provide vs what you bring”.
- Align FAQ blocks with theme/schema patterns (do not duplicate conflicting JSON-LD).

### Step E - Body & draft standards (`/seo-content-writer`)

- Intro **50–100 words**: hook + primary keyword natural + promise.
- Body: examples, specifics (hoists, parking, doors), trustworthy wording for YMYL-adjacent topics.
- **CTA** aligned to intent (enquire vs read more).
- **Internal links** suggested in draft notes for editor.

### Step F - Internal links

1. **Outbound:** 2–4 to pillars / related Tier 1 URLs (varied anchors).
2. **Inbound:** from blog, `/resources/`, guides - see §3.3.
3. Run `**/seo-cannibalization-detector*`* when two pages feel same-intent.

### Step G - Publish & verify

1. WP save; cache purge.
2. View-source check `title`, `meta description`, `og:title/description`.
3. Monthly: compare **Pages** performance for this URL vs **§11** prior snapshot (see §11.5).

### Step H - Quality pass (aligns with §16 B4)

- FAQ or definition blocks where people actually ask (PAA, calls, forums) - not only where GSC shows queries yet.
- Theme SEO fields in WP (Search & Social / focus keyphrase if used) aligned with primary query.
- After material edits: note **dateModified** / visible “updated” where appropriate (**§16 B5**).

### 4.1 Per-URL agent log (Cursor)

*Use **§13.1** for the wide worksheet row; use this subsection for short step-by-step audit trails. Append `#### URL … - YYYY-MM-DD` with bullets (Step A: …; Step B: …) if §13.1 is not enough space.*

- **P4 Step C (2026-05-11):** `/the-property/` H1 and H2 ladder in §13.1 **H1 / H2 summary** plus §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/the-property/`.
- **P4 Step C (2026-05-11):** `/how-it-works/` H1 and H2 ladder in §13.1 **H1 / H2 summary** plus §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/how-it-works/`.
- **P4 Step C (2026-05-11):** `/faq/` H1 and H2 ladder in §13.1 **H1 / H2 summary** plus §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/faq/`.
- **P4 Step C (2026-05-11):** `/blog/` H1 and H2 ladder in §13.1 **H1 / H2 summary** plus §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/blog/`.
- **P4 Step C (2026-05-11):** `/guest-guide/` H1 and H2 ladder in §13.1 **H1 / H2 summary** plus §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/guest-guide/`.
- **P4 Step C (2026-05-11):** `/accessible-beaches-coastal-walks-kent/` H1 and H2 ladder in §13.1 **H1 / H2 summary** plus §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/accessible-beaches-coastal-walks-kent/`.
- **P4 Step C (2026-05-11):** `/direct-payment-holiday-accommodation/` H1 and H2 ladder in §13.1 **H1 / H2 summary** plus §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/direct-payment-holiday-accommodation/`.
- **P4 Step C (2026-05-11):** `/chc-respite-holiday-accommodation-uk/` H1 and H2 ladder in §13.1 **H1 / H2 summary** plus §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/chc-respite-holiday-accommodation-uk/`.
- **P4 Step C (2026-05-11):** `/carers-respite-holiday-guide/` H1 and H2 ladder in §13.1 **H1 / H2 summary** plus §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/carers-respite-holiday-guide/`.
- **P4 Step C (2026-05-11):** `/revitalise-alternatives-accessible-holidays/` H1 and H2 ladder in §13.1 **H1 / H2 summary** plus §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/revitalise-alternatives-accessible-holidays/`.
- **P4 Step C (2026-05-11):** `/how-to-choose-accessible-self-catering-holiday/` H1 and H2 ladder in §13.1 **H1 / H2 summary** plus §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/how-to-choose-accessible-self-catering-holiday/`.
- **P4 Step C (2026-05-11):** `/accessible-train-travel-whitstable-kent/` H1 and H2 ladder in §13.1 **H1 / H2 summary** plus §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/accessible-train-travel-whitstable-kent/`.
- **P4 Step C (2026-05-11):** `/what-to-pack-accessible-self-catering-uk/` H1 and H2 ladder in §13.1 **H1 / H2 summary** plus §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/what-to-pack-accessible-self-catering-uk/`.
- **P4 Step C (2026-05-11):** `/accessible-parking-whitstable-tankerton/` H1 and H2 ladder in §13.1 **H1 / H2 summary** plus §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/accessible-parking-whitstable-tankerton/`.
- **P4 Step C (2026-05-11):** `/accessible-eating-out-whitstable-kent/` H1 and H2 ladder in §13.1 **H1 / H2 summary** plus §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/accessible-eating-out-whitstable-kent/`.
- **P4 Step C (2026-05-11):** `/travel-insurance-disability-uk-self-catering/` H1 and H2 ladder in §13.1 **H1 / H2 summary** plus §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/travel-insurance-disability-uk-self-catering/`.
- **P4 Step C (2026-05-11):** `/quieter-times-whitstable-low-crowd-access/` H1 and H2 ladder in §13.1 **H1 / H2 summary** plus §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/quieter-times-whitstable-low-crowd-access/`.
- **P4 Step C (2026-05-11):** `/how-to-read-holiday-cottage-access-statement/` H1 and H2 ladder in §13.1 **H1 / H2 summary** plus §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/how-to-read-holiday-cottage-access-statement/`.
- **P4 Step C (2026-05-11):** `/holiday-backup-plan-care-worker-change/` H1 and H2 ladder in §13.1 **H1 / H2 summary** plus §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/holiday-backup-plan-care-worker-change/`.
- **P4 Step C (2026-05-11):** `/changing-places-toilets-kent-coast-days-out/` H1 and H2 ladder in §13.1 **H1 / H2 summary** plus §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/changing-places-toilets-kent-coast-days-out/`.
- **P4 Step C (2026-05-11):** `/personal-budget-short-break-care-act/` H1 and H2 ladder in §13.1 **H1 / H2 summary** plus §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/personal-budget-short-break-care-act/`.
- **P4 Step C (2026-05-11):** `/fatigue-friendly-whitstable-coastal-day/` H1 and H2 ladder in §13.1 **H1 / H2 summary** plus §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/fatigue-friendly-whitstable-coastal-day/`.
- **P4 Step C (2026-05-11):** `/hire-mobility-scooter-equipment-uk-holiday/` H1 and H2 ladder in §13.1 **H1 / H2 summary** plus §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/hire-mobility-scooter-equipment-uk-holiday/`.
- **P4 Step C (2026-05-11):** `/privacy-policy/` H1 and H2 ladder in §13.1 **H1 / H2 summary** plus §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/privacy-policy/`.
- **P4 Step C (2026-05-11):** `/terms-and-conditions/` H1 and H2 ladder in §13.1 **H1 / H2 summary** plus §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/terms-and-conditions/`.
- **P4 Step C (2026-05-11):** `/accessibility-policy/` H1 and H2 ladder in §13.1 **H1 / H2 summary** plus §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/accessibility-policy/`.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/privacy-policy/](https://restwellretreats.co.uk/privacy-policy/)

**Source:** §13.1 row for this URL; Step A keywords in `#### Run - 2026-05-10 - template-privacy-policy.php` and legal trio `#### Run - 2026-05-10 - Legal policies trio` pillar A (§2.6); AEO tables in both runs (five questions each, merged without inventing processors beyond theme). **Repo:** `template-privacy-policy.php`; `template-parts/legal-policy-layout.php`; `restwell_get_privacy_policy_content()` in `inc/theme-setup.php` (Confirm in WP: `legal_body_html` overrides).

**Scope:** Legal privacy notice only, plain English, no marketing tone. **Banned phrase:** not used. **Facts:** stick to theme default sections (controller, enquiry fields, lawful bases, cookies and GA4 with consent, sharing with Continuity of Care when agreed, no sale, retention up to three years, UK GDPR rights, ICO link, contact email).

**Ordered outline**

1. **H1 (one):** Restwell Retreats privacy policy (UK GDPR, plain English) (echoes Primary **restwell privacy** plus **holiday cottage privacy policy UK GDPR**; Confirm in WP: single H1).
2. **H2:** What this policy covers and when it was last updated (answers AEO: What does Restwell's privacy policy cover?; supports Tier 2 **privacy policy last updated date WordPress** with visible `Last updated` when theme outputs it).
3. **H2:** Who is the data controller (answers pillar AEO: Who is the data controller for Restwell Retreats?; Tier 2 **data controller name holiday let Whitstable**).
4. **H2:** Enquiry and booking personal data we collect (answers pillar AEO: What personal data does Restwell collect on the enquiry form?; **H3** Name, email, phone; **H3** Optional care or accessibility text; **H3** Booking or payment records only as your live policy body states, Confirm in WP).
5. **H2:** Lawful bases and why we use your data (Step A **self catering guest data legitimate interests UK**; legitimate interests and contract per theme, no invented bases).
6. **H2:** Cookies, Google Analytics 4, and your choices (answers both runs' cookie question: list or categories **only** from published body; GA4 when consented; **cookie banner first visit preferences UK** Tier 2; essential cookies line per theme).
7. **H2:** Sharing data, Continuity of Care, and no sale (**H3** Continuity of Care Services when care is agreed, CQC-regulated partner framing per theme; **H3** We do not sell your personal information; **do not sell personal information UK SME** Tier 2).
8. **H2:** How long we keep enquiry and booking records (answers pillar AEO: How long does Restwell keep enquiry and booking records?; **three years** in theme default).
9. **H2:** Your UK GDPR rights, ICO, and how to contact us (answers pillar AEO: How do I contact Restwell to exercise UK GDPR rights? plus **UK GDPR subject access request holiday let** Tier 2; **ICO complaint** Tier 2; merges AEO contact-about-privacy into one practical block).
10. **H2:** Website accessibility statement and overlays (answers first-run AEO: Does Restwell use accessibility overlays? with a short honest signpost to `/accessibility-policy/`, not a second WCAG policy on this URL).
11. **H2:** Booking and cancellation rules (answers first-run AEO: Where are booking and cancellation rules?; link `/terms-and-conditions/` only, no merged contract text).

**Step A echo:** restwell privacy, holiday cottage privacy policy UK GDPR, self catering guest data legitimate interests UK, holiday let cookies Google Analytics 4 consent UK, care partner data sharing CQC privacy notice UK (signpost depth, no care outcome claims).

**Avoid-ai-writing self-check:** Legal nouns, short clauses, no stacked praise, no fake urgency, ASCII hyphens and commas only (no Unicode em dash).

**PHP:** none until editor maps H2 bands into WP blocks; fallback HTML order in `restwell_get_privacy_policy_content()` may differ from this ladder.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/terms-and-conditions/](https://restwellretreats.co.uk/terms-and-conditions/)

**Source:** §13.1 row for this URL; Step A Tier 1 to 2 and AEO table in `#### Run - 2026-05-10 - template-terms-and-conditions.php` (`/terms-and-conditions/`, §2.6 ~3898 to ~3959); legal trio depth refresh `#### Run - 2026-05-10 - Legal policies trio` (booking, deposit, balance six weeks, BACS and card, cancellation tiers, equipment and hoist, dogs, optional care); `#### Step B - 2026-05-11` same URL. **Repo:** `template-terms-and-conditions.php` (loads `template-parts/legal-policy-layout.php`); default body `restwell_get_terms_conditions_content()` in `inc/theme-setup.php` (Confirm in WP: `legal_body_html` or blocks may reorder or retitle sections).

**Scope:** Contract copy for Whitstable-area adapted self-catering bookings, deposits, cancellations, guest duties, equipment use. **Banned phrase:** not used (do not add **fully accessible**).

**Ordered outline**

1. **H1 (one):** Terms and conditions (Confirm in WP: matches hero `legal_heading` from `restwell_get_terms_conditions_page_defaults()` or editor override).
2. **H2:** What these terms cover (answers AEO: What does Restwell terms and conditions cover?; mirrors default intro themes: booking, payment, cancellation, accessibility at booking, house rules, optional care, liability).
3. **H2:** Contact about these terms (answers AEO: How do I contact Restwell about terms issues?; enquiry page and public email per default `Contact` section).
4. **H2:** Booking confirmation and availability (answers AEO: Where are booking and cancellation rules? part 1, booking; written confirmation before contract).
5. **H2:** Accessibility information at booking (early requirements disclosure; suitability checks; link out to `/accessibility/` for spec depth only).
6. **H2:** Deposits, balance, and payment methods (Step A **restwell terms bookings payments**, **booking deposits cancellations accessible stay**; BACS and card; balance no later than six weeks before arrival unless agreed otherwise in writing, per theme default).
7. **H2:** Cancellations, refunds, and travel insurance (answers AEO: Where are booking and cancellation rules? part 2, money bands; more than 30 days full refund, 14 to 30 days fifty per cent, fewer than 14 days no refund, per theme default; insurance nudge; Confirm in WP live bands).
8. **H2:** Medical or care emergencies and evidence (Step A **medical cancellation evidence accessible accommodation UK**; doctor letter example; partial refund or date change case-by-case).
9. **H2:** Date changes, early departure, no-shows, and if we cancel (combines default **Date changes**, **Early departure and no-shows**, **If we cancel** blocks).
10. **H2:** Check-in, check-out, and guest numbers (15:00, 11:00; accessibility-related time requests; max occupancy).
11. **H2:** Using accessibility equipment safely (**H3** ceiling track hoist, profiling bed, wet room per theme default sentence; safe use, faults, leave as found; **H3** measurements and PDF on `/accessibility/` and commercial proof on `/the-property/`, not duplicated here; Step A **ceiling track hoist profiling bed wet room guest responsibilities UK** legal slice only).
12. **H2:** Assistance dogs, smoking, vaping, and care of the property (dogs with notice and risk assessment; no smoking or vaping inside).
13. **H2:** Optional care via Continuity of Care Services (CQC-regulated; provider terms apply; introducer-only role for Restwell legal entity).
14. **H2:** Liability and insurance (guest insurance; negligence carve-out per default).
15. **H2:** Personal data, cookies, and related policies (**H3** `/privacy-policy/` for data and cookies, AEO: What cookies does the Restwell site use? only with content that exists there; **H3** `/accessibility-policy/` for website WCAG approach, automated plus manual testing, third-party embed limits; AEO: Does Restwell use accessibility overlays? answer with that page facts only, Confirm in WP; property WCAG is not this URL primary).

**Step A echo:** `restwell terms`, `restwell terms bookings payments`, `restwell terms cancellations`, `booking deposits cancellations accessible stay`, `accessible holiday cottage cancellation policy 30 14 days UK` (numbers in body only when WP matches theme defaults), hoist guest duties split from spec URLs.

**Avoid-ai-writing self-check:** Plain legal labels, no hype, no hollow intensifiers, ASCII hyphens and colons only, YMYL cross-links named as policies not sales copy.

**PHP:** none until human maps headings into WP `legal_body_html` or blocks; rename default `h2` strings in `restwell_get_terms_conditions_content()` only after editor sign-off so live WP stays source of truth.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/fatigue-friendly-whitstable-coastal-day/](https://restwellretreats.co.uk/fatigue-friendly-whitstable-coastal-day/)

**Source:** §13.1 row for this URL; Step A Tier 1 to 2 and AEO table in `#### Run - 2026-05-10 - https://restwellretreats.co.uk/fatigue-friendly-whitstable-coastal-day/` (§2.6, lines ~3775 to ~3827); `#### Step B - 2026-05-11` same URL. **Repo:** `page.php`; body HTML from `restwell_get_blog_post_fatigue_friendly_coastal_day_html()` in `inc/seo-content-seed-blog-cluster-b.php` (Confirm in WP: live blocks may reorder headings).

**Scope:** Low-energy Whitstable-area coastal day pacing with sensory load awareness; no invented promenade equipment or hoist coverage beyond Restwell stay bridge in FAQ seed line. **Banned phrase:** not used.

**Ordered outline**

1. **H1 (one):** Fatigue-friendly Whitstable coastal day: low-energy Kent coast pacing (echoes Step A primary `fatigue friendly whitstable coastal day` plus Kent modifier row; Confirm in WP: hero or first band shows this once).
2. **H2:** What counts as a fatigue-friendly Whitstable coastal day? (answers AEO: What is fatigue friendly whitstable coastal day?; aligns seed block **What is a fatigue-friendly coastal plan?**).
3. **H2:** Who this pacing pattern is for (answers AEO: Who is fatigue friendly whitstable coastal day for?; MS, long COVID, chronic pain, post-stroke limits, neurodivergent masking costs per seed lede themes).
4. **H2:** How to plan the day in timed blocks (answers AEO: How do I plan fatigue friendly whitstable coastal day?; seed **Pacing pattern** table, 90-minute block idea in the opening summary block).
5. **H2:** Why wind, glare, and coast surfaces tax energy (answers sensory load intent in Step B meta; seed **Why the coast deceives energy budgets**: wind, shingle, social load).
6. **H2:** Sensory tweaks (seed **Sensory tweaks**; **H3** Glare; **H3** Noise; **H3** Pain supports).
7. **H2:** Check these links before you go (maps AEO planning steps to internal routes only: seed **Practical steps** list to `/quieter-times-whitstable-low-crowd-access/`, `/accessible-beaches-coastal-walks-kent/`, `/what-to-pack-accessible-self-catering-uk/`, `/holiday-backup-plan-care-worker-change/`; parking or train depth stay on their guides).
8. **H2:** What papers or panels to line up (answers AEO: What documents do I need for fatigue friendly whitstable coastal day?; light checklist for commissioners or carers, no invented forms; Confirm in WP if you add council-specific PDF names).
9. **H2:** Where direct payments or CHC sit beside a day out (answers AEO: Where does fatigue friendly whitstable coastal day overlap with direct payments or CHC?; signpost `/resources/` and funding slugs only, no eligibility outcomes).
10. **H2:** Common mistakes (seed list).
11. **H2:** Frequently asked questions (seed FAQ topics; **H3** Electric chairs and wind; **H3** Mobility scooters on paths; **H3** Naps after lunch; **H3** Teenagers and pace; **H3** Does Restwell suit low-energy days? with link to `/enquire/` and layout questions only, hoist or wet room proof on `/accessibility/`).
12. **H2:** Next reads (seed **Closing** link to `/blog/`).

**Step A echo:** `fatigue friendly whitstable coastal day`, `fatigue friendly whitstable coastal day kent`, checklist or parking or train secondaries satisfied by internal links under H2 7, not new H2 spam.

**Avoid-ai-writing self-check:** Short labels, concrete nouns (wind, shingle, blocks), no hollow superlatives, ASCII hyphens only, YMYL deferral on funding lines.

**PHP:** none until human maps H2 order into WP blocks; seed heading text can be renamed to match this ladder without changing facts.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/personal-budget-short-break-care-act/](https://restwellretreats.co.uk/personal-budget-short-break-care-act/)

**Source:** §13.1 row for this URL; Step A Tier 1 and 2 keywords in `#### Run - 2026-05-10 - https://restwellretreats.co.uk/personal-budget-short-break-care-act/` (§2.6: primary `personal budget short break care act`, splitting receipts, audit, DP versus PB, LA short breaks); AEO question tables in that run (first five-row block) plus the second five-row AEO block in the companion same-URL run later in the plan file (receipt splits, audit clean, accommodation alone, DP comparison, multi-agency sign-off). **Repo:** `page.php`; seed `inc/seo-content-seed.php` slug `personal-budget-short-break-care-act`; body HTML from `restwell_get_blog_post_personal_budget_short_break_html()` in `inc/seo-content-seed-blog-cluster-a.php` (Confirm in WP: live blocks override seed).

**Scope:** Care Act personal budget mechanics for short breaks, receipt discipline, not legal advice. **Facts:** General guide only; equipment lines echo seed meta (hoist, profiling bed, wet room) for Whitstable-area bridge, not new kit claims. **Banned phrase:** not used.

**Ordered outline**

1. **H1 (one):** Care Act personal budget short breaks: split PA hours, accommodation, and travel receipts (echoes Step A primary and seed receipt split theme; Confirm in WP: one visible H1 matches hero or first band).
2. **H2:** What this means under the Care Act (answers AEO: What is personal budget short break care act?; short definition; defer to local authority wording for eligibility).
3. **H2:** Who should use this guide (answers AEO: Who is personal budget short break care act for?; carers, families, commissioners, funding-aware bookers).
4. **H2:** Plan the break before invoices stack (answers AEO: How do I plan personal budget short break care act?; ordered steps, LA checks).
5. **H2:** How to split PA hours, travel, and self-catering lodging (answers AEO: How should I split receipts between PA hours, travel, and accommodation on a Care Act short break?; table H3 when helpful).
6. **H2:** Can accommodation sit alone on a personal budget line? (answers AEO: Can a personal budget pay for accommodation on its own?; careful paragraph, no invented council rules).
7. **H2:** Documents and habits that keep post-trip audits clear (answers AEO: What documents do I need for personal budget short break care act? plus What makes a personal budget audit clean after a self-catering holiday?; checklist plus panel discipline language).
8. **H2:** Direct payment versus personal budget on one trip (answers AEO: What is the difference between a direct payment and a personal budget for a short break?; link `/direct-payment-holiday-accommodation/` for mechanism depth).
9. **H2:** Who signs off when several agencies are involved (answers AEO: Who signs off a short break plan under the Care Act if several agencies are involved?; link `/commissioner-checklist-accessible-respite-stay/`; general framing only).
10. **H2:** How this sits beside CHC, direct payment holidays, and the Kent funding hub (answers AEO: Where does personal budget short break care act overlap with direct payments or CHC?; signpost `/resources/`, `/chc-respite-holiday-accommodation-uk/`, DP URL; no duplicated eligibility outcomes).
11. **H2:** Whitstable-area self-catering at Restwell (seed meta bridge: hoist, profiling bed, wet room; Confirm in WP wording; `/accessibility/`, `/the-property/`, `/enquire/`).

**Step A echo:** `personal budget short break care act`, `personal budget short break self catering`, splitting PA hours accommodation transport receipts, retrospective audit clean social care finance holiday, direct payment versus personal budget same trip.

**Avoid-ai-writing self-check:** Concrete section jobs, YMYL signposting, LA deferral where rules vary, ASCII hyphens only, no hype stackers.

**PHP:** none until human maps H2 bands into WP blocks; seed HTML remains source for bulk copy edits.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/blog/](https://restwellretreats.co.uk/blog/)

**Source:** §13.1 row for `/blog/`, Step A keywords in `#### Run - 2026-05-10 - index.php` and `#### Run - 2026-05-11 - /blog/` (`index.php`) in §2.6, AEO table `#### Run - 2026-05-11 - /blog/` §2.0 (six questions), plus guest-guide split from paired outline `#### Run - 2026-05-10 - /blog/` plus `/guest-guide/`.

**Scope:** `index.php` posts index, optional `page_for_posts` title or excerpt. **Facts:** Default strings include `Guides & articles`, practical guides to accessible travel on the Kent coast, `From the blog`; guest guide uses `page-guest-guide.php` and is not the public blog index. **Banned phrase:** not used.

**Ordered outline**

1. **H1 (one):** Accessible travel guides for the Kent coast and Whitstable area (echoes Tier 1 hub `accessible travel` plus Step A coast or Whitstable phrases; Confirm in WP: hero matches one visible H1, not a second line competing with home).
2. **H2:** What this hub covers (answers: what does the Restwell blog cover; short paragraph plus bullets: planning, area notes, funding news in posts when published).
3. **H2:** Who these posts are for (answers: who are the stories for; guests with disabilities, carers, commissioners per seed meta themes; Confirm in WP if you tighten wording).
4. **H2:** How this hub differs from home, property pages, and the guest guide (answers: blog versus property or booking pages, plus blog versus guest guide; public editorial index versus booking-first `/` or `/the-property/`; guest guide is post-booking, OTP-gated, `noindex, follow` per theme routing).
5. **H2:** CHC, direct payments, and funded breaks - where to read deeper (answers: where should I read about CHC or direct payments; numbered signpost only: `/resources/` then cluster URLs; no duplicated eligibility promises on the hub).
6. **H2:** Kent coast topics we post about (answers: what Kent coast topics do posts tackle; **H3** beaches and coastal walks; **H3** trains and connections; **H3** eating out; **H3** parking and drop-off; **H3** quieter visits or fatigue-friendly days when posts exist; Confirm in WP slugs live versus `inc/seo-content-seed.php`).
7. **H2:** Choose self-catering without kit surprises (answers: how to plan without equipment surprises; one CTA line to `/how-to-choose-accessible-self-catering-holiday/`; hoist type and widths on `/accessibility/` and `/the-property/` only).
8. **H2:** Browse the guides (featured first post, grid, pagination; **H3** Category, tag, or date archives when you need a narrower slice, per `index.php`; Confirm in WP: posts page in Reading settings).

**Step A echo:** `accessible travel`, Kent coast guides, practical guides accessible travel kent coast, guides articles blog index, secondaries in §13.1 row (hoist or wet room pack for SERP fields, not a duplicate spec H1).

**Avoid-ai-writing self-check:** Concrete routes and page names, cautious YMYL signposting, no filler stackers, ASCII hyphens only.

**PHP:** none until human maps H2 bands into WP blocks or template; `index.php` hero already outputs one heading from posts page or defaults.

#### URL [https://restwellretreats.co.uk/](https://restwellretreats.co.uk/) (`front-page.php`) - 2026-05-10

- **P4 Step A:** Primary `accessible holidays whitstable` (default H1 stem `Accessible Holidays in Whitstable, Kent`, `inc/seo-content-seed.php` focus_keyphrase). Secondaries: `accessible self catering whitstable kent`, `wheelchair accessible holiday whitstable`, `whole property accessible holiday whitstable`, `accessible kent coast holiday bungalow`, `restwell retreats whitstable` (nav). LSI or entities: self-catering bungalow (meta or FAQ or schema, not hero lede default), adapted bungalow, bedroom ceiling track hoist, profiling bed, roll-in wet room, direct payments, NHS Continuing Healthcare, CQC-regulated care, Continuity of Care Services, step-free routes, Tankerton promenade. Intent: commercial investigation plus transactional entry (enquiry or property CTAs). Cannibal: keep bungalow long-story primary on `/the-property/`, Kent wheelchair cottage comparison and spec-depth primaries on `/accessibility/`, funding depth on `/resources/` and guides, coast routes on `/whitstable-area-guide/`. **Editor:** visible hero subheading in `front-page.php` defaults does not say self-catering (Confirm in WP: one short clause aligned with verified meta or FAQ if you want self-catering in above-fold body). **Do not also target** `adapted bungalow whitstable` as the homepage primary (URL `/the-property/`). **Do not also target** `wheelchair accessible holiday cottages in Kent` as the homepage primary (URL `/accessibility/`).
- **P4 Step C (2026-05-10):** First pass: H2 ladder followed PHP band order; see `#### Step C - 2026-05-10` below.
- **P4 Step C (2026-05-11):** Refresh: H2 order opens with §2.6 homepage AEO five questions, then `front-page.php` section bands; compact cell in §13.1 **H1 / H2 summary**; full ladder in `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/`.

#### Step B - 2026-05-10 - [https://restwellretreats.co.uk/](https://restwellretreats.co.uk/)

**Scope note:** Step B applies to the **homepage** (`front-page.php`, URL `/`), not `template-property.php`. Equipment wording must match verified theme copy (`inc/seo-content-seed.php` home meta, `inc/theme-setup.php` comparison rows). Use **ceiling track hoist** in publish strings, not **tracking hoist**, unless WP confirms supplier wording.

**Brand rule:** Do **not** append brand at the end of homepage titles (exception to inner pages). Yoast or Rank Math can still output site name in SERP separately if configured.

**Title variants (~50 to 60 characters; primary intent in first ~30)**

1. `Accessible Whitstable cottage: hoist, wet room (Kent)` (53 characters). Publish separators: colons as shown, or pipes if the SEO plugin prefers.
2. `Self-catering Whitstable Kent: hoist, bed, wet room` (51 characters).
3. `Disabled-access cottage Whitstable: hoist and wet room` (54 characters).

**Meta description variants (~150 to 160 characters; benefit, keywords, one CTA)**

1. `Accessible self-catering Whitstable, Kent: bedroom ceiling track hoist, profiling bed, wet room. Quiet area, whole-property booking. Ask availability.` (150 characters).
2. `Kent coast self-catering Whitstable: ceiling track hoist, profiling bed, wet room. Whole-property cottage for families and carers. Enquire for availability.` (156 characters).
3. `Disabled-access cottage Whitstable: ceiling track hoist, profiling bed, wet room. Private self-catering. Optional CQC-regulated care. No obligation to book.` (156 characters).

**Recommended pick:** Title **1** + Meta **1**. **Rationale:** Title leads with accessible plus Whitstable plus cottage within the first thirty characters, names hoist and wet room without adding unverified kit, and tags Kent in parentheses for county intent without stuffing. Meta repeats verified phrases from the home seed (bedroom ceiling track hoist, profiling bed, wet room), adds the quiet-location USP in plain words, states whole-property booking, and uses a direct CTA without hype.

**Runner-up pair:** Title **2** + Meta **2** (stronger **accessible self catering Kent coast** and ceiling-track wording for users who search coast-first).

**Step B vs Step A / brief:** §13.1 **Primary** remains Step A `accessible holidays whitstable`. This Step B pass weaves the brief phrase **accessible holiday cottage hoist and wet room Whitstable Kent** across titles and metas in shortened, natural form; confirm in Search Console before changing the worksheet Primary cell.

**Human next:** Paste chosen title and meta into WP Search and Social fields. **Do not** edit `inc/seo.php` until a human confirms.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/](https://restwellretreats.co.uk/)

**Scope:** `front-page.php`, URL `/`. **Facts:** Hoist scope stays **bedroom ceiling track** in theme defaults (not whole-property hoist); kit list matches FAQ and highlight seeds (`inc/seo.php`, `inc/theme-setup.php`). **Banned phrase:** not used.

**Ordered outline (H1, then H2, then H3):**

1. **H1:** Accessible holidays in Whitstable, Kent (matches `hero_heading` default in `front-page.php`; Confirm in WP if editors changed casing or added a second line).
2. **H2:** What Restwell is in Whitstable (answers §2.6 AEO: what is Restwell Retreats in Whitstable; adapted bungalow, whole-property booking, hero lede from meta).
3. **H2:** Self-catering and hoist in Whitstable (answers wheelchair-accessible self-catering with hoist; **H3** Bedroom ceiling track hoist scope, **H3** Profiling bed and roll-in wet room, CTA to `/accessibility/` for measurements and PDF).
4. **H2:** Direct payments or NHS Continuing Healthcare (answers funding toward a stay; **H3** Plain-English teaser, **H3** Link to `/resources/` and cluster guides, no outcome promises beyond theme FAQ).
5. **H2:** Whole property for a guest and carer (answers how to book whole property; **H3** Enquiry-first steps, **H3** Property and enquire CTAs from hero defaults).
6. **H2:** Equipment included at Restwell (answers kit list; bullets from verified homepage FAQ slice, link `/accessibility/` and `/the-property/` for depth).
7. **H2:** Area and funding (matches home teaser band; **H3** Whitstable and the Kent coast, **H3** Funding your stay).
8. **H2:** Two people, one break (who band; **H3** For the guest, **H3** For the carer).
9. **H2:** Our Whitstable home (property spotlight).
10. **H2:** What guests say (if block has quotes; hide if empty in WP).
11. **H2:** Why choose Restwell for your accessible break (value props; **H3** Private and personal, **H3** Professional support on your terms, **H3** Local knowledge, **H3** Honest and open).
12. **H2:** Specialist partners.
13. **H2:** Restwell vs a typical hotel stay (comparison table).
14. **H2:** Need exact access details first (mid-page CTA to specs).
15. **H2:** Common questions (homepage FAQ subset from `restwell_get_faq_items( 'homepage' )`; Confirm in WP: order and which seven).
16. **H2:** Care on your terms (trust strip, CQC-regulated partner line per theme defaults).
17. **Optional H2:** Only if `hero_spec_heading` is set in WP and text is verified (no new kit claims in this plan).

**Step A alignment:** Primary `accessible holidays whitstable` sits on H1; secondaries surface in H2 2 to 7 (self-catering Whitstable Kent, wheelchair accessible holiday, whole property, Kent coast bungalow, brand plus place in H2 1 and trust).

**Human next:** Map headings to visible WP blocks or ACF; keep hoist wording as **ceiling track** in publish unless WP confirms tracking.


#### Step D - 2026-05-25 - [https://restwellretreats.co.uk/](https://restwellretreats.co.uk/)

**Scope:** `front-page.php`, URL `/`. **Primary snippet query:** `accessible holidays whitstable` (§13.1 Primary). **JSON-LD path:** `inc/seo.php` → `restwell_output_jsonld_homepage_faq()`; visible FAQ section uses `restwell_get_faq_items( 'homepage' )` (first seven items on the FAQ template page). **Banned phrase:** not used. **Punctuation:** ASCII hyphens only.

**Featured snippet paragraph (40-55 words, target: accessible holidays whitstable)**

Place directly under the H1 band or in the first answer block for "What Restwell is in Whitstable" (§4.1 Step C H2). Word count: 52.

> Restwell Retreats is a wheelchair-accessible self-catering bungalow in Whitstable, Kent. You book the whole property for a coastal break. The accessible bedroom has a ceiling track hoist, profiling bed, and roll-in wet room on one level. Optional CQC-regulated care is available through our partner. Enquire for availability.

**Homepage FAQ pairs (5, align FAQ page items 1-5 in WP for homepage + JSON-LD parity)**

| # | Question (H3 or accordion summary) | Answer (publish, ≤80 words) |
|---|--------------------------------------|-----------------------------|
| 1 | What is Restwell Retreats in Whitstable? | Restwell Retreats is a private wheelchair-accessible self-catering holiday bungalow in Whitstable, Kent. You book the whole property for guests, families, and carers. Care is optional and arranged separately through Continuity of Care Services (CQC-regulated); it is not included in the rental. |
| 2 | Is there wheelchair accessible self catering in Whitstable with a hoist? | Yes. Restwell is a single-storey adapted bungalow with a ceiling track hoist in the accessible bedroom, a profiling bed, and a roll-in wet room on the same level. Check measurements and equipment on our [Accessibility](/accessibility/) page before you book. |
| 3 | Can I use direct payments or NHS Continuing Healthcare toward a stay at Restwell? | Many guests use personal budgets or direct payments, subject to your care plan. NHS Continuing Healthcare for care during your stay depends on your package: speak to your case manager. We can provide documentation to support applications. See [Funding & Support](/resources/) for routes in plain English. |
| 4 | How do I book the whole property for a guest and carer? | Start with our [enquiry form](/enquire/) or contact us by phone or email. We confirm availability, talk through access needs, then agree dates. There is no obligation until you are ready. Cancellation terms depend on how close your stay is; we confirm the policy when you book. |
| 5 | What accessibility equipment is included at Restwell? | The accessible bedroom has a ceiling track hoist and profiling bed. The wet room has roll-in shower access, grab rails, and a height-adjustable washbasin. Level access and two off-road parking spaces are on the private drive. Full detail is on [Accessibility](/accessibility/). |

**Avoid-ai-writing self-check:** Plain verbs, no empty intensifiers, no template transitions, no promotional stackers, no em dash, no banned phrase.

**JSON-LD FAQPage (mirror visible homepage FAQ items; strip HTML in output)**

```json
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "What is Restwell Retreats in Whitstable?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Restwell Retreats is a private wheelchair-accessible self-catering holiday bungalow in Whitstable, Kent. You book the whole property for guests, families, and carers. Care is optional and arranged separately through Continuity of Care Services (CQC-regulated); it is not included in the rental."
      }
    },
    {
      "@type": "Question",
      "name": "Is there wheelchair accessible self catering in Whitstable with a hoist?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes. Restwell is a single-storey adapted bungalow with a ceiling track hoist in the accessible bedroom, a profiling bed, and a roll-in wet room on the same level. Check measurements and equipment on our Accessibility page before you book."
      }
    },
    {
      "@type": "Question",
      "name": "Can I use direct payments or NHS Continuing Healthcare toward a stay at Restwell?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Many guests use personal budgets or direct payments, subject to your care plan. NHS Continuing Healthcare for care during your stay depends on your package: speak to your case manager. We can provide documentation to support applications. See Funding and Support for routes in plain English."
      }
    },
    {
      "@type": "Question",
      "name": "How do I book the whole property for a guest and carer?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Start with our enquiry form or contact us by phone or email. We confirm availability, talk through access needs, then agree dates. There is no obligation until you are ready. Cancellation terms depend on how close your stay is; we confirm the policy when you book."
      }
    },
    {
      "@type": "Question",
      "name": "What accessibility equipment is included at Restwell?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "The accessible bedroom has a ceiling track hoist and profiling bed. The wet room has roll-in shower access, grab rails, and a height-adjustable washbasin. Level access and two off-road parking spaces are on the private drive. Full detail is on the Accessibility page."
      }
    }
  ]
}
```


**Implementation (2026-05-25):** Homepage FAQ copy ships in `inc/homepage-faq.php` (`restwell_get_homepage_faq_defaults()`). `restwell_get_faq_items( 'homepage' )` in `inc/faq.php` returns code defaults only. Visible accordion and FAQPage JSON-LD both read the same array (`answer_html` / `answer_text`). Front page `home_faq_1_q` through `home_faq_7_a` are redundant for FAQ body copy (section label/heading meta still used).
**Human next:** Deploy theme; optional: add featured snippet paragraph to hero lede or new ACF field in WP. FAQ page `faq_1`..`faq_14` still powers `/faq/` and How It Works only.

#### Step C - 2026-05-10 - [https://restwellretreats.co.uk/](https://restwellretreats.co.uk/)

*Archive of first Step C pass (band-first order); use **Step C - 2026-05-11** as the current structural source.*

- **H1:** Accessible Holidays in Whitstable, Kent (theme default).
- **H2:** Area and funding (H3 Whitstable and the Kent coast, H3 Funding your stay).
- **H2:** Two people, one break (H3 For the guest, H3 For the carer).
- **H2:** Our Whitstable home.
- **H2:** What guests say.
- **H2:** Why choose Restwell for your accessible break (H3 Private and personal, H3 Professional support on your terms, H3 Local knowledge, H3 Honest and open).
- **H2:** Specialist Partners.
- **H2:** Restwell vs a typical hotel stay.
- **H2:** Need exact access details first?
- **H2:** Common questions.
- **H2:** Care on your terms.
- Optional: sr-only equipment H2 if `hero_spec_heading` set, verified copy only.

#### Step B - 2026-05-11 - [https://restwellretreats.co.uk/the-property/](https://restwellretreats.co.uk/the-property/)

**Scope:** `template-property.php` (`/the-property/`). **Facts:** Hoist, profiling bed, and wet room wording follows theme normalised accessibility list (ceiling track hoist in the accessible bedroom; wet room with roll-in shower, grab rails, adjustable washbasin; adjustable profiling bed). **Banned phrase:** not used. **Hoist SERP note:** Secondaries include `tracking hoist holiday accommodation`; publish strings use **ceiling track hoist** unless WP or supplier copy confirms tracking.

**Title variants (~50 to 60 characters with trailing brand)**

1. `Accessible Whitstable: hoist, wet room - Restwell Retreats` (58 characters). Primary intent in the opening segment: accessible, Whitstable, hoist, wet room.
2. `Adapted bungalow Whitstable: hoist, wet room - Restwell Retreats` (64 characters). Stronger Step A commercial anchor `adapted bungalow whitstable`.
3. `Self-catering Whitstable: hoist, wet room - Restwell Retreats` (61 characters). Leads self-catering plus Whitstable for Kent coast bookers; weaker on the word accessible in the first segment.

**Meta description variants (~150 to 160 characters)**

1. `Adapted bungalow Whitstable area, Kent: ceiling track hoist, profiling bed, roll-in wet room. Quiet self-catering for families. Read specs on-page, then enquire.` (153 characters).
2. `Accessible self-catering Kent coast near Whitstable: bedroom ceiling track hoist, profiling bed, wet room. Door widths on-page. Enquire for availability.` (153 characters).
3. `Disabled-access cottage Whitstable area: ceiling track hoist, profiling bed, roll-in wet room. Quiet Kent coast self-catering. See specs, then book direct.` (155 characters).

**Recommended pick:** Title **1** plus Meta **1**. **Rationale:** Title **1** keeps accessible, Whitstable, hoist, and wet room early without copying the `/accessibility/` worksheet title pattern (`Accessible cottage hoist & wet room Kent`). Meta **1** states adapted bungalow plus Kent, names hoist and wet room in the same language as the template list, adds the quiet self-catering USP, and pushes spec-then-enquire behaviour before deposit.

**Human next:** Paste into WP. **Do not** edit `inc/seo.php` until a human confirms.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/the-property/](https://restwellretreats.co.uk/the-property/)

**Scope:** `template-property.php`, defaults in `restwell_get_property_page_defaults()` (`inc/theme-setup.php`). **Banned phrase:** not used. **Hoist:** theme uses **ceiling track hoist** in the accessible bedroom; do not imply whole-property hoist coverage. **Avoid-ai-writing pass:** plain section labels, short clauses, no filler stack, ASCII hyphens only.

**H1 (one only):** Our accessible home in Whitstable (`prop_hero_heading`; Confirm in WP if hero overrides). Subtitle already carries adapted home plus hoist, profiling bed, wet room (`prop_hero_subtitle`).

**H2 and H3 (ordered; AEO from §2.6 `#### Run - 2026-05-10 - template-property.php` maps to template bands)**

1. **H2:** Everything you need. Nothing you don't (`prop_home_heading`). **AEO:** What equipment and layout cues matter before booking (step-free, sleeps up to five, quiet street). **H3:** Step-free throughout. **H3:** Flexible sleeping setup (up to five). **H3:** Quiet location.
2. **H2:** Thoughtful at every turn (`prop_dignity_heading`). **AEO:** What accessibility equipment is in the bungalow (summary story: roll-in wet room, ceiling track hoist in accessible bedroom, wide hallways, kitchen, garden). **H3:** Wet room and bathing. **H3:** Hoist and bedroom (bedroom-scoped track only).
3. **H2:** What's in the house (`prop_features_heading`). **AEO:** Equipment list readers can scan (hoist, wet room, profiling bed, door widths, step-free, patio, kitchen, Wi-Fi). **H3:** Ceiling track hoist (accessible bedroom). **H3:** Wet room and profiling bed. **H3:** Door clear widths (965 mm front, 926 mm internal per defaults, Confirm in WP).
4. **H2:** Honest accessibility information (`prop_acc_heading`). **AEO:** Confirmed versus still checking (TBC hoist weight limit in `prop_acc_tbc`). **H3:** Confirmed on arrival list. **H3:** Still confirming (measurements, hoist limit, local pool per defaults).
5. **H2:** A house, not a hotel room (`prop_comparison_heading`). **AEO:** Why book a whole bungalow instead of an accessible hotel room (comparison table). **H3:** A standard accessible room (left column). **H3:** Your Restwell stay (right column; optional CQC-regulated care line from theme only).
6. **H2:** Take a look around (`prop_gallery_heading`). **AEO:** Visual proof before deposit (photos, 3D, video when URLs or media exist, Confirm in WP).
7. **H2:** The basics, clearly (`prop_practical_heading`). **AEO:** How many people can stay; parking for an adapted vehicle (two on private drive; on-street note in defaults); how far is the sea (Tankerton Slopes promenade 15 min flat walk in `prop_distances`, Confirm in WP). **H3:** Bedrooms and sleeps. **H3:** Wet room pointer to `/accessibility/` for full spec. **H3:** Parking. **H3:** Distances.
8. **H2:** Explore Whitstable (`prop_nearby_heading`). **AEO:** Nearby flat routes and venue access notes (defaults name pubs and promenade; Confirm in WP for live venue access).

**Internal links:** Practical and confirmed bands should point commissioners and OTs to `/accessibility/` for PDF or measurements; funding questions to `/resources/`; booking to `/enquire/` (matches template CTAs).

#### Step B - 2026-05-11 - [https://restwellretreats.co.uk/how-it-works/](https://restwellretreats.co.uk/how-it-works/)

**Scope:** `template-how-it-works.php` (`/how-it-works/`). **Facts:** Four-step defaults (Get in touch, Plan your stay, Arrange support if needed with optional Continuity of Care Services CQC-regulated or bring carer or PA, Arrive and enjoy); whole-bungalow copy in included cards; FAQs pulled from `restwell_get_faq_items` (same source as `/faq/`, including cancellation policy text in theme defaults). **Banned phrase:** not used. **Hoist wording:** secondaries include tracking hoist SERP phrase; publish strings use **ceiling track hoist** where hoist type is named (meta variant M2).

**Title variants (~50 to 60 characters, brand suffix on inner page)**

1. `Whitstable accessible stay: 4 steps - Restwell Retreats` (55 characters).
2. `Accessible cottage Whitstable: 4 steps - Restwell Retreats` (58 characters).
3. `Hoist Whitstable stay: 4-step booking - Restwell Retreats` (57 characters).

**Meta description variants (~150 to 160 characters)**

1. `Whitstable accessible stay: 4 steps to book, optional care or PA. FAQ for deposits and cancellation. Hoist, profiling bed, wet room on accessibility. Enquire.` (158 characters).
2. `Kent coast self-catering near Whitstable: 4 steps, optional care or PA. FAQ on deposits and cancellation. Ceiling track hoist, wet room: accessibility. Enquire.` (160 characters).
3. `Disabled-access Whitstable, Kent: 4 enquiry steps, optional care or PA. FAQ for deposits and cancellation. Hoist and wet room on accessibility. Enquire.` (152 characters).

**Recommended pick:** Title **2** plus Meta **1**. **Rationale:** Title **2** gets **accessible cottage** and **Whitstable** into the first segment without copying `/accessibility/` or `/the-property/` title shapes, and signals the booking explainer with **4 steps**. Meta **1** states the numbered journey, optional care or PA in plain words, points anxiety on money and cancellation to the FAQ (where `faq_11` defaults live), names hoist plus profiling bed plus wet room as on-page signposts to `/accessibility/`, and ends with a direct **Enquire** CTA. **Voice:** short clauses, no filler, no invented kit beyond theme-backed USPs.

**Human next:** Paste chosen title and meta into WP Search and Social. **Do not** edit `inc/seo.php` until a human confirms.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/how-it-works/](https://restwellretreats.co.uk/how-it-works/)

**Scope:** `template-how-it-works.php`, defaults in `restwell_get_how_it_works_page_defaults()` (`inc/theme-setup.php`). **Banned phrase:** not used. **Avoid-ai-writing pass:** plain labels, short clauses, no filler stack, ASCII hyphens only. **Facts:** Four-step band, optional Continuity of Care Services (CQC-regulated) or bring your own carer or PA in step copy; included grid and FAQ pull from theme (`restwell_get_faq_items`). **Confirm in WP:** hero `hiw_heading` may still read `How it works`; align publish H1 with this ladder or keep seed and match H2s only. Step titles in PHP fallbacks (`Plan your stay`, `Arrange support (if needed)`) can differ from `restwell_get_how_it_works_page_defaults()` (`We'll call you back`, `Confirm your booking`); use one set sitewide after editor pass. **Confirm in WP:** reply timing lines match `/enquire/` (one to two working days) versus HIW step 2 default (48 hours) before publish.

**H1 (one only):** How your accessible stay at Restwell works (enquiry to arrival). **AEO map:** answers "How does booking an accessible stay at Restwell work?" without duplicating the title tag verbatim.

**H2 and H3 (ordered; mirrors §2.6 `#### Run - 2026-05-10 - template-how-it-works.php` Tier 1 to 2 keywords and AEO table §2.3 questions)**

1. **H2:** Four steps to your stay (`hiw_steps_heading` default in `restwell_get_how_it_works_page_defaults()`; Confirm in WP). **AEO:** numbered journey, `four steps accessible booking restwell`, `accessible stay process`. **H3:** Get in touch. **H3:** We'll call you back (property fit, questions; reply timing Confirm in WP). **H3:** Confirm your booking (deposit; care arrangements with Continuity of Care Services if required, per theme-setup default). **H3:** Arrive and rest easy (handover; house is yours).
2. **H2:** Is care required when you book? **AEO:** clear no unless you want it; `optional cqc regulated care continuity restwell`, `optional cqc regulated care holiday`, bring your own carer or PA. **H3:** Optional Continuity of Care Services (Kent, CQC-regulated; theme default). **H3:** Bring your own carer or PA (step copy allows this path).
3. **H2:** What is included in the house? **AEO:** bullet-friendly list; `linen towels wifi parking included restwell`, `welcome pack tea coffee restwell`, `exclusive use whole house accessible holiday` (no shared spaces in template defaults). **H3:** Linen, towels, welcome pack, kitchen, garden, Wi-Fi, parking (card labels from template; Confirm in WP overrides). **H3:** Hoist, profiling bed, wet room depth stays on `/accessibility/` (cannibal guard from §2.6).
4. **H2:** Deposits, changes, and cancellation. **AEO:** PAA-style deposits and cancellations; `deposit booking confirmation accessible stay`; link or embed FAQ lines from shared FAQ source (theme `faq_11` and related, Confirm in WP visible wording).
5. **H2:** When should I book? **AEO:** `how far advance book peak summer accessible`; short honest horizon (peak summer fills quickly in theme FAQ defaults, Confirm in WP).
6. **H2:** How far is the beach on foot? **AEO:** one-sentence distance; `how far property from beach tankerton` (flat walk minutes in theme-setup FAQ default, Confirm in WP). **H3:** Point to `/guest-guide/` or area guides only when those pages carry the same fact.

**Internal links:** Care detail and measurements to `/accessibility/`; property proof to `/the-property/`; enquiry to `/enquire/`; funding systems to `/resources/`; comparator framing to `/how-to-choose-accessible-self-catering-holiday/` when relevant (template already links some related guides).

#### Step B - 2026-05-11 - [https://restwellretreats.co.uk/enquire/](https://restwellretreats.co.uk/enquire/)

**Scope:** `template-enquire.php` (`/enquire/`). **Facts:** Multi-step form labels About you, Your stay, Your needs; meta keys include care, accessibility, funding, and contact preference (`enq_care`, `enq_accessibility`, `enq_funding` in template). Success copy: reply within one to two working days, often sooner; urgent path aims within one working day where possible; mail warning if auto-email fails suggests call or email if no word within 48 hours. Intro default mentions accessible holiday cottage in Kent and bathroom measurements without pressure. **Banned phrase:** not used. **Hoist wording:** secondaries include `tracking hoist holiday accommodation`; chosen title and meta use generic **hoist** plus profiling bed and wet room; T2 and M3 test **tracking hoist** phrasing only. **Confirm in WP:** ceiling track versus tracking hoist matches access statement before publish.

**Title variants (~50 to 60 characters with trailing brand)**

1. `Accessible Kent hoist cottage: enquire - Restwell Retreats` (58 characters). **Accessible**, **Kent**, and **hoist** sit inside the first thirty characters; **enquire** signals the form URL.
2. `Tracking hoist Whitstable: enquire Kent - Restwell Retreats` (57 characters). Targets the **tracking hoist holiday accommodation** secondary; weaker if you cannot verify tracking wording on site.
3. `Disabled access Whitstable enquire hoist - Restwell Retreats` (60 characters). Stronger **disabled access holiday cottage Whitstable** echo; enquire sits mid-title.

**Meta description variants (~150 to 160 characters)**

1. `Enquire: hoist, profiling bed, wet room Whitstable Kent. Accessible self-catering Kent coast. Reply in one to two working days, often sooner. Restwell Retreats.` (160 characters).
2. `Accessible Kent coast: enquire for hoist, profiling bed, wet room Whitstable. Reply in one to two working days. Form for care and access. Restwell Retreats.` (156 characters).
3. `Tracking hoist Whitstable: enquire with dates, care, and access needs. Reply one to two working days. Full specs on Accessibility page. Restwell Retreats.` (154 characters).

**Recommended pick:** Title **1** plus Meta **1**. **Rationale:** Title **1** keeps conversion intent with **enquire** while front-loading accessible, Kent, hoist, and cottage for the Step B equipment pack without copying `/accessibility/` worksheet lines. Meta **1** opens on the enquiry action, lists hoist, profiling bed, and wet room in one place (theme-backed USPs), names Whitstable Kent and accessible self-catering Kent coast, and states the honest reply window from `template-enquire.php` defaults (often sooner). **Avoid-ai-writing pass:** plain verbs, no moreover or landscape framing.

**Human next:** Paste chosen title and meta into WP Search and Social. **Do not** edit `inc/seo.php` until a human confirms.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/enquire/](https://restwellretreats.co.uk/enquire/)

**Scope:** `template-enquire.php`, `template-parts/interior-hero.php` (single page H1). **Facts:** Defaults include multi-step labels About you, Your stay, Your needs; fields for care, accessibility, funding, contact preference, urgent flag; success copy one to two working days (often sooner), urgent branch one working day where possible; mail warn if auto-email fails (48-hour follow-up). **Banned phrase:** not used. **§2.3 pillar C AEO map:** each H2 below answers one row in the plan AEO table for `/enquire/` (contact paths, booking commitment, reply speed, post-submit steps, email failure, urgent marking). **Step A echo:** contact Restwell, enquire accessible cottage Kent, accessible self catering Kent coast, Whitstable, hoist or wet room or profiling bed (signpost only here). **Confirm in WP:** published hero H1 matches proposed line; ceiling track versus tracking hoist wording stays on `/accessibility/` unless access statement confirms otherwise.

**Ordered outline (publish ladder)**

1. **H1:** Contact Restwell about accessible self-catering near Whitstable, Kent (hero `enq_heading`; only H1 on load, id `page-hero-heading`).
2. **H2:** Ways to reach us (mirrors How do I contact Restwell about a stay?) (H3 Online form anchor; H3 Phone and email from sidebar or contact block).
3. **H2:** Conversation first, not a booking commitment (mirrors Is submitting the form a booking commitment?) (pull from `enq_intro` themes: conversation, no pressure).
4. **H2:** How quickly we usually reply (mirrors How quickly will Restwell respond?) (one to two working days, often sooner; urgent path one working day where possible).
5. **H2:** What happens next after you submit (mirrors What happens after I submit an enquiry?) (H3 We review dates and availability; H3 We contact you; H3 No commitment at this stage from numbered list).
6. **H2:** If you do not hear back (mirrors What if confirmation email does not arrive?) (mail warn copy: 48 hours, call or email).
7. **H2:** Tight dates or urgent requests (mirrors Can I mark the enquiry as urgent?) (time-sensitive field and success branch; Confirm in WP field label).
8. **H2:** Send the enquiry form (default `enq_form_heading` can stay as lead line under this band or merge; H3 About you; H3 Your stay; H3 Your needs with care, accessibility, funding per template meta keys).
9. **H2:** Hoist, wet room, and profiling bed where to read detail (internal links to `/accessibility/` and `/the-property/` only; no new measurements on this URL).

**Human next:** Add WP body sections or blocks to match H2 order where the template does not yet output headings; align hero H1 with row §13.1 without adding a second H1.

#### Step B - 2026-05-11 - [https://restwellretreats.co.uk/whitstable-area-guide/](https://restwellretreats.co.uk/whitstable-area-guide/)

**Scope:** `template-whitstable-guide.php` (`/whitstable-area-guide/`). **Facts:** Pillar copy covers Whitstable town, Tankerton promenade, nearby towns, travel, buses, eating out, and access cards that describe surfaces and crowding, not blanket venue guarantees. Gorrell Tank parking and Stagecoach routes appear in template defaults. **Banned phrase:** not used. **Hoist wording:** secondary includes `tracking hoist holiday accommodation`; this URL meta uses **hoist** only and sends type detail to `/accessibility/` (`See accessibility`).

**Title variants (~50 to 60 characters with trailing brand)**

1. `Accessible Kent coast Whitstable guide - Restwell Retreats` (58 characters). Accessible and Kent coast inside the first segment; Whitstable and guide signal the local pillar.
2. `Self-catering Kent coast Whitstable guide - Restwell Retreats` (61 characters). Stronger **accessible self catering Kent coast** echo; weaker on the word **accessible** in the opening token.
3. `Disabled-access Whitstable: Kent coast guide - Restwell Retreats` (64 characters). Stronger **disabled access holiday cottage Whitstable** family phrasing; Kent coast sits after the colon.

**Meta description variants (~150 to 160 characters)**

1. `Whitstable guide: promenades, parking, buses, access notes. Quiet Restwell self-catering with hoist, profiling bed, wet room. See accessibility, enquire.` (153 characters).
2. `Accessible self-catering Kent coast, Whitstable area: Tankerton promenade, town surfaces, eating out tips. Restwell: hoist, wet room, profiling bed. Enquire.` (157 characters).
3. `Kent coast Whitstable: routes, parking, buses, disabled-access planning. Pair days out with Restwell self-catering: hoist, wet room, profiling bed. Enquire.` (156 characters).

**Recommended pick:** Title **1** plus Meta **1**. **Rationale:** Title **1** keeps the pillar as a **guide** (not a duplicate of `/the-property/`) while still opening with **accessible** and **Kent coast** for planners. Meta **1** lists on-page themes that match the template (promenades, parking, buses, access notes), carries the two USPs (quiet self-catering plus hoist, profiling bed, wet room together), and routes spec seekers to `/accessibility/` before **Enquire**, which limits invented venue access claims on this URL.

**Human next:** Paste chosen title and meta into WP Search and Social. **Do not** edit `inc/seo.php` until a human confirms.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/whitstable-area-guide/](https://restwellretreats.co.uk/whitstable-area-guide/)

**Scope:** `template-whitstable-guide.php`, URL `/whitstable-area-guide/`. **Facts:** Surfaces, slopes, crowding, named Gorrell Tank car park, Tankerton promenade, Stagecoach 400, M2 and A299 driving line, National Rail disclaimer, Plough and harbour eating copy from theme defaults only. **Banned phrase:** not used. **Hoist:** commercial bridge names hoist with profiling bed and wet room; ceiling track versus tracking wording stays on `/accessibility/` and `/the-property/` per worksheet. **Avoid-ai-writing pass:** plain labels, short clauses, no filler stack, ASCII hyphens only.

**H1 (one only):** Whitstable and Kent coast: practical local guide when accessibility shapes your plans (maps `wg_heading` intent; Confirm in WP if hero line should stay shorter).

**H2 and H3 (ordered; Step A secondaries plus §2.6 AEO rows dated 2026-05-10 for this template)**

1. **H2:** Whitstable town, harbour, and realistic pavements. **AEO:** Is Whitstable town centre workable with a wheelchair year-round? **H3** Compact centre and mostly flat routes. **H3** Uneven, narrow, or busy spots (Confirm in WP: wording matches published about body).
2. **H2:** Tankerton promenade: level seafront option. **AEO:** Most level seafront walk near Whitstable, powerchair-friendly promenade. **H3** Wide surfaced promenade. **H3** Slopes between Marine Parade and the front (stay on paved paths per defaults).
3. **H2:** Parking near town (Gorrell Tank and high street context). **AEO:** Which car park suits accessible access to the high street? **H3** Gorrell Tank call-out (Canterbury City Council pay and display in defaults). **H3** Link out to `/accessible-parking-whitstable-tankerton/` for Blue Badge and Tankerton bay detail (pillar keeps summary only).
4. **H2:** The Street shingle spit at low tide. **AEO:** Is The Street accessible? **H3** Loose shingle, not a wheelchair route (theme default warning).
5. **H2:** Getting here by car. **AEO:** How do I drive from London to Whitstable? **H3** M2 and A299, rough timing from defaults. **H3** Property parking note (off-street in template; Confirm in WP: align with `restwell_get_whitstable_guide_page_defaults()` if two spaces copy appears elsewhere).
6. **H2:** Getting here by train. **H3** Direct services named in defaults. **H3** Check National Rail or the operator before you travel (no verified platform layout on this URL).
7. **H2:** Buses, taxis, and local travel during your stay. **AEO:** Are Whitstable buses workable for wheelchairs? **H3** Stagecoach South East and route 400 toward Canterbury. **H3** Low-floor and ramp space can vary (same-day check). **H3** Book accessible taxis ahead on busy days (planning default).
8. **H2:** Nearby towns worth visiting. **AEO:** Accessible days out toward Canterbury, Faversham, Herne Bay. **H3** Canterbury (distance and flat plus cobbled caveats). **H3** Faversham market days. **H3** Herne Bay promenade note from defaults.
9. **H2:** Eating out near the property. **AEO:** What places near Restwell mention practical access? **H3** The Plough (short walk, ask us about access on arrival per default). **H3** Harbour seafood strip (ground level caveats, space at peak times). **H3** Tankerton Parade cafes (quieter cluster). **Confirm in WP:** any new venue claim before publish.
10. **H2:** Plan before you go and on the day. **H3** Before you travel (venue access checks, taxis, ask us if unsure). **H3** On the day (promenade-first routes, Gorrell Tank when harbour parking is tight, weather and tide flexibility).
11. **H2:** Local routes with practical access context. **H3** Access cards: Tankerton promenade, harbour area, town centre and Harbour Street, practical services (template four-card frame; no blanket venue guarantees).
12. **H2:** Key local areas at a glance (visual spotlight when `wg_spotlight_image_*` set in WP).
13. **H2:** Restwell base while you plan days out. **AEO:** Bridge for `accessible self catering Kent coast`, `disabled access holiday cottage Whitstable`, and hoist-led queries without spec tables. **H3** Hoist, profiling bed, wet room in one place (see `/accessibility/`). **H3** Enquire or view `/the-property/` for booking story (Confirm in WP: CTA order).
14. **H2:** Related reading. **H3** `/accessible-beaches-coastal-walks-kent/`, `/accessible-parking-whitstable-tankerton/`, `/accessible-eating-out-whitstable-kent/`, `/quieter-times-whitstable-low-crowd-access/`, `/accessible-train-travel-whitstable-kent/` as editorially relevant (not every link on every band).

**Step A alignment:** Worksheet **Primary** phrase stays the Step B commercial pack; on-page H1 leads **Whitstable**, **Kent coast**, and **guide** so `whitstable kent coast` and local Tier 1 intents stay visible without stealing `/the-property/` bungalow primaries. Secondaries (`accessible self catering Kent coast`, `disabled access holiday cottage Whitstable`, hoist bridge) surface in H2 13 and meta path, not as fake venue specs.

**Human next:** Map headings to ACF or WP blocks to match `template-whitstable-guide.php` section order where possible; keep cluster primaries on their slugs.

#### Step B - 2026-05-11 - [https://restwellretreats.co.uk/who-its-for/](https://restwellretreats.co.uk/who-its-for/)

**Scope:** `template-who-its-for.php` (`/who-its-for/`). **Step A primary:** `accessible stay suitability` (locked 2026-05-10). **Facts:** page supports guests and families, carers and support workers, OTs or case managers, and commissioners; verified wording includes ceiling track hoist in the accessible bedroom, profiling bed, wet room, funding routes, and referral documentation. **Hoist SERP note:** secondaries may include `tracking hoist holiday accommodation`, but publish strings use template-backed hoist wording unless WP confirms different supplier wording.

**Title variants (~50 to 60 characters with trailing brand)**

1. `Accessible stay suitability guide - Restwell Retreats` (53 characters). Exact Step A primary appears in the first 27 characters.
2. `Accessible stay fit: hoist, wet room - Restwell Retreats` (56 characters). Stronger equipment signal for users comparing practical fit.
3. `Respite breaks Kent: who it is for - Restwell Retreats` (54 characters). Stronger seed-title and audience-fit language, weaker on Step A primary.

**Meta description variants (~150 to 160 characters)**

1. `Accessible stay suitability for carers, families and commissioners: check hoist, profiling bed, wet room and funding routes before you enquire online.` (150 characters).
2. `Not sure Restwell fits? Compare accessible self-catering Kent coast details: ceiling track hoist, wet room, funding routes and referral notes. Enquire.` (151 characters).
3. `For families, carers, OTs and commissioners: see disabled access holiday cottage Whitstable details, hoist, wet room and funding links. Check next steps.` (153 characters).

**Recommended pick:** Title **1** plus Meta **1**. **Rationale:** Title **1** keeps the locked Step A primary exact and early, while Meta **1** adds the verified equipment and funding proof points for families, carers, and commissioners without turning this audience-fit page into the `/accessibility/` spec page.

**Human next:** Paste into WP Search and Social after review. **Do not** edit `inc/seo.php` until a human confirms.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/who-its-for/](https://restwellretreats.co.uk/who-its-for/)

**Scope:** `template-who-its-for.php`. **Step A primary:** `accessible stay suitability`. **AEO mirror:** §2.6 run **2026-05-10** table (five questions: carer, commissioner evidence, OT checks, wheelchair friendly reliability, Kent funding teaser). **Facts:** headings below follow repo defaults (ceiling track hoist in accessible bedroom, profiling bed, wet room, KCC Adult Social Care, Care and Support Assessment, Continuity of Care Services as CQC-registered provider connection). **Banned phrase:** not used. **Publish note:** current PHP uses persona titles as cards; this ladder is the SEO target order for a future editorial pass or hero override (Confirm in WP: `wif_heading` if H1 should stay shorter).

**Ordered outline**

1. **H1:** Accessible stay suitability: who Restwell is for (one H1; carries Step A primary, matches audience-fit goal).
2. **H2:** Who is Restwell for if you are a carer? **H3:** Care Act Carer's Assessment and council route; separate sleeping area for support worker; wet room for assisted personal care; CTA to suitability questions or `/enquire/` per template defaults.
3. **H2:** What evidence do commissioners need for a funded stay? **H3:** Property specification, access measurements, equipment inventory, written CQC-registered provider confirmation (template default bullets); hand off depth to `/commissioner-checklist-accessible-respite-stay/` and `/resources/` where relevant.
4. **H2:** What should an OT check before recommending Restwell? **H3:** Doorway widths, turning circles, hoist specs, wet room dimensions (published on `/accessibility/`); transfer clearances on request; referral before commitment.
5. **H2:** Is wheelchair friendly wording reliable for holiday cottages? **H3:** Guests and families band: plain warning on loose marketing language; ceiling track hoist already fitted, wet room with roll-in shower; read accessibility specification CTA to `/accessibility/`.
6. **H2:** How does funding work for a short break in Kent? **H3:** Care and Support Assessment framing; Kent County Council Adult Social Care; three routes: local authority and direct payments (link DP guide), personal health budget (link `/resources/`), private self-funded; no duplicate of hub long-form.
7. **H2:** Real photos and next steps **H3:** Visual trust strip; related reading links (Confirm in WP: slugs in related strip).

#### Step B - 2026-05-11 - [https://restwellretreats.co.uk/faq/](https://restwellretreats.co.uk/faq/)

**Scope:** `template-faq.php` (`/faq/`). **Facts:** FAQ list comes from `restwell_get_faq_items( 'faq-page' )` with categories about, booking, care, local, funding (theme defaults in `inc/theme-setup.php` include ceiling track hoist and profiling bed in equipment answers, cancellation tiers, DP wording, CQC explainer). **Banned phrase:** not used. **Hoist SERP note:** secondaries include `tracking hoist holiday accommodation`; one meta variant uses **ceiling track hoist** to match on-page FAQ8 wording unless WP confirms tracking.

**Title variants (~50 to 60 characters with trailing brand)**

1. `Accessible cottage FAQ: hoist, wet room - Restwell Retreats` (59 characters). Accessible plus cottage plus hoist plus wet room in the opening segment, FAQ label for support intent.
2. `Whitstable FAQ: hoist, wet room, booking - Restwell Retreats` (60 characters). Local-first for Whitstable-area bookers, adds booking signal.
3. `Hoist and wet room FAQ: Whitstable area - Restwell Retreats` (59 characters). Equipment-led for users comparing hoist plus wet room answers before they open spec pages.

**Meta description variants (~150 to 160 characters)**

1. `Booking, cancellation, funding, and care FAQs. Near Whitstable, Kent: hoist, profiling bed, wet room in one self-catering place. Enquire or read accessibility.` (159 characters).
2. `Hoist, profiling bed, wet room, and Whitstable access in our FAQs. Self-catering Kent coast: deposits, cancellation, DP. Enquire or see accessibility.` (150 characters).
3. `FAQ for ceiling track hoist, profiling bed, wet room near Whitstable, Kent. Booking, cancellation, funding. Self-catering. Enquire or read accessibility.` (153 characters).

**Recommended pick:** Title **1** plus Meta **1**. **Rationale:** Title **1** mirrors the Step B brief keywords without copying `/accessibility/` or `/the-property/` title shapes, and the word FAQ sets SERP expectation for answers. Meta **1** lines up with high-friction FAQ themes from the §2.6 run (booking, cancellation, funding, care), states Whitstable plus Kent, names hoist plus profiling bed plus wet room in one self-catering place (USPs from the brief), and uses a split CTA (enquire or read accessibility) so spec depth stays on `/accessibility/`.

**Human next:** Paste chosen title and meta into WP Search and Social. **Do not** edit `inc/seo.php` until a human confirms.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/faq/](https://restwellretreats.co.uk/faq/)

**Scope:** `template-faq.php`, URL `/faq/`. **Step A mirror:** `restwell booking questions`, `accessible holiday cottage hoist and wet room Whitstable Kent` (worksheet Primary), `direct payment stay restwell`, equipment and cancellation Tier 1 rows in §2.6 run **2026-05-10**. **§2.3 AEO mirror:** five table questions (price includes, cancellation, direct payments, equipment list, sea distance). **Facts:** accordion copy comes from `restwell_get_faq_items( 'faq-page' )`; theme defaults use **ceiling track hoist** in the accessible bedroom plus profiling bed and wet room language (`inc/theme-setup.php` FAQ8). **Banned phrase:** not used. **Schema:** FAQPage JSON-LD must match visible question and answer strings after any heading edits (Confirm in WP).

**Ordered outline (H1, then H2, then H3):**

1. **H1:** Booking and access FAQs for Restwell (Whitstable area, Kent) (Confirm in WP: set `faq_heading` in interior hero so this stays the only on-page H1, or shorten while keeping booking plus place plus FAQ intent).
2. **H2:** What is included in the price at Restwell? (§2.3 AEO; FAQ7 cluster).
3. **H2:** What is Restwell's cancellation policy? (§2.3 AEO; FAQ11 tiers plus medical nuance in source).
4. **H2:** Can direct payments be used for a stay at Restwell? (§2.3 AEO; FAQ13; link `/resources/` and `/direct-payment-holiday-accommodation/`, no funding primaries duplicated here).
5. **H2:** What accessibility equipment is included? (§2.3 AEO; FAQ8). **H3:** Ceiling track hoist in the accessible bedroom, profiling bed, roll-in wet room, grab rails, washbasin, parking (Confirm in WP: list matches FAQ8 and `/accessibility/`).
6. **H2:** How far is the sea from Restwell? (§2.3 AEO; FAQ10 flat path wording in theme).
7. **H2:** What is Restwell? (Step A FAQ1, brand plus offer clarity for commissioners and families).
8. **H2:** How do I book? (Step A enquiry paths: form, email, call in theme FAQ5).
9. **H2:** Care, personal support, and the regulator (Step A CQC explainer FAQ14 plus optional care FAQ4; keep optional care framing, no outcome promises beyond source).
10. **H2:** Local access in Whitstable (Step A harbour or cobbles FAQ9; link `/whitstable-area-guide/` for depth).
11. **H2:** Common questions by topic (matches template filter band: about, booking, care, local, funding; screen reader live region stays as implemented).
12. **H2:** Further reading (template links: direct payment guide, beaches guide, carers guide).
13. **H2:** Still have a question? (quick question form band; reply within 48 hours per template default).

**Step A alignment:** Primary plus secondaries surface across H1 and H2 5 to 10 (hoist type, wet room, self-catering Kent coast, disabled access cottage Whitstable, booking questions). **Human next:** If you promote AEO lines to visible H2s, keep accordion questions identical to FAQPage entities or update schema in theme to match.

#### Step B - 2026-05-11 - [https://restwellretreats.co.uk/accessible-beaches-coastal-walks-kent/](https://restwellretreats.co.uk/accessible-beaches-coastal-walks-kent/)

**Scope:** `page.php` long-form seeded from `inc/seo-content-seed.php` (`accessible-beaches-coastal-walks-kent`). **Step A primary (locked):** `accessible beaches kent` (§2.6 run 2026-05-10, seed `focus_keyphrase`). The brief phrase **accessible holiday cottage hoist and wet room Whitstable Kent** is not the worksheet Primary on this URL (it would cannibalise `/accessibility/` and `/the-property/`); it is carried in **Secondaries** and in meta copy as a short commercial bridge. **Facts:** Promenade, parking, and access-notes framing matches the cluster guide role; named places in meta M3 follow plan research echoes (Confirm in WP: seed body still covers Tankerton and Herne Bay before publish). **Hoist SERP note:** secondary `tracking hoist holiday accommodation` maps to **ceiling track hoist** in publish strings unless WP confirms supplier wording. **Banned phrase:** not used.

**Title variants (~50 to 60 characters, brand suffix)**

1. `Accessible beaches Kent: walks - Restwell Retreats` (50 characters). Primary query in the opening segment; walks signal for coastal slug.
2. `Accessible beaches Kent coast guide - Restwell Retreats` (55 characters). Adds **coast** and **guide** for slug alignment and **accessible self catering Kent coast** planners.
3. `Accessible beaches Whitstable Kent - Restwell Retreats` (54 characters). Whitstable modifier for local overlap while keeping **accessible beaches** early.

**Meta description variants (~150 to 160 characters)**

1. `Accessible beaches Kent: promenades, parking, access notes. Whitstable-area self-catering with hoist, profiling bed, wet room. See accessibility, enquire.` (154 characters).
2. `Plan accessible beaches Kent: realistic access notes for coastal walks. Quiet self-catering near Whitstable: hoist, profiling bed, wet room. Enquire online.` (156 characters).
3. `Accessible beaches Kent guide: Tankerton, Herne Bay, access tips. Self-catering near Whitstable: hoist, profiling bed, wet room. Read accessibility, enquire.` (157 characters).

**Recommended pick:** Title **2** plus Meta **1**. **Rationale:** Title **2** keeps **accessible beaches Kent** in the opening segment, adds **coast** and **guide** so the line matches the URL and mixed informational intent without copying the `/whitstable-area-guide/` title shape. Meta **1** opens with the primary, lists practical planning hooks (promenades, parking, access notes) for honest beach-day realism, states both USPs (quiet Whitstable-area self-catering plus hoist, profiling bed, wet room together), and uses **See accessibility, enquire** so equipment proof stays on `/accessibility/`.

**Human next:** Paste into WP Search and Social. **Do not** edit `inc/seo.php` until a human confirms.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/accessible-beaches-coastal-walks-kent/](https://restwellretreats.co.uk/accessible-beaches-coastal-walks-kent/)

**Scope:** `page.php` long-form seeded from `inc/seo-content-seed.php` (`accessible-beaches-coastal-walks-kent`); body phrases and entities grounded in `restwell_get_blog_post_beaches_kent_html()` per §2.0 run **2026-05-10**. **Step A primary:** `accessible beaches kent`. **AEO mirror:** §2.0 table (five questions) plus §2.3 worksheet rows on definition, planning steps, audience, documents, and funding overlap (one light H2, links only). **Banned phrase:** not used. **Hoist wording:** use **ceiling track hoist** in publish strings unless WP confirms tracking (secondaries in §13.1).

**Ordered outline (H1, then H2, then H3):**

1. **H1:** Accessible beaches Kent: practical notes on promenades, sand, and hire schemes (Confirm in WP: one on-page H1 matches hero or lead block; no second H1 in `the_content()`.)
2. **H2:** What counts as accessible beach access in Kent? (AEO §2.0 Q1; shingle versus promenade versus sand; honest limits, no blanket venue claims beyond seed.)
3. **H2:** Who this Kent coast guide is for? (§2.3; carers, families, commissioners, funding-aware bookers; keep tone practical, not promotional.)
4. **H2:** Where to borrow beach wheelchairs on the Kent coast (AEO §2.0 Q2; Beach Within Reach; **H3:** Who to ring and what to confirm before travel (Confirm in WP: number and operator text match live scheme pages).)
5. **H2:** Is Whitstable beach workable on wheels? (AEO §2.0 Q3; shingle versus Tankerton Slopes promenade; **H3:** Harbour crowding at weekends where seed mentions it.)
6. **H2:** Whitstable to Herne Bay with limited stamina (AEO §2.0 Q4; promenade distance and pacing; link `/fatigue-friendly-whitstable-coastal-day/` and `/quieter-times-whitstable-low-crowd-access/` for timing detail.)
7. **H2:** Blue Flags, water quality, and access limits (AEO §2.0 Q5; separate water quality from roll-on access.)
8. **H2:** Thanet sandy bays and day trips (Step A tier 1: Viking Bay, Margate sands; **H3:** Viking Bay access setup; **H3:** Margate Main Sands surface; **H3:** Turner Contemporary as a paired stop (Confirm in WP: opening times and access lines from venue sources).)
9. **H2:** Toilets, trails, and parking checks (Broadstairs Harbour toilets; Viking Coastal Trail sections; **H3:** Dreamland Blue Badge parking where seed references it.)
10. **H2:** Changing Places and toilet planning before travel (signpost `/changing-places-toilets-kent-coast-days-out/`; keep CP registry depth off this URL per §2.0 cannibal note.)
11. **H2:** Parking and drop-off near Whitstable (high level only; link `/accessible-parking-whitstable-tankerton/` for bay and kerb detail.)
12. **H2:** Funding routes and paperwork for a Kent break (§2.3 template: documents and DP or CHC overlap; short checklist tone; link `/resources/` and relevant guides, no funding primaries on this URL.)
13. **H2:** After a coast day near Whitstable (commercial bridge: hoist, profiling bed, wet room in one self-catering place; link `/accessibility/` for measurements, `/enquire/` for dates.)
14. **H2:** Related guides (internal links: `/whitstable-area-guide/`, `/accessible-parking-whitstable-tankerton/`, `/accessible-eating-out-whitstable-kent/`, `/accessible-train-travel-whitstable-kent/` as editorially relevant.)

**Step A alignment:** Tier 1 strings (beach within reach, tankerton promenade wheelchair, kent coast shingle, Viking Bay, Margate sands, Herne Bay promenade) sit under H2 4 through 9 without inventing kit beyond seed HTML. **Human next:** Add or reorder WP blocks so visible H2s match this ladder where the template does not output headings; cite external operator or council pages when publishing phone numbers or hours.

#### Step B - 2026-05-11 - [https://restwellretreats.co.uk/accessible-parking-whitstable-tankerton/](https://restwellretreats.co.uk/accessible-parking-whitstable-tankerton/)

**Scope:** `page.php` seeded guide (`/accessible-parking-whitstable-tankerton/`). **Facts:** Repo body in `restwell_get_blog_post_accessible_parking_whitstable_html()` (Blue Badge, Tankerton slopes and kerbs, town centre crowding, harbour and beaches, council maps disclaimer); seed meta in `inc/seo-content-seed.php` (`accessible-parking-whitstable-tankerton`). **Step A primary:** `accessible parking whitstable` (not the long cottage phrase as Primary, which would fight `/accessibility/` and `/the-property/`); Step B pack secondaries still list hoist, wet room, and Kent coast phrases for one-line commercial bridges in meta only. **Banned phrase:** not used. **Hoist wording:** secondary lists `tracking hoist holiday accommodation`; publish on-page kit labels should follow **ceiling track hoist** unless WP or access statement confirms tracking.

**Title variants (~50 to 60 characters with trailing brand)**

1. `Accessible parking Whitstable Kent - Restwell Retreats` (54 characters). Opens **accessible parking** plus **Whitstable** and **Kent** inside the first segment for Step A plus county intent.
2. `Blue Badge Whitstable: crowds, parking - Restwell Retreats` (58 characters). Leads **Blue Badge** and **Whitstable** for badge-led queries; **crowds** signals seasonal honesty from the seeded TL;DR tone.
3. `Tankerton drop-off: Whitstable parking - Restwell Retreats` (58 characters). Surfaces **Tankerton** and **drop-off** early for kerb and unload intent without shrinking the Whitstable parking job.

**Meta description variants (~150 to 160 characters)**

1. `Blue Badge Whitstable Tankerton: tight bays, drop-off first, kerbs. Quiet Kent self-catering: hoist, profiling bed, wet room. Read accessibility, enquire.` (154 characters).
2. `Accessible parking Whitstable: bay timing, drop-off when busy, Tankerton kerbs. Kent self-catering: hoist, profiling bed, wet room. See accessibility, enquire.` (159 characters).
3. `Disabled-access Whitstable parking: Blue Badge basics, summer crowding, prom access. Quiet cottage: hoist, profiling bed, wet room. Read accessibility, enquire.` (160 characters).

**Recommended pick:** Title **1** plus Meta **1**. **Rationale:** Title **1** keeps the URL-owned parking primary and Kent in one scan line before the brand. Meta **1** pairs Blue Badge with both place names, states honest crowding mechanics (tight bays, drop-off first, kerbs) that match the seeded guide, then carries both USPs (quiet Kent self-catering plus hoist, profiling bed, wet room together) and sends proof readers to `/accessibility/` before **enquire**.

**Human next:** Paste chosen title and meta into WP Search and Social. **Do not** edit `inc/seo.php` until a human confirms.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/accessible-parking-whitstable-tankerton/](https://restwellretreats.co.uk/accessible-parking-whitstable-tankerton/)

**Scope:** `page.php` long-form; `restwell_get_blog_post_accessible_parking_whitstable_html()` in `inc/seo-content-seed.php`. **Step A primary:** `accessible parking whitstable`. **Tier 1 echoes (§2.6 `#### Run - 2026-05-10` table):** `accessible parking whitstable kent`, `blue badge whitstable seafront`, `tankerton drop off marine parade`, `pay and display seafront whitstable disabled bay`, `tide crowds parking turnover whitstable`, `promenade access parking link tankerton`. **§2.3 AEO (five, same run):** reliable Blue Badge space near seafront; Tankerton versus harbour at weekends; tides and crowds; drop-off when the car park is far; weekday and quieter timing. **Earlier §2.6 generic AEO rows (~2854):** definition, planning, audience, documents, DP or CHC overlap: cover with H2 1, H2 10 to 11, and signposts only, not funding primaries. **Banned phrase:** not used. **Facts:** Council tariffs and zone maps stay on official council pages the week you travel (seed disclaimer); do not invent equipment beyond Restwell stay bridge lines on `/accessibility/`. **Cannibal:** bay and kerb depth here; shore surfaces on `/accessible-beaches-coastal-walks-kent/`; town hub on `/whitstable-area-guide/`; Passenger Assist and rail gaps on `/accessible-train-travel-whitstable-kent/`.

**Ordered outline (H1, then H2, then H3):**

1. **H1:** Accessible parking in Whitstable and Tankerton, Kent (Confirm in WP: one visible H1 from hero or lead block.)
2. **H2:** What counts as accessible parking here (definition: short roll distance on uneven pavements, not a logo-only bay; aligns seed opening and §2.6 definition row.)
3. **H2:** Reliable Blue Badge space near Whitstable seafront (AEO Q1; turnover and timing honesty from seed TL;DR tone.)
4. **H2:** Tankerton compared with Whitstable harbour when it is busy (AEO Q2; **H3** Tankerton slopes, kerbs, promenade per seed; **H3** Harbour and beach approach, link beaches guide for shingle.)
5. **H2:** Tides, events, and parking turnover (AEO Q3; markets, summer day-trippers, late road closures caveat per seed.)
6. **H2:** Drop-off when you cannot walk far from the car (AEO Q4; town centre drop-off may beat bay-hunt per seed.)
7. **H2:** Weekday patterns and quieter visits (AEO Q5; link `/quieter-times-whitstable-low-crowd-access/`; optional `/fatigue-friendly-whitstable-coastal-day/` for pacing.)
8. **H2:** On-street rules, pay and display, and car parks (seed comparison table; council verify note; **H3** On-street Blue Badge versus pay-and-display columns where you keep the table.)
9. **H2:** Harbour approaches and busy weekends (Tier 2: narrow Harbour Street, oyster festival; Confirm in WP: event names and dates from official calendars only.)
10. **H2:** Practical checks before you drive (seed bullet list: candidate bays, timer disc, wet-weather plan, private drive etiquette; documents angle stays generic checklist, no forms invented.)
11. **H2:** If your trip is funded (short paragraph; link `/resources/` for CHC, direct payments, personal budget guides; no YMYL depth on this URL.)
12. **H2:** Rail, taxi, and station links (Tier 2 taxi rank station accessible; link `/accessible-train-travel-whitstable-kent/` for assist and connection realism.)
13. **H2:** Frequently asked questions (**H3** Do Blue Badge holders always park free? **H3** Is the promenade level all the way? **H3** Can I reserve a harbour bay? **H3** Where should electric wheelchair users aim? **H3** What if every bay is full; mirror seed FAQ block.)
14. **H2:** Next reads: beaches, area guide, property access (internal: `/accessible-beaches-coastal-walks-kent/`, `/whitstable-area-guide/`, `/accessibility/` for measurements, `/enquire/` for dates.)

**Step A alignment:** H1 and early H2s carry `accessible parking whitstable`, Kent, Blue Badge, Tankerton, drop-off, tides and crowds, pay and display, promenade, and station or taxi follow-up without claiming on-street hoist coverage.

**Avoid-ai-writing self-check:** ASCII hyphens and colons only, no em dash; concrete bay and kerb language; no "delve", "landscape", or "robust"; festival and council lines flagged for human verify.

**Human next:** Reorder WP blocks or refresh seed HTML H2 order so visible headings match this ladder where `page.php` outputs `the_content()`; keep a single H1.

#### Step B - 2026-05-11 - [https://restwellretreats.co.uk/accessible-eating-out-whitstable-kent/](https://restwellretreats.co.uk/accessible-eating-out-whitstable-kent/)

**Scope:** `page.php` seeded long-form (`/accessible-eating-out-whitstable-kent/`). **Facts:** Seed `focus_keyphrase` `accessible eating out whitstable` and slug echo in `inc/seo-content-seed.php`; §2.6 run **2026-05-10** logged dining intent and cannibal rules (local days out plus eating out vs area guide). **Banned phrase:** not used. **Hoist wording:** secondaries include `tracking hoist holiday accommodation`; publish body or meta should use **ceiling track hoist** where hoist type is named unless WP or access statement confirms tracking.

**Title variants (~50 to 60 characters with trailing brand)**

1. `Accessible eating out Whitstable Kent - Restwell Retreats` (57 characters). Step A primary plus Kent in the opening segment before brand.
2. `Step-free dining Whitstable: loos, routes - Restwell Retreats` (61 characters). Surfaces step-free and toilet-route realism for planners who skim for loos and routes first.
3. `Disabled-access dining Whitstable Kent - Restwell Retreats` (58 characters). Stronger **disabled access holiday cottage Whitstable** family echo on the dining job; **accessible** is not the first word.

**Meta description variants (~150 to 160 characters)**

1. `Plan Whitstable dining access: step-free checks, toilet routes, call ahead. Quiet self-catering: hoist, profiling bed, wet room. Read accessibility, enquire.` (157 characters).
2. `Accessible eating out Whitstable: what to ask venues before you book. Kent coast self-catering with hoist, profiling bed, wet room. See accessibility, enquire.` (159 characters).
3. `Whitstable disabled-access dining: entries, toilet routes, no fixed venue list. Quiet cottage: hoist, profiling bed, wet room. Read accessibility, enquire.` (155 characters).

**Recommended pick:** Title **1** plus Meta **1**. **Rationale:** Title **1** keeps the URL-owned eating-out query and Kent in one line without stuffing equipment into the title (avoids implying restaurants supply hoists). Meta **1** answers the page job (step-free checks, toilet routes, phone ahead), states both USPs on the stay line, and routes kit proof to `/accessibility/` before **enquire**, matching other cluster guides.

**Human next:** Paste into WP Search and Social. **Do not** edit `inc/seo.php` until a human confirms.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/accessible-eating-out-whitstable-kent/](https://restwellretreats.co.uk/accessible-eating-out-whitstable-kent/)

**Source:** §13.1 row for this URL; Step A keywords in `#### Run - 2026-05-10 - https://restwellretreats.co.uk/accessible-eating-out-whitstable-kent/` (§2.6 worksheet plus condensed Tier or AEO block under the same URL heading in §2.6); §2.3 AEO worksheet (What is, How do I plan, Who is, What documents, Where overlap); §2.0 AEO table on the same URL run (harbour queues, toilet script, quieter tables, Kent pairings, dysphagia or menu checks with Confirm in WP). **Repo:** `page.php`; body seed `restwell_get_blog_post_accessible_eating_out_whitstable_html()` in `inc/seo-content-seed-blog-cluster-b.php` (Confirm in WP: live blocks override seed order).

**Scope:** Local dining access guide for Whitstable and Kent coast; no fixed venue list without verification. **Banned phrase:** not used.

**Ordered H1, H2, H3 (target editorial ladder; Confirm in WP before reordering `the_content()` blocks)**

1. **H1:** Accessible eating out near Whitstable, Kent (single H1; aligns seed `focus_keyphrase` `accessible eating out whitstable` plus Kent; Confirm in WP hero or post title field).
2. **H2:** What accessible eating out means on this page (answers §2.3 What is accessible eating out whitstable; short definition, Kent coast scope from seed excerpt).
3. **H2:** Why harbour crowds and weekends change access (answers §2.0 AEO on queues and circulation; Tier 1 harbour weekend crowding; oyster festival line Confirm in WP event calendar).
4. **H2:** Step-free entries and real thresholds (Tier 1 step free entry restaurants whitstable harbour; ask for current door lip photos, not old street view).
5. **H2:** Toilet routes, not cubicle labels alone (answers §2.0 AEO on real toilet access; Tier 1 accessible toilet route; **H3** Entrance and threshold; **H3** Toilet route same level as seating; **H3** Changing Places signpost only, depth on `/changing-places-toilets-kent-coast-days-out/`).
6. **H2:** How to plan meals before you arrive (answers §2.3 How do I plan; numbered call-ahead list; chair dimensions, off-peak booking).
7. **H2:** Quieter tables and lower-sensory tactics (answers §2.0 AEO quieter tables; Tier 1 quieter tables wheelchair restaurant kent coast; link `/quieter-times-whitstable-low-crowd-access/`).
8. **H2:** Harbour strip versus side streets (trade-off table; parking proximity links `/accessible-parking-whitstable-tankerton/`; kerb checks each block).
9. **H2:** Kent coast towns for an accessible food day trip (answers §2.0 AEO pairing; short list, no unverified venue access claims).
10. **H2:** Menus, allergies, and texture checks (seed Menus h3 themes; §2.0 dysphagia row: add texture or IDDSI depth only if editor confirms in WP).
11. **H2:** Who this guide is for (answers §2.3 Who is; carers, families, commissioners, funding-aware bookers; one short paragraph each or bullets).
12. **H2:** Documents, receipts, and funding overlaps on a wider trip (answers §2.3 What documents and Where overlap; checklist tone; signpost `/resources/`, `/direct-payment-holiday-accommodation/`, `/chc-respite-holiday-accommodation-uk/` without YMYL depth here).
13. **H2:** Common mistakes when listings sound easy (seed list; no venue names unless verified).
14. **H2:** Frequently asked questions (seed FAQ: Changing Places in pubs, chair width, dogs, who lists access, reviews; Confirm in WP FAQ schema if used).
15. **H2:** Next reads and enquiries (link `/whitstable-area-guide/`, `/blog/`; CTA `/enquire/`; property kit stays on `/accessibility/` and `/the-property/`).

**Step A echo:** accessible eating out whitstable, accessible eating out whitstable kent, step-free and toilet-route language, harbour crowding, quieter tables, Kent coast pairings.

**Avoid-ai-writing self-check:** Plain labels, concrete checks (photos, levels, routes), no empty superlatives, ASCII hyphens and colons only.

**Human next:** Reorder WP blocks or refresh seed HTML H2 order so visible headings match this ladder where `page.php` outputs `the_content()`; keep one H1; do not name venues without live access confirmation.

#### Step B - 2026-05-11 - [https://restwellretreats.co.uk/guest-guide/](https://restwellretreats.co.uk/guest-guide/)

**Scope:** `page-guest-guide.php` (`/guest-guide/`). **Facts:** OTP-gated flow (booking email, 6-digit code, about 30-minute TTL per `RESTWELL_GG_OTP_TTL_SECONDS`); interior sections include arrival, keys, WiFi, parking, house rules, departure, local area, emergency labels (ACF-driven detail **Confirm in WP**). Verified state can mention print when the template allows. **Banned phrase:** not used. **Technical:** theme outputs `noindex, follow` for this template, so these strings support navigational clarity and post-booking utility, not head-term acquisition. **Hoist wording:** secondary includes `tracking hoist holiday accommodation`; metas use **ceiling track hoist** unless WP confirms supplier tracking wording.

**Title variants (~50 to 60 characters with trailing brand)**

1. `Accessible hoist cottage Whitstable - Restwell Retreats` (56 characters). Packs accessible, hoist, cottage, and Whitstable inside the first thirty characters for the Step B brief.
2. `Hoist, wet room: Whitstable guest info - Restwell Retreats` (58 characters). Leads equipment plus Whitstable for users who skim for wet room and hoist before brand.
3. `Kent coast self-catering guest guide - Restwell Retreats` (56 characters). Stronger **accessible self catering Kent coast** echo; weaker on the word **accessible** in the opening token.

**Meta description variants (~150 to 160 characters)**

1. `Kent coast self-catering Whitstable: WiFi, parking, rules, tips. Quiet stay. Ceiling track hoist, profiling bed, wet room. OTP to open. Restwell Retreats.` (154 characters).
2. `Accessible self-catering Kent coast: Whitstable guest guide. WiFi, parking, rules, tips. Hoist, profiling bed, wet room. Booking OTP to open. Restwell Retreats.` (160 characters).
3. `Disabled-access Whitstable: guest WiFi, parking, house rules, tips. Hoist, profiling bed, wet room. Quiet self-catering. Booking OTP. Restwell Retreats.` (152 characters).

**Recommended pick:** Title **1** plus Meta **1**. **Rationale:** Title **1** lands Step B primary fragments without copying the `/accessibility/` worksheet title shape. Meta **1** matches **accessible self catering Kent coast** and Whitstable-area utility, lists real guest-guide job topics from template labels, carries both USPs (quiet stay plus hoist, profiling bed, wet room together), and ends with a clear OTP CTA that matches the template.

**Human next:** Paste chosen title and meta into WP Search and Social. **Do not** edit `inc/seo.php` until a human confirms.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/guest-guide/](https://restwellretreats.co.uk/guest-guide/)

**Scope:** `page-guest-guide.php` (`/guest-guide/`). **Facts:** OTP flow uses booking email, 6-digit code, and about 30-minute TTL (`RESTWELL_GG_OTP_TTL_SECONDS` in `page-guest-guide.php`); hero passes `Your arrival guide` and `verified guests only` framing to `template-parts/interior-hero.php` (single H1 there); verified cards use labels Arrival details, Getting in, WiFi, Parking, House rules, Before you leave, Local area (template adds a level promenade note and Marine Parade parking tip plus link to `/whitstable-area-guide/`), Emergency information (label keys include Emergency services, NHS non-emergency, Police non-emergency, Nearest A and E, maintenance lines, Gas emergency), Your host when `gg_host_contact` is set. **Technical:** `noindex, follow` in `inc/seo.php` for this template (logistics first, SEO secondary unless indexing changes). **Banned phrase:** not used.

**Step A and AEO mirror:** `restwell guest guide`, check-in and WiFi and parking and house rules and confirmed guests language from seeds; §2.6 paired-pass questions (open guide after booking, why email and code, OTP expiry, where WiFi parking rules live, guest guide versus accessibility page); Step A run **2026-05-10** AEO rows (what is in the guide, Wi-Fi and parking, blog difference, what to read before arrival, who the guide is for).

**Ordered H1, H2, H3 (target editorial ladder; Confirm in WP before changing visible heading levels in PHP)**

1. **H1:** Restwell guest guide: your arrival and stay (Confirm in WP: align with `interior-hero` `heading` so the page keeps exactly one H1 in each gate state).
2. **H2:** Open the guide after you book (answers: How do I open the Restwell guest guide after booking?)
  - **H3:** Booking email and send code (matches Verify your identity step).
  - **H3:** Enter the 6-digit code (matches Enter your access code step).
  - **H3:** If the code expired, resend or start again (matches expiry and resend copy in `page-guest-guide.php`).
3. **H2:** Why we ask for email and a code (answers: Why does the site ask for my booking email and a code?)
4. **H2:** What you will find in this guide (answers: What is in the Restwell guest guide? plus Where do I find Wi-Fi and parking information? as one scan block; list arrival, keys, WiFi, parking, rules, departure, local tips, emergency, host when set).
5. **H2:** How the blog differs from this guide (answers: How is the guest guide different from the blog? link `/blog/`.)
6. **H2:** Guest guide versus accessibility specification (answers: Is the guest guide the same as your accessibility specification page? keep measurements and PDF on `/accessibility/`.)
7. **H2:** Arrival details (Address, Check-in, Check-out when ACF fields set).
8. **H2:** Getting in (Key safe code, Instructions when set).
9. **H2:** WiFi (Network, Password when set).
10. **H2:** Parking (when `gg_parking_info` set).
11. **H2:** House rules (when `gg_house_rules` set).
12. **H2:** Before you leave (when `gg_departure_notes` set).
13. **H2:** Local area (when `gg_local_info` set; template default lines on promenade slope and Marine Parade parking are in repo).
14. **H2:** Emergency information (phone and contact list when ACF values set).
15. **H2:** Your host (when `gg_host_contact` set).

**Human next:** If you add FAQ or explainer blocks in WP, match this order to §2.3 questions before reordering cards; do not duplicate `/accessibility/` hoist scope beyond what the template or ACF already states.

#### Step B - 2026-05-11 - [https://restwellretreats.co.uk/carers-respite-holiday-guide/](https://restwellretreats.co.uk/carers-respite-holiday-guide/)

**Scope:** `page.php` seeded long-form (`/carers-respite-holiday-guide/`). **Step A seed:** `carer assessment respite rights` (`inc/seo-content-seed.php`, `carers-respite-holiday-guide`; **Confirm in WP** live copy and internal links). **Primary (this Step B brief):** `accessible holiday cottage hoist and wet room Whitstable Kent` for foundation pack alignment; keep Step A seed in **Secondaries** until GSC confirms a Primary swap. **Facts:** high-level carer assessment and respite rights framing only, signpost to funding hubs, calm non-alarmist tone, not tailored legal or financial advice. **Banned phrase:** not used. **Hoist SERP note:** secondary lists `tracking hoist holiday accommodation`; on-page kit lines should follow **ceiling track hoist** unless WP or access statement confirms tracking wording.

**Title variants (~50 to 62 characters with trailing brand)**

1. `Accessible carers respite Whitstable guide - Restwell Retreats` (62 characters). **Accessible** plus carers plus respite plus Whitstable inside the first thirty characters for guide and rights discovery.
2. `Accessible hoist cottage carers Kent guide - Restwell Retreats` (62 characters). Stronger Step B equipment plus **accessible self catering Kent coast** echo; weaker on the word **respite** in the title.
3. `Respite rights Whitstable: hoist, wet room - Restwell Retreats` (62 characters). Leads respite rights plus Whitstable for assessment-led queries; **accessible** sits after the colon only in the equipment fragment.

**Meta description variants (~150 to 160 characters)**

1. `Carer assessment and respite rights overview for UK bookers. Whitstable-area self-catering with hoist, profiling bed, wet room. Funding pages linked. Enquire.` (158 characters).
2. `Carer assessment and respite rights in plain English. Whitstable-area self-catering with hoist, profiling bed, wet room. Open funding hub links, then enquire.` (158 characters).
3. `Accessible self-catering Kent coast for carers: hoist, profiling bed, wet room near Whitstable. Read rights basics, open funding hub links, enquire when ready.` (159 characters).

**Recommended pick:** Title **1** plus Meta **2**. **Rationale:** Title **1** keeps the URL job visible (carers, respite, Whitstable, guide) while still opening with **Accessible** for the Step B brief. Meta **2** answers the assessment and rights question first, states both USPs in one line (quiet Whitstable-area self-catering plus hoist, profiling bed, wet room together), tells people to open the linked funding hub pages, then **Enquire** without hype or stacked intensifiers.

**Human next:** Paste chosen title and meta into WP Search and Social. **Do not** edit `inc/seo.php` until a human confirms.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/carers-respite-holiday-guide/](https://restwellretreats.co.uk/carers-respite-holiday-guide/)

**Source:** §13.1 row for `/carers-respite-holiday-guide/`; Step A seed and Tier 1 table in `#### Run - 2026-05-10 - https://restwellretreats.co.uk/carers-respite-holiday-guide/` (§2.6, ~~4269); AEO block (five questions) in that same run; generic §2.3 worksheet AEO rows under `#### Run - 2026-05-10` for this slug (~~2675 to ~2683) for definition, planning, audience, documents, and funding overlap; `#### Step B - 2026-05-11` same URL; `page.php` plus `restwell_get_blog_post_carers_respite_html()` in `inc/seo-content-seed.php`.

**Scope:** Carer support guide, high-level rights and assessment framing, routes to funding hubs. **Facts:** not tailored legal or financial advice; on-page kit claims follow seed or WP only (ceiling track hoist unless WP confirms tracking). **Banned phrase:** not used.

**Ordered outline**

1. **H1 (one):** Carer assessment and respite rights: plain-English guide (UK, Kent signposts; general information, not tailored legal advice) (Confirm in WP: single visible H1 matches hero or first body heading; echoes Step A seed **carer assessment respite rights** and worksheet secondaries without swapping Primary until GSC).
2. **H2:** What a carer's assessment is, and who can ask (answers §2.6 AEO: Am I entitled to a carer's assessment if I want a holiday? plus §2.3 definition row; plain English only).
3. **H2:** Respite rights after a carer's assessment (answers Care Act 2014 framing in Tier 1 table; high level, signpost official guidance).
4. **H2:** How to ask Kent social care for respite as an unpaid carer (answers §2.6 AEO step question; Confirm in WP: KCC and Kent Connect to Support URLs or phone lines in body match live council pages).
5. **H2:** What funding can pay for cover while you travel (answers §2.6 AEO table row; **H3** Holiday care funding hub `/resources/`; **H3** Direct payments guide `/direct-payment-holiday-accommodation/`; **H3** CHC guide `/chc-respite-holiday-accommodation-uk/`; **H3** Personal budget receipts `/personal-budget-short-break-care-act/`; keep definitions on those URLs).
6. **H2:** Personal budgets and self-catering breaks for carers (answers §2.6 AEO: Can a personal budget pay for a self-catering break for me as a carer?; yes or no plus receipts, not outcomes).
7. **H2:** Planning carers' holidays and restful breaks (answers §2.6 AEO on restful breaks; carries Tier 1 **carers taking holidays respite planning** and **unpaid carer short break self catering**; optional link `/how-to-choose-accessible-self-catering-holiday/` when editor adds).
8. **H2:** Documents and checks before you book (answers §2.3 checklist row at worksheet level; commissioner paperwork stays light, link `/commissioner-checklist-accessible-respite-stay/` if panel-led).
9. **H2:** Whitstable-area self-catering after funding checks (bridge only: hoist, profiling bed, wet room in one place per seed themes; full measurements on `/accessibility/` and `/the-property/`; enquire `/enquire/`).
10. **H2:** Related reading (answers §2.3 overlap row lightly: `/who-its-for/` audience fit; `/faq/` Carer's Assessment snippet path versus this long-form per §16 B2).

**Human next:** Align WP `the_content` headings to this ladder without adding a second H1; keep FAQPage or other schema in sync if visible questions change.

#### Step B - 2026-05-11 - [https://restwellretreats.co.uk/accessible-train-travel-whitstable-kent/](https://restwellretreats.co.uk/accessible-train-travel-whitstable-kent/)

**Scope:** `page.php` seeded long-form (`/accessible-train-travel-whitstable-kent/`). **Facts:** Theme seed `inc/seo-content-seed.php` (`accessible-train-travel-whitstable-kent`): `meta_title` stem Accessible Train Travel Whitstable Kent, `meta_description` names Passenger Assist, platform gaps, connections, pairing rail with local parking or taxi backup, `focus_keyphrase` `accessible train travel whitstable`. **Step A vs Step B primary:** worksheet **Primary** keeps URL owner `accessible train travel whitstable` (§2.6 run **2026-05-10**); Step B brief phrase **accessible holiday cottage hoist and wet room Whitstable Kent** sits in **Secondaries** as commercial bridge until GSC says otherwise. **Banned phrase:** not used. **Hoist SERP note:** secondary lists `tracking hoist holiday accommodation`; publish on-page kit lines should follow **ceiling track hoist** unless WP or access statement confirms tracking wording.

**Title variants (~50 to 60 characters with trailing brand)**

1. `Accessible train travel Whitstable - Restwell Retreats` (54 characters). Puts **accessible train travel Whitstable** inside the first thirty-four characters for seed and §2.6 alignment.
2. `Accessible train Whitstable: assist tips - Restwell Retreats` (60 characters). Surfaces Passenger Assist style wording in the visible title without repeating the full seed line.
3. `Accessible rail Whitstable: connections - Restwell Retreats` (59 characters). Leads on connection realism for planners who already know they need changes en route.

**Meta description variants (~150 to 160 characters)**

1. `Passenger Assist, gaps, and connections for Whitstable by rail, Kent. Quiet self-catering: hoist, profiling bed, wet room. Read accessibility, enquire.` (151 characters).
2. `Passenger Assist, realistic rail connections to Whitstable. Accessible self-catering Kent coast: hoist, profiling bed, wet room. See accessibility, enquire.` (156 characters).
3. `Plan rail to Whitstable: Passenger Assist, gaps, backups. Whitstable-area self-catering with hoist, profiling bed, wet room. Read accessibility, enquire.` (153 characters).

**Recommended pick:** Title **1** plus Meta **1**. **Rationale:** Title **1** matches the logged Step A primary and the seed `meta_title` stem without stuffing **Kent** into a tight SERP line. Meta **1** carries Passenger Assist, gaps, and connections (aligned to seed description), adds **Kent**, states both USPs (quiet self-catering plus hoist, profiling bed, wet room in one place), and sends proof reads to **Read accessibility** before **enquire**, so the transport page does not pretend to own full hoist scope.

**Human next:** Paste chosen title and meta into WP Search and Social. **Do not** edit `inc/seo.php` until a human confirms.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/accessible-train-travel-whitstable-kent/](https://restwellretreats.co.uk/accessible-train-travel-whitstable-kent/)

**Source:** §13.1 row for this URL; Step A Tier 1 to 2 keywords in `#### Run - 2026-05-10 - https://restwellretreats.co.uk/accessible-train-travel-whitstable-kent/` (§2.6, ~3057 to ~3108); AEO table (five questions, ~3088 to ~3096); `#### Step B - 2026-05-11` same URL; seed `inc/seo-content-seed.php` (`accessible-train-travel-whitstable-kent`).

**Scope:** `page.php` seeded transport guide. **Facts:** Seed meta names Passenger Assist, platform gaps, connections, and pairing rail with local parking or taxi backup; rail layout and times stay operator-dependent (**Confirm in WP:** body matches live operator or National Rail facts). **Banned phrase:** not used. **Hoist wording:** secondaries list `tracking hoist holiday accommodation`; publish **ceiling track hoist** on stay-bridge lines unless WP or access statement confirms tracking.

**Ordered outline**

1. **H1 (one):** Accessible train travel to Whitstable, Kent (maps Primary `accessible train travel whitstable` plus slug or county query `accessible train travel whitstable kent`; Confirm in WP: one visible H1).
2. **H2:** What counts as accessible train travel here? (maps AEO: What is accessible train travel whitstable?; scope: planning for Whitstable by rail, not a timetable mirror).
3. **H2:** How to plan your journey (maps AEO: How do I plan accessible train travel whitstable?; numbered steps in body when WP adds them).
4. **H3:** Passenger Assist: book and confirm with your operator (seed Passenger Assist theme; no invented booking windows).
5. **H3:** Connections, changes, and platform gaps (seed gaps and connections theme; Confirm in WP against current services).
6. **H3:** Parking or taxi backup (seed parking or taxi backup; link `/accessible-parking-whitstable-tankerton/` for Blue Badge and drop-off depth).
7. **H2:** Who this guide is for (maps AEO: Who is accessible train travel whitstable for?; carers, families, commissioners, wheelchair or powerchair users, scooter hirers where body covers it).
8. **H2:** Documents and checks before you travel (maps AEO: What documents do I need for accessible train travel whitstable?; light checklist only, Confirm in WP if body lists specific forms).
9. **H2:** Funding overlap for a Kent break (maps AEO: Where does accessible train travel whitstable overlap with direct payments or CHC?; signpost `/resources/`, `/direct-payment-holiday-accommodation/`, `/chc-respite-holiday-accommodation-uk/`, `/personal-budget-short-break-care-act/`; no eligibility outcomes).
10. **H2:** Whitstable station and onward travel (connection realism: last leg, taxis, pavements; link `/whitstable-area-guide/` where editor adds; Confirm in WP: station copy matches operator pages).
11. **H2:** Staying near Whitstable after the train (soft bridge: hoist, profiling bed, wet room in one self-catering place per seed USPs; measurements on `/accessibility/` and `/the-property/`; `/enquire/` for dates; ceiling track hoist unless WP confirms tracking).
12. **H2:** Related reading (internal links only when editorially relevant: parking, beaches, eating out, mobility hire, insurance per §16 B2 cluster map).

**Avoid-ai-writing pass:** short section labels, one job per H2, no empty intensifiers, no em dash in publish strings.

**Human next:** Align WP `the_content` headings to this ladder without adding a second H1; keep any FAQ or Article schema in sync if visible questions change.

#### Step B - 2026-05-11 - [https://restwellretreats.co.uk/direct-payment-holiday-accommodation/](https://restwellretreats.co.uk/direct-payment-holiday-accommodation/)

**Scope:** `page.php` seeded funding guide (`/direct-payment-holiday-accommodation/`). **Facts:** Repo anchors `inc/seo-content-seed.php` (`direct-payment-holiday-accommodation` meta, `restwell_get_blog_post_direct_payments_html()`, seed priority row); goal is care versus lodging wording without bespoke financial advice. **Banned phrase:** not used. **Hoist SERP note:** secondaries include `tracking hoist holiday accommodation`; T3 tests that phrase in the title, while publish body or access statement should prefer **ceiling track hoist** unless WP confirms tracking.

**Title variants (~50 to 60 characters with trailing brand)**

1. `Holiday direct payment: hoist, wet room Kent - Restwell Retreats` (64 characters). Opens with holiday plus direct payment inside the first segment for funding intent, then hoist, wet room, Kent before the brand.
2. `Kent direct payment holidays: hoist, wet room - Restwell Retreats` (65 characters). Stronger **Kent** geography plus direct payment plus equipment in one line (echoes **accessible self catering Kent coast** in the meta set, not the title).
3. `Tracking hoist holiday: direct payment, Kent - Restwell Retreats` (64 characters). Surfaces the **tracking hoist holiday accommodation** secondary for SERP tests; confirm tracking versus ceiling track hoist before mirroring on-page.

**Meta description variants (~150 to 160 characters)**

1. `Holiday direct payment, Whitstable area: hoist, profiling bed, wet room in one self-catering place. Break costs versus care budgets, clearly explained. Enquire.` (160 characters).
2. `Direct payment and Whitstable-area self-catering: hoist, profiling bed, wet room. General guide on holiday versus care spend, not personal advice. Enquire.` (155 characters).
3. `Using a direct payment for holidays: hoist, profiling bed, wet room near Whitstable. Quiet self-catering, general facts only. Not tailored advice. Enquire.` (155 characters).

**Recommended pick:** Title **1** plus Meta **1**. **Rationale:** Title **1** keeps the page as a **holiday direct payment** answer first, which matches the funding guide URL and §2.6 ownership for `direct payment holiday accommodation`, while still carrying hoist, wet room, and Kent from the Step B brief inside the visible snippet. Meta **1** states the one-place USP (hoist, profiling bed, wet room), the Whitstable-area self-catering context, the break-versus-care split the page must explain, a plain limits line (not personal advice), and a single CTA.

**Human next:** Paste chosen title and meta into WP Search and Social. **Do not** edit `inc/seo.php` until a human confirms.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/direct-payment-holiday-accommodation/](https://restwellretreats.co.uk/direct-payment-holiday-accommodation/)

**Source:** §13.1 row for `/direct-payment-holiday-accommodation/`; Step A and AEO in `#### Run - 2026-05-10 - https://restwellretreats.co.uk/direct-payment-holiday-accommodation/` (§2.0 Tier table plus five AEO rows at ~~4140); mirror questions in `#### Run - 2026-05-10` Tier 1 table AEO block (~~2441); `#### Step B - 2026-05-11` same URL. Seed `focus_keyphrase` `direct payment for holiday` (`inc/seo-content-seed.php`).

**Scope:** `page.php` seeded funding guide. **Facts:** Theme wiring `restwell_get_blog_post_direct_payments_html()`, excerpt care-not-accommodation angle in seed priority row (grep plan §4111). **Banned phrase:** not used. **YMYL:** signpost councils and NHS sources; no tailored eligibility or spend outcomes.

**Ordered outline**

1. **H1 (one):** Direct payment holiday accommodation: care spend versus stay costs (general guide, not personal advice) (maps Primary `direct payment holiday accommodation` plus seed `direct payment for holiday`; single visible H1 in WP body or hero, Confirm in WP).
2. **H2:** Who this is for and what this page does not decide (maps AEO who plus documents risk: carers, commissioners, funded bookers; states general facts only, not panel decisions).
3. **H2:** Can direct payments pay for self-catering accommodation? (maps AEO: Can I use my direct payment to pay for holiday accommodation?; cautious framing, LA variation).
4. **H2:** Care, PA hours, and usual splits from the lodging bill (maps Step A `direct payments fund care not accommodation` and exclusions theme; food, fuel, rent-style spend stays out of scope unless your council says otherwise, Confirm in WP).
5. **H2:** Personal health budgets versus local authority direct payments (maps AEO comparison; short contrast, link PHB official guidance when editor adds URLs).
6. **H2:** Questions for your social worker or council before you book (maps AEO checklist plus seed meta social worker promise; no invented paperwork list unless WP lists it).
7. **H2:** Personal assistants on a self-catering break (maps AEO PA on holiday; hours versus travel versus cover).
8. **H2:** How to plan a funded break without bespoke figures (maps AEO how do I plan; numbered steps, LA variation, link `/resources/` for hub routes; no invented four-week caps unless WP cites a source).
9. **H2:** Receipts and evidence for audits (**H3** PA, stay, and travel receipt splits: deep tables on `/personal-budget-short-break-care-act/`, not duplicated here).
10. **H2:** CHC overlap and next reads (**H3** Funding hub `/resources/`; CHC guide `/chc-respite-holiday-accommodation-uk/`; commissioner checklist `/commissioner-checklist-accessible-respite-stay/` when B2B readers need it).
11. **H2:** Whitstable area at Restwell (light stay bridge; Confirm in WP: ceiling track hoist versus tracking wording per access statement; kit proof on `/accessibility/` and `/the-property/`; `/enquire/` for dates).

**Avoid-ai-writing pass:** plain section labels, one question or job per H2, no filler intensifiers.

#### Step B - 2026-05-11 - [https://restwellretreats.co.uk/chc-respite-holiday-accommodation-uk/](https://restwellretreats.co.uk/chc-respite-holiday-accommodation-uk/)

**Scope:** `page.php` seeded NHS CHC guide (`/chc-respite-holiday-accommodation-uk/`). **Facts:** Repo anchors `inc/seo-content-seed.php` (`chc-respite-holiday-accommodation-uk` meta, CHC long-form seed); goal is panel-facing framing and CHC versus holiday lodging clarity without invented eligibility outcomes. **Banned phrase:** not used. **Hoist SERP note:** secondaries include `tracking hoist holiday accommodation`; T3 tests that phrase in the title; publish on-page and access statement should prefer **ceiling track hoist** unless WP confirms tracking.

**Title variants (~50 to 60 characters with trailing brand)**

1. `Accessible CHC respite: Whitstable cottage - Restwell Retreats` (62 characters). Puts **accessible**, **CHC respite**, and **Whitstable cottage** inside the first thirty-five characters while keeping the URL owner intent legible in SERPs.
2. `CHC respite holidays: Kent hoist, wet room - Restwell Retreats` (62 characters). Leads on CHC plus **Kent hoist** and **wet room** for commissioners who already know the funding label.
3. `Tracking hoist CHC respite: Whitstable UK - Restwell Retreats` (61 characters). Surfaces the **tracking hoist holiday accommodation** secondary for tests; confirm tracking versus ceiling track hoist before mirroring in body.

**Meta description variants (~150 to 160 characters)**

1. `CHC respite UK breaks: framing for panels, not advice. Quiet Whitstable cottage: hoist, profiling bed, wet room. See accessibility, enquire. Restwell Retreats.` (159 characters).
2. `Accessible self-catering Whitstable Kent: hoist, profiling bed, wet room. CHC versus holiday lodging, general facts. Read resources, enquire. Restwell Retreats.` (160 characters).
3. `Whitstable-area cottage: hoist, profiling bed, wet room, quiet stay. CHC respite guide for families and panels, not outcomes. Enquire. Restwell Retreats.` (153 characters).

**Recommended pick:** Title **1** plus Meta **1**. **Rationale:** Title **1** opens with **accessible** and **CHC respite** before **Whitstable cottage**, so the Step B brief and the funding page job read together without a duplicate `/direct-payment-holiday-accommodation/` title shape. Meta **1** leads with CHC and panel framing, states the YMYL limiter (not advice, not outcomes), carries both USPs (quiet Whitstable-area self-catering plus hoist, profiling bed, wet room), and splits proof to **See accessibility** before **enquire**.

**Human next:** Paste chosen title and meta into WP Search and Social. **Do not** edit `inc/seo.php` until a human confirms.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/chc-respite-holiday-accommodation-uk/](https://restwellretreats.co.uk/chc-respite-holiday-accommodation-uk/)

**Source:** §13.1 row for `/chc-respite-holiday-accommodation-uk/`; Step A keywords in `#### Run - 2026-05-10 - https://restwellretreats.co.uk/chc-respite-holiday-accommodation-uk/` (Tier 1: `chc respite holiday accommodation`, `chc respite holiday accommodation kent`, `chc respite holiday accommodation uk`, NHS CHC plus respite phrasing in content map); AEO mirror: §2.3 table under `#### Run - 2026-05-10 - /resources/ - legacy outline` (CHC definition, DP use, commissioner paperwork, personal budget versus CHC, who pays care versus lodging, carer self-catering plan) plus URL-specific AEO block in the same CHC run (what is, how to plan, who for, documents, overlap with DP or CHC). `#### Step B - 2026-05-11` same URL. Seed `focus_keyphrase` `chc respite holiday accommodation` (`inc/seo-content-seed.php`).

**Scope:** `page.php` seeded NHS CHC guide. **Facts:** Panel-facing framing and CHC versus holiday lodging clarity only; no invented eligibility outcomes. **Banned phrase:** not used. **YMYL:** cite NHS, DHSC, ICB, or council sources in drafts; Restwell stays a signpost, not a decision-maker.

**Ordered outline**

1. **H1 (one):** NHS Continuing Healthcare (CHC), respite, and self-catering accommodation: UK framing for panels (general guide, not advice) (maps Primary `chc respite holiday accommodation`, Tier 1 `NHS continuing healthcare respite holiday`, and slug-as-query `chc respite holiday accommodation uk`; single visible H1 in WP, Confirm in WP).
2. **H2:** What is NHS Continuing Healthcare (CHC) in relation to respite or holiday stays? (**H3** Why we do not state eligibility outcomes; maps §2.3 AEO definition row; 40 to 60 word lead plus official link; no case promises).
3. **H2:** Who is CHC respite holiday accommodation for? (maps CHC run AEO who; panels, families, carers, commissioners as audiences without invented roles).
4. **H2:** How do I plan CHC-linked respite or holiday accommodation? (maps CHC run AEO how to plan; numbered steps, area variation, cite official sources only).
5. **H2:** How does a personal budget differ from CHC for paying for a short break? (maps §2.3 comparison table intent; neutral X versus Y; link `/personal-budget-short-break-care-act/` for receipt depth).
6. **H2:** Who pays for what on an accessible self-catering break: care versus lodging? (maps §2.3 who pays; short paragraph plus bullets; no property kit table beyond seed or WP, Confirm in WP).
7. **H2:** Can direct payments be used for holiday or respite accommodation when readers confuse pots with CHC? (maps §2.3 DP question; brief caveats plus link `/direct-payment-holiday-accommodation/`, not duplicated steps).
8. **H2:** What paperwork or evidence might commissioners or panels expect? (**H3** Link `/commissioner-checklist-accessible-respite-stay/` for checklist depth; **H3** Confirm in WP: forms Restwell actually supplies; maps §2.3 commissioner row plus CHC run AEO documents).
9. **H2:** Kent CHC contacts and appeals routes (process snippet only; align with `/resources/` hub defaults such as Kent and Medway ICB CHC email where theme lists it; Confirm in WP on-page list matches live hub).
10. **H2:** After funding checks: Whitstable-area stay at Restwell (light commercial bridge; hoist, profiling bed, wet room per seed and Step B meta; proof on `/accessibility/` and `/the-property/`; `/enquire/` for dates; ceiling track hoist wording unless WP confirms tracking).
11. **H2:** Related reading and next steps (`/resources/` hub, `/carers-respite-holiday-guide/` when carer-led planning fits; optional `/faq/` funding answers as signposts only).

**Avoid-ai-writing pass:** declarative H1, question-shaped H2s match the worksheet, no filler intensifiers, no Unicode em dash in publish strings.

#### Step B - 2026-05-11 - [https://restwellretreats.co.uk/personal-budget-short-break-care-act/](https://restwellretreats.co.uk/personal-budget-short-break-care-act/)

**Scope:** `page.php` seeded Care Act funding guide (`/personal-budget-short-break-care-act/`). **Facts:** Repo anchor `inc/seo-content-seed.php` (`personal-budget-short-break-care-act`: meta_description theme splits PA hours, accommodation, and transport receipts; `focus_keyphrase` `personal budget short break care act`). **Banned phrase:** not used. **Hoist SERP note:** secondaries include `tracking hoist holiday accommodation`; T3 tests **Accessible Kent** in the title for the Step B brief; publish on-page prefers **ceiling track hoist** unless WP confirms tracking.

**Title variants (~50 to 60 characters with trailing brand)**

1. `Care Act budget breaks: receipts, splits - Restwell Retreats` (60 characters). Leads **Care Act** plus **receipts** and **splits** so the receipt-discipline URL job reads before the brand.
2. `Personal budget short break: Care Act - Restwell Retreats` (57 characters). Mirrors the seed focus query **personal budget short break care act** in the opening segment (Step A owner).
3. `Accessible Kent budget breaks: Care Act - Restwell Retreats` (59 characters). Puts **Accessible** and **Kent** in the first segment for the Step B geo plus access brief while keeping **Care Act** as the funding anchor.

**Meta description variants (~150 to 160 characters)**

1. `Care Act personal budgets: split PA, stay, and travel receipts. Whitstable-area self-catering with hoist, profiling bed, wet room. General guide only. Enquire.` (159 characters).
2. `Personal budget short breaks: Care Act receipt splits for respite. Accessible Kent self-catering near Whitstable, hoist, profiling bed, wet room. See resources.` (160 characters).
3. `Budget short breaks: PA, accommodation, and travel receipts (Care Act). Quiet Whitstable cottage, hoist, profiling bed, wet room. Read accessibility, enquire.` (158 characters).

**Recommended pick:** Title **2** plus Meta **1**. **Rationale:** Title **2** keeps the Step A and seed owner query visible in the first characters without copying `/direct-payment-holiday-accommodation/` title shape. Meta **1** opens on Care Act personal budgets and receipt splits (PA, stay, travel), names Whitstable-area self-catering with hoist, profiling bed, and wet room as the one-place USP, states the YMYL limiter (**general guide only**), and ends with **Enquire**. **Step A vs Step B brief:** Primary cell stays **personal budget short break care act**; long Step B equipment phrase sits in Secondaries for bridges and GSC tests (not the worksheet Primary until data says so). **Cannibal:** `/direct-payment-holiday-accommodation/` owns direct payment holiday language; `/chc-respite-holiday-accommodation-uk/` owns CHC; `/resources/` summarises; spec tables stay on `/accessibility/`. **Avoid-ai-writing pass:** short clauses, one job per sentence, no empty superlatives.

**Human next:** Paste chosen title and meta into WP Search and Social. **Do not** edit `inc/seo.php` until a human confirms.

#### Step B - 2026-05-11 - [https://restwellretreats.co.uk/commissioner-checklist-accessible-respite-stay/](https://restwellretreats.co.uk/commissioner-checklist-accessible-respite-stay/)

**Scope:** `page.php` seeded commissioner audit aid (`/commissioner-checklist-accessible-respite-stay/`). **Facts:** Repo anchors `inc/seo-content-seed.php` (`commissioner-checklist-accessible-respite-stay`, `focus_keyphrase` `commissioner accessible respite stay`, default meta mentions hoist paperwork and insurance certificates). **Goal:** checklist framing with links to proof pages, not invented certificates (Confirm in WP: align live body and Search and Social with that goal; seed meta may still need a body pass). **Banned phrase:** not used. **Hoist wording:** secondaries include `tracking hoist holiday accommodation`; M3 tests that phrase; publish on-page and access statement should prefer **ceiling track hoist** unless WP confirms tracking.

**Title variants (~50 to 60 characters with trailing brand)**

1. `Accessible commissioner checklist Kent - Restwell Retreats` (58 characters). Puts **Accessible** and **commissioner** inside the first thirty-one characters for B2B plus Step B intent before **Kent** and the brand.
2. `Commissioner checklist Whitstable hoist - Restwell Retreats` (59 characters). Leads on **commissioner checklist**, **Whitstable**, and **hoist** for slug-aligned navigational queries; **wet room** moves to the meta.
3. `Accessible respite checklist: hoist, Kent - Restwell Retreats` (61 characters). Stresses **accessible respite** plus **hoist** and **Kent** for families and panels who search without the word commissioner first.

**Meta description variants (~150 to 160 characters)**

1. `Commissioner checklist: hoist, profiling bed, wet room Whitstable. Kent coast self-catering. Read accessibility and property proof, enquire. Restwell Retreats.` (159 characters).
2. `Disabled-access Whitstable checklist: hoist, profiling bed, wet room. Kent self-catering. Proof on property and accessibility pages. Enquire. Restwell Retreats.` (160 characters).
3. `Tracking hoist Kent checklist: accessible self-catering Whitstable area. Profiling bed, wet room. Read accessibility and property, enquire. Restwell Retreats.` (158 characters).

**Recommended pick:** Title **1** plus Meta **1**. **Rationale:** Title **1** keeps commissioner and accessible early without duplicating the CHC or direct-payment title shapes. Meta **1** lists hoist, profiling bed, and wet room with Whitstable and Kent coast self-catering (both USPs), sends readers to **accessibility** and **property** for proof, and uses **enquire** as a single CTA so the page stays an audit aid, not a spec hub.

**Human next:** Paste chosen title and meta into WP Search and Social. **Do not** edit `inc/seo.php` until a human confirms.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/commissioner-checklist-accessible-respite-stay/](https://restwellretreats.co.uk/commissioner-checklist-accessible-respite-stay/)

**Source:** §13.1 row for `/commissioner-checklist-accessible-respite-stay/`; Step A Tier 1 to 2 and AEO table in §2.6 `#### Run - 2026-05-10 - https://restwellretreats.co.uk/commissioner-checklist-accessible-respite-stay/` (five questions); §16 B2 checklist row (*What paperwork do commissioners need for a funded adapted respite stay?*); plan §3.4 commissioner versus social worker note; `page.php` plus seed slug in `inc/seo-content-seed.php` per plan.

**Scope:** Commissioner audit aid. **Facts:** Proof stays on `/accessibility/` and `/the-property/`; no invented certificates (Confirm in WP live body and Search and Social). **Banned phrase:** not used. **Hoist wording:** **ceiling track hoist** on publish unless WP or access statement confirms tracking.

**Ordered outline**

1. **H1 (one):** Commissioner checklist for an accessible respite stay in Kent (echoes `commissioner accessible respite stay`, `commissioner checklist accessible respite stay`, Kent; Confirm in WP: hero or body H1 matches, no second competing H1).
2. **H2:** What this commissioner checklist covers (answers AEO: What is commissioner accessible respite stay? Short definition, panel-facing scope, not legal or clinical advice).
3. **H2:** Who should use it (answers AEO: Who is commissioner accessible respite stay for? Panels, social care, families; roles vary by council).
4. **H2:** How to plan a documented short break (answers AEO: How do I plan commissioner accessible respite stay? Ordered steps in body; Confirm in WP if you add dates).
5. **H2:** Document bundle for funded adapted stays (answers AEO: What documents do I need for commissioner accessible respite stay? plus §16 B2 paperwork question; bullet checklist in body; **H3** Property and access proofs, link `/accessibility/`, `/the-property/`; **H3** Panel forms or packs Restwell issues, Confirm in WP which PDFs or letters you supply).
6. **H2:** Commissioners, social workers, and who signs what (plan §3.4; plain vocabulary, no invented LA workflow).
7. **H2:** Where DP, CHC, and personal budgets overlap this stay (answers AEO: Where does commissioner accessible respite stay overlap with direct payments or CHC? Short comparison; link `/resources/`, `/direct-payment-holiday-accommodation/`, `/chc-respite-holiday-accommodation-uk/`, `/personal-budget-short-break-care-act/`; do not own those primaries here).
8. **H2:** How to read a cottage access statement before panel sign-off (link `/how-to-read-holiday-cottage-access-statement/`; keep Restwell numbers off this page unless quoted from the same PDF).
9. **H2:** Whitstable area context and kit wording at Restwell (Step A `commissioner accessible respite stay kent` or Whitstable variants; light bridge; hoist wording **ceiling track hoist** unless WP confirms tracking).
10. **H2:** Next steps and enquiries (link `/enquire/`).

**Step A echo:** commissioner accessible respite stay, commissioner checklist accessible respite stay, commissioner accessible respite stay checklist, commissioner accessible respite stay kent, commissioner checklist funded respite accommodation documentation (hypothesis row), plus secondaries in §13.1 worksheet.

**Avoid-ai-writing self-check:** Short section labels, concrete routes, no hollow intensifiers, no Unicode em dash in suggested publish strings.

**PHP:** none until editor maps headings in WP blocks; seed HTML order may differ from this ladder.

#### Step B - 2026-05-11 - [https://restwellretreats.co.uk/how-to-choose-accessible-self-catering-holiday/](https://restwellretreats.co.uk/how-to-choose-accessible-self-catering-holiday/)

**Scope:** `page.php` seeded long-form (`/how-to-choose-accessible-self-catering-holiday/`). **Facts:** Checklist angle (hoist, doors, wet room) matches plan comparator role; equipment claims in publish copy stay aligned with `/accessibility/` and `/the-property/` (Confirm in WP). **Banned phrase:** not used. **Hoist wording:** secondary includes `tracking hoist holiday accommodation`; on-page and meta use **ceiling track hoist** unless WP or supplier copy confirms tracking.

**Title variants (~50 to 60 characters with trailing brand)**

1. `Accessible hoist wet room Whitstable - Restwell Retreats` (56 characters). Puts **accessible**, **hoist**, **wet room**, and **Whitstable** inside the first thirty-five characters for the Step B brief.
2. `Kent accessible self-catering hoist pick - Restwell Retreats` (60 characters). Stronger echo of **accessible self catering Kent coast**; weaker on **wet room** in the title token budget.
3. `How to choose hoist wet room Whitstable - Restwell Retreats` (59 characters). Matches how-to and slug intent; **accessible** appears only after the first thirty characters if you count from the start of **How**.

**Meta description variants (~150 to 160 characters)**

1. `Check hoist, doors, and wet room before booking accessible self-catering near Whitstable. Quiet stay. Read accessibility and property pages, then enquire.` (154 characters).
2. `Accessible Kent coast self-catering: check hoist, doors, and wet room before a Whitstable-area booking. Quiet stay. See accessibility and property, then enquire.` (157 characters).
3. `Disabled-access Whitstable: hoist, profiling bed, and wet room in one place. Quiet self-catering. Read accessibility and property pages, then enquire.` (150 characters).

**Recommended pick:** Title **1** plus Meta **1**. **Rationale:** Title **1** lands the Step B primary fragments without mirroring the `/accessibility/` worksheet line (`Accessible cottage hoist & wet room Kent`). Meta **1** states the verifier job (hoist, doors, wet room), keeps accessible self-catering near Whitstable, adds the quiet-stay line, and routes proof reads to **accessibility** and **property** pages before **enquire**, matching the URL goal.

**Human next:** Paste chosen title and meta into WP Search and Social. **Do not** edit `inc/seo.php` until a human confirms.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/how-to-choose-accessible-self-catering-holiday/](https://restwellretreats.co.uk/how-to-choose-accessible-self-catering-holiday/)

**Source:** §13.1 row for `/how-to-choose-accessible-self-catering-holiday/`; Step A plus AEO in §2.6 `#### Run - 2026-05-10 - https://restwellretreats.co.uk/how-to-choose-accessible-self-catering-holiday/` (Tier 1 to 2 rows: hoist, doors, wet room, deposit, OT-before-booking, and related); AEO blocks at ~2597 (pillar five questions) and ~4248 (comparator five questions); `page.php` and `restwell_get_blog_post_self_catering_checklist_html()` in `inc/seo-content-seed.php` per plan.

**Scope:** Decision checklist URL. **Facts:** Verifier framing (hoist, doors, wet room) matches Step B meta; kit proof stays on `/accessibility/` and `/the-property/`. **Banned phrase:** not used. **Hoist wording:** use **ceiling track hoist** in publish strings unless WP or access statement confirms tracking.

**Ordered outline**

1. **H1 (one):** How to choose an accessible self-catering holiday: checks before you pay a deposit (echoes `how to choose accessible self catering holiday` and seed `accessible self-catering holiday`; Confirm in WP: hero or body H1 matches, no second competing H1).
2. **H2:** What we mean by accessible self-catering here (answers AEO: What is accessible self-catering holiday? Short definition, no over-claim).
3. **H2:** Who should use this checklist (answers AEO: Who is accessible self-catering holiday for? Carers, families, commissioners; link `/who-its-for/` if you add a one-line bridge).
4. **H2:** What to verify before you pay a deposit (answers AEO: What should I verify before paying a deposit on an accessible cottage? Checklist opener; ties Tier 1 deposit and OT-before-booking keywords).
5. **H2:** Hoist evidence and sling fit (answers AEO: How do I check hoist compatibility with my sling system on holiday? Process only; **H3** insist on written hoist type and safe working load in the access pack, Confirm in WP; link `/accessibility/` and `/the-property/` for Restwell numbers, not invented limits here).
6. **H2:** Door widths and circulation (answers Step A: door widths holiday cottage wheelchair; keep numbers on spec URLs unless this page quotes the same PDF).
7. **H2:** Wet rooms: roll-in versus walk-in claims (answers AEO: Is a wet room always roll-in for a wheelchair user? Definition plus caveat; link `/accessibility/` for room proof).
8. **H2:** Red phrases in listings (answers AEO: What red phrases in cottage listings suggest accessibility is overstated? Bullet warnings; no naming competitors).
9. **H2:** Access statements and panels (answers AEO: Who can help me assess a cottage access statement as a commissioner? Short process; link `/how-to-read-holiday-cottage-access-statement/` and `/commissioner-checklist-accessible-respite-stay/`).
10. **H2:** Deposits and cooling-off caution (answers Step A: accessible holiday listing scams deposit; YMYL-light; send insurance detail to `/travel-insurance-disability-uk-self-catering/` if you expand later).
11. **H2:** Documents, direct payments, and CHC overlap (answers AEO: Where does accessible self-catering holiday overlap with direct payments or CHC? One short signpost block; link `/resources/`, no duplicated funding primaries).
12. **H2:** Check this list at Restwell (soft close: `/the-property/`, `/accessibility/`, `/enquire/`; same kit lines as Step B meta, Confirm in WP).

**Step A echo:** accessible self-catering holiday, verify hoist specifications holiday cottage, door widths holiday cottage wheelchair, wet room versus walk in shower listing red flags, accessible holiday listing scams deposit, ot questions before booking accessible cottage, plus secondaries in §13.1 row.

**Avoid-ai-writing self-check:** Plain section labels, concrete routes, no hollow intensifiers, no Unicode em dash in suggested publish strings.

**PHP:** none until editor maps headings in WP blocks; seed HTML order may differ from this ladder.

#### Step B - 2026-05-11 - [https://restwellretreats.co.uk/what-to-pack-accessible-self-catering-uk/](https://restwellretreats.co.uk/what-to-pack-accessible-self-catering-uk/)

**Scope:** `page.php` seeded long-form (`/what-to-pack-accessible-self-catering-uk/`). **Facts:** Seed `meta_title`, `meta_description`, `focus_keyphrase`, post excerpt, and `restwell_get_blog_post_pack_accessible_self_catering_html()` in `inc/seo-content-seed.php` list hoist-adjacent categories (hoist extras, meds, continence, kitchen aids) and owner confirmation before travel. **Banned phrase:** not used. **Hoist wording:** secondary includes `tracking hoist holiday accommodation`; these metas keep generic **hoist** and sling wording; use **ceiling track hoist** on-page only if WP or the access statement confirms it, not unverified **tracking**.

**Title variants (~50 to 60 characters with trailing brand)**

1. `Accessible pack: hoist, wet room Whitstable - Restwell Retreats` (63 characters). **Accessible**, **hoist**, **wet room**, and **Whitstable** sit in the first segment before the brand.
2. `Self-catering Kent pack: hoist, Whitstable - Restwell Retreats` (62 characters). Stronger echo of **accessible self catering Kent coast**; **wet room** omitted from the title token budget.
3. `Disabled-access pack list Whitstable Kent - Restwell Retreats` (61 characters). Stronger **disabled access holiday cottage Whitstable** phrasing; lighter explicit **wet room** in the title.

**Meta description variants (~150 to 160 characters)**

1. `Pack for accessible Kent self-catering near Whitstable: hoist slings, meds, continence. Profiling bed, wet room on site. Read accessibility. Restwell Retreats.` (159 characters).
2. `Whitstable packing: hoist slings, meds, continence. Kent accessible self-catering with hoist, profiling bed, wet room. Read accessibility. Restwell Retreats.` (157 characters).
3. `Kent accessible packing: hoist slings, meds, continence. Self-catering Whitstable area. Hoist, profiling bed, wet room. Confirm with owner. Restwell Retreats.` (158 characters).

**Recommended pick:** Title **1** plus Meta **1**. **Rationale:** Title **1** keeps the checklist URL honest as a **pack** line while still loading the Step B brief fragments (accessible, hoist, wet room, Whitstable) before the brand. Meta **1** lists hoist-adjacent travel categories that match the seed (slings map to hoist extras, meds, continence), states profiling bed and wet room as the one-place USP without inventing extra kit, and uses **Read accessibility** as the single CTA so spec depth stays on `/accessibility/`. **Avoid-ai-writing pass:** short clauses, no stacked moreover transitions, no empty superlatives.

**Human next:** Paste chosen title and meta into WP Search and Social. **Do not** edit `inc/seo.php` until a human confirms.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/what-to-pack-accessible-self-catering-uk/](https://restwellretreats.co.uk/what-to-pack-accessible-self-catering-uk/)

**Source:** §13.1 row for this URL; Step A plus AEO in `#### Run - 2026-05-10 - https://restwellretreats.co.uk/what-to-pack-accessible-self-catering-uk/` (§2.6 Tier table ~4351 and **AEO (≥5)** ~4371); §2.3 AEO table ~2777 in the same slug run; `page.php` and `restwell_get_blog_post_pack_accessible_self_catering_html()` in `inc/seo-content-seed.php`.

**Scope:** Practical packing checklist. **Facts:** Hoist table row in seed uses generic **Track, motor** wording for adapted stays, not a Restwell-only equipment promise (Confirm in WP live table if you publish property-specific columns). **Banned phrase:** not used. **Hoist wording:** use **ceiling track hoist** in publish strings unless WP or the access statement confirms **tracking** (matches §13.1 secondaries note).

**Ordered outline**

1. **H1 (one):** What to pack for an accessible self-catering break in the UK (echoes seed post `title` and slug query `what to pack accessible self catering uk`; Confirm in WP: no second H1 in hero or blocks).
2. **H2:** What an accessible holiday packing list is here (answers §2.3: What is accessible holiday packing list uk?; ties seed `focus_keyphrase` **accessible holiday packing list uk**).
3. **H2:** Who should use this list (answers §2.3: Who is accessible holiday packing list uk for?; carers, families, commissioners in plain terms).
4. **H2:** Why self-catering packing trips fail without clinical buffers (answers §2.3 anxiety theme plus seed **Why packing trips fail disabled travellers**).
5. **H2:** Supplied at the property versus packed by you (seed comparison table; keep generic owner column labels unless WP states Restwell stock).
6. **H2:** Continence care in a self-catering cottage (answers §2.6 AEO: What should I pack for continence care in a self-catering cottage?; Step A **continence supplies holiday cottage packing**).
7. **H2:** Hoist accessories when the room has a track hoist (answers §2.6 AEO: What hoist accessories should I bring if the cottage has a track hoist?; Step A **hoist extras to pack self catering**; sling SWL and type Confirm on `/accessibility/`, not invented here).
8. **H2:** Medication and feeds for a UK self-catering week (answers §2.6 AEO: How do I pack medication for a UK self-catering week safely?; Step A **medication refrigeration holiday uk cottage**; fridge space Confirm in WP).
9. **H2:** Kitchen aids disabled guests still pack (answers §2.6 AEO: What kitchen aids should disabled guests pack for self catering?; Step A **kitchen aids accessible self catering packing**).
10. **H2:** What to email the owner before you pack (answers §2.6 AEO: What should I email the owner before I pack for an accessible break?; Step A **confirm with owner before travel accessible stay**; link `/how-to-choose-accessible-self-catering-holiday/`).
11. **H2:** How to plan packing before you travel (answers §2.3: How do I plan accessible holiday packing list uk?; merges seed **Practical steps before you lock the door** ordered list).
12. **H2:** Documents to pack for commissioners or carers (answers §2.3: What documents do I need for accessible holiday packing list uk?; seed FAQ on MAR charts and consent).
13. **H2:** Where DP or CHC checks overlap packing proof (answers §2.3: Where does accessible holiday packing list uk overlap with direct payments or CHC?; short signpost to `/resources/`, no funding primaries).
14. **H2:** Common packing mistakes (seed bullet list).
15. **H2:** Frequently asked questions (seed; **H3** Should I bring my own shower chair?; **H3** How many spare sling loops?; **H3** Can I bring a second fridge for meds?; **H3** What paperwork helps carers?; **H3** Where do I double-check house specifics?).
16. **H2:** Related guides and enquiries (seed **Closing** links: beaches, blog, hire or insurance clusters as editor sets; `/enquire/` when Whitstable is on the shortlist).

**Step A echo:** accessible holiday packing list uk, hoist extras to pack self catering, continence supplies holiday cottage packing, medication refrigeration holiday uk cottage, kitchen aids accessible self catering packing, confirm with owner before travel accessible stay, plus Tier 2 rows only when body has evidence.

**Avoid-ai-writing self-check:** Concrete section labels, no empty intensifiers, no Unicode em dash in suggested publish strings.

**PHP:** none until editor reorders WP blocks; seed HTML section order may differ from this ladder.

#### Step B - 2026-05-11 - [https://restwellretreats.co.uk/hire-mobility-scooter-equipment-uk-holiday/](https://restwellretreats.co.uk/hire-mobility-scooter-equipment-uk-holiday/)

**Scope:** `page.php` seeded equipment-hire guide (`/hire-mobility-scooter-equipment-uk-holiday/`). **Facts:** Plan §3 intent map and §2.6 runs anchor `hire mobility equipment uk holiday` plus cluster `hire mobility equipment uk holiday kent` (`inc/seo-content-seed.php` slug `hire-mobility-scooter-equipment-uk-holiday`; **Confirm in WP** live body for supplier names, coverage, and any hire inventory list). **Page goal (editor):** measurements, insurance, handover photos, no supplier claims without evidence. **Banned phrase:** not used. **Hoist wording:** secondary lists `tracking hoist holiday accommodation`; metas use **hoist** without asserting tracking versus ceiling track on this hire URL (type detail stays on `/accessibility/` and `/the-property/`).

**Title variants (~50 to 56 characters with trailing brand)**

1. `Mobility hire UK holiday: checklist - Restwell Retreats` (55 characters). **Mobility hire** plus **UK holiday** sit inside the first segment for hire intent before the brand.
2. `Mobility equipment hire: UK holidays - Restwell Retreats` (56 characters). Stronger **hire mobility equipment** echo; lighter **checklist** signal in the title.
3. `Mobility hire holidays UK: Kent tips - Restwell Retreats` (56 characters). Surfaces **Kent** and **holidays** for coast planners; checklist depth moves to the meta.

**Meta description variants (~150 to 154 characters)**

1. `Mobility hire UK holidays: measurements, insurance, handover photos. Whitstable self-catering: hoist, profiling bed, wet room. See accessibility, enquire.` (154 characters).
2. `UK holiday mobility hire: measurements, insurance, handover photos. Whitstable-area self-catering with hoist, profiling bed, wet room. Enquire online.` (150 characters).
3. `Mobility equipment hire UK: sizes, insurance, handover photos. Kent coast accessible self-catering Whitstable: hoist, wet room, profiling bed. Enquire.` (151 characters).

**Recommended pick:** Title **1** plus Meta **1**. **Rationale:** Title **1** keeps hire plus UK holiday in the opening scan line and signals the checklist job without competing with property URLs. Meta **1** names the three editor goals (measurements, insurance, handover photos), states Whitstable self-catering with hoist, profiling bed, and wet room as the one-place stay bridge (Confirm in WP: matches access statement), and sends spec readers to **See accessibility** before **enquire**. **Step A vs brief:** Primary for this URL stays **hire mobility equipment UK holiday** (seed and §3); phrase **accessible holiday cottage hoist and wet room Whitstable Kent** is a **secondary bridge** only, not the SERP owner here. **Cannibal:** keep hoist measurements and PDF on `/accessibility/`; keep adapted bungalow proof on `/the-property/`; this URL owns hire logistics. **Avoid-ai-writing pass:** plain verbs, no stacked intensifiers, no fake urgency.

**Human next:** Paste chosen title and meta into WP Search and Social. **Do not** edit `inc/seo.php` until a human confirms.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/hire-mobility-scooter-equipment-uk-holiday/](https://restwellretreats.co.uk/hire-mobility-scooter-equipment-uk-holiday/)

**Source:** §13.1 row for this URL; Step A Tier 1 to 3 and AEO table in `#### Run - 2026-05-10 - https://restwellretreats.co.uk/hire-mobility-scooter-equipment-uk-holiday/` (§2.6, lines ~2995 to ~3071 and ~4521 to ~4573); §2.3 AEO question set (same run, mirrored generic stems); `#### Step B - 2026-05-11` same URL. **Repo:** `page.php`; body HTML from `restwell_get_blog_post_hire_mobility_equipment_uk_html()` in `inc/seo-content-seed-blog-cluster-a.php` (Confirm in WP: live blocks may reorder headings).

**Scope:** Equipment hire planning guide. **Facts:** Seed body covers mobility scooters, profiling beds, shower chairs, and short hire-versus-bring-from-home decisions; seed FAQ mentions mobile gantry hoists with ceiling assessments and notes ceiling tracks are property-fixed (Confirm in WP: live body for any supplier names, coverage, or inventory; do not invent vendor partnerships). **Banned phrase:** not used. **Hoist wording:** keep generic **hoist** and **ceiling track hoist** language; only state **tracking** if WP or the access statement on `/accessibility/` confirms it. **Page goal anchors:** measurements, insurance, and handover photos.

**Ordered outline**

1. **H1 (one):** Hire mobility equipment for a UK holiday: measurements, insurance, and handover photos (echoes seed `meta_title` plus editor page goal; Confirm in WP: one visible H1 in hero or page blocks).
2. **H2:** What mobility equipment hire on holiday is (answers §2.3: What is hire mobility equipment uk holiday?; matches seed body H2 **What is mobility equipment hire on holiday?**; short-term rental from NHS wheelchair services partners or private firms, delivered to the cottage or collected from a depot).
3. **H2:** Who this hire guide is for (answers §2.3: Who is hire mobility equipment uk holiday for?; carers, families, commissioners, OT planners scoping kit ahead of a stay).
4. **H2:** Why hire decisions trip people up (seed body H2 **Why hire decisions trip people up**; coastal humidity affects batteries, narrow terraces block turning circles, charging sockets sit on the wrong wall).
5. **H2:** Measurements to confirm before you book (page goal plus §2.6 AEO: What measurements do I need before hiring a mobility scooter for a cottage?; Step A **mobility scooter hire holiday cottage measurements**).
  - **H3:** Door widths and thresholds (link `/how-to-choose-accessible-self-catering-holiday/` for the property checklist; spec numbers stay on `/accessibility/`).
  - **H3:** Tyre width and folded length (seed body sub-section **Scooters and powerchairs** mentions tyre width, folded length, and ramp gradient limits).
  - **H3:** Turning circles and ramp gradient (seed body language; Confirm in WP: property turning-circle figures stay on `/accessibility/` or `/the-property/`).
6. **H2:** How to match kit to property geometry (seed body H2; mirrors the **fit before order** intent in §2.6 cannibalization notes).
  - **H3:** Scooters and powerchairs (seed H3; tyre width, folded length, ramp gradient limits).
  - **H3:** Bathroom aids (seed H3; seat heights versus transfer technique; rental PVC differs from home moulded seats).
  - **H3:** Beds and mattresses (seed H3; profiling hire must clear ceiling hoist paths already installed; ceiling-track wording stays on `/accessibility/`).
7. **H2:** Insurance and excess when hire kit fails (page goal plus §2.6 AEO: Does holiday insurance cover hired mobility scooters in the UK?; Step A **mobility hire insurance small print uk**; damage waiver versus traveller policy, who pays first pound; link `/travel-insurance-disability-uk-self-catering/`; no product picks).
8. **H2:** Delivery slots and how far ahead to book (answers §2.6 AEO: How far in advance should I book delivery of a profiling bed to a holiday let?; Step A **delivery slots mobility equipment holiday address**; seed Practical booking checklist plus peak-season warning).
9. **H2:** Hire versus bring from home (seed body H2 plus **Choose hire when transport risk outweighs familiarity** table; airline or van damage risk, setup time, insurance excess, peak season stock).
10. **H2:** Handover photos and condition sheets (page goal plus §2.6 AEO: Should I photograph mobility equipment at handover for a holiday hire?; Step A **profiling bed hire holiday handover photos**; seed FAQ **What if equipment arrives damaged?** drives refusal of sign-off, photographing scrapes, demanding replacement before transfer attempts).
11. **H2:** What to do if hired equipment will not fit through the doorway (answers §2.6 AEO: What happens if hired equipment does not fit through the cottage doorway?; bridge to `/how-to-choose-accessible-self-catering-holiday/` for early checks; do not promise hire-firm swap windows beyond seed copy).
12. **H2:** Practical booking checklist (seed body H2; serial photos of actual units (not catalogue renders), evening breakdown helpline hours, delivery aligned with someone able to sign and test brakes, adapters named on the packing list; link `/what-to-pack-accessible-self-catering-uk/`).
13. **H2:** Common hire mistakes (seed body H2; late August bank holiday booking, ignoring battery cooling rules after beach humidity, informal deposits bypassing VAT receipts commissioners need, skipping compatibility checks with rental shower chairs and grab rails).
14. **H2:** Documents to share with commissioners or care teams (answers §2.3: What documents do I need for hire mobility equipment uk holiday?; Step A Tier 2 **hire mobility equipment uk holiday commissioner**; VAT receipts, hire contract, breakdown PDF, condition photos; signpost `/commissioner-checklist-accessible-respite-stay/`).
15. **H2:** Where hire planning overlaps with direct payments or CHC (answers §2.3: Where does hire mobility equipment uk holiday overlap with direct payments or CHC?; short signpost to `/resources/`, `/direct-payment-holiday-accommodation/`, `/chc-respite-holiday-accommodation-uk/`; no eligibility promises and no funding primaries duplicated here).
16. **H2:** Frequently asked questions (seed FAQ block kept; **H3** Does NHS wheelchair services cover Kent holidays? (some regions loan vacation kits, others refuse outside boundaries); **H3** Who fixes a flat tyre on hire? (contract spells roadside repair or swap-out; keep that PDF on your phone); **H3** Can I hire a hoist? (mobile gantry hires exist but need ceiling assessments; ceiling tracks are property-fixed, see `/accessibility/`); **H3** Should I tell insurers? (yes; link `/travel-insurance-disability-uk-self-catering/`); **H3** What if equipment arrives damaged? (refuse sign-off, photograph scrapes, demand replacement before transfer attempts)).
17. **H2:** Related guides and enquiries (seed **Closing**; link `/blog/`, `/what-to-pack-accessible-self-catering-uk/`, `/travel-insurance-disability-uk-self-catering/`, `/accessibility/`, `/the-property/`, `/enquire/`).

**Step A echo:** hire mobility equipment uk holiday, hire mobility equipment uk holiday kent, mobility scooter hire holiday cottage measurements, shower chair hire self catering uk, profiling bed hire holiday handover photos, mobility hire insurance small print uk, delivery slots mobility equipment holiday address, hire mobility equipment uk holiday checklist, hire mobility equipment uk holiday carers, hire mobility equipment uk holiday commissioner; Tier 2 hoist, battery, kerb-weight, and damage-waiver rows only when body has evidence.

**Cannibalization (per §2.6 run):** hire logistics own this URL; verify-before-order stays on `/how-to-choose-accessible-self-catering-holiday/`; insurance limits stay on `/travel-insurance-disability-uk-self-catering/`; property-owned hoist and wet room proof stay on `/accessibility/` and `/the-property/`; train with scooter stays on `/accessible-train-travel-whitstable-kent/`.

**Avoid-ai-writing self-check:** Concrete section labels, no empty intensifiers, no banned phrase, no Unicode em dash in any suggested publish strings; hoist wording stays generic unless WP confirms tracking.

**PHP:** none until editor reorders WP blocks; seed HTML section order in `restwell_get_blog_post_hire_mobility_equipment_uk_html()` may differ from this ladder.

#### Step B - 2026-05-11 - [https://restwellretreats.co.uk/holiday-backup-plan-care-worker-change/](https://restwellretreats.co.uk/holiday-backup-plan-care-worker-change/)

**Scope:** `page.php` seeded contingency guide (`/holiday-backup-plan-care-worker-change/`). **Facts:** Seed `meta_title`, `meta_description`, and `focus_keyphrase` in `inc/seo-content-seed.php` name holiday backup when care workers change or cancel, contingency cards, agency tiers, budgets for emergency cover, and safe escalation (no invented kit list on this URL beyond the stay bridge). **Page goal:** calm operational escalation realism for families and bookers when a carer drops mid-trip. **Banned phrase:** not used. **Step A vs Step B brief:** **Primary** stays **holiday backup plan care worker** (seed and §2.6 run **2026-05-10**); phrase **accessible holiday cottage hoist and wet room Whitstable Kent** sits in **Secondaries** for the Step B equipment pack. **Hoist wording:** secondary lists `tracking hoist holiday accommodation`; metas use **hoist** without asserting tracking versus ceiling track (Confirm in WP: align with access statement on `/accessibility/`).

**Title variants (~56 to 64 characters with trailing brand)**

1. `Holiday backup plan care worker Kent - Restwell Retreats` (56 characters). Loads **holiday backup plan care worker** plus **Kent** in the first segment so the Step A owner matches seed and slug intent before the brand.
2. `Accessible Whitstable backup: carer change - Restwell Retreats` (62 characters). Puts **Accessible** and **Whitstable** early for the Step B brief while keeping the carer-change job visible.
3. `Care worker change: holiday backup plan Kent - Restwell Retreats` (64 characters). Slug-echo **care worker change** plus **holiday backup plan** for navigational scans.

**Meta description variants (~150 to 159 characters)**

1. `Holiday backup when carers change: cards, agency tiers, escalation. Kent self-catering Whitstable: hoist, profiling bed, wet room. Read accessibility, enquire.` (159 characters).
2. `When carers cancel: budgets, agency tiers, escalation. Accessible Kent self-catering Whitstable: hoist, profiling bed, wet room. Read accessibility, enquire.` (157 characters).
3. `Holiday backup if your carer changes: agency tiers, escalation order. Accessible Kent self-catering Whitstable: hoist, profiling bed, wet room. Enquire.` (152 characters).

**Recommended pick:** Title **1** plus Meta **1**. **Rationale:** Title **1** keeps the seed focus phrase and Kent inside the first scan line for the contingency query, not a duplicate property-title shape. Meta **1** mirrors seed themes (cards, agency tiers, escalation), states both USPs (Kent self-catering Whitstable plus hoist, profiling bed, wet room together), and sends proof readers to **Read accessibility** before **enquire** without claiming tracking hoist wording. **Cannibal:** carers rights and assessment depth stay on `/carers-respite-holiday-guide/`; equipment proof stays on `/accessibility/` and `/the-property/`. **Avoid-ai-writing pass:** short clauses, no stacked hype, no empty superlatives.

**Human next:** Paste chosen title and meta into WP Search and Social. **Do not** edit `inc/seo.php` until a human confirms.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/holiday-backup-plan-care-worker-change/](https://restwellretreats.co.uk/holiday-backup-plan-care-worker-change/)

**Source:** §13.1 row for this URL; Step A Tier 1 to 2 plus **AEO questions** table in `#### Run - 2026-05-10 - https://restwellretreats.co.uk/holiday-backup-plan-care-worker-change/` (§2.6, ~3619 to ~3671); `#### Step B - 2026-05-11` same URL; `page.php` plus slug `holiday-backup-plan-care-worker-change` in `inc/seo-content-seed.php` (Confirm in WP: live body matches seed HTML).

**Scope:** Contingency planning when carers change or cancel before or during a break; calm escalation, no invented equipment list beyond the stay bridge. **Banned phrase:** not used.

**Ordered outline (H1, then H2, then H3):**

1. **H1:** Holiday backup plan when care workers change or cancel on a break (Kent context; primary **holiday backup plan care worker**; Confirm in WP: one visible H1).
2. **H2:** What a holiday backup plan is in this guide (answers AEO: What is holiday backup plan care worker?; contingency cards, safe scope, not tailored legal advice).
3. **H2:** How to build your backup plan before you travel (answers AEO: How do I plan holiday backup plan care worker?; **H3** Named workers and rotas; **H3** Agency contacts, tiers, and budgets for emergency cover; **H3** Escalation order when the roster fails; Confirm in WP seed section order and wording).
4. **H2:** Who should own and refresh the plan (answers AEO: Who is holiday backup plan care worker for?; families, unpaid carers, commissioners when the body supports it).
5. **H2:** Documents and checklist items before a change (answers AEO: What documents do I need for holiday backup plan care worker?; Tier 2 **checklist** keyword; PDF row Confirm in WP).
6. **H2:** Where direct payments or CHC meet emergency cover (answers AEO: Where does holiday backup plan care worker overlap with direct payments or CHC?; `/resources/`, `/direct-payment-holiday-accommodation/`, `/chc-respite-holiday-accommodation-uk/` signposts only, no outcome promises).
7. **H2:** Mid-stay care worker or roster change on a UK trip (slug **change** and hypothesis **respite holiday backup plan care worker roster change**; light cross-link `/carers-respite-holiday-guide/`).
8. **H2:** Local travel backups near Whitstable (Tier 2 parking and train intents; links `/accessible-parking-whitstable-tankerton/`, `/accessible-train-travel-whitstable-kent/`; no new venue or council tariff claims here).
9. **H2:** After plans are clear, check the property before you book (stay bridge: hoist, profiling bed, wet room; `/accessibility/`, `/the-property/`, `/enquire/`; publish **ceiling track hoist** unless WP confirms tracking).
10. **H2:** Related guides (cluster anchors editor sets; insurance stays `/travel-insurance-disability-uk-self-catering/` if you add a line, Confirm in WP).

**Step A echo:** holiday backup plan care worker, holiday backup plan care worker kent, holiday backup plan care worker whitstable, holiday backup plan care worker change, holiday backup plan care worker checklist, holiday backup plan care worker carers, holiday backup plan care worker commissioner (when body backs B2B lines), respite holiday backup plan care worker roster change (hypothesis).

**Avoid-ai-writing self-check:** Section labels name tasks, routes, and limits; no stacked intensifiers; ASCII hyphens only.

**PHP:** none until editor maps H2 bands in WP blocks; seed HTML order may differ from this ladder.

#### Step B - 2026-05-11 - [https://restwellretreats.co.uk/travel-insurance-disability-uk-self-catering/](https://restwellretreats.co.uk/travel-insurance-disability-uk-self-catering/)

**Scope:** `page.php` seeded insurance YMYL guide (`/travel-insurance-disability-uk-self-catering/`). **Facts:** Seed `meta_title`, `meta_description`, and `focus_keyphrase` in `inc/seo-content-seed.php` (`travel-insurance-disability-uk-self-catering`) list mobility equipment limits, pre-existing conditions, cancellation triggers, and broker questions. **Page goal:** broker questions and coverage angles, no named products unless the editor supplies them. **Banned phrase:** not used. **Step A vs brief:** **Primary** stays **travel insurance disability uk self catering** (seed and §3 intent row); the Step B accommodation phrase sits in **Secondaries** as a bridge to Whitstable-area self-catering with hoist, profiling bed, and wet room (Confirm in WP: on-page does not over-claim hoist coverage beyond the guide text). **Hoist wording:** secondary lists `tracking hoist holiday accommodation`; metas use **hoist** without asserting tracking versus ceiling track (type detail stays on `/accessibility/` and `/the-property/`).

**Title variants (~50 to 64 characters with trailing brand)**

1. `Travel insurance disability UK self-catering - Restwell Retreats` (64 characters). Loads **travel insurance**, **disability**, **UK**, and **self-catering** in the first segment so the Step A owner matches the slug intent before the brand.
2. `Disability travel insurance broker questions UK - Restwell Retreats` (67 characters). Leads on **disability** plus **broker questions** for commissioners and funding-aware bookers scanning for a checklist tone.
3. `UK accessible self-catering travel insurance - Restwell Retreats` (64 characters). Echoes **accessible self catering Kent coast** and keeps **travel insurance** inside the scan line for mixed intent tests.

**Meta description variants (~150 to 160 characters)**

1. `Travel insurance, disability, UK self-catering: broker kit, cancellation. Quiet Whitstable hoist, profiling bed, wet room. Not advice. Restwell Retreats.` (153 characters).
2. `Travel insurance disability UK self-catering: ask brokers about kit limits and cancellation. Accessible Kent coast stays. No product picks. Restwell Retreats.` (158 characters).
3. `Hoist or wet room Kent trip? Travel insurance UK self-catering, disability: broker questions, no product picks. Quiet Whitstable-area breaks. Restwell Retreats.` (160 characters).

**Recommended pick:** Title **1** plus Meta **1**. **Rationale:** Title **1** keeps the seed focus order and the first thirty characters on the commercial insurance job, not a duplicate property PDP title. Meta **1** opens with travel insurance, disability, and UK self-catering, names broker kit and cancellation angles that match the seed description, adds quiet Whitstable plus hoist, profiling bed, and wet room as the one-place stay bridge without naming products, and states **Not advice** for YMYL limits. **Avoid-ai-writing pass:** short clauses, no stacked transition fillers, no hollow superlatives.

**Human next:** Paste chosen title and meta into WP Search and Social. **Do not** edit `inc/seo.php` until a human confirms.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/travel-insurance-disability-uk-self-catering/](https://restwellretreats.co.uk/travel-insurance-disability-uk-self-catering/)

**Source:** §13.1 row for this URL; Step A and Tier tables in `#### Run - 2026-05-10 - https://restwellretreats.co.uk/travel-insurance-disability-uk-self-catering/` (§2.6, ~~3122); **AEO questions** table same run (~~3166 to ~3174); `#### Step B - 2026-05-11` same URL; `page.php` plus `restwell_get_blog_post_travel_insurance_disability_uk_html()` in `inc/seo-content-seed-blog-cluster-a.php`.

**Scope:** Insurance YMYL primer, broker questions and coverage angles only. **Facts:** Seed blockquote, H2 order, table rows, lists, and FAQ H3s trace to that PHP function (Confirm in WP: live blocks override seed). **Banned phrase:** not used. **Hoist wording:** stay bridge uses generic **hoist** with profiling bed and wet room; publish **ceiling track hoist** only if WP or the access statement confirms tracking (secondaries in §13.1). **Products:** do not name insurers or products unless the editor supplies them.

**Ordered outline**

1. **H1 (one):** Travel insurance, disability, and UK self-catering (matches Step A primary **travel insurance disability uk self catering** and seed `meta_description` themes; Confirm in WP: single visible H1, no duplicate hero line).
2. **H2:** What this topic covers on a UK break (answers AEO: What is travel insurance disability uk self catering?; plain definition of disability-aware cover checks, not legal advice).
3. **H2:** Who should read this (answers AEO: Who is travel insurance disability uk self catering for?; disabled guests, carers, commissioners, funding-aware bookers in short terms).
4. **H2:** How to plan cover before you pay (answers AEO: How do I plan travel insurance disability uk self catering?; broker email trail, compare schedules, no named products).
5. **H2:** Evidence and documents to gather (**H3** Valuations, **H3** Photos, **H3** Medication list; answers AEO: What documents do I need...?; matches seed subsection titles).
6. **H2:** Where direct payments or CHC meet policy wording (answers AEO: Where does ... overlap with direct payments or CHC?; short signpost to `/resources/`, `/direct-payment-holiday-accommodation/`, `/chc-respite-holiday-accommodation-uk/`; not funding or legal advice).
7. **H2:** Why UK self-catering claims fail (seed **Why claims fail for UK breaks**; equipment theft, PA drop-out, illness clause gaps).
8. **H2:** How policies differ on mobility kit and hire (seed table **How policies differ on kit**; broker column; link `/hire-mobility-scooter-equipment-uk-holiday/` for hire overlap only).
9. **H2:** Practical steps before you travel (seed **Practical steps** list; written confirmations for hoists and hired beds stay generic).
10. **H2:** Mistakes that void cover (seed **Common mistakes** bullets).
11. **H2:** Frequently asked questions (seed **H3** EHIC scope, NHS CHC declaration, beach injury clauses, hired WAV duplication, vague wording plus charity or **resources hub** signpost).
12. **H2:** Whitstable-area stay after insurance checks (soft bridge: hoist, profiling bed, wet room; proof on `/accessibility/`, `/the-property/`, book via `/enquire/`; Confirm in WP: kit list matches access statement, no extra hoist claims).
13. **H2:** Related guides (seed **Closing**; `/blog/`, `/enquire/`; keep `/resources/` once for funding context).

**Step A echo:** travel insurance disability uk self catering, Kent or Whitstable modifiers in secondaries only when body supports them, checklist and faq Tier 2 rows if sections exist, carers or commissioner secondaries when prose names those readers.

**Avoid-ai-writing self-check:** Short section labels, concrete broker and document nouns, no stacked filler transitions, no Unicode em dash in suggested publish strings.

**PHP:** none until editor maps headings in WP blocks; seed HTML order may differ from this ladder (reorder blocks to match when you adopt this outline).

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/how-to-read-holiday-cottage-access-statement/](https://restwellretreats.co.uk/how-to-read-holiday-cottage-access-statement/)

**Source:** §13.1 row for this URL; Step A and AEO tables in `#### Run - 2026-05-10 - https://restwellretreats.co.uk/how-to-read-holiday-cottage-access-statement/` (§2.6, ~~3697 to ~3763); §16 B2 AEO-priority note (~~6358); `#### Step B - 2026-05-11` for this URL in §4.1 immediately after this block; `page.php` plus slug `how-to-read-holiday-cottage-access-statement` in `inc/seo-content-seed.php` (Confirm in WP: long-form HTML source matches cluster wiring).

**Scope:** Education for OTs, families, carers, and commissioners: read listing blurbs and PDF access statements without duplicating measured property tables on this URL. **Facts:** Headings mirror plan keywords and five AEO rows only; numbers, door widths, and PDF proof stay on `/accessibility/` (**Confirm in WP** before any pasted measurements in blocks). **Banned phrase:** not used. **Hoist wording:** publish **ceiling track hoist** unless WP or the access statement confirms tracking (secondaries in §13.1).

**Ordered outline**

1. **H1 (one):** How to read a holiday cottage access statement before you book (echoes Step A **holiday cottage access statement** plus navigational **how to read holiday cottage access statement**; Confirm in WP: single visible H1).
2. **H2:** What a holiday cottage access statement is (answers AEO: What is holiday cottage access statement?; UK self-catering context; short definition, not a spec table duplicate of `/accessibility/`).
3. **H2:** How to read a statement in order when time is tight (answers AEO: How do I plan holiday cottage access statement?; numbered skim, biggest risks first).
4. **H2:** Who uses these statements (answers AEO: Who is holiday cottage access statement for?; OTs, families, carers, commissioners).
5. **H2:** Measurements and kit lines to insist on (**H3** hoist wording and sling fit questions; **H3** wet room, doors, and circulation; **H3** parking or arrival only if the PDF raises them; local parking depth on `/accessible-parking-whitstable-tankerton/` when relevant; widths and PDF on `/accessibility/` only, **Confirm in WP** before quoting numbers).
6. **H2:** PDFs, downloads, and version dates (Tier 2 **holiday cottage access statement pdf**; **Confirm in WP** if a file is offered).
7. **H2:** Checklist for panels and paperwork (answers AEO: What documents do I need for holiday cottage access statement?; Tier 2 **holiday cottage access statement checklist**; optional link `/commissioner-checklist-accessible-respite-stay/` if live copy matches).
8. **H2:** Where funding routes meet the statement (answers AEO: Where does holiday cottage access statement overlap with direct payments or CHC?; signpost `/resources/` and linked guides, not personal advice).
9. **H2:** Kent or Whitstable wording on generic PDFs (Tier 1 geo secondaries when the body scopes local framing; no invented local kit claims).
10. **H2:** Red phrases and email checks before a deposit (vague comfort words without numbers; internal link `/how-to-choose-accessible-self-catering-holiday/` for deposit-stage checks).
11. **H2:** Where to read Restwell measurements next (§16 B2 hand-off; `/accessibility/` for PDF and dimensions; `/the-property/` for commercial proof; `/enquire/` when ready).

**Step A echo:** holiday cottage access statement, holiday cottage access statement kent, how to read holiday cottage access statement; Tier 2 checklist, pdf, carers or commissioner secondaries when the body supports them.

**Avoid-ai-writing self-check:** Short labels, concrete nouns (PDF, panel, deposit), no filler stacks, ASCII hyphen and colon punctuation only in suggested publish strings.

**PHP:** none until editor maps headings in WP blocks; reorder blocks to match this ladder when adopted.

#### Step B - 2026-05-11 - [https://restwellretreats.co.uk/how-to-read-holiday-cottage-access-statement/](https://restwellretreats.co.uk/how-to-read-holiday-cottage-access-statement/)

**Scope:** `page.php` seeded education guide (`/how-to-read-holiday-cottage-access-statement/`). **Facts:** Seed `meta_title`, `meta_description`, and `focus_keyphrase` in `inc/seo-content-seed.php` (`how-to-read-holiday-cottage-access-statement`) name how to read a holiday cottage access statement, measurements that matter, hoist proof, red-flag phrases, and questions for OTs and families (no wider kit list invented here). **Page goal:** teach how to read listings and PDFs, which measurements to insist on, and how to cross-check wording before booking. **Banned phrase:** not used. **Step A vs brief:** **Primary** stays **holiday cottage access statement** (seed and §2.6 run **2026-05-10**); phrase **accessible holiday cottage hoist and wet room Whitstable Kent** sits in **Secondaries** for the Step B equipment pack (confirm in GSC before swapping Primary). **Hoist wording:** secondaries list `tracking hoist holiday accommodation`; metas use **hoist** without asserting tracking versus ceiling track (Confirm in WP: align with `/accessibility/` access statement).

**Title variants (~59 to 61 characters with trailing brand)**

1. `How to read access statements: Whitstable - Restwell Retreats` (61 characters). **How to read** plus **access statements** load the Step A literacy job early; **Whitstable** carries the disabled-access holiday cottage Whitstable angle before the brand.
2. `Read access statements: hoist, wet room - Restwell Retreats` (59 characters). Surfaces **hoist** and **wet room** in the first segment for equipment-led scans; Whitstable moves to the meta.
3. `Tracking hoist wording: access statements - Restwell Retreats` (61 characters). Targets **tracking hoist holiday accommodation** phrasing without claiming Restwell runs a tracking hoist unless WP confirms (type detail on `/accessibility/`).

**Meta description variants (~153 to 165 characters with trailing brand)**

1. `How to read access statements: hoist and wet room numbers to insist on. Whitstable: hoist, profiling bed, wet room. See accessibility. Restwell Retreats.` (153 characters). **Chosen** meta: measurement CTA, both USPs, single proof path to `/accessibility/`.
2. `Tracking hoist wording in access statements: OT checks. Whitstable self-catering with hoist, profiling bed, wet room. Read accessibility, enquire. Restwell Retreats.` (165 characters). Stronger **tracking hoist** and **OT** signals for commissioner scans; dual CTA.
3. `Cottage access statement tips: hoist proof, wet room lines. Whitstable self-catering: hoist, profiling bed, wet room. See accessibility, enquire. Restwell Retreats.` (164 characters). Checklist tone; **accessible self catering Kent coast** echo is lighter (Kent not in string; optional editor add if Yoast allows).

**Recommended pick:** Title **1** plus Meta **1**. **Rationale:** Title **1** matches navigational how-to intent and keeps Whitstable in the scan line without copying `/accessibility/` or `/the-property/` equipment-first titles. Meta **1** states the measurement job (hoist and wet room numbers to insist on), names hoist, profiling bed, and wet room as the one-place USP (Confirm in WP: matches access statement and on-page list), and uses **See accessibility** as the single CTA so door widths and PDFs stay on `/accessibility/`. **Cannibal:** measured facts and download PDF on `/accessibility/`; adapted bungalow proof on `/the-property/`; this URL owns decode literacy only. **Avoid-ai-writing pass:** short clauses, concrete verbs, no stacked transition fillers, no hollow superlatives.

**Human next:** Paste chosen title and meta into WP Search and Social. **Do not** edit `inc/seo.php` until a human confirms.

#### Step B - 2026-05-11 - [https://restwellretreats.co.uk/fatigue-friendly-whitstable-coastal-day/](https://restwellretreats.co.uk/fatigue-friendly-whitstable-coastal-day/)

**Scope:** `page.php` seeded pacing guide (`/fatigue-friendly-whitstable-coastal-day/`). **Facts:** Seed `meta_title`, `meta_description`, and `focus_keyphrase` in `inc/seo-content-seed.php` (`fatigue-friendly-whitstable-coastal-day`); long-form HTML from `restwell_get_blog_post_fatigue_friendly_coastal_day_html()` in `inc/seo-content-seed-blog-cluster-b.php` (pacing blocks, sensory load, wind, glare, hydration, promenade framing, FAQs). **Page goal:** structure a low-energy Whitstable-area coastal day with sensory load awareness, not duplicate property spec tables. **Banned phrase:** not used. **Step A vs brief:** **Primary** stays **fatigue friendly whitstable coastal day** (seed and §3 P3 row); phrase **accessible holiday cottage hoist and wet room Whitstable Kent** sits in **Secondaries** for the Step B equipment pack (confirm in GSC before promoting that string to Primary). **Hoist wording:** secondaries list `tracking hoist holiday accommodation`; metas use **hoist** without asserting tracking versus ceiling track (Confirm in WP: align with `/accessibility/` access statement).

**Title variants (~58 to 59 characters with trailing brand)**

1. `Accessible Whitstable: hoist, wet room - Restwell Retreats` (58 characters). **Accessible**, **Whitstable**, **hoist**, and **wet room** load in the first segment for the Step B brief before the brand; URL slug and H1 context carry fatigue-friendly coastal day intent.
2. `Fatigue Whitstable day: hoist, wet room - Restwell Retreats` (59 characters). Stronger seed-owner echo **fatigue** plus **Whitstable** plus **day** for navigational scans; still names hoist and wet room.
3. `Low-energy Whitstable: hoist & wet room - Restwell Retreats` (59 characters). Surfaces **low-energy** language from the guide body without the long **fatigue-friendly** compound; **&** saves width versus a comma before **wet room**.

**Meta description variants (~140 to 159 characters)**

1. `Whitstable coast day for fatigue: pacing and sensory load. Quiet self-catering: hoist, profiling bed, wet room. Read accessibility, enquire.` (140 characters). Tight pacing plus sensory mirror of seed opening; both USPs; split CTA.
2. `Low-energy Whitstable Kent coast: pacing, sensory load, wind, glare. Accessible self-catering with hoist, profiling bed, wet room. Read accessibility, enquire.` (159 characters). **Chosen** meta: matches seed description themes (pacing, sensory load, wind, glare), adds **Kent** and **accessible self catering** secondary echo, both USPs, proof deferred to `/accessibility/`.
3. `Pacing a Whitstable-area coast day with sensory load in mind. Accessible self-catering: hoist, profiling bed, wet room. Read accessibility, enquire.` (148 characters). Softer lead for commissioners and carers; same kit bridge and CTA split.

**Recommended pick:** Title **1** plus Meta **2**. **Rationale:** Title **1** keeps the Step B equipment and place words in the first scan line without copying `/the-property/` or `/accessibility/` title shapes, while the slug and on-page H1 stack still answer **fatigue friendly whitstable coastal day** navigational intent. Meta **2** stays close to the verified seed description list (pacing, sensory load, wind, glare), adds **Kent** and **accessible self-catering** for secondary coverage, states hoist, profiling bed, and wet room as the one-place stay bridge only (not a claim about promenade equipment), and uses **Read accessibility** then **enquire** so measurements stay on `/accessibility/`. **Cannibal:** beaches and shore detail on `/accessible-beaches-coastal-walks-kent/`; quieter timing on `/quieter-times-whitstable-low-crowd-access/`; parking on `/accessible-parking-whitstable-tankerton/`. **Avoid-ai-writing pass:** concrete nouns, short clauses, no empty superlatives, no fake urgency.

**Human next:** Paste chosen title and meta into WP Search and Social. **Do not** edit `inc/seo.php` until a human confirms.

#### Step B - 2026-05-11 - [https://restwellretreats.co.uk/accessibility-policy/](https://restwellretreats.co.uk/accessibility-policy/)

**Scope:** `template-accessibility-policy.php` (`/accessibility-policy/`). **Digital versus property:** This URL is the **website** accessibility statement only. Default body in `restwell_get_accessibility_policy_content()` sends door widths, equipment, and room layout to `/accessibility/`. **Banned phrase:** not used. **Facts:** WCAG 2.2 Level AA where reasonably practicable; automated and manual testing; keyboard, zoom, screen readers; third-party embed limits; 48-hour reply aim; EHRC link. **Hoist wording:** secondaries may carry tracking hoist SERP language; property-facing publish strings use **ceiling track hoist** unless WP confirms tracking.

**Title variants (~50 to 60 characters, brand suffix on inner page)**

1. `WCAG website accessibility statement - Restwell Retreats` (56 characters). Primary digital intent in the opening segment: WCAG, website, accessibility.
2. `Website WCAG testing and feedback - Restwell Retreats` (53 characters). Stresses testing plus feedback routes from the template sections.
3. `Web accessibility statement WCAG 2.2 - Restwell Retreats` (56 characters). Shorter **Web** lead for pixel-tight SERPs while keeping WCAG 2.2 visible.

**Meta description variants (~150 to 160 characters)**

1. `WCAG site statement: checks, embed limits, reporting. Hoist, profiling bed, wet room specs on Accessibility only. Email or enquire. Restwell Retreats.` (150 characters).
2. `Accessible Kent self-catering: website policy only. Hoist, profiling bed, wet room on Accessibility. Report web barriers by email or enquiry. Restwell Retreats.` (160 characters).
3. `We test this site for WCAG barriers and embed limits. Cottage hoist and wet room on Accessibility. Request formats or report issues here. Restwell Retreats.` (156 characters).

**Recommended pick:** Title **1** plus Meta **1**. **Rationale:** Title **1** matches Step A owner `restwell website accessibility` and the seed `focus_keyphrase` without reading like the cottage spec page. Meta **1** carries WCAG plus operational promises the theme already states (checks, embed limits, reporting), routes hoist, profiling bed, and wet room to **Accessibility** only, and closes with a clear CTA. **Avoid-ai-writing pass:** plain verbs, no stacked hype, split digital versus bricks-and-mortar in one clear sentence in the meta.

**Human next:** Paste chosen title and meta into WP Search and Social. **Do not** edit `inc/seo.php` until a human confirms.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/accessibility-policy/](https://restwellretreats.co.uk/accessibility-policy/)

**Source:** §13.1 row for this URL; Step A Tier 1 and AEO in `#### Run - 2026-05-10 - template-accessibility-policy.php` (`/accessibility-policy/`) (§2.6, lines ~3972 to ~4023); legal trio depth in `#### Run - 2026-05-10 - Legal policies trio` pillar C (§2.6, website versus property split); `#### Step B - 2026-05-11` same URL. **Repo:** `template-accessibility-policy.php`; `template-parts/legal-policy-layout.php`; `restwell_get_accessibility_policy_content()` in `inc/theme-setup.php`; seed `inc/seo-content-seed.php` (`accessibility-policy`) (Confirm in WP: `legal_body_html` overrides).

**Scope:** Website accessibility statement only (WCAG-oriented testing, feedback, third-party limits). Not the cottage access specification. **Banned phrase:** not used anywhere in publish strings.

**Ordered outline**

1. **H1 (one):** WCAG website accessibility statement (matches Step B chosen title stem and Step A primary family `restwell website accessibility`; Confirm in WP: single H1, theme hero does not add a second H1).
2. **H2:** What this statement covers (answers AEO: What does Restwell's accessibility policy cover?; digital pages and flows, not door widths or equipment lists).
  - **H3:** Where to read cottage access (signpost `/accessibility/` and `/the-property/` for hoist, profiling bed, wet room; ceiling track hoist unless WP confirms tracking; no merged spec tables on this URL).
3. **H2:** WCAG 2.2 commitment and how we test (answers Step A `restwell website accessibility wcag` plus legal trio; automated and manual checks, keyboard, zoom, screen readers where theme body states them; reasonably practicable framing per plan cluster note).
4. **H2:** Third-party content and embed limits (maps legal trio embed limits row; no invented vendor list, Confirm in WP if live embeds changed).
5. **H2:** Accessibility overlays (answers AEO: Does Restwell use accessibility overlays?; one factual paragraph aligned to published approach, no marketing claims).
6. **H2:** Report a barrier or request an alternative format (answers AEO: How do I contact Restwell about accessibility issues?; email or enquiry path; reply aim Confirm in WP if forty-eight hour line still accurate).
7. **H2:** Bookings and cancellations (answers AEO: Where are booking and cancellation rules?; link `/terms-and-conditions/` or FAQ band only, no pasted contract text).
8. **H2:** Cookies and analytics (answers AEO: What cookies does the Restwell site use?; short signpost to `/privacy-policy/` only; list categories only if privacy body already lists them).
9. **H2:** Complaints and EHRC (equality body signpost per theme default; not a second privacy policy).

**Step A echo:** restwell website accessibility, restwell website accessibility wcag, restwell website accessibility overlays (factual block), plus AEO rows in the same run table (lines ~4014 to ~4023).

**Avoid-ai-writing self-check:** Plain verbs, short clauses, concrete nouns (WCAG, EHRC, Terms), no stacked hype, ASCII hyphens and commas only (no Unicode em dash).

**PHP:** none until editor maps H2 bands into WP blocks; fallback order in `restwell_get_accessibility_policy_content()` may differ from this ladder.

#### Step B - 2026-05-11 - [https://restwellretreats.co.uk/changing-places-toilets-kent-coast-days-out/](https://restwellretreats.co.uk/changing-places-toilets-kent-coast-days-out/)

**Scope:** `page.php` seeded guide (`/changing-places-toilets-kent-coast-days-out/`). **Facts:** Seed `meta_title`, `meta_description`, and `focus_keyphrase` in `inc/seo-content-seed.php` (`changing-places-toilets-kent-coast-days-out`) describe Changing Places versus standard accessible toilets, mapping stops, and pairing with beach plans. **Page goal:** differentiate CP from standard loos and map day-out stops without inventing venue scope or hours. **Banned phrase:** not used. **Step A vs brief:** **Primary** stays **changing places toilets kent coast** (seed and §2.6); phrase **accessible holiday cottage hoist and wet room Whitstable Kent** is a **secondary bridge** only (not the SERP owner for this URL). **Hoist wording:** secondaries list `tracking hoist holiday accommodation`; metas use **hoist** without asserting tracking versus ceiling track (Confirm in WP and `/accessibility/`).

**Title variants (~52 to 58 characters with trailing brand)**

1. `Changing Places Kent: day out guide - Restwell Retreats` (55 characters). Puts **Changing Places** and **Kent** in the first segment for Step A `changing places toilets kent coast` intent before the brand.
2. `Accessible Kent coast: CP toilet stops - Restwell Retreats` (58 characters). Weaves **accessible** plus **Kent coast** for secondary **accessible self catering Kent coast** tests while keeping CP in the scan line.
3. `Changing Places Kent coast days out - Restwell Retreats` (55 characters). Echoes slug-as-query **changing places toilets kent coast days out** without stuffing Whitstable into the title.

**Meta description variants (~151 to 157 characters)**

1. `Kent coast days out: CP toilets, mapping tips, beach pair ideas. Quiet Whitstable self-catering: hoist, profiling bed, wet room. Read accessibility, enquire.` (157 characters).
2. `CP versus standard loos on Kent trips: map stops carefully. Whitstable-area self-catering: hoist, profiling bed, wet room. Read accessibility, enquire.` (151 characters).
3. `Changing Places Kent coast: CP versus standard loos, map stops before travel. Whitstable stay: hoist, profiling bed, wet room. See accessibility, enquire.` (154 characters).

**Recommended pick:** Title **1** plus Meta **1**. **Rationale:** Title **1** keeps the educational owner (Changing Places, Kent, day out) in the first thirty characters and avoids reading like `/the-property/` or `/accessibility/`. Meta **1** mirrors the seed job (CP toilets, mapping, beach pairing), states cautious mapping in plain words, carries both USPs (quiet Whitstable self-catering plus hoist, profiling bed, wet room in one place), and splits the CTA to **Read accessibility** then **enquire** so spec depth stays on `/accessibility/`. **Avoid-ai-writing pass:** concrete nouns, short clauses, no stacked hype, no fake urgency.

**Human next:** Paste chosen title and meta into WP Search and Social. **Do not** edit `inc/seo.php` until a human confirms.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/changing-places-toilets-kent-coast-days-out/](https://restwellretreats.co.uk/changing-places-toilets-kent-coast-days-out/)

**Source:** §13.1 row for this URL; Step A and AEO in `#### Run - 2026-05-10 - https://restwellretreats.co.uk/changing-places-toilets-kent-coast-days-out/` (Tier 1 to 2 keywords, ~3451; AEO five questions, ~3478); `#### Step B - 2026-05-11` same URL; seed `title`, `meta_description`, and body `restwell_get_blog_post_changing_places_kent_coast_html()` in `inc/seo-content-seed-blog-cluster-b.php` (Confirm in WP: live blocks override seed).

**Scope:** `page.php` seeded guide. **Facts:** Seed HTML opens with TL;DR then `h2` **What is a Changing Places toilet?**; body states CP includes ceiling hoist, adult changing bench, centrally placed toilet, space for two carers; contrasts standard accessible WC in a table; sections on coastal gaps, planning with three `h3`, practical steps, mistakes, FAQs, closing links to blog, beaches, dining, enquire. **Banned phrase:** not used. **Venue scope:** no invented venue list or hours; maps and phone checks per seed.

**Ordered outline**

1. **H1 (one):** Changing Places and accessible toilets for Kent coast days out (matches seed `title` in `inc/seo-content-seed.php`; Confirm in WP: single visible H1; seed currently starts with blockquote then first `h2`, add or promote title so only one H1 renders).
2. **H2:** What Changing Places means on the Kent coast (AEO: what is changing places toilets kent coast; merges seed **What is a Changing Places toilet?**; definition: ceiling hoist, adult changing bench, centrally placed toilet, two carers).
3. **H2:** How to plan a day out around toilet stops (AEO: how do I plan changing places toilets kent coast; merges **Planning a day out** and **Practical steps**; **H3** Morning anchor; **H3** Emergency backup; **H3** Beach legs with link to `/accessible-beaches-coastal-walks-kent/`).
4. **H2:** Who needs Changing Places versus standard accessible toilets (AEO: who is changing places toilets kent coast for).
5. **H2:** What to carry or confirm before you travel (AEO: what documents do I need; kit and checks: offline national CP map, sling clips, radar key, phone attractions for closures, cleaning gaps; add formal paperwork only if editor extends for commissioners).
6. **H2:** Where DP or CHC planning meets toilet planning (AEO: overlap with direct payments or CHC; short signpost to `/resources/`, `/direct-payment-holiday-accommodation/`, `/chc-respite-holiday-accommodation-uk/`; not tailored advice).
7. **H2:** Why coastal miles expose gaps (seed heading).
8. **H2:** How standard accessible loos differ (seed heading and comparison table).
9. **H2:** Common mistakes (seed list).
10. **H2:** Frequently asked questions (seed **H3** Are Changing Places free; Can families without disabilities use CP rooms; Do all Kent beaches have loos; What if hoist weight limit is low; Who updates maps).
11. **H2:** After you map the coast (seed **Closing**; links `/blog/`, `/enquire/`, plus on-property wet-room detail on `/accessibility/` per seed).

**Avoid-ai-writing pass:** concrete nouns, short clauses, no stacked hype, ASCII punctuation only.

**Human next:** Align WP block headings with this ladder; keep venue facts sourced to official CP data and operator confirmations.

#### Step B - 2026-05-11 - [https://restwellretreats.co.uk/quieter-times-whitstable-low-crowd-access/](https://restwellretreats.co.uk/quieter-times-whitstable-low-crowd-access/)

**Scope:** `page.php` seeded timing or sensory guide (`/quieter-times-whitstable-low-crowd-access/`). **Facts:** Seed `meta_title`, `meta_description`, and `focus_keyphrase` `quieter times whitstable visit` in `inc/seo-content-seed.php` (`quieter-times-whitstable-low-crowd-access`); long-form body in `restwell_get_blog_post_quieter_whitstable_visit_html()` (`inc/seo-content-seed-blog-cluster-b.php`) covers midweek versus weekend patterns, oyster festival and regatta caveats, parking turnover (links to `/accessible-parking-whitstable-tankerton/`), pavement and kerb realism, sensory load (noise versus hearing-loop usefulness), noon restaurant booking (links to `/accessible-eating-out-whitstable-kent/`), Tankerton slope mitigation, fatigue pairing (links to `/fatigue-friendly-whitstable-coastal-day/`), and a seasonal table captioned **Rough guide only - verify event calendars yearly**. **Page goal:** give low-crowd and fatigue-friendly visit timing without guaranteeing quiet. **Banned phrase:** not used. **Step A vs brief:** **Primary** stays **quieter times whitstable visit** (seed `focus_keyphrase`, §2.6 run **2026-05-10**); pasted Step B foundation phrase **accessible holiday cottage hoist and wet room Whitstable Kent** is **not** the SERP owner for this timing or sensory URL and sits in **Secondaries** only (same pattern as `/accessible-eating-out-whitstable-kent/`, `/accessible-parking-whitstable-tankerton/`, `/changing-places-toilets-kent-coast-days-out/`, `/accessible-train-travel-whitstable-kent/`). **Hoist wording:** secondaries list `tracking hoist holiday accommodation`; metas use **hoist** without asserting tracking versus ceiling track (type detail stays on `/accessibility/` and `/the-property/`).

**Title variants (~52 to 58 characters with trailing brand)**

1. `Quieter times Whitstable visit: Kent - Restwell Retreats` (56 characters). Lands the seed `focus_keyphrase` **quieter times whitstable visit** in the first thirty-one characters, then **Kent** for geo before the brand.
2. `Quieter Whitstable access timing - Restwell Retreats` (52 characters). Leads on **Quieter** plus **Whitstable** plus **access timing** for the timing or sensory angle without the verbatim seed phrase; weaker on **visit** as a SERP word.
3. `Low-crowd Whitstable: accessible visit - Restwell Retreats` (58 characters). Echoes slug-as-query secondary **quieter times whitstable low crowd access** and pairs **accessible** with **visit**; loses the seed phrase **quieter times** as an exact match.

**Meta description variants (~155 to 159 characters)**

1. `Quieter times to visit Whitstable, Kent: weekday windows, festival caveats. Quiet self-catering: hoist, profiling bed, wet room. See accessibility, enquire.` (156 characters).
2. `Whitstable visit timing for low crowds: midweek slots, festival pitfalls, parking turnover. Quiet Kent self-catering: hoist, wet room, profiling bed. Enquire.` (159 characters).
3. `Plan a quieter Whitstable visit: weekdays, festival caveats, pavement realism. Accessible self-catering Kent: hoist, wet room. Read accessibility, enquire.` (155 characters).

**Recommended pick:** Title **1** plus Meta **1**. **Rationale:** Title **1** keeps the Step A seed `focus_keyphrase` **quieter times whitstable visit** intact and inside the first thirty-one characters without mirroring a property hub or comparator shape; **Kent** gives the geo signal SERP scanners look for. Meta **1** opens with the same seed phrase as a definition cue, names two honest body themes (weekday windows, festival caveats) so the snippet does not over-promise quiet (the body TL;DR explicitly says quiet midweek rules vanish on oyster festival or regatta weekends), then carries both USPs in one breath (quiet Whitstable-area self-catering plus hoist, profiling bed, wet room together) and splits the CTA to **See accessibility** before **enquire**, keeping kit measurements on `/accessibility/` per §2.6 ownership. **Cannibal:** town hub on `/whitstable-area-guide/`; parking and Tankerton kerb mechanics on `/accessible-parking-whitstable-tankerton/`; beach surfaces on `/accessible-beaches-coastal-walks-kent/`; dining route notes on `/accessible-eating-out-whitstable-kent/`; fatigue pacing on `/fatigue-friendly-whitstable-coastal-day/`; kit measurements on `/accessibility/` and `/the-property/`. **Avoid-ai-writing pass:** short clauses, concrete nouns, no stacked hype, no fake urgency, no banned phrase, ASCII hyphens only.

**Human next:** Paste chosen title and meta into WP Search and Social. **Do not** edit `inc/seo.php` until a human confirms.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/quieter-times-whitstable-low-crowd-access/](https://restwellretreats.co.uk/quieter-times-whitstable-low-crowd-access/)

**Source:** §13.1 row for this URL; Step A Tier 1 keywords in `#### Run - 2026-05-10 - https://restwellretreats.co.uk/quieter-times-whitstable-low-crowd-access/` (§2.6, ~~3541: seed **quieter times whitstable visit**, **quieter times whitstable visit kent**, slug query **quieter times whitstable low crowd access**, weekday patterns, festival pitfalls, parking turnover, tide times versus crowd times); second AEO block same URL (~~4869: weekday patterns, festival pitfalls, parking turnover, low sensory morning, tide versus crowd); AEO questions ~3556-3564 (definition, plan, who, documents, DP or CHC overlap) plus ~4869-4877 (quietest timing, festivals, parking turnover, Tankerton versus harbour, neurodivergent morning itinerary). **Repo:** `page.php`; `restwell_get_blog_post_quieter_whitstable_visit_html()` in `inc/seo-content-seed-blog-cluster-b.php` (Confirm in WP: live blocks override seed).

**Scope:** Timing and sensory planning for Whitstable-area visits. **Facts:** Body themes from seed (midweek versus weekend, oyster festival and regatta caveats, parking turnover, pavement and kerb realism, sensory load, noon booking, Tankerton slopes, fatigue pairing, seasonal table **Rough guide only - verify event calendars yearly**). **Page goal:** low-crowd and fatigue-friendly timing without guaranteeing quiet. **Banned phrase:** not used. **Cannibal:** parking bay mechanics on `/accessible-parking-whitstable-tankerton/`; hour-by-hour pacing on `/fatigue-friendly-whitstable-coastal-day/`; town hub on `/whitstable-area-guide/`; kit proof on `/accessibility/` and `/the-property/`.

**Ordered outline**

1. **H1 (one):** Quieter times to visit Whitstable, Kent: when crowds often ease (echoes Step A **quieter times whitstable visit** plus Kent; honest framing, not a silence guarantee; Confirm in WP: single visible H1).
2. **H2:** What "quieter times" means here (answers AEO ~3560: What is quieter times whitstable visit?; short definition, limits of prediction).
3. **H2:** How to plan around crowd peaks (answers AEO ~3561: How do I plan quieter times whitstable visit?; **H3** weekday versus weekend and school breaks; **H3** seasonal table with Confirm in WP event dates yearly).
4. **H2:** When Whitstable is usually calmer if you avoid crowds (answers AEO ~4873; wheelchair crowd-aversion angle; tie **weekday patterns whitstable low crowd** Step A).
5. **H2:** Festivals and regatta weekends that spike crowds (answers AEO ~4874; oyster festival caveats per seed; Confirm in WP: official calendars before naming dates).
6. **H2:** Parking turnover and low-energy arrivals (answers AEO ~4875; Step A **parking turnover low energy travellers whitstable**; link `/accessible-parking-whitstable-tankerton/` for bay detail).
7. **H2:** Tankerton versus Whitstable harbour on busy days (answers AEO ~4876; geography split, slopes per seed).
8. **H2:** Low-crowd mornings, tides, and sensory load (answers AEO ~4877; **tide times versus crowd times whitstable** Step A; hearing loop versus noise realism per seed; link `/fatigue-friendly-whitstable-coastal-day/` for hour pacing depth).
9. **H2:** Who this guide helps (answers AEO ~3562: Who is quieter times whitstable visit for?; carers, families, commissioners, funding-aware bookers; light tone).
10. **H2:** Documents and funding overlap on the same trip (answers AEO ~3563-3564; checklist light unless editor extends; signpost `/resources/`, `/direct-payment-holiday-accommodation/`, `/chc-respite-holiday-accommodation-uk/` without owning those primaries).
11. **H2:** Practical next reads (link `/whitstable-area-guide/`, `/accessible-eating-out-whitstable-kent/`, `/accessible-train-travel-whitstable-kent/`, `/accessible-beaches-coastal-walks-kent/` when relevant).
12. **H2:** Whitstable-area stay after you set timings (soft bridge: hoist, profiling bed, wet room; `/accessibility/`, `/the-property/`, `/enquire/`; **ceiling track hoist** wording unless WP confirms tracking).
13. **H2:** Related guides (cluster close).

**Step A echo:** quieter times whitstable visit, quieter times whitstable visit kent, quieter times whitstable low crowd access, weekday patterns whitstable low crowd, festival pitfalls whitstable access, parking turnover low energy travellers whitstable, tide times versus crowd times whitstable, low sensory morning whitstable harbour (hypothesis row).

**Avoid-ai-writing self-check:** Plain section jobs, no hollow intensifiers, no fake urgency, ASCII hyphens and commas only (no Unicode em dash).

**PHP:** none until editor maps H2 bands into WP blocks; seed HTML order may differ from this ladder.

#### Step B - 2026-05-11 - [https://restwellretreats.co.uk/privacy-policy/](https://restwellretreats.co.uk/privacy-policy/)

**Scope:** `template-privacy-policy.php` (loads `template-parts/legal-policy-layout.php`; body fallback `restwell_get_privacy_policy_content()` in `inc/theme-setup.php`). **Page goal:** factual privacy disclosures only (no marketing tone). **Facts (repo):** accessible holiday accommodation in Whitstable, Kent; data controller named; enquiry form collects name, email, phone, optional care or accessibility text; legitimate interests and contract bases; no sale of personal data; share with Continuity of Care Services when care is agreed; essential cookies plus GA4 where consented, cookie controls on first visit; enquiry and booking records kept up to three years; UK GDPR rights and ICO link; contact by public enquiry email. **Banned phrase:** not used. **Step A vs brief:** **Primary** stays **restwell privacy** (`inc/seo-content-seed.php` `focus_keyphrase`); phrase **accessible holiday cottage hoist and wet room Whitstable Kent** sits in **Secondaries** as a cluster bridge only (this URL does not own equipment primaries). **Hoist wording:** secondaries list `tracking hoist holiday accommodation`; titles and metas avoid asserting tracking versus ceiling track (Confirm in WP and `/accessibility/`).

**Title variants (~58 to 62 characters with trailing brand)**

1. `Accessible cottage Whitstable: privacy - Restwell Retreats` (58 characters). Puts **accessible**, **cottage**, and **Whitstable** in the first segment for the Step B brief scan line, then **privacy** so the result reads as a policy page.
2. `Hoist, wet room Whitstable: privacy data - Restwell Retreats` (60 characters). Weaves **hoist** and **wet room** with **Whitstable** for secondary tests while keeping **privacy data** as the page job.
3. `Kent self-catering privacy: GA4, retention - Restwell Retreats` (62 characters). Leads on **Kent self-catering** and **privacy** for GDPR-style informational scans, names **GA4** and **retention** as on-page topics.

**Meta description variants (~154 to 158 characters)**

1. `Privacy for Whitstable stays: enquiry data, optional care share if agreed, GA4 controls, three-year retention, UK GDPR and ICO. Email us. Restwell Retreats.` (156 characters).
2. `Accessible self-catering Kent privacy: enquiry data, GA4 consent, three-year retention, UK GDPR, ICO. Disabled-access Whitstable stays. Restwell Retreats.` (154 characters).
3. `Disabled-access Whitstable privacy: enquiry and booking data, GA4 cookies, three-year retention, UK GDPR rights. See Accessibility for kit. Restwell Retreats.` (158 characters).

**Recommended pick:** Title **1** plus Meta **1**. **Rationale:** Title **1** matches the legal page type while opening with accessible Whitstable cottage wording from the Step B pack without duplicating `/the-property/` or `/accessibility/` PDP titles. Meta **1** mirrors the theme fallback sections (enquiry data, optional Continuity of Care share when agreed, GA4 controls, three-year retention, UK GDPR, ICO, email) and avoids selling the stay; it does not imply the privacy page lists hoist specifications (those stay on `/accessibility/`). **Avoid-ai-writing pass:** plain legal nouns, short clauses, no stacked superlatives, no fake urgency.

**Human next:** Paste chosen title and meta into WP Search and Social. **Do not** edit `inc/seo.php` until a human confirms.

#### Step B - 2026-05-11 - [https://restwellretreats.co.uk/terms-and-conditions/](https://restwellretreats.co.uk/terms-and-conditions/)

**Scope:** `template-terms-and-conditions.php` (loads `template-parts/legal-policy-layout.php`; body fallback `restwell_get_terms_conditions_content()` in `inc/theme-setup.php`). **Page goal:** authoritative booking, deposit, balance, cancellation, guest duties, and equipment use text that editors maintain in WordPress, aligned with live legal copy (not marketing). **Facts (repo, cluster 2026-05-10):** themes defaults cover booking confirmation, payments including deposit and balance six weeks before arrival, BACS and card, cancellation tiers, accessibility reliance at booking, exceptional circumstances, optional care introduction, equipment use and hoist, dogs with notice and risk assessment. **Banned phrase:** not used. **Step A vs brief:** **Primary** stays **restwell terms** (`inc/seo-content-seed.php` navigational owner); phrase **accessible holiday cottage hoist and wet room Whitstable Kent** sits in **Secondaries** for the Step B SERP pack (confirm in GSC before promoting that string to Primary). **Hoist wording:** secondaries list **tracking hoist holiday accommodation**; title and meta use **hoist** without asserting tracking versus ceiling track (Confirm in WP and `/accessibility/`).

**Title variants (~56 to 62 characters with trailing brand)**

1. `Terms: accessible cottage Whitstable - Restwell Retreats` (56 characters). Opens with **Terms** for navigational plus legal scans, then **accessible cottage Whitstable** for the Step B place pack before the brand.
2. `Deposits, cancellations: Whitstable terms - Restwell Retreats` (58 characters). Leads on **deposits** and **cancellations** for money-first contract intent, keeps **Whitstable** and **terms** in the scan line.
3. `Accessible hoist cottage Whitstable: terms - Restwell Retreats` (62 characters). Loads **Accessible**, **hoist**, **cottage**, and **Whitstable** in the first segment for the Step B equipment phrase, then **terms** as the page type.

**Meta description variants (~157 to 159 characters)**

1. `Deposits, cancellations, balance: Whitstable-area booking terms. Hoist, profiling bed, wet room (see accessibility). Read before you book. Restwell Retreats.` (157 characters).
2. `Kent self-catering Whitstable: deposits, cancellations, balance terms. Hoist, profiling bed, wet room on accessibility. Read before booking. Restwell Retreats.` (159 characters).
3. `Tracking hoist holidays: Restwell terms, deposits, cancellations Whitstable. Accessible Kent self-catering. Hoist type: see accessibility. Restwell Retreats.` (157 characters).

**Recommended pick:** Title variant **3** plus Meta **1**. **Rationale:** Variant **3** keeps **Accessible**, **hoist**, **Whitstable**, and **terms** in one opening line so the Step B pack reads before the legal label, without copying `/accessibility/` hub titles. Meta **1** opens on **deposits**, **cancellations**, and **balance** so the snippet matches this URL is contract job, states **Whitstable-area booking terms**, carries hoist, profiling bed, and wet room as the one-place USP with proof deferred to **see accessibility**, and uses **Read before you book** as the CTA. **Cannibal:** tier numbers and balance timing stay authoritative here; FAQ answers link back for detail; kit measurements on `/accessibility/` and `/the-property/`. **Avoid-ai-writing pass:** concrete nouns, short clauses, no stacked hype, no banned phrase, ASCII hyphens only.

**Human next:** Paste chosen title and meta into WP Search and Social. **Do not** edit `inc/seo.php` until a human confirms.

#### Step C - 2026-05-10 - [https://restwellretreats.co.uk/](https://restwellretreats.co.uk/)

- **H1 (exactly one):** Accessible Holidays in Whitstable, Kent (`inc/theme-setup.php` `hero_heading` default; Confirm in WP second line or spacing only).
- **H2 and H3 order** (matches `front-page.php` band order; labels from theme defaults unless WP overrides; maps §2.6 homepage AEO rows):
  1. **Area and funding** (Home teaser, sr-only section label): **H3** Whitstable and the Kent coast (coast, routes, realistic access notes); **H3** Funding your stay (DP, CHC, LA signpost, depth on `/resources/`).
  2. **Two people. One break.** (`who_heading`): **H3** For the guest; **H3** For the carer (whole-property, optional CCS or own carer).
  3. **Our Whitstable home** (`property_heading`): summary-level Whitstable self-catering story; equipment stays teaser-only (verified highlights, `/the-property/`, `/accessibility/`).
  4. **What guests say** (conditional when testimonial quotes exist).
  5. **Why choose Restwell for your accessible break?** (`why_heading`): **H3** Private and personal; **H3** Professional support on your terms; **H3** Local knowledge; **H3** Honest and open.
  6. **Specialist Partners**
  7. **Restwell vs. a typical hotel stay** (comparison band: whole property, equipment summary, care, kitchen).
  8. **Need exact access details first?** (bottom CTA: enquiry plus property links).
  9. **Common questions** (`home_faq_heading` default): first seven FAQ items from the FAQ page via `restwell_get_faq_items` homepage scope (`inc/faq.php`); default seed order in `restwell_get_faq_page_default_pairs()` covers care home versus holiday let, accessibility overview, booking, advance booking, carer or PA, care scope, beach access; hoist plus profiling bed FAQ defaults at position ten, so it is outside the homepage slice unless WP reorders (Confirm in WP).
  10. **Care on your terms** (trust strip when shown; default `trust_heading`).
- **Optional hero band:** Confirm in WP: non-empty `hero_spec_heading` exposes an sr-only **H2** for the equipment strip; keep claims to that field and verified hero copy only (bedroom-scoped hoist in highlights, not whole-property hoist claims).
- **AEO alignment (§2.6 table):** definition or what-is Restwell (FAQ plus property band); wheelchair self-catering plus hoist (highlights, comparison row, FAQ slice, link to `/accessibility/`); DP or CHC (funding H3 plus FAQ); book whole property for guest and carer (who band plus booking FAQ); equipment checklist tone (highlights plus FAQ answers, PDF or measurements on hub URLs).
- **Banned phrase:** never use `fully accessible` in headings or body.

#### URL [https://restwellretreats.co.uk/the-property/](https://restwellretreats.co.uk/the-property/) (`template-property.php`) - 2026-05-10

- **P4 Step A:** Primary `adapted bungalow whitstable` (`inc/seo-content-seed.php` focus_keyphrase; meta title or description; aligns with `prop_hero_subtitle` adapted home plus hoist or bed or wet room wording in `restwell_get_property_page_defaults()`). Secondaries: `ceiling track hoist accessible bedroom`, `roll-in wet room grab rails`, `adjustable profiling bed`, `private self-catering whitstable`, `step-free parking to all rooms`. LSI or entities: Whitstable Kent coast, Tankerton Slopes promenade, wheelchair users, carers, transfer space, pressure-relieving mattress, adjustable washbasin, door clear widths 926 mm and 965 mm, driveway parking, optional CQC-regulated care on site (comparison list only). Intent: commercial transactional, verify specs before deposit (property PDP-style, not county guide). Cannibal: `/accessibility/` owns `**wheelchair accessible holiday cottages in Kent`** (default intro phrase) plus PDF or measurement-led spec narrative; `/` owns `accessible holidays whitstable`; `/whitstable-area-guide/` owns local transport and days out; `/how-to-choose-accessible-self-catering-holiday/` owns vetting checklist angle. **Do not also target** `wheelchair accessible holiday cottages in Kent` or singular cottage spec-hub primaries on URL `/the-property/` (owner `/accessibility/`). **Do not also target** `accessible holidays whitstable` as this page primary (owner `/`). **Confirm in WP:** hero or meta overrides versus theme defaults; publish hoist weight limit only when confirmed (listed TBC in `prop_acc_tbc` defaults).
- **P4 Step B (2026-05-11):** Chosen title and meta logged in **§13.1**; full T1 to T3 and M1 to M3 text plus rationale in **§4.1** `#### Step B - 2026-05-11 - https://restwellretreats.co.uk/the-property/`. §13.1 **Primary** now follows this Step B brief phrase; Step A commercial anchor `adapted bungalow whitstable` is retained in **Secondaries** for GSC alignment.
- **P4 Step C (2026-05-11):** One H1 plus ordered H2/H3 in §13.1 **H1 / H2 summary**; full ladder in §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/the-property/` (maps §2.6 property AEO rows to `template-property.php` section order).

#### URL [https://restwellretreats.co.uk/accessibility/](https://restwellretreats.co.uk/accessibility/) (`template-accessibility.php`) - 2026-05-10

- **P4 Step A (template-grounded):** Primary `**wheelchair accessible holiday cottages in Kent`** (verbatim default `acc_intro` lede in `template-accessibility.php`). Secondaries: `wheelchair accessible holiday cottage`, `holiday cottage access statement PDF`, `door widths wheelchair accessible holiday let`, `Whitstable wheelchair seafront access`, `level access ground floor cottage`. LSI or entities (defaults in template only): comparing cottages, equipment dimensions verified honestly, level threshold wide front door, standard and power wheelchairs, OTs commissioners planning PDF, Tankerton promenade surfaced path Kent coast, Marine Parade parking accessible toilets harbour, shingle beach limits promenade alternative, dropped kerbs residential street, measurements on request. Intent: **informational plus commercial investigation** (access hub, trust, PDF download, enquiry CTAs), not a county guide. Cannibal: keep **adapted bungalow Whitstable** booking story on `/the-property/`; keep **accessible holidays Whitstable** headline cluster on `/`; route long days-out depth to `/whitstable-area-guide/`; comparator checklist angle stays `/how-to-choose-accessible-self-catering-holiday/`. **Editor:** default empty ACF bodies hide bedroom, bathroom, kitchen, outdoor cards until WP adds verified lines (do not imply hoist, wet room, or hob here from PHP defaults alone). **Confirm in WP:** align any equipment list with `/the-property/` and PDF facts only. **Do not also target** `adapted bungalow whitstable` on URL `/accessibility/` (`/the-property/`). **Do not also target** `accessible holidays whitstable` as this URL primary (`/`).

#### Step B - [https://restwellretreats.co.uk/accessibility/](https://restwellretreats.co.uk/accessibility/) - 2026-05-10

- **Title T1 (60c):** Accessible cottage hoist & wet room Kent | Restwell Retreats
- **Title T2 (55c):** Whitstable hoist & wet room cottage | Restwell Retreats
- **Title T3 (58c):** Tracking hoist cottage Whitstable Kent | Restwell Retreats
- **Meta M1 (157c, chosen):** Accessible self-catering near Whitstable: hoist, profiling bed, roll-in shower. Download our access statement PDF or request measurements. Restwell Retreats.
- **Meta M2 (148c):** Disabled access cottage Whitstable: tracking hoist and wet room. Quiet Kent coast self-catering. PDF access statement for OTs. Request measurements.
- **Meta M3 (147c):** Accessible holiday cottage Whitstable Kent: hoist, profiling bed, wet room. Download the PDF access statement. Quiet self-catering for family rest.
- **Chosen:** T1 + M1. **Rationale:** T1 puts accessible plus hoist or wet room plus Kent inside the first segment before the brand; M1 matches equipment wording in `inc/seo-content-seed.php` accessibility seed (hoist, profiling bed, roll-in shower), adds self-catering Whitstable and the PDF or measurements CTAs the template promotes. **Facts:** kit claims trace to seed and property narrative, not empty `template-accessibility.php` room defaults (Confirm in WP: PDF and on-page lists stay aligned). **Note:** Step A on-page intro phrase `wheelchair accessible holiday cottages in Kent` remains in body; Step B pack targets SERP phrasing for hoist or wet room Whitstable Kent. **Publish:** WP title can use `|` before the site name to match theme seed style; the §13.1 table uses `-` only so the markdown row does not break.
- **P4 Step C (2026-05-11):** H1 and H2 ladder aligned to §13.1 primary plus §2.6 run AEO questions (door widths, roll-in wet room, hoist room scope, induction hob, Whitstable friction, measurements before booking). Compact outline lives in §13.1 **H1 / H2 summary**; full ordered list in `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/accessibility/` below. **Worksheet note:** §13.1 **Primary** cell follows Step B hoist pack; Step A intro phrase above stays valid in body when WP keeps that lede.

#### Step C - 2026-05-11 - [https://restwellretreats.co.uk/accessibility/](https://restwellretreats.co.uk/accessibility/)

**Scope:** `template-accessibility.php`, URL `/accessibility/`. **Facts:** Only publish lines that WP or defaults already verify; PHP skips empty room cards. Prefer **ceiling track hoist** wording on publish unless WP confirms supplier **tracking** wording. **Banned phrase:** not used.

**Ordered outline (H1, then H2, then H3):**

1. **H1:** Wheelchair accessible holiday cottage near Whitstable: hoist, wet room, and measurements we publish (Confirm in WP: `acc_heading` matches this line so the hero carries the single H1).
2. **H2:** Published door widths and level access (answers §2.6 AEO: what door widths does Restwell publish; use 926 mm internal and 965 mm front door only when those lines exist in WP or theme defaults).
3. **H2:** Roll-in wet room and bathroom kit (answers AEO: is the wet room roll-in; keep to verified wet-room lines, no new kit).
4. **H2:** Ceiling track hoist in the accessible bedroom (answers AEO: where the hoist runs; full-room track there; Confirm in WP: sling compatibility or weight limit if you publish them).
5. **H2:** Kitchen: gas hob, not induction (answers AEO: does Restwell use induction hobs; hide subsection if the kitchen card has no verified lines).
6. **H2:** Room-by-room verified detail (**H3** Arrival and entrance, **H3** Inside the property, **H3** Bedrooms and sleeping, **H3** Bathroom, **H3** Kitchen, **H3** Outdoor spaces; same order as template cards).
7. **H2:** Whitstable: what works on wheels, what gets awkward, beach reality (**H3** The good, **H3** The challenge, **H3** The reality).
8. **H2:** Access statement PDF and measurement requests (answers commissioner or OT download path; link out to how-to-read guide when relevant).
9. **H2:** Ask us before you book (**H3** Have a specific requirement, **H3** Need precise measurements; both CTAs to `/enquire/` per template).

**Step A alignment:** Hoist, wet room, door widths, Whitstable, PDF, and wheelchair cottage language mirror §13.1 primary and secondaries plus Tier 1 rows in `#### Run - 2026-05-10 - template-accessibility.php`.

**Human next:** Map headings to ACF keys (`acc_heading`, room bodies, destination blocks); keep one H1; align PDF helper output with visible lists.

---

## 5. Voice & editorial rhythm (`/content-creator`)

- **Outline before draft** (template sections from skill frameworks - adapted to Restwell, no external scripts required).
- **Consistency:** calm, precise, non-alarmist health/funding language; avoid unverifiable claims.
- **Repurpose:** one pillar → shorter FAQ fragments → internal link targets for cluster posts.
- **Quality bar:** value-first; if `/content-creator` conflicts with medical/legal caution, **caution wins**.

---

## 6. AI search & extractability (`/ai-seo`)

Apply **after** core on-page work on priority URLs.

### 6.1 Extractability checklist


| Check            | Pass criteria                                                                                                |
| ---------------- | ------------------------------------------------------------------------------------------------------------ |
| Definition       | “X is …” or plain definition in **first ~60 words** of key sections                                          |
| Answer blocks    | Self-contained; **40–60 words** for snippet-style; **134–167 words** for longer GEO passages where justified |
| Questions        | H2/H3 phrased as user questions where natural                                                                |
| Tables           | Comparisons as real `<table>` or structured lists                                                            |
| Stats            | Numbers + sources (NHS/dates); dated                                                                         |
| Freshness        | Visible **updated** signals where content changed materially                                                 |
| Keyword stuffing | **Avoid** - hurts AI visibility (~negative signal in GEO research)                                           |

| Image alt text | Descriptive alt on property photos; `alt=""` only for decorative; see [MEDIA-SEO-DETAILS.md](MEDIA-SEO-DETAILS.md) |
| Link text | No "click here" / "read more"; use descriptive anchors (benefits SEO + screen readers) |
| Skip link | Present in theme header; verify after layout changes |
| Colour contrast | Deep teal on white passes WCAG AA; verify gold text token on live CSS |


### 6.2 Manual AI visibility (no tools)

Monthly: run **10–20 priority queries** through Google AI Overview / Perplexity / ChatGPT (browse) - log if Restwell cited and which competitor pages appear.

### 6.3 Agent extractability audit log (Cursor)

*Append `#### Extractability - YYYY-MM-DD - <URL>` with a table: §6.1 row name  Pass/Fail  Fix (one concrete sentence)  Owner. Add two **AI Overview test queries** as bullets.*

---

## 7. GEO & technical AI surfaces (`/seo-geo`)

- **Crawlers:** Ensure important AI/search user-agents are not accidentally blocked for **public** marketing URLs (policy decision - align with site owner). Guest/noindex URLs stay noindex.
- `**llms.txt`:** Theme already supports discoverability - keep **accurate** page descriptions if you maintain it.
- **SSR:** Critical SEO content should not depend on client-only JS for core text (WordPress PHP templates OK).
- **Schema:** Use theme’s existing JSON-LD; extend via `/schema-markup` skill when adding FAQ/Article blocks - avoid duplicate conflicting types on same page.

### 7.1 Agent GEO / AI-crawler run log (Cursor)

*Append `#### GEO run - YYYY-MM-DD` with bullets: `severity (H/M/L)` - finding - file path. If read-only, label “Recommended fix (not applied)”.*

---

## 8. Comparison & alternatives (`/seo-competitor-pages`)

Applies to pages like `**/revitalise-alternatives-accessible-holidays/`** and any future “vs” URLs.

- **Balanced** claims; **verifiable** competitor facts; **last updated** date.
- **Comparison tables** with criteria relevant to disabled travellers (access, not just price).
- **Internal links** to `/the-property/`, `/accessibility/`, `/enquire/`.
- **Title formulas:** e.g. `[Topic]: alternatives compared ([Year])` - within meta limits (§4 Step B).

### 8.1 Agent comparison / alternatives run log (Cursor)


#### Competitor landscape (merged from legacy section 8 — 2026-07-05)

**Differentiation one-liner:** The only purpose-adapted holiday bungalow on the Kent coast that speaks to families and to professionals making placements (OTs, case managers, commissioners).

| Competitor | Threat | Notes |
|------------|--------|-------|
| Hawthorn Farm Cottages | Moderate | Closest like-for-like Kent adapted cottage; inland not coastal |
| Bramley & Teal | Low–moderate | Aggregator; aim to be listed as well as competing |
| DisabledHolidays.com | High national / low local | Listing + backlink opportunity, not SERP competitor for Whitstable |
| Revitalise (closed centres) | Content opportunity | Target "Revitalise alternatives" — see `/revitalise-alternatives-accessible-holidays/` |
| National Trust / generic aggregators | High generic terms | Do not compete on unmodified "Whitstable holiday cottage" |

**SERP gaps (6–12 months):** Whitstable-specific accessible terms; equipment long-tail (hoist, profiling bed); commissioner/professional terms; Revitalise alternatives; accessible Kent coast with coastal positioning.


*Append `#### Comparison run - YYYY-MM-DD - <URL>` with H1 angle, H2 list, table column plan, FAQ questions (AEO), and risk notes.*

---

## 9. Live data (optional) (`/seo-dataforseo`)

**Only if** DataForSEO MCP/extension is installed and budget approved.


| Use                  | Tool pattern                                                 |
| -------------------- | ------------------------------------------------------------ |
| SERP reality check   | Organic SERP for Tier 1 keywords (**UK** location/language). |
| Volumes / difficulty | Bulk keyword metrics before committing calendar              |
| Competitor overlap   | Domain intersection vs 2–3 competitor domains                |
| GEO                  | ChatGPT scraper / LLM mentions for brand + category queries  |


If unavailable: use **manual SERP checks** + GSC **Pages** only.

### 9.1 Agent keyword metrics log (Cursor)

*Append `#### Metrics - YYYY-MM-DD` with table: `Keyword`  `Volume est`  `Difficulty est`  `Intent`  `Tier`  `Note` - or paste **manual SERP check steps** if no API.*

---

## 10. Growth metrics (`/growth-engine`)

Focus on **metrics that matter** for Restwell (not generic SaaS viral loops):


| Funnel stage | Metric                                                                       |
| ------------ | ---------------------------------------------------------------------------- |
| Acquisition  | GSC clicks / impressions (Pages); branded vs non-branded when Queries appear |
| Activation   | Key guide reads (GA4), scroll depth on `/accessibility/`                     |
| Conversion   | Enquiry form submits, CTA clicks                                             |
| Retention    | Return visits, email replies (ops)                                           |
| Referral     | Reviews, charity/partner links (manual)                                      |


Review **monthly** with **§16 B6** ritual.

---

**Conversion events:** See [inc/ANALYTICS-PRIMARY-GOAL.md](inc/ANALYTICS-PRIMARY-GOAL.md) for primary GA4 goals and message match with SEO seed copy.

## 11. Measurement baseline (Google Search Console)

### 11.1 Why **Pages** beats **Queries** (new / low-volume sites)

The **Queries** tab can show **only one row** or sparse strings **even when** **Pages** shows real impressions on `/accessibility/`, `/enquire/`, etc. That is **normal**:

- Google often **does not show** individual query strings below a volume threshold (privacy / aggregation).
- Performance is still counted **per URL** in **Pages** - trust **Pages** sooner than Queries.
- **Don’t wait for query rows** to improve SEO. Use **Pages**, **Countries**, **Devices**, plus §2–§4.

Per-page **Queries** drill-down may stay empty until traffic grows; same optimization path.

### 11.2 Snapshot - Pages (export dated **2026-05-10**)

*Replace this table when you re-export; keep the prior table in git history or a dated note below.*


| Page                      | Clicks | Impressions | CTR    | Avg position | Plan focus |
| ------------------------- | ------ | ----------- | ------ | ------------ | ---------- |
| `/`                       | 10     | 30          | 33.33% | 1.53         | Maintain   |
| `/accessibility/`         | 0      | 10          | 0%     | 13.3         | **P1**     |
| `/enquire/`               | 0      | 8           | 0%     | 5.88         | **P1**     |
| `/the-property/`          | 0      | 3           | 0%     | 14           | **P2**     |
| `/faq/`                   | 0      | 1           | -      | 1            | **P3**     |
| `/whitstable-area-guide/` | 0      | 1           | -      | 1            | **P3**     |


### 11.3 What each GSC export file is for

Store raw CSVs **off-repo** (e.g. Downloads backup). Summaries live **here**.


| File                      | Use                                                                                                   |
| ------------------------- | ----------------------------------------------------------------------------------------------------- |
| **Queries.csv**           | Which searches triggered listings (often thin early → mostly branded/direct).                         |
| **Pages.csv**             | Which URLs earn impressions/clicks → **prioritize titles/meta** where impressions exist but CTR is 0. |
| **Chart.csv**             | Daily trend → spot spikes/drops after deploys or indexing changes.                                    |
| **Countries.csv**         | Geo split (UK vs US intent; hreflang later if needed).                                                |
| **Devices.csv**           | Mobile vs desktop CTR/position (snippet tuning).                                                      |
| **Search appearance.csv** | Rich result / AI / video surfaces (empty = none reported this period).                                |
| **Filters.csv**           | Documents the slice so the next export is comparable.                                                 |


**Typical filters:** Search type **Web**, date range **Last 3 months** (adjust consistently month to month).

### 11.4 Countries & devices (same export as §11.2)

**Countries**


| Country        | Clicks | Impressions |
| -------------- | ------ | ----------- |
| United Kingdom | 10     | 22          |
| United States  | 0      | 16          |


**Devices**


| Device  | Clicks | Impressions |
| ------- | ------ | ----------- |
| Mobile  | 7      | 17          |
| Desktop | 3      | 21          |


### 11.5 Monthly compare ritual

1. Re-export Performance with **consistent filters** (§11.3).
2. Update **§11.2** table (or append a dated subsection).
3. Promote URLs with rising impressions into **P1** (§12).
4. Run **§16 B6** one-pager.

### 11.6 Agent measurement notes (Cursor)

*Append `#### Measurement - YYYY-MM-DD` with: five trend bullets, one experiment for a weak URL, KPI table hints. If GSC rows were pasted in the prompt, summarize them here as a compact markdown table (top URLs or queries only).*
#### Measurement - 2026-07-05 (consolidation)

**Open live verification** (from archived homepage plans — assign on deployed URL):

| Check | Owner | Status |
|-------|-------|--------|
| Keyword density / GSC editorial pass | Marketing | Open |
| Core Web Vitals (LCP, INP, CLS) on `/` | Engineering | Open |
| Security headers on production host/CDN | Engineering | Open |
| WCAG 2.2 AA axe scan on homepage | QA | Open |
| Keyboard + screen reader spot check | QA | Open |
| Database query profiling (heaviest templates) | Engineering | Optional |



---

## 12. Site inventory & priority tiers

### 12.1 Full inventory (money pages & hubs)

Use as **internal link hubs**. After launch, let GSC **confirm** which URLs earn impressions - rebalance links toward winners.


| Role               | Path                                                                                           | Notes                        |
| ------------------ | ---------------------------------------------------------------------------------------------- | ---------------------------- |
| Conversion         | `/enquire/`                                                                                    | Primary CTA                  |
| Property           | `/the-property/`                                                                               | Core commercial              |
| Funding hub        | `/resources/`                                                                                  | Pillar for CHC / DP / carers |
| Accessibility spec | `/accessibility/`                                                                              | Trust + technical detail     |
| Audience           | `/who-its-for/`                                                                                | Intent segmentation          |
| Area               | `/whitstable-area-guide/`                                                                      | Local + discovery            |
| Choice guide       | `/how-to-choose-accessible-self-catering-holiday/`                                             | Comparator intent            |
| DP                 | `/direct-payment-holiday-accommodation/`                                                       | High-intent funding          |
| Carers             | `/carers-respite-holiday-guide/`                                                               | Respite / rights             |
| FAQ                | `/faq/`                                                                                        | Snippet + citation candidate |
| Blog index         | `/blog/`                                                                                       | Cluster entry                |
| Alternatives       | `/revitalise-alternatives-accessible-holidays/`                                                | Competitive / comparison     |
| Travel extras      | `/travel-insurance-disability-uk-self-catering/`, `/what-to-pack-accessible-self-catering-uk/` | Supporting guides            |
| Coastal            | `/accessible-beaches-coastal-walks-kent/`                                                      | Local experience             |


Guest-facing `**/guest-guide/`** stays **noindex** (theme); do not push it in public SEO maps.

### 12.2 Priority tiers (execution order)

**P1:** `/accessibility/`, `/enquire/`  
**P2:** `/the-property/`, `/resources/`, `/how-to-choose-accessible-self-catering-holiday/`  
**P3:** `/who-its-for/`, `/direct-payment-holiday-accommodation/`, `/carers-respite-holiday-guide/`, `/whitstable-area-guide/`, `/accessible-beaches-coastal-walks-kent/`, `/faq/`  
**P4:** `/blog/` + posts per §3

---

## 13. Execution worksheet (per URL)

**At-a-glance progress:** update **[SEO-PROGRESS-MATRIX.md](SEO-PROGRESS-MATRIX.md)** when you complete P4 steps A–G or global prompts P1–P10 (see **Matrix write-back** at the top of this plan).


| Field                                     | Source      |
| ----------------------------------------- | ----------- |
| URL                                       |             |
| Tier (keyword research)                   | §2          |
| Cluster role (pillar / cluster / support) | §3          |
| Primary / secondary / AEO questions       | §2 + Step A |
| Title / meta                              | Step B      |
| H1 / H2 outline                           | Step C      |
| Snippet blocks added                      | Step D      |
| Body drafted/refreshed                    | Step E      |
| Outbound / inbound links                  | Step F      |
| AI/GEO checklist                          | §6–7        |
| Published date                            |             |


### 13.1 Worksheet rows - agent-filled (Cursor)


#### Home preset (`/` — from HOMEPAGE-PIPELINE-DELIVERABLE)

**Handoff doc:** [FRONT-PAGE-OPTIMIZATION.md](../FRONT-PAGE-OPTIMIZATION.md) · **Sources:** `front-page.php`, `inc/page-meta-definitions.php`, `inc/seo-content-seed.php` (slug `home`), `inc/seo.php`.

**Page Content Fields (all keys):** `hero_eyebrow`, `hero_heading`, `hero_subheading`, `hero_media_id`, `hero_cta_primary_label`, `hero_cta_primary_url`, `hero_cta_secondary_label`, `hero_cta_secondary_url`, `hero_cta_promise`; `what_restwell_label`, `what_restwell_heading`, `intro_body`; `who_label`, `who_heading`, `who_guest_title`, `who_guest_body`, `who_carer_title`, `who_carer_body`; `property_label`, `property_heading`, `property_body`, `property_cta_label`, `property_cta_url`, `property_image_id`; `why_label`, `why_heading`, `why_item1_title` … `why_item4_desc`; `trust_label`, `trust_heading`, `trust_badge_image_id`, `trust_line`; `testimonial_label`, `testimonial_heading`, `testimonial_1_quote` … `testimonial_5_role`; `cta_heading`, `cta_body`, `cta_primary_label`, `cta_primary_url`, `cta_secondary_label`, `cta_secondary_url`, `cta_promise`, `cta_image_id`.

**Editor warning:** If `post_content` is non-empty, `$use_editor_main` in `front-page.php` uses editor HTML and omits the default section stack and bottom CTA.

**Schema:** Do **not** add extra homepage JSON-LD. `is_front_page()` outputs `WebSite` + `LodgingBusiness` via `inc/seo.php`. `VacationRental` only on property template.

**LodgingBusiness field sources:**

| Schema field | Source |
|--------------|--------|
| `name` | `get_bloginfo( 'name' )` |
| `description` | Fixed string in `inc/seo.php` |
| `url` | `home_url( '/' )` |
| `address.streetAddress` | Option `restwell_property_address` |
| `address.postalCode` | Option `restwell_property_postcode` |
| `addressLocality` / `addressRegion` / `addressCountry` | `Whitstable`, `Kent`, `GB` (hardcoded) |
| `geo` | Hardcoded lat/long in `inc/seo.php` — update in code if coordinates must be exact |
| `telephone` | Option `restwell_phone_number` |
| `email` | Option `restwell_enquiry_notify_email` |
| `image` | Front page `og_image_id`, else `hero_media_id` if image |
| `tourBookingPage` | Permalink of page slug `enquire` |
| `checkinTime` / `checkoutTime` / `petsAllowed` / `amenityFeature` | Hardcoded in `inc/seo.php` |

**Siblings (intent):** Homepage = discovery; `/the-property/` = depth; `/accessibility/` = full spec; `/enquire/` = conversion; `/who-its-for/` = persona detail.

*Add or update **one data row per URL per pass** (append new `|` rows). Keep cells short; link to long copy in WP rather than pasting thousands of words.*


| URL                                                                          | Run date (ISO) | Tier | Primary                                                       | Secondaries (comma)                                                                                                                                                                                                                                                                                                                                                                                                                              | Title (chosen)                                                   | Meta (chosen)                                                                                                                                                     | H1 / H2 summary                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     | Snippets / FAQ summary                                                                                                         | Body / links notes                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         | Published / verified                                                                                                                                                                                                                                |
| ---------------------------------------------------------------------------- | -------------- | ---- | ------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | ---------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------ | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `/accessibility/`                                                            | 2026-05-11     | 1    | accessible holiday cottage hoist and wet room Whitstable Kent | tracking hoist holiday accommodation, accessible self catering Kent coast, disabled access holiday cottage Whitstable, wheelchair accessible holiday cottages in Kent (on-page intro), access statement PDF                                                                                                                                                                                                                                      | Accessible cottage hoist & wet room Kent - Restwell Retreats     | Accessible self-catering near Whitstable: hoist, profiling bed, roll-in shower. Download our access statement PDF or request measurements. Restwell Retreats.     | **P4 Step C (2026-05-11), compact:** **H1** Wheelchair accessible holiday cottage near Whitstable: hoist, wet room, and measurements we publish. **H2** Published door widths and level access. **H2** Roll-in wet room and bathroom kit. **H2** Ceiling track hoist in the accessible bedroom (Confirm in WP: sling type or weight limit if you publish them). **H2** Kitchen: gas hob, not induction. **H2** Room-by-room verified detail (H3: Arrival and entrance; Inside the property; Bedrooms and sleeping; Bathroom; Kitchen; Outdoor spaces). **H2** Whitstable: what works, what gets awkward, beach reality (H3: The good; The challenge; The reality). **H2** Access statement PDF and measurement requests. **H2** Ask us before you book (CTA /enquire/). **Note:** set WP acc_heading to match this H1 (Confirm in WP: one visible H1).                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              | AEO (§2.6): door widths, measurements on request, PDF for OTs or commissioners, honest beach or town caveats (template-backed) | **P4 Step C (2026-05-11):** Full ordered ladder in §4.1 under Step C dated 2026-05-11 for this URL. **P4 Step B (2026-05-10):** Runner-up titles T2 Whitstable hoist & wet room cottage - Restwell Retreats; T3 Tracking hoist cottage Whitstable Kent - Restwell Retreats. Runner-up metas (148c) Disabled access cottage Whitstable: tracking hoist and wet room. Quiet Kent coast self-catering. PDF access statement for OTs. Request measurements.; (147c) Accessible holiday cottage Whitstable Kent: hoist, profiling bed, wet room. Download the PDF access statement. Quiet self-catering for family rest. **Rationale:** chosen pair matches seed equipment in `inc/seo-content-seed.php` and template CTAs (PDF, measurements). **Intent:** informational plus commercial investigation. **Cannibal:** do not also target `adapted bungalow whitstable` on URL `/accessibility/` (`/the-property/`). Do not also target `accessible holidays whitstable` as primary here (`/`). **Overlap:** `/whitstable-area-guide/` owns broad days-out primaries. **Editor:** Confirm in WP: meta matches published kit and PDF; do not edit `inc/seo.php` until human confirms                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             | Seed defaults in theme; human publish TBD; P4 Step C logged in plan 2026-05-11; D-G TBD in WP                                                                                                                                                       |
| `/enquire/`                                                                  | 2026-05-11     | 1    | accessible holiday cottage hoist and wet room Whitstable Kent | tracking hoist holiday accommodation (SERP phrase; publish ceiling track hoist on property URLs unless WP confirms tracking), accessible self catering Kent coast, disabled access holiday cottage Whitstable, contact restwell (seed; confirm in GSC before swapping Primary back)                                                                                                                                                              | Accessible Kent hoist cottage: enquire - Restwell Retreats       | Enquire: hoist, profiling bed, wet room Whitstable Kent. Accessible self-catering Kent coast. Reply in one to two working days, often sooner. Restwell Retreats.  | **P4 Step C (2026-05-11), compact:** **H1** Contact Restwell about accessible self-catering near Whitstable, Kent (Confirm in WP: hero H1 via enq_heading; single H1 in interior-hero). **H2** Ways to reach us (form, phone, email). **H2** Conversation first, not a booking commitment. **H2** How quickly we usually reply (one to two working days, often sooner; urgent path one working day where possible). **H2** What happens next after you submit (review dates, we contact you, no commitment yet). **H2** If you do not hear back (48-hour call or email when mail warn applies). **H2** Tight dates or urgent requests (time-sensitive checkbox; Confirm in WP label copy). **H2** Send the enquiry form (H3 About you; H3 Your stay; H3 Your needs with care, accessibility, funding). **H2** Hoist, wet room, and profiling bed detail (link `/accessibility/` and `/the-property/`; no duplicate measurements).                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   | Transactional AEO: SLA, contact channels, what happens after submit                                                            | Cross-link from `/accessibility/` CTA and funding pages; keep booking story on `/the-property/`. **P4 Step B (2026-05-11):** Runner-up titles T2 Tracking hoist Whitstable: enquire Kent - Restwell Retreats; T3 Disabled access Whitstable enquire hoist - Restwell Retreats. Runner-up metas M2 Accessible Kent coast: enquire for hoist, profiling bed, wet room Whitstable. Reply in one to two working days. Form for care and access. Restwell Retreats.; M3 Tracking hoist Whitstable: enquire with dates, care, and access needs. Reply one to two working days. Full specs on Accessibility page. Restwell Retreats. **Rationale:** T1 plus M1 pair enquiry-first conversion with the Step B kit and place words, use template-backed reply timing (not the old seed-only 48-hour line), and defer detailed hoist type proof to `/accessibility/` (see §4.1 `#### Step B - 2026-05-11 - https://restwellretreats.co.uk/enquire/`). **Intent:** transactional enquiry hub. **Cannibal:** keep spec tables on `/accessibility/` and `/the-property/`. **Human:** paste into WP Search and Social; do not edit `inc/seo.php` until confirmed                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         | Chosen Step B in plan 2026-05-11; WP paste TBD. **P4 Step C (2026-05-11):** Full H1 and H2 ladder in §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/enquire/`; implement in WP when editor adds sections or adjusts ACF hero copy. |
| `/how-it-works/` (`template-how-it-works.php`)                               | 2026-05-11     | 2    | accessible holiday cottage hoist and wet room Whitstable Kent | tracking hoist holiday accommodation (SERP phrase; publish ceiling track hoist unless WP confirms tracking), accessible self catering Kent coast, disabled access holiday cottage Whitstable                                                                                                                                                                                                                                                     | Accessible cottage Whitstable: 4 steps - Restwell Retreats       | Whitstable accessible stay: 4 steps to book, optional care or PA. FAQ for deposits and cancellation. Hoist, profiling bed, wet room on accessibility. Enquire.    | **P4 Step C (2026-05-11), compact:** **H1:** How your accessible stay at Restwell works (enquiry to arrival) (Confirm in WP `hiw_heading` vs this line). **H2:** Four steps to your stay, **H3:** Get in touch; We'll call you back; Confirm your booking; Arrive and rest easy (Confirm in WP: step labels may match `template-how-it-works.php` fallbacks instead). **H2:** Is care required when you book? **H2:** What is included in the house? **H2:** Deposits, changes, and cancellation. **H2:** When should I book? **H2:** How far is the beach on foot? Full ladder §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/how-it-works/`                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      | TBD Step D                                                                                                                     | **P4 Step B (2026-05-11):** Runner-up titles T1 Whitstable accessible stay: 4 steps - Restwell Retreats; T3 Hoist Whitstable stay: 4-step booking - Restwell Retreats. Runner-up metas in §4.1 `#### Step B - 2026-05-11 - https://restwellretreats.co.uk/how-it-works/`. **Rationale:** Title leads with accessible cottage plus Whitstable and a clear step promise for this template. Meta matches the four-step journey, optional regulated care or own PA (`template-how-it-works.php` step three default), sends deposits and cancellation to the shared FAQ (theme default `faq_11` cancellation bands), and points hoist plus profiling bed plus wet room to `/accessibility/` per §2.6 ownership (no spec tables on HIW). **Intent:** mixed informational plus commercial (enquiry path). **Cannibal:** keep equipment primaries on `/accessibility/` and `/the-property/`; keep form conversion on `/enquire/`. **Confirm in WP:** Search and Social paste; align Yoast focus keyphrase with seed `accessible stay` or this worksheet primary after GSC check (§2.6 Next validation). **Do not edit** `inc/seo.php` until human confirms. **P4 Step C (2026-05-11):** H1 or H2 outline logged above and in §4.1 Step C block.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    | TBD                                                                                                                                                                                                                                                 |
| `/resources/` (`template-resources.php`)                                     | 2026-05-11     | 1    | holiday care funding Kent                                     | accessible holiday cottage hoist and wet room Whitstable Kent, tracking hoist holiday accommodation (SERP phrase; publish ceiling track hoist unless WP confirms tracking), accessible self catering Kent coast, disabled access holiday cottage Whitstable                                                                                                                                                                                      | Accessible Kent funding hub: hoist stays - Restwell Retreats     | Kent funding hub: CHC, direct payments, carers, grants. Whitstable-area accessible self-catering: hoist, profiling bed, wet room. Browse guides, enquire.         | **P4 Step C (2026-05-11):** **H1** Holiday care funding in Kent (Confirm in WP hero res_heading matches). **H2** How to fund your stay; Grants and charities; NHS Continuing Healthcare (CHC); Complaints and appeals; Key Kent contacts; Related guides. **H3 (fund)** Direct payments and respite: `/direct-payment-holiday-accommodation/`; personal budget versus CHC: `/personal-budget-short-break-care-act/` and `/chc-respite-holiday-accommodation-uk/`; care versus lodging; commissioner paperwork: `/commissioner-checklist-accessible-respite-stay/` (Confirm in WP forms Restwell supplies). **H3 (CHC band)** Definition plus ICB handoff per template default email, depth on `/chc-respite-holiday-accommodation-uk/`. **H3 (related)** Carer-led self-catering break `/carers-respite-holiday-guide/`; property checklist `/how-to-choose-accessible-self-catering-holiday/`; beaches `/accessible-beaches-coastal-walks-kent/`; Revitalise or grants `/revitalise-alternatives-accessible-holidays/`; audience `/who-its-for/` (mirrors Related guides list; optional WP rows for CHC or PB guides if editor wants list parity).                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 | TBD Step D                                                                                                                     | **P4 Step B (2026-05-11):** Runner-up titles T2 Holiday care funding Kent: hoist guides - Restwell Retreats; T3 Kent funding for hoist breaks: guides - Restwell Retreats. Runner-up metas (156c) Accessible self catering Kent coast: CHC, direct payments, carers, grants hub. Whitstable-area stay: hoist, profiling bed, wet room. Browse guides, enquire.; (150c) Kent funding routes: CHC, direct payments, carers, grants. Whitstable-area self-catering: hoist, profiling bed, wet room. Read linked guides, enquire. **Rationale:** Title opens **Accessible**, **Kent**, and **funding hub**, then **hoist stays** as a bridge to the Step B pack without making this URL the spec owner (`template-resources.php` defaults signpost KCC carers and care needs lines, paying for care, direct payments, grants, CHC ICB email, complaints, key contacts). Chosen meta lists funding systems first, then the one-place kit USP, ends **Browse guides, enquire** so the hub routes intent to long-tail guides. **Step A vs brief:** **Primary** stays **holiday care funding Kent** per §2.6; pasted long cottage phrase sits in **Secondaries** until GSC supports a swap. **Cannibal:** CHC or DP depth on cluster URLs; hoist measurements on `/accessibility/`; booking proof on `/the-property/`. **Human:** Paste into WP Search and Social; full Step B block §4.1 `#### Step B - 2026-05-11 - https://restwellretreats.co.uk/resources/`; **do not** edit `inc/seo.php` until human confirms.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              | TBD                                                                                                                                                                                                                                                 |
| `/the-property/` (`template-property.php`)                                   | 2026-05-11     | 2    | accessible holiday cottage hoist and wet room Whitstable Kent | adapted bungalow whitstable, tracking hoist holiday accommodation (SERP phrase; on-page: ceiling track hoist per `template-property.php`), accessible self catering Kent coast, disabled access holiday cottage Whitstable, ceiling track hoist accessible bedroom, step-free parking to all rooms                                                                                                                                               | Accessible Whitstable: hoist, wet room - Restwell Retreats       | Adapted bungalow Whitstable area, Kent: ceiling track hoist, profiling bed, roll-in wet room. Quiet self-catering for families. Read specs on-page, then enquire. | **P4 Step C (2026-05-11):** **H1:** Our accessible home in Whitstable (default `prop_hero_heading` in `inc/theme-setup.php`; Confirm in WP). **H2:** Everything you need. Nothing you don't (home cards: step-free, sleeps up to five, quiet). Thoughtful at every turn (dignity band: adapted home, hoist in accessible bedroom, wet room). What's in the house (feature grid: hoist, wet room, profiling bed, doors, step-free, patio, kitchen, Wi-Fi). Honest accessibility information (confirmed list; hoist weight limit TBC per theme). A house, not a hotel room (hotel comparison; optional CQC line from theme). Take a look around (gallery or 3D if linked, Confirm in WP). The basics, clearly (bedrooms, wet room, parking, distances; Tankerton Slopes promenade 15 min flat walk in defaults). Explore Whitstable (nearby cards). **H3:** Hoist scope (accessible bedroom, ceiling track wording per theme; Confirm in WP vs access statement). Sleeps and parking (two on drive; on-street note in defaults). Link full wet room and door widths to `/accessibility/`. Full ladder §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/the-property/`                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  | TBD Step D                                                                                                                     | **Intent:** commercial transactional, spec verification before deposit (not a generic area guide). **LSI or entities (repo defaults):** Whitstable Kent coast, Tankerton promenade, wheelchair users, carers, transfer space, profiling bed, pressure-relieving mattress, grab rails, adjustable washbasin, door clear widths 926 mm and 965 mm, driveway parking, optional CQC-regulated care on site (comparison copy only). **Cannibal:** do not also target `wheelchair accessible holiday cottages in Kent` or singular cottage spec-hub primaries on URL `/the-property/` (owner `/accessibility/`). Do not also target `accessible holidays whitstable` as this URL primary (owner `/`). Keep funding primaries on `/resources/` and guides; local days-out depth on `/whitstable-area-guide/`. **Editor:** Confirm in WP: live hero and meta if overrides; link full wet-room and hoist scope to `/accessibility/`; hoist weight limit remains TBC in theme default list (`prop_acc_tbc`), do not publish a limit until confirmed. **P4 Step B (2026-05-11):** Runner-up titles T2 Adapted bungalow Whitstable: hoist, wet room - Restwell Retreats; T3 Self-catering Whitstable: hoist, wet room - Restwell Retreats. Runner-up metas: see §4.1 `#### Step B - 2026-05-11 - https://restwellretreats.co.uk/the-property/`. **Rationale (short):** Chosen pair front-loads accessible plus Whitstable plus hoist plus wet room without mirroring `/accessibility/` title shape; meta names adapted bungalow and kit lines aligned to `template-property.php` accessibility list. **Human:** Paste into WP Search and Social; do not edit `inc/seo.php` until confirmed                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             | Seed defaults; Step B chosen in plan; WP publish TBD; Steps D-G TBD                                                                                                                                                                                 |
| `/whitstable-area-guide/` (`template-whitstable-guide.php`)                  | 2026-05-11     | 2    | accessible holiday cottage hoist and wet room Whitstable Kent | tracking hoist holiday accommodation (SERP phrase; type-specific wording on `/accessibility/` and `/the-property/`, not this pillar), accessible self catering Kent coast, disabled access holiday cottage Whitstable                                                                                                                                                                                                                            | Accessible Kent coast Whitstable guide - Restwell Retreats       | Whitstable guide: promenades, parking, buses, access notes. Quiet Restwell self-catering with hoist, profiling bed, wet room. See accessibility, enquire.         | **P4 Step C (2026-05-11), compact:** **H1** Whitstable and Kent coast: practical local guide when accessibility shapes your plans. **H2** Whitstable town, harbour, and realistic pavements. **H2** Tankerton promenade: level seafront route for wheelchairs and powerchairs. **H2** Parking near town (Gorrell Tank summary, link `/accessible-parking-whitstable-tankerton/` for Blue Badge depth). **H2** The Street shingle spit: not a wheelchair route at low tide. **H2** Getting here: by car (M2, A299) and by train (Confirm layout with National Rail or your operator). **H2** Buses and local travel (Stagecoach 400, low-floor and ramp caveats). **H2** Nearby towns: Canterbury, Faversham, Herne Bay. **H2** Eating out near the property (Plough, harbour; Confirm in WP for live venue access lines). **H2** Plan before you go and on the day (taxis, venue checks, weather). **H2** Local access context (surfaces, slopes, crowding, not blanket venue labels). **H2** Key areas at a glance (spotlight photos when set in WP). **H2** Restwell base while you plan days out (hoist, profiling bed, wet room: see `/accessibility/`, enquire). **H2** Related reading (beaches, parking, eating, quieter times clusters).                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    | TBD Step D                                                                                                                     | **P4 Step C (2026-05-11):** Full ordered ladder in §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/whitstable-area-guide/`. **P4 Step B (2026-05-11):** Runner-up titles T2 Self-catering Kent coast Whitstable guide - Restwell Retreats; T3 Disabled-access Whitstable: Kent coast guide - Restwell Retreats. Runner-up metas in §4.1 `#### Step B - 2026-05-11 - https://restwellretreats.co.uk/whitstable-area-guide/`. **Rationale:** Title keeps local pillar as a **guide** (not a duplicate of `/the-property/`) while opening with **accessible** and **Kent coast** for planners. Meta mirrors template topics (promenades, parking, buses, access notes), states quiet self-catering USP with hoist, profiling bed, wet room, defers spec claims to `/accessibility/` (`See accessibility`), ends with **Enquire**. **Intent:** informational coast planning plus soft commercial bridge. **Cannibal:** deep hoist or wet room measurements stay on `/accessibility/`; do not assert venue-by-venue access beyond `template-whitstable-guide.php` defaults (Confirm in WP for any new venue claims). **Human:** Paste into WP Search and Social; do not edit `inc/seo.php` until human confirms                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 | TBD                                                                                                                                                                                                                                                 |
| `/accessible-beaches-coastal-walks-kent/` (`page.php` seeded guide)          | 2026-05-11     | 2    | accessible beaches kent                                       | accessible beaches coastal walks Kent, tracking hoist holiday accommodation (SERP phrase; use ceiling track hoist on publish unless WP confirms tracking), accessible self catering Kent coast, disabled access holiday cottage Whitstable, accessible holiday cottage hoist wet room Whitstable Kent (commercial bridge; spec depth on `/accessibility/`)                                                                                       | Accessible beaches Kent coast guide - Restwell Retreats          | Accessible beaches Kent: promenades, parking, access notes. Whitstable-area self-catering with hoist, profiling bed, wet room. See accessibility, enquire.        | **P4 Step C (2026-05-11), compact:** **H1** Accessible beaches Kent: practical notes on promenades, sand, and hire schemes (Confirm in WP: single visible H1). **H2** What counts as accessible beach access in Kent? **H2** Who this Kent coast guide is for? **H2** Where to borrow beach wheelchairs on the Kent coast. **H2** Is Whitstable beach workable on wheels? **H2** Whitstable to Herne Bay with limited stamina. **H2** Blue Flags, water quality, and access limits. **H2** Thanet sandy bays and day trips (H3 Viking Bay; H3 Margate Main Sands; H3 Turner Contemporary). **H2** Toilets, trails, and parking checks (H3 Broadstairs Harbour toilets; H3 Dreamland Blue Badge parking; H3 Viking Coastal Trail). **H2** Changing Places and toilet planning (signpost `/changing-places-toilets-kent-coast-days-out/`). **H2** Parking and drop-off near Whitstable (link `/accessible-parking-whitstable-tankerton/`). **H2** Funding routes and paperwork for a Kent break (light signpost `/resources/`). **H2** After a coast day near Whitstable (hoist, profiling bed, wet room; `/accessibility/`, enquire). **H2** Related guides.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         | TBD Step D                                                                                                                     | **P4 Step C (2026-05-11):** Full ordered ladder in §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/accessible-beaches-coastal-walks-kent/`. **P4 Step B (2026-05-11):** Runner-up titles T1 Accessible beaches Kent: walks - Restwell Retreats; T3 Accessible beaches Whitstable Kent - Restwell Retreats. Runner-up metas M2 Plan accessible beaches Kent: realistic access notes for coastal walks. Quiet self-catering near Whitstable: hoist, profiling bed, wet room. Enquire online.; M3 Accessible beaches Kent guide: Tankerton, Herne Bay, access tips. Self-catering near Whitstable: hoist, profiling bed, wet room. Read accessibility, enquire. **Rationale, intent, cannibal, facts:** see §4.1 `#### Step B - 2026-05-11 - https://restwellretreats.co.uk/accessible-beaches-coastal-walks-kent/`. **Human:** Paste chosen title and meta into WP Search and Social; do not edit `inc/seo.php` until human confirms                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         | TBD                                                                                                                                                                                                                                                 |
| `/accessible-parking-whitstable-tankerton/` (`page.php` seeded guide)        | 2026-05-11     | 2    | accessible parking whitstable                                 | accessible parking whitstable kent, tracking hoist holiday accommodation (SERP phrase; publish ceiling track hoist unless WP confirms tracking), accessible self catering Kent coast, disabled access holiday cottage Whitstable, accessible holiday cottage hoist wet room Whitstable Kent (commercial bridge; kit depth on `/accessibility/`)                                                                                                  | Accessible parking Whitstable Kent - Restwell Retreats           | Blue Badge Whitstable Tankerton: tight bays, drop-off first, kerbs. Quiet Kent self-catering: hoist, profiling bed, wet room. Read accessibility, enquire.        | **P4 Step C (2026-05-11), compact:** **H1** Accessible parking in Whitstable and Tankerton, Kent (Confirm in WP: one visible H1). **H2** What counts as accessible parking here (definition, short roll distance, not logo-only). **H2** Reliable Blue Badge space near Whitstable seafront (AEO §2.3 Q1). **H2** Tankerton compared with Whitstable harbour when it is busy (AEO Q2; kerbs, slopes). **H2** Tides, events, and parking turnover (AEO Q3). **H2** Drop-off when you cannot walk far from the car (AEO Q4). **H2** Weekday patterns and quieter visits (AEO Q5; link `/quieter-times-whitstable-low-crowd-access/`). **H2** On-street rules, pay and display, and car parks (Confirm in WP: council tariffs on official sites). **H2** Harbour approaches and busy weekends (Confirm in WP: festival dates yearly). **H2** Practical checks before you drive (seed list; timer disc; wet-weather plan). **H2** If your trip is funded (signpost `/resources/` only). **H2** Rail, taxi, and station links (link `/accessible-train-travel-whitstable-kent/`). **H2** FAQs (**H3** Blue Badge charges; **H3** Promenade level; **H3** Harbour bay reserve; **H3** Powerchair routing; **H3** When bays are full). **H2** Next reads: beaches, area guide, property access (`/accessible-beaches-coastal-walks-kent/`, `/whitstable-area-guide/`, `/accessibility/`, `/enquire/`).                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     | TBD Step D                                                                                                                     | **P4 Step C (2026-05-11):** Full ordered ladder in §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/accessible-parking-whitstable-tankerton/`. **P4 Step B (2026-05-11):** Runner-up titles T2 Blue Badge Whitstable: crowds, parking - Restwell Retreats; T3 Tankerton drop-off: Whitstable parking - Restwell Retreats. Runner-up metas M2 Accessible parking Whitstable: bay timing, drop-off when busy, Tankerton kerbs. Kent self-catering: hoist, profiling bed, wet room. See accessibility, enquire. (159c); M3 Disabled-access Whitstable parking: Blue Badge basics, summer crowding, prom access. Quiet cottage: hoist, profiling bed, wet room. Read accessibility, enquire. (160c). **Rationale:** T1 plus M1 match Step A parking intent, put Kent in the title, and use M1 for Blue Badge, Tankerton, and crowding realism (tight bays, drop-off, kerbs) aligned to `restwell_get_blog_post_accessible_parking_whitstable_html()` and seed `meta_description` themes; both USPs appear in the meta as a stay bridge, not as on-street hoist claims. **Cannibal:** keep bay mechanics here; `/whitstable-area-guide/` for town hub; `/accessible-beaches-coastal-walks-kent/` for shore surfaces; `/accessibility/` for measurements. **Human:** Paste into WP Search and Social; do not edit `inc/seo.php` until confirmed                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   | TBD                                                                                                                                                                                                                                                 |
| `/accessible-eating-out-whitstable-kent/` (`page.php` seeded guide)          | 2026-05-11     | 2    | accessible eating out whitstable                              | accessible eating out whitstable kent, accessible holiday cottage hoist and wet room Whitstable Kent (Step B bridge only, kit on `/accessibility/`), tracking hoist holiday accommodation (SERP phrase; publish ceiling track hoist unless WP confirms tracking), accessible self catering Kent coast, disabled access holiday cottage Whitstable                                                                                                | Accessible eating out Whitstable Kent - Restwell Retreats        | Plan Whitstable dining access: step-free checks, toilet routes, call ahead. Quiet self-catering: hoist, profiling bed, wet room. Read accessibility, enquire.     | **P4 Step C (2026-05-11), compact:** **H1** Accessible eating out near Whitstable, Kent (Confirm in WP: one visible H1; seed post title is close). **H2** What accessible eating out means on this page (§2.3 definition; Tier 1 primary framing). **H2** Why harbour crowds and weekends change access (§2.0 AEO harbour circulation; oyster festival angle Confirm in WP yearly). **H2** Step-free entries and real thresholds (Tier 1 step-free harbour; door lip photos). **H2** Toilet routes, not cubicle labels alone (§2.0 AEO script; **H3** entrance and threshold; **H3** same-level WC versus stairs). **H2** How to plan meals before you arrive (§2.3 planning steps; call ahead, chair dimensions). **H2** Quieter tables and lower-sensory tactics (§2.0 AEO quieter tables; link `/quieter-times-whitstable-low-crowd-access/`). **H2** Harbour strip versus side streets (trade-offs; link `/accessible-parking-whitstable-tankerton/`). **H2** Kent coast towns for an accessible food day trip (§2.0 AEO pairing). **H2** Menus, allergies, and texture checks (§2.0 AEO dysphagia row: Confirm in WP before dysphagia depth; seed covers large print or QR). **H2** Documents, receipts, and funding overlaps on a wider trip (§2.3 documents plus DP or CHC overlap; signpost `/resources/` only). **H2** Changing Places versus in-venue loos (signpost `/changing-places-toilets-kent-coast-days-out/`; keep venue loo honesty here). **H2** Common mistakes when listings sound easy. **H2** Frequently asked questions (seed themes). **H2** Next reads and enquiries (`/whitstable-area-guide/`, `/blog/`, `/enquire/`; kit on `/accessibility/`).                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       | TBD Step D                                                                                                                     | **P4 Step C (2026-05-11):** Full ordered ladder in §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/accessible-eating-out-whitstable-kent/`. **P4 Step B (2026-05-11):** Runner-up titles T2 Step-free dining Whitstable: loos, routes - Restwell Retreats; T3 Disabled-access dining Whitstable Kent - Restwell Retreats. Runner-up metas M2 Accessible eating out Whitstable: what to ask venues before you book. Kent coast self-catering with hoist, profiling bed, wet room. See accessibility, enquire.; M3 Whitstable disabled-access dining: entries, toilet routes, no fixed venue list. Quiet cottage: hoist, profiling bed, wet room. Read accessibility, enquire. **Rationale:** T1 matches Step A seed primary plus Kent before brand; M1 covers step-free and toilet-route planning without naming venues unless WP verifies, carries both USPs (quiet self-catering plus hoist, profiling bed, wet room), sends hoist or wet room proof to `/accessibility/` before enquire. **Step A vs brief:** pasted foundation primary **accessible holiday cottage hoist and wet room Whitstable Kent** is **not** the query owner for this URL (dining guide per §2.6 run **2026-05-10**); it stays in Secondaries for pack alignment only. **Cannibal:** keep town hub on `/whitstable-area-guide/`; keep commercial booking on `/the-property/`; do not claim restaurant hoist coverage beyond what seed or WP body states (**Confirm in WP:** venue lines and Changing Places cross-links). **Human:** Paste into WP Search and Social; **do not** edit `inc/seo.php` until confirmed                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              | TBD                                                                                                                                                                                                                                                 |
| `/who-its-for/` (`template-who-its-for.php`)                                 | 2026-05-11     | 2    | accessible stay suitability                                   | accessible holiday cottage hoist and wet room Whitstable Kent (supporting Step B brief), tracking hoist holiday accommodation (SERP phrase; publish wording uses ceiling track hoist unless WP confirms), accessible self catering Kent coast, disabled access holiday cottage Whitstable, commissioner referral documentation adapted respite stay, carer assessment short break self catering UK                                               | Accessible stay suitability guide - Restwell Retreats            | Accessible stay suitability for carers, families and commissioners: check hoist, profiling bed, wet room and funding routes before you enquire online.            | **P4 Step C (2026-05-11):** **H1:** Accessible stay suitability: who Restwell is for. **H2 (AEO §2.6 order):** Who is Restwell for if you are a carer? **H3:** Care Act Carer's Assessment; separate sleeping area; wet room for assisted care. **H2:** What evidence do commissioners need for a funded stay? **H3:** Property specification, access measurements, CQC-registered care confirmation (Confirm in WP). **H2:** What should an OT check before recommending Restwell? **H3:** Doorways, turning circles, hoist specs on `/accessibility/`; on-request measures. **H2:** Is wheelchair friendly wording reliable for holiday cottages? **H3:** Guests and families band (ceiling track hoist in accessible bedroom, wet room, read specification CTA). **H2:** How does funding work for a short break in Kent? **H3:** Care and Support Assessment; KCC Adult Social Care; local authority and direct payments; personal health budget; private self-funded. **H2:** Real photos and related reading **H3:** Layout and equipment; links to `/accessibility/`, `/resources/`, cluster guides (Confirm in WP: related strip)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           | TBD Step D                                                                                                                     | **P4 Step C (2026-05-11):** outline in H1 or H2 summary cell; full ladder §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/who-its-for/`. **P4 Step B (2026-05-11):** Runner-up titles T2 Accessible stay fit: hoist, wet room - Restwell Retreats; T3 Respite breaks Kent: who it is for - Restwell Retreats. Runner-up metas: see §4.1 `#### Step B - 2026-05-11 - https://restwellretreats.co.uk/who-its-for/`. **Rationale:** chosen title keeps locked Step A primary exact and early; chosen meta adds verified hoist, profiling bed, wet room, funding, and audience-fit proof without competing with `/accessibility/` spec depth. **Cannibal:** `/who-its-for/` owns suitability and referral fit; `/accessibility/` owns measurement and spec depth; `/resources/` owns funding depth; `/the-property/` owns commercial property proof. **Human:** Paste into WP Search and Social; do not edit `inc/seo.php` until confirmed                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     | Seed defaults; Step B chosen in plan; WP publish TBD; Steps D-G TBD                                                                                                                                                                                 |
| `/faq/` (`template-faq.php`)                                                 | 2026-05-11     | 2    | accessible holiday cottage hoist and wet room Whitstable Kent | tracking hoist holiday accommodation (SERP phrase; theme FAQ8 uses ceiling track hoist and profiling bed per `inc/theme-setup.php`, Confirm in WP), accessible self catering Kent coast, disabled access holiday cottage Whitstable, restwell booking questions                                                                                                                                                                                  | Accessible cottage FAQ: hoist, wet room - Restwell Retreats      | Booking, cancellation, funding, and care FAQs. Near Whitstable, Kent: hoist, profiling bed, wet room in one self-catering place. Enquire or read accessibility.   | **P4 Step C (2026-05-11), compact:** **H1** Booking and access FAQs for Restwell (Whitstable area, Kent) (Confirm in WP `faq_heading` single H1). **H2 (§2.3 AEO)** What is included in the price? **H2** What is our cancellation policy? **H2** Can direct payments be used for a stay? **H2** What accessibility equipment is included? **H3** Ceiling track hoist in accessible bedroom, profiling bed, wet room, rails, washbasin, parking (Confirm in WP; match FAQ8 and `/accessibility/`). **H2** How far is the sea on foot? **H2 (Step A)** What is Restwell? **H2** How do I book? **H2** Care, personal support, and the regulator **H2** Local access in Whitstable **H2** Common questions by topic (filters) **H2** Further reading **H2** Still have a question?                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    | TBD Step D                                                                                                                     | **P4 Step C (2026-05-11):** Full ordered ladder §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/faq/`. **P4 Step B (2026-05-11):** Runner-up titles T2 Whitstable FAQ: hoist, wet room, booking - Restwell Retreats; T3 Hoist and wet room FAQ: Whitstable area - Restwell Retreats. Runner-up metas in §4.1 `#### Step B - 2026-05-11 - https://restwellretreats.co.uk/faq/`. **Rationale:** Title keeps accessible, cottage, hoist, and wet room early, adds FAQ so SERP matches support intent. Meta lists booking friction topics that match FAQ tabs on `template-faq.php`, names hoist plus profiling bed plus wet room in one line, and sends spec readers to `/accessibility/`. **Cannibal:** keep equipment depth on `/accessibility/` and `/the-property/`; keep funding primaries on `/resources/` and long guides; FAQ stays short with outbound links per §2.6 run **2026-05-10**. **Schema:** Confirm in WP: FAQPage JSON-LD matches visible accordion wording after publish. **Human:** Paste into WP Search and Social; do not edit `inc/seo.php` until confirmed                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          | Seed defaults; Step B chosen in plan; WP publish TBD; Steps D-G TBD                                                                                                                                                                                 |
| `/contact/` (`template-contact.php`)                                     | 2026-07-05     | 2    | contact restwell Whitstable                     | phone, email, professional referral                                     | Contact Restwell Retreats \| Accessible Whitstable                    | Phone, email and post. Professional referral lane without inventing policy. | H1 contact; H2 phone, email, location, professionals                     | Reassurance FAQ if needed                                               | Link to /enquire/, /faq/, /accessibility/                               | Seed in WP; verify NAP matches JSON-LD                                  |
| `/guest-guide/` (`page-guest-guide.php`)                                     | 2026-05-11     | 3    | accessible holiday cottage hoist and wet room Whitstable Kent | tracking hoist holiday accommodation (SERP phrase; publish ceiling track hoist in metas, not unverified tracking), accessible self catering Kent coast, disabled access holiday cottage Whitstable, restwell guest guide (nav)                                                                                                                                                                                                                   | Accessible hoist cottage Whitstable - Restwell Retreats          | Kent coast self-catering Whitstable: WiFi, parking, rules, tips. Quiet stay. Ceiling track hoist, profiling bed, wet room. OTP to open. Restwell Retreats.        | **P4 Step C (2026-05-11), compact:** **H1** Restwell guest guide: your arrival and stay (Confirm in WP: `interior-hero` heading string, `page-guest-guide.php` default is `Your arrival guide`; keep one visible H1 across gate states). **H2** Open the guide after you book (**H3** booking email and send code; **H3** enter 6-digit code; **H3** if the code expired, resend or start again). **H2** Why we ask for email and a code (verify it is you, limit scraping). **H2** What you will find here (check-in, keys, WiFi, parking, rules, departure, Whitstable-area tips, emergency numbers; kit measurements stay on `/accessibility/`). **H2** How the blog differs from this guide (public `/blog/` versus gated ops). **H2** Guest guide versus accessibility specification (ops and local here; PDF and room detail on `/accessibility/`). **H2** Arrival details. **H2** Getting in. **H2** WiFi. **H2** Parking. **H2** House rules. **H2** Before you leave. **H2** Local area. **H2** Emergency information. **H2** Your host (when `gg_host_contact` is set in WP).                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             | TBD Step D                                                                                                                     | **P4 Step B (2026-05-11):** Runner-up titles T2 Hoist, wet room: Whitstable guest info - Restwell Retreats; T3 Kent coast self-catering guest guide - Restwell Retreats. Runner-up metas in §4.1 `#### Step B - 2026-05-11 - https://restwellretreats.co.uk/guest-guide/`. **Rationale:** Title front-loads accessible, hoist, cottage, and Whitstable for the Step B brief while signalling a guest path, not a duplicate `/accessibility/` hub title. Meta lists utility topics from `page-guest-guide.php` section labels, adds quiet-stay USP, states property-level kit in theme-backed wording (not a claim every guide block lists equipment), and states the booking email plus OTP gate. **Technical:** `noindex, follow` for this template in `inc/seo.php`, so strings support navigational clarity and copy QA, not acquisition SERP goals. **Cannibal:** keep spec depth on `/accessibility/`; keep commercial story on `/the-property/`; guest guide stays post-booking ops plus local tips when ACF set (**Confirm in WP:** `gg_`* bodies). **Human:** Paste into WP Search and Social; do not edit `inc/seo.php` until confirmed. **P4 Step C (2026-05-11):** full ordered ladder §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/guest-guide/`                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            | Seed defaults; Step B chosen in plan; WP publish TBD; Steps D-G TBD                                                                                                                                                                                 |
| `https://restwellretreats.co.uk/` (`front-page.php`)                         | 2026-05-11     | 1    | accessible holidays whitstable                                | accessible self catering whitstable kent, wheelchair accessible holiday whitstable, whole property accessible holiday whitstable, accessible kent coast holiday bungalow, restwell retreats whitstable; Step B brief maps: accessible holiday cottage hoist wet room Whitstable Kent, ceiling track hoist holiday accommodation (not unverified tracking hoist), accessible self catering Kent coast, disabled access holiday cottage Whitstable | Accessible Whitstable cottage: hoist, wet room (Kent)            | Accessible self-catering Whitstable, Kent: bedroom ceiling track hoist, profiling bed, wet room. Quiet area, whole-property booking. Ask availability.            | **P4 Step C (2026-05-11), compact:** **H1** Accessible holidays in Whitstable, Kent (Confirm in WP `hero_heading` matches this line). **H2 (AEO order)** What Restwell is in Whitstable. Self-catering and hoist in Whitstable (bedroom ceiling track, profiling bed, wet room, link `/accessibility/`). Direct payments or NHS Continuing Healthcare (teaser, link `/resources/`). Whole property for a guest and carer (enquiry path). Equipment included (short list, link `/accessibility/`). **H2 (template bands)** Area and funding (H3 Whitstable and Kent coast, H3 Funding your stay). Two people, one break (H3 For the guest, H3 For the carer). Our Whitstable home. What guests say. Why choose Restwell (H3 Private and personal, H3 Support on your terms, H3 Local knowledge, H3 Honest and open). Specialist partners. Restwell vs a typical hotel stay. Need exact access details first. Common questions. Care on your terms (trust). Optional strip heading only if `hero_spec_heading` in WP carries verified kit text                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        | **P4 Step D (2026-05-25):** Featured snippet target query `accessible holidays whitstable` (40-55w paragraph in §4.1). **FAQ (5, homepage subset):** 1) What is Restwell in Whitstable? → definition + whole-property + optional CCS care. 2) Wheelchair accessible self-catering Whitstable with hoist? → yes, bedroom ceiling track, profiling bed, roll-in wet room, link `/accessibility/`. 3) Direct payments or CHC? → budgets/DP/CHC caveats, documentation, `/resources/`. 4) Book whole property for guest and carer? → enquiry-first, no obligation. 5) Equipment included? → hoist, bed, wet room, parking, spec link. **Source (2026-05-25):** Git-managed `inc/homepage-faq.php` → `restwell_get_homepage_faq_defaults()` → `restwell_get_faq_items( 'homepage' )` (accordion in `front-page.php` + `restwell_output_jsonld_homepage_faq()` in `inc/seo.php`, plain `answer_text` for JSON-LD). **Redundant WP fields (copy ignored):** Front page `home_faq_1_q`..`home_faq_7_a`; FAQ page slots 1-5 no longer drive homepage.                                                                                                                     | **Intent:** commercial entry plus booking path. **LSI (verified):** adapted bungalow, bedroom ceiling track hoist, profiling bed, wet room, step-free routes (Confirm in WP hero). **Cannibal:** `adapted bungalow whitstable` owner `/the-property/`; cottage spec hub `/accessibility/`; funding `/resources/`. **P4 Step B:** Chosen title omits trailing brand (homepage rule). Runner-up titles and metas plus rationale: §4.1 `#### Step B - 2026-05-10 - https://restwellretreats.co.uk/`. **Do not edit** `inc/seo.php` until human confirms. **P4 Step C (2026-05-11):** ordered outline §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/` (supersedes 2026-05-10 Step C note for structure). Prior Step C log kept for history in same §4.1 URL block                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            | TBD                                                                                                                                                                                                                                                 |
| `/blog/` (`index.php`)                                                       | 2026-05-11     | 2    | accessible holiday cottage hoist and wet room Whitstable Kent | tracking hoist holiday accommodation, accessible self catering Kent coast, disabled access holiday cottage Whitstable; Step A §2.6 Tier 1 hub phrase remains `accessible travel` (seed); confirm in GSC before swapping Primary cell                                                                                                                                                                                                             | Accessible hoist wet room Whitstable hub - Restwell Retreats     | Guides on accessible Kent self-catering, hoists, wet rooms, Whitstable days out, funding in posts. Browse, then check property pages. Restwell Retreats.          | **P4 Step C (2026-05-11), compact:** **H1** Accessible travel guides for the Kent coast and Whitstable area (Confirm in WP: posts page hero H1 matches; single H1 in interior-hero). **H2** What this hub covers (maps AEO: what the blog covers). **H2** Who these posts are for (maps AEO: who the stories are for; Confirm in WP tone). **H2** How this hub differs from home, property pages, and the guest guide (public posts index versus booking-first `/` or `/the-property/`; guest guide is OTP-gated utility, `noindex, follow` per `inc/seo.php`). **H2** CHC, direct payments, and funded breaks - where to read deeper (H3 `/resources/`; H3 `/direct-payment-holiday-accommodation/`, `/chc-respite-holiday-accommodation-uk/`, `/personal-budget-short-break-care-act/`, `/commissioner-checklist-accessible-respite-stay/`; hub stays signpost-only). **H2** Kent coast topics we post about (H3 beaches and walks; H3 trains; H3 eating out; H3 parking; Confirm in WP live posts match seed slugs in `inc/seo-content-seed.php`). **H2** Choose self-catering without kit surprises (link `/how-to-choose-accessible-self-catering-holiday/`; measurements on `/accessibility/` and `/the-property/`). **H2** Browse the guides (featured post, grid, category or tag or date archives; Confirm in WP Reading settings posts page).                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             | TBD Step D                                                                                                                     | **Intent:** content hub, editorial plus cluster discovery (not booking-first). **P4 Step B (2026-05-11):** Runner-up titles T2 Accessible Kent blog: hoist, Whitstable - Restwell Retreats; T3 Tracking hoist holidays Whitstable blog - Restwell Retreats. Runner-up metas M2 Kent accessible travel: hoist and wet room angles, Whitstable coast self-catering, disabled access posts. Browse the hub, then enquire. Restwell Retreats.; M3 Quiet Whitstable-area guides: hoist, wet room self-catering Kent coast, cluster posts for families and carers. Pick a read, link to property. Restwell Retreats. **Rationale:** T1 loads hoist, wet room, and Whitstable in the first segment so the Step B brief keyword sits early without mirroring the homepage title; M1 matches `index.php` hub role (guides, days out, funding in posts) and sends readers to property detail pages for kit facts (hoist, profiling bed, wet room live on `/accessibility/` and `/the-property/`, not invented in the blog seed). **Cannibal:** keep commercial cottage booking primaries on `/`, `/the-property/`, `/enquire/`; spec tables on `/accessibility/`; comparator on `/how-to-choose-accessible-self-catering-holiday/`. **Facts:** Confirm in WP: posts page title or excerpt overrides and Search and Social paste match chosen strings; do not edit `inc/seo.php` until human confirms. **Tracking hoist:** use on-page only if WP or access statement confirms tracking versus ceiling track hoist wording (see `/how-it-works/` §13.1 note). **P4 Step C (2026-05-11):** Full ordered ladder in §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/blog/`.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              | TBD                                                                                                                                                                                                                                                 |
| `/how-to-choose-accessible-self-catering-holiday/` (`page.php` seeded guide) | 2026-05-11     | 2    | accessible holiday cottage hoist and wet room Whitstable Kent | tracking hoist holiday accommodation (SERP phrase; publish **ceiling track hoist** in body unless WP confirms tracking), accessible self catering Kent coast, disabled access holiday cottage Whitstable                                                                                                                                                                                                                                         | Accessible hoist wet room Whitstable - Restwell Retreats         | Check hoist, doors, and wet room before booking accessible self-catering near Whitstable. Quiet stay. Read accessibility and property pages, then enquire.        | **P4 Step C (2026-05-11), compact:** **H1** How to choose an accessible self-catering holiday: checks before you pay a deposit (Confirm in WP: single visible H1). **H2** What we mean by accessible self-catering here (AEO: definition). **H2** Who should use this checklist (AEO: audience; carers, families, commissioners). **H2** What to verify before you pay a deposit (AEO: deposit checklist; OT questions). **H2** Hoist evidence and sling fit (AEO: hoist compatibility; **H3** ceiling track hoist wording unless WP confirms tracking; link /accessibility/, /the-property/). **H2** Door widths and circulation (Step A door widths). **H2** Wet rooms: roll-in versus walk-in claims (AEO wet room caveat). **H2** Red phrases in listings (AEO listing red flags). **H2** Access statements and panels (AEO commissioner reads; link /how-to-read-holiday-cottage-access-statement/, /commissioner-checklist-accessible-respite-stay/). **H2** Deposits and cooling-off caution (Step A deposit scams; brief only). **H2** Documents, DP, and CHC overlap (AEO funding cross; signpost /resources/). **H2** Check this list at Restwell (/the-property/, /accessibility/, /enquire/).                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           | TBD Step D                                                                                                                     | **Intent:** decision checklist, informational plus soft commercial (vet before deposit). **P4 Step B (2026-05-11):** Runner-up titles T2 Kent accessible self-catering hoist pick - Restwell Retreats; T3 How to choose hoist wet room Whitstable - Restwell Retreats. Runner-up metas M2 Accessible Kent coast self-catering: check hoist, doors, and wet room before a Whitstable-area booking. Quiet stay. See accessibility and property, then enquire.; M3 Disabled-access Whitstable: hoist, profiling bed, and wet room in one place. Quiet self-catering. Read accessibility and property pages, then enquire. **Rationale:** Chosen title stacks accessible, hoist, wet room, and Whitstable early without copying `/accessibility/` or `/the-property/` title shapes. Chosen meta opens with a verifier checklist (hoist, doors, wet room), names accessible self-catering near Whitstable, states the quiet-stay USP, and sends readers to accessibility and property pages before enquire. **Cannibal:** `/accessibility/` owns measurements and PDF; `/the-property/` owns commercial bungalow proof; this URL owns how-to-choose framing. **Facts:** Confirm in WP: hoist wording (ceiling track versus tracking) matches access statement and on-page copy. **Human:** Paste into WP Search and Social; do not edit `inc/seo.php` until confirmed. **P4 Step C (2026-05-11):** H1 and H2 ladder in **H1 / H2 summary** above; full ordered outline in §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/how-to-choose-accessible-self-catering-holiday/`.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     | TBD                                                                                                                                                                                                                                                 |
| `/direct-payment-holiday-accommodation/` (`page.php` seeded guide)           | 2026-05-11     | 1    | direct payment holiday accommodation                          | accessible holiday cottage hoist and wet room Whitstable Kent (Step B commercial bridge), tracking hoist holiday accommodation (SERP phrase; publish ceiling track hoist unless WP confirms tracking), accessible self catering Kent coast, disabled access holiday cottage Whitstable, direct payment for holiday (seed focus_keyphrase §2.6)                                                                                                   | Holiday direct payment: hoist, wet room Kent - Restwell Retreats | Holiday direct payment, Whitstable area: hoist, profiling bed, wet room in one self-catering place. Break costs versus care budgets, clearly explained. Enquire.  | **P4 Step C (2026-05-11), compact:** **H1** Direct payment holiday accommodation: care spend versus stay costs (general guide, not personal advice). **H2** Who this is for and what this page does not decide. **H2** Can direct payments pay for self-catering accommodation? **H2** Care, PA hours, and usual splits from the lodging bill. **H2** Personal health budgets versus local authority direct payments. **H2** Questions for your social worker or council. **H2** Personal assistants on a self-catering break. **H2** How to plan a funded break (steps, `/resources/`). **H2** Receipts and evidence (H3 PA, stay, travel splits on `/personal-budget-short-break-care-act/`). **H2** CHC overlap and next reads (H3 `/resources/`, `/chc-respite-holiday-accommodation-uk/`). **H2** Whitstable area at Restwell (Confirm in WP: kit wording; `/accessibility/`, `/the-property/`, `/enquire/`).                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  | TBD Step D                                                                                                                     | **P4 Step C (2026-05-11):** Full ordered ladder §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/direct-payment-holiday-accommodation/`. **P4 Step B (2026-05-11):** Runner-up titles T2 Kent direct payment holidays: hoist, wet room - Restwell Retreats; T3 Tracking hoist holiday: direct payment, Kent - Restwell Retreats. Runner-up metas (155c) Direct payment and Whitstable-area self-catering: hoist, profiling bed, wet room. General guide on holiday versus care spend, not personal advice. Enquire.; (155c) Using a direct payment for holidays: hoist, profiling bed, wet room near Whitstable. Quiet self-catering, general facts only. Not tailored advice. Enquire. **Rationale:** Chosen title leads with holiday plus direct payment so funding intent reads before hoist, wet room, and Kent; chosen meta carries one-place kit USP (Confirm in WP: matches access statement), break versus care framing, not personal advice, enquire CTA. **Step A note:** Primary cell keeps URL owner `direct payment holiday accommodation` (§2.6); Step B brief equipment phrase sits in Secondaries. **YMYL:** general information only. **Cannibal:** `/resources/` hub and `/personal-budget-short-break-care-act/` stay distinct; `/accessibility/` owns kit measurements. **Hoist:** T3 uses tracking hoist for SERP testing; on-site publish prefers ceiling track hoist unless WP confirms. **Human:** Paste into WP Search and Social; do not edit `inc/seo.php` until confirmed. Full T1 to T3 and M1 to M3 in §4.1 `#### Step B - 2026-05-11 - https://restwellretreats.co.uk/direct-payment-holiday-accommodation/`.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                | TBD                                                                                                                                                                                                                                                 |
| `/chc-respite-holiday-accommodation-uk/` (`page.php` seeded guide)           | 2026-05-11     | 1    | chc respite holiday accommodation                             | accessible holiday cottage hoist and wet room Whitstable Kent (Step B SERP bridge), tracking hoist holiday accommodation (SERP phrase; publish ceiling track hoist unless WP confirms tracking), accessible self catering Kent coast, disabled access holiday cottage Whitstable, chc respite holiday accommodation uk (§2.6)                                                                                                                    | Accessible CHC respite: Whitstable cottage - Restwell Retreats   | CHC respite UK breaks: framing for panels, not advice. Quiet Whitstable cottage: hoist, profiling bed, wet room. See accessibility, enquire. Restwell Retreats.   | **P4 Step C (2026-05-11), compact:** **H1** NHS Continuing Healthcare (CHC), respite, and self-catering accommodation: UK framing for panels (general guide, not advice). **H2** What CHC is in relation to respite or holiday stays (**H3** Why we do not state eligibility outcomes). **H2** Who is CHC respite holiday accommodation for? **H2** How do I plan CHC-linked respite or holiday accommodation? **H2** Personal budget versus CHC for a short break (**H3** Link `/personal-budget-short-break-care-act/`). **H2** Care versus lodging: who pays for what? **H2** Direct payments when readers confuse pots with CHC (**H3** Link `/direct-payment-holiday-accommodation/`). **H2** Paperwork or evidence commissioners and panels may expect (**H3** Link `/commissioner-checklist-accessible-respite-stay/`; Confirm in WP: forms Restwell supplies). **H2** Kent CHC contacts and appeals (signpost `/resources/` defaults; Confirm in WP). **H2** After funding checks: Whitstable-area stay (hoist, profiling bed, wet room; `/accessibility/`, `/the-property/`, `/enquire/`; ceiling track hoist unless WP confirms tracking). **H2** Related reading (`/resources/`, `/carers-respite-holiday-guide/`).                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      | TBD Step D                                                                                                                     | **P4 Step C (2026-05-11):** Full ordered ladder §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/chc-respite-holiday-accommodation-uk/`. **P4 Step B (2026-05-11):** Runner-up titles T2 CHC respite holidays: Kent hoist, wet room - Restwell Retreats; T3 Tracking hoist CHC respite: Whitstable UK - Restwell Retreats. Runner-up metas M2 Accessible self-catering Whitstable Kent: hoist, profiling bed, wet room. CHC versus holiday lodging, general facts. Read resources, enquire. Restwell Retreats.; M3 Whitstable-area cottage: hoist, profiling bed, wet room, quiet stay. CHC respite guide for families and panels, not outcomes. Enquire. Restwell Retreats. **Rationale:** T1 plus M1 pair CHC and NHS funding intent with the Step B equipment and place words without promising eligibility; M1 states panel framing, YMYL limiter, both USPs, split CTA to `/accessibility/` and enquire. **Cannibal:** `/resources/` hub, `/commissioner-checklist-accessible-respite-stay/`, `/personal-budget-short-break-care-act/` stay distinct primaries; kit tables on `/accessibility/`. **Facts:** Confirm in WP: on-page CHC copy matches `inc/seo-content-seed.php` CHC seed and does not over-claim outcomes; hoist wording matches access statement (ceiling track versus tracking). **Human:** Paste into WP Search and Social; do not edit `inc/seo.php` until human confirms. Full T1 to T3 and M1 to M3 in §4.1 `#### Step B - 2026-05-11 - https://restwellretreats.co.uk/chc-respite-holiday-accommodation-uk/`.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    | TBD                                                                                                                                                                                                                                                 |
| `/personal-budget-short-break-care-act/` (`page.php` seeded guide)           | 2026-05-11     | 1    | personal budget short break care act                          | accessible holiday cottage hoist and wet room Whitstable Kent (Step B SERP bridge), tracking hoist holiday accommodation (SERP phrase; publish ceiling track hoist unless WP confirms tracking), accessible self catering Kent coast, disabled access holiday cottage Whitstable, personal budget short break self catering (§2.6)                                                                                                               | Personal budget short break: Care Act - Restwell Retreats        | Care Act personal budgets: split PA, stay, and travel receipts. Whitstable-area self-catering with hoist, profiling bed, wet room. General guide only. Enquire.   | **P4 Step C (2026-05-11), compact:** **H1** Care Act personal budget short breaks: split PA hours, accommodation, and travel receipts. **H2** What this means under the Care Act (plain definition; defer to local authority wording). **H2** Who should use this guide (carers, families, commissioners). **H2** Plan the break before invoices stack (maps how to plan). **H2** How to split PA hours, travel, and self-catering lodging (maps receipt splits; H3 table when helpful). **H2** Can accommodation sit alone on a personal budget line? **H2** Documents and habits that keep post-trip audits clear (maps paperwork plus clean audit). **H2** Direct payment versus personal budget on one trip (link `/direct-payment-holiday-accommodation/`). **H2** Who signs off when several agencies are involved (link `/commissioner-checklist-accessible-respite-stay/`). **H2** How this sits beside CHC, direct payment holidays, and the Kent funding hub (`/resources/`, `/chc-respite-holiday-accommodation-uk/`). **H2** Whitstable-area self-catering at Restwell (hoist, profiling bed, wet room per seed; Confirm in WP; `/accessibility/`, `/the-property/`, `/enquire/`).                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      | TBD Step D                                                                                                                     | **P4 Step B (2026-05-11):** Runner-up titles T1 Care Act budget breaks: receipts, splits - Restwell Retreats; T3 Accessible Kent budget breaks: Care Act - Restwell Retreats. Runner-up metas M2 (160c) Personal budget short breaks: Care Act receipt splits for respite. Accessible Kent self-catering near Whitstable, hoist, profiling bed, wet room. See resources.; M3 (158c) Budget short breaks: PA, accommodation, and travel receipts (Care Act). Quiet Whitstable cottage, hoist, profiling bed, wet room. Read accessibility, enquire. **Rationale:** T2 mirrors Step A and seed `focus_keyphrase` in the opening segment; M1 matches seed receipt split theme (PA, stay, travel), states both USPs, YMYL limiter, single CTA. **Step A vs Step B brief:** Primary stays URL owner phrase; long hoist or wet room Whitstable Kent string sits in Secondaries. **Cannibal:** `/direct-payment-holiday-accommodation/` owns direct payment holiday; `/chc-respite-holiday-accommodation-uk/` owns CHC; `/resources/` hub; kit depth on `/accessibility/`. **Human:** Paste into WP Search and Social; do not edit `inc/seo.php` until human confirms. Full T1 to T3 and M1 to M3 in §4.1 `#### Step B - 2026-05-11 - https://restwellretreats.co.uk/personal-budget-short-break-care-act/`.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      | TBD                                                                                                                                                                                                                                                 |
| `/commissioner-checklist-accessible-respite-stay/` (`page.php` seeded guide) | 2026-05-11     | 1    | commissioner accessible respite stay                          | accessible holiday cottage hoist and wet room Whitstable Kent (Step B SERP bridge), tracking hoist holiday accommodation (SERP phrase; publish ceiling track hoist unless WP confirms tracking), accessible self catering Kent coast, disabled access holiday cottage Whitstable, commissioner checklist funded respite accommodation documentation (§2.6 hypothesis)                                                                            | Accessible commissioner checklist Kent - Restwell Retreats       | Commissioner checklist: hoist, profiling bed, wet room Whitstable. Kent coast self-catering. Read accessibility and property proof, enquire. Restwell Retreats.   | **P4 Step C (2026-05-11), compact:** **H1** Commissioner checklist for an accessible respite stay in Kent (Confirm in WP: one visible H1; echoes Step A `commissioner accessible respite stay`, checklist, Kent geo). **H2** What this commissioner checklist covers (AEO: what is commissioner accessible respite stay; audit aid, not tailored care advice). **H2** Who should use it (AEO: who is it for; panels, social care, families; roles vary by council). **H2** How to plan a documented short break (AEO: how do I plan; numbered steps in body, Confirm in WP dates). **H2** Document bundle for funded adapted stays (AEO plus §16 B2: paperwork for funded adapted respite; **H3** Property and access proofs, link `/accessibility/`, `/the-property/`; **H3** Panel forms or packs Restwell issues, Confirm in WP). **H2** Commissioners, social workers, and who signs what (plan §3.4 vocabulary; no invented local process). **H2** Where DP, CHC, and personal budgets overlap this stay (AEO overlap; signpost `/resources/`, `/direct-payment-holiday-accommodation/`, `/chc-respite-holiday-accommodation-uk/`, `/personal-budget-short-break-care-act/`; no duplicated funding primaries). **H2** How to read a cottage access statement before panel sign-off (link `/how-to-read-holiday-cottage-access-statement/`). **H2** Whitstable area context and kit wording at Restwell (Step A Kent or Whitstable; use **ceiling track hoist** unless WP confirms tracking; proof on linked pages only). **H2** Next steps and enquiries (link `/enquire/`).                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   | TBD Step D                                                                                                                     | **P4 Step B (2026-05-11):** Runner-up titles T2 Commissioner checklist Whitstable hoist - Restwell Retreats; T3 Accessible respite checklist: hoist, Kent - Restwell Retreats. Runner-up metas M2 (160c) Disabled-access Whitstable checklist: hoist, profiling bed, wet room. Kent self-catering. Proof on property and accessibility pages. Enquire. Restwell Retreats.; M3 (158c) Tracking hoist Kent checklist: accessible self-catering Whitstable area. Profiling bed, wet room. Read accessibility and property, enquire. Restwell Retreats. **Rationale:** T1 plus M1 pair commissioner audit intent with **Accessible** and **Kent** early, weave hoist, profiling bed, wet room, Whitstable, and Kent coast self-catering without mirroring CHC or DP title shapes; M1 routes proof to on-site pages (not invented certificates). **Cannibal:** CHC and DP funding URLs keep their primaries; kit measurements stay on `/accessibility/` and `/the-property/`. **Facts:** Seed `inc/seo-content-seed.php` still lists insurance certificates in the default `meta_description`; Confirm in WP: body and internal links match proof-page goal and hoist wording (ceiling track versus tracking). **Human:** Paste into WP Search and Social; do not edit `inc/seo.php` until human confirms. Full T1 to T3 and M1 to M3 in §4.1 `#### Step B - 2026-05-11 - https://restwellretreats.co.uk/commissioner-checklist-accessible-respite-stay/`. **P4 Step C (2026-05-11):** full ordered ladder §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/commissioner-checklist-accessible-respite-stay/`.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    | TBD                                                                                                                                                                                                                                                 |
| `/revitalise-alternatives-accessible-holidays/` (`page.php` seeded guide)    | 2026-05-11     | 1    | accessible holiday cottage hoist and wet room Whitstable Kent | revitalise alternatives accessible holidays, tracking hoist holiday accommodation (SERP phrase; publish ceiling track hoist unless WP confirms tracking), accessible self catering Kent coast, disabled access holiday cottage Whitstable; Step A Tier 1 cluster: `revitalise holiday centres closed`, `revitalise support fund grants` (§4 Run 2026-05-10)                                                                                      | Revitalise news: accessible Kent cottage - Restwell Retreats     | After Revitalise changes, compare routes. Quiet Whitstable-area cottage: hoist, profiling bed, wet room. Kent coast self-catering. Enquire. Restwell Retreats.    | **P4 Step C (2026-05-11), compact:** **H1** Revitalise holiday centre changes: UK facts, grants, and next steps (Confirm in WP: one visible H1; optional question-style H1 from seed if editor prefers). **H2** What happened to Revitalise holiday centres? **H2** Where can I get grants instead of Revitalise centre breaks? (**H3** Revitalise Support Fund and dates: only from charity source, Confirm in WP.) **H2** What are alternatives to Revitalise for wheelchair users in the UK? (**H3** Categories and signposts, calm tone, not a rankings pile-on; **H3** One Whitstable-area self-catering option: hoist, profiling bed, wet room, link `/accessibility/`, `/the-property/`, `/enquire/`; Confirm in WP kit list matches access statement.) **H2** Can I still use Revitalise for anything after centres closed? (**H3** Confirm current scope on revitalise.org.uk; no speculation.) **H2** How do I combine charity grants with direct payments for a holiday? (**H3** `/resources/` hub; `/direct-payment-holiday-accommodation/`; personal budget receipt guide `/personal-budget-short-break-care-act/`.)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   | TBD Step D                                                                                                                     | **Intent:** news plus competitor pivot, national Revitalise context with calm Restwell bridge (not pile-on). **P4 Step B (2026-05-11):** Runner-up titles T1 Accessible cottage hoist Whitstable Kent - Restwell Retreats; T3 Disabled access cottage Whitstable hoist - Restwell Retreats. Runner-up metas M1 Revitalise centre news, calm UK context. Whitstable-area self-catering: hoist, profiling bed, wet room. Read accessibility, then enquire. Restwell Retreats.; M3 Revitalise updates: calm Whitstable-area alternative, hoist, profiling bed, wet room. Self-catering Kent. Check accessibility, enquire. Restwell Retreats. **Rationale:** T2 plus M2 name Revitalise early for slug and entity queries, keep tone factual, and carry both USPs (equipment trio plus quiet Whitstable-area self-catering) with secondaries in the meta without duplicating `/the-property/` booking-first line. **Cannibal:** closure narrative and grant dates only on this URL; kit measurements on `/accessibility/`; adapted bungalow proof on `/the-property/`; generic how-to on `/how-to-choose-accessible-self-catering-holiday/`. **Facts:** Confirm in WP: charity dates, Support Fund copy, and on-page list match seed in `inc/seo-content-seed.php` (`restwell_get_blog_post_revitalise_html()`); do not edit `inc/seo.php` until human confirms. **P4 Step C (2026-05-11):** Full ordered ladder in §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/revitalise-alternatives-accessible-holidays/` (mirrors §2.3 AEO table `#### Run - 2026-05-10` for this URL plus Step A Tier 1 `revitalise holiday centres closed`, `revitalise support fund grants`, `revitalise alternatives accessible holidays`).                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      | TBD                                                                                                                                                                                                                                                 |
| `/carers-respite-holiday-guide/` (`page.php` seeded guide)                   | 2026-05-11     | 2    | accessible holiday cottage hoist and wet room Whitstable Kent | tracking hoist holiday accommodation (SERP phrase; publish ceiling track hoist unless WP confirms tracking), accessible self catering Kent coast, disabled access holiday cottage Whitstable, carer assessment respite rights (Step A seed; confirm in GSC before swapping Primary cell)                                                                                                                                                         | Accessible carers respite Whitstable guide - Restwell Retreats   | Carer assessment and respite rights in plain English. Whitstable-area self-catering with hoist, profiling bed, wet room. Open funding hub links, then enquire.    | **P4 Step C (2026-05-11), compact:** **H1** Carer assessment and respite rights: plain-English guide (UK, Kent signposts; general information, not tailored legal advice). **H2** Carer's assessment: who can ask and what it covers (AEO entitlement, seed **carer assessment respite rights**). **H2** Respite rights after an assessment (Care Act 2014, high level). **H2** Ask Kent social care for respite (Confirm in WP: KCC and Kent Connect to Support links). **H2** Funding for cover while you travel (**H3** `/resources/`; **H3** `/direct-payment-holiday-accommodation/`; **H3** `/chc-respite-holiday-accommodation-uk/`; **H3** `/personal-budget-short-break-care-act/`). **H2** Personal budgets and self-catering breaks (AEO; link PB guide). **H2** Planning carers' holidays and restful breaks (Step A: carers taking holidays respite planning, unpaid carer short break self catering). **H2** Documents and checks before you book (§2.3 checklist; light commissioner signpost `/commissioner-checklist-accessible-respite-stay/`). **H2** Whitstable-area stay after funding checks (bridge: hoist, profiling bed, wet room; proof on `/accessibility/`, `/the-property/`, `/enquire/`; Confirm in WP: ceiling track versus tracking hoist). **H2** Related links (`/who-its-for/`, `/faq/` snippet path per §16 B2).                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                | TBD Step D                                                                                                                     | **P4 Step C (2026-05-11):** Full ordered ladder §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/carers-respite-holiday-guide/`. **P4 Step B (2026-05-11):** Runner-up titles T2 Accessible hoist cottage carers Kent guide - Restwell Retreats; T3 Respite rights Whitstable: hoist, wet room - Restwell Retreats. Runner-up metas M1 Carer assessment and respite rights overview for UK bookers. Whitstable-area self-catering with hoist, profiling bed, wet room. Funding pages linked. Enquire.; M3 Accessible self-catering Kent coast for carers: hoist, profiling bed, wet room near Whitstable. Read rights basics, open funding hub links, enquire when ready. **Rationale:** T1 plus M2 open with **Accessible** and carers plus respite plus Whitstable for the guide URL without mirroring `/accessibility/` or `/the-property/` spec-first titles; meta states the assessment and rights job in plain words, carries both USPs (quiet Whitstable-area self-catering plus hoist, profiling bed, wet room together), and routes readers to on-page funding hub links before **Enquire**. **Intent:** informational YMYL plus soft commercial bridge. **Cannibal:** deep funding primaries stay on `/resources/`, `/direct-payment-holiday-accommodation/`, `/chc-respite-holiday-accommodation-uk/`; equipment proof stays on `/accessibility/` and `/the-property/`; Carer's Assessment FAQ snippets stay on `/faq/` with distinct depth. **Facts:** Confirm in WP: long-form body and internal links match `inc/seo-content-seed.php` carers seed (`restwell_get_blog_post_carers_respite_html()`); not legal advice. **Human:** Paste into WP Search and Social; **do not** edit `inc/seo.php` until human confirms.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        | TBD                                                                                                                                                                                                                                                 |
| `/what-to-pack-accessible-self-catering-uk/` (`page.php` seeded guide)       | 2026-05-11     | 2    | accessible holiday cottage hoist and wet room Whitstable Kent | tracking hoist holiday accommodation (SERP phrase; publish ceiling track hoist in on-page copy unless WP confirms tracking), accessible self catering Kent coast, disabled access holiday cottage Whitstable; seed `focus_keyphrase` `accessible holiday packing list uk` (Confirm in WP or Yoast)                                                                                                                                               | Accessible pack: hoist, wet room Whitstable - Restwell Retreats  | Pack for accessible Kent self-catering near Whitstable: hoist slings, meds, continence. Profiling bed, wet room on site. Read accessibility. Restwell Retreats.   | **P4 Step C (2026-05-11), compact:** **H1** What to pack for an accessible self-catering break in the UK (seed post title in `inc/seo-content-seed.php`; Confirm in WP one visible H1). **H2** What an accessible holiday packing list is here (§2.3 definition question, run 2026-05-10). **H2** Who should use this list (§2.3 audience question). **H2** Why self-catering packing trips fail without clinical buffers (§2.3 failure pattern plus seed opener). **H2** Supplied at the property versus packed by you (seed table; generic adapted-stay wording until Confirm in WP Restwell columns). **H2** Continence care in a self-catering cottage (§2.6 AEO plus Step A continence supplies row). **H2** Hoist accessories when the room has a track hoist (§2.6 AEO; Confirm in WP ceiling track versus tracking on `/accessibility/`). **H2** Medication and feeds for a UK self-catering week (§2.6 AEO; fridge or power Confirm in WP). **H2** Kitchen aids disabled guests still pack (§2.6 AEO). **H2** What to email the owner before you pack (§2.6 AEO; link `/how-to-choose-accessible-self-catering-holiday/`). **H2** How to plan packing before you travel (§2.3 planning steps question; seed ordered list). **H2** Documents to pack for commissioners or carers (§2.3 documents question; MAR charts seed FAQ). **H2** Where DP or CHC checks overlap packing proof (§2.3 overlap question; signpost `/resources/` only). **H2** Common packing mistakes (seed bullets). **H2** Frequently asked questions (seed **H3** own shower chair; spare sling loops; second fridge for meds; paperwork carers need; where to read house specifics). **H2** Related guides and enquiries (beaches, mobility hire, insurance; `/enquire/` Confirm in WP).                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            | TBD Step D                                                                                                                     | **P4 Step C (2026-05-11):** Full ordered ladder §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/what-to-pack-accessible-self-catering-uk/`. **Intent:** practical checklist, reduce travel anxiety, hoist-adjacent categories aligned to seed (meds, continence, hoist extras, kitchen aids, owner checks per `inc/seo-content-seed.php`). **P4 Step B (2026-05-11):** Runner-up titles T2 Self-catering Kent pack: hoist, Whitstable - Restwell Retreats; T3 Disabled-access pack list Whitstable Kent - Restwell Retreats. Runner-up metas M2 Whitstable packing: hoist slings, meds, continence. Kent accessible self-catering with hoist, profiling bed, wet room. Read accessibility. Restwell Retreats.; M3 Kent accessible packing: hoist slings, meds, continence. Self-catering Whitstable area. Hoist, profiling bed, wet room. Confirm with owner. Restwell Retreats. Full T1 to T3 and M1 to M3 in §4.1 `#### Step B - 2026-05-11 - https://restwellretreats.co.uk/what-to-pack-accessible-self-catering-uk/`. **Rationale:** T1 loads accessible, hoist, wet room, and Whitstable before the brand without mirroring `/accessibility/` hub lines; M1 lists hoist-adjacent travel categories, states profiling bed and wet room as the one-place USP, sends spec readers to `/accessibility/`. **Cannibal:** measurements and PDF stay on `/accessibility/` and `/the-property/`; how-to vetting stays `/how-to-choose-accessible-self-catering-holiday/`; travel insurance stays `/travel-insurance-disability-uk-self-catering/`. **Facts:** Confirm in WP: live body matches `restwell_get_blog_post_pack_accessible_self_catering_html()`; do not invent kit beyond seed categories. **Human:** Paste into WP Search and Social; do not edit `inc/seo.php` until human confirms                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            | TBD                                                                                                                                                                                                                                                 |
| `/hire-mobility-scooter-equipment-uk-holiday/` (`page.php` seeded guide)     | 2026-05-11     | 2    | hire mobility equipment UK holiday                            | tracking hoist holiday accommodation (SERP phrase, publish ceiling track hoist on property URLs unless WP confirms), accessible self catering Kent coast, disabled access holiday cottage Whitstable, accessible holiday cottage hoist wet room Whitstable Kent (bridge only, owner `/accessibility/`), mobility scooter hire UK holiday (slug echo), hire mobility equipment UK holiday Kent (§2.6 cluster)                                     | Mobility hire UK holiday: checklist - Restwell Retreats          | Mobility hire UK holidays: measurements, insurance, handover photos. Whitstable self-catering: hoist, profiling bed, wet room. See accessibility, enquire.        | **P4 Step C (2026-05-11), compact:** **H1** Hire mobility equipment for a UK holiday: measurements, insurance, and handover photos (echoes seed `meta_title` in `inc/seo-content-seed.php` plus editor page goal; Confirm in WP: one visible H1, no second H1 in hero block). **H2** What mobility equipment hire on holiday is (§2.3 definition question; matches seed body H2 What is mobility equipment hire on holiday?). **H2** Who this hire guide is for (§2.3 audience question; carers, families, commissioners, OT planners). **H2** Why hire decisions trip people up (seed body H2; coastal humidity, narrow turning circles, charging sockets on the wrong wall). **H2** Measurements to confirm before you book (page goal plus §2.6 AEO What measurements do I need before hiring a mobility scooter for a cottage?; **H3** Door widths and thresholds; **H3** Tyre width and folded length; **H3** Turning circles and ramp gradient; link `/how-to-choose-accessible-self-catering-holiday/` for property checklist; spec numbers stay on `/accessibility/`). **H2** How to match kit to property geometry (seed body H2; **H3** Scooters and powerchairs; **H3** Bathroom aids; **H3** Beds and mattresses; hoist type stays on `/accessibility/` and `/the-property/`, do not assert ceiling track or tracking here). **H2** Insurance and excess when hire kit fails (page goal plus §2.6 AEO Does holiday insurance cover hired mobility scooters in the UK?; damage waiver versus traveller policy, who pays first pound; link `/travel-insurance-disability-uk-self-catering/`; no product picks). **H2** Delivery slots and how far ahead to book (§2.6 AEO How far in advance should I book delivery of a profiling bed to a holiday let?; seed Practical booking checklist plus peak-season warning). **H2** Hire versus bring from home (seed comparison table; airline or van damage risk, setup time, insurance, peak season stock). **H2** Handover photos and condition sheets (page goal plus §2.6 AEO Should I photograph mobility equipment at handover for a holiday hire?; refuse sign-off if damaged, photograph scrapes, demand replacement before transfer attempts). **H2** What to do if hired equipment will not fit through the doorway (§2.6 AEO What happens if hired equipment does not fit through the cottage doorway?; bridge to `/how-to-choose-accessible-self-catering-holiday/`). **H2** Practical booking checklist (seed body H2; serial photos of actual units, evening breakdown helpline, brake test on delivery; link `/what-to-pack-accessible-self-catering-uk/`). **H2** Common hire mistakes (seed body H2; late August booking, battery cooling after beach humidity, informal deposits versus VAT receipts, compatibility checks with rental shower chairs and grab rails). **H2** Documents to share with commissioners or care teams (§2.3 documents question; VAT receipts, hire contract, breakdown PDF, condition photos; signpost `/commissioner-checklist-accessible-respite-stay/`). **H2** Where hire planning overlaps with direct payments or CHC (§2.3 overlap question; short signpost to `/resources/`, `/direct-payment-holiday-accommodation/`, `/chc-respite-holiday-accommodation-uk/`; no eligibility promises). **H2** Frequently asked questions (seed; **H3** Does NHS wheelchair services cover Kent holidays?; **H3** Who fixes a flat tyre on hire?; **H3** Can I hire a hoist? (mobile gantry versus property-fixed ceiling track, Confirm in WP on `/accessibility/`); **H3** Should I tell insurers?; **H3** What if equipment arrives damaged?). **H2** Related guides and enquiries (seed Closing; link `/blog/`, `/what-to-pack-accessible-self-catering-uk/`, `/travel-insurance-disability-uk-self-catering/`, `/accessibility/`, `/the-property/`, `/enquire/`). | TBD Step D                                                                                                                     | **Intent:** informational hire checklist plus soft stay bridge. **P4 Step B (2026-05-11):** Runner-up titles T2 Mobility equipment hire: UK holidays - Restwell Retreats; T3 Mobility hire holidays UK: Kent tips - Restwell Retreats. Runner-up metas M2 UK holiday mobility hire: measurements, insurance, handover photos. Whitstable-area self-catering with hoist, profiling bed, wet room. Enquire online.; M3 Mobility equipment hire UK: sizes, insurance, handover photos. Kent coast accessible self-catering Whitstable: hoist, wet room, profiling bed. Enquire. **Rationale:** Chosen pair keeps hire intent in the title opening, matches editor goals in the meta, carries both USPs on the stay line, routes proof to `/accessibility/` before enquire. **Step A vs brief:** pasted foundation primary **accessible holiday cottage hoist and wet room Whitstable Kent** is **not** the query owner for this URL (see §3 row for hire slug); it stays in Secondaries for pack alignment only. **Cannibal:** kit tables and hoist type wording on `/accessibility/` and `/the-property/`; supplier evidence on-page only when WP backs it. **Human:** Paste into WP Search and Social; do not edit `inc/seo.php` until human confirms. Full T1 to T3 and M1 to M3 in §4.1 `#### Step B - 2026-05-11 - https://restwellretreats.co.uk/hire-mobility-scooter-equipment-uk-holiday/`. **P4 Step C (2026-05-11):** Full ordered ladder §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/hire-mobility-scooter-equipment-uk-holiday/`.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            | TBD                                                                                                                                                                                                                                                 |
| `/holiday-backup-plan-care-worker-change/` (`page.php` seeded guide)         | 2026-05-11     | 3    | holiday backup plan care worker                               | accessible holiday cottage hoist and wet room Whitstable Kent (Step B SERP bridge), tracking hoist holiday accommodation (SERP phrase; publish ceiling track hoist unless WP confirms tracking), accessible self catering Kent coast, disabled access holiday cottage Whitstable, holiday backup plan care worker change (slug), respite holiday backup plan care worker roster change (§3 hypothesis)                                           | Holiday backup plan care worker Kent - Restwell Retreats         | Holiday backup when carers change: cards, agency tiers, escalation. Kent self-catering Whitstable: hoist, profiling bed, wet room. Read accessibility, enquire.   | **P4 Step C (2026-05-11), compact:** **H1** Holiday backup plan when care workers change or cancel on a break (Kent context; echo **holiday backup plan care worker**; Confirm in WP: one visible H1). **H2** What a holiday backup plan is here (AEO what-is). **H2** How to build your backup plan before you travel (AEO how-to-plan; **H3** rotas and named contacts; **H3** agency tiers and budgets for emergency cover; **H3** escalation when cover fails). **H2** Who should own the plan (AEO who-for; families, carers, commissioners). **H2** Documents and checklist items before change (AEO documents; PDF angle Confirm in WP). **H2** Direct payments, CHC, and emergency cover overlap (AEO overlap; `/resources/` signposts only). **H2** Mid-stay care worker or roster change (slug **change** intent; light `/carers-respite-holiday-guide/`). **H2** Local travel backups near Whitstable (parking, train; `/accessible-parking-whitstable-tankerton/`, `/accessible-train-travel-whitstable-kent/`). **H2** Check the property before you book (hoist, profiling bed, wet room; `/accessibility/`, `/the-property/`, `/enquire/`; ceiling track hoist unless WP confirms tracking). **H2** Related guides.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  | TBD Step D                                                                                                                     | **Intent:** contingency planning when carers change mid-trip, plus soft commercial bridge. **P4 Step B (2026-05-11):** Runner-up titles T2 Accessible Whitstable backup: carer change - Restwell Retreats; T3 Care worker change: holiday backup plan Kent - Restwell Retreats. Runner-up metas M2 When carers cancel: budgets, agency tiers, escalation. Accessible Kent self-catering Whitstable: hoist, profiling bed, wet room. Read accessibility, enquire. (157c); M3 Holiday backup if your carer changes: agency tiers, escalation order. Accessible Kent self-catering Whitstable: hoist, profiling bed, wet room. Enquire. (152c). **Rationale:** see §4.1 `#### Step B - 2026-05-11 - https://restwellretreats.co.uk/holiday-backup-plan-care-worker-change/`. **Cannibal:** deeper carer rights and respite framing on `/carers-respite-holiday-guide/`; hoist type and measurements on `/accessibility/` and `/the-property/`. **Facts:** contingency cards, agency tiers, budgets, escalation echo `inc/seo-content-seed.php` `meta_description` for this slug (Confirm in WP: live body matches seed HTML). **Human:** Paste into WP Search and Social; do not edit `inc/seo.php` until human confirms. **P4 Step C (2026-05-11):** Full ordered ladder §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/holiday-backup-plan-care-worker-change/`.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           | TBD                                                                                                                                                                                                                                                 |
| `/accessible-train-travel-whitstable-kent/` (`page.php` seeded guide)        | 2026-05-11     | 2    | accessible train travel whitstable                            | tracking hoist holiday accommodation (SERP phrase; publish ceiling track hoist unless WP confirms tracking), accessible self catering Kent coast, disabled access holiday cottage Whitstable, accessible holiday cottage hoist wet room Whitstable Kent (Step B commercial bridge; kit depth on `/accessibility/`), accessible train travel whitstable kent (slug query)                                                                         | Accessible train travel Whitstable - Restwell Retreats           | Passenger Assist, gaps, and connections for Whitstable by rail, Kent. Quiet self-catering: hoist, profiling bed, wet room. Read accessibility, enquire.           | **P4 Step C (2026-05-11), compact:** **H1** Accessible train travel to Whitstable, Kent (Confirm in WP: single visible H1). **H2** What counts as accessible train travel here? **H2** How to plan your journey (**H3** Passenger Assist: book and confirm with your operator; **H3** connections, changes, and platform gaps; **H3** parking or taxi backup, link `/accessible-parking-whitstable-tankerton/`). **H2** Who this guide is for **H2** Documents and checks before you travel **H2** Funding overlap for a Kent break (light signpost `/resources/`, `/direct-payment-holiday-accommodation/`, `/chc-respite-holiday-accommodation-uk/`). **H2** Whitstable station and onward travel (Confirm in WP: match National Rail or operator pages). **H2** Staying near Whitstable after the train (bridge: hoist, profiling bed, wet room; proof on `/accessibility/` and `/the-property/`; ceiling track hoist wording unless WP confirms tracking). **H2** Related reading                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               | TBD Step D                                                                                                                     | **Intent:** informational transport planning (Passenger Assist, connection realism) plus soft commercial bridge to Restwell kit. **P4 Step B (2026-05-11):** Runner-up titles T2 Accessible train Whitstable: assist tips - Restwell Retreats; T3 Accessible rail Whitstable: connections - Restwell Retreats. Runner-up metas M2 Passenger Assist, realistic rail connections to Whitstable. Accessible self-catering Kent coast: hoist, profiling bed, wet room. See accessibility, enquire.; M3 Plan rail to Whitstable: Passenger Assist, gaps, backups. Whitstable-area self-catering with hoist, profiling bed, wet room. Read accessibility, enquire. Full T1 to T3 and M1 to M3 in §4.1 `#### Step B - 2026-05-11 - https://restwellretreats.co.uk/accessible-train-travel-whitstable-kent/`. **Rationale:** Chosen title matches seed `focus_keyphrase` stem (`inc/seo-content-seed.php` `accessible-train-travel-whitstable-kent`). Chosen meta keeps seed topics (Passenger Assist, gaps, connections, Kent) and adds both USPs with proof deferred to `/accessibility/`. **Cannibal:** parking and drop-off depth on `/accessible-parking-whitstable-tankerton/`; kit tables on `/accessibility/` and `/the-property/`. **Facts:** Confirm in WP: live body matches operator-dependent rail facts; seed description also names pairing rail with local parking or taxi backup. **Human:** Paste into WP Search and Social; do not edit `inc/seo.php` until human confirms. **P4 Step C (2026-05-11):** Full ordered ladder in §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/accessible-train-travel-whitstable-kent/`.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       | TBD                                                                                                                                                                                                                                                 |
| `/travel-insurance-disability-uk-self-catering/` (`page.php` seeded guide)   | 2026-05-11     | 2    | travel insurance disability uk self catering                  | accessible holiday cottage hoist and wet room Whitstable Kent (Step B bridge), tracking hoist holiday accommodation (SERP phrase; publish ceiling track hoist unless WP confirms tracking), accessible self catering Kent coast, disabled access holiday cottage Whitstable                                                                                                                                                                      | Travel insurance disability UK self-catering - Restwell Retreats | Travel insurance, disability, UK self-catering: broker kit, cancellation. Quiet Whitstable hoist, profiling bed, wet room. Not advice. Restwell Retreats.         | **P4 Step C (2026-05-11), compact:** **H1** Travel insurance, disability, and UK self-catering (Confirm in WP: one visible H1). **H2** What this topic covers on a UK break (AEO what-is). **H2** Who should read this (AEO who-for). **H2** How to plan cover before you pay (AEO how-to-plan). **H2** Evidence and documents to gather (**H3** Valuations, **H3** Photos, **H3** Medication list; AEO documents). **H2** Where direct payments or CHC meet policy wording (AEO overlap; `/resources/` signposts only). **H2** Why UK self-catering claims fail. **H2** How policies differ on mobility kit and hire (broker table; `/hire-mobility-scooter-equipment-uk-holiday/`). **H2** Practical steps before you travel. **H2** Mistakes that void cover. **H2** Frequently asked questions (seed H3s). **H2** Whitstable-area stay after checks (bridge; `/accessibility/`, `/the-property/`, `/enquire/`; Confirm in WP kit lines). **H2** Related guides (seed Closing; `/blog/`).                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        | TBD Step D                                                                                                                     | **P4 Step C (2026-05-11):** Full ordered ladder §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/travel-insurance-disability-uk-self-catering/`. **P4 Step B (2026-05-11):** Runner-up titles T2 Disability travel insurance broker questions UK - Restwell Retreats; T3 UK accessible self-catering travel insurance - Restwell Retreats. Runner-up metas M2 Travel insurance disability UK self-catering: ask brokers about kit limits and cancellation. Accessible Kent coast stays. No product picks. Restwell Retreats.; M3 Hoist or wet room Kent trip? Travel insurance UK self-catering, disability: broker questions, no product picks. Quiet Whitstable-area breaks. Restwell Retreats. **Rationale:** Chosen pair keeps the URL owner phrase early in the title, mirrors seed themes (`inc/seo-content-seed.php` mobility equipment limits, cancellation, broker questions), carries hoist, profiling bed, and wet room in the meta without naming products, and uses YMYL-safe lines (Not advice, no product picks in alternates). **Intent:** insurance YMYL informational, broker checklist. **Cannibal:** `/hire-mobility-scooter-equipment-uk-holiday/` owns hire handover and equipment hire insurance prompts; `/accessibility/` and `/the-property/` own hoist and wet room proof; this URL owns policy questions only. **Facts:** Confirm in WP: body matches travel insurance seed HTML and does not name products unless editor adds them. **Human:** Paste into WP Search and Social; **do not** edit `inc/seo.php` until human confirms. Full T1 to T3 and M1 to M3 in §4.1 `#### Step B - 2026-05-11 - https://restwellretreats.co.uk/travel-insurance-disability-uk-self-catering/`.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              | TBD                                                                                                                                                                                                                                                 |
| `/how-to-read-holiday-cottage-access-statement/` (`page.php` seeded guide)   | 2026-05-11     | 2    | holiday cottage access statement                              | accessible holiday cottage hoist and wet room Whitstable Kent (Step B brief), tracking hoist holiday accommodation (SERP phrase; publish ceiling track hoist unless WP confirms tracking), accessible self catering Kent coast, disabled access holiday cottage Whitstable                                                                                                                                                                       | How to read access statements: Whitstable - Restwell Retreats    | How to read access statements: hoist and wet room numbers to insist on. Whitstable: hoist, profiling bed, wet room. See accessibility. Restwell Retreats.         | **P4 Step C (2026-05-11), compact:** **H1** How to read a holiday cottage access statement before you book (Confirm in WP: single visible H1). **H2** What a holiday cottage access statement is (AEO definition; UK self-catering). **H2** How to read one in order when time is tight (AEO plan; numbered skim). **H2** Who uses these statements (AEO audience; OTs, families, carers, commissioners). **H2** Measurements and kit lines to insist on (**H3** hoist wording and sling fit; **H3** wet room, doors, circulation; **H3** parking or arrival if the PDF raises it; numbers on `/accessibility/` only, **Confirm in WP**). **H2** PDFs, downloads, and version dates (Tier 2 pdf row; **Confirm in WP** file offer). **H2** Checklist for panels and paperwork (AEO documents; Tier 2 checklist; optional `/commissioner-checklist-accessible-respite-stay/`). **H2** Where funding routes meet the statement (AEO DP or CHC overlap; signpost `/resources/`). **H2** Kent or Whitstable on generic PDFs (geo secondaries when body supports). **H2** Red phrases and email checks before a deposit (link `/how-to-choose-accessible-self-catering-holiday/`). **H2** Where to read Restwell measurements next (`/accessibility/`, `/the-property/`, `/enquire/`).                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   | TBD Step D                                                                                                                     | **Intent:** informational literacy for OTs, families, commissioners (decode PDFs and listings). **P4 Step B (2026-05-11):** Runner-up titles T2 Read access statements: hoist, wet room - Restwell Retreats; T3 Tracking hoist wording: access statements - Restwell Retreats. Runner-up metas M2 Tracking hoist wording in access statements: OT checks. Whitstable self-catering with hoist, profiling bed, wet room. Read accessibility, enquire. Restwell Retreats.; M3 Cottage access statement tips: hoist proof, wet room lines. Whitstable self-catering: hoist, profiling bed, wet room. See accessibility, enquire. Restwell Retreats. **Rationale:** Chosen title leads with how-to plus Whitstable for local scans without duplicating `/accessibility/` hub lines; chosen meta states the measurement job, both USPs (Confirm in WP: on-page kit matches access statement), and sends proof to `/accessibility/` before any booking ask. **Cannibal:** spec tables and PDF depth on `/accessibility/`; commercial bungalow proof on `/the-property/`; this URL owns process and red-flag literacy per §16 B2. **Facts:** Seed `focus_keyphrase` and default copy in `inc/seo-content-seed.php` (`how-to-read-holiday-cottage-access-statement`); **Confirm in WP:** pasted Search and Social match live body and internal links. **P4 Step C (2026-05-11):** Full ordered ladder §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/how-to-read-holiday-cottage-access-statement/`. **Human:** Paste into WP Search and Social; **do not** edit `inc/seo.php` until human confirms. Full T1 to T3 and M1 to M3 in §4.1 `#### Step B - 2026-05-11 - https://restwellretreats.co.uk/how-to-read-holiday-cottage-access-statement/`.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                | TBD                                                                                                                                                                                                                                                 |
| `/fatigue-friendly-whitstable-coastal-day/` (`page.php` seeded guide)        | 2026-05-11     | 3    | fatigue friendly whitstable coastal day                       | accessible holiday cottage hoist and wet room Whitstable Kent (Step B SERP pack), tracking hoist holiday accommodation (SERP phrase; publish ceiling track hoist on property URLs unless WP confirms tracking), accessible self catering Kent coast, disabled access holiday cottage Whitstable                                                                                                                                                  | Accessible Whitstable: hoist, wet room - Restwell Retreats       | Low-energy Whitstable Kent coast: pacing, sensory load, wind, glare. Accessible self-catering with hoist, profiling bed, wet room. Read accessibility, enquire.   | **P4 Step C (2026-05-11), compact:** **H1** Fatigue-friendly Whitstable coastal day: low-energy Kent coast pacing (Confirm in WP: one visible H1). **H2** What counts as a fatigue-friendly Whitstable coastal day? **H2** Who this pacing pattern is for **H2** How to plan the day in timed blocks **H2** Why wind, glare, and coast surfaces tax energy **H2** Sensory tweaks (**H3** Glare; **H3** Noise; **H3** Pain supports). **H2** Check these links before you go (quieter timing, beach notes, packing, backup care). **H2** What papers or panels to line up (light checklist; link `/resources/` only). **H2** Where direct payments or CHC sit beside a day out (signpost; general information, not advice). **H2** Common mistakes **H2** Frequently asked questions (**H3** Wind and powerchairs; **H3** Scooters on paths; **H3** Naps after lunch; **H3** Teenagers and pace; **H3** Low-energy stays at Restwell). **H2** Next reads (`/blog/`).                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 | TBD Step D                                                                                                                     | **P4 Step C (2026-05-11):** Full ordered ladder §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/fatigue-friendly-whitstable-coastal-day/`. **P4 Step B (2026-05-11):** Runner-up titles T2 Fatigue Whitstable day: hoist, wet room - Restwell Retreats; T3 Low-energy Whitstable: hoist & wet room - Restwell Retreats. Runner-up metas M1 (140c) Whitstable coast day for fatigue: pacing and sensory load. Quiet self-catering: hoist, profiling bed, wet room. Read accessibility, enquire.; M3 (148c) Pacing a Whitstable-area coast day with sensory load in mind. Accessible self-catering: hoist, profiling bed, wet room. Read accessibility, enquire. Full T1 to T3 and M1 to M3 in §4.1 `#### Step B - 2026-05-11 - https://restwellretreats.co.uk/fatigue-friendly-whitstable-coastal-day/`. **Rationale (short):** Title **1** puts **Accessible**, **Whitstable**, **hoist**, and **wet room** in the opening scan line for the Step B equipment phrase while staying distinct from `/the-property/` spec titles; slug plus body still carry fatigue-friendly coastal day intent. Meta **chosen** mirrors seed `meta_description` and `restwell_get_blog_post_fatigue_friendly_coastal_day_html()` themes (pacing, sensory load, wind, glare), names **accessible self catering Kent coast**, both USPs (quiet Kent framing plus hoist, profiling bed, wet room together), defers proof to **Read accessibility**, then **enquire**. **Step A vs brief:** Primary cell keeps seed `focus_keyphrase` owner; long commercial primary sits in Secondaries until GSC supports a swap. **Cannibal:** beaches and prom realism on `/accessible-beaches-coastal-walks-kent/`; parking on `/accessible-parking-whitstable-tankerton/`; quieter timing on `/quieter-times-whitstable-low-crowd-access/`; kit tables on `/accessibility/` and `/the-property/`. **Facts:** Day-out copy does not claim coastal paths include a hoist; stay bridge refers to the Restwell base only (**Confirm in WP:** Search and Social paste matches live page). **Human:** Paste chosen title and meta into WP Search and Social; **do not** edit `inc/seo.php` until human confirms.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                | TBD                                                                                                                                                                                                                                                 |
| `/quieter-times-whitstable-low-crowd-access/` (`page.php` seeded guide)      | 2026-05-11     | 2    | quieter times whitstable visit                                | accessible holiday cottage hoist and wet room Whitstable Kent (Step B commercial bridge; kit depth on `/accessibility/`), tracking hoist holiday accommodation (SERP phrase; publish ceiling track hoist unless WP confirms tracking), accessible self catering Kent coast, disabled access holiday cottage Whitstable, quieter times whitstable low crowd access (slug query)                                                                   | Quieter times Whitstable visit: Kent - Restwell Retreats         | Quieter times to visit Whitstable, Kent: weekday windows, festival caveats. Quiet self-catering: hoist, profiling bed, wet room. See accessibility, enquire.      | **P4 Step C (2026-05-11), compact:** **H1** Quieter times to visit Whitstable, Kent: when crowds often ease (Confirm in WP: one visible H1). **H2** What "quieter times" means here, not a silence promise (AEO: what is quieter times whitstable visit). **H2** How to plan around crowd peaks (AEO: how do I plan quieter times whitstable visit; weekday windows, school breaks; **quieter times whitstable visit kent**). **H2** When Whitstable is usually calmer if you avoid crowds (AEO, §2.6 ~4873). **H2** Festivals and regatta weekends that spike crowds (AEO, §2.6 ~4874; oyster caveats per seed; Confirm in WP: yearly event calendars). **H2** Parking turnover and low-energy arrivals (AEO ~4875; Step A parking turnover; link `/accessible-parking-whitstable-tankerton/`). **H2** Tankerton versus Whitstable harbour on busy days (AEO ~4876). **H2** Low-crowd mornings, tides, and sensory load (AEO ~4877; tide times versus crowd times Step A; link `/fatigue-friendly-whitstable-coastal-day/` for hour pacing). **H2** Who this guide helps (AEO: who is quieter times whitstable visit for). **H2** Documents and funding overlap on the same trip (AEO ~3563-3564; signpost `/resources/` only). **H2** Next reads: area guide, eating out, trains (**H3** `/whitstable-area-guide/`, `/accessible-eating-out-whitstable-kent/`, `/accessible-train-travel-whitstable-kent/`). **H2** Whitstable-area stay after timing checks (hoist, profiling bed, wet room bridge; `/accessibility/`, `/the-property/`, `/enquire/`; ceiling track hoist on publish unless WP confirms tracking). **H2** Related guides.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        | TBD Step D                                                                                                                     | **P4 Step B (2026-05-11):** Runner-up titles T2 Quieter Whitstable access timing - Restwell Retreats (52c); T3 Low-crowd Whitstable: accessible visit - Restwell Retreats (58c). Runner-up metas M2 Whitstable visit timing for low crowds: midweek slots, festival pitfalls, parking turnover. Quiet Kent self-catering: hoist, wet room, profiling bed. Enquire. (159c); M3 Plan a quieter Whitstable visit: weekdays, festival caveats, pavement realism. Accessible self-catering Kent: hoist, wet room. Read accessibility, enquire. (155c). **Rationale:** T1 plus M1 keep the Step A seed `focus_keyphrase` `quieter times whitstable visit` in the first ~31 characters of the title and at the start of the meta, add Kent for geo, mirror seed body topics in `restwell_get_blog_post_quieter_whitstable_visit_html()` (weekday windows, festival caveats, parking turnover, Tankerton slopes) without copying long-form lines, carry both USPs as a stay bridge, defer kit measurements to `/accessibility/`, split the CTA (See accessibility, enquire). **Step A vs Step B brief:** pasted foundation primary **accessible holiday cottage hoist and wet room Whitstable Kent** is **not** the SERP owner for this timing or sensory URL (Step A run **2026-05-10** seed `focus_keyphrase` `quieter times whitstable visit`); it sits in Secondaries for cluster bridge alignment only (same pattern as `/accessible-eating-out-whitstable-kent/`, `/accessible-parking-whitstable-tankerton/`, `/changing-places-toilets-kent-coast-days-out/`, `/accessible-train-travel-whitstable-kent/`). **Intent:** informational timing and sensory planning plus soft commercial bridge. **Banned phrase:** not used. **Cannibal:** town hub on `/whitstable-area-guide/`; parking and kerb mechanics on `/accessible-parking-whitstable-tankerton/`; beach surfaces on `/accessible-beaches-coastal-walks-kent/`; dining route notes on `/accessible-eating-out-whitstable-kent/`; fatigue pacing on `/fatigue-friendly-whitstable-coastal-day/`; kit measurements on `/accessibility/` and `/the-property/`. **Facts:** Page goal forbids guaranteeing quiet (body TL;DR explicitly says oyster festival and regatta weekends break midweek calm); chosen meta uses **Quieter times** and **caveats**, not absolute claims. **Confirm in WP:** body matches `restwell_get_blog_post_quieter_whitstable_visit_html()` in `inc/seo-content-seed-blog-cluster-b.php`; seasonal table caption is **Rough guide only - verify event calendars yearly**; do not assert venue hours or hoist coverage in town beyond seed. **Hoist wording:** secondary lists `tracking hoist holiday accommodation`; metas use **hoist** without asserting tracking versus ceiling track (publish on-page kit wording follows **ceiling track hoist** unless WP confirms tracking). **Human:** Paste chosen title and meta into WP Search and Social; do not edit `inc/seo.php` until human confirms. Full T1 to T3 and M1 to M3 in §4.1 `#### Step B - 2026-05-11 - https://restwellretreats.co.uk/quieter-times-whitstable-low-crowd-access/`. **P4 Step C (2026-05-11):** Full ordered ladder in §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/quieter-times-whitstable-low-crowd-access/` (Step A plus §2.3 AEO tables ~3556-3564 and ~4869-4877). | TBD                                                                                                                                                                                                                                                 |
| `/changing-places-toilets-kent-coast-days-out/` (`page.php` seeded guide)    | 2026-05-11     | 2    | changing places toilets kent coast                            | tracking hoist holiday accommodation (SERP phrase; publish ceiling track hoist unless WP confirms tracking), accessible self catering Kent coast, disabled access holiday cottage Whitstable, accessible holiday cottage hoist wet room Whitstable Kent (commercial bridge; kit depth on `/accessibility/`), changing places toilets kent coast days out (slug query)                                                                            | Changing Places Kent: day out guide - Restwell Retreats          | Kent coast days out: CP toilets, mapping tips, beach pair ideas. Quiet Whitstable self-catering: hoist, profiling bed, wet room. Read accessibility, enquire.     | **P4 Step C (2026-05-11), compact:** **H1** Changing Places and accessible toilets for Kent coast days out (seed `title` in `inc/seo-content-seed.php`; Confirm in WP: one visible H1). **H2** What Changing Places means on the Kent coast (AEO what-is; seed ceiling hoist, bench, toilet, two carers). **H2** How to plan a day out around toilet stops (AEO how-to-plan; **H3** Morning anchor; **H3** Emergency backup; **H3** Beach legs, link `/accessible-beaches-coastal-walks-kent/`). **H2** Who needs CP versus standard accessible loos (AEO who-for). **H2** What to carry or confirm before travel (AEO documents or checks; map, sling clips, radar key, phone closures). **H2** Where DP or CHC planning meets this topic (AEO overlap; signpost `/resources/` only). **H2** Why coastal miles expose gaps. **H2** How standard accessible loos differ (table). **H2** Practical steps. **H2** Common mistakes. **H2** Frequently asked questions (seed H3s). **H2** Closing: specs on `/accessibility/`, `/enquire/`, `/blog/` per seed.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          | TBD Step D                                                                                                                     | **P4 Step C (2026-05-11):** Full ordered ladder §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/changing-places-toilets-kent-coast-days-out/` (AEO block `#### Run - 2026-05-10` for this URL plus `restwell_get_blog_post_changing_places_kent_coast_html()`). **P4 Step B (2026-05-11):** Runner-up titles T2 Accessible Kent coast: CP toilet stops - Restwell Retreats; T3 Changing Places Kent coast days out - Restwell Retreats. Runner-up metas M2 CP versus standard loos on Kent trips: map stops carefully. Whitstable-area self-catering: hoist, profiling bed, wet room. Read accessibility, enquire. M3 Changing Places Kent coast: CP versus standard loos, map stops before travel. Whitstable stay: hoist, profiling bed, wet room. See accessibility, enquire. **Rationale:** T1 keeps Changing Places and Kent in the opening segment for Step A primary, reads as a guide not a duplicate `/accessibility/` hub. M1 tracks seed promises in `inc/seo-content-seed.php` (CP versus standard loos, mapping stops, pairing with beach plans), adds careful mapping language, both USPs, defers kit proof to `/accessibility/`. **Step A vs brief:** worksheet **Primary** stays Step A `changing places toilets kent coast`; phrase **accessible holiday cottage hoist and wet room Whitstable Kent** is **not** the SERP owner here, it sits in **Secondaries** for the cluster bridge (same pattern as `/hire-mobility-scooter-equipment-uk-holiday/` §13.1 note). **Intent:** informational CP and day-out planning plus soft stay bridge. **Cannibal:** full CP venue data and hours Confirm in WP against official Changing Places map and operator pages; beaches article signposts only; kit tables on `/accessibility/` and `/the-property/`. **Human:** Paste into WP Search and Social; **do not** edit `inc/seo.php` until human confirms. Full T1 to T3 and M1 to M3 in §4.1 `#### Step B - 2026-05-11 - https://restwellretreats.co.uk/changing-places-toilets-kent-coast-days-out/`.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        | TBD                                                                                                                                                                                                                                                 |
| `/privacy-policy/` (`template-privacy-policy.php`)                           | 2026-05-11     | 2    | restwell privacy                                              | accessible holiday cottage hoist and wet room Whitstable Kent (Step B SERP bridge only, not page owner), tracking hoist holiday accommodation (SERP phrase; do not assert tracking versus ceiling track on this legal URL, Confirm in WP and `/accessibility/`), accessible self catering Kent coast, disabled access holiday cottage Whitstable, holiday cottage privacy policy UK GDPR                                                         | Accessible cottage Whitstable: privacy - Restwell Retreats       | Privacy for Whitstable stays: enquiry data, optional care share if agreed, GA4 controls, three-year retention, UK GDPR and ICO. Email us. Restwell Retreats.      | **P4 Step C (2026-05-11), compact:** **H1** Restwell Retreats privacy policy (UK GDPR, plain English) (Confirm in WP: one visible H1 in `legal-policy-layout`). **H2** What this policy covers and when it was last updated (AEO: what the Restwell privacy policy covers; Tier 2 last updated). **H2** Who is the data controller (pillar AEO; entity per theme). **H2** Enquiry and booking personal data we collect (**H3** Enquiry form fields; **H3** Optional care or accessibility text; **H3** Booking records where applicable, Confirm in WP). **H2** Lawful bases and why we use your data (legitimate interests, contract; Step A self catering guest data UK). **H2** Cookies, Google Analytics 4, and your choices (AEO: what cookies the Restwell site uses; essential plus GA4 when consented; first-visit controls; list only what the published body states). **H2** Sharing data, Continuity of Care, and no sale (**H3** Continuity of Care Services when care is agreed; **H3** We do not sell your personal information). **H2** How long we keep enquiry and booking records (three years in theme default). **H2** Your UK GDPR rights, ICO, and how to contact us (pillar AEO plus contact about privacy; Confirm in WP mailbox). **H2** Website accessibility statement and overlays (AEO: accessibility overlays; signpost `/accessibility-policy/`, no duplicate WCAG claims here). **H2** Booking and cancellation rules (AEO: where booking and cancellation rules live; link `/terms-and-conditions/`).                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              | TBD Step D                                                                                                                     | **P4 Step C (2026-05-11):** Full ordered ladder §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/privacy-policy/`. **P4 Step B (2026-05-11):** Runner-up titles T2 Hoist, wet room Whitstable: privacy data - Restwell Retreats; T3 Kent self-catering privacy: GA4, retention - Restwell Retreats. Runner-up metas M2 Accessible self-catering Kent privacy: enquiry data, GA4 consent, three-year retention, UK GDPR, ICO. Disabled-access Whitstable stays. Restwell Retreats.; M3 Disabled-access Whitstable privacy: enquiry and booking data, GA4 cookies, three-year retention, UK GDPR rights. See Accessibility for kit. Restwell Retreats. **Rationale:** Chosen title leads with **Accessible cottage** and **Whitstable** for the Step B brief scan line, then **privacy** so the SERP matches a legal page, not a property PDP. Chosen meta tracks `restwell_get_privacy_policy_content()` in `inc/theme-setup.php` (enquiry fields, Continuity of Care when agreed, GA4 and controls, three years, UK GDPR, ICO, email) without marketing tone; defers hoist and wet room proof to **Accessibility** so USPs are not misread as privacy disclosures. **Intent:** informational trust, navigational (`restwell privacy` seed). **Cannibal:** kit tables on `/accessibility/` and `/the-property/`; website WCAG statement on `/accessibility-policy/`. **Human:** Paste into WP Search and Social; do not edit `inc/seo.php` until human confirms. Full T1 to T3 and M1 to M3 in §4.1 `#### Step B - 2026-05-11 - https://restwellretreats.co.uk/privacy-policy/`.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             | TBD                                                                                                                                                                                                                                                 |
| `/terms-and-conditions/` (`template-terms-and-conditions.php`)               | 2026-05-11     | 2    | restwell terms                                                | accessible holiday cottage hoist and wet room Whitstable Kent (Step B pack in title or meta, not Primary swap without GSC), tracking hoist holiday accommodation (SERP phrase; on property URLs publish ceiling track hoist unless WP confirms tracking), accessible self catering Kent coast, disabled access holiday cottage Whitstable, booking deposits cancellations accessible stay                                                        | Accessible hoist cottage Whitstable: terms - Restwell Retreats   | Deposits, cancellations, balance: Whitstable-area booking terms. Hoist, profiling bed, wet room (see accessibility). Read before you book. Restwell Retreats.     | **P4 Step C (2026-05-11), compact:** **H1** Terms and conditions (Confirm in WP: one visible H1 matches hero `legal_heading`). **H2** What these terms cover (AEO: what Restwell terms cover). **H2** Contact about these terms (AEO: contact path). **H2** Booking confirmation and availability. **H2** Accessibility information at booking. **H2** Deposits, balance, and payment methods (BACS, card; balance no later than six weeks before arrival, per `restwell_get_terms_conditions_content()` default). **H2** Cancellations, refunds, and travel insurance (tiers: more than 30 days, 14 to 30 days, fewer than 14 days, per theme default; Confirm in WP). **H2** Medical or care emergencies and evidence (partial refund or date change, case-by-case). **H2** Date changes, early departure, no-shows, and if we cancel. **H2** Check-in, check-out, and guest numbers. **H2** Using accessibility equipment safely (**H3** ceiling track hoist, profiling bed, wet room per theme default; intended use; report faults; measurements on `/accessibility/`). **H2** Assistance dogs, smoking, vaping, and care of the property. **H2** Optional care via Continuity of Care Services (their terms apply). **H2** Liability and insurance. **H2** Personal data, cookies, and related policies (**H3** `/privacy-policy/` for data and cookies; **H3** `/accessibility-policy/` for website WCAG, testing, third-party embeds; AEO cookie and overlay-style questions answered only with text that exists on those pages, Confirm in WP).                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            | TBD Step D                                                                                                                     | **P4 Step C (2026-05-11):** Full ordered ladder §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/terms-and-conditions/`. **P4 Step B (2026-05-11):** Runner-up titles T1 Terms: accessible cottage Whitstable - Restwell Retreats; T2 Deposits, cancellations: Whitstable terms - Restwell Retreats. Runner-up metas M2 Kent self-catering Whitstable: deposits, cancellations, balance terms. Hoist, profiling bed, wet room on accessibility. Read before booking. Restwell Retreats.; M3 Tracking hoist holidays: Restwell terms, deposits, cancellations Whitstable. Accessible Kent self-catering. Hoist type: see accessibility. Restwell Retreats. **Rationale:** Chosen title variant **3** plus meta **1** load **Accessible**, **hoist**, **Whitstable**, and **terms** early for the Step B pack while signalling a legal page; meta leads on deposits, cancellations, and balance so the snippet matches contract intent in `restwell_get_terms_conditions_content()` themes and §2.6 legal trio summary, carries hoist, profiling bed, and wet room as the one-place USP, defers hoist type detail to `/accessibility/`. **Intent:** transactional contract plus trust. **Cannibal:** FAQ tier summaries must link here for numbers; kit proof on `/accessibility/` and `/the-property/`. **Facts:** Confirm in WP: live editor text for deposits, balance timing, cancellation bands, equipment use, and hoist guest duties matches theme defaults or overrides (legal trio cluster **2026-05-10**); do not invent tier days. **Human:** Paste into WP Search and Social; do not edit `inc/seo.php` until human confirms. Full T1 to T3 and M1 to M3 in §4.1 `#### Step B - 2026-05-11 - https://restwellretreats.co.uk/terms-and-conditions/`.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               | TBD                                                                                                                                                                                                                                                 |
| `/accessibility-policy/` (`template-accessibility-policy.php`)               | 2026-05-11     | 2    | restwell website accessibility                                | accessible holiday cottage hoist and wet room Whitstable Kent (Step B bridge only, kit on `/accessibility/` and `/the-property/`), tracking hoist holiday accommodation (SERP phrase, publish ceiling track hoist on property URLs unless WP confirms), accessible self catering Kent coast, disabled access holiday cottage Whitstable                                                                                                          | WCAG website accessibility statement - Restwell Retreats         | WCAG site statement: checks, embed limits, reporting. Hoist, profiling bed, wet room specs on Accessibility only. Email or enquire. Restwell Retreats.            | **P4 Step C (2026-05-11), compact:** **H1** WCAG website accessibility statement (mirrors Step B title stem plus Step A `restwell website accessibility` and `restwell website accessibility wcag`; digital only; Confirm in WP: one visible H1, no duplicate hero H1). **H2** What this statement covers (AEO: What does Restwell's accessibility policy cover?; this site, not bungalow layout). **H3** Where to read cottage access (signpost `/accessibility/` and `/the-property/` for hoist, profiling bed, wet room; ceiling track hoist wording unless WP confirms tracking). **H2** WCAG 2.2 commitment and how we test (legal trio plus Step A wcag row; automated and manual testing, keyboard, zoom, screen readers per `restwell_get_accessibility_policy_content()`; Confirm in WP: body matches theme default). **H2** Third-party content and embed limits (legal trio cluster). **H2** Accessibility overlays (AEO: Does Restwell use accessibility overlays?; factual approach only, no unsupported widget claims). **H2** Report a barrier or request a format (AEO: How do I contact Restwell about accessibility issues?; email or enquire; reply timing Confirm in WP: forty-eight hour aim if still in theme copy). **H2** Bookings and cancellations (AEO: Where are booking and cancellation rules?; signpost `/terms-and-conditions/` or `/faq/` only). **H2** Cookies and analytics (AEO: What cookies does the Restwell site use?; signpost `/privacy-policy/` only; categories only if that policy lists them). **H2** Complaints and EHRC (equality body signpost per theme defaults).                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                | TBD Step D                                                                                                                     | **Intent:** informational trust, digital WCAG statement (not cottage spec). **Facts:** Aligns with `restwell_get_accessibility_policy_content()` and seed `inc/seo-content-seed.php` (`accessibility-policy`). **P4 Step B (2026-05-11):** Runner-up titles T2 Website WCAG testing and feedback - Restwell Retreats; T3 Web accessibility statement WCAG 2.2 - Restwell Retreats. Runner-up metas M2 (160c) Accessible Kent self-catering: website policy only. Hoist, profiling bed, wet room on Accessibility. Report web barriers by email or enquiry. Restwell Retreats.; M3 (156c) We test this site for WCAG barriers and embed limits. Cottage hoist and wet room on Accessibility. Request formats or report issues here. Restwell Retreats. **Rationale:** T1 names WCAG and website accessibility early so the SERP matches this page, not `/accessibility/`; M1 states checks, embed limits, reporting, splits kit to Accessibility only, CTA. **Step A vs pasted brief:** long cottage primary is **not** query owner here; see §4.1 `#### Step B - 2026-05-11 - https://restwellretreats.co.uk/accessibility-policy/`. **Cannibal:** `/accessibility/` and `/the-property/` own kit proof. **Human:** Paste into WP Search and Social; **do not** edit `inc/seo.php` until human confirms. Full T1 to T3 and M1 to M3 in §4.1 `#### Step B - 2026-05-11 - https://restwellretreats.co.uk/accessibility-policy/`. **P4 Step C (2026-05-11):** Full ordered ladder §4.1 `#### Step C - 2026-05-11 - https://restwellretreats.co.uk/accessibility-policy/`.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     | TBD                                                                                                                                                                                                                                                 |


---

## 14. Sprint schedule


| Week | URLs / work                          | Skills                                                                |
| ---- | ------------------------------------ | --------------------------------------------------------------------- |
| 1    | `/accessibility/`, `/enquire/`       | §2 refresh seeds → §4 full pipeline                                   |
| 2    | `/the-property/`, `/resources/`      | + competitor benchmarking                                             |
| 3    | `/how-to-choose…`, `/faq/`           | + `/seo-snippet-hunter`, schema review                                |
| 4    | Internal link pass + 2 cluster posts | `/seo-aeo-content-cluster` link map + `/seo-cannibalization-detector` |


Re-export GSC monthly; promote URLs with rising impressions to **P1**.

---

## 15. Completion checklist

- §2 keyword+AEO captured for each pillar (**§2.6** runs appended; **§2.6** index + workspace note at top of log; live `google.co.uk` SERP + Ahrefs or Semrush or DataForSEO KD or volume still **TBD** per each run's **Next validation**)  
- §16 B2 intent map filled; cannibalization actions assigned (table synced **2026-05-10** from §2.6 ownership bullets)  
- §16 B3 backlog has owners or dates (Owner column set **2026-05-10**; refine dates with your calendar)  
- P1–P2: §13 worksheet complete (**§13.1** rows for key URLs; `/`, `/accessibility/`, `/enquire/`, and `/the-property/` Step A rows **2026-05-10**, extend for `/resources/`, etc.)  
- §6–7 spot-check on top 5 URLs  
- Comparison/alternatives pages reviewed per §8  
- §11.2 updated after latest GSC export  
- §16 B6 monthly ritual running once GSC has any data  
- §17 Track A: optional A4 decided; A5 verification done when ready

---

## 16. Ranking execution (B1–B6)

### Brand-new sites (no meaningful GSC history yet)

You **cannot** run a rich **B1 classic** until Google has indexed you and Performance exists (often weeks). That is normal.

1. Complete **B1-new** below (verify + sitemap + research-led priorities).
2. Run **B2–B5** using URL inventory + intent map; “competition” includes overlapping pages **you** publish.
3. Start **B6** once GSC shows *any* impressions - first month becomes baseline.

### B1-new - Launch & strategic priority

**Skills:** `/seo-audit`, `/seo-fundamentals`, `/seo-keyword-strategist`, `/seo-content-planner`

**A. Property readiness**

1. Google Search Console: verify domain or URL-prefix property.
2. Submit **sitemaps** (e.g. `/wp-sitemap.xml`).
3. Confirm **GA4** (or equivalent) if used for landing-page QA.

**B. Strategic priority table (research-led - not GSC-dependent)**


| Target query / intent | Primary URL (assign one) | Est. difficulty (L/M/H) | Business value (H/M/L) | Notes |
| --------------------- | ------------------------ | ----------------------- | ---------------------- | ----- |
|                       |                          |                         |                        |       |


**Rule:** Ship and interlink **high business value** intents first, even if estimated volume is low.

### B1 classic - Baseline export (when GSC is mature)

1. Performance → Search results → **Last 16 months** (or max available).
2. Export **Queries** + **Pages** CSV; save dated folder off-repo.
3. Fill priority table: high impressions + position **6–15** + high business value.


| Query | Primary landing URL | Impressions | Clicks | Avg position | Business value (H/M/L) |
| ----- | ------------------- | ----------- | ------ | ------------ | ---------------------- |
|       |                     |             |        |              |                        |


### B2 - Intent map & cannibalization

**Living scorecard:** [AUDIT.md](AUDIT.md) §8 hub/spoke table (editorial intent boundaries).

**Skills:** `/seo-keyword-strategist`, `/seo-cannibalization-detector`, `/seo-meta-optimizer`

1. One **primary URL** per commercial intent.
2. List secondary URLs that compete for the same intent (GSC overlap or editorial duplication).
3. Actions: **differentiate** (H1 + angle), **internal link** to primary, **301/consolidate** only after editorial agreement.


| Intent / theme                                   | Primary URL                                                           | Competing URLs                                                          | Action                                                                                                                                     |
| ------------------------------------------------ | --------------------------------------------------------------------- | ----------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------ |
| Commercial Whitstable adapted stay (book-now)    | `/the-property/`                                                      | `/accessibility/` (spec depth), `/` (support)                           | Keep conversion and story on property; `/accessibility/` answers kit and dimensions; internal links only, no duplicate commercial primary. |
| Funding systems (DP, CHC, carers, commissioner)  | `/resources/` plus the matching long-form guide slug per query family | `/faq/` (short answers that link out)                                   | Hub summarises; deep YMYL on cluster URLs; FAQ must not steal primaries from `/resources/` or guides.                                      |
| Equipment specs (hoist, wet room, door widths)   | `/accessibility/`                                                     | `/how-to-choose-accessible-self-catering-holiday/`, relevant blog posts | Spec pillar here; comparator owns vetting or checklist angle; differentiate H1s.                                                           |
| Local Whitstable and Kent days out               | `/whitstable-area-guide/`                                             | Beaches, parking, eating out, quieter times cluster URLs                | Assign one primary per topic; area guide cross-links; property page keeps distance-only copy.                                              |
| Accessibility evidence / access statement how-to | `/accessibility/` (facts)                                             | `/how-to-read-holiday-cottage-access-statement/` (process)              | Split spec facts vs how to read a statement; cross-link both ways.                                                                         |


**Starting theme → primary map (validate when data exists):**


| Theme                           | Primary                                            | Supporting                                |
| ------------------------------- | -------------------------------------------------- | ----------------------------------------- |
| Accessible self-catering choice | `/how-to-choose-accessible-self-catering-holiday/` | `/blog/` posts, `/accessibility/`         |
| Direct payments & holidays      | `/direct-payment-holiday-accommodation/`           | `/resources/`, relevant posts             |
| CHC / NHS funding context       | `/resources/` + strongest blog post                | Cluster cross-links                       |
| Carers / respite                | `/carers-respite-holiday-guide/`                   | `/resources/`, blog                       |
| Property / booking              | `/the-property/`                                   | `/enquire/`, `/faq/`                      |
| Local - Whitstable              | `/whitstable-area-guide/`                          | `/accessible-beaches-coastal-walks-kent/` |


### B3 - Topic cluster & 90-day backlog

**Skills:** `/seo-content-planner`, `/programmatic-seo` (only if scaling templated pages - defer until IA + quality gates are clear)

**Pillar vs supporting**


| Pillar            | Supporting articles (examples)                        | Internal link rule                                                                          |
| ----------------- | ----------------------------------------------------- | ------------------------------------------------------------------------------------------- |
| Funding & respite | CHC vs holiday rent, mobility hire, DP invoice splits | Each supporting piece links **up** to `/resources/` or pillar once above fold where natural |
| Choosing property | Checklist, insurance, packing                         | Link to `/the-property/` + `/accessibility/`                                                |
| Kent / stay       | Area guide, beaches                                   | Link to `/the-property/` + `/enquire/`                                                      |


**90-day backlog**


| Week  | Deliverable                                                                                                                                                                            | Target keyword / intent                                                                                                                                                                                                                                                                                                                                                                                                                                                                            | Owner  |
| ----- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------ |
| 1–2   | Publish/polish **top 5 pillar URLs** + B1-new map                                                                                                                                      | `/accessibility/`, `/enquire/`, then `/the-property/`, `/resources/`, `/how-to-choose-accessible-self-catering-holiday/` per **§14**                                                                                                                                                                                                                                                                                                                                                               | Editor |
| 3–4   | One new or expanded Tier 2 cluster article **plus** `/who-its-for/` inbound links                                                                                                      | Tier 2 pick from **§2.6**; add contextual links from `/resources/`, `/direct-payment-holiday-accommodation/`, `/carers-respite-holiday-guide/`, `/commissioner-checklist-accessible-respite-stay/` to `/who-its-for/` per **§3.5** run **2026-05-10**                                                                                                                                                                                                                                              | Editor |
| 5–8   | Internal link pass on pillars                                                                                                                                                          | Cannibalization actions in B2 table above; include `/who-its-for/` hub routing from Whitstable and beaches cluster where natural                                                                                                                                                                                                                                                                                                                                                                   | Editor |
| 9–12  | Second content wave + `/faq/` expansions                                                                                                                                               | `/faq/` plus under-served AEO from **§2.6**; pair Carer's Assessment and commissioner paperwork snippets with `/carers-respite-holiday-guide/` and commissioner checklist                                                                                                                                                                                                                                                                                                                          | Editor |
| 13–14 | Draft OT or case manager referral helper (new slug TBD in WP)                                                                                                                          | `occupational therapist referral questions adapted self catering holiday`; facts limited to published `/accessibility/` scope                                                                                                                                                                                                                                                                                                                                                                      | Editor |
| 15–16 | Funding realism supplement (**Confirm in WP**)                                                                                                                                         | Direct payment invoice wording **or** Kent assessment timeline signposting; no invented procedural guarantees                                                                                                                                                                                                                                                                                                                                                                                      | Editor |
| 17–18 | Seeded 15-URL cluster internal link pass                                                                                                                                               | Execute §3.5 cluster run **2026-05-10** tree: each long-form links up to `/resources/`, `/how-to-choose-accessible-self-catering-holiday/`, or `/whitstable-area-guide/` plus horizontal links as listed                                                                                                                                                                                                                                                                                           | Editor |
| 19–20 | AEO blocks on two flagged guides                                                                                                                                                       | Primary intents: holiday accessibility statement definition; CHC respite funding question (short answer openings + citations)                                                                                                                                                                                                                                                                                                                                                                      | Editor |
| 21–22 | Whitstable logistics trio polish                                                                                                                                                       | Mutual anchors across `/accessible-parking-whitstable-tankerton/`, `/accessible-train-travel-whitstable-kent/`, `/accessible-eating-out-whitstable-kent/`; keep primaries distinct                                                                                                                                                                                                                                                                                                                 | Editor |
| 23–24 | Low-volume conversion pair                                                                                                                                                             | `/holiday-backup-plan-care-worker-change/` + `/fatigue-friendly-whitstable-coastal-day/` inbound links from `/resources/`, carers guide, area guide                                                                                                                                                                                                                                                                                                                                                | Editor |
| 25–26 | Legal trio cluster P1 drafts or publishes                                                                                                                                              | `/website-accessibility-statement-vs-property-access/`, `/health-information-enquiry-form-uk-gdpr/`, `/care-partner-data-share-booking-continuity/` per **§3.5** run **2026-05-10** legal trio; link each to matching pillar                                                                                                                                                                                                                                                                       | Editor |
| 27–28 | Legal trio cluster P2 plus enquiry cross-links                                                                                                                                         | Cookie GA4, retention three years, SAR practicals, deposit timing, cancellation evidence; add `/enquire/` pointers to `/privacy-policy/` and `/terms-and-conditions/` where natural                                                                                                                                                                                                                                                                                                                | Editor |
| 29–30 | Legal trio P3 and site-wide legal footer pass                                                                                                                                          | Assistance dogs notice, equipment fault reporting, third-party embed limits; verify no invented PCI or overnight service claims (**Confirm in WP**)                                                                                                                                                                                                                                                                                                                                                | Editor |
| 31–32 | Draft new homepage cluster comparison and what-is pages per **§3.5** run **2026-05-10** for `/`                                                                                        | New: `/restwell-vs-accessible-hotel-room-uk/` (kw: `whole property accessible cottage vs accessible hotel room UK comparison`, P2, AEO comparison); New: `/whats-included-accessible-self-catering-stay/` (kw: `what is included in an accessible self catering holiday UK`, P2, AEO what-is). Keep equipment claims to bedroom ceiling hoist + profiling bed seed; do not extend hoist coverage.                                                                                                  | Editor |
| 33–34 | Draft `/care-support-partner-kent-cqc/` trust page **plus** homepage cluster internal-link pass                                                                                        | Kw: `optional on site care support holiday Kent CQC regulated` (P3); link from `/how-it-works/` Step 3 + homepage trust band; **Confirm in WP** before stating service scope, response times, or pricing. Internal-link pass: add or audit cross-links per **§3.5** tree (homepage hub to /the-property/, /accessibility/, /how-it-works/, /enquire/, /how-to-choose…/, /who-its-for/, /whitstable-area-guide/, /resources/, /blog/, /faq/, plus the two new AEO pages and the care-partner page). | Editor |
| 35–36 | Lock primary keywords for `/the-property/`, `/enquire/`, `/how-it-works/`, `/how-to-choose-accessible-self-catering-holiday/`, `/blog/` per **§3.5** homepage cluster (P1 and P3 rows) | Run **§4 Step A–E** for each P1 URL; align titles/meta with seed in `inc/seo.php`, `inc/page-meta-definitions.php`. Update **§13.1** rows.                                                                                                                                                                                                                                                                                                                                                         | Editor |


### B4 - On-page upgrades

Execute **§4** end-to-end (including **Step H**). Homepage published baseline: [FRONT-PAGE-OPTIMIZATION.md](../FRONT-PAGE-OPTIMIZATION.md). Money pages first; then URLs that gain impressions in GSC when data exists.

### B5 - Quality, authority, freshness (YMYL-adjacent)

**Skills:** `/seo-authority-builder`, `/seo-content-refresher`, `/seo-content-auditor`, `/seo-content-writer`

**Trust edits log**


| Page             | Issue | Edit made | dateModified |
| ---------------- | ----- | --------- | ------------ |
| `/resources/`    |       |           |              |
| `/faq/`          |       |           |              |
| `/the-property/` |       |           |              |


Focus: named expertise, consistent org/address (matches JSON-LD / GBP); refresh stats and legislation references when material.

### B6 - Monthly ranking ritual

**Sync with:** §11.5 monthly compare + §11.6 measurement log; open technical/editorial items in [AUDIT.md](AUDIT.md).

**Skills:** `/seo-audit`, `/seo-fundamentals`, `/geo-fundamentals`

**New sites (first ~3–6 months):** indexing checks; snapshot totals even if near-zero; manual SERP spot-checks on priority URLs.

**One-pager template**

**Month:** ____  

- vs prior month (or vs first snapshot): impressions / clicks / avg position.  
- **Winners:**  
- **Losers:**  
- **Experiments next month:**  
- **AI / overview:** optional (`/geo-fundamentals`).

### Track B completion criteria

**Brand-new site**

- B1-new: GSC verified + sitemap + strategic table filled  
- Optional later: B1 classic export

**All sites**

- B2: Intent map filled; cannibalization actions assigned (synced **2026-05-10** with **§16 B2** table)  
- B3: 90-day backlog has owners/dates (Owner **Editor** set **2026-05-10**; adjust to named person if needed)  
- B4: Priority URLs through §4 (+ Step H)  
- B5: Trust log started for core pages  
- B6: Monthly ritual running


**Forms (2026-06-18):** Enquiry and FAQ question forms require a valid phone number (`restwell_validate_submission_phone()` in theme).

### Optional - programmatic scale

**Skill:** `/programmatic-seo`  

Evaluate only after B2 is stable and thin-page risk is controlled. Restwell is mostly editorial + blog; programmatic expansion is **not** required for baseline success.

---

## 17. Technical remediation (Track A - theme)

Prerequisite for trusting measurements: core technical SEO fixes live in theme PHP.


| Item                                                                                            | Status   | Location / note                                |
| ----------------------------------------------------------------------------------------------- | -------- | ---------------------------------------------- |
| **A1** `og:url` from canonical on non-singular views                                            | Shipped  | `inc/seo-social-meta.php`                      |
| **A2** Paginated blog canonical                                                                 | Shipped  | `inc/seo.php` (`is_home` + paged)              |
| **A3** Breadcrumb JSON-LD vs visible trail                                                      | Shipped  | `inc/seo.php`, `template-parts/breadcrumb.php` |
| **A4** Front-page `og:type` vs `article:`*                                                      | Optional | `inc/seo-social-meta.php`                      |
| **A5** Verification pass (singular, blog, pagination, category, tag, post; guest guide noindex) | Pending  | Rich Results + manual                          |


**Skills:** `/seo-meta-optimizer`, `/seo-audit`, `/schema-markup`, `/verification-before-completion`

---

## 18. Skills quick reference


| Purpose                       | Skill                             |
| ----------------------------- | --------------------------------- |
| Diagnose / prioritise         | `/seo-audit`, `/seo-fundamentals` |
| Keywords in copy              | `/seo-keyword-strategist`         |
| Page overlap                  | `/seo-cannibalization-detector`   |
| Clusters / calendar           | `/seo-content-planner`            |
| Headings + internal links     | `/seo-structure-architect`        |
| Featured-snippet style blocks | `/seo-snippet-hunter`             |
| Titles/descriptions           | `/seo-meta-optimizer`             |
| Trust (YMYL-adjacent)         | `/seo-authority-builder`          |
| Stale content                 | `/seo-content-refresher`          |
| Thin/low-quality pages        | `/seo-content-auditor`            |
| New copy                      | `/seo-content-writer`             |
| Scale/template SEO            | `/programmatic-seo`               |
| AI search surfaces            | `/geo-fundamentals`               |


Full index: [SKILLS_GLOSSARY.md](SKILLS_GLOSSARY.md). Closest proxies for niche audits: `/seo-audit`, `/seo-meta-optimizer`, `/schema-markup`.

---
## 19. Off-site / GBP / authority (merged legacy §7–9)

### 19.1 Google Business Profile

| Type | Category |
|------|----------|
| **Primary** | Holiday rental |
| **Secondary 1** | Vacation home rental agency |
| **Secondary 2** | Cottage rental |

**Business description (≤750 chars):** Fully adapted holiday bungalow in Whitstable, Kent coast — wheelchair accessible throughout, ceiling track hoist, profiling bed, roll-in shower, step-free access. Genuine holiday home (not a care facility). Carers welcome. Bookings from individuals, OTs, case managers, commissioners. Assistance dogs and pets welcome. Whitstable ~8 miles from Canterbury; ~90 min London by train.

**Services:** Accessible holiday accommodation; short breaks (2+ nights); self-catering; dog-friendly; respite/funded stays (direct payments, personal budgets, CHC).

**Q&A seeds:** Powered wheelchair suitability (965mm door, level access); carer can stay; beach access via Tankerton promenade + route 400 bus; direct payment/CHC funding; peak-date availability.

**GBP posts:** Rotate awareness (exterior/seafront), consideration (interior space + carers), seasonal booking CTAs → `restwellretreats.co.uk/enquire/` (not `/booking`).

**Operating cadence:** Cross-link [plan-seo-ops.md](plan-seo-ops.md) **G7** (backlink pipeline) and **G8** (entity consistency sheet).

### 19.2 Backlink strategy (priority targets)

| Tier | Targets |
|------|---------|
| **High** | Tourism for All, DisabledHolidays.com, CS Disabled Holidays, AccessAble, Euan's Guide, Visit Kent, Google Business Profile |
| **Medium** | Visit Canterbury, Explore Kent, SimplyOwners, OpenBritain, Bing/Apple Places |
| **Cross-links (day one)** | continuityofcareservices.co.uk, CTA site — reciprocal "Continuity Group" footer links |

**Link-earning content:** Accessible beaches Kent guide; Revitalise alternatives; direct payment holiday guide; packing list; downloadable access statement PDF; professional referral guide.

**Avoid:** Paid link schemes, generic directories, reciprocal unrelated exchanges, anchor-text manipulation, PR wire services.

### 19.3 Directory submissions checklist

Track outreach in [plan-seo-ops.md](plan-seo-ops.md) **G7** pipeline: target, tier, contact date, status, live URL, referral traffic.
