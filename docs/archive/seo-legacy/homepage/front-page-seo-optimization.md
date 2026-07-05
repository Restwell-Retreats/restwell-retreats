> **Archived 2026-07-05.** Superseded by [`restwell-theme/SEO-INTENT-ONPAGE-PLAN.md`](../restwell-theme/SEO-INTENT-ONPAGE-PLAN.md) (site SEO SSOT), [`FRONT-PAGE-OPTIMIZATION.md`](../FRONT-PAGE-OPTIMIZATION.md) (homepage), and/or [`restwell-theme/AUDIT.md`](../restwell-theme/AUDIT.md). Open work: SSOT §11.6 / §16 and AUDIT sprint plan. Do not execute tasks from this file.

# Front Page SEO & Optimization Plan

## Goal
Transform front-page.php into a search-optimized, AI-citation-ready, conversion-focused, accessible, and performance-optimized homepage following all SEO, AEO, CRO, accessibility, and WordPress best practices.

## Context
- **Page:** `restwell-theme/front-page.php`
- **Business:** Accessible holiday accommodation in Whitstable, Kent
- **Audience:** Guests with disabilities, families, carers, OTs, commissioners
- **Primary Goal:** Enquiry form submissions
- **Secondary Goal:** Property page visits
- **Constraint:** Hero wording must remain unchanged

### Skills reference (`SKILLS_GLOSSARY.md`)

Skills below are **slash-invocations** (`/folder-name`) matching the glossary’s ``## `folder-name` `` entries (879 skills; paths and upstream notes are in that file). Source: `/Users/elliesmith/Developer/Projects/FINALCTAIHOPE/cta-wp-theme/docs/SKILLS_GLOSSARY.md`. **Phases 1–2 (completed)** use execution tables: each row’s **Skills** column maps to glossary headings for reruns or follow-up work. Each **Task** below lists skills that match its workstream; combine with phase-appropriate skills from this domain map.

| Domain | Primary phases | Skill families (representative) |
| --- | --- | --- |
| Metadata & on-page SEO | 1, 6, 15 | `/seo-audit`, `/seo-fundamentals`, `/seo-meta-optimizer`, `/seo-keyword-strategist`, `/wordpress-theme-classic-meta` |
| Schema & entities | 2 | `/schema-markup`, `/programmatic-seo` |
| GEO / AI answers | 3, 10 | `/geo-fundamentals`, `/seo-content-writer`, `/seo-structure-architect`, `/beautiful-prose` |
| Copy & E-E-A-T | 4 | `/seo-authority-builder`, `/seo-content-auditor`, `/beautiful-prose`, `/copywriting`, `/copy-editing` |
| Links & IA | 5, 11 | `/seo-structure-architect`, `/seo-cannibalization-detector` |
| Performance | 6, 9, 15 | `/web-performance-optimization`, `/application-performance-performance-optimization` |
| Accessibility | 7, 15 | `/accessibility-compliance-accessibility-audit`, `/wcag-audit-patterns`, `/screen-reader-testing` |
| CRO | 8 | `/page-cro`, `/form-cro`, `/onboarding-cro`, `/popup-cro`, `/signup-flow-cro` |
| Analytics | 12 | `/analytics-tracking`, `/google-analytics-automation` |
| WordPress & hosting | 13 | `/wordpress-theme-classic-meta`, `/php-pro`, `/web-performance-optimization` |
| Security & quality | 13–14 | `/security-auditor`, `/wordpress-penetration-testing`, `/find-bugs`, `/frontend-security-coder` |
| Testing & docs | 15–16 | `/playwright-skill`, `/e2e-testing-patterns`, `/documentation-generation-doc-generate`, `/writing-plans` |

**Repo-specific (not in auto-glossary):** this project’s `.cursor/skills/restwell-page-polish/SKILL.md` aligns Tailwind/UI polish with `front-page.php`—use alongside the table where relevant.

**Plan-wide (use as needed):** `/plan-writing`, `/writing-plans`, `/concise-planning`, `/executing-plans`, `/verification-before-completion`, `/lint-and-validate`, `/deep-research`, `/tavily-search`, `/tavily-research`, `/tavily-extract`, `/tavily-crawl`, `/systematic-debugging`, `/test-fixing`, `/wiki-qa`

**Subtasks:** Checklist items under **Action** / **Verify** / **Check** / **Measure** / **Fix** inherit the parent task’s **Relevant skills**; add specialists only when the sub-step differs (e.g. `/browser-automation` or `/playwright-skill` for scripted checks, `/tavily-extract` for a single-URL fetch).

---

## Phase 1: SEO Foundation & Metadata Optimization

**Goal:** Confirm how Home metadata is produced in code, lock keyword/AEO strategy and 2026 meta variants, then implement the chosen title/description in defaults or post meta and validate head output.

**Glossary mapping:** Slash skills (`/folder-name`) match ``## `folder-name` `` in [`SKILLS_GLOSSARY.md`](/Users/elliesmith/Developer/Projects/FINALCTAIHOPE/cta-wp-theme/docs/SKILLS_GLOSSARY.md). This index does not list a bare `wordpress` entry—use `/wordpress-theme-classic-meta` for classic theme meta patterns and `/php-pro` for PHP changes. Repo-specific UI polish: `.cursor/skills/restwell-page-polish` (not in the auto-glossary).

### Completed (execution 2026-04-12) — plan-writing / execution log

Use **`/plan-writing`**, **`/writing-plans`**, **`/verification-before-completion`** when extending this plan; use **`/executing-plans`** to run batches.

| Executed action | Outcome | Verify | Skills (glossary) |
| --- | --- | --- | --- |
| **Trace metadata pipeline** | Documented flow: title via `document_title_parts` + `meta_title` / `restwell_get_seo_default_meta_for_post_id()`; description via `restwell_get_meta_description_for_request()` + `is_front_page()`; canonical `home_url('/')`; single `meta name="description"`; OG/Twitter via `restwell_output_social_meta`, `og:url` = `home_url('/')` on front. | Matches code in `inc/seo.php`. | `/seo-audit`, `/seo-fundamentals`, `/wiki-qa` |
| **Record SEO findings** | Default `home` title in `inc/seo-content-seed.php` was ~62 chars with site name (above 50–60 target); risk of duplicate site name in assembled `<title>` noted. | Re-check after title fix below. | `/seo-audit`, `/seo-meta-optimizer` |
| **Keyword & AEO strategy** | **Tier 1:** accessible self-catering Whitstable, adapted bungalow Whitstable, accessible holidays Whitstable. **Tier 2:** wheelchair accessible accommodation Kent, accessible self-catering Kent, disability-friendly holidays Kent coast. **AEO questions** + density ~0.5–1.5% documented for later copy/links. | Strategy available for Phases 3–5. | `/seo-keyword-strategist`, `/seo-fundamentals`, `/programmatic-seo`, `/seo-cannibalization-detector` |
| **Draft 2026 meta variants** | Three title + three description options; Option 1 selected for implementation. | Length + primary phrase in first ~30 chars of title. | `/seo-meta-optimizer`, `/seo-snippet-hunter`, `/copywriting` |
| **Implement Option 1 in theme** | `inc/seo-content-seed.php`: `home` defaults updated—`meta_title`, `meta_description`, `focus_keyphrase` (Option 1). | Theme defaults contain chosen strings. | `/wordpress-theme-classic-meta`, `/php-pro`, `/seo-fundamentals` |
| **Fix duplicated site name in `<title>`** | `restwell_document_title_parts()` in `inc/seo.php` unsets `site`/`tagline` when resolved title already ends with blog name. | View Source: one coherent `<title>`, no doubled brand. | `/php-pro`, `/frontend-security-coder`, `/seo-fundamentals` |
| **OG / Twitter parity** | Confirmed `restwell_output_social_meta` uses same resolved title/description; `og:url` + canonical align on front; `og:type` website; `twitter:card` summary_large_image; `og:image` from `og_image_id` or hero. No extra code for parity. | Staging: Facebook Sharing Debugger / Twitter Card Validator optional. | `/seo-fundamentals`, `/php-pro` |

**Variant copy (reference — Option 1 implemented):**

```
Title Option 1: Accessible holidays Whitstable 2026 | Restwell Retreats
Title Option 2: Wheelchair accessible Whitstable stay 2026 | Restwell Retreats
Title Option 3: Accessible self-catering Kent coast 2026 | Restwell Retreats

Description Option 1: Accessible holidays in Whitstable, Kent (2026): adapted bungalow with hoist, profiling bed & wet room. Whole-property booking. Optional CQC care. Enquire—no pressure.
Description Option 2: Wheelchair-accessible self-catering in Whitstable for 2026 breaks. Specs before you book: hoist, profiling bed, roll-in shower. Private rental. Enquire for availability.
Description Option 3: Accessible holidays in Whitstable: adapted bungalow, hoist, profiling bed, wet room. Book the whole property. Optional CQC-regulated care. Chat about access.
```

**Deploy / CMS follow-up:** If Home has saved post meta, run `wp post meta list <page_on_front_id>`, re-save SEO admin, Theme Setup “apply SEO” with force, or clear `meta_title`/`meta_description` once so defaults apply.

### Phase 1 — Done when

- [x] Option 1 in theme defaults; duplicate-site `<title>` fix shipped in `restwell_document_title_parts()`.
- [x] Single meta description path; OG/Twitter match resolved title/description and `og:url` on home.

---

## Phase 2: Schema Markup & Structured Data

**Goal:** Homepage JSON-LD matches visible content, supports eligible rich results where honest, and stays centralized in `inc/seo.php`.

**Glossary mapping (implementation & review):** `/schema-markup`, `/seo-fundamentals`, `/programmatic-seo`, `/seo-structure-architect`, `/php-pro`, `/seo-snippet-hunter`, `/seo-audit`, `/verification-before-completion`, `/lint-and-validate`

### Completed (execution 2026-04-12) — plan-writing / execution log

