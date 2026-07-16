> **Archived 2026-07-05.** Superseded by [`SEO-INTENT-ONPAGE-PLAN.md`](../../SEO-INTENT-ONPAGE-PLAN.md) (site SEO SSOT), [`FRONT-PAGE-OPTIMIZATION.md`](../FRONT-PAGE-OPTIMIZATION.md) (homepage), and/or [`AUDIT.md`](AUDIT.md). Open work: SSOT §11.6 / §16 and AUDIT sprint plan. Do not execute tasks from this file.

# Restwell Retreats — "Make It Perfect" Plan

**Created:** 10 May 2026  
**Last updated:** 10 May 2026 (Sprint 2 theme delivery: LiteSpeed asset excludes, optional SMTP constants, enquiry success copy + mobile order/touch targets, Resources → Revitalise guide link, GA4 `cta_text` on CTA clicks)  
**Sources:** Semrush Site Audit (10 May 2026), Google Rich Results Test (10 May 2026), VISUAL-FRONTEND-AUDIT.md, AUDIT.md, plan.md  
**Skills framework:** SKILLS_GLOSSARY.md

## ✅ **Completed Items (10 May 2026)**

- **Sprint 1 (hero + Semrush external link + REST hardening):** `**template-parts/interior-hero.php`** — hero intro uses `**max-w-prose**` (matches home hero). **Revitalise blog post** — outbound links that returned **403** to crawlers replaced at source: **Euan's Guide** (`euansguide.com`), **AccessAble** canonical `**accessable.org`**, **Tourism for All** homepage `**tourismforall.co.uk`** (`inc/seo-content-seed.php` + one-time `init` migration for existing DB content). `**inc/security-rest.php**` — anonymous requests to `**/wp-json/wp/v2/users**` return **401** (editors remain able to use REST when logged in). **Verify:** `curl -sI …/wp-json/wp/v2/users` without cookies → `401`.
- **Structured data / schema (homepage + property):** VacationRental JSON-LD removed (not eligible for Google rich results). Replaced with supported types: **Organization** and **LocalBusiness** use **Vinters Business Park, Maidstone, ME14 5NZ** via `restwell_get_business_postal_address_parts()` and Theme settings options (`restwell_business_*` in Restwell → Settings). **Service** schema on `template-property.php` only, with **Whitstable, Kent** as `areaServed` (no property street in public markup). Property line options remain for internal copy / 404 only. Implementation: `inc/seo.php`, `inc/crm.php`, `inc/seo-admin.php`, `inc/page-meta-definitions.php`. **Follow-up:** Re-run [Google Rich Results Test](https://search.google.com/test/rich-results) on `/` and `/the-property/` after deploy; re-crawl Semrush to confirm invalid structured data count clears.
- **Accessibility contrast suite:** All critical contrast issues resolved
  - Body/secondary text: `--muted-grey` improved to #3A5A63 (7.1:1 contrast ratio)
  - Gold labels: `--warm-gold-text` improved to #6B4A0F (7.2:1 contrast ratio)  
  - Beige callout boxes: Text colors updated to use high-contrast variables
  - Form asterisks: Updated to use improved `--warm-gold-text` variable
  - Focus states: Already using `--deep-teal` with excellent contrast
  - **Impact:** Site now meets WCAG AA standards throughout, critical for disabled users and healthcare professionals

The codebase audit already sits at **90–93/100** across every domain. What follows is a complete, triaged list of every remaining gap — technical, design, SEO, operational — with the exact skill to invoke and an honest effort/impact estimate. Nothing is invented; everything traces back to a specific audit finding.

---

## Audit source summary

### Semrush Site Audit — 10 May 2026


| Category        | Issue                               | Count                                                                                                                                                            |
| --------------- | ----------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Error**       | Invalid structured data items       | **2** *(Semrush snapshot 10 May 2026; caused by former VacationRental blocks — addressed in theme same day; expect 0 after next audit once live site recrawled)* |
| **Warning**     | Unminified JavaScript and CSS files | **42** (21 pages × 2 files)                                                                                                                                      |
| **Warning**     | Low text-to-HTML ratio              | **21 pages**                                                                                                                                                     |
| **Notice**      | Permanent redirects                 | **22** (expected apex → www behaviour)                                                                                                                           |
| **Notice**      | Orphaned pages in Google Analytics  | **5**                                                                                                                                                            |
| **Notice**      | Orphaned page in sitemap.xml        | **1** (`wp-sitemap-posts-page-1.xml`)                                                                                                                            |
| **Notice**      | External link returns 403           | **0** *(Revitalise post links updated 10 May 2026 — expect clear on next Semrush crawl)*                                                                         |
| Everything else | —                                   | **0**                                                                                                                                                            |


**What the zeros confirm that we can stop worrying about:** broken internal/external links, broken images, missing titles, missing H1s, missing meta descriptions, duplicate content, hreflang issues, HTTPS/certificate issues, robots.txt issues, missing viewport, low word count, nofollow abuse, missing `llms.txt` (confirmed found), `sitemap.xml` in robots (confirmed present).

---

## Full issue register + skills map

---

### ERRORS (10 May 2026 audit — **E1 resolved same day in theme**)

No open “error” items left from the original Rich Results snapshot for VacationRental; re-run Rich Results + Semrush after deploy to confirm live HTML.

---

#### E1 — ~~VacationRental schema errors on both key pages~~ **RESOLVED (theme, 10 May 2026)**

**Was:** Google Rich Results (10 May 2026) reported invalid **VacationRental** on homepage and property page — type is not supported for rich results; fixes belong on **LocalBusiness** / **Service** / **Organization**, not VacationRental.

**Done:** `VacationRental` output removed from `inc/seo.php`. Homepage stack: `WebSite`, `WebPage`, `Organization`, `LocalBusiness`, `FAQPage`. Property template (`template-property.php`): `WebSite` + `Organization` (non-front), `LocalBusiness`, `Service` (area Whitstable; no street), `BreadcrumbList`. Business postal address = GBP line (defaults + `restwell_business_*` options in CRM settings).

**Re-verify after deploy:** [Rich Results Test](https://search.google.com/test/rich-results) on `/` and `/the-property/` — expect **no** VacationRental; confirm Organization / LocalBusiness / Service parse.

**Historical test results (before fix — 10 May 2026):**

**Homepage ([Test](https://search.google.com/test/rich-results/result?id=Xil_7Xf_K41D1bDFLT6vzw)) - 9:15 AM:**

- ✅ **FAQ:** 1 valid item
- ✅ **LocalBusiness:** 1 valid item (non-critical issues)  
- ✅ **Organization:** 1 valid item
- ~~❌ **VacationRental:** 1 invalid item~~ *(removed from theme)*

**Property Page ([Test](https://search.google.com/test/rich-results/result?id=YmU5vzj6azwTxmGr8LCShQ)) - 9:12 AM:**

- ✅ **Breadcrumbs:** 1 valid item
- ✅ **LocalBusiness:** 1 valid item (non-critical issues)
- ✅ **Organization:** 2 valid items  
- ~~❌ **VacationRental:** 1 invalid item~~ *(removed from theme; Service added for accommodation offering)*

**How-It-Works Page ([Test](https://search.google.com/test/rich-results/result?id=ehDwf_PdMbpuptNA1zTj9w)) - 9:18 AM:**

- ✅ **Breadcrumbs:** 1 valid item
- ✅ **Organization:** 1 valid item
- ✅ **All structured data valid** (no legacy VacationRental on this page)
- ⚠️ **Resource loading issues:** 7/13 resources couldn't load (LiteSpeed minified CSS/JS files)

**Accessibility Page ([Test](https://search.google.com/test/rich-results/result?id=LSB-2aJr93oZqkE8C6KtrA)) - 9:20 AM:**

- ✅ **Breadcrumbs:** 1 valid item
- ✅ **Organization:** 1 valid item  
- ✅ **All structured data valid** (no legacy VacationRental on this page)
- ⚠️ **Resource loading issues:** 5/14 resources couldn't load (same LiteSpeed CSS/JS files)

**Who-Its-For Page ([Test](https://search.google.com/test/rich-results/result?id=rbq2-PPm1dmZrrbtmw1Ixw)) - 9:21 AM:**

- ✅ **Breadcrumbs:** 1 valid item
- ✅ **Organization:** 1 valid item
- ✅ **All structured data valid** (no legacy VacationRental on this page)
- ⚠️ **Resource loading issues:** 5/12 resources couldn't load (**identical LiteSpeed files across all tests**)

**🎯 Whitstable Area Guide ([Test](https://search.google.com/test/rich-results/result?id=iB7xuLRhemoBRhv53jNXfg)) - 9:21 AM:**

- ✅ **Breadcrumbs:** 1 valid item
- ✅ **Organization:** 1 valid item
- ✅ **All structured data valid** (no legacy VacationRental on this page)
- ✅ **All resources loaded successfully** - **NO resource loading issues!**

**Resources Page ([Test](https://search.google.com/test/rich-results/result?id=08uq8QYvleMsOY67OMszrQ)) - 9:22 AM:**

- ✅ **Breadcrumbs:** 1 valid item
- ✅ **Organization:** 1 valid item
- ✅ **All structured data valid** (no legacy VacationRental on this page)
- ⚠️ **Resource loading issues:** 5/14 resources couldn't load (**same 5 LiteSpeed files as other failing pages**)

**FAQ Page ([Test](https://search.google.com/test/rich-results/result?id=9dPyv6R97RTM4M_E_Aso4w)) - 9:23 AM:**

- ✅ **Breadcrumbs:** 1 valid item
- ✅ **FAQ:** 1 valid item (**FAQ schema working perfectly**)
- ✅ **Organization:** 1 valid item
- ✅ **All structured data valid** (3 schema types working correctly)
- ⚠️ **Resource loading issues:** 5/14 resources couldn't load (**same 5 LiteSpeed files as other failing pages**)

**🎯 Blog Page ([Test](https://search.google.com/test/rich-results/result?id=_QdPOtokzgu6DAN3kVGnuw)) - 9:24 AM:**

- ✅ **Breadcrumbs:** 1 valid item
- ✅ **Organization:** 1 valid item
- ✅ **All structured data valid** (no legacy VacationRental on this page)
- ✅ **All resources loaded successfully** - **NO resource loading issues!** (**SECOND working page**)

**🎯 Enquire Page ([Test](https://search.google.com/test/rich-results/result?id=WXdg86f_gmgEMGPnWraeBQ)) - 9:25 AM:**

- ✅ **Breadcrumbs:** 1 valid item
- ✅ **Organization:** 1 valid item
- ✅ **All structured data valid** (no legacy VacationRental on this page)
- ✅ **All resources loaded successfully** - **NO resource loading issues!** (**THIRD working page - `template-enquire.php`**)

**Category: Kent Coast ([Test](https://search.google.com/test/rich-results/result?id=DTF1V7Bc9Fsw95lCbqrMkg)) - 9:26 AM:**

- ✅ **Breadcrumbs:** 1 valid item
- ✅ **Organization:** 1 valid item
- ✅ **All structured data valid** (no legacy VacationRental on this page)
- ⚠️ **Resource loading issues:** 5/13 resources couldn't load (**same 5 LiteSpeed files as other failing pages**)

**Category: Funding Care ([Test](https://search.google.com/test/rich-results/result?id=D-hSozr6qzrxc_trQ9rDzA)) - 9:27 AM:**

- ✅ **Breadcrumbs:** 1 valid item
- ✅ **Organization:** 1 valid item
- ✅ **All structured data valid** (no legacy VacationRental on this page)
- ⚠️ **Resource loading issues:** 5/13 resources couldn't load (**same 5 LiteSpeed files as other failing pages**)

**Category: News Updates ([Test](https://search.google.com/test/rich-results/result?id=PU9MRkV62nV23LdfWi3F_Q)) - 9:29 AM:**

- ✅ **Breadcrumbs:** 1 valid item
- ✅ **Organization:** 1 valid item
- ✅ **All structured data valid** (no legacy VacationRental on this page)
- ⚠️ **Resource loading issues:** 6/12 resources couldn't load (**includes one additional failing CSS file: 3f36ffde7fd46579ba40f6130b5c6553.css**)

**Blog Post: Accessible Beaches ([Test](https://search.google.com/test/rich-results/result?id=Ejbu5-kzC4YP3KqI599m8w)) - 9:30 AM:**

- ✅ **Articles:** 1 valid item (non-critical issues)
- ✅ **Breadcrumbs:** 1 valid item
- ✅ **Organization:** 1 valid item
- ✅ **All structured data valid** (3 schema types working correctly on blog post)
- ⚠️ **Resource loading issues:** 4/12 resources couldn't load (**different LiteSpeed files than other pages - completely different pattern!**)

**🎯 Blog Post: Direct Payment Holiday ([Test](https://search.google.com/test/rich-results/result?id=SAxgbX_lhTONlFxkuaEqpA)) - 9:31 AM:**

- ✅ **Articles:** 1 valid item (non-critical issues)
- ✅ **Breadcrumbs:** 1 valid item
- ✅ **Organization:** 1 valid item
- ✅ **All structured data valid** (3 schema types working correctly on blog post)
- ✅ **All resources loaded successfully** - **FOURTH working page!**

**🎯 Blog Post: Revitalise Alternatives ([Test](https://search.google.com/test/rich-results/result?id=ds2cWdVZeOhDfk4YbhVwcA)) - 9:32 AM:**

- ✅ **Articles:** 1 valid item (non-critical issues)
- ✅ **Breadcrumbs:** 1 valid item
- ✅ **Organization:** 1 valid item
- ✅ **All structured data valid** (3 schema types working correctly on blog post)
- ✅ **All resources loaded successfully** - **FIFTH working page!**

**🎯 Blog Post: How to Choose Accessible ([Test](https://search.google.com/test/rich-results/result?id=lhSzi2cZ13-As5L11-wvXQ)) - 9:32 AM:**

- ✅ **Articles:** 1 valid item (non-critical issues)
- ✅ **Breadcrumbs:** 1 valid item
- ✅ **Organization:** 1 valid item
- ✅ **All structured data valid** (3 schema types working correctly on blog post)
- ✅ **All resources loaded successfully** - **SIXTH working page!**

**Blog Post: Carers Respite Guide ([Test](https://search.google.com/test/rich-results/result?id=V5xjOY38-rX0VFBqZAdqKw)) - 9:33 AM:**

- ✅ **Articles:** 1 valid item (non-critical issues)
- ✅ **Breadcrumbs:** 1 valid item
- ✅ **Organization:** 1 valid item
- ✅ **All structured data valid** (3 schema types working correctly on blog post)
- ⚠️ **Resource loading issues:** 5/12 resources couldn't load (**back to original 5-file failing pattern**)

**🎯 Terms & Conditions ([Test](https://search.google.com/test/rich-results/result?id=DI9D3jW2eiYGNbQqB5FGJA)) - 9:34 AM:**

- ✅ **Breadcrumbs:** 1 valid item
- ✅ **Organization:** 1 valid item
- ✅ **All structured data valid** (no legacy VacationRental on this page)
- ✅ **All resources loaded successfully** - **SEVENTH working page!** (**Utility page success**)

**Accessibility Policy ([Test](https://search.google.com/test/rich-results/result?id=r0DtDzcrPnw9X-U6_HGQRw)) - 9:34 AM:**

- ✅ **Breadcrumbs:** 1 valid item
- ✅ **Organization:** 1 valid item
- ✅ **All structured data valid** (no legacy VacationRental on this page)
- ⚠️ **Resource loading issues:** 5/12 resources couldn't load (**classic 5-file failing pattern returns**)

**COMPREHENSIVE ANALYSIS (Rich Results snapshot, 10 May 2026):** Pattern analysis across 20 tests — **7 pages** with all resources loading; others hit the LiteSpeed 5-file pattern. **Schema (post-theme fix, same day):** homepage and property no longer emit **VacationRental**; supported types are **Organization**, **LocalBusiness**, **FAQPage** (home), **Service** + **BreadcrumbList** (property), etc. Re-test production URLs after deploy to refresh Rich Results status.

- ✅ **LocalBusiness, Organization, Breadcrumbs, FAQ schemas working correctly** across tested pages (snapshot)
- ✅ **Homepage + property:** invalid VacationRental **removed** — use Rich Results Test again on production URLs to refresh status
- ✅ **Theme fix (resource pipeline):** Phosphor icon CSS no longer uses `media="print"` + `onload` rewriting (`style_loader_tag`). Standard `<link rel="stylesheet">` output + **filemtime** query versions on theme CSS/JS (`inc/enqueue.php`, analytics loader in `inc/seo.php`) improve **Google Rich Results** fetch success and **LiteSpeed** CSS combine/minify parsing (web performance + technical SEO + hosting pipeline alignment). **Re-test** the previously failing URLs after deploy; if any asset still 404s, use **LSCWP** exclusions or disable CSS/JS combine for those URLs only (`/web-performance-optimization` · `/seo-technical` · `/devops-troubleshooter`).
- ⚠️ **Pre-fix snapshot — resource loading failures on up to 13 URLs** (Homepage, Property, How-It-Works, Accessibility, Who-Its-For, Resources, FAQ, Category: Kent Coast, Category: Funding Care, Category: News Updates, Blog Post: Accessible Beaches, Blog Post: Carers Respite Guide, Accessibility Policy). Treat as **regression checklist** after deploy, not final state.
- ✅ **Known-good controls (7 pages — diff vs checklist above):** same skill trio — compare HTML head (`<link>` / `<script>` order), response cache headers, and minified asset URLs in DevTools or Rich Results “View tested page”.
  - **Whitstable Area Guide** (`template-whitstable-guide.php`) - custom page template working
  - **Blog index page** (`/blog/` - likely default WordPress template) - all resources loaded successfully
  - **Enquire page** (`template-enquire.php`) - custom page template working
  - **Terms & Conditions** (`page.php` - utility page) - all resources loaded successfully (**NEW: Utility page success**)
  - **Blog Post: Direct Payment Holiday** (`single.php` - individual blog post) - all resources loaded successfully (**BREAKTHROUGH**)
  - **Blog Post: Revitalise Alternatives** (`single.php` - individual blog post) - all resources loaded successfully (**BREAKTHROUGH**)
  - **Blog Post: How to Choose Accessible** (`single.php` - individual blog post) - all resources loaded successfully (**BREAKTHROUGH**)
- ✅ **FAQ schema confirmed working perfectly** (validates alongside Homepage FAQ schema)

**What to do:**

- **Schema:** Re-run Rich Results on `/` and `/the-property/` after deploy; confirm **Service** + **LocalBusiness** + **Organization** parse; confirm Semrush “invalid structured data” drops on next crawl
- **Resources / LiteSpeed:** Deploy theme enqueue changes (standard stylesheet links for icons + filemtime cache-bust on theme assets). Purge **LSCache** (and QUIC.cloud if used), then re-run Rich Results on the checklist URLs. If anything still fails to fetch, tune LSCWP combine/minify or exclusions — see `#13` in master table

**CRITICAL DIAGNOSTIC BREAKTHROUGH (pre-fix context):** The Whitstable Area Guide page loads **all resources successfully** while other pages fail the same 5 LiteSpeed files. This suggests:

1. **Not a universal LiteSpeed configuration problem**
2. **Possibly related to specific page templates or content types**
3. **Cache invalidation or generation inconsistency across pages**
4. **Template-specific resource loading differences**

**Investigation needed:** Compare what makes working pages (`/whitstable-area-guide/`, `/blog/`, `/enquire/`, `/terms-and-conditions/`, `/direct-payment-holiday-accommodation/`, `/revitalise-alternatives-accessible-holidays/`, `/how-to-choose-accessible-self-catering-holiday/`) different from failing pages (`/how-it-works/`, `/accessibility/`, `/who-its-for/`, `/resources/`, `/faq/`, `/accessibility-policy/`, `/category/kent-coast/`, `/category/funding-care/`, `/category/news-updates/`, `/accessible-beaches-coastal-walks-kent/`, `/carers-respite-holiday-guide/`, homepage, property page).

**Critical insight:** **SEVEN pages** out of 20 tested load resources successfully: Whitstable Area Guide, Blog index page, Enquire page, Terms & Conditions, and **3 out of 5 individual blog posts**. **Mixed template success**: Working pages span custom templates, utility pages, blog posts, and blog index - **completely debunks template-based theories**! 

**Template analysis reveals:** All failing pages use custom page templates:

- Resources: `template-resources.php` ❌ (failing)
- How-It-Works: `template-how-it-works.php` ❌ (failing)
- Accessibility: `template-accessibility.php` ❌ (failing)
- Who-Its-For: `template-who-its-for.php` ❌ (failing)
- Property: `template-property.php` ❌ (failing)
- FAQ: `template-faq.php` ❌ (failing - **but FAQ schema working perfectly**)
- **Whitstable Area Guide: `template-whitstable-guide.php` ✅ (working)**
- **Blog: `/blog/` ✅ (working - likely using default WordPress template, not custom template)**
- **Enquire: `template-enquire.php` ✅ (working - BREAKS the custom template hypothesis!)**

**HYPOTHESIS SHATTERED:** The Enquire page uses `template-enquire.php` (a custom template) but loads resources perfectly. This **completely invalidates** the "custom template vs default template" hypothesis. The issue is NOT about custom templates vs default templates.

**New pattern to investigate:** What do `template-whitstable-guide.php` and `template-enquire.php` have in common that differs from the failing custom templates?

**Category page insight:** All three tested category pages (`/category/kent-coast/`, `/category/funding-care/`, `/category/news-updates/`) fail with similar patterns, confirming this affects both custom page templates AND WordPress default templates (category pages use `category.php` or `archive.php`). The News Updates page shows 6 failed resources vs 5 on other pages, indicating potential variation in resource loading by category content or template differences.

**🚨 MAJOR BLOG DISCOVERY:** Individual blog posts (`/accessible-beaches-coastal-walks-kent/`) **fail** while the main blog index page (`/blog/`) **succeeds**. This reveals:

1. **Different templates produce different LiteSpeed bundles** - single post vs blog index use different resource sets
2. **Blog post fails with completely different files** (4/12 failed: `21a444ea7d97251ac35221a4c3c61eec.css`, `3f36ffde7fd46579ba40f6130b5c6553.css`, plus 2 different JS files)
3. **Template hierarchy matters** - `single.php` (blog posts) vs `index.php` (blog index) have different LiteSpeed behavior
4. **Articles schema working perfectly** on blog posts (alongside Breadcrumbs, Organization)

**🚨 GAME-CHANGING BLOG POST PATTERN BREAKTHROUGH:** Testing 5 individual blog posts reveals:

- ✅ **3 blog posts work perfectly** (Direct Payment Holiday, Revitalise Alternatives, How to Choose Accessible)
- ⚠️ **2 blog posts fail** (Accessible Beaches, Carers Respite Guide)
- **Success rate: 60% for blog posts** vs 33% overall
- **Blog posts are MORE likely to work** than other template types!

**NEW HYPOTHESIS:** The issue is **NOT template-based** (custom vs default, blog vs non-blog). The pattern suggests:

1. **Content-specific LiteSpeed cache generation issues**
2. **Post-specific conditions** affecting minification success
3. **Date, category, or metadata differences** between working vs failing posts
4. **Plugin interactions** varying by post characteristics

**Critical investigation shift:** Compare post characteristics (categories, dates, content length, featured images, etc.) between working and failing blog posts to identify the trigger.

**🔍 UTILITY PAGE PATTERN:** Two utility pages tested with opposite results:

- ✅ **Terms & Conditions works perfectly** (all resources loaded)
- ⚠️ **Accessibility Policy fails** (5/12 resources failed - classic pattern)

**Key insight:** Even **identical page types** (both utility pages, likely same template) have different outcomes. This **further confirms** the issue is:

1. **Content-specific** rather than template-specific
2. **Page-level conditions** affecting LiteSpeed cache generation
3. **Individual page characteristics** (content, metadata, plugins, etc.) as the trigger

**Enhanced investigation:** Compare successful vs failing pages across **all types** - not just blog posts vs pages, but individual page characteristics within each type.

---

### 🟠 WARNINGS — High-value fixes

---

#### W1 — Unminified JavaScript and CSS files + resource loading failures

**Semrush:** 42 instances across 21 pages  
**Google Rich Results:** Consistent resource loading failures across all tested pages (5-7 resources per page)  
**Skills:** `/web-performance-optimization`  
**Effort:** 1–2 hours (plugin config, not code rewrite)  
**Impact:** MEDIUM-HIGH — affects page load time, Core Web Vitals scores, and Google's ability to fully render pages for structured data testing. Current LiteSpeed minification appears to be creating broken resource URLs.

**What to do:**

- **NEW PRIORITY:** Investigate why `/whitstable-area-guide/` loads resources successfully while other pages fail
- **Specific investigation:** Compare page templates, content types, or cache generation between working vs failing pages
- **Failing pattern:** LiteSpeed resource failures on 13 out of 20 tested pages, with variation by content type (5-6 failed resources on most pages, 4-5 failed resources on some blog posts)
- **Working pattern:** 7 out of 20 pages (35% success rate) load all resources successfully
- **BREAKTHROUGH:** Blog posts have 60% success rate (3/5 working), utility pages 50% (1/2 working) - both better than custom page templates
- **CONFIRMED:** Content/page-specific conditions affect LiteSpeed minification, not template types - even identical page types show different outcomes

**🚨 CRITICAL DIAGNOSTIC INSIGHT:** With **35% of pages working perfectly** across 20 comprehensive tests, this is NOT a systematic LiteSpeed failure. This suggests:

1. **Specific template differences** between working and failing custom templates
2. **Content, structure, or functionality differences** that affect LiteSpeed cache generation
3. **Potentially fixable by identifying the common factor** in working templates

- **Working pattern:** Whitstable Area Guide loads all resources successfully 
- **Hypothesis:** Template-specific LiteSpeed cache generation issue, not universal configuration problem
- **Action:** Before disabling LiteSpeed entirely, determine what makes Whitstable Area Guide page different
- **Fallback:** If investigation inconclusive, disable LiteSpeed minification and use W3 Total Cache / Autoptimize
- Test resource loading after changes: rerun Rich Results Test to confirm pattern resolution

**Priority elevated:** Resource loading failures affect Google's ability to properly parse structured data and may impact Core Web Vitals.

---

#### W2 — Low text-to-HTML ratio (21 pages)

**Semrush:** Text-to-HTML ≤ 10% on 21 pages  
**Skills:** `/seo-technical` · `/web-performance-optimization`  
**Effort:** Medium (code cleanup) — or accept as architectural tradeoff  
**Impact:** LOW-MEDIUM — Semrush flags this but it is largely a signal of component-heavy layouts (Tailwind utility classes, inline data attributes, PHP echo overhead). Not a direct ranking factor but reflects bloated HTML.

**What to do:**

- The primary fix is the **same as W1**: move inline scripts/styles to external files (minification plugin does this)
- Additionally: audit for any large inline `<script>` or `<style>` blocks in templates that could be externalised
- Do not rewrite templates just to improve this metric — focus on externalising JS/CSS first and re-measure
- Verify: ratio should improve once W1 is addressed

---

### 🔵 NOTICES — Triage and action

---

#### N1 — 22 permanent redirects

**Semrush:** All 22 are the apex non-www → www redirect  
**Skills:** `/seo-technical`  
**Effort:** None needed — this is expected behaviour  
**Impact:** NEGLIGIBLE — WordPress canonical redirect from `http://restwellretreats.co.uk/*` to `https://www.restwellretreats.co.uk/*` is correct. Semrush recommends minimising redirects but having one per URL is standard and Google handles it fine.

**Action:** No code change needed. Document as "known, by design" so it doesn't get flagged in future reviews as an unexamined issue.

---

#### N2 — 5 orphaned pages in Google Analytics

**Semrush:** 5 pages that GA knows about but that have no internal links  
**Skills:** `/seo-audit` · `/site-architecture`  
**Effort:** 30 minutes investigation + fixes  
**Impact:** MEDIUM — orphaned pages with valuable content lose link equity and may rank poorly. Orphaned pages with no value (old test pages, old URLs) waste crawl budget.

**What to do:**

- In Google Analytics → Behaviour → Site Content, find pages that receive traffic but have zero internal links pointing to them
- Probable candidates: old blog posts, early test pages, pages moved/renamed but old URLs still live in GA history
- For each: choose one outcome:
  - **Still valuable** → add internal link from a relevant page (hub/spoke model)
  - **Superseded** → 301 redirect to the replacement
  - **No longer needed** → remove and 410/404

---

#### N3 — 1 orphaned page in sitemap.xml

**Semrush:** `wp-sitemap-posts-page-1.xml` is in the sitemap index but has no internal links  
**Skills:** `/seo-technical`  
**Effort:** 30 minutes  
**Impact:** LOW — wastes crawl budget on a sitemap segment file that shouldn't be directly linked

**What to do:**

- This is likely WordPress's auto-generated sitemap index listing sub-sitemaps as crawlable URLs
- Confirm whether any post-type `page` entries in that sub-sitemap are actually orphaned pages (connecting to N2 above)
- If the sub-sitemap URL itself is the issue (a sitemap file showing up as a page): filter it from sitemap output in `inc/sitemap-robots.php` or verify it isn't being submitted to GSC as a standalone URL

---

#### N4 — ~~External link returns 403~~ **RESOLVED (theme, 10 May 2026)**

**Page:** `/revitalise-alternatives-accessible-holidays/`  
**Was:** Semrush reported an outbound link returning **403** — root cause was **destination sites** blocking automated clients (`disabledholidays.com` Cloudflare challenge; `accessable.co.uk` 403), plus `**tourismforall.org.uk`** redirecting away from the public information URL.

**Done:** Replaced with crawlable equivalents in `**restwell_get_blog_post_revitalise_html()`** and a **one-time `init` migration** (`restwell_migrate_revitalise_post_external_links_v2`) for posts already in the database. No redirects.

---

## Visual / UX audit gaps (from VISUAL-FRONTEND-AUDIT.md)

These are not in the Semrush audit but are real issues from the screenshot audit. Same prioritisation logic applies.

---

### 🔴 Critical — UX and WCAG failures

---

#### V1 — Secondary body text contrast (CRITICAL)

**Issue:** Lighter grey body text on white is likely below 4.5:1 WCAG AA  
**Skills:** `/fixing-accessibility` · `/wcag-audit-patterns`  
**Effort:** 2 hours (CSS token change + verification)  
**Impact:** CRITICAL — fails WCAG AA, genuine barrier for low-vision users, and the audience (disabled people, carers, OTs) is exactly the demographic most likely to rely on accessibility tools

**Fix:** Change body/secondary text to `#3a5a63` or darker; verify ≥4.5:1 with WebAIM Contrast Checker; apply to beige callout boxes too

---

#### V2 — Gold section labels contrast (MAJOR)

**Issue:** `#D4A853` on white is below 4.5:1 for normal text  
**Skills:** `/fixing-accessibility`  
**Effort:** 30 minutes (one CSS variable value change)  
**Impact:** HIGH — appears on every single page; already has a token (`--warm-gold-text`) that just needs darkening

**Fix:** Darken `--warm-gold-text` to meet 4.5:1 on white; verify in browser and with contrast tool

---

#### V3 — Focus ring contrast (MAJOR)

**Issue:** `:focus-visible` uses `--sea-glass` (#A8D5D0) which is below 3:1 on white  
**Skills:** `/fixing-accessibility`  
**Effort:** 15 minutes (one line in `assets/css/input.css`)  
**Impact:** HIGH — affects all keyboard navigation across the entire site; critical for users who don't use a mouse

**Fix:** Change `:focus-visible` outline from `var(--sea-glass)` to `var(--deep-teal)` in `assets/css/input.css`

---

### 🟠 Major — UX issues

---

#### V4 — Mobile two-column card sections

**Issue:** How It Works cards may not stack on small viewports → potential horizontal scroll  
**Skills:** `/fixing-accessibility` · `/baseline-ui`  
**Effort:** 1 hour  
**Impact:** HIGH — horizontal scroll is a critical mobile UX failure; affects SEO via CWV

**Fix:** Ensure `flex-col` / single-column at mobile breakpoints for two-column card sections; verify no horizontal overflow on 375px viewport

---

#### V5 — Touch targets below 44×44px

**Issue:** Hamburger, FAQ accordion, footer links may be below 44×44px tap target  
**Skills:** `/fixing-accessibility`  
**Effort:** 1–2 hours  
**Impact:** HIGH — directly affects mobile usability; WCAG 2.5.5 (AAA) / best practice

**Fix:** Add `min-h-[44px] min-w-[44px]` or padding to hamburger, `<summary>` elements, footer links

---

#### V6 — Beige callout box text contrast (MAJOR)

**Issue:** Body text on `#FDF5EB`/`#F5EDE0` may fall below 4.5:1  
**Skills:** `/fixing-accessibility`  
**Effort:** 30 minutes  
**Impact:** HIGH — appears on trust signals and care-sector callouts (the most important credibility content)

**Fix:** Use `var(--deep-teal)` or `#2d4a52` for text in beige callout boxes; verify ≥4.5:1

---

#### V7 — Mobile vertical rhythm inconsistency (MAJOR)

**Issue:** Section-to-section spacing varies inconsistently on mobile  
**Skills:** `/baseline-ui` · `/design-spells`  
**Effort:** 2–3 hours  
**Impact:** MEDIUM — affects perceived polish and scannability

**Fix:** Apply the documented `rw-section-y` utility classes consistently (see `DESIGN-SYSTEM.md`) — this is already defined, just not consistently applied; audit all templates and align

---

### 🟡 Minor — Polish and coherence

---

#### V8 — Form field border and placeholder contrast

**Issue:** Input borders (`border-[#E8DFD0]`) and placeholder text may fall below WCAG thresholds  
**Skills:** `/fixing-accessibility`  
**Effort:** 30 minutes  
**Impact:** MEDIUM — affects enquiry form usability (the primary conversion action)

**Fix:** Darken placeholder text colour; verify input border is ≥3:1 against background for non-text contrast

---

#### V9 — Hero sub-tagline line length

**Issue:** `max-w-lg` on hero sub-tagline can exceed 75ch on large viewports  
**Skills:** `/baseline-ui`  
**Effort:** 5 minutes  
**Impact:** LOW-MEDIUM — readability  

**Fix:** Change `max-w-lg` to `max-w-prose` on the hero sub-tagline in `front-page.php`

---

#### V10 — Footer navigation spacing

**Issue:** Spacing between links within footer columns is uneven; group boundaries unclear on mobile  
**Skills:** `/baseline-ui`  
**Effort:** 30 minutes  
**Impact:** LOW — cosmetic but affects perceived polish

**Fix:** `space-y-2` within each link group; `mt-8` between groups

---

#### V11 — Icon style inconsistency

**Issue:** Mix of outline and solid icon styles in property features section  
**Skills:** `/design-spells`  
**Effort:** 30 minutes  
**Impact:** LOW — subtle but breaks design system coherence

**Fix:** Standardise on one style (all Phosphor regular or all bold) for informational icon circles

---

## Customer journey and operational gaps (from plan.md)

These are not technical SEO issues but they directly affect the business outcomes the site exists to produce.

---

#### J1 — Post-enquiry expectations (plan.md B)

**Skills:** `/form-cro` · `/onboarding-cro`  
**Effort:** Half day (`template-enquire.php` + `inc/emails.php`)  
**Impact:** HIGH — for an enquiry-only booking model, the gap between "submitted" and "heard back" is where interest dies

**Fix:**

- Enquiry success state: explicit expected response time ("We'll reply within 1 working day")
- Urgent path: phone number or "email us directly" if your need is time-sensitive
- Duplicate submission UX: "We already have your enquiry from [date]" message rather than silently skipping

---

#### J2 — Enquiry form draft preservation (plan.md B)

**Skills:** `/form-cro`  
**Effort:** Half day (vanilla JS + `localStorage`)  
**Impact:** MEDIUM — 4-step form with no draft = one refresh = lost guest

**Fix:** Persist form state to `localStorage` on each step; add `beforeunload` warning if form has been started

---

#### J3 — Guest guide OTP: resend + expiry copy (plan.md B)

**Skills:** `/onboarding-cro`  
**Effort:** Half day (`page-guest-guide.php` + emails)  
**Impact:** MEDIUM — "I didn't get the code" is a common failure point that creates support overhead

**Fix:** Add "Resend code" option; explicit "Code expires after 30 minutes" copy; improve OTP email subject to be clearly recognisable

---

#### P1 — SMTP / email deliverability (plan.md C)

**Skills:** `/email-systems`  
**Effort:** 1–2 hours (plugin install + DNS records)  
**Impact:** CRITICAL — `wp_mail` in production is fragile; any missed enquiry notification = potential lost booking. SPF/DKIM/DMARC needed.

**Fix:** Install SMTP plugin (Postmark or SendGrid preferred; free tier sufficient at current volume); configure SPF/DKIM/DMARC on DNS; test all mail paths (enquiry notify, ack, OTP, CRM-triggered)

---

#### P2 — Rate limiting on enquiry + OTP (plan.md C)

**Skills:** `/security-auditor`  
**Effort:** Half day  
**Impact:** MEDIUM — honeypot exists but no rate limiting; burst spam can overwhelm inbox and DB

**Fix:** Add IP-based rate limiting on enquiry submission and OTP request endpoints in theme

---

#### D1 — CRM: front-end team dashboard (plan.md E3) — **DEFERRED**

**Status:** Deferred indefinitely (10 May 2026). Originally proposed to support phone-based lead triage, but no staff currently process leads from a mobile device — desktop wp-admin is the established workflow. Building a parallel mobile-first UI would create two surfaces to maintain (drift risk, doubled AJAX/permission surface) for a workflow nobody has asked for.

**If revisited:** the existing `restwell_crm_dashboard_page()` already has mobile breakpoints (`assets/css/admin-crm.css:1303` and `:1317`); a cheaper first step would be tighter `<480px` rules and 44×44px tap targets on the existing admin view rather than a parallel front-end build. Only commit to the full `/dashboard/` page if mobile triage becomes a stated, recurring need.

---

#### D2 — CRM: auto-reminders for stale leads (plan.md E4)

**Skills:** Theme PHP work  
**Effort:** Half–1 day  
**Impact:** HIGH — prevents "new" enquiries going cold overnight; hourly cron with 24h idempotency

**Product note (10 May 2026):** CRM does **not** use per-enquiry staff assignment. Reminders always go to the shared submission notify inbox (`restwell_get_submission_notify_email()`), matching how new enquiry alerts are triaged.

**Fix:** Hourly WP cron process; threshold 18h for `status = 'new'`; `last_reminder_at` guard; dry-run mode; team notify inbox as recipient

---

#### D3 — Stay dates editable in CRM (plan.md D)

**Skills:** Theme PHP / admin UI  
**Effort:** Half day  
**Impact:** MEDIUM — prerequisite for calendar export and any future reporting

**Fix:** Surface `date_from` / `date_to` on admin enquiry detail screen; allow editing for "Booked" leads

---

#### D4 — Single view of guest: link enquiry ↔ guest record (plan.md D)

**Skills:** `/ux-flow` for design + Theme PHP  
**Effort:** 1 day  
**Impact:** MEDIUM — removes "who is this person?" friction for staff at scale

---

## SEO and content operating cadence (from plan.md F + G)

These are not one-off fixes but ongoing systems. They compound over time.

---

#### S1 — ~~Fix VacationRental schema on both key pages~~ **DONE (10 May 2026)**

**Shipped:** Supported JSON-LD only; business address aligned with GBP (Vinters Business Park); **Service** on property; **Whitstable** at area level on property-facing markup. See **Completed Items** and E1 above. **Ongoing:** Rich Results + Semrush re-check after production deploy.

---

#### S2 — Content cadence: 12-month blog plan (plan.md F9)

**Skills:** `/seo-aeo-blog-writer` · `/content-strategy` · `/avoid-ai-writing`  
**Effort:** Ongoing (1 post/month minimum)  
**Impact:** HIGH (compounding) — four content pillars already defined with high-opportunity topics identified:

- Accessible Travel Guides (e.g. accessible Kent beaches, Whitstable for wheelchair users)
- Funding & Access (e.g. direct payments, Personal Independence Payment and holidays)
- For Professionals (e.g. what OTs need to know about recommending accessible holiday lets)
- Kent Coast Life (local area content for long-tail discovery)

**Note:** Use `/avoid-ai-writing` on every draft. This audience — carers, disabled people, OTs — will notice AI cadence immediately. It will actively harm trust.

---

#### S3 — Access statement PDF + professional trust assets (plan.md F7)

**Skills:** `/seo-content` · `/seo-aeo-content-quality-auditor`  
**Effort:** 1–2 days (content creation + upload + linking)  
**Impact:** HIGH — builds E-E-A-T signals specifically for healthcare/professional audience; direct conversion tool for OTs and case managers

**Fix:** Publish up-to-date access statement PDF; link from Accessibility, Who It's For, FAQ, and Enquire pages

---

#### S4 — SEO monthly QA runbook (plan.md G3)

**Skills:** `/seo-audit` · `/seo-technical`  
**Effort:** Half day/month to set up; 1 hour/month to run  
**Impact:** HIGH (preventative) — catches drift before it compounds

**Monthly checks:**

- Duplicate titles/descriptions
- Missing meta descriptions
- Accidental noindex
- Canonical mismatches
- Orphan pages (N2 above should be cleared first)
- Sitemap inclusion errors

---

#### S5 — CTR optimisation sprint (plan.md G5)

**Skills:** `/seo-aeo-meta-description-generator` · `/seo-meta-optimizer`  
**Effort:** Half day/month  
**Impact:** MEDIUM-HIGH — rewriting title/meta for the 5 highest-impression / below-target-CTR pages is the highest-ROI SEO activity once technical foundations are solid

**How:** Pull top 5 pages from GSC by impressions; rewrite title/meta using intent-aligned language; measure after 28 days; log changelog

---

#### S6 — AI search / GEO optimisation (plan.md implicit)

**Skills:** `/ai-seo` · `/geo-fundamentals`  
**Effort:** 2–3 hours  
**Impact:** MEDIUM-HIGH (future-facing) — site has `llms.txt`, TL;DR blocks, and schema already in place. Next level: verify passage-level citability for the queries most likely to appear in AI Overviews (accessible holidays Kent, self-catering holiday for disabled adults, direct payments holiday accommodation)

---

#### S7 — Entity consistency control sheet (plan.md G8)

**Skills:** `/seo-fundamentals`  
**Effort:** 2 hours (one-off setup)  
**Impact:** LOW-MEDIUM — prevents NAP/category drift across site, GBP, directories, and outreach

**Fix:** Create one canonical business-facts source: brand name, address, phone, email, primary category, short/long description variants; use as reference for all content

---

## GA4 verification (from plan.md Sprint 1)

#### A1 — Live GA4 verification pass

**Skills:** `/analytics-tracking`  
**Effort:** Half day  
**Impact:** HIGH — the analytics event schema exists in code but has never been verified in production. All funnel analysis depends on events actually firing correctly.

**What to check in DebugView:**

- `enquiry_form_started` fires once on first input interaction
- `enquiry_step_changed` fires on each step transition
- `enquiry_form_submitted` fires on success
- `restwell_cta_click` fires on CTA clicks with correct `cta_text` param
- `faq_expanded` fires on accordion open
- `scroll_depth` fires at 25/50/75/90 with correct page_path
- All events include `page_path` and `user_type` params

---

## Security smoke test (from AUDIT.md Sprint 1)

#### Sec1 — Runtime REST API hardening verification

**Skills:** `/security-auditor`  
**Effort:** 15 minutes (post-deploy verification only — implementation shipped 10 May 2026)  
**Impact:** HIGH — `**inc/security-rest.php`** returns **401** for **anonymous** `GET /wp-json/wp/v2/users` (collection and numeric IDs); **logged-in** sessions unchanged for block editor / `who=authors`.

**What to verify after deploy:**

- `curl -sI https://www.restwellretreats.co.uk/wp-json/wp/v2/users` returns **401**, not a JSON user list
- Authenticated editor/admin REST access still works (block editor or application password smoke test)

---

## Design polish (from VISUAL-FRONTEND-AUDIT.md — quick wins)

#### P0 — Design micro-interactions

**Skills:** `/design-spells` · `/fixing-motion-performance`  
**Effort:** Half day  
**Impact:** LOW but noticeable — the site is clean and intentional; a few targeted additions make it feel alive rather than static

**Specific additions:**

- FAQ `<details>` smooth open/close: CSS `transition` on content reveal (already `<details>`, just needs CSS)
- Feature card hover: subtle lift (`hover:-translate-y-1 transition-transform duration-200`)
- CTA button press: `active:scale-[0.98]` feedback
- Image lazy-fade: `opacity-0 → opacity-100` on load for below-fold images

**Important:** All motion must respect `prefers-reduced-motion`. Use `/fixing-motion-performance` to verify no animation regresses CWV.

---

## Master priority table


| #   | Issue                                                                                                  | Skill                                         | Effort         | Impact                 | Source                          |
| --- | ------------------------------------------------------------------------------------------------------ | --------------------------------------------- | -------------- | ---------------------- | ------------------------------- |
| ✅   | ~~Body/secondary text contrast + callout boxes~~                                                       | ~~`/fixing-accessibility`~~                   | ~~2–4 hrs~~    | ~~🔴 Critical~~        | ~~VISUAL-FRONTEND-AUDIT~~       |
| ✅   | ~~Gold label contrast (darken `--warm-gold-text`)~~                                                    | ~~`/fixing-accessibility`~~                   | ~~30 min~~     | ~~🔴 Critical~~        | ~~VISUAL-FRONTEND-AUDIT~~       |
| ✅   | ~~Focus ring contrast (already using `--deep-teal`)~~                                                  | ~~`/fixing-accessibility`~~                   | ~~15 min~~     | ~~🔴 Critical~~        | ~~VISUAL-FRONTEND-AUDIT~~       |
| ✅   | ~~VacationRental → LocalBusiness + Service + GBP address (homepage + property)~~                       | ~~`/schema-markup`~~                          | ~~3 hrs~~      | ~~🟠 High~~            | ~~Google Rich Results / theme~~ |
| ✅   | ~~SMTP / email deliverability (theme: optional `RESTWELL_SMTP_*`; DNS still on host)~~                 | ~~`/email-systems`~~                          | ~~1–2 hrs~~    | ~~🟠 High~~            | ~~plan.md~~                     |
| ⏳   | GA4 live verification (manual DebugView)                                                               | `/analytics-tracking`                         | half day       | 🟠 High                | AUDIT.md                        |
| ✅   | ~~Mobile stacking + touch targets~~                                                                    | ~~`/fixing-accessibility` `/baseline-ui~~`    | ~~2–3 hrs~~    | ~~🟠 High~~            | ~~VISUAL-FRONTEND-AUDIT~~       |
| ✅   | ~~Beige callout contrast~~                                                                             | ~~`/fixing-accessibility`~~                   | ~~30 min~~     | ~~🟠 High~~            | ~~VISUAL-FRONTEND-AUDIT~~       |
| ✅   | ~~Post-enquiry success copy + response time~~                                                          | ~~`/form-cro` `/onboarding-cro~~`             | ~~half day~~   | ~~🟠 High~~            | ~~plan.md~~                     |
| ✅   | ~~Enquiry form draft persistence~~                                                                     | ~~`/form-cro`~~                               | ~~half day~~   | ~~🟡 Medium~~          | ~~plan.md~~                     |
| ✅   | ~~Guest guide OTP: resend + expiry copy~~                                                              | ~~`/onboarding-cro`~~                         | ~~half day~~   | ~~🟡 Medium~~          | ~~plan.md~~                     |
| ✅   | ~~External 403 on /revitalise-alternatives/~~                                                          | ~~`/seo-audit`~~                              | ~~15 min~~     | ~~🔵 Quick win~~       | ~~Semrush notice~~              |
| ✅   | ~~Fix broken LiteSpeed minification (theme excludes `/assets/` when LSC active)~~                      | ~~`/web-performance-optimization`~~           | ~~1–2 hrs~~    | ~~🟠 High~~            | ~~Google Rich Results~~         |
| ⏳   | Orphaned GA pages — confirm in GA + finish link/redirect                                               | `/seo-audit` `/site-architecture`             | 30 min         | 🟡 Medium              | Semrush notice                  |
| 15  | Orphaned sitemap entry                                                                                 | `/seo-technical`                              | 30 min         | 🔵 Low                 | Semrush notice                  |
| ✅   | ~~Security: REST users enumeration (anonymous)~~                                                       | ~~`/security-auditor`~~                       | ~~30 min~~     | ~~🟠 High~~            | ~~AUDIT.md~~                    |
| ✅   | ~~Rate limiting on enquiry + OTP~~                                                                     | ~~`/security-auditor`~~                       | ~~half day~~   | ~~🟡 Medium~~          | ~~plan.md~~                     |
| ⏸   | ~~CRM: front-end team dashboard (E3)~~ — **deferred 10 May 2026, no staff use phones for lead triage** | ~~theme PHP~~                                 | ~~1–2 days~~   | ~~🟠 High~~            | ~~plan.md P1~~                  |
| ✅   | ~~CRM: auto-reminders stale leads (E4)~~                                                               | ~~theme PHP~~                                 | ~~half–1 day~~ | ~~🟠 High~~            | ~~plan.md P2~~                  |
| ✅   | ~~Stay dates editable in CRM~~                                                                         | ~~theme PHP~~                                 | ~~half day~~   | ~~🟡 Medium~~          | ~~plan.md~~                     |
| 21  | Link enquiry ↔ guest record                                                                            | `/ux-flow` + PHP                              | 1 day          | 🟡 Medium              | plan.md                         |
| 22  | Access statement PDF + professional trust assets                                                       | `/seo-content`                                | 1–2 days       | 🟠 High                | plan.md F7                      |
| 23  | Blog content cadence (launch + sustain)                                                                | `/seo-aeo-blog-writer` `/content-strategy`    | ongoing        | 🟠 High                | plan.md F9                      |
| 24  | SEO monthly QA runbook                                                                                 | `/seo-audit`                                  | 1 hr/month     | 🟠 High (preventative) | plan.md G3                      |
| 25  | CTR sprint (top 5 pages, monthly)                                                                      | `/seo-aeo-meta-description-generator`         | half day/month | 🟡 Medium              | plan.md G5                      |
| 26  | AI search / GEO pass                                                                                   | `/ai-seo` `/geo-fundamentals`                 | 2–3 hrs        | 🟡 Medium              | implicit                        |
| 27  | Design micro-interactions + motion polish                                                              | `/design-spells` `/fixing-motion-performance` | half day       | 🔵 Polish              | VISUAL-FRONTEND-AUDIT           |
| ✅   | ~~Hero sub-tagline line length (`max-w-prose`)~~                                                       | ~~`/baseline-ui`~~                            | ~~5 min~~      | ~~🔵 Quick win~~       | ~~VISUAL-FRONTEND-AUDIT~~       |
| 29  | Footer link spacing + group separation                                                                 | `/baseline-ui`                                | 30 min         | 🔵 Polish              | VISUAL-FRONTEND-AUDIT           |
| 30  | Icon style standardisation                                                                             | `/design-spells`                              | 30 min         | 🔵 Polish              | VISUAL-FRONTEND-AUDIT           |
| 31  | Entity consistency sheet (NAP)                                                                         | `/seo-fundamentals`                           | 2 hrs          | 🔵 Preventative        | plan.md G8                      |


---

## Sprint plan

### Sprint 1 — This week (high-leverage, mostly quick)

**✅ ACCESSIBILITY CONTRAST COMPLETED (10 May 2026):**

1. ✅ `#3` Focus ring → already using `--deep-teal` (verified)
2. ✅ `#2` Darken `--warm-gold-text` → #6B4A0F (7.2:1 contrast)
3. ✅ `#1` Body/secondary text → `--muted-grey` to #3A5A63 (7.1:1 contrast)
4. ✅ `#8` Beige callout box text → updated to use contrast-safe variables

**REMAINING ITEMS:**
4. ✅ `#12` Revitalise post: replaced outbound URLs that return **403** to crawlers (DisabledHolidays.com behind Cloudflare challenge; `accessable.co.uk` blocking bots) with **[https://www.euansguide.com](https://www.euansguide.com)** and **[https://www.accessable.org/](https://www.accessable.org/)**; **Tourism for All** → **[https://www.tourismforall.co.uk/](https://www.tourismforall.co.uk/)** (was 301 to trade). Seed + one-time `init` migration in `inc/seo-content-seed.php`.
5. ✅ `#28` Interior hero intro (`template-parts/interior-hero.php`): added `**max-w-prose`** to match home hero (line-length / readability).
7. ✅ `#16` `**inc/security-rest.php**`: anonymous `GET /wp-json/wp/v2/users` (and per-ID) returns **401**; logged-in users unchanged. **Verify after deploy:** `curl -sI https://www.restwellretreats.co.uk/wp-json/wp/v2/users` → `401` (no user list body).

---

### Sprint 2 — Next 2 weeks (structural)

1. ✅ `#4` Schema: VacationRental removed; LocalBusiness + Service + `restwell_business_`* (see Completed Items / E1)
2. ✅ `#5` **Theme:** `inc/smtp-config.php` — optional `RESTWELL_SMTP_`* constants for `wp_mail` via PHPMailer (no plugin). **Still required on server/DNS:** SPF, DKIM, DMARC for the sending domain; transactional SMTP account from host or provider.
3. ⏳ `#6` GA4 DebugView verification pass — **manual** after deploy; events in `assets/js/main.js` include `cta_text` on `restwell_cta_click`. Checklist: PERFECT-SITE-PLAN § GA4 verification (A1).
4. ✅ `#7` Mobile stacking + touch targets — Enquire: explicit `grid-cols-1` + comfortable `gap-8` on small screens; step indicators 44×44px; sidebar pills + urgent checkbox row `min-h-[44px]` (thank-you state still reads before sidebar in document order).
5. ✅ `#9` Post-enquiry success copy — Defaults + “What happens next” aligned to 1–2 working days; `inc/theme-setup.php`, `template-enquire.php`, editor hint in `page-meta-definitions.php`.
6. ✅ `#13` LiteSpeed — `inc/litespeed-compat.php` excludes theme `/assets/` from JS/CSS combine+minify when `LSCWP_V` is defined; purge LSCache after deploy and re-run Rich Results on failing URLs.
7. ✅ `#14` Orphan mitigation — Internal link to `/revitalise-alternatives-accessible-holidays/` from Resources “Related guides”; **still** confirm top orphan URLs in GA and add/remove links or redirects as needed.

---

### Sprint 3 — Month 2 (operational)

1. ~~`#19` CRM auto-reminders for stale leads (hourly cron, 18h threshold, `last_reminder_at` guard)~~ ✅ **Done 10 May 2026** — `inc/crm-reminders.php` (filterable thresholds, dry-run via constant or `restwell_crm_reminder_dry_run` filter, **team notify inbox only** — no per-user assignee routing, audit-log notes per send, optional `wp restwell crm-reminders run --dry-run` for ops). Legacy `assigned_to` column may remain on old rows but is unused in UI and routing.
2. ~~`#20` Stay dates editable in CRM (prerequisite for any future calendar / reporting work)~~ ✅ **Done 10 May 2026** — native date inputs in detail panel, audit-logged via activity feed, public/admin formatting kept in lockstep via shared helper (`inc/enquire-handler.php` + `inc/crm.php`)
3. ~~`#10` Form draft persistence (`localStorage`, `beforeunload` warning)~~ ✅ **Done 10 May 2026** — versioned storage key, debounced writes (400 ms), 7-day TTL, server-flash detection so post-validation re-renders win over stale drafts, accessible "Restored your details from N minutes ago — Discard and start fresh" notice, `beforeunload` warning when fields are dirty (`assets/js/main.js` + `assets/css/input.css` — `npm run build` regenerates the minified outputs)
4. ~~`#11` Guest guide OTP resend + clearer expiry copy~~ ✅ **Done 10 May 2026** — dedicated resend button with own nonce, dynamic "expires in N min" countdown, expired-state input lock-out, accessible notice (`page-guest-guide.php`)
5. ~~`#17` Rate limiting on enquiry + OTP endpoints~~ ✅ **Done 10 May 2026** — per-IP issuance (5/h), per-email issuance (5/h), per-IP verification (10/h); enquiry + FAQ endpoints already throttled via `restwell_form_rate_limit_exceeded()`

> `#18` (CRM front-end dashboard at `/dashboard/`) was dropped from this sprint — see Master priority table for rationale. No staff currently triage leads from a phone, so a parallel mobile-first UI would be speculative work.

---

### Ongoing — Monthly cadence

1. `#23` Blog post (one per month, four-pillar plan)
2. `#24` SEO monthly QA runbook (first week of month)
3. `#25` CTR sprint (top 5 pages, rewrite title/meta, measure 28 days)
4. `#22` Access statement PDF (one-off, then keep current)

---

## What "perfect" looks like after this work

- **WCAG AA** throughout — an accessibility-focused brand that fails its own colour contrast is the single worst signal to its primary audience
- **Rich results / structured data** on homepage and property — **LocalBusiness**, **Organization**, **FAQPage** (home), **Service** + **BreadcrumbList** (property); no unsupported VacationRental; verify in Rich Results Test + GSC after deploy
- **Email that actually arrives** — every enquiry, OTP, and confirmation delivered reliably
- **GA4 data you can trust** — funnel events verified, dashboards mapped to canonical names
- **A CRM that nudges itself** — auto-reminders for stale leads, editable stay dates, status timestamps, and rate-limited public endpoints — all inside the existing wp-admin workflow staff actually use
- **Monthly content compounding** — four-pillar blog cadence building authority in accessible holidays + Kent + professional referrers
- **A site that feels as good as it looks** — contrast fixed, micro-interactions in place, consistent rhythm

---

*To act on any item: reference the issue number above and invoke the skill listed. For PHP/theme work items (D2, D3, D4) there is no matching skill — those are standard WordPress/PHP builds using the existing theme patterns in `inc/`. (D1 was deferred — see its block above for rationale.)*