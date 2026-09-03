/**
 * Restwell Retreats — enquire form (vanilla JS, no bundler).
 */
(function () {
	'use strict';

	function ready(fn) {
		if (document.readyState !== 'loading') {
			fn();
		} else {
			document.addEventListener('DOMContentLoaded', fn);
		}
	}

	function safeInit(name, fn) {
		try {
			fn();
		} catch (err) {
			if (typeof console !== 'undefined' && console.error) {
				console.error('Restwell init failed: ' + name, err);
			}
		}
	}

	/**
	 * Anti-bot timing token: set when the form is first rendered (no-JS users leave empty; server allows).
	 */
	function initRestwellFormOpenedAt() {
		document.querySelectorAll('[data-restwell-form-opened]').forEach(function (input) {
			if (!input || !input.name) return;
			input.value = String(Math.floor(Date.now() / 1000));
		});
	}
	/**
	 * Date min constraints for the enquire form.
	 *
	 * Live step navigation lives in shared.js. This only keeps From/To from
	 * landing in the past. Selector matches the live markup: [data-multistep]
	 * is on the wrapper, [data-multistep-form] is on the <form>.
	 */
	function initEnquiryDateConstraints() {
		var form = document.querySelector('[data-multistep] .restwell-enq-form[data-multistep-form]')
			|| document.querySelector('.restwell-enq-form');
		if (!form) return;

		function todayYmd() {
			var d = new Date();
			var y = d.getFullYear();
			var m = String(d.getMonth() + 1);
			var day = String(d.getDate());
			if (m.length === 1) m = '0' + m;
			if (day.length === 1) day = '0' + day;
			return y + '-' + m + '-' + day;
		}

	var dateFrom = form.querySelector('#enq-from') || form.querySelector('[name="enq_date_from"]');
	var dateTo = form.querySelector('#enq-to') || form.querySelector('[name="enq_date_to"]');
		var todayStr = todayYmd();
		function syncDateConstraints() {
			if (!dateFrom || !dateTo) return;
			if (!dateFrom.getAttribute('min')) {
				dateFrom.setAttribute('min', todayStr);
			}
			if (!dateTo.getAttribute('min')) {
				dateTo.setAttribute('min', todayStr);
			}
			var fromVal = dateFrom.value;
			var floor = fromVal && fromVal >= todayStr ? fromVal : todayStr;
			dateTo.setAttribute('min', floor);
		}
		if (dateFrom && dateTo) {
			syncDateConstraints();
			dateFrom.addEventListener('change', syncDateConstraints);
		}
	}

	/**
	 * Enquiry form draft persistence.
	 *
	 * Why: a 3-step form on a phone is a real abandonment risk. If the user
	 * answers a call mid-step and the tab gets evicted, or they navigate away
	 * to check a date, losing every keystroke is the kind of friction that
	 * turns a warm enquiry into a never-returns. localStorage gives us a
	 * cheap, server-free safety net.
	 *
	 * Behaviour:
	 *   - Persist non-sensitive form fields to localStorage on input/change
	 *     (debounced).
	 *   - On a fresh load, restore the draft silently so a dropped connection
	 *     or evicted tab does not wipe the form. Do not announce the restore.
	 *   - Server-flashed values (post-validation re-render) always win — we
	 *     never let stale localStorage clobber what the server just sent back.
	 *   - Clear on submit so a successful send wipes the draft.
	 *   - Warn via beforeunload if the form has user input and they navigate
	 *     away without submitting (browsers ignore custom messages now;
	 *     setting returnValue is enough to trigger the standard prompt).
	 *   - Honeypot, nonce, timing token, and action marker are *intentionally*
	 *     excluded — they must never round-trip through localStorage.
	 */
	function initEnquiryDraftPersistence() {
		// The multistep wrapper carries [data-multistep]; the <form> inside it
		// carries [data-multistep-form] (see shared.js, which owns step
		// navigation for this form). These are two different attributes on two
		// different elements — matching both on the form itself never finds it.
		var form = document.querySelector('[data-multistep] .restwell-enq-form[data-multistep-form]');
		if (!form) return;

		// Versioned key so we can change the stored shape later without exhuming
		// bad drafts from returning visitors.
		var KEY = 'restwell_enquiry_draft_v1';
		// Drop drafts older than a week — by then the user has clearly moved on.
		var MAX_AGE_MS = 7 * 24 * 60 * 60 * 1000;
		// Long enough to coalesce burst typing into one write; short enough that
		// closing the tab right after typing still captures the latest state.
		var SAVE_DEBOUNCE_MS = 400;

		var PERSIST_FIELDS = [
			'enq_name', 'enq_email', 'enq_phone',
			'enq_contact_preference', 'enq_preferred_time',
			'enq_date_from', 'enq_date_to',
			'enq_guests', 'enq_funding', 'enq_urgent',
			'enq_care', 'enq_accessibility', 'enq_message',
			'enq_marketing_optin'
		];

		// Probe localStorage with a write/remove. Safari's "Block all cookies"
		// or quota-exhausted contexts throw, in which case we silently no-op
		// and the form keeps working without persistence.
		function safeStorage() {
			try {
				var k = '__rw_test__';
				window.localStorage.setItem(k, k);
				window.localStorage.removeItem(k);
				return window.localStorage;
			} catch (e) {
				return null;
			}
		}
		var storage = safeStorage();
		if (!storage) return;

		function getField(name) {
			return form.querySelector('[name="' + name + '"]');
		}

		function readField(field) {
			if (!field) return '';
			if (field.type === 'checkbox') return field.checked ? '1' : '';
			return field.value == null ? '' : String(field.value);
		}

		function writeField(field, val) {
			if (!field) return;
			if (field.type === 'checkbox') {
				field.checked = val === '1' || val === true;
				return;
			}
			field.value = val == null ? '' : String(val);
		}

		// Fields that render empty in the plain PHP template and only gain a
		// value via $enq_val() echoing back a failed submission. enq_guests,
		// enq_funding, and enq_contact_preference are deliberately excluded:
		// they always render with a non-empty default (2 / self / email) even
		// on a first-ever visit, so including them made this check always
		// true and permanently disabled draft restoration.
		var SERVER_PREFILL_SIGNAL_FIELDS = [
			'enq_name', 'enq_email', 'enq_phone', 'enq_preferred_time',
			'enq_date_from', 'enq_date_to', 'enq_urgent',
			'enq_care', 'enq_accessibility', 'enq_message', 'enq_marketing_optin'
		];

		// True if the page rendered with values already filled in by the server.
		// That happens after a validation failure: the server re-renders the
		// form with the user's submitted values via $enq_f. Their just-typed
		// state is fresher than anything in localStorage, so we leave it alone.
		function isServerPrefilled() {
			for (var i = 0; i < SERVER_PREFILL_SIGNAL_FIELDS.length; i++) {
				var f = getField(SERVER_PREFILL_SIGNAL_FIELDS[i]);
				if (!f) continue;
				if (f.type === 'checkbox') {
					if (f.checked) return true;
				} else if (readField(f) !== '') {
					return true;
				}
			}
			return false;
		}

		function loadDraft() {
			try {
				var raw = storage.getItem(KEY);
				if (!raw) return null;
				var data = JSON.parse(raw);
				if (!data || !data.savedAt || !data.fields) return null;
				if ((Date.now() - data.savedAt) > MAX_AGE_MS) {
					storage.removeItem(KEY);
					return null;
				}
				return data;
			} catch (e) {
				return null;
			}
		}

		function persistDraft() {
			var fields = {};
			var anyValue = false;
			PERSIST_FIELDS.forEach(function (name) {
				var f = getField(name);
				var v = readField(f);
				if (v) anyValue = true;
				fields[name] = v;
			});
			if (!anyValue) {
				// Empty form means there's nothing worth restoring later.
				try { storage.removeItem(KEY); } catch (e) {}
				hasUnsavedInput = false;
				return;
			}
			try {
				storage.setItem(KEY, JSON.stringify({
					v: 1,
					savedAt: Date.now(),
					fields: fields
				}));
				hasUnsavedInput = true;
			} catch (e) {
				// QuotaExceededError or storage disabled mid-session — there's
				// nothing useful we can do here, and the form still submits.
			}
		}

		function clearDraft() {
			try { storage.removeItem(KEY); } catch (e) {}
			hasUnsavedInput = false;
		}

		function applyDraft(draft) {
			PERSIST_FIELDS.forEach(function (name) {
				if (Object.prototype.hasOwnProperty.call(draft.fields, name)) {
					writeField(getField(name), draft.fields[name]);
				}
			});
			// Re-run the date-range floor calc now that values are populated;
			// the multi-step controller wires this up but only on a real change
			// event, not on programmatic value writes.
			if (dateFromAfterRestore && dateToAfterRestore) {
				try {
					dateFromAfterRestore.dispatchEvent(new Event('change', { bubbles: true }));
				} catch (e) { /* old IE shims not relevant here */ }
			}
		}

		function parseYmd(value) {
			return /^\d{4}-\d{2}-\d{2}$/.test(value) ? value : '';
		}

		function readUrlStayDates() {
			try {
				var params = new URLSearchParams(window.location.search);
				var from = parseYmd(params.get('enq_date_from') || '');
				var to = parseYmd(params.get('enq_date_to') || '');
				if (!from && !to) return null;
				return { from: from, to: to };
			} catch (e) {
				return null;
			}
		}

		// Capture date inputs once so applyDraft() can re-fire the change event.
		var dateFromAfterRestore = form.querySelector('#enq-from') || form.querySelector('[name="enq_date_from"]');
		var dateToAfterRestore   = form.querySelector('#enq-to') || form.querySelector('[name="enq_date_to"]');

		var hasUnsavedInput = false;
		var urlDates = readUrlStayDates();
		var flashOnly = isServerPrefilled() && !urlDates;

		if (flashOnly) {
			// Server flash carried the user's submitted values. Treat that as
			// "unsaved" so beforeunload still warns them off accidental nav.
			hasUnsavedInput = true;
		} else {
			var draft = loadDraft();
			if (draft) {
				applyDraft(draft);
				hasUnsavedInput = true;
			}
			if (urlDates) {
				if (urlDates.from && dateFromAfterRestore) {
					dateFromAfterRestore.value = urlDates.from;
				}
				if (urlDates.to && dateToAfterRestore) {
					dateToAfterRestore.value = urlDates.to;
				}
				hasUnsavedInput = true;
				if (dateFromAfterRestore) {
					try {
						dateFromAfterRestore.dispatchEvent(new Event('change', { bubbles: true }));
					} catch (e) { /* ignore */ }
				}
				persistDraft();
			}
		}

		// Save on input and change. Debounced to avoid storage churn on long
		// messages — we hit storage once after the user pauses, not 200 times
		// while they type.
		var saveTimer = null;
		function scheduleSave() {
			if (saveTimer) window.clearTimeout(saveTimer);
			saveTimer = window.setTimeout(persistDraft, SAVE_DEBOUNCE_MS);
		}
		form.addEventListener('input',  scheduleSave, { passive: true });
		form.addEventListener('change', scheduleSave, { passive: true });

		// Clear on submit. The next page load is the success view, which has
		// no form to restore into.
		form.addEventListener('submit', function () {
			clearDraft();
		});

		// beforeunload warning. Modern browsers ignore custom messages and show
		// a generic "Leave site?" prompt; setting returnValue is the standards
		// pattern that triggers it. Bail out if the form is empty so we don't
		// nag people who just glanced at the page.
		window.addEventListener('beforeunload', function (e) {
			if (!hasUnsavedInput) return;
			e.preventDefault();
			// returnValue is the documented contract for this prompt.
			e.returnValue = '';
		});
	}
	/**
	 * After enquiry form redirect (?sent=1), scroll to the thank-you card.
	 * Fragments on redirect URLs are unreliable across browsers; this runs client-side.
	 */
	function initEnquirySuccessScroll() {
		var params = new URLSearchParams(window.location.search);
		if (params.get('sent') !== '1') {
			return;
		}
		// Primary conversion: successful enquiry (GA4; requires measurement ID in theme SEO settings).
		if (typeof window.gtag === 'function') {
			var refPath = '';
			try {
				refPath = document.referrer ? new URL(document.referrer).pathname : '';
			} catch (err) {
				refPath = '';
			}
			window.gtag('event', 'enquiry_form_submitted', {
				source_page: refPath || '(direct)',
				user_type: 'guest',
				page_path: window.location.pathname,
			});
		}
		var el = document.getElementById('enquiry-result');
		if (!el) {
			return;
		}
		function scrollToResult() {
			el.scrollIntoView({ behavior: 'smooth', block: 'start' });
			try {
				el.focus({ preventScroll: true });
			} catch (err) {
				/* IE / older */
			}
		}
		/* Double rAF: layout + fonts settled before scroll */
		if (window.requestAnimationFrame) {
			requestAnimationFrame(function () {
				requestAnimationFrame(scrollToResult);
			});
		} else {
			window.setTimeout(scrollToResult, 0);
		}
	}

	ready(function () {
		safeInit('initRestwellFormOpenedAt', initRestwellFormOpenedAt);
		safeInit('initEnquiryDateConstraints', initEnquiryDateConstraints);
		safeInit('initEnquiryDraftPersistence', initEnquiryDraftPersistence);
		safeInit('initEnquirySuccessScroll', initEnquirySuccessScroll);
	});
})();
