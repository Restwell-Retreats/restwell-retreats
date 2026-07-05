> **Archived 2026-07-05.** Superseded by [`restwell-theme/SEO-INTENT-ONPAGE-PLAN.md`](../restwell-theme/SEO-INTENT-ONPAGE-PLAN.md) (site SEO SSOT), [`FRONT-PAGE-OPTIMIZATION.md`](../FRONT-PAGE-OPTIMIZATION.md) (homepage), and/or [`restwell-theme/AUDIT.md`](../restwell-theme/AUDIT.md). Open work: SSOT §11.6 / §16 and AUDIT sprint plan. Do not execute tasks from this file.

# Homepage pipeline deliverable (`front-page.php`)

Consolidated output for the Homepage-only manifest: private adapted coastal home, optional CQC-regulated care via partner, honest access. Primary CTA: property; secondary: enquire. No fabricated testimonials.

**Sources:** [`front-page.php`](front-page.php), [`inc/page-meta-definitions.php`](inc/page-meta-definitions.php) (`restwell_get_front_page_field_definitions`), [`inc/seo-content-seed.php`](inc/seo-content-seed.php) (slug `home`), [`inc/seo.php`](inc/seo.php).

---

## 1. Copy brief summary

- **Goal:** Drive enquiries and property exploration for accessible Whitstable stays.
- **Audience:** Disabled guests, families, carers, people comparing accessible stays.
- **Objection:** “Accessible” listings that are not actually suitable — countered with specific equipment, published spec, low-pressure CTAs.
- **Proof:** On-page facts only; testimonial block only if real quotes are stored in meta.

---

## 2. Search and Social (post meta)

| Key | Purpose |
|-----|---------|
| `focus_keyphrase` | e.g. `accessible holiday cottage in whitstable` (see seed) |
| `meta_title` | Seeded: Accessible Holiday Cottage in Whitstable, Kent \| {site name} |
| `meta_description` | Seeded: adapted cottage, hoist, profiling bed, book direct |
| `og_image_id` | Optional attachment for social card |

**Risk:** CQC claims apply to Continuity of Care Services as regulator context for partner care — keep wording consistent across sections.

---

## 3. Page Content Fields (all keys)

Hero: `hero_eyebrow`, `hero_heading`, `hero_subheading`, `hero_media_id`, `hero_cta_primary_label`, `hero_cta_primary_url`, `hero_cta_secondary_label`, `hero_cta_secondary_url`, `hero_cta_promise`.

What is Restwell: `what_restwell_label`, `what_restwell_heading`, `intro_body` (allows HTML via `wp_kses_post`).

Who: `who_label`, `who_heading`, `who_guest_title`, `who_guest_body`, `who_carer_title`, `who_carer_body`.

Property: `property_label`, `property_heading`, `property_body`, `property_cta_label`, `property_cta_url`, `property_image_id`.

Why: `why_label`, `why_heading`, `why_item1_title` … `why_item4_desc`.

Trust: `trust_label`, `trust_heading`, `trust_badge_image_id`, `trust_line`.

Testimonials: `testimonial_label`, `testimonial_heading`, `testimonial_1_quote` … `testimonial_5_role`.

CTA band: `cta_heading`, `cta_body`, `cta_primary_label`, `cta_primary_url`, `cta_secondary_label`, `cta_secondary_url`, `cta_promise`, `cta_image_id`.

**Defaults** when meta is empty are defined in [`front-page.php`](front-page.php) (lines 17–61 and testimonial loop).

---

## 4. SEO structure

- **H1:** Single — `#home-hero-heading` (`hero_heading`).
- **H2:** What is Restwell, Who it’s for, Property snapshot, Why Restwell, optional Trust/Testimonials, bottom CTA.
- **H3:** Who cards (guest / carer); Why grid (four items).
- **Internal links (template):** Who-it’s-for page; property strip links to accessibility, who, Whitstable guide, how-it-works when pages exist.

**Siblings (avoid duplicate primary intent):** Homepage = discovery; [`template-property.php`](template-property.php) = depth; [`template-accessibility.php`](template-accessibility.php) = full spec; [`template-enquire.php`](template-enquire.php) = conversion; [`template-who-its-for.php`](template-who-its-for.php) = persona detail.

