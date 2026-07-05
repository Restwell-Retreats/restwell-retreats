> **Archived 2026-07-05.** Superseded by [`restwell-theme/SEO-INTENT-ONPAGE-PLAN.md`](../restwell-theme/SEO-INTENT-ONPAGE-PLAN.md) (site SEO SSOT), [`FRONT-PAGE-OPTIMIZATION.md`](../FRONT-PAGE-OPTIMIZATION.md) (homepage), and/or [`restwell-theme/AUDIT.md`](../restwell-theme/AUDIT.md). Open work: SSOT §11.6 / §16 and AUDIT sprint plan. Do not execute tasks from this file.

# Homepage: SEO + CRO (no testimonials yet)

## Goal

Make the Restwell homepage clearer for **search intent** and **enquiry intent**, using **trust without guest quotes** (specs, CQC, process, internal links) until testimonials exist.

**CRO baseline (diagnostic):** Moderate readiness (~low 70s); fix fundamentals before A/B tests. **SEO:** One primary topic cluster per section; natural keywords; E-E-A-T via specificity and verifiable claims.

---

## Tasks

- [x] **1. Lock primary goal + measurement** — Primary success: **start enquiry journey**. Theme documents `inc/ANALYTICS-PRIMARY-GOAL.md`. **`restwell_cta_click`** fires when `gtag` exists and user clicks any `[data-cta]` (`assets/js/main.js`). → *Verify in GA4:* event appears after clicking hero or bottom CTA.

- [x] **2. Hero copy: 5-second clarity + primary keyword** — Updated fallbacks in `front-page.php` + `theme-setup.php`: accessible self-catering Whitstable, audience, specs before dates. Em dashes removed in touched strings (Beautiful Prose / project copy rules).

- [x] **3. Meta title + description (homepage)** — Defaults in `inc/seo-content-seed.php` slug `home`. **Existing sites:** update Home page SEO fields in WP or re-run SEO seed if your workflow uses it.

- [x] **4. Trust band + bottom CTA (no testimonials)** — `cta_body` default stresses objection handling; `template-parts/cta-accessibility-prompt.php` adds spec link before final buttons. Trust strip defaults unchanged (CQC line).

- [x] **5. Internal links from homepage body** — Property quick links already use descriptive anchors (Accessibility specification, Who it’s for, etc.). No “click here”.

- [x] **6. Collect future proof (ops, not dev)** — `inc/TESTIMONIAL-COLLECT.md` (owner, permission, WP fields).

---

## Done when

- [x] Primary conversion goal is **named** and **measurable** (docs + optional `restwell_cta_click`).
- [x] Hero + meta defaults align on **accessible self-catering Whitstable** and specs-first promise.
- [x] Trust on the page does **not** depend on testimonials.
- [x] Pillar pages are **linked** with descriptive copy; Accessibility reinforced at final CTA.

## Notes

- **Do not** run multivariate tests until fundamentals above are live and traffic allows (CRO guardrail).
- **Keyword density** targets from seo-content-writer are secondary to **clarity and specificity**; E-E-A-T here means dimensions, regulation, and honest process—not filler stats.
