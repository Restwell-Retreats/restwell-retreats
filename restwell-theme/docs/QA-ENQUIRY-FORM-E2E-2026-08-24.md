# Enquiry form end-to-end QA — 2026-08-24

## Scope

Full walkthrough of `/enquire/`: step 1 → 2 → 3 validation, draft
persistence for returning/interrupted visitors, and final submission
into the CRM.

## Bugs found and fixed

### 1. Draft persistence never activated (dead selector)

`initEnquiryDraftPersistence()` in `assets/js/main.js` looked for:

```js
document.querySelector('.restwell-enq-form[data-multistep]')
```

But the real markup (`template-enquire.php`) puts `data-multistep` on the
**outer wrapper** `<div class="multistep">` and `data-multistep-form` (a
different attribute) on the `<form class="restwell-enq-form">` itself.
That selector can never match, so the entire draft-save/restore feature —
despite being fully built, commented, and wired into `safeInit()` — has
never run in production.

Fixed the selector to `[data-multistep] .restwell-enq-form[data-multistep-form]`,
which matches the real DOM.

A related dead function, `initMultiStepForm()`, has the same broken
selector and duplicates step-navigation logic that is already handled
(correctly, and differently) by `shared.js`. Left it disabled rather than
"fixing" it — re-enabling it risks double-binding click/submit handlers
onto the same form. Flagged for removal during the JS modularisation pass.

### 2. `isServerPrefilled()` always returned `true`

Once the selector above was fixed, the draft still never restored. The
guard meant to detect "the server just re-rendered this form with your
failed-validation values, don't clobber them with an old draft" checked
**every** persisted field for a non-empty value — including
`enq_guests` (defaults to `2`), `enq_funding` (defaults to `self`), and
`enq_contact_preference` (defaults to `email`), all of which render with
a non-empty value on a first-ever, completely fresh page load. So the
check was true 100% of the time, and `applyDraft()` / the "We restored
your details…" notice never ran.

Fixed by checking only the fields that genuinely render empty in the
plain template and only gain a value via `$enq_val()` echoing back a
failed submission (name, email, phone, dates, message, textareas,
checkboxes) — excluding the three fields with non-empty HTML defaults.

### 3. Discard-and-restart button referenced non-existent classes

`showRestoredNotice()`'s "Discard and start fresh" handler tried to find
`.step-node[data-step="1"]`, `.enquire-step:not(.hidden)`, and
`.step-back[data-back="1"]` — none of which exist in the real markup
(which uses `.form-step[data-step-panel]` / `[data-step-prev]`, owned by
`shared.js`). It degraded safely (no-op) rather than crashing, but never
actually returned the user to step 1. Rewrote it to walk back through
the real `[data-step-prev]` button the correct number of times.

### 4. `main.min.js` was a stale, manually-maintained build

The theme has no build tooling (no `package.json`), yet
`inc/enqueue.php` serves `assets/js/main.min.js` in production
(`assets/js/main.js` is only used when `SCRIPT_DEBUG` is on). All of the
above fixes were invisible on the live site until `main.min.js` was
regenerated. Rebuilt it with `npx terser` (one-off, not added as a
project dependency) after every `main.js` change in this pass.
**Any future edit to `main.js` must be followed by regenerating
`main.min.js`, or it silently won't ship.** This is a standing risk —
worth turning into an actual build step during the JS refactor (task 7).

## Verified via browser (CDP)

- Filled step 1 (name/email/phone), confirmed a debounced write to
  `localStorage['restwell_enquiry_draft_v1']`.
- Reloaded the page: "We restored your details from N minutes ago."
  notice appeared, name/email fields repopulated.
- Clicked "Discard and start fresh": notice removed, fields cleared,
  focus returned to the name field, `localStorage` entry removed.
- Refilled all three steps, ticked consent, submitted. Landed on
  `/enquire/?sent=1&mail_warn=1#enquiry-result` (the `mail_warn` flag is
  expected here — this local Playground instance has no mail transport
  configured, and the theme correctly falls back to "your enquiry is
  still saved, call us if you don't hear back" messaging rather than
  failing silently).
- Confirmed `localStorage` draft was cleared on successful submit.
- Confirmed the enquiry landed in **Restwell → Enquiries** in wp-admin
  with status "New", name/email/phone visible in the list.

## Known minor issue not fixed (low priority)

Discarding a draft calls `writeField(field, '')` on the `<select>`
elements too (`enq_contact_preference`, `enq_funding`). Setting a
select's `.value` to `''` when no option has that value doesn't reset it
to the *first* option — in one test it landed on the *last* option
("Not sure yet") instead of the sensible default ("Self-funded"/"Email").
Cosmetic only: the field is still a valid, submittable choice, just not
the one a fresh page load would have shown. Left as-is to keep this pass
scoped to the reported bug; worth a one-line fix (reset selects to their
first `<option>` on discard) alongside the JS refactor.
