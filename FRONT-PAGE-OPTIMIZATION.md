# Front page SEO optimization — technical handoff & editor guide

**Site:** Restwell Retreats (accessible holiday accommodation, Whitstable, Kent)  
**Theme:** `restwell-theme/`  
**Primary conversion goal:** Enquiry form submissions  
**Constraint:** Hero wording on the homepage must remain unchanged.

This document consolidates the work completed across **Phases 1–15** of `front-page-seo-optimization.md` (execution through 2026-04-12). Use it for **engineering handoff**, **quarterly maintenance**, and **editor training**.

---

## 1. Summary of changes

| Area | What changed (high level) |
| --- | --- |
| **SEO & metadata** | Home defaults for title, description, and focus keyphrase; duplicate site name stripped from `<title>` when the resolved title already ends with the blog name; single meta description path; canonical + OG/Twitter aligned on `/`. |
| **Schema** | WebSite + SearchAction; global LodgingBusiness; homepage FAQ UI + FAQPage JSON-LD when visible; WebPage JSON-LD with dates on home; freshness signals in OG article times. |
| **GEO / AI** | `robots.txt` allows listed AI crawlers; `llms.txt` served at `/llms.txt`; default intro uses three AI-extractable paragraphs when legacy/empty; brand mention strategy documented in plan. |
| **Content** | Non-hero defaults refined; E-E-A-T-oriented copy; 50-keyword list for internal linking / gaps; no “fully accessible” in defaults. |
| **Internal linking** | Contextual links in default intro; footer link to Contact when page exists; property quick-link labels de-duplicated for anchors. |
| **Technical SEO** | Sitemap line in robots; indexability rules documented; mobile viewport; JS not required for critical SEO HTML. |
| **Accessibility** | Skip link, landmarks, focus patterns documented; enquiry form validated on its template. |
| **CRO / analytics** | GA4 secondary events, CTA `data-cta`, footer tracking hooks; UTM strategy documented. |
| **Performance / WP** | Emoji script removal; nav memoization; slug resolution cache; related-posts query tweaks; generator meta removed; style headers for WP/PHP. |
| **Security / quality** | Enquiry success query params sanitized; escaping/nonce patterns reviewed. |
| **Testing** | Cross-browser, mobile, a11y, perf, and SEO validation **procedures** documented for staging/production (not automated in repo). |

---

## 2. Rationale (why it was done)

1. **Metadata** — Control how the brand appears in SERPs and social shares without duplicate titles; keep descriptions within useful length and match user intent (accessible holidays + specs + enquiry).
2. **Schema** — Eligible rich results where honest (FAQ, business facts); help search and assistants understand entity, location, and actions (search, booking page).
3. **GEO** — Improve discoverability in AI-assisted search; provide a machine-readable site summary (`llms.txt`) and crawler policy consistency.
4. **Copy & keywords** — Support rankings and trust without stuffing; hero locked for brand/legal consistency.
5. **Internal links** — Distribute PageRank and clarify IA; fix Contact orphan; avoid repetitive anchor text.
6. **Technical** — Align with crawl/index best practices; defer heavy JS; document hosting boundaries (cache, security headers).
7. **Analytics** — Measure enquiry and property interest with privacy-conscious events.
8. **Performance** — Reduce avoidable WordPress overhead and duplicate DB work in-theme.

---

## 3. Before / after metrics (documented targets & scores)

Figures below are **from the optimization plan execution logs** (code review and documented scoring), not a live production benchmark unless noted.

| Metric / area | Before / baseline | After / noted |
| --- | --- | --- |
| **Schema eligibility score** | N/A | **84/100** (alignment, rich results, completeness, technical, maintenance, spam risk — see Phase 2 log). |
| **E-E-A-T (homepage defaults)** | N/A | Rough **72/100** on-page; revisit when testimonials exist (Phase 4). |
| **GA4 measurement readiness** | N/A | **87/100** — event mapping, accuracy caveats, attribution notes (Phase 12). |
| **Core Web Vitals** | Not run in CI | **Targets:** LCP &lt;2.5s, INP &lt;200ms, CLS &lt;0.1 — run Lighthouse/PSI on **deployed** URL (Phases 6, 9, 15). |
| **Title length** | Default home title ~62 chars with duplication risk | Option 1 implemented + duplicate site name fix in `restwell_document_title_parts()` (Phase 1). |

**Production:** Establish a baseline (Lighthouse JSON, GSC, GA4) after deploy and compare quarterly.

---

## 4. Testing & validation results

| Layer | What was done in-repo | What still requires staging/production |
| --- | --- | --- |
| **PHP** | Logic split across `inc/*`; templates escaped. | `php -l` on changed files; full WP boot tests on host. |
| **SEO head** | Canonical, meta, OG, JSON-LD from PHP. | View Source; Rich Results Test; URL Inspection. |
| **Accessibility** | Markup patterns, skip link, enquiry focus notes. | axe/Lighthouse a11y; keyboard; VoiceOver/NVDA; real images for contrast. |
| **Performance** | Defer JS, emoji removal, query tweaks. | Lighthouse/PSI/WebPageTest on live URL; Query Monitor. |
| **Cross-browser** | Responsive Tailwind + viewport. | Manual or Playwright on Chrome, Firefox, Safari, Edge. |

Enquiry success URL parameters (`sent`, `urgent`) are **sanitized** before use (`template-enquire.php`).

---

## 5. Maintenance notes (engineering)

