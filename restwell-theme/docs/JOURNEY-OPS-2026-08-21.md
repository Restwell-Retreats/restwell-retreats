# Enquire journey ops notes — 21 Aug 2026

## Pipeline

`template-enquire.php` → `restwell_handle_enquire_submit()` (mu-plugin) → CRM `rw_enquiries` → staff notify + guest ack (`restwell_wp_mail_with_retry`).

## Fixes landed this pass

- Funding slugs aligned (`self` / `kcc` / `chc` / `direct` / `''`) with legacy alias map.
- Flash errors consumed (`enq_flash` transient) + field repopulation.
- Success variants: default / urgent / duplicate / `mail_warn`.

## SMTP / deliverability (ops, not theme)

Theme support: define `RESTWELL_SMTP_*` in `wp-config.php` — see [`inc/smtp-config.php`](../inc/smtp-config.php).

| Check | Playground | Live production |
|-------|------------|-----------------|
| Form → CRM row | Yes | Yes |
| Staff + guest email | Unreliable (no real SMTP) | Requires host SMTP **or** `RESTWELL_SMTP_*` + SPF/DKIM/DMARC on From domain |
| Failure visibility | CRM notes when `wp_mail` returns false | Same |

## Playground verification (21 Aug 2026)

With CRM mu-plugin present under Playground `wp-content/mu-plugins/`:

| Check | Result |
|-------|--------|
| Happy path | `?sent=1&mail_warn=1` (mail_warn expected — no SMTP); CRM row “Ops Test Guest”; funding **Self-funded** |
| Duplicate | `?sent=1&duplicate=1` → “We already have your enquiry” |
| Validation flash | `?enq_flash=…` → `.form-errors` + field repopulation |

Live SMTP / SPF-DKIM-DMARC still needs a production check with a `+crmtest` alias after deploy.

