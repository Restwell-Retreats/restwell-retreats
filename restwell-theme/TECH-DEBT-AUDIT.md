# Restwell Theme — Technical Debt Audit

**Date:** 5 July 2026
**Scope:** `/restwell-theme/` — PHP (`inc/`, templates, `template-parts/`), JS (`assets/js/`), CSS (`assets/css/`)
**Method:** Full-file reads across five module areas (CRM, SEO, theme-setup/content-meta, templates, front-end assets), plus an objective `phpcs` run against the WordPress Coding Standards config already in the repo (`phpcs.xml.dist`). Every finding below cites `file:line`. No git history rewriting was needed — the 41-commit history is already linear with clean conventional messages, so `git-advanced-workflows` techniques (rebase/bisect/worktree) aren't required for cleanup; they're noted only where relevant to *how* to land these fixes safely (small commits, `git bisect` if a fix regresses something).

**Headline finding:** [`docs/archive/AUDIT.md`](docs/archive/AUDIT.md) currently scores "Code quality / maintainability" at **94/100** and "WordPress standards" at **93/100**. Neither is supported by the code. The modular file-splitting described there is real and was a genuine improvement, but splitting files ≠ removing debt — several of the new files are themselves 700–1,100 line god-modules, there are zero automated tests anywhere in the theme, and an objective linter run finds security-relevant violations (unescaped output, unprepared SQL, global overrides) that a 93–94/100 score should not have.

---

## 1. Objective baseline (tool-verified, not opinion)

```
$ composer phpcs
A TOTAL OF 1082 ERRORS AND 0 WARNINGS WERE FOUND IN 71 FILES
PHPCBF CAN FIX 441 OF THESE SNIFF VIOLATIONS AUTOMATICALLY
```

Breakdown of the 641 violations phpcbf **can't** auto-fix (i.e. real code issues, not formatting):

| Sniff | Count | What it means |
|---|---|---|
| `WordPress.WP.GlobalVariablesOverride.Prohibited` | 25 | Local variables shadow WP globals (`$title`, `$error`) — can leak state between includes |
| `WordPress.WP.I18n.MissingTranslatorsComment` | 15 | Placeholders in translatable strings undocumented for translators |
| `WordPress.Security.EscapeOutput.OutputNotEscaped` | **11** | Output not run through `esc_html`/`esc_attr` — directly violates this project's own `.cursorrules` |
| `WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase` | 9 | camelCase properties in a snake_case codebase |
| `WordPress.WP.I18n.InterpolatedVariableText` | 7 | Variables interpolated into translatable strings (breaks translation) |
| `WordPress.DB.PreparedSQL.InterpolatedNotPrepared` | **6** | Raw SQL string interpolation instead of `$wpdb->prepare()` |
| `WordPress.DateTime.RestrictedFunctions.date_date` | 2 | `date()` instead of timezone-safe `wp_date()`/`gmdate()` |
| `WordPress.WP.I18n.MissingArgDomain` | 2 | Missing text-domain arg on `__()`/`_e()` |
| `WordPress.WP.EnqueuedResources.NonEnqueuedScript` | 1 | A script not going through `wp_enqueue_script` — confirms the inline-script finding below |
| `WordPress.Files.FileName.InvalidClassFileName` | 1 | Class file doesn't follow `class-*.php` naming |
| `WordPress.WP.DeprecatedParameters.Term_descriptionParam2Found` | 1 | Deprecated core param usage |
| `Universal.Files.SeparateFunctionsFromOO.Mixed` | 1 | Procedural functions and OOP classes mixed in one file |

**These aren't style nits — they're the exact categories this project's own rules ("Always escape output", "Always sanitise input") call out.** Full locations below (§2).

---

## 2. Critical / security-relevant findings (fix first, low risk)

These are narrow, mechanical, behavior-preserving fixes — safe to do as a first pass without touching architecture.

### 2.1 SQL built by string interpolation instead of `$wpdb->prepare()`

| File:Line | Query |
|---|---|
| `inc/crm/database.php:115` | `UPDATE {$enq_table} …` |
| `inc/crm/notes.php:47` | `SELECT * FROM {$notes_table} WHERE enquiry_id = %d …` |
| `inc/crm/handlers.php:37` | `FROM {$table} ORDER BY submitted_at DESC` |
| `inc/crm/handlers.php:355` | `SELECT date_from, date_to FROM {$table} WHERE id = %d` |
| `inc/guest-guide.php:269` | `SELECT * FROM {$table} WHERE send_date <= %s AND sent_at IS NULL` |
| `inc/guest-guide.php:631` | `SELECT COUNT(*) FROM {$table} WHERE LOWER(email) = LOWER(%s)` |

