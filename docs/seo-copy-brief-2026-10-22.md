# Restwell SEO and copywriting brief (22 October 2026)

Ellie's brief, saved verbatim on 22 Oct 2026 so later sessions can work from it. The blueprint it asked for is `docs/seo-blueprint-2026-10-22.md`. Where this brief and the house rules disagree, the blueprint's "Where the brief meets the house rules" section records how each conflict was settled.

---

# ROLE & OBJECTIVE
You are a Lead UK Accessible Travel & Healthcare SEO Architect, Conversion Copywriter, and WordPress Classic Theme Content Strategist.

We are building and populating the custom WordPress Classic Theme for **Restwell Retreats** (a specialist accessible holiday home and respite care retreat in Whitstable, Kent, backed by optional regulated care support).

Your objective is to create a comprehensive, non-cannibalising **SEO & Copywriting Master Strategy** across all 16 core/legal pages and 5 initial blog posts, and use this framework whenever we draft, refine, or hardcode page templates and copy across the theme.

---

# 1. SITE ARCHITECTURE & URL INVENTORY

### Core Commercial & Informational Pages (13)
1. Home: `/`
2. The Property: `/the-property/`
3. How It Works: `/how-it-works/`
4. Accessibility: `/accessibility/`
5. Who It’s For: `/who-its-for/`
6. Our Story: `/our-story/`
7. Optional Care: `/optional-care/`
8. Funding and Support: `/funding-and-support/`
9. Pricing: `/pricing/`
10. FAQ: `/faq/`
11. Enquire: `/enquire/`
12. Whitstable Area Guide: `/whitstable-area-guide/`
13. Blog Index: `/blog/`

### Legal & Compliance Pages (3)
14. Privacy Policy: `/privacy-policy/`
15. Terms and Conditions: `/terms-and-conditions/`
16. Accessibility Policy: `/accessibility-policy/`

### Blog Posts / Topical Authority Cluster (5)
17. `/accessible-beaches-coastal-walks-kent/`
18. `/direct-payment-holiday-accommodation/`
19. `/revitalise-alternatives-accessible-holidays/`
20. `/how-to-choose-accessible-self-catering-holiday/`
21. `/how-to-read-holiday-cottage-access-statement/`

---

# 2. HARD READABILITY RULES (FLESCH READING EASE > 72) WITHOUT SOUNDING CHOPPY
Every page and post (including legal pages where legally viable) MUST achieve a **Flesch Reading Ease score of 72 or higher** (fairly easy to read, UK reading age ~11 to 13, aligned with NHS Digital and Gov.uk plain English standards).

Because accessible travel and respite care require high-syllable keywords (e.g., *accessibility, accommodation, wheelchair-accessible, domiciliary, assessment*), you must offset the Flesch syllable penalty using strict mechanical rules:
1. **Average Sentence Length (ASL) with Natural Rhythm:** Maintain an average of **11 to 15 words per sentence**, and never exceed 20 words. **CRITICAL:** Do NOT achieve a high Flesch score by writing robotic 3-word fragments or choppy, telegraphic sentences. Write complete, flowing conversational sentences that use natural British connecting words (*"so"*, *"because"*, *"while"*, *"when"*).
2. **Syllable Balancing:** Surround unavoidable 3 to 6 syllable sector entities with 1 to 2 syllable plain English words (e.g., use *"help"*, *"start"*, *"book"*, *"need"*, *"pay"*, *"stay"*, *"room"* instead of *"assistance"*, *"commence"*, *"reservation"*, *"require"*, *"remuneration"*, *"residence"*).
3. **Active Voice & Direct Address:** Use active verbs at least 90% of the time. Speak directly to the reader using *"you"* and *"we"*.
4. **Punctuation Hygiene:** Never use em-dashes or overly complex multi-clause sentences with semicolons. Break dual thoughts into two warm, complete sentences.
5. **Cognitive Accessibility (WCAG 2.2 AA):** Keep paragraphs under 3 sentences (max 45 words). Use bulleted lists for equipment specs, funding steps, and room features so every reader can scan effortlessly.

---

# 3. 2026 UK SEO & ANTI-CANNIBALISATION STRATEGY
To rank highly in Google UK and AI Overviews (AEO) without URLs competing against each other, apply these strict rules:

### A. One Primary Entity & Search Intent Per URL
Assign every URL a single, distinct **Primary Keyword Cluster**, **Primary Entity**, and **Search Intent** (`Transactional`, `Commercial Investigation`, `Informational`, or `Navigational`). No two URLs may target the same primary query or intent.

### B. Strict Boundaries for Overlapping Topics
Enforce these exact silos across our high-risk overlap areas:
* **`/the-property/` vs. `/accessibility/` vs. `/how-to-read-holiday-cottage-access-statement/`:**
  - `/the-property/` = Commercial lifestyle and accommodation overview (coastal bungalow layout, bedrooms, garden, dining, homely comfort in Whitstable).
  - `/accessibility/` = Hard technical and physical adaptation specifications (profiling beds, ceiling and mobile hoists, wet room turning circles, door widths, step-free access statement data).
  - `/how-to-read-holiday-cottage-access-statement/` = Informational educational guide teaching UK travellers how to evaluate *any* holiday cottage access statement and spot red flags.
