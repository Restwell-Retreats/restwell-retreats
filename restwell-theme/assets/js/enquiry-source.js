/**
 * Enquiry source: where did this visit come from?
 *
 * Loaded on every page. On arrival it reads the UTM tags, whether an fbclid or
 * gclid was present (yes/no only), the landing path and the referrer's domain,
 * then copies them into the hidden enq_src_* fields on either enquiry form
 * (template-parts/enquire-source-fields.php).
 *
 * Storage and consent (UK PECR covers sessionStorage as well as cookies):
 *   - The visit is only kept in sessionStorage after the visitor accepts
 *     analytics on the cookie banner, so it can survive moving from /pricing/
 *     to /enquire/. sessionStorage ends when the tab closes; nothing persists.
 *   - Without consent nothing is stored. A form sent from the page they
 *     arrived on still gets that page's address and referrer, which needs no
 *     storage. After moving to another page the enquiry shows as "Unknown".
 *   - Rejecting analytics later clears anything stored.
 *
 * Every value is untrusted on the server (inc/crm/enquiry-source.php), which
 * also builds the readable Source label.
 */
(function () {
	'use strict';

	var STORE_KEY = 'restwell_enquiry_source_v1';
	var CONSENT_COOKIE = 'restwell_cookie_consent';
	var UTM_KEYS = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term'];
	var MAX_LEN = 300;

	// enqueue.php adds data-consent-gated="0" only when the site is set to load
	// analytics without a banner. Anything else (including a missing attribute)
	// is treated as gated, so the safe default is "ask first".
	var script = document.currentScript;
	var gated = !(script && script.getAttribute('data-consent-gated') === '0');

	function hostOf(url) {
		try {
			return new URL(url).hostname.toLowerCase().replace(/^www\./, '');
		} catch (e) {
			return '';
		}
	}

	var ownHost = window.location.hostname.toLowerCase().replace(/^www\./, '');

	function analyticsAllowed() {
		if (!gated) {
			return true;
		}
		try {
			var prefix = CONSENT_COOKIE + '=';
			var parts = document.cookie ? document.cookie.split(';') : [];
			for (var i = 0; i < parts.length; i++) {
				var p = parts[i].trim();
				if (p.indexOf(prefix) === 0) {
					var data = JSON.parse(decodeURIComponent(p.substring(prefix.length)));
					return !!(data && data.analytics === true);
				}
			}
		} catch (e) {}
		return false;
	}

	function session() {
		try {
			var k = '__rw_src_test__';
			window.sessionStorage.setItem(k, k);
			window.sessionStorage.removeItem(k);
			return window.sessionStorage;
		} catch (e) {
			return null;
		}
	}

	function readStored() {
		var s = session();
		if (!s) {
			return null;
		}
		try {
			var data = JSON.parse(s.getItem(STORE_KEY) || 'null');
			return data && data.v === '1' ? data : null;
		} catch (e) {
			return null;
		}
	}

	function store(record) {
		if (!record || !analyticsAllowed()) {
			return;
		}
		var s = session();
		if (s) {
			try {
				s.setItem(STORE_KEY, JSON.stringify(record));
			} catch (e) {}
		}
	}

	function clearStored() {
		var s = session();
		if (s) {
			try {
				s.removeItem(STORE_KEY);
			} catch (e) {}
		}
	}

	/**
	 * What this page view tells us. kind is "campaign" (tags, click IDs or an
	 * outside referrer), "direct" (no referrer at all) or "internal" (came from
	 * another page on this site, so it says nothing about the original source).
	 */
	function readThisPage() {
		var params = new URLSearchParams(window.location.search);
		var record = { v: '1' };
		var tagged = false;
		UTM_KEYS.forEach(function (key) {
			var value = (params.get(key) || '').slice(0, MAX_LEN);
			record[key] = value;
			if (value) {
				tagged = true;
			}
		});
		record.has_fbclid = params.has('fbclid') ? '1' : '0';
		record.has_gclid = params.has('gclid') ? '1' : '0';
		record.landing_path = window.location.pathname.slice(0, MAX_LEN);

		var refHost = document.referrer ? hostOf(document.referrer) : '';
		var internal = refHost !== '' && refHost === ownHost;
		record.referrer_domain = internal ? '' : refHost;

		var kind = 'direct';
		if (tagged || record.has_fbclid === '1' || record.has_gclid === '1' || record.referrer_domain) {
			kind = 'campaign';
		} else if (internal) {
			kind = 'internal';
		}
		return { kind: kind, record: record };
	}

	var page = readThisPage();
	var stored = readStored();
	var current = null;
	// Saved when the visitor accepts analytics on this page view.
	var toStore = null;

	if (page.kind === 'campaign') {
		// A new ad, link or search always becomes the source for this visit.
		current = page.record;
		toStore = page.record;
	} else if (page.kind === 'direct') {
		// Typing the address again mid-visit should not wipe out an ad click.
		current = stored || page.record;
		toStore = stored ? null : page.record;
	} else {
		// Moving between our own pages: only a stored arrival is known.
		current = stored;
	}
	store(toStore);

	function fillForms(record) {
		if (!record) {
			return;
		}
		var flags = document.querySelectorAll('input[data-enq-src="v"]');
		Array.prototype.forEach.call(flags, function (flag) {
			// A value already here came back from the server after a failed
			// submit: that is the original source, so leave the whole set alone.
			if (flag.value || !flag.form) {
				return;
			}
			var inputs = flag.form.querySelectorAll('input[data-enq-src]');
			Array.prototype.forEach.call(inputs, function (input) {
				var key = input.getAttribute('data-enq-src');
				if (Object.prototype.hasOwnProperty.call(record, key)) {
					input.value = String(record[key]);
				}
			});
		});
	}

	function init() {
		fillForms(current);
	}

	document.addEventListener('restwell-analytics-allow', function () {
		store(toStore);
	});
	document.addEventListener('restwell-analytics-deny', clearStored);

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