The table name itself isn't attacker-controlled in any of these (it's a hardcoded `$wpdb->prefix . 'restwell_…'` constant), so this isn't an active exploit today — but it's the exact pattern PHPCS's `WordPress.DB.PreparedSQL` sniff exists to catch, and it normalizes a habit that becomes a real SQL-injection risk the moment anyone adds a dynamic column/table elsewhere. Fix: build the query with `$wpdb->prepare()` throughout, or at minimum a `sprintf()`-with-`%i`-style helper if the table name must stay dynamic.

### 2.2 Output not escaped

| File:Line | Variable |
|---|---|
| `inc/crm/dashboard.php:851–852` | `$display`, `$exported_at` |
| `inc/meta-fields.php:122,124,126,127,129,134` | `$allowed`, `$preview_show`, `$preview_src`, `$preview_text`, `$remove_show` |
| `inc/theme-setup/admin.php:72` | `$message` |

All admin-context, all low-severity individually (not directly user-supplied in the request), but this is precisely the class of bug that becomes a stored-XSS vector the day one of these values starts coming from a filterable/meta source. 30-minute fix: wrap each in `esc_html()`/`esc_attr()` as appropriate.

### 2.3 Global variable overrides

`page-guest-guide.php` reassigns `$error` **9 times** (lines 29, 48, 50, 66, 96, 102, 129, 137, 143) and `template-how-it-works.php` reassigns `$title` **5 times** (lines 32, 35, 39, 43, 47). `$error` and `$title` are WP-reserved names used elsewhere in core/template context — this can cause confusing bugs if anything downstream expects the global. Fix: rename to `$gg_error` / `$step_title` etc. Mechanical, low-risk, but touch one template at a time and smoke-test the guest-guide OTP flow after, since it's the file with the most reassignments and no test coverage.

### 2.4 Inline `<style>`/`<script>` in `page-guest-guide.php` (direct `.cursorrules` violation)

- `page-guest-guide.php:721–732` — inline `<style>` print block after `get_footer()`
- `page-guest-guide.php:733–752` — inline `<script>` for keysafe code reveal

This project's own rules say "Never inline `<style>` or `<script>` tags directly in templates" and "Enqueue ALL scripts and styles via `wp_enqueue_scripts`." This is the only template-level violation found; everything else (JSON-LD, analytics) already goes through `inc/enqueue.php` correctly. **Effort: 5–7h** to move both into `assets/css/`/`assets/js/` and enqueue conditionally on the guest-guide template.

**Total effort for §2 (critical/security): ~10–14 hours.** All mechanical, all low-risk to behavior, all should land as small individual commits so a regression is trivial to `git bisect` if the untested guest-guide/CRM flows break.

---

## 3. God functions (ranked, theme-wide)

Functions this long are where bugs hide and reviews get rubber-stamped. None of these are "data" arrays — all are logic.

| Function | File:Line | ~Lines | Mixes |
|---|---|---|---|
| `restwell_crm_dashboard_page` | `inc/crm/dashboard.php:19` | **846** | Stats SQL + 4 UI panels + a full unrelated site-settings form (GA4/Mailchimp/Metricool/footer CTA) + export audit log |
| `restwell_crm_enquiries_page` | `inc/crm/enquiries.php:19` | **431** | POST handling + filters + pagination + table render + inline JS |
| `restwell_crm_enquiry_detail` | `inc/crm/enquiries.php:461` | **417** | Full detail layout + forms + activity log |
| `initMultiStepForm` (JS) | `assets/js/main.js:521` | **330** | 3-step form validation + progress DOM mutation + analytics |
| `initRestwellGalleryLightbox` (JS) | `assets/js/main.js:1867` | **296** | Modal lifecycle + focus trap + touch scroll lock |
| `restwell_seed_priority_blog_posts` | `inc/seo-content-seed-blog-priority.php:18` | **289** | Post CRUD + category assignment + meta seeding |
| `restwell_guest_guide_settings_page` | `inc/guest-guide.php:408` | **204** | Admin UI + inline HTML |
| `restwell_run_theme_setup` | `inc/theme-setup/runner.php:12` | **134** | Orchestrates 20+ result keys |
| `restwell_crm_maybe_create_table` | `inc/crm/database.php:20` | **137** | 4 table schemas + backfill + legacy migration in one `init` hook |
| `restwell_output_jsonld_breadcrumb` | `inc/seo/jsonld.php:691` | **122** | 6-branch `if/elseif` page-type router, cyclomatic complexity ~8 |
| `restwell_output_jsonld_local_business` | `inc/seo/jsonld.php:306` | **100** | Schema build + image harvesting (duplicated elsewhere) |
| `restwell_crm_handle_save_settings` | `inc/crm/handlers.php:109` | **160** | 25+ unrelated `update_option()` calls in one handler |
| `restwell_output_social_meta` | `inc/seo-social-meta.php:18` | **145** | Title/description/image resolution re-implemented rather than reused |
| `restwell_seo_admin_run_checks` | `inc/seo-admin.php:421` | **140** | 8 independent SEO checks in one function |
| `restwell_handle_faq_question_submit` | `inc/faq-question-handler.php:15` | **156** | Acceptable — well-structured validation chain, flagged for size only |

