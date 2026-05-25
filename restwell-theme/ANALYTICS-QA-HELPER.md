# Analytics QA Helper (GA4)

Use this helper when validating frontend events in `assets/js/main.js`.

## 1) Quick setup

- Enable GA4 DebugView (Tag Assistant or GA debug extension).
- Open the page you want to test in a clean session.
- Keep `ANALYTICS-EVENT-SCHEMA.md` open beside this checklist.

## 2) Test actions and expected events

- Open an enquiry form and start typing -> `enquiry_form_started`
- Move between enquiry steps -> `enquiry_step_changed`
- Submit enquiry successfully (`?sent=1`) -> `enquiry_form_submitted`
- Expand any FAQ item -> `faq_expanded`
- Scroll page to 25/50/75/90% -> `scroll_depth`
- Click any element with `data-cta` -> `restwell_cta_click`
- Click phone link (`tel:`) -> `phone_number_clicked`
- Click email link (`mailto:`) -> `email_clicked`
- Visit `/the-property/` -> `property_page_viewed`
- Visit `/accessibility/` -> `accessibility_spec_viewed`

## 3) Parameter assertions

For every event above, confirm:

- `page_path` exists and matches the current path.
- `user_type` exists and equals `guest`.

Then verify event-specific fields:

- `enquiry_step_changed` -> `enquiry_step`
- `faq_expanded` -> `faq_category`
- `scroll_depth` -> `scroll_percent`
- `enquiry_form_submitted` -> `source_page`
- `restwell_cta_click` -> `cta_id`, `cta_location`, `cta_label`, `target_url`
- `phone_number_clicked` -> `phone_number`
- `email_clicked` -> `email_address`

## 4) Drift guardrails

- Do not ship with renamed or duplicate event names.
- Do not add custom params unless schema is updated first.
- If code changes event shape, update `ANALYTICS-EVENT-SCHEMA.md` in the same PR.