- **Theme version:** Bumped in `style.css` (e.g. **1.0.1**) for asset cache-bust — bump again when shipping CSS/JS changes.
- **Home meta overrides:** If the front page has saved post meta, theme defaults may not show — use SEO admin / Theme Setup “apply SEO” or clear `meta_title` / `meta_description` once so defaults apply (see Phase 1 deploy note).
- **Caching:** Object cache, page cache, CDN, and security headers (CSP, HSTS, etc.) are **hosting/plugin** concerns; theme documents boundaries in Phase 6 / 13.
- **Guest Guide** template remains **noindex** by design (private/session flow).

---

## 6. Quarterly maintenance checklist (site owner / marketing)

Use **`/seo-content-refresher`**, **`/plan-writing`**, **`/documentation-templates`** when extending this list.

- [ ] **Dates & stats** — Refresh year references, prices “on enquiry,” and any time-bound copy (footer, intro, FAQ).
- [ ] **Testimonials** — Add or rotate real quotes where templates allow; keep E-E-A-T honest (no fabricated reviews).
- [ ] **Broken links** — Crawl main nav, footer, homepage contextual links; fix or redirect.
- [ ] **Schema** — Re-run Rich Results Test after template or FAQ changes; ensure FAQ JSON-LD matches visible Q&A.
- [ ] **Keywords / GSC** — Review Search Console queries, impressions, and average position for target phrases; adjust interior pages before stuffing home.
- [ ] **Core Web Vitals** — PSI or Lighthouse on `/` and `/enquire/`; investigate LCP/CLS regressions after image or font changes.
- [ ] **GA4** — Confirm key events (`enquiry_form_submitted`, etc.) still fire; mark conversions in Admin as needed.
- [ ] **robots / llms** — Confirm `/robots.txt` and `/llms.txt` respond 200 after migrations.
- [ ] **Accessibility** — Spot-check keyboard path and form labels after content edits.

---

## 7. Editor & content guide

Use **`/documentation-generation-doc-generate`**, **`/doc-coauthoring`**, **`/wiki-qa`** when updating this section.

### 7.1 How to update meta tags (title & description)

1. Log in to **WordPress Admin**.
2. Open the page set as **Home** (Settings → Reading → “Your homepage displays”).
3. Use the theme’s **SEO / Page Content Fields** (labels may match “Meta title”, “Meta description” in `page-meta-definitions.php` / Theme Options).
4. **Rules:**
   - **Title:** ~50–60 characters; primary phrase early; avoid duplicating the site name if the theme already appends it (preview the browser tab or View Source).
   - **Description:** ~150–160 characters; include location, differentiators (hoist, wet room, whole-property), and a soft CTA (enquiry).
5. Save the page. Clear any **page cache** if the site uses a caching plugin or CDN.
6. Validate with **View Source** and optional [Rich Results Test](https://search.google.com/test/rich-results) for the URL.

### 7.2 How to add or edit homepage content sections

- **Hero:** Text is **locked by project policy** — do not change without stakeholder approval.
- **Intro (“What is Restwell?”):** If the `intro_body` field is filled with custom HTML, that content replaces the default three-paragraph GEO stack. Keep paragraphs short and factual; link to key interior pages using the same-origin links your editor allows.
- **FAQ block:** Questions/answers are driven by page meta / theme defaults (`home_faq_*`). Ensure visible FAQ text **matches** what appears in JSON-LD (no contradictions).
- **Other sections:** Edit through the assigned page fields or Theme Setup defaults; after changes, spot-check **mobile** layout and **heading order** (one H1 per page — typically the hero).

### 7.3 Image optimization guidelines

- Prefer **WebP** or modern formats the media library provides; avoid multi-megabyte uploads for hero and above-the-fold images.
- Always set **alt text** that describes the image functionally (empty alt only for decorative images).
- Lazy-load non-critical images where the theme already does; do not rely on client-only rendering for SEO-critical text.

### 7.4 Accessibility checklist (content editors)

- Use real **heading levels** (don’t skip from H2 to H4).
- **Link text** must make sense out of context (“Read our accessibility specification” vs “click here”).
- Don’t rely on colour alone for meaning; check **contrast** on custom coloured blocks.
- Forms: clear labels, error messages, and focus order — enquiry form lives on **Enquire** template.

### 7.5 SEO practices for editors (short list)

- Align with **Phase 1** keyword tiers; avoid repeating the same phrase unnaturally.
- **No** phrase “fully accessible” in marketing copy — describe specific features instead.
- **Internal links:** Use varied, descriptive anchors; link to Property, Accessibility, How it Works, Area guide, Resources as appropriate.
- **Freshness:** Meaningful edits update `post_modified` — the theme can show “Last updated” and schema dates on the homepage.

---

## 8. Key theme files (reference)

| Concern | Primary files |
| --- | --- |
| Front page markup | `restwell-theme/front-page.php` |
| SEO hooks, meta, JSON-LD | `restwell-theme/inc/seo.php`, `restwell-theme/inc/seo-content-seed.php` |
| Robots / sitemap / AI | `restwell-theme/inc/sitemap-robots.php`, `restwell-theme/inc/llms-txt.php`, `restwell-theme/llms.txt` |
| Page meta UI | `restwell-theme/inc/page-meta-definitions.php` |
| Analytics / CTA | `restwell-theme/assets/js/main.js`, `restwell-theme/footer.php` |
| Enquiry | `restwell-theme/template-enquire.php` |

---

## 9. Related plan file

- **`front-page-seo-optimization.md`** — Full phased plan, execution tables for Phases 1–16, and verification checklist.

**Document version:** 2026-04-12 (Phase 16 documentation batch)