**Worst offender:** `restwell_crm_dashboard_page` at 846 lines is a CRM enquiry dashboard that has quietly become the site's *general settings admin* (GA4, Mailchimp, Metricool, Bing, footer CTA copy, access-statement PDF URL, CRM role config). None of that belongs in a file called `dashboard.php` under `inc/crm/`.

---

## 4. Duplication catalog (by module, ranked by size)

Methodology differs slightly per module (literal copy-paste vs. structural/near-duplicate), so totals are ranges, not a single precise number. Aggregate estimate: **~3,500–4,500 lines of duplicated or near-duplicate code across the theme.**

### 4.1 SEO / content — the largest single source (~1,300 lines)

- **Blog post HTML boilerplate**: 19 functions like `restwell_get_blog_post_*_html()` across `seo-content-seed-blog-priority.php`, `-cluster-a.php`, `-cluster-b.php` all repeat the same skeleton (TL;DR → What is → Why → table/steps → common mistakes → 5 FAQs → closing links). **~950 lines.** e.g. `inc/seo-content-seed-blog-cluster-a.php:17–83` vs `inc/seo-content-seed-blog-priority.php:312–417`.
- **Triple-stored SEO meta**: `meta_title`/`meta_description` for every blog post live in *both* `restwell_get_seo_meta_defaults_by_slug()` (`inc/seo-content-seed-meta.php:18–196`) *and* inline in the `$articles` array in `restwell_seed_priority_blog_posts()` (`inc/seo-content-seed-blog-priority.php:34–41` etc.) — only `focus_keyphrase` actually reads from the shared map. **19 × 2 = 38 fields that can silently drift out of sync.**
- **Repeated `esc_url( home_url(...) )` link wiring**: 116 occurrences across the seed files. **~100–120 lines.**
- **JSON-LD entity builders**: `areaServed`/image-harvesting/FAQ-entity logic repeated across `restwell_output_jsonld_local_business()`, `restwell_output_jsonld_accommodation_service()`, `restwell_output_jsonld_homepage_faq()`, `restwell_output_jsonld_faq_page()` in `inc/seo/jsonld.php`. **~100 lines.**
- **Meta title/description resolution** re-implemented in `seo/description.php`, `seo/meta-helpers.php`, `seo-social-meta.php`, and `seo-admin.php` instead of one resolver. **~80–100 lines.**

### 4.2 Theme-setup / content-meta (~900+ concrete lines, more conceptually)

- **Triple source of truth for every page field**: admin schema (`inc/page-meta-definitions.php`), seed defaults (`inc/theme-setup/page-defaults.php`), *and* inline `?:` fallbacks in templates (e.g. `front-page.php:19–27`). The template fallback pattern is also a **correctness bug**, not just duplication — `?:` overwrites intentionally-empty meta, while the shared `restwell_post_meta_or_default()` helper (`inc/theme-setup/meta-helpers.php:40–55`) correctly uses `metadata_exists()` and isn't used consistently.
- **Homepage FAQ has three competing sources** (code defaults in `inc/homepage-faq.php`, unused post-meta fields `home_faq_1_q`…`home_faq_7_a` in `page-meta-definitions.php:186–202`, and a seed map in `inc/seo/jsonld.php:597–608`). Editors see 14 FAQ fields in wp-admin that do nothing.
- **Migration boilerplate**: `inc/theme-setup/migrations.php` (676 lines) is 16 ad-hoc one-off functions, not a registry — same option-guard pattern copy-pasted 16 times, `get_page_by_path( 'the-property' )` called **11 times** in one file, and three migration functions share **duplicate hook priorities** (`24`, `25`, `26` each used twice — undefined execution order).
- **Dead duplicate function**: `restwell_get_property_room_tour_blocks()` (`inc/property-content.php:139–199`) is never called anywhere — `restwell_get_property_room_tour_sections()` in `gallery.php` is the one actually used.
- Logo sideload duplication (`inc/theme-setup/logos.php:44–95` vs `116–206`, ~55 lines), repeated meta-closure pattern (~125 lines across `property-content.php`/`gallery.php`), repeated page-registry maps (~30 lines), and the exact same paragraph of property copy repeated 3× in `page-defaults.php:180–217`.