---

## 5. Schema

- **Do not add** extra homepage-only JSON-LD beyond theme output.
- **Existing:** `is_front_page()` outputs `WebSite` then `LodgingBusiness`; interior pages get `WebSite` + `Organization` bundle (`inc/seo.php`). `VacationRental` only on property template.

---

## 6. Polish (restwell-page-polish)

- Tokens: `--deep-teal`, `--warm-gold-hero`, `--soft-sand`, `--bg-subtle`, etc. from [`assets/css/input.css`](assets/css/input.css). Homepage markup uses Tailwind theme colours where they match the design system (`text-deep-teal`, `bg-soft-sand`, `bg-sea-glass/30`, `bg-warm-gold/20`, `bg-deep-teal/75`, `bg-[var(--driftwood)]`, `hover:text-[var(--warm-gold-text)]`); secondary body copy still uses `#3a5a63` (no single token match).
- Escaping: `esc_html` for plain strings; `esc_url` for hrefs; `wp_kses_post` for `intro_body` only.
- **vs property template:** Homepage is summary + story; property page is detail, gallery, practicals.

---

## 7. Editor note

If `post_content` is non-empty, the template uses editor HTML and omits the default section stack and bottom CTA — see `$use_editor_main` in [`front-page.php`](front-page.php).

---

## 8. CMS images and meta (optional — WordPress admin)

Do in **WP admin** when final assets and copy should override PHP fallbacks:

| Action | Keys / location |
|--------|------------------|
| Hero media | `hero_media_id` (image or video; video uses poster where applicable) |
| Property block | `property_image_id` |
| Closing CTA band | `cta_image_id` |
| Social / Open Graph | `og_image_id` (Search and Social meta box; also used for **LodgingBusiness** `image` when set — see §10) |
| Override seeded SEO | `meta_title`, `meta_description`, `focus_keyphrase` (see [`inc/seo-admin.php`](inc/seo-admin.php) and seed for slug `home` in [`inc/seo-content-seed.php`](inc/seo-content-seed.php)) |

Paste **Page Content Fields** only if published copy should differ from defaults in [`front-page.php`](front-page.php); see §3 for the full key list.

---

## 9. Audience vs `who_heading` (optional)

Default **`who_heading`** in code is *Two people. One break.* The pipeline audience also includes **families**. If marketing wants alignment, set **`who_heading`** (and related who-card copy if needed) via **meta only** — no template change required.

---

## 10. LodgingBusiness JSON-LD — data sources (verify NAP / facts)

Homepage outputs **`LodgingBusiness`** in [`restwell_output_jsonld_lodging_business()`](inc/seo.php) (`is_front_page()`). Confirm these match **live** business details in **Settings → Restwell** (or equivalent options UI) and the front page:

| Schema field | Source |
|--------------|--------|
| `name` | `get_bloginfo( 'name' )` |
| `description` | Fixed string in code (accessible self-catering Whitstable); adjust only if intentionally changed in code |
| `url` | `home_url( '/' )` |
| `address.streetAddress` | Option `restwell_property_address` (default `101 Russell Drive` if unset) |
| `address.postalCode` | Option `restwell_property_postcode` (default `CT5 2RQ` if unset) |
| `addressLocality` / `addressRegion` / `addressCountry` | Hardcoded `Whitstable`, `Kent`, `GB` |
| `geo` | Hardcoded `51.3600`, `1.0300` — update in code if coordinates must be exact |
| `telephone` | Option `restwell_phone_number` (omitted if empty) |
| `email` | Option `restwell_enquiry_notify_email` (omitted if empty) |
| `image` | Front page `og_image_id`, else hero image attachment id `hero_media_id` if image type |
| `tourBookingPage` | Permalink of page slug `enquire`, or `/enquire/` |
| `checkinTime` / `checkoutTime` / `petsAllowed` / `smokingAllowed` / `amenityFeature` | Hardcoded in `inc/seo.php` — change only if facts differ |

If any option or hardcoded value is wrong, fix **data in admin** or **small code updates** in `inc/seo.php`; do not add extra homepage-only JSON-LD types for the audit.