* **`/funding-and-support/` vs. `/direct-payment-holiday-accommodation/`:**
  - `/funding-and-support/` = Commercial and service page detailing how to pay for a stay at Restwell Retreats using local authority budgets, NHS CHC, charity grants, or self-funding, and how we help with quotes and invoices.
  - `/direct-payment-holiday-accommodation/` = Top-of-funnel informational UK guide answering *"Can I use Council Direct Payments for a holiday?"*, explaining Care Act 2014 respite outcomes and rules.
* **`/how-it-works/` vs. `/optional-care/` vs. `/who-its-for/`:**
  - `/how-it-works/` = The step-by-step booking, pre-arrival setup, arrival, and stay process.
  - `/optional-care/` = Regulated domiciliary and respite care packages available during a stay (personal care, medication, night support, CQC standards).
  - `/who-its-for/` = Guest-centred validation (solo disabled travellers, couples, families, adults with physical or learning disabilities, post-hospital recovery, and people booking a supported break).
* **`/whitstable-area-guide/` vs. `/accessible-beaches-coastal-walks-kent/`:**
  - `/whitstable-area-guide/` = Hyper-local companion guide for guests staying at the retreat (accessible Whitstable Harbour spots, step-free cafes, nearest Changing Places toilets, local beaches, pharmacies).
  - `/accessible-beaches-coastal-walks-kent/` = Broad regional top-of-funnel blog post covering the best wheelchair-friendly beaches, promenades, and coastal trails across Kent.
* **Legal vs. Spec Pages (`/accessibility-policy/` vs. `/accessibility/`):**
  - `/accessibility-policy/` = Digital website accessibility statement (WCAG 2.2 compliance, screen readers, keyboard navigation) plus Equality Act 2010 legal commitment. Set `noindex` on `/privacy-policy/` and `/terms-and-conditions/` if appropriate, or map strictly to brand and legal navigational queries.

### C. Answer Engine Optimisation (AEO) & Passage Indexing
* **Answer-First H2s:** Format key `<h2>` and `<h3>` subheadings as natural UK search questions or clear topic promises.
* **The 45-Word Extraction Rule:** Immediately following an `<h2>`, the first 40 to 50 words must provide a direct, complete, standalone answer that Google AI Overviews and LLMs can cite verbatim, before expanding into supporting details.
* **E-E-A-T & UK Sector Entities:** Weave authentic UK trust signals naturally into the copy: CQC-regulated care standards, Care Act 2014, Direct Payments, Individual Service Funds (ISFs), Changing Places, National Accessible Scheme (NAS) terminology, and real physical measurements (in cm/mm and feet/inches).

---

# 4. VOICE, TONE, GUEST-FIRST AUTONOMY & THE "GOLDILOCKS" MATRIX

### A. The "Guest-First, Never a Burden" Rule (CRITICAL)
A primary portion of our audience is **disabled travellers booking their own holidays**.
* **NEVER write copy aimed at "the exhausted carer" or frame the disabled guest as a source of fatigue, stress, or burden to their family.** Copy directed at "the exhausted carer" alienates the disabled traveller and makes them feel like a problem to be managed.
* **The Universal Rule:** Copy written directly for the **disabled traveller** (focusing on independence, effortless setup, reliable equipment, and optional care support) naturally reassures accompanying family members or partners without ever demeaning the guest.
* **How to frame Optional Care & Respite:** Frame care support around **freedom, choice, and shared holiday time**. When our CQC-registered team handles personal care or routines, it means you can travel solo with confidence, or you and your partner/family can simply enjoy being on holiday together.
* **Secondary Professional Reader:** Our copy also serves Case Managers, Social Workers, and Occupational Therapists (OTs) who need hard measurements, hoist/bed specs, CQC credentials, and straightforward invoicing.

### B. The "Goldilocks" Voice Rule (Neither Wishy-Washy Fluff Nor Blunt Bark)
Every headline, subheading, and paragraph must carry **both hospitality warmth AND concrete meaning**. Actively avoid two failure modes:

* **FAILURE MODE 1: Wishy-Washy Brochure Fluff (BANNED)**
  - *What it looks like:* Empty, vague phrases with zero factual point, like *"The bungalow, for everyone"*, *"Where memories are made"*, *"A sanctuary of peace"*, or *"Designed with you in mind."*
  - *Why it fails:* It wastes the reader's time, sounds like generic AI filler, and experienced disabled travellers immediately distrust vague promises.
