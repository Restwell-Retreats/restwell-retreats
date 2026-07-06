# SEO documentation consolidation checklist

**Executed:** 2026-07-05  
**Living operators:** [SEO-INTENT-ONPAGE-PLAN.md](../restwell-theme/SEO-INTENT-ONPAGE-PLAN.md) · [SEO-PROGRESS-MATRIX.md](../restwell-theme/SEO-PROGRESS-MATRIX.md) · [COPY-PASTE-PROCESS.md](../restwell-theme/COPY-PASTE-PROCESS.md) · [COPY-PASTE-PROMPTS.md](../restwell-theme/COPY-PASTE-PROMPTS.md) · [plan.md](../restwell-theme/plan.md) · [FRONT-PAGE-OPTIMIZATION.md](../FRONT-PAGE-OPTIMIZATION.md)

---

## Standard archive banner

```markdown
> **Archived YYYY-MM-DD.** Superseded by [`restwell-theme/SEO-INTENT-ONPAGE-PLAN.md`](../restwell-theme/SEO-INTENT-ONPAGE-PLAN.md) (site SEO SSOT), [`FRONT-PAGE-OPTIMIZATION.md`](../FRONT-PAGE-OPTIMIZATION.md) (homepage), and/or [`restwell-theme/AUDIT.md`](../restwell-theme/AUDIT.md). Open work: SSOT §11.6 / §16 and AUDIT sprint plan. Do not execute tasks from this file.
```

**Archive root:** [`docs/archive/seo-legacy/`](archive/seo-legacy/)

---

## Master table (29 files)

