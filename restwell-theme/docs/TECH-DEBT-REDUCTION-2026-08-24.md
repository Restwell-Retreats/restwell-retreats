# Tech debt reduction — 24 Aug 2026

Part of the "make it perfect" workstream, deliverable 4: refactor the two
~490-line functions in `inc/crm/enquiries.php`, and either modularise
`assets/js/main.js` or justify leaving it.

## 1. `inc/crm/enquiries.php` — refactored

### Before

Two "god functions" did everything for their page:

- `restwell_crm_enquiries_page()` (~207 lines): handled the bulk-status POST,
  read every `$_GET` filter/sort/paging param, ran the `$wpdb` query, computed
  status counts, and rendered ~330 lines of list-table HTML — all inline, in
  one function.
- `restwell_crm_enquiry_detail( $id )` (~490 lines): handled the detail-view
  POST (status/notes/follow-up), then rendered the entire two-column detail
  screen (contact card, guest-guide lookup, stay-dates form, requirements,
  message, status form, staff notes, activity log, quick actions) inline.

### After

Split into 8 single-responsibility functions:

| Function | Responsibility |
|---|---|
| `restwell_crm_handle_enquiry_detail_post( $table )` | POST handler: status / notes / follow-up updates from the detail view |
| `restwell_crm_handle_bulk_status_post()` | POST handler: bulk status update from the list view |
| `restwell_crm_get_enquiries_list_data( $table )` | Parses filters/sort/paging, runs the query, returns one data array |
| `restwell_crm_enquiries_page()` | Thin orchestrator: calls the two POST handlers, then either shows the detail view or renders the list panel |
| `restwell_crm_render_enquiries_panel( $list )` | Filter tabs, search box, bulk-action form and results table |
| `restwell_crm_enquiry_detail( $id )` | Thin orchestrator: fetches the row, handles "not found", computes shared values, delegates rendering |
| `restwell_crm_render_enquiry_main( $row, $promote_url )` | Left column: contact, guest guide, booking, stay dates, requirements, message |
| `restwell_crm_render_enquiry_sidebar( $row, $notes, $statuses, $follow_up_value, $mailto, $promote_url )` | Right column: status form, staff notes, activity log, quick actions |

No behaviour, markup, or query logic changed — this was a pure extraction
(move code into a named function, pass the few locals it needs as
parameters). No new template files or state were introduced.

### Verification

- `php -l inc/crm/enquiries.php` — no syntax errors.
- `composer phpcs -- restwell-theme/inc/crm/enquiries.php --sniffs=WordPress.Security.EscapeOutput,WordPress.DB.PreparedSQL` — 0 violations (matches the [PHPCS security baseline](PHPCS-BASELINE-2026-08-21.md)).
- Live browser check against the Playground instance (`/wp-admin/admin.php?page=restwell-enquiries`):
  - List page: filter pills, counts, search box and table render identically to before the refactor.
  - Detail page (`&view=1`): all sections render; changed **Status** from *New* → *Contacted*, saved, confirmed the heading, dashboard badge and activity log ("Contacted: 24 Aug 2026, 15:12") all updated correctly; then reset back to *New* the same way to leave the test data as found.

## 2. `assets/js/main.js` — left as one file (justified)

### What it actually looks like

At 2,246 lines this is a large *file*, but it is not a god function: it's a
single IIFE containing ~40 small, independently-named `initXxx()` functions
(`initStickyHeaderShadow`, `initMobileMenu`, `initExploreFilter`,
`initFaqTabs`, `initMultiStepForm`, `initEnquiryDraftPersistence`,
`initScrollToTop`, `initRestwellGalleryCarousel`, …), each scoped to one
concern, plus a single bootstrap block at the bottom (`assets/js/main.js`, end of file):

```javascript
ready(function () {
	function safeInit(name, fn) {
		try {
			fn();
		} catch (err) {
			if (typeof console !== 'undefined' && console.error) {
				console.error('Restwell init failed: ' + name, err);
			}
		}
	}
	safeInit('initRestwellGalleryCarousel', initRestwellGalleryCarousel);
	// … ~14 more safeInit() calls, ordered with comments explaining dependencies …
	runWhenIdle(function () {
		// non-critical analytics/reveal-animation inits, deferred off the paint path
	});
});
```

Each `initXxx()` is independently wrapped in `safeInit()`, so a bug in one
feature (e.g. the gallery carousel) can't take down another (e.g. the
enquiry form) — that isolation is the main practical benefit a god-function
split would give you, and it's already there.

### Why it wasn't split into multiple files

1. **No build tooling, by design.** The `.cursorrules` for this theme
   explicitly forbid npm dependencies. `main.min.js` is hand-regenerated with
   a one-off `npx terser` pass (not a tracked build step) — see the enquiry
   form fix in [QA-ENQUIRY-FORM-E2E-2026-08-24.md](QA-ENQUIRY-FORM-E2E-2026-08-24.md).
   Splitting into e.g. `nav.js`, `forms.js`, `analytics.js` would mean either:
   - adding a bundler (against the no-build-tooling rule), or
   - hand-maintaining N separate minified files and N `wp_enqueue_script()`
     registrations with correct `deps` ordering — which is *more* fragile
     than the current single manually-minified file, not less.
2. **The actual fragility this workstream already found** was in stale
   selectors and mismatched logic *inside* individual `initXxx()` functions
   (see Errors 16–17 in the enquiry-form QA doc), not in the file being one
   file. Splitting the file wouldn't have caught or prevented those bugs;
   reading each function carefully did.
3. **Risk vs. benefit.** Moving ~2,200 lines across new files by hand, then
   re-minifying each and rewiring enqueue order, carries real regression
   risk (this file drives navigation, the multi-step enquiry form, and
   analytics — all business-critical) for no functional improvement, since
   the file already has clean internal separation and per-feature error
   isolation.

**Decision: leave `main.js` as a single file.** If the project later adopts
a JS bundler (e.g. esbuild) as a deliberate, separate decision, splitting
into per-concern modules at that point would be low-risk and worthwhile.
