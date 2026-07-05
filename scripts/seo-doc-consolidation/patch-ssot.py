#!/usr/bin/env python3
"""Apply SEO doc consolidation patches to SEO-INTENT-ONPAGE-PLAN.md."""

from pathlib import Path

ROOT = Path(__file__).resolve().parents[2]
SSOT = ROOT / "restwell-theme" / "SEO-INTENT-ONPAGE-PLAN.md"

DOC_MAP = """
### 0.1 Documentation map (living vs archived)

| Track | Living docs | Archived |
|-------|-------------|----------|
| **SSOT P1–P10** | This file + [SEO-PROGRESS-MATRIX.md](SEO-PROGRESS-MATRIX.md) | — |
| **Template COPY-PASTE** | [COPY-PASTE-PROMPTS.md](COPY-PASTE-PROMPTS.md) (parallel; **post-run sync required** → §13.1 + matrix) | [PAGE-RUNS.md](../docs/archive/seo-legacy/prompt-stubs/PAGE-RUNS.md) |
| **Homepage** | [FRONT-PAGE-OPTIMIZATION.md](../FRONT-PAGE-OPTIMIZATION.md) | `docs/archive/seo-legacy/homepage/` |
| **Audit / technical** | [AUDIT.md](AUDIT.md) | `docs/archive/seo-legacy/audit-sprints/` |
| **Legacy strategy** | Absorbed into §2–§8, §16, §19 | `docs/archive/seo-legacy/legacy-strategy/` |
| **Media SEO** | [MEDIA-SEO-DETAILS.md](MEDIA-SEO-DETAILS.md) | — |
| **Skills index** | [SKILLS_GLOSSARY.md](SKILLS_GLOSSARY.md) (§18 curated subset) | — |

Full merge/archive checklist: [docs/SEO-DOC-CONSOLIDATION-CHECKLIST.md](../docs/SEO-DOC-CONSOLIDATION-CHECKLIST.md).

"""

COPY_PASTE_NOTE = """
**Parallel track:** Template-level runs also use [COPY-PASTE-PROMPTS.md](COPY-PASTE-PROMPTS.md). After each COPY-PASTE run, map outputs to P4 steps A–G and write back to **§13.1** + [SEO-PROGRESS-MATRIX.md](SEO-PROGRESS-MATRIX.md) (same rules as P4 prompts below).

"""

HOME_PRESET = """
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

"""

CONTACT_ROW = (
    "| `/contact/` (`template-contact.php`)                                     "
    "| 2026-07-05     | 2    | contact restwell Whitstable                     "
    "| phone, email, professional referral                                     "
    "| Contact Restwell Retreats \\| Accessible Whitstable                    "
    "| Phone, email and post. Professional referral lane without inventing policy. "
    "| H1 contact; H2 phone, email, location, professionals                     "
    "| Reassurance FAQ if needed                                               "
    "| Link to /enquire/, /faq/, /accessibility/                               "
    "| Seed in WP; verify NAP matches JSON-LD                                  |\n"
)

COMPETITOR_BLOCK = """
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

"""

A11Y_ROWS = """
| Image alt text | Descriptive alt on property photos; `alt=""` only for decorative; see [MEDIA-SEO-DETAILS.md](MEDIA-SEO-DETAILS.md) |
| Link text | No "click here" / "read more"; use descriptive anchors (benefits SEO + screen readers) |
| Skip link | Present in theme header; verify after layout changes |
| Colour contrast | Deep teal on white passes WCAG AA; verify gold text token on live CSS |
"""

MEASUREMENT_LOG = """
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

"""

B3_CALENDAR_NOTE = """
**12-month calendar (reconciled with legacy section 10 — 2026-07-05):** Month 1 — launch announcement + FAQ live + access statement PDF; Month 2 — Revitalise alternatives + direct payment guide; Month 3 — accessible beaches Kent + OT referral one-pager; Month 4 — booking checklist + first guest story; ongoing — one blog/month across four pillars (Accessible Travel, Funding & Access, For Professionals, Kent Coast Life). Seeded URLs in `inc/seo-content-seed-blog-cluster-*.php` supersede legacy month-only titles where both exist — prefer seeded slugs in B3 backlog.

"""

SECTION_19 = """
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

**Operating cadence:** Cross-link [plan.md](plan.md) **G7** (backlink pipeline) and **G8** (entity consistency sheet).

### 19.2 Backlink strategy (priority targets)

| Tier | Targets |
|------|---------|
| **High** | Tourism for All, DisabledHolidays.com, CS Disabled Holidays, AccessAble, Euan's Guide, Visit Kent, Google Business Profile |
| **Medium** | Visit Canterbury, Explore Kent, SimplyOwners, OpenBritain, Bing/Apple Places |
| **Cross-links (day one)** | continuityofcareservices.co.uk, CTA site — reciprocal "Continuity Group" footer links |

**Link-earning content:** Accessible beaches Kent guide; Revitalise alternatives; direct payment holiday guide; packing list; downloadable access statement PDF; professional referral guide.

**Avoid:** Paid link schemes, generic directories, reciprocal unrelated exchanges, anchor-text manipulation, PR wire services.

### 19.3 Directory submissions checklist

Track outreach in plan.md **G7** pipeline: target, tier, contact date, status, live URL, referral traffic.

"""