| # | File | Tier | Action | Merge target | Pre-merge verification | Pointer updates | Status |
|---|------|------|--------|--------------|------------------------|-----------------|--------|
| 1 | `restwell-theme/SEO-INTENT-ONPAGE-PLAN.md` | 1 | Keep + refactor | §0.1 doc map; §13.1 Home preset; §19 GBP/authority; §8.1 competitors; §6.1 a11y; §11.6 verification log; §16 B3 calendar; `/contact/` row; dedupe §17/§18 | SSOT patch script applied | README, matrix, COPY-PASTE | [x] |
| 2 | `restwell-theme/SEO-PROGRESS-MATRIX.md` | 1 | Keep | COPY-PASTE sync rule #7; §18 = `x`; contact in meta | 34 URLs incl. `/contact/` | README | [x] |
| 3 | `restwell-theme/COPY-PASTE-PROMPTS.md` | 1 | Keep + refactor | Per-page manifests only; workflow → COPY-PASTE-PROCESS.md | `/whitstable-area-guide/` | README, SSOT §0.1 | [x] |
| 3b | `restwell-theme/COPY-PASTE-PROCESS.md` | 1 | **New** | Workflow, sync, shared pipeline block | — | README, SSOT §0.1, matrix | [x] |
| 4 | `restwell-theme/PAGE-RUNS.md` | 1 | Merge → archive | Folded into COPY-PASTE intro + run log | Run log preserved | COPY-PASTE | [x] |
| 5 | `restwell-theme/SKILLS_GLOSSARY.md` | 1 | Keep | Reference only | — | README | [x] |
| 6 | `restwell-theme/README.md` | 1 | Refactor | Two-track SEO doc map | — | — | [x] |
| 7 | `restwell-seo-section1.md` | 2 | Archive | §2.1/§2.6 already supersede keyword tables | No orphaned P1 keywords | plan-seo-ops.md §F | [x] |
| 8 | `restwell-seo-sections2-4.md` | 2 | Archive | §13.1 + `seo-content-seed.php` live | Title/meta parity via seeds | — | [x] |
| 9 | `restwell-seo-sections5-7.md` | 2 | Merge → archive | §19.1 GBP; §3.3/B2 links; skip JSON-LD | GBP Q&A/posts in §19 | plan-seo-ops.md G7/G8 | [x] |
| 10 | `restwell-seo-sections8-11.md` | 2 | Merge → archive | §8.1 competitors; §19.2 backlinks; §16 B3 calendar; §6.1 a11y | Calendar reconciled with seeds | plan-seo-ops.md G9 | [x] |
| 11 | `restwell-theme/plan.md` | 2 | Refactor | Hub only; CRM → plan-crm-ops.md; SEO → plan-seo-ops.md | — | README, SSOT §0.1 | [x] |
| 11b | `restwell-theme/plan-crm-ops.md` | 2 | **New** | Sections A–E | — | plan.md | [x] |
| 11c | `restwell-theme/plan-seo-ops.md` | 2 | **New** | Sections F–G; pointers to SSOT/matrix | — | plan.md, SSOT §19 | [x] |
| 12 | `front-page-seo-optimization.md` | 3 | Archive | Open checks → FRONT-PAGE §6 + §11.6 | Verification rows logged | FRONT-PAGE | [x] |
| 13 | `FRONT-PAGE-OPTIMIZATION.md` | 3 | Keep | Linked from §13.1 Home + §16 B4 | — | SSOT | [x] |
| 14 | `homepage-seo-cro-plan.md` | 3 | Archive | Absorbed in front-page cluster | All tasks done | — | [x] |
| 15 | `restwell-theme/HOMEPAGE-PIPELINE-DELIVERABLE.md` | 3 | Merge → archive | §13.1 Home preset | Fields + LodgingBusiness table | SSOT | [x] |
| 16 | `front-page-polish.md` | 3 | Archive | Verification gates → FRONT-PAGE §6 | MFRI historical only | — | [x] |
| 17 | `restwell-theme/seo-admin-cpt.md` | 4 | Archive | Vision only; live = `inc/seo-admin.php` | — | — | [x] |
| 18 | `restwell-theme/MEDIA-SEO-DETAILS.md` | 4 | Keep | Open tasks section merged from TODO | Hero derivatives documented | SSOT §6.1 | [x] |
| 19 | `restwell-theme/MEDIA-OPTIMIZATION-TODO.md` | 4 | **Archived** | Folded into MEDIA-SEO-DETAILS | Reconciled with DETAILS | `prompt-stubs/` | [x] |
| 20 | `restwell-theme/AUDIT.md` | 5 | Keep | PERFECT-SITE open items extracted | Items #6,14,22–25 | SSOT §16 | [x] |
| 21 | `restwell-theme/PERFECT-SITE-PLAN.md` | 5 | Extract → archive | → AUDIT + §16 B3/B6 | Open ⏳ owned | AUDIT | [x] |
| 22 | `audit-90-all-domains.md` | 5 | Archive | Outcomes in AUDIT | All `[x]` | — | [x] |
| 23 | `high-priority-audit-remediation.md` | 5 | Archive | In AUDIT scorecard | All `[x]` | SSOT phone note | [x] |
| 24 | `critical-audit-fixes.md` | 5 | Archive | OG/Twitter in `seo-social-meta.php` | All `[x]` | — | [x] |
| 25 | `restwell-theme/inc/ANALYTICS-PRIMARY-GOAL.md` | 6 | Keep | Cross-link §11 + README | — | README | [x] |
| 26 | `restwell-theme/inc/TESTIMONIAL-COLLECT.md` | 6 | Keep | Optional §16 B5 | — | — | [x] |
| 27 | `restwell-theme/docs/about-your-stay-welcome-sheet-copy.md` | 6 | Keep | Post-booking; not in matrix | — | — | [x] |
| 28 | `audit.md` | 6 | Archive | Prompt stub | — | — | [x] |
| 29 | `hero-audit-follow-up.md` | 6 | **Archived** | Open items in DESIGN-SYSTEM §Hero follow-up | `homepage/` | [x] |
| 30 | `restwell-theme/VISUAL-FRONTEND-AUDIT.md` | 7 | Keep | Remediation status header | — | COPY-PASTE-PROCESS §Visual pass | [x] |

*Note: 30 rows — Tier 1–7 sum to 29 SEO-involved files plus `plan.md` §F–G counted with legacy row 11.*

---

