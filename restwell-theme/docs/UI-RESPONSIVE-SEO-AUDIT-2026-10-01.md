# UI, responsive and SEO audit, 1 October 2026

Audit of the rendered Restwell Retreats theme in a local WordPress Playground, with a read-only check of the live site. Decisions recorded on 1 October 2026 are included. The live tracker for these issues (status, ratings, evidence) is the **Restwell Audit Tracker** artifact; issue IDs below (I01–I46) match it.

This document does not replace the SEO records. Lane ownership and titles stay in [`docs/seo/LANES.md`](seo/LANES.md) and [`copy-overwrites/`](../copy-overwrites/), which you confirmed on 1 Oct as the source of truth for SEO decisions.

---

## 1. Executive assessment

**Overall: 6.9 / 10.** The site is calm, consistent and well built at the component level. Its responsive behaviour and accessibility are already strong. The weaknesses are in the plumbing around the pages rather than the pages themselves: SEO output that doubles up or truncates, images served at one size for every screen, conversion tracking that can double count, and a live site running an older build than the repo.

| Area | Score | Summary |
|---|---|---|
| Visual polish and warmth | 6.8 | Calm and real; heroes too dark, some photos uneven |
| Consistency across pages | 7.5 | One interior pattern everywhere; eyebrow and alignment rules drift |
| Responsive behaviour | 8.5 | No overflow on 26 pages at 7 widths |
| Spacing and rhythm | 8.0 | Token-led; spacing gate passes; design doc out of date |
| Typography and hierarchy | 8.0 | One H1 per page, no skipped levels |
| Navigation and interactions | 8.5 | Mobile menu handles inert, focus trap and Escape |
| Forms and functionality | 7.3 | Accessible forms; date-order check late; no site search |
| Accessibility | 8.0 | Contrast passes; small target and naming gaps |
| Technical SEO | 6.0 | Doubled canonicals, indexing drift, links via redirects |
| On-page and search appearance | 6.3 | Strong H1s; cut descriptions, keyword-string post titles |
| Structured data | 6.0 | Rich graph; address conflict, entity encoding |
| Internal links and architecture | 7.0 | Nav covers everything; orphan categories |
| Images and image SEO | 4.5 | Good alt text; no `srcset` anywhere |
| Performance risk (lab only) | 5.5 | CLS 0; 250 KB render-blocking CSS; oversize images |
| Analytics and consent | 5.5 | Consent correct; conversions can double count |
| AI-search clarity | 7.5 | Entities clear; one contradiction (address) |

Scores are judgements from the evidence, not measured metrics.

**Five most important confirmed issues**

1. **Production has no blog posts, and the live FAQ links to one that 404s** (I01). The five guides your lanes keep indexable are not live.
2. **Two `rel=canonical` tags on every page, live and in the repo** (I04). They match today; a custom canonical would make them conflict.
3. **The property address is public in schema and Terms, while the homepage says it is sent after booking** (I02). Live on production.
4. **Enquiry conversions fire on any visit to `/enquire/?sent=1`** (I03). Refreshes and shared links count again.
5. **No responsive images: 0 of 373 `<img>` tags have `srcset`** (I05). Phones download 2.6–5× the pixels they show; desktop heroes are 1024px files stretched to 1440px.

**P0 risks:** none found.
**P1 risks:** I01, I02, I03.

---

## 2. Environment and audit limitations

**Environment**