### 4.3 Templates (~400–500 lines of markup)

- **Homepage hero reimplements `interior-hero.php` instead of using it**: ~90–110 duplicated lines (`front-page.php:409–513` vs `template-parts/interior-hero.php:115–225`) — despite an in-code comment acknowledging the two should share markup.
- **FAQ accordion markup copy-pasted 3×**: `front-page.php:1064–1074`, `template-faq.php:120–131`, `template-how-it-works.php:244–250` — and the How It Works copy is missing the focus-visible ring the other two have (a real accessibility regression from copy-paste drift, not just DRY).
- **Teal CTA band** repeated across `template-property.php`, `template-whitstable-guide.php`, `footer.php`, `front-page.php` (~80–120 lines).
- **"Related reading" hub-link blocks** repeated near-identically across 6 templates with hardcoded URLs (~120–180 lines).
- **Sticky in-page sub-nav** duplicated between `template-property.php:202–214` and `template-who-its-for.php:185–199`, and duplicated again in JS (§4.4).

### 4.4 JavaScript (~300–400 lines)

- **`initWifPersonaNav` and `initPropPageNav` are near-identical** (`assets/js/main.js:1303–1487` and `:1492–1618`) — scroll-spy, rAF throttle, and scroll-affordance logic copy-pasted with only selectors changed. **Highest-value single JS extraction** (`initSectionJumpNav({...})`), ~3–5h.
- `setActivePill()` copy-pasted verbatim at `main.js:313–317` and `:385–389`.
- `getFieldLabel()` duplicated between `initMultiStepForm` (695–704) and `initFaqQuestionFormValidation` (859–867); phone regex duplicated within `isPlausiblePhone`/`restwellPhoneErrorMessage` (500–512).
- `gtag('event', …)` boilerplate repeated in ~10 places with no shared `trackEvent()` helper.

### 4.5 CRM (~90–130 lines literal + ~400 lines structural)

- Permission-gate boilerplate (`restwell_crm_can_manage()` + `wp_die()`) repeated in every handler (`handlers.php:20–22,81–83,110–112,276–278,316–318,401–408`, `dashboard.php:20–22`, `enquiries.php:20–22`, `mailing-list.php:16–18`).
- "Promote to Guest Guide" URL builder duplicated verbatim (`dashboard.php:181–189` vs `enquiries.php:486–494`).
- Fetch-enquiry-by-ID raw `$wpdb` query repeated 5+ places with no repository — one AJAX status change (`restwell_crm_handle_lead_action`) does **3 separate fetches** for the same row.
- Settings save (`handlers.php:116–263`) and settings display (`dashboard.php:311–808`) maintain the same ~25 fields in two places with no shared field map — the highest-effort item in this section (8–16h) but also the one most likely to cause a silent bug (add a setting in one place, forget the other).

---

## 5. Architecture: the service layer doesn't do what it claims

`inc/services/` (`Restwell_Crm_Gateway`, `Restwell_Enquiry_Service`) is presented in [`docs/archive/AUDIT.md`](docs/archive/AUDIT.md) as a Clean-Architecture-style boundary ("Plugin architecture boundary: 92/100"). In practice:

- `services/bootstrap.php:6–7` says outright: *"Business logic remains in `inc/crm/*` … services are the stable entry surface."* That's a facade, not dependency inversion — there's no interface, no injection, nothing swappable.
- Public-facing intake (`wp-content/mu-plugins/restwell-crm/enquire-handler.php`, `inc/faq-question-handler.php`) does go through the service layer correctly.
- **Every admin CRM screen bypasses it**: stay-date updates (`handlers.php:369–381`), staff notes (`enquiries.php:46–55`), all list/dashboard queries (`dashboard.php`, `enquiries.php`, `mailing-list.php`), and notes reads (`enquiries.php:474`) all hit `$wpdb` or module functions directly. Even `status-transition.php:76` calls `restwell_crm_add_note()` directly instead of going through the gateway it's supposed to sit behind.
- The gateway itself leaks persistence concerns back the other way: `Restwell_Crm_Gateway::mark_faq_marketing_sync_failed()` runs a raw `$wpdb->update()` (`class-restwell-crm-gateway.php:93–109`) that arguably belongs in `persistence.php`.