## Gap-audit worksheet (Phase 1)

| Source | Method | Result | Pass |
|--------|--------|--------|------|
| section1 keywords | Grep §2.1 + §2.6 | Primary/secondary terms present in evidence runs | Yes |
| sections2-4 page specs | §13.1 + seeds | Live slugs use `/enquire/` not `/booking/` | Yes |
| sections5-7 GBP | Read §7 | Merged to SSOT §19.1 | Yes |
| sections8-11 calendar | §16 B3 + blog seeds | Reconciliation note appended; seeds authoritative | Yes |
| HOMEPAGE-PIPELINE-DELIVERABLE | §3, §7, §10 | Merged to §13.1 Home preset | Yes |
| PERFECT-SITE-PLAN open ⏳ | Extract #6,14,22–25 | Owned in AUDIT High + §11.6 | Yes |

---

## Execution phases

| Phase | Description | Status |
|-------|-------------|--------|
| 0 | This checklist + `docs/archive/seo-legacy/README.md` | Done |
| 1 | Gap audits (table above) | Done |
| 2 | SSOT merges (`scripts/seo-doc-consolidation/patch-ssot.py`) | Done |
| 3 | Wiring (COPY-PASTE, README, plan.md, matrix) | Done |
| 4 | Archive moves (`scripts/seo-doc-consolidation/archive-seo-docs.sh`) | Done |
| 5 | Link verification (`rg` stale paths) | Done |

---

## Pointer-update manifest

| File | Updates made |
|------|----------------|
| `restwell-theme/README.md` | Two-track SEO table; COPY-PASTE-PROCESS; ops plan split |
| `restwell-theme/plan.md` | Hub only; links to plan-crm-ops, plan-seo-ops |
| `restwell-theme/plan-crm-ops.md` | Sections A–E extracted from plan.md |
| `restwell-theme/plan-seo-ops.md` | Sections F–G; G7→§19; G9→§8.1 |
| `restwell-theme/SEO-PROGRESS-MATRIX.md` | COPY-PASTE-PROCESS sync; §18 `x`; meta date |
| `restwell-theme/COPY-PASTE-PROCESS.md` | Workflow + shared pipeline; inward SSOT/matrix links |
| `restwell-theme/COPY-PASTE-PROMPTS.md` | Manifests only; `@` COPY-PASTE-PROCESS per run |
| `restwell-theme/AUDIT.md` | PERFECT-SITE extractions |
| `FRONT-PAGE-OPTIMIZATION.md` | Live verification checklist |
| `restwell-theme/DESIGN-SYSTEM.md` | Hero follow-up open items table |
| `restwell-theme/VISUAL-FRONTEND-AUDIT.md` | Remediation status header |
| `restwell-theme/MEDIA-SEO-DETAILS.md` | Open tasks from TODO |
| `restwell-theme/MEDIA-SEO-DETAILS.md` | Open tasks section; archive link to TODO |

---

## Archive inventory

| Subfolder | Files |
|-----------|-------|
| `legacy-strategy/` | `restwell-seo-section1.md`, `restwell-seo-sections2-4.md`, `restwell-seo-sections5-7.md`, `restwell-seo-sections8-11.md` |
| `homepage/` | `front-page-seo-optimization.md`, `homepage-seo-cro-plan.md`, `front-page-polish.md`, `HOMEPAGE-PIPELINE-DELIVERABLE.md` |
| `audit-sprints/` | `audit-90-all-domains.md`, `high-priority-audit-remediation.md`, `critical-audit-fixes.md`, `PERFECT-SITE-PLAN.md` |
| `prompt-stubs/` | `audit.md`, `seo-admin-cpt.md`, `PAGE-RUNS.md`, `MEDIA-OPTIMIZATION-TODO.md` |

---

## Target end state

| Action | Count |
|--------|-------|
| Keep (living) | 12 |
| Merge then archive | 10 |
| Archive only | 6 |
| Refactor in place | 3 |
| Keep until tasks closed | 1 (`hero-audit-follow-up.md`) |
