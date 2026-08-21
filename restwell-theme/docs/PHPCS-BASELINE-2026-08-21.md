# PHPCS security baseline — 21 Aug 2026

Replaces reliance on [TECH-DEBT-AUDIT.md](../TECH-DEBT-AUDIT.md) §2.1–2.2 (5 July 2026), whose file:line citations are stale.

## Scope

- Config: repo-root `phpcs.xml.dist`
- Paths: `restwell-theme/` + `wp-content/mu-plugins/restwell-crm/` (+ loader `restwell-crm.php`)
- Command: `composer phpcs` from repo root

## Headline (full WordPress-Extra)

~3374 errors in 81 files at start of this workstream (mostly auto-fixable formatting / style). **Out of scope.**

## Security sniffs (this workstream) — after fixes

| Sniff | Errors (2026-08-21 post-fix) | Notes |
|-------|-------------------------------|--------|
| `WordPress.Security.EscapeOutput` | **0** | July “11 OutputNotEscaped” already gone before this pass |
| `WordPress.DB.PreparedSQL` | **0** | Converted CRM/guest-guide/FAQ/reminder queries to `%i` + `prepare()`; one justified `phpcs:disable` remains on enquiry list dynamic WHERE (fragments pre-prepared; orderby allow-listed) |

### Verify

```bash
composer phpcs -- --sniffs=WordPress.Security.EscapeOutput,WordPress.DB.PreparedSQL
```

Expect exit 0 / no violations.