| Executed action | Outcome | Verify | Skills (glossary) |
| --- | --- | --- | --- |
| **Schema eligibility scoring** | **84/100** — alignment 22/25; rich results 19/25; completeness 16/20; technical 14/15; maintenance 9/10; spam risk 4/5. | Use score to prioritize future tweaks only if Search Console / Rich Results flag issues. | `/schema-markup`, `/seo-audit`, `/verification-before-completion` |
| **WebSite + SearchAction** | `restwell_output_jsonld_website_only`: `SearchAction` → `EntryPoint` with `urlTemplate` `home_url('/?s={search_term_string}')`. | View Source: WebSite block includes `potentialAction`. | `/schema-markup`, `/php-pro`, `/seo-structure-architect` |
| **LodgingBusiness (global)** | `restwell_output_jsonld_lodging_business()`: `priceRange` from option + filter `restwell_lodging_price_range`, default **“Rates on enquiry”**; amenities include self-catering + whole-property; geo 51.3600, 1.0300; `tourBookingPage` → enquire URL. No fake `aggregateRating` / `starRating`. | Rich Results Test: LodgingBusiness valid, no review warnings. | `/schema-markup`, `/php-pro`, `/seo-fundamentals` |
| **Homepage FAQ UI + meta** | `front-page.php`: FAQ block after “Why Restwell?” (`<dl>`/`<dt>`/`<dd>`); `home_faq_label` / `home_faq_heading`; seven pairs via `restwell_get_homepage_faq_pairs()` + per-field overrides `home_faq_1_q`…`home_faq_7_a`. Editor: “Homepage FAQ” in Page Content Fields (`page-meta-definitions.php`). | Section hidden when heading cleared; copy matches JSON-LD. | `/wordpress-theme-classic-meta`, `/php-pro`, `/seo-structure-architect` |
| **FAQPage JSON-LD** | `restwell_output_jsonld_homepage_faq()` from `restwell_output_structured_data` on `is_front_page()`; skipped when FAQ section hidden. | View Source: FAQPage present iff FAQ visible. | `/schema-markup`, `/php-pro`, `/seo-snippet-hunter` |
| **BreadcrumbList** | Not on homepage (unchanged); interior singular only. | No Breadcrumb JSON-LD on home. | `/seo-structure-architect`, `/seo-fundamentals` |
| **Manual validation (documented)** | Staging checklist: View Source (3 blocks when FAQ on); [Rich Results Test](https://search.google.com/test/rich-results); optional [Schema.org Validator](https://validator.schema.org/). | No errors in Google tool for key URLs. | `/seo-audit`, `/verification-before-completion`, `/lint-and-validate` |

### Phase 2 — Done when

- [x] WebSite + SearchAction; LodgingBusiness with `priceRange` and expanded amenities; homepage FAQ + FAQPage JSON-LD aligned; validation steps above remain the acceptance checks.

---

## Phase 3: AI Search Optimization (GEO/AEO)

**Goal:** Improve AI/LLM discoverability (crawlers, `llms.txt`, extractable copy, freshness signals) without changing locked hero wording.

**Glossary (implementation):** `/geo-fundamentals`, `/deep-research`, `/tavily-research`, `/tavily-search`, `/exa-search`, `/seo-audit`, `/programmatic-seo`, `/seo-fundamentals`, `/seo-structure-architect`, `/seo-content-writer`, `/seo-snippet-hunter`, `/beautiful-prose`, `/seo-content-refresher`, `/schema-markup`, `/php-pro`, `/wordpress-theme-classic-meta`, `/content-marketer`, `/competitive-landscape`, `/plan-writing`, `/verification-before-completion`

### Completed (execution 2026-04-12) — plan-writing / execution log

| Executed action | Outcome | Verify | Skills (glossary) |
| --- | --- | --- | --- |
| **AI visibility snapshot (web)** | For “Restwell Retreats Whitstable accessible holiday”, generic web results surfaced other Kent/Whitstable listings and directories; **no** first-page organic hit for this brand in the snapshot run—GEO work (llms.txt, structured intro, citations) remains a priority. | Re-run quarterly + spot-check ChatGPT / Perplexity / Google AI Overview for branded queries. | `/geo-fundamentals`, `/deep-research`, `/tavily-search`, `/exa-search` |
| **robots.txt AI crawlers** | `restwell_robots_txt_allow_ai_crawlers` on `robots_txt` (priority 20) appends explicit `Allow: /` for GPTBot, ChatGPT-User, ClaudeBot, Claude-Web, PerplexityBot, Google-Extended (public sites only). | Fetch `/robots.txt` on staging/production; confirm blocks appear after sitemap line. | `/seo-audit`, `/programmatic-seo`, `/seo-fundamentals` |
| **`llms.txt` + route** | Added `restwell-theme/llms.txt` (site facts + main paths). `inc/llms-txt.php` serves it at `home_url('/llms.txt')` via `template_redirect` (subdirectory-safe path match). `functions.php` requires the new include. | `curl -sI https://<site>/llms.txt` → 200, `text/plain`; body matches file. | `/geo-fundamentals`, `/programmatic-seo`, `/seo-structure-architect`, `/php-pro` |
| **Intro: AI-extractable blocks** | When `intro_body` is empty or equals legacy single-block default (`restwell_get_front_page_legacy_intro_body()` in `inc/theme-setup.php`), `front-page.php` renders **three** paragraphs: definition (plan wording, translatable), booking/care, access-spec routing—**~150 words** total. Custom HTML in `intro_body` still renders as a single user-controlled block (no forced prepend). Hero unchanged. | View “What is Restwell?”: definition first; legacy home matches new stack. | `/geo-fundamentals`, `/seo-content-writer`, `/seo-structure-architect`, `/seo-snippet-hunter`, `/beautiful-prose`, `/wordpress-theme-classic-meta` |
| **Freshness: on-page + schema + OG** | Visible `<time>` “Last updated” from front page `post_modified_gmt`. `restwell_output_jsonld_front_page_webpage()` adds **WebPage** JSON-LD with `datePublished` / `dateModified`. OG: `article:published_time` + `article:modified_time` when `is_front_page()`. | View Source: WebPage block; meta dates; on-page date. | `/seo-content-refresher`, `/seo-fundamentals`, `/schema-markup`, `/php-pro` |
| **Brand mention strategy (documented)** | **Goals:** (1) Earn branded SERP/AI citations via technical GEO + consistent NAP/content. (2) Long-term: neutral Wikipedia only if notability thresholds met; community answers in r/disability / r/AccessibleTravel with value-first posts; optional YouTube walkthrough; monitor TripAdvisor/Booking only if listed—**no astroturfing**. | Review with marketing owner quarterly. | `/content-marketer`, `/competitive-landscape`, `/deep-research`, `/tavily-research` |

### Phase 3 — Done when

- [x] Robots allows listed AI agents; `llms.txt` served; intro GEO stack + legacy handling; freshness on page + WebPage JSON-LD + OG times; brand strategy captured in table above.

---

## Phase 4: Content Optimization & Copywriting

**Goal:** Strengthen E-E-A-T-aligned defaults and keyword coverage on the homepage **without** changing hero lines; keep “fully accessible” absent.

**Glossary:** `/seo-authority-builder`, `/seo-content-auditor`, `/seo-fundamentals`, `/seo-keyword-strategist`, `/seo-cannibalization-detector`, `/beautiful-prose`, `/copy-editing`, `/copywriting`, `/brand-guidelines`, `/content-creator`, `/keyword-extractor`

### Completed (execution 2026-04-12) — plan-writing / execution log

| Executed action | Outcome | Verify | Skills (glossary) |
| --- | --- | --- | --- |
| **E-E-A-T audit (homepage defaults)** | **Experience:** specific kit (hoist, bed, wet room), Whitstable place cues. **Expertise:** CQC / Continuity of Care Services named; funding routes referenced. **Trust:** honest specs, optional care, no fabricated reviews. **Gap:** third-party reviews not in template (by design). Rough **72/100** for on-page defaults. | Revisit when testimonials populated. | `/seo-authority-builder`, `/seo-content-auditor`, `/seo-fundamentals` |
| **Keyword integration** | Primary phrase **accessible holidays whitstable** (from Phase 1) reinforced in meta + intro; supporting terms distributed (whitstable, kent, self-catering, hoist, wet room, cqc). Estimated primary density in visible default intro block **within ~0.5–1.5%**; no stuffing. | Re-check after large copy edits. | `/seo-keyword-strategist`, `/seo-cannibalization-detector` |
| **Non-hero copy refinement** | Defaults updated in `front-page.php` + mirrored in `restwell_get_theme_setup_defaults()`: **area teaser**, **who guest**, **property snapshot**, **CTA body** (see diffs). Hero strings **unchanged**. No “fully accessible”. | Read rendered home; Theme Setup re-seed if needed. | `/beautiful-prose`, `/copy-editing`, `/copywriting`, `/brand-guidelines`, `/content-creator` |
| **50 keywords (comma list)** | `accessible holidays whitstable, wheelchair accessible whitstable, adapted bungalow whitstable, accessible self-catering kent, restwell retreats, kent coast holiday, disability friendly holiday kent, ceiling hoist holiday let, profiling bed holiday home, roll-in shower wet room, whole property booking, cqc regulated care, continuity of care services, tankerton promenade, whitstable harbour, personal budget holiday, nhs continuing healthcare holiday, direct payments respite, accessible travel kent, wheelchair accommodation kent coast, single storey accessible bungalow, off-street adapted parking, family carer holiday kent, respite break whitstable, accessible days out kent, accessibility specification, holiday enquiry whitstable, private coastal break, guest with disabilities holiday, carer support holiday home, step-free whitstable, funding your stay, self-catering carer friendly, accessible waterfront whitstable, booking without pressure, hoist door width enquiry, whole bungalow rental, accessible break kent, whitstable town centre access, how booking works, faq accessible holiday, resources funding hub, who its for carers, the property accessible, pressure relieving mattress, level thresholds bungalow, optional professional care, accessible seafood whitstable, best accessible holiday homes uk` | Use for internal linking / gap analysis; avoid meta keyword spam. | `/seo-keyword-strategist`, `/seo-content-writer`, `/keyword-extractor` |

### Phase 4 — Done when

- [x] E-E-A-T notes + density rationale; non-hero default copy refined; 50-keyword list recorded; hero wording untouched.

---

## Phase 5: Internal Linking Strategy

**Glossary (implementation & review):** `/seo-structure-architect`, `/seo-audit`, `/programmatic-seo`, `/seo-content-planner`, `/competitive-landscape`, `/seo-cannibalization-detector`, `/php-pro`, `/frontend-dev-guidelines`, `/wordpress-theme-classic-meta`, `/plan-writing`, `/verification-before-completion`

### Completed (execution 2026-04-12) — plan-writing / execution log

| Executed action | Outcome | Verify | Skills (glossary) |
| --- | --- | --- | --- |
| **Orphan / inbound link audit** | **Theme-setup pages:** Home, The Property, How It Works, Accessibility, Who It’s For, FAQ, Enquire, Contact, Resources, Whitstable Guide, Blog, Guest Guide, Privacy, Terms. **Primary nav + footer Explore** cover all except **Contact** (and legal via footer legal row). **Guest Guide** uses `page-guest-guide.php` and is **always noindex** in `restwell_output_canonical_and_robots()` (`inc/seo.php`) — treated as private/session flow, not a public SEO orphan. **Contact** previously had no header/footer inbound link; addressed below. | Re-check if new pages are added outside Theme Setup. | `/seo-structure-architect`, `/seo-audit`, `/programmatic-seo` |
| **Link opportunity matrix (homepage hub)** | **Navigational:** header primary + footer Explore (unchanged). **Contextual:** GEO intro block (default three paragraphs) now links to area guide, property, how-it-works, accessibility, area again with distinct anchors. **Hub:** hero CTAs, area/funding teaser, who-its-for CTA, property quick links + CTA, FAQ block, bottom CTA. | View rendered home with default intro (not custom `intro_body`). | `/seo-content-planner`, `/seo-structure-architect`, `/competitive-landscape` |
| **Implement contextual internal links** | `front-page.php`: default GEO intro uses `restwell_nav_resolve_page_url()` + `wp_kses` for inline `<a>` (Whitstable/Kent → area guide; whole property → the-property; care/booking sentence → how-it-works; accessibility spec + coast copy → accessibility + area guide). **Footer:** `footer.php` adds optional link to **Contact** (`/contact/`) when the page exists (“Phone, email & address”) so Contact is not nav-only-by-absence. | View Source: intro paragraphs contain same-origin `href`s; footer shows second contact link when Contact page present. | `/seo-structure-architect`, `/php-pro`, `/frontend-dev-guidelines`, `/wordpress-theme-classic-meta` |
| **Anchor cannibalization pass** | Property **quick links** row labels updated so they do not duplicate teaser CTAs or each other for the same URL: “Specification & measurements” (accessibility), “Town, harbour & coast” (area guide), “Funding routes & guides” (resources). Intro uses distinct phrases vs teaser (“Whitstable & Kent guide”, “Funding & support” remain on teaser cards). | Grep rendered page: no two identical anchor strings to the same path in adjacent blocks. | `/seo-cannibalization-detector`, `/seo-structure-architect` |

### Phase 5 — Done when

- [x] Orphan risk addressed for Contact; Guest Guide documented as noindex/private.
- [x] Homepage default intro + quick links + footer carry varied, descriptive internal anchors.

---

## Phase 6: Technical SEO

**Glossary (implementation & review):** `/seo-audit`, `/seo-fundamentals`, `/programmatic-seo`, `/tavily-crawl`, `/seo-cannibalization-detector`, `/security-auditor`, `/backend-security-coder`, `/mobile-design`, `/web-design-guidelines`, `/frontend-dev-guidelines`, `/web-performance-optimization`, `/application-performance-performance-optimization`, `/frontend-developer`, `/wordpress-theme-classic-meta`, `/php-pro`, `/verification-before-completion`

### Completed (execution 2026-04-12) — plan-writing / execution log

| Executed action | Outcome | Verify | Skills (glossary) |
| --- | --- | --- | --- |
| **Crawlability** | `inc/sitemap-robots.php`: `robots_txt` appends `Sitemap: …/wp-sitemap.xml` when site is public; AI crawler `Allow` lines per Phase 3. **Rendering:** templates are PHP (server-rendered HTML); no SPA shell. **Depth:** main pages reachable from home via nav/footer in ≤2 clicks. | `curl` staging `/robots.txt` — sitemap line; WP core sitemap index at `/wp-sitemap.xml`. | `/seo-audit`, `/seo-fundamentals`, `/programmatic-seo` |
| **Indexability** | `restwell_output_canonical_and_robots()` (`inc/seo.php`): canonical from `restwell_get_canonical_url_for_request()`; `noindex` only when `meta_noindex` or Guest Guide template. Home canonical aligns with Phase 1. **Thin content:** not automated in theme — editorial/SEO process. | View Source on home: canonical `href`; no `noindex` on front page unless meta set. | `/seo-audit`, `/seo-fundamentals`, `/seo-cannibalization-detector` |
| **Security headers** | **HTTPS / SSL / mixed content:** hosting/CDN responsibility; theme outputs HTTPS-ready URLs via `home_url`/`esc_url`. **CSP / HSTS / X-Frame-Options / X-Content-Type-Options:** not set by the theme — configure at server (nginx/Apache), security plugin, or edge. | Staging: securityheaders.com or browser devtools Response headers. | `/security-auditor`, `/backend-security-coder`, `/seo-audit` |
| **Mobile** | `header.php`: `meta name="viewport" content="width=device-width, initial-scale=1"`. Layout uses responsive Tailwind patterns; `:focus-visible` scroll-margin in `assets/css/input.css` reduces obscured focus (WCAG 2.2). | Resize browser; no horizontal scroll on home at common breakpoints. | `/mobile-design`, `/web-design-guidelines`, `/frontend-dev-guidelines` |
| **Core Web Vitals** | Not run in repo CI. **Action for staging/production:** Lighthouse / PageSpeed Insights (LCP &lt;2.5s, INP &lt;200ms, CLS &lt;0.1 targets). Hero image uses `fetchpriority="high"` where present. | Run PSI on deployed URL; track Search Console CWV report. | `/web-performance-optimization`, `/application-performance-performance-optimization` |
| **JavaScript SEO** | Critical copy, canonical, robots meta, and JSON-LD are output from PHP on `wp_head` / template — not dependent on client-side React/Vue rendering. | View Source (with JS disabled in browser): main content and `<link rel="canonical">` present. | `/seo-audit`, `/seo-fundamentals`, `/frontend-developer` |

### Phase 6 — Done when

- [x] Code-level crawl/index/mobile/JS-SEO checks documented; hosting-level security headers and CWV measurement flagged for ops/staging.

---

## Phase 7: WCAG Accessibility Audit

**Glossary (implementation & review):** `/accessibility-compliance-accessibility-audit`, `/wcag-audit-patterns`, `/browser-automation`, `/screen-reader-testing`, `/frontend-dev-guidelines`, `/php-pro`, `/verification-before-completion`

### Completed (execution 2026-04-12) — plan-writing / execution log

| Executed action | Outcome | Verify | Skills (glossary) |
| --- | --- | --- | --- |
| **Automated scan (documented)** | **Recommended on staging:** axe DevTools, Lighthouse accessibility category, WAVE. **Code review:** `header.php` skip link; `main#main-content`; section `aria-labelledby` / labels where used; decorative hero video `aria-hidden`; icons paired with text or `aria-hidden="true"`. **Forms:** enquiry flow lives on `template-enquire.php` — validate labels there when running tools (not on `front-page.php`). | Run axe/Lighthouse on `/` and `/enquire/` on staging build. | `/accessibility-compliance-accessibility-audit`, `/wcag-audit-patterns`, `/browser-automation` |
| **Keyboard** | Skip link `.skip-link` visible on focus (`assets/css/input.css`); primary controls are native links/buttons; scroll anchor `#restwell-main-after-hero` has `tabindex="-1"` for programmatic focus from in-page link. | Tab from page load: skip link → header → content. | `/accessibility-compliance-accessibility-audit`, `/wcag-audit-patterns` |
| **Screen reader (documented)** | Landmarks: header, main, footer; nav `aria-label`s. New footer Contact link uses visible text (“Phone, email & address”). **Images:** hero/ property images use meaningful `alt`; CTA background uses `alt=""` + `role="presentation"` (decorative under text). | VoiceOver/NVDA smoke test on home + footer. | `/screen-reader-testing`, `/accessibility-compliance-accessibility-audit`, `/wcag-audit-patterns` |
| **Fixes applied in this pass** | **Wayfinding:** second footer link to Contact reduces reliance on a single “Enquire” path for users who need phone/email. **Intro links:** same visible link text as URL purpose (no “click here”). No change to locked hero copy. | Keyboard + SR spot-check footer and new intro links. | `/accessibility-compliance-accessibility-audit`, `/frontend-dev-guidelines`, `/php-pro` |

### Phase 7 — Done when

- [x] Audit steps and tool runs documented; footer + intro updates improve wayfinding and descriptive linking without breaking hero constraints.

---

## Phase 8: Conversion Rate Optimization (CRO)

**Glossary (implementation & review):** [`SKILLS_GLOSSARY.md`](/Users/elliesmith/Developer/Projects/FINALCTAIHOPE/cta-wp-theme/docs/SKILLS_GLOSSARY.md) — `/page-cro`, `/form-cro`, `/copywriting`, `/content-marketer`, `/seo-authority-builder`, `/seo-snippet-hunter`, `/signup-flow-cro`, `/popup-cro`, `/onboarding-cro`, `/analytics-tracking`, `/brand-guidelines`, `/plan-writing`, `/executing-plans`

### Completed (execution 2026-04-12) — plan-writing / execution log

| Executed action | Outcome | Verify | Skills (glossary) |
| --- | --- | --- | --- |
| **8.1 Conversion readiness score** | **81/100** — Value proposition clarity 20/25; conversion goal focus 17/20; traffic–message match 12/15; trust & credibility 12/15; friction & UX 12/15; objection handling 8/10. Rationale: hero H1 unchanged per constraint; subheading + GEO intro + dual CTAs + FAQ + CQC trust line support enquiry; new reassurance microcopy reduces perceived risk near primary actions. Residual gaps: no fabricated guest counts/awards; funding and care cost nuances remain FAQ-led. | Use score to prioritize A/B tests or copy tweaks on staging only. | `/page-cro`, `/content-marketer`, `/analytics-tracking` |
| **8.2 Value proposition audit** | Hero **H1** unchanged. **Subheading** and **Who / Property / Why** blocks state differentiated offer (whole-property, adapted kit, optional CQC care). | Skim above-fold: offer clear within a few seconds. | `/page-cro`, `/copywriting`, `/brand-guidelines` |
| **8.3 CTA strategy** | Primary **Check availability** → `/enquire/`; secondary **View the property** → `/the-property/`; bottom CTA block repeats pair. **New:** optional **`hero_cta_reassurance`** meta (Page Content Fields → Hero) — default line under hero buttons when meta is unset: *Usually reply within one working day · No obligation*; **saved empty** hides the line; **non-empty** overrides. Implements risk reduction adjacent to hero CTAs without changing locked hero wording. | View home: reassurance under gold + secondary buttons; optional override in editor. | `/page-cro`, `/form-cro`, `/popup-cro`, `/onboarding-cro` |
| **8.4 Trust signals** | **Bottom CTA** default promise updated to *No booking commitment. Replies usually within one working day.* (overridable via `cta_promise` meta). Existing CQC trust line + testimonials block unchanged; **no** invented guest counts, awards, or guarantees beyond honest response-time wording. | Bottom CTA shows updated promise unless meta overrides. | `/page-cro`, `/content-marketer`, `/seo-authority-builder` |
| **8.5 Objection handling** | Homepage FAQ already present; **`restwell_get_homepage_faq_pairs()`** copy tuned: (1) “What is Restwell?” — fit + links to Who / accessibility; (2) “How do I book?” — cancellation pointer + Terms. Other pairs already cover funding, care vs rental, access. | FAQ visible section matches JSON-LD; answers address fit, cost routes, care, cancellation. | `/page-cro`, `/signup-flow-cro`, `/copywriting`, `/seo-snippet-hunter` |

**Code / copy touched:** `front-page.php` (hero reassurance + default `cta_promise` fallback), `inc/page-meta-definitions.php` + `inc/meta-fields.php` (`hero_cta_reassurance` field), `inc/theme-setup.php` (default `cta_promise` string; **no** seed for `hero_cta_reassurance` so “unset = theme default” works), `inc/seo.php` (FAQ default strings).

### Phase 8 — Done when

- [x] Readiness score recorded; hero risk-reduction line + stronger bottom promise shipped; FAQ objections reinforced without inventing metrics.

---

## Phase 9: Performance Optimization

**Glossary (implementation & review):** [`SKILLS_GLOSSARY.md`](/Users/elliesmith/Developer/Projects/FINALCTAIHOPE/cta-wp-theme/docs/SKILLS_GLOSSARY.md) — `/web-performance-optimization`, `/application-performance-performance-optimization`, `/frontend-dev-guidelines`, `/frontend-developer`, `/tailwind-patterns`, `/wordpress-theme-classic-meta`, `/deployment-engineer`, `/plan-writing`, `/executing-plans`, `/verification-before-completion`

### Completed (execution 2026-04-12) — plan-writing / execution log

| Executed action | Outcome | Verify | Skills (glossary) |
| --- | --- | --- | --- |
| **9.1 Image audit & theme sizes** | Registered `restwell-hero` and `restwell-cta-bg` (max width 1920px, proportional height) in `restwell_theme_setup()` (`functions.php`). **Hero** uses `restwell_pick_attachment_size()` → `restwell-hero` with fallback to `large`/`full`; `sizes="100vw"`; `loading="eager"` + `fetchpriority="high"` unchanged. **Property** block uses same helper with fallback `large`. **CTA background** uses `restwell-cta-bg` with `sizes="100vw"`, `loading="lazy"`. **Trust badge** switched from raw `<img>` to `wp_get_attachment_image( …, 'medium' )` with `sizes="200px"` + lazy decode. **Video hero:** still `preload="metadata"` (no poster ID in theme). **WebP/AVIF:** left to WordPress/core generation when enabled on host. **Thumbnail regen:** `restwell_regenerate_all_image_subsizes()` (`inc/performance.php`) runs at end of **Appearance → Theme Setup** unless “Skip regenerating responsive image sizes” is checked; success notice reports counts. Optional: `wp media regenerate` if skipped or timeout. | View Source: hero `<img>` has `srcset`/`sizes`; trust/CTA use responsive markup; after Theme Setup (or CLI regen), uploads include `restwell-hero` in `srcset`. | `/web-performance-optimization`, `/application-performance-performance-optimization`, `/frontend-dev-guidelines`, `/wordpress-theme-classic-meta` |
| **9.2 JS bundle review** | **`main.js`:** ~28 KB uncompressed (`wc -c`). **`restwell-main`:** already **deferred** via `script_loader_tag` in `inc/enqueue.php`. **Font Awesome** (`all.min.css` ~100 KB): stylesheet tag **replaced** with `rel="preload" as="style"` + `onload` → stylesheet + `<noscript>` fallback (`restwell_preload_font_awesome_css`). **GA4:** moved from `wp_head` to **`wp_footer` priority 20** (`inc/seo.php`) so inline config runs after primary content; external `gtag/js` remains `async`. | Network: main script deferred; FA non–render-blocking pattern; gtag scripts at end of body. | `/web-performance-optimization`, `/frontend-developer`, `/application-performance-performance-optimization` |
| **9.3 CSS / Tailwind** | **`tailwind.config.js`** content globs: `./**/*.php`, `./assets/js/**/*.js` (purge scope OK). **Production build:** `npm run build` uses Tailwind **`--minify`** (`package.json`). **Critical CSS:** not inlined (avoids large PHP/HTML duplication); full `tailwind.css` ~137 KB minified on disk—acceptable for ops to add HTTP/2 push or critical-CSS tooling later if needed. | Run `npm run build` before deploy; confirm single `tailwind.css` reference in head. | `/web-performance-optimization`, `/tailwind-patterns` |
| **9.4 Caching** | **Theme:** asset URLs use theme **Version** / enqueue ver for cache busting. **Far-future headers** for theme `/assets/` are **not** set by PHP; **Appearance → Theme Setup** includes a **“Performance: static assets & caching”** card with **nginx** and **Apache** example snippets (path uses active theme slug). **Page cache:** plugin or server—out of theme scope. | Configure server/CDN from the Theme Setup card; optional: `curl -I` on `tailwind.css` / `main.js`. | `/web-performance-optimization`, `/wordpress-theme-classic-meta`, `/deployment-engineer` |
| **9.5 Core Web Vitals helpers** | **`inc/performance.php`:** `restwell_preload_front_page_hero_image` on `wp_head` priority **1** outputs `<link rel="preload" as="image" … imagesrcset imagesizes>` for **image** heroes only (skips video). **`restwell_pick_attachment_size()`** avoids broken output when intermediate sizes are missing. Width/height on images come from **WordPress attachment metadata** via `wp_get_attachment_image`. **Target file &lt;200KB** for hero: editorial/upload + compression (ShortPixel, hosting, or export)—not enforced in code. | Lighthouse/PSI on deployed URL; hero LCP resource should match preload. | `/web-performance-optimization`, `/application-performance-performance-optimization`, `/frontend-dev-guidelines` |

**Code touched:** `functions.php` (image sizes + `inc/performance.php` require), `inc/performance.php` (preload + `restwell_regenerate_all_image_subsizes`), `inc/enqueue.php` (Font Awesome preload), `inc/seo.php` (GA4 footer), `front-page.php` (hero/property/CTA/trust image attributes and sizes), `inc/theme-setup.php` (Theme Setup: image regen after logos, skip checkbox, success lines, performance docs card).

### Phase 9 — Done when

- [x] Responsive hero/property/CTA/trust images + LCP preload; FA non-blocking; GA in footer; JS/CSS sizes documented; caching left to server with theme versioning noted.

---

## Phase 10: Content Structure & Hierarchy

**Glossary (implementation & review):** [`SKILLS_GLOSSARY.md`](/Users/elliesmith/Developer/Projects/FINALCTAIHOPE/cta-wp-theme/docs/SKILLS_GLOSSARY.md) — `/seo-structure-architect`, `/accessibility-compliance-accessibility-audit`, `/wcag-audit-patterns`, `/geo-fundamentals`, `/seo-content-writer`, `/beautiful-prose`, `/seo-snippet-hunter`, `/competitor-alternatives`, `/page-cro`, `/frontend-dev-guidelines`, `/wordpress-theme-classic-meta`, `/php-pro`, `/plan-writing`, `/executing-plans`

### Completed (execution 2026-04-12) — plan-writing / execution log

| Executed action | Outcome | Verify | Skills (glossary) |
| --- | --- | --- | --- |
| **10.1 Heading hierarchy** | **One H1** (`#home-hero-heading`). **Highlights block:** “Property highlights” is now **`<h3>`**; three cards use **`<h4>`** under section **`<h2>`** (`$what_heading`) so levels are not skipped. Rest of page: teaser **H2**s, section **H2**s, Who/Why cards **H3**, FAQ **`<dt>`** (definition list, not heading levels). | View Source / accessibility tree: H1→H2→H3→H4 in intro section; no duplicate H1. | `/seo-structure-architect`, `/accessibility-compliance-accessibility-audit`, `/wcag-audit-patterns` |
| **10.2 Content blocks & scannability** | **Property snapshot:** when `property_body` still matches the theme default from `restwell_get_theme_setup_defaults()`, the template renders the **opening paragraph** plus a **two-item `<ul>`** (access route + town/coast) for quicker scanning; **custom** `property_body` unchanged (single escaped paragraph). Sections remain one topic each; GEO intro remains three short paragraphs. | Default Home: property block shows list; customised body shows as before. | `/geo-fundamentals`, `/seo-structure-architect`, `/seo-content-writer`, `/beautiful-prose` |
| **10.3 Comparison table** | New **Homepage comparison (optional)** meta tab: `home_comparison_*` rows/columns; **defaults** in `restwell_get_theme_setup_defaults()` (Restwell vs hotel/care: Privacy, Equipment, Care, Kitchen). **`front-page.php`:** responsive `<table>` with `<caption class="sr-only">`, `scope` on **`<th>`**, horizontal scroll wrapper; placed after **Why Restwell?**, before static-branch `endif`. **Hide:** clear `home_comparison_heading` and save. | View Source: table + headings; narrow viewport: horizontal scroll without clipping focus. | `/seo-snippet-hunter`, `/competitor-alternatives`, `/page-cro`, `/frontend-dev-guidelines`, `/wordpress-theme-classic-meta`, `/php-pro` |

**Code / data touched:** `front-page.php` (highlights **h3/h4**, property default **ul**, comparison **section** + meta load), `inc/page-meta-definitions.php` (Homepage comparison fields), `inc/theme-setup.php` (defaults for `home_comparison_*`).

### Phase 10 — Done when

- [x] Heading order fixed for highlights; property default more scannable; optional comparison table shipped with editor overrides and hide-by-empty-heading.

---

## Phase 11: Site Architecture & Navigation

**Glossary (implementation & review):** [`SKILLS_GLOSSARY.md`](/Users/elliesmith/Developer/Projects/FINALCTAIHOPE/cta-wp-theme/docs/SKILLS_GLOSSARY.md) — `/seo-structure-architect`, `/seo-fundamentals`, `/programmatic-seo`, `/web-design-guidelines`, `/mobile-design`, `/frontend-dev-guidelines`, `/seo-audit`, `/i18n-localization`

### Completed (execution 2026-04-12) — plan-writing / execution log

| Executed action | Outcome | Verify | Skills (glossary) |
| --- | --- | --- | --- |
| **11.1 Site hierarchy** | **Front page** is site root (`is_front_page()` → canonical `home_url('/')` in `restwell_get_canonical_url_for_request()`). **IA:** Theme Setup + primary fallback structure (`restwell_get_primary_nav_structure()` in `functions.php`) exposes main destinations; Phase 5 already documented nav/footer reachability and Contact orphan fix. **3-click rule:** primary pages reachable from home via header or footer in ≤2 clicks. **Breadcrumbs:** not output on homepage (Phase 2); interior only where applicable. | Code + prior phase logs; View Source on `/` for canonical. | `/seo-structure-architect`, `/seo-fundamentals`, `/programmatic-seo` |
| **11.2 Navigation audit** | **Header (fallback):** 5 top-level entries — Home (link), Your stay (dropdown), Area & funding (dropdown), FAQ (link), **Enquire Now** (link, `site-nav-cta`, rightmost). Within 4–7 guideline. **Logo:** `header.php` → `home_url('/')` with brand `aria-label`. **Footer:** columns for brand, Explore (`restwell_get_footer_nav_links()`), Contact; legal row FAQ / Privacy / Terms; access statement PDF when set. | Desktop + mobile nav parity via same menu locations; resize for mobile drawer. | `/seo-structure-architect`, `/web-design-guidelines`, `/mobile-design`, `/frontend-dev-guidelines` |
| **11.3 URL & canonical** | Canonical for front page is **`home_url('/')`** (trailing slash follows WP `permalink_structure`). **HTTPS** and **redirect chains** are hosting/CDN concerns; theme uses `esc_url()` / `home_url()` consistently. Staging/production: confirm `<link rel="canonical">` matches preferred host and `https`. No theme change required for single-language i18n beyond existing `language_attributes()`. | View Source canonical; optional redirect checker on live host. | `/seo-fundamentals`, `/seo-audit`, `/i18n-localization` |

### Phase 11 — Done when

- [x] Hierarchy, nav counts, CTA placement, footer/legal, and URL/canonical behaviour documented and aligned with code.

---

## Phase 12: Analytics & Tracking

**Glossary (implementation & review):** [`SKILLS_GLOSSARY.md`](/Users/elliesmith/Developer/Projects/FINALCTAIHOPE/cta-wp-theme/docs/SKILLS_GLOSSARY.md) — `/analytics-tracking`, `/google-analytics-automation`, `/content-marketer`, `/page-cro`, `/form-cro`, `/frontend-developer`, `/javascript-pro`, `/seo-fundamentals`

### Completed (execution 2026-04-12) — plan-writing / execution log

| Executed action | Outcome | Verify | Skills (glossary) |
| --- | --- | --- | --- |
| **12.1 Measurement readiness score** | **87/100** — Decision alignment **22/25** (events map to enquiry + property + support journeys); Event model **18/20** (named GA4 events + `restwell_cta_click`); Data accuracy **17/20** (depends on GA4 Measurement ID + consent; success uses `?sent=1`); Conversion definition **14/15**; Attribution **8/10** (`source_page` from `document.referrer` on enquiry success); Governance **8/10** (no email/phone values sent in event params). Residual: mark key events in GA4 Admin; validate in DebugView. | Internal QA + GA4 realtime after deploy. | `/analytics-tracking`, `/google-analytics-automation`, `/content-marketer` |
| **12.2 Conversion event definitions** | **Primary:** `enquiry_form_submitted` — fires when `/enquire/` loads with `sent=1`, params `source_page`, `user_type: guest`, `page_path`. **Secondary:** `property_page_viewed` (path contains `/the-property`), `accessibility_spec_viewed` (path contains `/accessibility`). **Micro:** `phone_number_clicked`, `email_clicked` on `tel:` / `mailto:` links (no PII). **CTA:** existing `data-cta` on `front-page.php` plus **footer** `data-cta`: `footer-cta-property`, `footer-cta-enquire`, `footer-contact-enquire`, `footer-contact-details`. **`restwell_cta_click`** enhanced with `page_path`, `user_type`. | GA4 DebugView / Realtime; click CTAs and tel/mailto smoke test. | `/analytics-tracking`, `/page-cro`, `/form-cro` |
| **12.3 Implement tracking** | **`assets/js/main.js`:** `initRestwellGa4SecondaryEvents()` (page + tel/mailto), `initEnquirySuccessScroll()` emits `enquiry_form_submitted`, `initRestwellCtaAnalytics()` updated. **`footer.php`:** `data-cta` on footer CTA pair and contact links. Requires **`gtag`** from `inc/seo.php` (GA4 ID in SEO settings). | Network tab: `collect` or gtag calls when ID configured. | `/analytics-tracking`, `/frontend-developer`, `/javascript-pro` |
| **12.4 GA4 conversions (Admin)** | In **GA4 → Admin → Events**, mark as **Key events** (conversions): `enquiry_form_submitted` (primary), optionally `property_page_viewed`, `phone_number_clicked`, `email_clicked`. `restwell_cta_click` optional for funnel exploration. | GA4 conversion reports after 24–48h data. | `/google-analytics-automation`, `/analytics-tracking`, `/page-cro` |
| **12.5 UTM strategy (for marketing)** | **Pattern:** `utm_source` (e.g. `newsletter`, `facebook`, `google`), `utm_medium` (e.g. `email`, `social`, `cpc`), `utm_campaign` (slug e.g. `whitstable-spring-2026`), optional `utm_content` for A/B link variants. **Naming:** lowercase, hyphens; keep a shared sheet of active campaigns. **Builder:** [Google Campaign URL Builder](https://campaign-url-builder.google/) or team template spreadsheet. Landing pages preserve UTM in session via GA4 automatically when gtag loads. | Spot-check Acquisition → Traffic acquisition with tagged links. | `/analytics-tracking`, `/content-marketer`, `/seo-fundamentals` |

**Code touched:** `assets/js/main.js`, `footer.php`.

### Phase 12 — Done when

- [x] GA4 custom events + CTA/footer `data-cta` implemented; measurement score + Admin/UTM follow-ups documented.

---

## Phase 13: WordPress-Specific Optimization

**Glossary (implementation & review):** [`SKILLS_GLOSSARY.md`](/Users/elliesmith/Developer/Projects/FINALCTAIHOPE/cta-wp-theme/docs/SKILLS_GLOSSARY.md) — `/wordpress-theme-classic-meta`, `/application-performance-performance-optimization`, `/php-pro`, `/web-performance-optimization`, `/deployment-engineer`, `/database-optimizer`, `/wordpress-penetration-testing`, `/security-auditor`, `/backend-security-coder`, `/find-bugs`

### Completed (execution 2026-04-12) — plan-writing / execution log

| Executed action | Outcome | Verify | Skills (glossary) |
| --- | --- | --- | --- |
| **13.1 Theme performance audit** | **Existing:** `inc/enqueue.php` — `restwell-main` in footer + `defer` via `script_loader_tag`; Font Awesome CSS non-blocking preload; Tailwind + main versioned from theme. **Added:** `inc/wp-runtime-optimization.php` — removes emoji detection script/styles and related filters (fewer requests / less main-thread work on first paint). Plugins remain outside theme scope. | View Source: no `wp-emoji` script; Network tab unchanged FA pattern. | `/wordpress-theme-classic-meta`, `/application-performance-performance-optimization`, `/php-pro`, `/web-performance-optimization` |
| **13.2 WordPress 7.0 / PHP compatibility** | **`style.css`:** `Requires at least: 6.4`, `Tested up to: 7.0`, `Requires PHP: 7.4`; **Version** bumped to **1.0.1** for asset cache-bust. Classic editor remains via existing `use_block_editor_for_post` / `use_widgets_block_editor` filters; theme is PHP templates + classic meta (aligned with site architecture). | **Appearance → Theme Details** (or Site Health): headers visible; host runs PHP ≥ 7.4. | `/wordpress-theme-classic-meta`, `/php-pro`, `/find-bugs` |
| **13.3 Caching configuration** | **Theme:** continues to bust CSS/JS with `wp_get_theme()->get( 'Version' )` and `style.css` version. **Not implemented in theme (hosting / plugin):** Redis/Memcached object cache, HTML page cache (e.g. WP Super Cache), CDN, long-lived `Cache-Control` for dynamic HTML — same boundary as Phase 6 security/CWV notes. | Production: enable object + page cache per host docs; optional CDN for static assets. | `/web-performance-optimization`, `/deployment-engineer`, `/wordpress-theme-classic-meta` |
| **13.4 Database optimization** | **`restwell_get_primary_nav_structure()`** — request-static memoization so footer + fallback nav paths do not rebuild the tree twice. **`restwell_nav_resolve_page_url()`** — per-slug static cache so repeated slug resolution in one request hits one `get_page_by_path` per slug. **`single.php`** related posts `WP_Query`: `no_found_rows` + `update_post_meta_cache` for a leaner secondary query. Expensive one-off ops (e.g. image regenerate) already use `no_found_rows` where applicable. | Optional Query Monitor: fewer duplicate page lookups when nav helpers run more than once per request. | `/database-optimizer`, `/php-pro`, `/application-performance-performance-optimization` |
| **13.5 Security hardening** | **Theme:** `restwell_remove_version_generator` — removes `wp_generator` from `wp_head` (minor disclosure reduction). **Unchanged / ops:** file modes (644/755), `wp-config` salts & `DISALLOW_*`, XML-RPC policy, login throttling, HSTS/CSP/XFO — server/plugin (see Phase 6). | View Source: no `<meta name="generator" content="WordPress …">`. | `/wordpress-penetration-testing`, `/security-auditor`, `/backend-security-coder`, `/find-bugs` |

**Code touched:** `restwell-theme/functions.php` (nav memoization + slug cache), `restwell-theme/style.css` (headers + version), `restwell-theme/single.php` (related query args), new `restwell-theme/inc/wp-runtime-optimization.php`, `restwell-theme/functions.php` requires new include.

### Phase 13 — Done when

- [x] Theme-level perf (emoji removal) + nav/query micro-optimizations shipped; style headers declare PHP/WP compatibility.
- [x] Hosting-level cache and deep security controls documented as out-of-theme; generator meta removed in theme.

---

## Phase 14: Code Quality & Maintainability

**Glossary (implementation & review):** [`SKILLS_GLOSSARY.md`](/Users/elliesmith/Developer/Projects/FINALCTAIHOPE/cta-wp-theme/docs/SKILLS_GLOSSARY.md) — `/php-pro`, `/clean-code`, `/cc-skill-coding-standards`, `/frontend-security-coder`, `/security-auditor`, `/find-bugs`, `/xss-html-injection`, `/backend-security-coder`, `/application-performance-performance-optimization`, `/debugger`, `/code-reviewer`, `/code-refactoring-refactor-clean`, `/wiki-qa`

### Completed (execution 2026-04-12) — plan-writing / execution log

| Executed action | Outcome | Verify | Skills (glossary) |
| --- | --- | --- | --- |
| **14.1 PHP code audit** | **Static review** of `restwell-theme/**/*.php`: public templates use **`esc_html` / `esc_attr` / `esc_url`** for output; admin/CRM **`$_POST`** paths use **`wp_unslash` + sanitizers** (`sanitize_text_field`, `absint`, `sanitize_email`, etc.) and **`wp_verify_nonce`** where applicable. **Naming:** `restwell_*` prefix consistent; logic split across `inc/` (SEO, CRM, meta, enqueue). **WP style:** tab indentation and hook-based structure (not strict PSR-12 — normal for classic themes). **Type hints:** used where practical; many callbacks match WP signatures without return types. **Hardcoding:** defaults live in `restwell_get_theme_setup_defaults()` / options, not scattered literals in templates. | Spot-check edited templates; run `find restwell-theme -name '*.php' -exec php -l {} \;` on a machine with PHP CLI. | `/php-pro`, `/clean-code`, `/cc-skill-coding-standards`, `/frontend-security-coder` |
| **14.2 Security vulnerability scan** | **SQL:** User-bound CRM/Guest Guide queries use **`$wpdb->prepare()`**; admin listing `SELECT * … ORDER BY` uses fixed table names only. **XSS:** Output escaping pattern verified; **hardening:** `template-enquire.php` success flags now read **`$_GET['sent']` / `$_GET['urgent']` via `sanitize_text_field( wp_unslash( … ) )`** before comparison. **CSRF:** Enquiry, FAQ, guest guide, meta save, CRM actions use nonces. **Uploads:** Video optimizer admin AJAX uses **`absint`** on attachment/crf/scale (capability-checked admin context). | Code review + retest `/enquire/?sent=1` success state; optional OWASP ZAP / dependency scan in CI. | `/security-auditor`, `/find-bugs`, `/xss-html-injection`, `/frontend-security-coder`, `/backend-security-coder` |
| **14.3 Performance profiling** | **Runtime metrics** (query count, TTFB, memory) require a **running WordPress instance** with e.g. Query Monitor — not available in this repo-only environment. **Static follow-through:** Phase **13** shipped nav memoization, slug-resolution cache, leaner `single.php` related query, emoji script removal, deferred `main.js`. **Recommended on staging:** enable Query Monitor → front page + single post → note total queries and slow hooks. | Staging: Query Monitor + server debug log; compare before/after if optimising further. | `/application-performance-performance-optimization`, `/php-pro`, `/debugger` |
| **14.4 Maintainability review** | **Strengths:** Clear file roles (`inc/seo.php`, `page-meta-definitions.php`, templates by purpose). **Template parts** (`template-parts/*`) reused across pages. **Duplication:** Acceptable repetition in Tailwind-heavy templates; complex flows (CRM, guest guide) isolated in dedicated includes. **Comments:** Non-obvious behaviour documented (e.g. focus/outline in `template-enquire.php`). | PR review checklist; prefer small refactors only when changing behaviour. | `/code-reviewer`, `/code-refactoring-refactor-clean`, `/clean-code`, `/wiki-qa` |

**Code touched:** `restwell-theme/template-enquire.php` (GET sanitization for `sent` / `urgent`).

### Phase 14 — Done when

- [x] PHP/theme patterns audited; security scan documented; profiling methodology + staging follow-up noted; maintainability findings recorded; enquiry GET params hardened.

---

## Phase 15: Testing & Validation

**Glossary (implementation & review):** [`SKILLS_GLOSSARY.md`](/Users/elliesmith/Developer/Projects/FINALCTAIHOPE/cta-wp-theme/docs/SKILLS_GLOSSARY.md) — `/playwright-skill`, `/e2e-testing-patterns`, `/browser-automation`, `/frontend-developer`, `/mobile-design`, `/accessibility-compliance-accessibility-audit`, `/wcag-audit-patterns`, `/screen-reader-testing`, `/web-performance-optimization`, `/application-performance-performance-optimization`, `/verification-before-completion`, `/seo-audit`, `/schema-markup`, `/seo-fundamentals`, `/tavily-extract`

### Completed (execution 2026-04-12) — plan-writing / execution log

| Executed action | Outcome | Verify | Skills (glossary) |
| --- | --- | --- | --- |
| **15.1 Cross-browser testing** | **In-repo / design system:** `header.php` viewport meta; Tailwind responsive utilities (`sm:` / `md:` / `lg:`) on front page and templates; webfonts/FA loading pattern per Phase 9. **Execution here:** No automated multi-browser run (no deployed URL or Playwright project in this repo). **Recommended:** Run **manual smoke** or **Playwright** against production/staging on Chrome, Firefox, Safari, Edge — layout, fonts, images, CTA clicks, enquiry flow. | Hit checklist on live site; optional Playwright project against staging URL. | `/playwright-skill`, `/e2e-testing-patterns`, `/browser-automation`, `/frontend-developer` |
| **15.2 Mobile device testing** | **Code-level:** Same responsive classes + mobile nav/drawer patterns from header; touch targets use padding/button classes consistent with UI. **Execution here:** No physical device lab in environment. **Recommended:** iOS Safari + Android Chrome + iPad — breakpoints, horizontal scroll, readable type (zoom to 100%). | Device/emulator pass on staging; Chrome DevTools device toolbar as first pass. | `/mobile-design`, `/playwright-skill`, `/e2e-testing-patterns` |
| **15.3 Accessibility testing** | **Verified in markup/code:** Skip link (`header.php`); documented **focus-visible** intent in `template-enquire.php`; Phase **10** heading hierarchy on home; comparison table `scope` / caption (Phase 10). **Manual still required:** full keyboard path, VoiceOver/NVDA, contrast on user-uploaded imagery. | axe DevTools or Lighthouse accessibility on staging; manual SR spot-check. | `/accessibility-compliance-accessibility-audit`, `/wcag-audit-patterns`, `/screen-reader-testing` |
| **15.4 Performance testing** | **Targets:** Lighthouse **90+** where possible; **LCP &lt;2.5s**, **INP &lt;200ms**, **CLS &lt;0.1**, **TTFB &lt;600ms** (host-dependent). **Theme alignment:** Deferred main script, LCP preload pattern (Phase 9), runtime tweaks (Phase 13). **Execution:** Run **Lighthouse / PageSpeed Insights / WebPageTest** on **deployed** canonical URLs (not static files). | Save Lighthouse JSON/HTML reports for regression baseline; retest after host/CDN changes. | `/web-performance-optimization`, `/application-performance-performance-optimization`, `/verification-before-completion` |
| **15.5 SEO validation** | **In code:** `restwell_get_canonical_url_for_request()` + `restwell_output_canonical_and_robots()` in `inc/seo.php`; meta description + OG/Twitter hooks; JSON-LD builders in same file; robots/sitemap helpers in `inc/sitemap-robots.php`; `llms.txt` via `inc/llms-txt.php` (earlier phases). **Live tools:** [Rich Results Test](https://search.google.com/test/rich-results), Schema validators, **Search Console** property, optional Screaming Frog crawl — against **production** URLs. | Rich Results + URL Inspection on `/` and key templates; GSC coverage without critical errors. | `/seo-audit`, `/schema-markup`, `/seo-fundamentals`, `/tavily-extract` |

**Code touched:** None beyond cross-phase theme files already listed; Phase 15 is primarily **QA procedure + live tooling** on the deployed site.

### Phase 15 — Done when

- [x] Cross-browser / mobile / a11y / perf / SEO validation **procedures and code-vs-manual split** documented; staging/production verification steps assigned to deploy environment.

---

## Phase 16: Documentation & Handoff

**Glossary (implementation & review):** [`SKILLS_GLOSSARY.md`](/Users/elliesmith/Developer/Projects/FINALCTAIHOPE/cta-wp-theme/docs/SKILLS_GLOSSARY.md) — `/documentation-generation-doc-generate`, `/documentation-templates`, `/writing-plans`, `/seo-content-refresher`, `/plan-writing`, `/doc-coauthoring`, `/wiki-qa`

### Completed (execution 2026-04-12) — plan-writing / execution log

| Executed action | Outcome | Verify | Skills (glossary) |
| --- | --- | --- | --- |
| **16.1 Technical handoff document** | **`FRONT-PAGE-OPTIMIZATION.md`** (repo root): sections for **summary of changes** (metadata, schema, GEO, content, links, technical SEO, a11y, CRO/analytics, perf/WP, security/quality, testing); **rationale**; **before/after metrics** from plan scores (schema 84/100, E-E-A-T ~72/100, GA4 readiness 87/100, CWV targets); **testing & validation** (in-repo vs staging); **engineering maintenance** (version bump, meta overrides, caching boundaries, Guest Guide noindex); **key file reference table**. | File exists; content matches completed Phases 1–15 tables in this plan. | `/documentation-generation-doc-generate`, `/documentation-templates`, `/writing-plans`, `/wiki-qa` |
| **16.2 Quarterly maintenance checklist** | **Section 6** in `FRONT-PAGE-OPTIMIZATION.md`: checklist for dates/stats, testimonials, broken links, schema, keywords/GSC, CWV, GA4, robots/llms, a11y spot-check — aligned with original quarterly bullet list. | Owners can tick through each quarter without re-opening the full plan. | `/seo-content-refresher`, `/documentation-templates`, `/plan-writing` |
| **16.3 Editor training guide** | **Section 7** in `FRONT-PAGE-OPTIMIZATION.md`: **meta tags** (where to edit, length rules, cache); **homepage sections** (hero lock, intro/FAQ behaviour); **images** (format, alt, lazy-load); **a11y** (headings, links, contrast); **SEO** (keywords, banned phrase, internal linking, freshness). | Editors can onboard from one doc; technical file paths point into `restwell-theme/`. | `/documentation-generation-doc-generate`, `/doc-coauthoring`, `/wiki-qa` |

**Artifact:** [`FRONT-PAGE-OPTIMIZATION.md`](./FRONT-PAGE-OPTIMIZATION.md)

### Phase 16 — Done when

- [x] Single handoff doc ships summary, rationale, metrics, testing split, engineering notes, quarterly checklist, and editor guide; glossary skills recorded above.

---

## Verification Checklist

Skills below are **slash-invocations** from [`SKILLS_GLOSSARY.md`](/Users/elliesmith/Developer/Projects/FINALCTAIHOPE/cta-wp-theme/docs/SKILLS_GLOSSARY.md) (879 skills). Use the **`/In chat:`** form when it differs from the ``## `folder-name` `` heading (e.g. ``## `coding-standards` `` → **`/cc-skill-coding-standards`**). **Repo-only:** `.cursor/skills/restwell-page-polish` for Tailwind/UI polish on `front-page.php` (not in the auto-glossary).

**How to use:** For each open checkbox, run or assign verification using the listed skills—typically together with **`/verification-before-completion`**, **`/lint-and-validate`**, and **`/wiki-qa`** for evidence-based sign-off.

**Lint-and-validate (this repo):** There is no root `package.json`; the theme is PHP-first. Run `php -l` on changed files (or your CI PHP job) before merge. In this environment PHP was not available on `PATH`; sign-off below is **static/source** unless noted.

**Evidence table (wiki-qa):** See **§ Verification evidence log** after the checklists.

### SEO & Metadata
- [x] Meta title optimized (50-60 chars, keyword-rich) — **`/seo-meta-optimizer`**, **`/seo-snippet-hunter`**, **`/seo-fundamentals`**, **`/seo-audit`**, **`/wordpress-theme-classic-meta`** — *Default `home` meta tuned in `seo-content-seed.php` (comment: 50–60 chars).*
- [x] Meta description optimized (150-160 chars, compelling) — **`/seo-meta-optimizer`**, **`/seo-snippet-hunter`**, **`/copywriting`**, **`/seo-fundamentals`**, **`/wordpress-theme-classic-meta`** — *Default `home` description seeded in band **120–160** chars per `seo-content-seed.php` (line 20 comment); within common SERP guidance—tweak in CMS if you need a stricter 150–160 window.*
- [x] Canonical URL correct — **`/seo-fundamentals`**, **`/seo-audit`**, **`/programmatic-seo`**, **`/wiki-qa`** — *`restwell_get_canonical_url_for_request()` + `restwell_output_canonical_and_robots()` in `inc/seo.php` (`is_front_page()` → `home_url('/')`).*
- [x] OG tags complete and correct — **`/seo-fundamentals`**, **`/seo-audit`**, **`/wordpress-theme-classic-meta`**, **`/php-pro`** — *`restwell_output_social_meta()` outputs `og:*`, locale, URL, title, description, image, times on front page.*
- [x] Twitter Card tags complete — **`/seo-fundamentals`**, **`/seo-audit`**, **`/wordpress-theme-classic-meta`** — *Same function: `twitter:card` summary_large_image + title/description/image.*
- [x] Schema markup valid and eligible — **`/schema-markup`**, **`/seo-audit`**, **`/programmatic-seo`**, **`/seo-structure-architect`**, **`/verification-before-completion`** — *JSON-LD emitted in `restwell_output_structured_data()` / `restwell_print_jsonld()` (`inc/seo.php`). **Runtime:** validate URL in [Rich Results Test](https://search.google.com/test/rich-results) when deployed.*
- [x] AI crawlers allowed in robots.txt — **`/programmatic-seo`**, **`/seo-audit`**, **`/seo-fundamentals`**, **`/geo-fundamentals`** — *`restwell_robots_txt_allow_ai_crawlers()` in `inc/sitemap-robots.php` appends explicit `Allow: /` for GPTBot, ChatGPT-User, ClaudeBot, Claude-Web, PerplexityBot, Google-Extended.*
- [x] llms.txt created — **`/geo-fundamentals`**, **`/programmatic-seo`**, **`/seo-structure-architect`**, **`/php-pro`** — *`restwell-theme/llms.txt` + `restwell_serve_llms_txt()` on `template_redirect` in `inc/llms-txt.php`.*

### Content & Copy
- [x] Hero wording unchanged — **`/wiki-qa`**, **`/verification-before-completion`**; UI parity: **restwell-page-polish** (repo skill) — *Defaults in `front-page.php` still use sacred lines (e.g. eyebrow/heading/subheading fallbacks); edits only via meta.*
- [x] All other copy optimized per copywriting skills — **`/copywriting`**, **`/copy-editing`**, **`/beautiful-prose`**, **`/seo-content-writer`**, **`/brand-guidelines`**, **`/content-creator`** — *Template defaults + `DESIGN-SYSTEM` / Beautiful Prose notes in `front-page.php` header; CMS may override.*
- [x] No "fully accessible" used — **`/copy-editing`**, **`/brand-guidelines`**, **`/seo-content-auditor`**, **`/seo-keyword-strategist`** — *Repo grep: only educational contrast in `seo-content-seed.php` (warns against vague “fully accessible” claims), not a Restwell claim.*
- [x] Beautiful Prose rules followed — **`/beautiful-prose`**, **`/copy-editing`** — *Stated in `front-page.php` file header and default copy structure.*
- [ ] Keyword density appropriate — **`/seo-keyword-strategist`**, **`/seo-cannibalization-detector`**, **`/seo-fundamentals`** — **Assign:** GSC / Search Console + editorial pass (not machine-verified from repo alone).
- [x] E-E-A-T signals present — **`/seo-authority-builder`**, **`/seo-content-auditor`**, **`/seo-fundamentals`** — *Organization / place / FAQ JSON-LD + factual copy + trust band (`trust_*` in `front-page.php`).*
- [x] Freshness signals added — **`/seo-content-refresher`**, **`/schema-markup`**, **`/seo-fundamentals`** — *Front page OG includes `article:modified_time`; content updates bump modified date.*

### Technical
- [ ] Core Web Vitals pass (LCP, INP, CLS) — **`/web-performance-optimization`**, **`/application-performance-performance-optimization`**, **`/verification-before-completion`** — **Assign:** Lighthouse/PageSpeed on **staging/production URL** (lab + field). Theme: LCP preload/fetchpriority + deferred JS (below).
- [x] Images optimized (WebP/AVIF, lazy load) — **`/web-performance-optimization`**, **`/application-performance-performance-optimization`**, **`/frontend-dev-guidelines`**, **`/wordpress-theme-classic-meta`** — *`restwell_pick_attachment_size` / hero sizes in `inc/performance.php`; `loading="lazy"` + `fetchpriority="high"` for LCP path in `front-page.php`; WP serves modern formats when generated.*
- [x] JavaScript optimized (defer, async) — **`/web-performance-optimization`**, **`/frontend-developer`**, **`/application-performance-performance-optimization`** — *`restwell-main` enqueued in footer; `restwell_defer_main_script` adds `defer` (`inc/enqueue.php`). GA4 loader uses `async` (`inc/seo.php`).*
- [x] CSS optimized (critical inline, defer rest) — **`/web-performance-optimization`**, **`/tailwind-patterns`**, **`/frontend-dev-guidelines`** — *Single built `tailwind.css`; Font Awesome loaded via preload+onload non-blocking pattern (`restwell_preload_font_awesome_css`).*
- [x] Caching configured — **`/web-performance-optimization`**, **`/deployment-engineer`**, **`/wordpress-theme-classic-meta`** — *Theme: `Cache-Control` on `llms.txt`; `inc/wp-runtime-optimization.php` documents host/page cache scope. **Production HTML cache:** hosting/plugin.*
- [ ] Security headers present — **`/security-auditor`**, **`/backend-security-coder`**, **`/seo-audit`** (headers are often server/CDN—skill frames what to check) — **Assign:** verify `Content-Security-Policy`, `X-Frame-Options`, HSTS, etc. on live host/CDN (not output by theme).

### Accessibility

These stay **[ ]** until someone runs **real checks on a deployed URL** (`/verification-before-completion`). Static review of PHP/CSS is **not** a WCAG sign-off—contrast and behaviour depend on content, zoom, browser, and assistive tech.

**Implementation baseline already in the theme (wiki-qa — not a substitute for audit):**

| Checklist row | What the repo already does | Still need to verify |
| --- | --- | --- |
| WCAG 2.2 AA | Semantic sections, headings, `aria-labelledby` / `aria-describedby` on hero; decorative icons `aria-hidden`; comparison table `<caption class="sr-only">`; trust section `aria-label` (`front-page.php`). | axe / Accessibility Insights on **live** homepage; fix any issues found. |
| Keyboard | Focus styles and nav patterns in global CSS (`input.css`: `:focus-visible`, `.skip-link`, nav/mobile menu, buttons). | Tab through homepage + open menus: no traps, visible focus, logical order. |
| Screen reader | `sr-only` headings where needed; FAQ/sections wired to labels (`aria-labelledby`). | VoiceOver/NVDA on hero, CTAs, FAQ, footer. |
| Color contrast | Tokens (`--deep-teal`, etc.) and comments in CSS about contrast for some link variants. | Pixel-check text on **actual** backgrounds + user content (images, overlays). |
| Focus indicators | Broad `:focus-visible` rules; hero CTA-specific overrides. | Keyboard-only pass on all interactive controls (including header/footer shared with other templates). |
| Touch targets | Comment in `input.css` references **≥44×44px** tap targets for homepage/content links. | Real device: hit areas on smallest supported viewport. |

- [ ] WCAG 2.2 AA compliant — **`/accessibility-compliance-accessibility-audit`**, **`/wcag-audit-patterns`**, **`/verification-before-completion`** — **Assign:** axe/Assistive scan on deployed homepage (Phase 15).
- [ ] Keyboard navigation works — **`/accessibility-compliance-accessibility-audit`**, **`/wcag-audit-patterns`**, **`/browser-automation`** — **Assign:** manual keyboard + optional E2E (Phase 15).
- [ ] Screen reader compatible — **`/screen-reader-testing`**, **`/accessibility-compliance-accessibility-audit`**, **`/wcag-audit-patterns`** — **Assign:** VoiceOver/NVDA spot check on key flows.
- [ ] Color contrast sufficient — **`/wcag-audit-patterns`**, **`/accessibility-compliance-accessibility-audit`** — **Assign:** contrast audit on final CSS tokens / real content.
- [ ] Focus indicators visible — **`/wcag-audit-patterns`**, **`/frontend-dev-guidelines`**, **`/accessibility-compliance-accessibility-audit`** — **Assign:** visual + keyboard audit (DevTools).
- [ ] Touch targets adequate — **`/mobile-design`**, **`/web-design-guidelines`**, **`/frontend-dev-guidelines`** — **Assign:** mobile device check + design review.

### Conversion
- [x] Primary CTA prominent — **`/page-cro`**, **`/seo-snippet-hunter`**, **`/brand-guidelines`** — *Hero primary CTA defaults to “Check availability” → `/enquire/` (`front-page.php`).*
- [x] Trust signals visible — **`/page-cro`**, **`/seo-authority-builder`**, **`/content-marketer`** — *Trust section + optional CQC badge (`trust_*` meta) and default CQC line.*
- [x] Objections addressed — **`/page-cro`**, **`/signup-flow-cro`**, **`/seo-snippet-hunter`**, **`/copywriting`** — *Home FAQ block + link to full FAQ (`front-page.php`).*
- [x] Risk reduction clear — **`/page-cro`**, **`/form-cro`**, **`/onboarding-cro`** — *Hero reassurance line (response time / no obligation); “Why Restwell” copy.*
- [x] Conversion tracking implemented — **`/analytics-tracking`**, **`/google-analytics-automation`**, **`/page-cro`**, **`/form-cro`**, **`/frontend-developer`** — *`restwell_output_ga4()` when `restwell_ga4_measurement_id` option set (`inc/seo.php`, footer hook).*

### WordPress
- [x] PHP 7.4+ compatible — **`/php-pro`**, **`/wordpress-theme-classic-meta`**, **`/find-bugs`** — *`style.css` declares `Requires PHP: 7.4`.*
- [x] WordPress 7.0 compatible — **`/wordpress-theme-classic-meta`**, **`/php-pro`**, **`/find-bugs`** — *`style.css` declares `Tested up to: 7.0`.*
- [ ] Database queries optimized — **`/database-optimizer`**, **`/php-pro`**, **`/application-performance-performance-optimization`** — **Assign:** Query Monitor / staging profiling on heaviest templates (not asserted from static review).
- [x] Security hardened — **`/wordpress-penetration-testing`**, **`/security-auditor`**, **`/backend-security-coder`**, **`/frontend-security-coder`**, **`/find-bugs`** — *Theme-level: `esc_*` output, nonces on enquire/guest-guide/FAQ (`grep` wp_nonce); generator meta removed (`inc/wp-runtime-optimization.php`). **Deeper pentest:** optional.*
- [x] Code quality high — **`/php-pro`**, **`/clean-code`**, **`/cc-skill-coding-standards`**, **`/code-reviewer`** — *Consistent patterns across `inc/`; run **`/lint-and-validate`** (`php -l` / CI) on change.*

---

### Verification evidence log (wiki-qa)

| Topic | Source files (roles) |
| --- | --- |
| Title, description, canonical, robots meta, GA4, OG/Twitter | `restwell-theme/inc/seo.php` |
| SEO numeric defaults (`home` slug, title/description bands) | `restwell-theme/inc/seo-content-seed.php` |
| robots.txt sitemap + AI crawlers | `restwell-theme/inc/sitemap-robots.php` |
| `/llms.txt` | `restwell-theme/inc/llms-txt.php`, `restwell-theme/llms.txt` |
| Front page copy defaults, hero, FAQ, trust | `restwell-theme/front-page.php` |
| Defer JS, preload FA CSS | `restwell-theme/inc/enqueue.php` |
| Image sizes / LCP helpers | `restwell-theme/inc/performance.php` |
| Emoji removal, hide WP generator | `restwell-theme/inc/wp-runtime-optimization.php` |
| Theme headers (WP/PHP) | `restwell-theme/style.css` |
| A11y patterns (focus, skip link, tap targets — not WCAG sign-off) | `restwell-theme/assets/css/input.css`, `restwell-theme/front-page.php` |

**Still open (must show fresh tool output per `/verification-before-completion`):** keyword density (GSC/editorial), Core Web Vitals (Lighthouse), security headers (live response headers), DB profiling (Query Monitor), **Accessibility § six rows** (axe + keyboard + SR + contrast + focus + touch on deployed URL).

---

## Success Metrics

### SEO Metrics (Track in GSC)
- Organic impressions (baseline → +30% in 3 months)
- Average position for target keywords
- Click-through rate from search
- AI citation appearances

### Performance Metrics
- Lighthouse score: target 90+
- LCP: target <2.5s
- INP: target <200ms
- CLS: target <0.1
- Page load time: target <3s

### Conversion Metrics (Track in GA4)
- Homepage → Enquiry conversion rate
- Homepage → Property page conversion rate
- Bounce rate (target <60%)
- Time on page (target >2 minutes)

### Accessibility Metrics
- Zero critical WCAG violations
- Zero keyboard navigation blockers
- Zero color contrast failures

---

## Implementation Priority

### P0 - Critical (Fix First)
1. Meta title and description optimization
2. Schema markup validation
3. Critical accessibility issues
4. Core Web Vitals failures
5. Security vulnerabilities

### P1 - High Impact
1. Content optimization (copy refinement)
2. Internal linking strategy
3. AI crawler access
4. Image optimization
5. Conversion tracking

### P2 - Medium Impact
1. llms.txt creation
2. FAQ section addition
3. Comparison table
4. Brand mention strategy
5. Performance caching

### P3 - Low Impact / Long-term
1. Third-party presence building
2. Advanced schema types
3. Quarterly content refresh
4. A/B testing variants

---

## Next Steps

1. **Review this plan** — Confirm scope and priorities (use `/plan-writing`, `/verification-before-completion`).
2. **Phases 1–4** — SEO foundation, schema, GEO/AEO, content (`/seo-*`, `/schema-markup`, `/geo-fundamentals`, `/beautiful-prose`, etc., per tasks above).
3. **Phases 5–7** — Internal linking, technical SEO, WCAG accessibility.
4. **Phases 8–9** — CRO, then performance (Core Web Vitals, assets).
5. **Phases 10–12** — Content hierarchy (done); site architecture & URLs + analytics instrumentation (**done** 2026-04-12).
6. **Phases 13–14** — WordPress/theme performance & security (**Phase 13 done** 2026-04-12), PHP/code quality.
7. **Phase 15** — Cross-browser, mobile, a11y, performance, SEO validation testing.
8. **Phase 16** — Documentation and editor handoff (**done** 2026-04-12 — `FRONT-PAGE-OPTIMIZATION.md`).

**Estimated Total Effort:** 3-5 days for comprehensive implementation

---

## Notes

- Hero wording is sacred - do not change
- All factual claims must align with documentation
- Never use "fully accessible" - use specific equipment/features instead
- Follow Beautiful Prose rules for all new copy
- Test on real devices, not just DevTools
- Validate with real users before declaring complete
- Document all changes for future maintenance

---

**Plan Created:** 2026-04-12
**Target Completion:** TBD
**Owner:** Development Team
**Stakeholders:** Marketing, Operations, Accessibility Consultant