**Net effect:** the boundary exists for one entry point (public form submission) and is decorative everywhere else. This isn't a five-minute fix — genuinely inverting the dependency (repository interfaces, admin reads/writes routed through them) is a **20–40 hour** project. Worth doing before this module grows further, not urgent today since the current procedural code does work.

---

## 6. Dead code

| Item | Location | Action |
|---|---|---|
| `restwell_get_property_room_tour_blocks()` | `inc/property-content.php:139–199` | Delete — superseded, zero callers |
| `template-parts/page-hero.php` (94 lines) | — | Zero `get_template_part()` references anywhere in the repo. Also contains an *unescaped* Tailwind class echo (`page-hero.php:57–72`) — a real WPCS violation sitting in dead code. Delete. |
| `template-parts/cta-accessibility-prompt.php` (43 lines) | — | Zero references. Delete or wire into the homepage/footer CTA it looks like it was built for. |
| `template-parts/icon-phosphor-light.php` (38 lines) | — | Zero references — theme now uses Phosphor **font** icons (`.ph-bold`), not this inline-SVG partial. Delete. |
| `assigned_to` DB column | `inc/crm/database.php:52` | Defined, never read/written anywhere in the CRM module despite `CRM_RISK_AUDIT.md` referencing an assignee filter. Either implement or drop the column. |
| Orphaned `home_faq_*` post-meta fields | `inc/page-meta-definitions.php:186–202` | 14 admin fields that don't drive the rendered homepage FAQ (see §4.2). Remove from the admin UI or wire them up — currently actively misleading to editors. |

---

## 7. Testing: there is none

Searched the entire theme for `*Test.php`, `phpunit.xml`, `*.test.js`, `*.spec.js`, `jest.config*` — **zero results**. Every one of the five module audits flagged this independently as High severity. Concretely untested and highest-risk to change blind:

- CRM status transitions and duplicate-enquiry guards (`inc/crm/status-transition.php`, `persistence.php`)
- Guest-guide OTP throttle/verify flow (`hash_equals()` check in `guest-guide.php:706`, session handling in `page-guest-guide.php`)
- SEO canonical/description/title fallback chains (`seo/canonical.php`, `seo/description.php`, `seo/meta-helpers.php`)
- FAQ question submission handler
- Front-end form validation (phone/email regex, multi-step form state)

**Recommendation:** don't try to retrofit full coverage. Stand up a minimal WP PHPUnit bootstrap (`wp-env` or `wp-cli scaffold plugin-tests` pattern adapted for a theme) and write ~15–20 focused tests on the highest-risk pure-logic functions above (most don't need a full WP bootstrap — canonical/description resolvers are close to pure functions already). **Effort: 16–24h initial setup**, then tests-with-the-fix going forward as a prevention measure (see §9).

---

## 8. What's actually good (don't re-litigate these)

To be direct rather than one-sided: the modular `inc/` split is real and worth keeping.

- `functions.php` is a clean, deterministic `require_once` chain — no logic buried there.
- Nonce + capability checks are consistently present on state-changing admin actions across CRM, FAQ, and guest-guide handlers.
- `interior-hero.php` + `breadcrumb.php` is a well-adopted shared pattern across 15+ interior templates.
- Escaping discipline is *mostly* good — the 11 gaps in §2.2 are the exception, not the norm, across ~24,000 lines of PHP.
- Accessibility baseline (skip link, FAQ `aria-expanded`, lightbox focus trap, form `aria-invalid`/`role="alert"`) is above average for a hand-rolled theme; the JS carousel/lightbox implementation in particular is well done.
- No jQuery, no page builder, no inline styles/scripts outside the one guest-guide exception — the project's own constraints are being followed almost everywhere.

---

## 9. Prioritized roadmap

### Quick wins (do this week, ~1–2 days total, near-zero behavioral risk)

