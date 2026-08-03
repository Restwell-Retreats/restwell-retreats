# SEO sources (pointers only)

## Must use

| What | Path |
|------|------|
| Titles, metas, `focus_keyphrase` | [`inc/seo-content-seed-meta.php`](../../inc/seo-content-seed-meta.php) |
| Keyword map + clash audit | [`inc/seo-keyword-map.php`](../../inc/seo-keyword-map.php) |
| Lane rules for skills | [`LANES.md`](LANES.md) |

## Optional (don’t load by default)

| What | Path | When |
|------|------|------|
| Intent map detail | [`SEO-INTENT-ONPAGE-PLAN.md`](../../SEO-INTENT-ONPAGE-PLAN.md) **§16 B2** | Deep cannibalization / cluster work |
| Research warehouse | Same plan, §2 / §3 / §13.1 | Only if user asks for research write-back |
| Progress scoreboard | [`SEO-PROGRESS-MATRIX.md`](../../SEO-PROGRESS-MATRIX.md) | Publishing pipeline A–G ticks |
| Monthly ops checklist | [`plan-seo-ops.md`](../../plan-seo-ops.md) | Cadence after pages ship |
| Hub plan index | [`plan.md`](../../plan.md) | Cross-track priority |
| Homepage SEO handoff | [`docs/FRONT-PAGE-OPTIMIZATION.md`](../FRONT-PAGE-OPTIMIZATION.md) | Live home polish |
| Living audit scorecard | [`docs/archive/AUDIT.md`](../archive/AUDIT.md) | Open trust/PDF items |

## Ignore

| Path | Why |
|------|-----|
| [`docs/archive/seo-legacy/`](../../../docs/archive/seo-legacy/) | Archived 2026-07-05 — do not execute |
| Mockup `title` / meta unless user is syncing design → seeds | Design layer |

## Theme SEO runtime (code, not strategy)

| Module | Path |
|--------|------|
| Bootstrap | [`inc/seo.php`](../../inc/seo.php) |
| Admin metabox | [`inc/seo-admin.php`](../../inc/seo-admin.php) |
| OG / Twitter | [`inc/seo-social-meta.php`](../../inc/seo-social-meta.php) |
| JSON-LD helpers | [`inc/seo/jsonld.php`](../../inc/seo/jsonld.php) |
