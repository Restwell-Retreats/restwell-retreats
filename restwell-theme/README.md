# Restwell Retreats — WordPress theme

| | |
|---|---|
| **Type** | Standalone custom theme (not a child theme) |
| **PHP** | 7.4+ (`style.css` → `Requires PHP`) |
| **WordPress** | 6.4+ (`Requires at least`) |
| **Stack** | PHP templates, Tailwind CSS v3, vanilla JS (no React/npm runtime in production) |

Custom front end for [Restwell Retreats](https://restwellretreats.co.uk/): accessible holiday property marketing, enquiry flows, blog, and guest arrival guide. CRM, enquiries, and transactional email live in the **Restwell CRM** must-use plugin (`wp-content/mu-plugins/restwell-crm/`); the theme loads that plugin from the monorepo when it is not already active.

---

## Quickstart

| Step | Command / action |
|------|------------------|
| 1. Clone | Clone the monorepo and `cd restwell-theme` |
| 2. Install | `npm install` |
| 3. Develop CSS/JS | `npm run dev` (watches Tailwind; rebuild JS manually or run `npm run build`) |
| 4. WordPress | Symlink or copy `restwell-theme` into `wp-content/themes/`; activate **Restwell Retreats** |
| 5. CRM (local) | Ensure `wp-content/mu-plugins/restwell-crm/` is present (theme `functions.php` can bootstrap it from the monorepo sibling path) |
| 6. First-time content | **WP Admin → Restwell → Theme Setup** — create pages, seed home meta, optional blog seed |
| 7. Deploy | Run `npm run build`, zip the `restwell-theme` folder, **Appearance → Themes → Add New → Upload** |

---

## Build commands

| Script | What it does | Output |
|--------|----------------|--------|
| `npm run dev` | Tailwind watch: `input.css` → `tailwind.css` | `assets/css/tailwind.css` (unminified) |
| `npm run build` | Minify Tailwind + terser on front-end JS | `assets/css/tailwind.css` (minified), `assets/js/main.min.js`, `assets/js/analytics-loader.min.js` |

Production enqueues **minified** assets when `SCRIPT_DEBUG` is not set (`inc/enqueue.php`). After changing `assets/js/main.js` or `analytics-loader.js`, run `npm run build` before deploy.

Phosphor icon CSS and self-hosted Inter/Lora fonts are committed under `assets/`; they are not built by npm.

---

## Linting

PHP in `restwell-theme/` is checked from the **monorepo root** (not inside `restwell-theme/`) with [WordPress Coding Standards](https://github.com/WordPress/WordPress-Coding-Standards) (WPCS 3, `WordPress-Extra`) and PHPCompatibilityWP (PHP 7.4+).

| Step | Command (repo root) |
|------|---------------------|
| Install (once) | `composer install` |
| Check | `composer phpcs` |
| Auto-fix (safe fixes only) | `composer phpcbf` |

**Requirements:** PHP and [Composer](https://getcomposer.org/) on your machine. Dev dependencies live in root `composer.json`; `vendor/` is gitignored.

**Config:** [`phpcs.xml.dist`](../phpcs.xml.dist) — scans `restwell-theme/**/*.php`; `minimum_wp_version` 6.4; `testVersion` 7.4-; `text_domain` `restwell-retreats`; `prefix` `restwell`. Excludes `node_modules`, `vendor`, and generated `assets/css/tailwind.css`. CLI flags: progress, sniff codes, source (`psn`).

`composer phpcs` exits **2** when violations are found (expected on first run). Fix incrementally with `composer phpcbf` where marked `[x]`, then hand-fix the rest.

---

## Local helpers

- `scripts/local/commit-push-main.sh` — quick commit + push to main from repo root.
  Usage: `./restwell-theme/scripts/local/commit-push-main.sh -m "feat(theme): your message"`

---

## `inc/` modules

Loaded from `functions.php` unless noted. One-line purpose each.

| File | Loaded | Description |
|------|--------|-------------|
| `admin-meta-boxes.php` | ✓ | Post editor: always show Excerpt box; meta box order |
| `blog-categories.php` | ✓ | Canonical blog category slugs, seeding, footer category list |
| `csp.php` | ✓ | Content-Security-Policy (Report-Only by default; optional enforce) |
| `enqueue.php` | ✓ | `wp_enqueue_scripts`: Tailwind, Phosphor, main/analytics JS, cache-busting versions |
| `faq.php` | ✓ | FAQ data by scope (homepage / FAQ page / How It Works); FAQPage schema helpers |
| `faq-question-handler.php` | ✓ | FAQ “Ask a question” form: validate, store, email, redirect flash |
| `guest-guide.php` | ✓ | Email-gated guest arrival guide: OTP, guest list, cron invites, admin UI hooks |
| `homepage-faq.php` | ✓ | **Git-managed** homepage FAQ copy (five Q&A pairs) |
| `llms-txt.php` | ✓ | Serve theme `llms.txt` at `/llms.txt` for AI crawlers |
| `litespeed-compat.php` | ✓ | Exclude theme `/assets/` from LiteSpeed JS/CSS combine (crawler stability) |
| `meta-fields.php` | ✓ | **Page Content Fields** meta box (native post meta, not ACF) |
| `nav.php` | ✓ | Primary menu filters, slug URL resolution, fallback nav tree/markup |
| `page-meta-definitions.php` | ✓ | Field schemas per page template (used by `meta-fields.php`) |
| `performance.php` | ✓ | Responsive image sizes, LCP hero preload, bulk image regen helper |
| `post-helpers.php` | ✓ | Blog: primary category label, read-time estimate |
| `privacy-page-bootstrap.php` | ✓ | On theme activation: ensure `/privacy-policy/` shell page exists |
| `redirects.php` | ✓ | 301s: contact→enquire, legacy slugs, canonical host, author archives |
| `security-rest.php` | ✓ | Block anonymous `GET /wp/v2/users` (username enumeration) |
| `seo.php` | ✓ | Title override, canonical, JSON-LD, breadcrumbs integration |
| `seo-admin.php` | ✓ | **Search & Social** meta box + live SEO checks on pages/posts |
| `seo-dashboard.php` | ✓ | Admin dashboard widget + off-site SEO reminder notice |
| `seo-social-meta.php` | ✓ | Open Graph + Twitter Card `<meta>` output |
| `sitemap-robots.php` | ✓ | `robots.txt` sitemap line, AI crawler Allow rules, drop attachment sitemaps |
| `smtp-config.php` | ✓ | Optional `wp_mail()` SMTP when `RESTWELL_SMTP_*` constants are set |
| `social-profiles.php` | ✓ | Hardcoded official profile URLs + `sameAs` for schema |
| `theme-setup.php` | ✓ | Admin **Theme Setup**: pages, home meta seed, media, blog seed, image regen |
| `tldr.php` | ✓ | TL;DR line under heroes from post meta + fallbacks |
| `wif-helpers.php` | ✓ | Who It’s For: bullet lists and paragraph helpers from meta |
| `wp-runtime-optimization.php` | ✓ | Disable emoji scripts/styles; light runtime hygiene |
| `seo-content-seed.php` | via `theme-setup` | Default SEO meta per slug; hub/blog HTML seed for Theme Setup |
| `seo-content-seed-blog-cluster-a.php` | via `seo-content-seed` | Seeded blog post HTML (cluster A) |
| `seo-content-seed-blog-cluster-b.php` | via `seo-content-seed` | Seeded blog post HTML (cluster B) |

**Related (not in `inc/`):** `functions.php` — theme supports, image sizes, security headers (HSTS, X-Frame-Options, etc.), CRM bootstrap, Gutenberg disabled.

---

## Page templates & URLs

WordPress resolves URLs from **page slug** (`post_name`), not the PHP filename. Slugs below match **Theme Setup** (`restwell_get_theme_setup_pages()`). Assign templates under **Page → Template** if pages already exist.

| PHP template | Admin template name | Typical slug | URL path |
|--------------|---------------------|--------------|----------|
| `front-page.php` | *(static front page)* | `home` | `/` (when set as front page) |
| `template-property.php` | The Property | `the-property` | `/the-property/` |
| `template-how-it-works.php` | How It Works | `how-it-works` | `/how-it-works/` |
| `template-accessibility.php` | Accessibility | `accessibility` | `/accessibility/` |
| `template-who-its-for.php` | Who It's For | `who-its-for` | `/who-its-for/` |
| `template-whitstable-guide.php` | Whitstable Guide | `whitstable-area-guide` | `/whitstable-area-guide/` |
| `template-faq.php` | FAQ | `faq` | `/faq/` |
| `template-enquire.php` | Enquire | `enquire` | `/enquire/` |
| `template-resources.php` | Resources | `resources` | `/resources/` |
| `page-guest-guide.php` | Guest Arrival Guide | `guest-guide` | `/guest-guide/` *(email-gated)* |
| `template-privacy-policy.php` | Privacy Policy | `privacy-policy` | `/privacy-policy/` *(may follow Settings → Privacy)* |
| `template-terms-and-conditions.php` | Terms & Conditions | `terms-and-conditions` | `/terms-and-conditions/` |
| `template-accessibility-policy.php` | Accessibility Policy | `accessibility-policy` | `/accessibility-policy/` |
| `template-contact.php` | Contact | `contact` | `/contact/` → **301 to `/enquire/`** |
| `page.php` | Default | *(varies)* | Generic pages |
| `single.php` | — | *(post slug)* | `/blog/{post-slug}/` when posts page is `blog` |
| `index.php` | — | — | Fallback loop |

**Also created by Theme Setup:** `blog` → posts index (`page_for_posts`); no `template-blog.php` (WordPress uses the posts page + `index.php` / archive templates).

**Redirects (see `inc/redirects.php`):** legacy blog slugs, `?page_id=3`, old beach URL, www/apex host, author archives → home.

---

## `template-parts/`

| Partial | Role |
|---------|------|
| `breadcrumb.php` | Breadcrumb trail |
| `cta-accessibility-prompt.php` | Accessibility CTA strip |
| `how-it-works-steps.php` | Numbered steps block |
| `icon-phosphor-light.php` | Phosphor icon helper |
| `interior-hero.php` | Interior page hero |
| `legal-policy-layout.php` | Legal/policy page shell |
| `page-hero.php` | Standard page hero |
| `section-label.php` | Eyebrow / section label |
| `trust-strip.php` | Trust/partner strip |

---

## Where content lives

This theme does **not** use ACF. Editors use native WordPress meta boxes and the classic editor.

| Content | Location | Editable how |
|---------|----------|----------------|
| Home hero, sections, images, CTAs | Post meta on front page | **Page Content Fields** metabox (`inc/meta-fields.php` + `page-meta-definitions.php`) |
| Template pages (property, FAQ, enquire, etc.) | Same meta keys per template | **Page Content Fields** (tabs vary by template) |
| SEO title, description, keyphrase | `meta_title`, `meta_description`, `focus_keyphrase` | **Search & Social** metabox (`inc/seo-admin.php`) |
| TL;DR under hero | `tldr` meta | Search & Social / dedicated meta |
| Homepage FAQ (5 items) | `inc/homepage-faq.php` | **Code / Git** — change file, deploy theme |
| FAQ page + How It Works FAQs | `faq_{n}_q`, `faq_{n}_a`, `faq_{n}_cat` | FAQ template page in WP admin |
| FAQ “ask a question” submissions | Stored by handler | Form on `/faq/` → `inc/faq-question-handler.php` |
| Guest guide body | Guest template meta + CRM guest list | Page meta + **Restwell CRM → Guest Guide** |
| Blog posts | `post_content`, excerpt, categories | Classic editor + categories |
| Seeded blog/hub HTML | `inc/seo-content-seed*.php` | Re-run **Theme Setup** (force) or edit posts in admin |
| Social URLs, nav fallbacks | `inc/social-profiles.php`, `inc/nav.php` | **Code** unless overridden in menus |
| Access statement PDF URL | `restwell_access_statement_url` option | **Restwell CRM** settings |
| `llms.txt` | `restwell-theme/llms.txt` | Edit file in theme root |
| Enquiries, Mailchimp, reminders | CRM mu-plugin | `wp-content/mu-plugins/restwell-crm/` |
| Primary CTA / conversion events | `inc/ANALYTICS-PRIMARY-GOAL.md` | `restwell_cta_click`, `generate_lead` — see doc |

---

## Related documentation

### SEO (two tracks)

| Track | Doc | Scope |
|-------|-----|--------|
| **SSOT P1–P10** | [SEO-INTENT-ONPAGE-PLAN.md](./SEO-INTENT-ONPAGE-PLAN.md) | Strategy, keywords, per-URL on-page work, §13.1 audit trail |
| **Scoreboard** | [SEO-PROGRESS-MATRIX.md](./SEO-PROGRESS-MATRIX.md) | Symbols only — update after every plan write-back |
| **Template COPY-PASTE** | [COPY-PASTE-PROMPTS.md](./COPY-PASTE-PROMPTS.md) | Per-template implementation prompts; **requires matrix sync** after each run |
| **Homepage handoff** | [FRONT-PAGE-OPTIMIZATION.md](../FRONT-PAGE-OPTIMIZATION.md) | Published homepage baseline for editors and engineering |
| **Living audit** | [AUDIT.md](./AUDIT.md) | Multi-domain scorecard and open remediation |
| **Skills index** | [SKILLS_GLOSSARY.md](./SKILLS_GLOSSARY.md) | Auto-generated slash-command index (regenerate; do not hand-edit) |
| **Media alt text** | [MEDIA-SEO-DETAILS.md](./MEDIA-SEO-DETAILS.md) | Media Library metadata fill-in sheet + open optimization tasks |
| **Consolidation map** | [docs/SEO-DOC-CONSOLIDATION-CHECKLIST.md](../docs/SEO-DOC-CONSOLIDATION-CHECKLIST.md) | Merge/archive status for all SEO markdown |
| **Archived legacy** | [docs/archive/seo-legacy/](../docs/archive/seo-legacy/) | Superseded strategy, homepage, and audit sprint docs |

### Design and UX

| Doc | Scope |
|-----|--------|
| [DESIGN-SYSTEM.md](./DESIGN-SYSTEM.md) | Colours, type, spacing, components, Tailwind conventions |
| [VISUAL-FRONTEND-AUDIT.md](./VISUAL-FRONTEND-AUDIT.md) | UI audit notes and remediation tracking |

### Analytics and ops (SEO-adjacent)

| Doc | Scope |
|-----|--------|
| [inc/ANALYTICS-PRIMARY-GOAL.md](./inc/ANALYTICS-PRIMARY-GOAL.md) | Primary conversion events and message match with SEO seed |
| [inc/TESTIMONIAL-COLLECT.md](./inc/TESTIMONIAL-COLLECT.md) | Post-stay testimonial collection SOP |

---

## Deploy checklist

Run after uploading a new theme zip or merging a release branch.

| # | Task | Why |
|---|------|-----|
| 1 | `npm run build` before zipping | Ship minified CSS/JS |
| 2 | Upload & activate theme | WP Admin → Appearance → Themes |
| 3 | **Settings → Permalinks → Save** | Flush rewrite rules (redirects, `llms.txt`, CRM routes) |
| 4 | Regenerate thumbnails | CLI: `wp media regenerate --yes` or **Theme Setup** image regen — enables `restwell-hero` / `restwell-cta-bg` sizes |
| 5 | LiteSpeed / cache purge | Avoid stale CSS/JS after deploy |
| 6 | Verify security headers (HTTPS) | `Strict-Transport-Security`, `X-Content-Type-Options`, `X-Frame-Options`, `Referrer-Policy`, `Permissions-Policy` (`functions.php`) |
| 7 | CSP | Default **Report-Only** in `inc/csp.php`; review console, then enable enforce only when ready (`restwell_enable_csp_enforce`) |
| 8 | Smoke-test key URLs | `/`, `/enquire/`, `/faq/`, `/guest-guide/`, one blog post |
| 9 | CRM mu-plugin present on production | Enquiry forms and guest guide depend on `restwell-crm` |
| 10 | Optional: Theme Setup (non-destructive) | New environment only — creates pages/seeds meta without overwriting if already seeded |

---

## Repo layout (theme root)

```
restwell-theme/
├── assets/css|js|fonts|images/
├── inc/                 # PHP modules (see table above)
├── template-parts/
├── template-*.php       # Page templates
├── front-page.php
├── functions.php
├── package.json         # Tailwind + terser only
├── style.css            # Theme header (version, WP/PHP requirements)
├── DESIGN-SYSTEM.md
├── SEO-INTENT-ONPAGE-PLAN.md
├── SEO-PROGRESS-MATRIX.md
├── VISUAL-FRONTEND-AUDIT.md
└── README.md            # This file
```

**Monorepo sibling:** `wp-content/mu-plugins/restwell-crm/` — enquiries, admin CRM, Mailchimp, form notifications (not part of the theme zip unless you bundle it separately for your host).