- WordPress Playground CLI, PHP 8.3, WordPress 7.1.2, at `http://localhost:9410` (port 9400 belongs to another project).
- `restwell-theme` mounted read-write; the active theme is Restwell Retreats.
- The blueprint runs the theme's own Theme Setup (non-forced, no media seed), so pages and the 19 posts come from theme seed content, not the production database.
- The audit crawl ran logged out (Playground's auto-login cookie only). Browser checks ran logged out after signing out the Playground admin.
- Your Outlook iCal feed was connected locally for calendar testing (108 booked nights).

**Production check (read-only, 1 Oct 2026):** 16 live pages, `robots.txt`, the sitemap index and four post URLs, fetched as an anonymous visitor. Production runs an **older theme build** than the repo: no TikTok config, a different Our Story social image, and no homepage care-section colon. Each issue in the tracker says whether it is live today or arrives with the next deploy.

**Limitations**

- **CSP:** the theme sends its report-only policy over HTTPS only; Playground is HTTP, so no CSP report was observed.
- **Performance:** lab only. The browser pane was hidden during loads, so lab LCP could not be measured (first paint waited for visibility). No field data (CrUX, Search Console) was available.
- **Analytics:** no GA4, TikTok or Metricool access; event behaviour was read from code.
- **Email and records:** no form was submitted, so CRM writes and emails were not exercised. The guest-guide "Send code" step was not pressed.
- **Media:** the Playground hero images are WordPress 1024×640 intermediates from the setup seed; production media may differ.
- **Screenshots at 1440px:** the pane scales wide viewports and sometimes paints stale frames; desktop findings were confirmed with computed styles, not screenshots alone.

**Changes made during the audit (outside the remediation plan, uncommitted)**

| Change | Files | Why |
|---|---|---|
| Playground preview config | `.claude/launch.json`, `.claude/playground-blueprint.json` | Repo-relative paths, port 9410, run Theme Setup so posts exist |
| Local iCal config | `.claude/playground-local/` (contents gitignored) | Calendar survives Playground restarts |
| Footer credit | `footer.php`, `assets/css/shared.css` | Requested: "Website Design by Ellie Smith" linked to LinkedIn |
| Availability calendar overhaul | `template-parts/availability-calendar.php`, `assets/js/availability.js` (+ `.min.js`), `assets/css/shared.css`, `assets/css/polish.css`, `tests/OccupancyCopyTest.php` | Requested redesign; closes I43 and I44 |

---

## 3. What already works well

Keep these. Remediation should not replace them.

- **No horizontal overflow** on any of 26 pages at 320, 375, 430, 768, 1024, 1280 and 1440px (182 runs). Nothing renders under 12px; body copy is 17px.
- **Heading structure:** exactly one H1 per page and no skipped levels on every crawled page.
- **Interior page system:** photo hero, breadcrumb, sticky section tabs with a working scrollspy, used consistently.
- **Mobile menu:** `aria-expanded` and label swap, `inert` background, focus trap, Escape returns focus, 44px targets.
- **Enquiry form:** every field labelled; errors linked with `aria-describedby`; focus moves to the first invalid field.
- **Contrast:** passes on all 16 pages measured. Hero text holds about 6.7:1 even over the lightest possible pixel.
- **Spacing system:** token-led (419 token uses against 11 raw values in `shared.css`); `tools/_check_spacing.py` passes.
- **Cookie banner:** Reject and Accept have equal weight; no analytics loads before consent.
- **Status codes:** real 404 with useful links; search results and 404 are `noindex`; guest guide is `noindex, follow` and gated; `/contact/`, `/news/`, `/resources/` redirect in one hop.
- **Accessibility page:** real millimetres and safe working loads; prices come from one source (`inc/pricing.php`) and match schema.
- **Real photography** of the bungalow, wet room and equipment.
- **llms.txt** names Restwell, Continuity and the CQC location plainly.
- **Availability calendar (after overhaul):** two-month board, nightly prices, hatched booked nights, continuous stay band, keyboard grid, live announcements, dates carried into the enquiry.

---

## 4. Cross-site systemic findings

| ID | Finding | Issues |
|---|---|---|
| S1 | SEO head output is assembled twice or trimmed carelessly: duplicate canonical, duplicate robots meta, byte-based trimming that cuts sentences and leaves stray pipes | I04, I09, I10, I11 |
| S2 | Images bypass WordPress's responsive pipeline: theme assets are printed as single files, heroes use the 1024px intermediate | I05, I07, I20 |
| S3 | Decisions live in docs but not in code: the 14-post noindex split, FAQ schema stance, address policy | I01, I02, I16 |
| S4 | Records drift from the site: `/resources/` slug, matrix missing `/optional-care/` and `/our-story/`, design doc describing old class names | I12, I13, I41 |
| S5 | Production runs an older build than the repo, with no posts published | I01 and live-only notes in each issue |
| S6 | Hero treatment is cold: photo at 62% opacity under a dark teal gradient on every interior page | I24, I25 |
| S7 | Conversion measurement can double count and depends on hard-coded config | I03, I14 |

---

## 5. Responsive test matrix

26 pages × 7 widths, probed in same-origin iframes (overflow, text size, targets, image sizing, rails), plus manual screenshots at 375 and 1280–1440.

| Width | Overflow | Smallest text | Content rail | H1 (home / interior) | Notes |
|---|---|---|---|---|---|
| 320 | none | 12px | 24px | 30px / 30px, 3 lines | Calendar tiles 34px wide; circle shrinks to 32px |
| 375 | none | 12px | 24px | 31px / 30px | Back-to-top overlaps footer text (I27) |
| 430 | none | 12px | 24px | 33px / 32px | |
| 768 | none | 12px | 38px | 51px / 38px | Calendar shows one month (max 28rem) |
| 1024 | none | 12px | 40px | 58px / 43px | Calendar shows two months |
| 1280 | none | 12px | centred 1200 container | 58px / 43px | Funding block up to 151 characters per line (I42) |
| 1440 | none | 12px | centred 1200 container | 58px / 43px | Hero images upscaled ~2.8× at DPR 2 (I05) |

**Targets under 24px:** FAQ question-form consent checkbox (18×18) and two external links on Funding (21px tall); may pass on the spacing exception (I37).
**Natural reflow, not defects:** sticky section tabs scroll sideways on phones; the pricing table becomes stacked blocks under 640px.

---

## 6. Spacing-system findings

- **Healthy:** sections use `section-y` / `section-y--compact` (92 uses); the spacing gate passes; rails are consistent (24px phones, 38–40px tablets, centred 1200px container).
- **I41 (P3):** `DESIGN-SYSTEM.md` documents `rw-section-y*` utilities and `input.css`, neither of which exists. `template-parts/pricing-cross-links.php` still uses the dead class `rw-section-y--compact`; `template-parts/post-cluster-links.php` uses raw `pt-8 mt-2`.
- **I26 (P3):** mixed centred and left alignment between neighbouring sections; centred multi-line body copy on How it works (mobile).
- **I42 (P3):** legal pages and Optional care run about 88 characters per line; one Funding block reaches 151 at 1280px+.

---

## 7. Shared-component findings

| Component | Status | Notes |
|---|---|---|
| Header | Good | Solid state switches with a 0.35s fade that briefly shows a white logo over white content (I35) |
| Logo | Decided | Accessible name becomes "Restwell Retreats"; visual logo unchanged (I36) |
| Mobile navigation | Pass | See section 3 |
| Footer | Gaps | No links to main pages (I34); credit line added 1 Oct |
| Back-to-top | Defect | Covers text on phones (I27); now hidden while the calendar is on screen |
| Breadcrumbs | Pass | Visible trail matches schema, apart from `&amp;` in schema names (I15) |
| Section tabs + scrollspy | Pass | Verified on Property across all nine anchors |
| Hero | Recommendation | Lighten scrim, keep 4.5:1 (I24); eyebrow on some pages only (I25) |
| Testimonial cards | Polish | Tiny stray quote glyph (I28) |
| Blog and category cards | Polish | White text on a beige placeholder until the photo loads (I39); stock images repeat (I20) |
| Cookie banner | Pass | Equal-weight choices, no pre-consent scripts |
| Availability calendar | Done | Overhauled 1 Oct (I43, I44) |

---

## 8. Page-by-page findings

| Page | Key findings |
|---|---|
| Home | Care section ends "…whichever you choose:" with the two options never rendered (I08, repo only). Hero is dark and empty above the H1 on phones (I24). Room photos uneven (I29). |
| The Property | Strong room-by-room structure and scrollspy. Hero 1024px upscaled on desktop (I05). |
| Accessibility | Best page on the site for evidence. Eyebrow present (I25). |
| Pricing | Rates table accessible (caption, scoped headers). Calendar overhauled. |
| How it works | Centred body paragraph on phones (I26). Title and description fine; description cut mid-sentence (I10). |
| Who it's for | Clear fit framing. Description fine. |
| Whitstable area guide | Useful, specific local detail; description cut (I10). |
| Funding & Support | Long line (I42); small external link targets (I37); title has no brand but `og:title` does. |
| FAQ | Question form uses browser pop-up errors (I45) and requires phone (I22). FAQPage schema kept with parity test (I16). |
| Enquire | Step 2 accepts departure before arrival and over five guests (I21). Contact preference to be removed (I22). |
| Optional care | Clear sister-company explanation; ~88-character lines (I42). |
| Our Story | Stock photo of a different house (I23, decided: keep). Not in LANES.md (record gap). |
| Guest guide | Correct `noindex, follow`; clean one-time-code flow. |
| Blog index | Lead card is one of the 14 mill posts; featured image lazy-loaded (I07); no category links (I31). |
| Blog posts | No byline; US date format (I19). Keyword-string titles (I18). Same social image on all 19 (I20). |
| Category archives | Thin, two unlinked, "Uncategorized" live and empty; garbled descriptions (I11, I31). |
| Search | Correct `noindex`; no search box anywhere, even on empty results (I30). |
| 404 | Correct status, `noindex`, helpful cards. No search box (I30). |
| Privacy | Proper version label. |
| Terms | Publishes the full address (I02); generated "Last updated" month (I40); 18 sections, no contents list (I46). |
| Website accessibility statement | Generated "Last updated" month (I40). |

---

## 9. Functional defects

| ID | Defect | Priority |
|---|---|---|
| I03 | Conversion events fire on any `/enquire/?sent=1` load | P1 |
| I21 | Enquiry step 2 accepts departure before arrival and more than five guests; server catches dates only after full submit | P2 |
| I22 | Contact preference conflicts with a required phone number (decided: remove the preference field) | P3 |
| I30 | No search box anywhere; WebSite schema still declares a SearchAction | P3 |
| I45 | FAQ question form shows browser pop-ups instead of inline errors | P3 |
| I32 | Missing static files 301 to the homepage (cause not traced) | P3 |
| ~~Calendar~~ | Crossing bookings, leaving on a booked morning, unselecting, keyboard paging: all fixed in the overhaul | Done |

Not defects (checked): scrollspy, mobile menu, Escape on dialogs, cookie banner, enquiry error focus.

---

## 10. Accessibility findings

**Confirmed (WCAG 2.2 AA)**

| ID | Finding | Criterion |
|---|---|---|
| I37 | 18×18 consent checkbox; 21px-tall external links | 2.5.8 Target size (may meet the spacing exception) |
| I27 | Back-to-top covers text on phones | 1.4.10 / usability |
| I44 | Calendar dialog unnamed, required markers missing, focus return wrong | 4.1.2, 3.3.2, 2.4.3 (fixed 1 Oct) |
| I45 | Errors as transient browser bubbles on the FAQ form | 3.3.1 (best practice) |

**Passes:** skip link, landmarks, one H1, focus visibility, labels, `aria-describedby` errors, live regions, reduced motion respected, contrast (16 pages), reflow at 320px.

**Needs assistive-technology verification:** VoiceOver and NVDA reading of the calendar grid (`role="grid"` with roving tab stop), the multi-step enquiry dialog, and the sticky section tabs; zoom to 200% and 400% on Pricing and Enquire.

---

## 11. SEO strategy and page-purpose findings

Primaries and jobs come from `docs/seo/LANES.md`. Classification uses the requested labels.

| URL | Job (LANES) | Classification | Notes |
|---|---|---|---|
| `/` | Private accessible house by the sea | Refresh | Fix care section (I08); keep title |
| `/the-property/` | Rooms and layout | Keep | Image delivery only |
| `/accessibility/` | Access statement in millimetres | Keep | Strongest evidence page |
| `/pricing/` | Tariff and deposits | Keep | Calendar now live with real occupancy |
| `/how-it-works/` | Enquire → confirm → arrive | Refresh | Description cut (I10) |
| `/who-its-for/` | Fit | Keep | |
| `/funding-and-support/` | How a break might be paid for | Technical repair | Records still say `/resources/` (I12, I13) |
| `/whitstable-area-guide/` | Honest local days out | Keep | |
| `/enquire/` | Conversion | Technical repair | I03, I21, I22 |
| `/optional-care/` | Adding Continuity care | Keep | Missing from progress matrix (I13) |
| `/our-story/` | Not in LANES | Deliberate no-action (lane) | Record gap: give it a lane row or mark it utility |
| `/faq/` | Short answers that link out | Improve internal links | Fix live link to missing guide (I01) |
| `/blog/` | Editorial index | Expand | Publish posts per I01 decision |
| 5 keep-guides | Specific guide intents | Expand | Not live; publish first (I01) |
| 14 mill posts | Supporting, `noindex, follow` | Technical repair | Enforce noindex in code before publishing (I01) |
| Category archives | Browsing | Technical repair | I31 decision |
| Legal pages | Compliance | Keep | Dates (I40) |

No cannibalisation found between live pages; the lanes hold.

---

## 12. Technical SEO findings

- **Canonicals (I04):** two tags on every singular page, from `inc/seo/canonical.php` and WordPress core `rel_canonical`. Live on 15 of 16 production pages.
- **Robots meta:** guest guide prints two robots tags (core + theme). Harmless today; folded into I04.
- **Statuses:** 200 for all pages; real 404 for unknown URLs, `?p=1`, `/sample-page/`, `/hello-world/`, `/thank-you/`, `/tag/kent/`.
- **Redirects:** `/contact/` → `/enquire/`, `/news/` → `/blog/`, `/resources/` → `/funding-and-support/`, `/author/admin/` → `/`, `/the-property` → `/the-property/`; all single-hop 301s.
- **Case:** `/THE-PROPERTY/` returns 200 with a lowercase canonical. Acceptable.
- **Search:** `noindex, follow`, not in sitemap. Parameter crawl space controlled.
- **`robots.txt`:** valid, references the sitemap. AI-crawler groups override the `*` group, so `/wp-admin/` is not disallowed for them (I33, low impact).
- **Soft 404 for assets (I32):** missing CSS returns a WordPress 301 to `/`.
- **Indexing decision not enforced (I01):** nothing in code applies `noindex` to the 14 mill posts.

---

## 13. On-page and search-appearance findings

- **H1s:** strong, human and distinct from titles, as LANES intends.
- **Titles:** page titles fine. Post titles read as keyword strings, e.g. "Holiday Backup Plan Care Worker Change" (I18). Funding page title has no brand while its `og:title` does.
- **Meta descriptions (I10):** authored copy longer than 160 bytes is cut mid-sentence ("…Care can go on the"). Category descriptions garbled (I11).
- **Open Graph (I09, I20):** three `og:title`s end in "|"; all 19 posts share one `og:image`.
- **Authorship and dates (I19):** no byline; dates in US format. Decided: byline "Ellie Smith", UK dates, Person in schema.
- **Copy standards (I38):** em dashes and spaced hyphens in a few strings.

All copy changes go through `copy-overwrites/` and need your approval before shipping.

---

## 14. Sitemap, canonical and indexability matrix

| URL group | Playground status | Playground indexable / in sitemap | Production status | Production indexable / in sitemap |
|---|---|---|---|---|
| 16 pages (home, property, accessibility, pricing, how it works, who it's for, funding, area guide, enquire, optional care, our story, FAQ, blog, 3 legal) | 200 | Yes / Yes | 200 | Yes / Yes |
| Guest guide | 200 | `noindex, follow` / No | not checked | |
| 5 keep-guides | 200 | Yes / Yes | **404** | n/a |
| 14 mill posts | 200 | **Yes / Yes** (should be noindex) | **404** | n/a |
| 4 categories | 200 | Yes / Yes | not in sitemap | not checked |
| `/category/uncategorized/` | 200, empty | Yes / No | not checked | |
| Search, 404 | 200 / 404 | `noindex` / No | | |
| Redirects (`/contact/`, `/news/`, `/resources/`, author) | 301 | n/a / No | | |

Sitemap uses absolute URLs for the current host; no attachments, users or tags. On production it lists the 16 pages only.

---

## 15. Internal-link and architecture findings

- **Navigation:** every page is linked from the primary nav (46 pages each).
- **Links through redirects (I12):** seven post-body links point to `/resources/`.
- **Live broken link (I01):** the production FAQ links to `/direct-payment-holiday-accommodation/` (404).
- **Orphans:** `/category/accessible-holidays/` and `/category/news-updates/` have no inbound links but are in the sitemap; `/category/uncategorized/` has none and is empty (I31).
- **Weakly linked guides:** `/revitalise-alternatives-accessible-holidays/` (4 in-content links), `/accessible-train-travel-whitstable-kent/` (3).
- **Our Story:** reachable only from navigation (0 in-content links).
- **Footer:** utility links only (I34).
- **Anchors:** descriptive throughout; the only empty-text anchors are logo links, which carry an accessible name.

---

## 16. Structured-data findings

| Template | Types |
|---|---|
| Home | WebSite, WebPage, Organization, LodgingBusiness, FAQPage |
| Property | Organization, LodgingBusiness, Service, BreadcrumbList |
| Pricing | Organization, BreadcrumbList, FAQPage, LodgingBusiness |
| Accessibility, Who it's for, legal | WebPage, BreadcrumbList |
| Funding | CollectionPage, FAQPage, BreadcrumbList |
| Optional care | Service (provider Continuity), FAQPage |
| Area guide | TouristDestination |
| Posts | BlogPosting (author Organization), BreadcrumbList |

**Issues**

- **I02:** LodgingBusiness publishes `streetAddress` and postcode. Decided: locality only.
- **I15:** `&amp;` in breadcrumb names and `articleSection`.
- **I16:** FAQPage kept; add a parity test so schema matches visible questions.
- **I17:** amenity "High-speed broadband throughout" not visible on checked pages.
- **I19:** BlogPosting author should become a Person.
- **I30:** WebSite SearchAction with no search UI.
- **Verified correct:** `priceRange` "£185-£1,400" matches `inc/pricing.php`; CQC rating sits on Continuity, not Restwell.

Schema eligibility does not guarantee rich results.

---

## 17. Local SEO findings

- **Name and phone:** consistent ("Restwell Retreats", 01622 809881).
- **Two addresses:** Organization uses the Maidstone business address; LodgingBusiness uses the Whitstable property. Correct in principle; the property street is the open decision (I02).
- **Address exposure:** schema, Terms and two image filenames (`101-russel-drive-archive.webp`, `russell-drive-whitstable.webp`) reveal the street, against the homepage line.
- **Area guide:** genuinely useful (level routes vs shingle, named venues with postcodes). No doorway pages; no implied service areas.
- **Social profiles:** consistent across schema, llms.txt and footer.

---

## 18. Image and visual-search findings

- **Alt text:** 0 of 373 images missing `alt`; 127 decorative with empty `alt` (correct).
- **Dimensions:** 54 without width/height, 46 of them the empty lightbox placeholder.
- **Responsive delivery (I05):** 0 `srcset`, 0 `<picture>`. Worst ratios on phones: `BD2-3-LS.webp` 5.1×, `wet-room-shower.webp` 4.8×, `cqc-rating-good.webp` 5.0×. Hero intermediates are 0.36× at 1440px on DPR 2 (blurry).
- **LCP priority:** heroes preloaded with `fetchpriority="high"` (good). Blog featured card is lazy (I07, P3).
- **Social images (I20):** one image for all posts; stock photos repeated across cards.
- **Filenames:** descriptive; two reveal the street (I02).
- **Photography (I29):** decided to re-crop and straighten the weakest originals, with approval per image.

---

## 19. AI-search presentation findings

- Restwell, the bungalow, Whitstable and Continuity are named unambiguously; the CQC rating is attributed to Continuity.
- Facts (millimetres, safe working loads, prices) sit next to their headings; FAQs answer real guest questions.
- **llms.txt** is accurate except "address sent after a booking is confirmed", which contradicts schema and Terms (I02).
- Posts lack visible authorship and review dates (I19).

No format guarantees inclusion or citation in AI answers.

---

## 20. Performance and Core Web Vitals findings

All figures are **lab, local Playground**; no field data was available.

- **CLS:** 0 on all key pages measured in a real tab (one 0.0003 font-swap shift on Our Story).
- **TTFB:** 0.5–0.7s (Playground PHP; not representative of production).
- **LCP:** not measurable (hidden pane delayed first paint). Hero images downloaded within ~0.5s locally.
- **Render-blocking CSS (I06):** four stylesheets; `shared.css` is 250 KB unminified.
- **JavaScript:** all theme scripts deferred; analytics consent-gated.
- **Images (I05):** the largest LCP risk on mobile.
- **Fonts:** self-hosted Inter and Lora, `font-display` swap causing the one small shift.

Validate after deploy with CrUX or Search Console Core Web Vitals (LCP ≤ 2.5s, INP ≤ 200ms, CLS ≤ 0.1).

---

## 21. Analytics and conversion-measurement findings

- **Consent:** correct. Nothing loads before Accept; Reject and Accept have equal weight.
- **Events (from code):** `enquiry_form_submitted`, `faq_expanded`, `scroll_depth`, `property_page_viewed`, `accessibility_spec_viewed`, `phone_number_clicked`, `email_clicked`, `restwell_cta_click`, TikTok `Lead`.
- **I03 (P1):** the conversion fires on any `?sent=1` load; GA4 has no de-duplication, TikTok de-duplicates per session only.
- **I14:** TikTok pixel ID hard-coded as the default; TikTok hosts missing from the CSP. Decided: move to settings.
- **Attempted vs completed:** no "enquiry started" or validation-error events, so drop-off cannot be measured.
- **Personal data:** none in event parameters (paths only).
- **Development traffic:** no environment guard; Playground would send events after consent if IDs were configured.
- **Release dates:** record each deploy date alongside GA4 annotations so before/after comparisons are possible.

---

## 22. Prioritised remediation backlog

Status as of 2 Oct 2026. "Approved" means you made the decision on 1 Oct; copy, legal wording and image choices still come back to you before shipping.

| ID | Priority | Area | Issue | Decision / status | Batch |
|---|---|---|---|---|---|
| I01 | P1 | Technical SEO | No posts live; FAQ link 404s; noindex split not enforced | Approved: publish all 19 once fully written; 5 keep-guides first, rest scheduled forward with true dates; 14 noindex in code; fix FAQ link | 3, 5 |
| I02 | P1 | Structured data | Address public in schema and Terms | Approved: keep private (locality only; Terms wording for sign-off; rename files) | 4 |
| I03 | P1 | Analytics | Conversions fire on any `?sent=1` | Open | 7 |
| I04 | P2 | Technical SEO | Two canonicals | Open | 1 |
| I05 | P2 | Images | No `srcset` | Open | 1 |
| I06 | P2 | Performance | 250 KB render-blocking CSS | Open | 1 |
| I07 | P3 | Performance | Blog featured image lazy | Open | 5 |
| I08 | P2 | Homepage | Care options never render | Approved: render existing options + label | 4 |
| I09 | P2 | On-page | Stray pipe character at the end of three `og:title`s | Open | 1 |
| I10 | P2 | On-page | Descriptions cut mid-sentence | Approved: fix trim; draft copy for approval | 1, 6 |
| I11 | P2 | On-page | Garbled category descriptions | Open | 1 |
| I12 | P2 | Internal links | Links via `/resources/` | Approved: update links and records | 6 |
| I13 | P2 | Records | Matrix out of date | Approved: LANES + copy-overwrites canonical; sync matrix | 6 |
| I14 | P2 | Analytics | Hard-coded TikTok ID; CSP gap | Approved: move to settings; add CSP hosts | 7 |
| I15 | P2 | Structured data | `&amp;` in schema | Open | 6 |
| I16 | P2 | Structured data | FAQPage vs record | Approved: keep + parity test | 6 |
| I17 | P3 | Structured data | Amenity not visible | Needs verification | 6 |
| I18 | P2 | On-page | Keyword-string post titles | Approved: draft titles for approval | 5 |
| I19 | P2 | Trust | No byline; US dates | Approved: "Ellie Smith", UK dates, Person schema | 5 |
| I20 | P2 | Images | One social image for all posts | Open | 6 |
| I21 | P2 | Forms | Step 2 date and guest checks | Open | 4 |
| I22 | P3 | Forms | Contact preference vs required phone | Approved: keep phone required; remove preference field | 4 |
| I23 | P2 | Visual | Our Story stock house | Won't fix (keep image) | — |
| I24 | P2 | Visual | Dark hero scrims | Approved: lighten, keep ≥4.5:1, before/after for approval | 2 |
| I25 | P3 | Visual | Inconsistent hero eyebrow | Open | 2 |
| I26 | P3 | Visual | Mixed alignment | Open | 2 |
| I27 | P3 | Responsive | Back-to-top covers text | Partly done (hidden over calendar) | 2 |
| I28 | P3 | Visual | Stray quote glyph | Open | 2 |
| I29 | P3 | Photography | Uneven room photos | Approved: re-crop, approval per image | 4 |
| I30 | P3 | Functionality | No search box | Open | 5 |
| I31 | P2 | Technical SEO | Thin categories | Approved: link from blog; noindex under 3 indexable posts; 404 empty | 3 |
| I32 | P3 | Technical SEO | Missing assets 301 to home | Needs verification | 3 |
| I33 | P3 | Technical SEO | AI groups skip wp-admin rule | Open | 3 |
| I34 | P3 | Navigation | Footer has no page links | Open | 2 |
| I35 | P3 | Visual | Header fade flash | Open | 2 |
| I36 | P3 | Brand | Logo accessible name | Approved: "Restwell Retreats" | 2 |
| I37 | P3 | Accessibility | Small targets | Needs verification | 7 |
| I38 | P3 | Copy | House-style dashes | Approved: fix, shown first | 5 |
| I39 | P3 | Visual | White text on placeholder | Open | 2 |
| I40 | P2 | Legal | Generated "Last updated" | Approved: fixed 17 September 2026 on both | 4 |
| I41 | P3 | Design system | Doc describes dead classes | Open | 1 |
| I42 | P3 | Typography | Long lines | Open | 1 |
| I43 | P3 | Calendar | Booked marking, today, past dates | **Done** (overhaul, uncommitted) | — |
| I44 | P3 | Accessibility | Calendar dialog | **Done** (overhaul, uncommitted) | — |
| I45 | P3 | Forms | FAQ form browser bubbles | Open | 7 |
| I46 | P3 | Navigation | Terms has no contents list | Open | 5 |

---

## 23. Recommended implementation batches

Each batch ships separately, with visual verification in Playground before commit.

### Batch 1: Foundations

- **Outcome:** shared head output and assets correct everywhere.
- **Issues:** I04, I05, I06, I09, I10 (code), I11, I41, I42.
- **Files:** `inc/seo/canonical.php`, `inc/seo/meta-helpers.php`, `inc/seo/description.php`, `inc/seo-social-meta.php`, `inc/page-hero.php`, `inc/gallery.php`, `template-parts/*` image output, `inc/enqueue.php`, CSS build, `DESIGN-SYSTEM.md`.
- **Records affected:** none.
- **Dependencies:** none.
- **Regression risks:** head tags removed by mistake; image swaps changing crops.
- **SEO safeguards:** diff `<head>` on every template before and after; one canonical, same URL.
- **Visual checks:** every hero at 375 and 1440; Property and Home galleries.
- **Tests:** crawl script, PHPUnit, PHPCS, spacing gate, image ratio probe.
- **Done when:** one canonical per page; no description ends mid-word; `srcset` on all content images; CSS minified.
- **Rollback:** revert the batch commit; no data changes.

### Batch 2: Shared shell

- **Outcome:** warmer, more consistent chrome.
- **Issues:** I24, I25, I26, I27, I28, I34, I35, I36, I39.
- **Files:** `header.php`, `footer.php`, `inc/page-hero.php`, `assets/css/shared.css`, `assets/js/shared.js`, `inc/theme-setup/logos.php`.
- **Records affected:** none.
- **Dependencies:** Batch 1 hero image changes.
- **Regression risks:** hero contrast; footer link count changes internal-link weights.
- **SEO safeguards:** footer links use canonical URLs; no heading changes.
- **Visual checks:** all interior heroes, before/after shared with you (I24).
- **Tests:** contrast probe (≥4.5:1 worst case), responsive probe at 7 widths.
- **Done when:** hero contrast passes; no overlap at 320–430; you approve the hero look.
- **Rollback:** revert commit.

### Batch 3: Technical SEO safety

- **Outcome:** indexing matches the recorded decisions.
- **Issues:** I01 (noindex enforcement + FAQ link), I31, I32, I33.
- **Files:** `inc/theme-setup/migrations.php` (idempotent noindex for the 14), `inc/sitemap-robots.php`, `inc/seo/canonical.php`, FAQ content source.
- **Records affected:** `copy-overwrites/mill-posts.md` (mark enforced).
- **Dependencies:** your confirmation of the 14-post list.
- **Regression risks:** noindexing a keep-guide by mistake.
- **SEO safeguards:** list the sitemap before and after; robots meta check on all 19 posts.
- **Visual checks:** none.
- **Tests:** crawl (robots, sitemap membership), PHPUnit test for the noindex list.
- **Done when:** 5 indexable posts and 14 `noindex, follow`, sitemap matches, no live link to a 404.
- **Rollback:** migration flag reset; revert commit.

### Batch 4: High-value journeys

- **Outcome:** Home, Pricing and Enquire flows complete and trustworthy.
- **Issues:** I02, I08, I21, I22, I29, I40.
- **Files:** `front-page.php`, `inc/seo/jsonld-lodging.php`, `inc/theme-setup/legal-content.php`, `template-enquire.php`, `assets/js/enquire.js`, `inc/crm/enquire-handler.php`, image files (renamed), `llms.txt`.
- **Records affected:** none (Terms wording comes to you first).
- **Dependencies:** your sign-off on Terms address wording and re-crops.
- **Regression risks:** CRM still expects `enq_contact_preference` (old enquiries keep it); renamed images break references.
- **SEO safeguards:** schema diff; image URL references updated everywhere.
- **Visual checks:** Home care section, Enquire steps at 375 and 1280.
- **Tests:** enquiry validation (no submit), PHPUnit, schema validator.
- **Done when:** no street in schema, Terms or filenames; step 2 blocks bad dates inline; legal dates fixed.
- **Rollback:** revert commit; restore original filenames if needed.

### Batch 5: Supporting content

- **Outcome:** a real, publishable blog.
- **Issues:** I01 (publish plan), I07, I18, I19, I30, I38, I46.
- **Files:** `inc/seo-content-seed-blog-*.php`, `copy-overwrites/`, `single.php`, `search.php`, `404.php`, legal templates.
- **Records affected:** `copy-overwrites/blog.md`, `mill-posts.md`.
- **Dependencies:** Batch 3; your approval of expanded posts and titles.
- **Regression risks:** publishing before noindex is enforced.
- **SEO safeguards:** publish only after Batch 3; schedule dates forward, never backdate.
- **Visual checks:** post template at 375 and 1280 with byline.
- **Tests:** crawl for robots, titles, dates; schema author check.
- **Done when:** 5 keep-guides live with byline and UK dates; others scheduled.
- **Rollback:** unpublish; revert commit.

### Batch 6: Internal links, metadata, schema and image SEO

- **Outcome:** records and markup agree with the site.
- **Issues:** I10 (copy), I12, I13, I15, I16, I17, I20.
- **Files:** content seeds, `inc/seo/jsonld-*.php`, `inc/seo-social-meta.php`, `SEO-PROGRESS-MATRIX.md`, `docs/seo/LANES.md`.
- **Records affected:** matrix and LANES (synced, not replaced).
- **Dependencies:** Batch 5 posts.
- **Regression risks:** FAQ schema drift.
- **SEO safeguards:** parity test fails the build if schema and visible FAQs differ.
- **Tests:** PHPUnit parity test, crawl for 3xx link targets, `og:image` uniqueness.
- **Done when:** no internal links to redirects; matrix rows match sitemap; unique social images.
- **Rollback:** revert commit.

### Batch 7: Functionality, analytics and accessibility

- **Outcome:** trustworthy measurement and the last a11y gaps closed.
- **Issues:** I03, I14, I37, I45.
- **Files:** `assets/js/enquire.js`, `inc/crm/enquire-handler.php`, `inc/seo/analytics.php`, `inc/csp.php`, `template-faq.php`, `assets/js/main.js`.
- **Records affected:** `ANALYTICS-EVENT-SCHEMA.md`.
- **Dependencies:** TikTok ID entered in live settings before deploy.
- **Regression risks:** conversions stop firing entirely.
- **SEO safeguards:** none needed.
- **Tests:** GA4 DebugView on staging: one event per real submit, none on reload.
- **Done when:** reload of the thank-you URL sends nothing; CSP report-only shows no TikTok violations.
- **Rollback:** revert commit.

### Batch 8: Final regression

- Run the checklist in section 24 on Playground, then on production after deploy.
- Record the deploy date for analytics comparisons.

---

## 24. Regression and SEO validation checklist

- [ ] Crawl: every sitemap URL returns 200; no internal link targets a 3xx or 4xx
- [ ] Exactly one canonical per page, absolute, self-referencing
- [ ] Robots meta: 5 keep-guides indexable, 14 mill posts `noindex, follow`, guest guide `noindex, follow`, search and 404 `noindex`
- [ ] Sitemap: no noindex URLs, no empty categories, no localhost on production
- [ ] Titles and descriptions: none cut mid-word, no stray pipes, approved copy only
- [ ] Schema: validator clean; no street address; FAQ parity test passes
- [ ] Responsive probe: no overflow at 320–1440; nothing under 12px
- [ ] Contrast probe: no text under 4.5:1 (3:1 large); hero worst case ≥4.5:1
- [ ] Keyboard: menu, section tabs, calendar grid, enquiry steps, dialogs
- [ ] Enquiry: inline errors at each step; no conversion event on reload
- [ ] Calendar: booked stretches blocked, totals correct, dates carried to enquiry
- [ ] PHPUnit (87+ tests), PHPCS zero, spacing gate
- [ ] Production after deploy: robots meta on posts, live sitemap, FAQ link, GA4 DebugView, CrUX baseline noted

---

## 25. Pages, templates and states inspected

**Pages:** Home, The Property, How it works, Accessibility, Who it's for, Whitstable area guide, Pricing, FAQ, Enquire, Funding & Support (formerly Resources), Guest guide (logged out), Our Story, Optional care, Blog page 1 and 2, posts (fatigue-friendly day, direct payments, how to choose, Revitalise), search with results and empty, Kent & coast and News categories, 404, Privacy, Terms, Website accessibility statement.

**Templates:** `front-page.php`, `template-*.php` (all), `page-guest-guide.php`, `single.php`, `home.php`, `search.php`, `404.php`, archive.

**States:** mobile menu open and closed, cookie banner first visit, enquiry validation (step 1 errors, step 2 dates), calendar (empty, arrival only, full stay, crossing a booking, leaving on a booked morning, unselect, keyboard paging), enquiry dialog open and closed, empty search, logged-out guest guide, sticky header on scroll.

**Widths:** 320, 375, 430, 768, 1024, 1280, 1440.

---

## 26. Pages, data or states not fully testable

| Item | Why | What would validate it |
|---|---|---|
| Form submission, CRM records, emails | Not submitted (no live sends) | Staging submission with a test inbox |
| Guest-guide code flow | Would send email | Staging test booking |
| CSP violations | HTTP only locally | HTTPS staging with report-only log |
| Field Core Web Vitals | No CrUX or Search Console access | CrUX dashboard or Search Console export |
| Lab LCP | Hidden browser pane | Lighthouse in a visible browser on staging |
| Analytics events | No GA4/TikTok access | GA4 DebugView on staging |
| Production robots meta on posts | Posts not published live | Re-check after Batch 5 |
| Production categories and guest guide | Not fetched | Live crawl after deploy |
| Screen-reader behaviour | No AT session run | VoiceOver and NVDA pass on calendar and enquiry |
| Search rankings, traffic, conversions | Not available; none invented | Search Console and GA4 exports |

**Production data needed to settle uncertain findings:** Search Console Pages and Core Web Vitals reports, a GA4 export of `enquiry_form_submitted` by page path (to size I03), confirmation of which posts exist in the production database, and the real revision dates for the Terms and accessibility statement if they differ from 17 September 2026.

## 27. Remediation status (re-audit 3 October 2026)

All checks were re-run against WordPress Playground on localhost:9410. The tracker artifact holds the status and resolution for each issue.

**Overall: 9.7 / 10, up from 6.9.** 44 of the 46 issues are done, including I43 and I44 from earlier. I23 is won't fix, by your decision. I01 waits on deploy. Your approvals on 3 October (photo re-crops, copy drafts, critical CSS) are live. Nothing is committed.

| Area | 1 Oct | 3 Oct | What holds it below 10 |
|---|---|---|---|
| Visual polish and warmth | 6.8 | 9.5 | Our Story image kept by your choice (I23) |
| Consistency across pages | 7.5 | 9.5 | |
| Responsive behaviour | 8.5 | 10 | |
| Spacing and rhythm | 8 | 10 | |
| Typography and hierarchy | 8 | 10 | |
| Navigation and interactions | 8.5 | 10 | |
| Forms and functionality | 7.3 | 10 | |
| Accessibility | 8 | 9.5 | No screen-reader pass yet |
| Technical SEO | 6 | 9.5 | Posts not yet published or deployed (I01) |
| On-page and search appearance | 6.3 | 10 | |
| Structured data | 6 | 10 | |
| Internal links and architecture | 7 | 10 | |
| Images and image SEO | 4.5 | 9.5 | Production media-library renames |
| Performance (lab) | 5.5 | 9 | No field data; `/the-property/` LCP held back by Playground's server response |
| Analytics and consent | 5.5 | 9 | GA4 check on production after deploy |
| AI-search clarity | 7.5 | 10 | |

**Evidence (3 Oct):**

- **Section 24 crawl.** 41 URLs: the sitemap, all 14 mill posts, the guest guide, search, a 404, the categories and blog page 2. It found 0 failures.
  - Every sitemap URL returns 200, and no URL appears twice.
  - Each page has exactly one canonical, pointing to itself, and no page has two robots tags.
  - The 5 keep-guides are indexable and in the sitemap. The 14 mill posts are `noindex, follow` and absent from the sitemap.
  - The guest guide, search and 404 pages are noindex. The empty category returns 404.
  - No title, og:title or description ends in a separator or is cut mid-sentence.
  - All JSON-LD is valid, with no `&amp;` and no street name.
  - FAQ schema matches the visible questions on every page. The BlogPosting author is a Person.
  - No two posts share an og:image.
  - There are 0 internal links to a 3xx or 4xx.
  - Every robots.txt group carries `Disallow: /wp-admin/`.
- **Responsive, contrast, target and line-length probe.** 25 pages at 320, 375, 768, 1024 and 1440px.
  - No horizontal overflow, and no interactive target under 24px.
  - No visible line over 80 characters. The hero intros and stacked split columns were capped at 35em during this pass.
  - Text contrast passes. Hero text holds 4.5:1 or above.
  - The remaining flags were checked by hand and are false positives: text over a section-level background or over the hero photo, and characters inside hidden "(opens in new tab)" labels.
- **Schema amenities.** Every amenity is stated on `/the-property/` or `/accessibility/`. The wet room line now says "shower seat", matching the visible equipment.
- **Lab performance.** Throttled mobile (slow 4G, 4x CPU) on five key pages: CLS 0 to 0.03, LCP 2.3 to 3.6 s.
  - Subsetting the fonts to Latin cut about 260 KB per first visit: Inter went from 341 KB to 144 KB and Lora from 82 KB to 45 KB, with no glyphs lost. A 48px favicon and a 180px touch icon replace the 63 KB 512px icon.
  - First paint is held up by Playground itself. It responds in about 0.6 s and serves `site.min.css` uncompressed, at 198 KB against 33 KB gzipped.
- **Gates.** PHPUnit: 97 tests and 351 assertions passing. PHPCS: 0 errors. Spacing gate: ok. The CSS bundle was rebuilt.

**Second pass, 3 October evening (after your approvals):**

- **Photo re-crops (I29).** Both are live. The bedroom is straightened and cropped clear of the loose towel. The living room is a level 4:3 crop with less wide-angle distortion. Both match the 640×480 frames the templates declare. WebP variants were regenerated at native size, with no upscaling.
- **Copy.** Everything below renders exactly as written in `copy-overwrites/`.
  - All 8 approved meta descriptions. The homepage needed migration v72, because its stored text was under the v67 length trigger.
  - All 19 approved post titles. The blog seeder was writing the old keyword titles back, so the seed now carries the approved ones and migration v73 re-applied them.
  - The Terms address wording.
- **Critical CSS.** `tools/build-critical-css.mjs` writes one above-the-fold file per template family to `assets/css/critical/` (31–49 KB raw, about 8 KB gzipped).
  - `inc/enqueue.php` inlines the file for the current page and loads `site.min.css` without blocking. It switches the bundle on with a nonce'd script, because the CSP blocks inline handlers, and keeps a `<noscript>` link.
  - A file built from an older bundle is skipped, and `CssBundleTest` fails when one is stale.
  - `@font-face` stays in the bundle. Inlined, it started about 190 KB of fonts at once and pushed LCP back.
- **WebP hero twins.** Media Library photos that also exist in `assets/images/` are served as the theme's WebP width variants, matched by file stem. For example, the property hero went from a 205 KB JPEG to a 115 KB WebP. Photos swapped in admin with no theme copy keep WordPress's sizes.
- **Lab performance.** Median of 3 runs on throttled mobile (slow 4G, 4x CPU), behind a local gzip proxy so compression matches a production host:

  | | FCP (mean) | LCP (mean) | CLS (worst) |
  |---|---|---|---|
  | Before this pass | 1.36 s | 2.16 s | 0.028 |
  | After | 0.95 s | 1.75 s | 0.055 |

  Six of the seven key pages have LCP under 2.5 s. `/the-property/` sits at 2.7–3.6 s: its HTML only arrives after about 1.2 s on Playground, and the garden hero is a busy photo that barely shrinks with lower quality.
- **Regression.** The section 24 crawl (41 URLs) found 0 failures. The responsive probe across 25 pages at five widths was clean, apart from the known false positives. PHPUnit: 98 tests and 390 assertions passing. PHPCS: 0 errors. Spacing gate: ok.

**Owner actions still open:**

1. Publish the posts and deploy (I01), then enter the TikTok ID in live settings.
2. After deploy, check on production:
   - gzip or brotli on CSS and HTML
   - robots meta on the posts
   - GA4 conversion counts, which should fire once per real submission
   - CrUX Core Web Vitals
3. Rename the street-named files in the production media library.
4. Run a VoiceOver and NVDA pass on the calendar and the enquiry flow.
5. Optional: revisit the Our Story image (I23).

**Build notes.** After any stylesheet edit, run `tools/build-css.sh` and then `node tools/build-critical-css.mjs`; the second needs the site running. The `.woff2` files are now Latin subsets: Latin-1, Latin Extended-A, punctuation, arrows and symbols. The full fonts remain as the `.ttf` files. If copy ever needs characters outside that range, regenerate the subsets from the `.ttf` files with `python3 -m fontTools.subset`.