| # | Task | Effort |
|---|---|---|
| 1 | Run `composer phpcbf` for the 441 auto-fixable whitespace/formatting violations | 15 min + review diff |
| 2 | Fix the 11 unescaped-output spots (§2.2) | 1–2h |
| 3 | Convert the 6 interpolated-SQL queries to `$wpdb->prepare()` (§2.1) | 2–3h |
| 4 | Rename the 14 global-shadowing variables (§2.3) — one file at a time, smoke-test after each | 2–3h |
| 5 | Delete the 3 dead template-parts + dead `restwell_get_property_room_tour_blocks()` (§6) | 1–2h |
| 6 | Fix How It Works FAQ missing focus-visible ring (accessibility regression, `template-how-it-works.php:245`) | 15 min |
| 7 | Extract `initSectionJumpNav()` to collapse `initWifPersonaNav`/`initPropPageNav` duplication | 3–5h |

### Sprint 1–2 (2–4 weeks)

- Move guest-guide inline `<style>`/`<script>` to enqueued assets (§2.4) — 5–7h
- Extract shared `template-parts/faq-accordion.php` from the 3 copies — 4–6h
- Deduplicate blog-post SEO meta (stop double-storing `meta_title`/`meta_description`) — 3–4h
- Split `restwell_crm_dashboard_page` — pull the unrelated site-settings form out of the CRM dashboard into its own admin page — 12–20h (highest-leverage single refactor: turns the single worst offender in §3 into two comprehensible files)
- Consolidate CRM permission-gate/promote-URL/redirect boilerplate — 3–4h
- Fix the 3 colliding migration hook priorities in `migrations.php` — 2h

### Longer-term (quarter)

- Introduce an `EnquiryRepository` so admin CRM screens read/write through the service layer instead of raw `$wpdb` (§5) — 20–40h
- Move blog-post seed content out of PHP functions into data (JSON/Markdown) + a thin renderer — 12–16h
- Consolidate the triple-stored page-meta schema (admin definitions / seed defaults / template fallbacks) into one source — 16–24h
- Stand up a minimal PHPUnit suite and write tests for the functions in §7 — 16–24h setup + ongoing
- Migrate `migrations.php` from 16 ad-hoc functions to a small versioned-migration registry — 8–12h

**Total estimated effort for full remediation: ~150–220 hours.** The quick-wins column (~15–20h) removes essentially all of the *security-relevant* findings and the accessibility regression; everything after that is quality-of-life for future changes, not urgent risk.

---

## 10. Prevention (stop new debt accumulating)

1. **Make `composer phpcs` a required check before merge**, not just a documented local command — it already exists and already catches real bugs (§2), it's just not gating anything.
2. **Function-length review guideline**: anything pushing past ~80–100 lines in a PR should get a "does this need splitting?" comment — informal is fine, doesn't need tooling.
3. **One source of truth per fact**: the recurring pattern across every module audit was the same fact (a meta field, a URL, a permission check) stored in 2–3 places. When adding a new page-meta field, SEO field, or CRM setting, add it in exactly one place and have everything else read from it.
4. **New PHP files touching `$wpdb` directly outside `inc/crm/persistence.php`/`database.php` should be a deliberate decision**, not a default — that's what's causing the service-layer erosion in §5.
5. **Tests alongside new logic**, not retrofitted — once the PHPUnit bootstrap exists (§7), any new pure-logic helper (resolvers, validators, migrations) gets a test in the same PR.

---

## 11. Scorecard: this audit vs. [`docs/archive/AUDIT.md`](docs/archive/AUDIT.md)

| Dimension | `docs/archive/AUDIT.md` | This audit | Why |
|---|---|---|---|
| Code quality / maintainability | 94/100 | **~60/100** | Multiple 300–850 line functions; ~3,500–4,500 duplicated lines; 3 dead template-parts |
| WordPress standards | 93/100 | **~75/100** | 1,082 PHPCS violations incl. 11 unescaped-output, 25 global-overrides; 1 inline-script/style violation of the project's own rules |
| Plugin/service architecture boundary | 92/100 | **~50/100** | Facade only — admin CRM bypasses the service layer almost entirely |
| Security | implied high (93/100 standards) | **~80/100** | Nonce/capability checks are genuinely solid; 6 unprepared-SQL patterns and 11 escaping gaps keep this from being higher |
| Test coverage | not scored | **0/100** | Zero automated tests anywhere in the theme |

This isn't a repudiation of the prior audit work — the SEO/schema/analytics/accessibility findings in [`docs/archive/AUDIT.md`](docs/archive/AUDIT.md) are largely accurate for what they measure (feature presence). This report measures something different: code structure, duplication, and verifiability, which that audit asserted without the underlying evidence. Both documents can be true at once — the site works and converts, and the code that makes it work carries real maintenance risk.