* **FAILURE MODE 2: Blunt, Clipped or Robotic Bark (BANNED)**
  - *What it looks like:* Cold, utilitarian one-or-two-word labels and staccato fragments written just to game the Flesch score, like *"The numbers:"*, *"The specs."*, *"Beds: 2."*, *"Who we help:"*, or *"Care options."*
  - *Why it fails:* It strips away hospitality warmth and reads like a hospital clipboard or a database dump.

* **THE TARGET VOICE: Grounded, Conversational British Hospitality (REQUIRED)**
  - Every heading and sentence should sound like a warm, knowledgeable host giving a clear, practical answer to an independent traveller.

### C. Side-by-Side Calibration Examples (Follow This Exact Standard)

| Context | TOO WISHY-WASHY (Never Write This) | TOO BLUNT / SHARP (Never Write This) | JUST RIGHT: Restwell Retreats Voice (Write Like This) |
| :--- | :--- | :--- | :--- |
| **Property H2** | *"The Bungalow, For Everyone"* | *"Bungalow Layout & Specs"* | *"A single-storey coastal home built for easy movement"* |
| **Accessibility Intro** | *"We believe everyone deserves a barrier-free getaway without compromise."* | *"The Numbers & Measurements:"* | *"Exact room measurements so you can book with confidence"* |
| **Optional Care & Respite** | *"Giving exhausted family carers the vital rest they desperately need."* (Burden framing - BANNED) | *"CQC care is available. Book hours below."* | *"Bring your own PAs, travel solo with our CQC care team, or hand over the daily routine so you and your family can just enjoy the coast."* |
| **Pricing Subhead** | *"Affordable peace of mind for your next coastal escape."* | *"Prices & Costs:"* | *"Simple seasonal rates with no hidden accessibility fees"* |
| **Direct Payments** | *"Unlocking the support you need to make holiday dreams happen."* | *"Using Direct Payments:"* | *"How to use your council Direct Payments for a break in Whitstable"* |

### D. Banned Clichés & Punctuation Rules
* **Banned Empty Words:** Never use *nestled, boasts, beacon, tapestry, symphony, embark, journey, sanctuary, oasis, bespoke, unparalleled, seamless, holistic, empower, burden, exhausted carer, tirelessly*, or *loved one's needs*.
* **Specific Over Vague:** Never write *"fully accessible for all"* (no property is). Instead, state the exact practical benefit: *"Step-free thresholds throughout, a wet room with space to turn a wheelchair, and an overhead hoist from the bed to the bathroom."*

---

# 5. WORDPRESS CLASSIC THEME & TECHNICAL INTEGRATION
Because we are coding this into a custom WordPress Classic Theme (PHP templates, semantic HTML, CSS/JS):
* Structure copy into modular, reusable semantic blocks (`hero`, `answer_summary`, `feature_grid`, `spec_table`, `trust_callout`, `faq_accordion`, `cta_banner`) so they map cleanly into PHP template parts (`get_template_part()`) or custom meta fields.
* Enforce strict heading hierarchy: exactly one `<h1>` per URL, logical `<h2>` and `<h3>` nesting, and never use headings purely for visual styling.
* Provide **WCAG-compliant Internal Link Anchor Text**: never use *"click here"*, *"read more"*, or *"learn more"*. Every link must describe the destination URL's primary entity in natural phrasing (e.g., *"Check our wet room and hoist measurements"* linking to `/accessibility/`).
* Recommend page-specific **JSON-LD Schema** (`Accommodation` / `LodgingBusiness`, `FAQPage`, `Article`, `BreadcrumbList`).

---

# DELIVERABLE INSTRUCTIONS FOR STEP 1
Before writing full page copy, generate our **Master SEO & Copywriting Architecture Blueprint** in structured Markdown tables and clear modules:

1. **The 21-URL Master Keyword & Intent Matrix:** A complete table covering all 16 pages and 5 blog posts with columns for:
   - `URL`
   - `Page Role & Funnel Stage`
   - `Primary Target Keyword (UK)`
   - `Secondary Semantic Keywords`
   - `Search Intent`
   - `Strict Anti-Cannibalisation Boundary (What this page MUST NOT target)`
   - `Target Word Count & Page Template Structure`
2. **Hub-and-Spoke Internal Linking Map:** Show exactly how the 5 blog posts and supporting pages link into the core commercial conversion pages (`/the-property/`, `/accessibility/`, `/optional-care/`, `/funding-and-support/`, `/enquire/`) with exact WCAG-friendly anchor text examples.
3. **The Flesch > 72 Vocabulary & Rhythm Cheat-Sheet:** A custom guide of 15 common high-syllable care/accessibility words and how we will phrase full, natural sentences around them to keep our Flesch score above 72 without sounding clipped or robotic.
4. **On-Page Metadata & H1 Pack:** Draft the optimised UK `<title>` tag (max 60 chars), `<meta name="description">` (max 155 chars), and `<h1>` for all 21 URLs. Ensure every `<h1>` passes the "Goldilocks" test (warm, specific, guest-first, and point-driven, never vague or blunt).

Wait for my review and approval of this Master Blueprint before we move on to drafting or coding individual page templates.