TECH_NOTE = """
**Forms (2026-06-18):** Enquiry and FAQ question forms require a valid phone number (`restwell_validate_submission_phone()` in theme).

"""


def main() -> None:
    text = SSOT.read_text(encoding="utf-8")

    # §0.1 after Related line
    marker = "**Related (reference only):**"
    if "### 0.1 Documentation map" not in text and marker in text:
        idx = text.find(marker)
        end = text.find("\n\n", idx)
        text = text[: end + 2] + DOC_MAP + text[end + 2 :]

    # COPY-PASTE note after "## How to run this in Cursor"
    if "Parallel track:" not in text:
        hook = "## How to run this in Cursor (skill order)"
        idx = text.find(hook)
        if idx >= 0:
            insert_at = text.find("\n", idx) + 1
            text = text[:insert_at] + COPY_PASTE_NOTE + text[insert_at:]

    # §6.1 a11y rows
    if "Image alt text" not in text:
        text = text.replace(
            "| Keyword stuffing | **Avoid** - hurts AI visibility (~negative signal in GEO research)                                           |\n",
            "| Keyword stuffing | **Avoid** - hurts AI visibility (~negative signal in GEO research)                                           |\n"
            + A11Y_ROWS,
        )

    # §8.1 competitor block
    if "#### Competitor landscape (merged" not in text:
        text = text.replace(
            "*Append `#### Comparison run - YYYY-MM-DD - <URL>` with H1 angle, H2 list, table column plan, FAQ questions (AEO), and risk notes.*\n",
            COMPETITOR_BLOCK
            + "\n*Append `#### Comparison run - YYYY-MM-DD - <URL>` with H1 angle, H2 list, table column plan, FAQ questions (AEO), and risk notes.*\n",
        )

    # §11.6 verification log
    if "#### Measurement - 2026-07-05 (consolidation)" not in text:
        text = text.replace(
            "*Append `#### Measurement - YYYY-MM-DD` with: five trend bullets, one experiment for a weak URL, KPI table hints. If GSC rows were pasted in the prompt, summarize them here as a compact markdown table (top URLs or queries only).*",
            "*Append `#### Measurement - YYYY-MM-DD` with: five trend bullets, one experiment for a weak URL, KPI table hints. If GSC rows were pasted in the prompt, summarize them here as a compact markdown table (top URLs or queries only).*"
            + MEASUREMENT_LOG,
        )

    # §16 B3 calendar note
    if "12-month calendar (reconciled" not in text:
        hook = "### B3 - 90-day content backlog"
        if hook in text:
            idx = text.find(hook)
            insert_at = text.find("\n", idx) + 1
            text = text[:insert_at] + B3_CALENDAR_NOTE + text[insert_at:]

    # §16 technical note for phone validation
    if "restwell_validate_submission_phone" not in text:
        hook = "### Optional - programmatic scale"
        if hook in text:
            idx = text.find(hook)
            text = text[:idx] + TECH_NOTE + text[idx:]

    # §13.1 home preset + contact row
    if "#### Home preset (`/`" not in text:
        hook = "### 13.1 Worksheet rows - agent-filled (Cursor)"
        idx = text.find(hook)
        if idx >= 0:
            insert_at = text.find("\n\n", idx) + 2
            text = text[:insert_at] + HOME_PRESET + text[insert_at:]

    if "| `/contact/` (`template-contact.php`)" not in text:
        # Insert after /faq/ row
        needle = "| `/faq/` (`template-faq.php`)"
        pos = text.find(needle)
        if pos >= 0:
            line_end = text.find("\n", pos) + 1
            text = text[:line_end] + CONTACT_ROW + text[line_end:]

    # Truncate corruption after first §18
    anchor = (
        "Full index: [SKILLS_GLOSSARY.md](SKILLS_GLOSSARY.md). "
        "Closest proxies for niche audits: `/seo-audit`, `/seo-meta-optimizer`, `/schema-markup`."
    )
    if text.count(anchor) >= 1:
        first = text.find(anchor) + len(anchor)
        text = text[:first].rstrip() + "\n\n---\n" + SECTION_19.strip() + "\n"

    # Link FRONT-PAGE in §16 B4 if missing
    if "FRONT-PAGE-OPTIMIZATION.md" not in text:
        text = text.replace(
            "Execute **§4** end-to-end (including **Step H**). Money pages first",
            "Execute **§4** end-to-end (including **Step H**). Homepage published baseline: [FRONT-PAGE-OPTIMIZATION.md](../FRONT-PAGE-OPTIMIZATION.md). Money pages first",
        )

    SSOT.write_text(text, encoding="utf-8")
    print(f"Patched {SSOT} ({len(text.splitlines())} lines)")


if __name__ == "__main__":
    main()
