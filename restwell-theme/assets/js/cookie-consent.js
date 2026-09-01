/**
 * First-party cookie consent banner (consent_gated analytics).
 *
 * Event delegation so the script can load before the banner HTML (wp_footer
 * historically sat inside <footer>, above the banner).
 *
 * @package Restwell_Retreats
 */
(function () {
	'use strict';

	var COOKIE_NAME = 'restwell_cookie_consent';
	var COOKIE_MAX_AGE = 15552000; // 180 days.
	var COOKIE_VERSION = 1;

	function readConsent() {
		try {
			var prefix = COOKIE_NAME + '=';
			var parts = document.cookie ? document.cookie.split(';') : [];
			var i;
			var p;
			var raw;
			var data;
			for (i = 0; i < parts.length; i++) {
				p = parts[i].trim();
				if (p.indexOf(prefix) !== 0) {
					continue;
				}
				raw = decodeURIComponent(p.substring(prefix.length));
				data = JSON.parse(raw);
				if (typeof data.analytics === 'boolean') {
					return data;
				}
				return null;
			}
		} catch (e) {}
		return null;
	}

	function writeConsent(analytics) {
		var payload = encodeURIComponent(
			JSON.stringify({
				v: COOKIE_VERSION,
				analytics: !!analytics
			})
		);
		var secure = location.protocol === 'https:' ? '; Secure' : '';
		document.cookie =
			COOKIE_NAME +
			'=' +
			payload +
			'; Max-Age=' +
			COOKIE_MAX_AGE +
			'; Path=/; SameSite=Lax' +
			secure;
	}

	function getBanner() {
		return document.querySelector('[data-cookie-banner]');
	}

	function hideBanner() {
		var banner = getBanner();
		if (banner) {
			banner.hidden = true;
		}
	}

	function showBanner() {
		var banner = getBanner();
		if (banner) {
			banner.hidden = false;
		}
	}

	function focusSettings() {
		var settings = document.querySelector('[data-cookie-settings]');
		if (settings && typeof settings.focus === 'function') {
			settings.focus();
		}
	}

	function focusAccept() {
		var accept = document.querySelector('[data-cookie-accept]');
		if (accept && typeof accept.focus === 'function') {
			accept.focus();
		}
	}

	document.addEventListener('click', function (event) {
		var t = event.target;
		if (!t || !t.closest) {
			return;
		}
		if (t.closest('[data-cookie-accept]')) {
			writeConsent(true);
			hideBanner();
			document.dispatchEvent(new Event('restwell-analytics-allow'));
			focusSettings();
			return;
		}
		if (t.closest('[data-cookie-reject]')) {
			writeConsent(false);
			hideBanner();
			focusSettings();
			return;
		}
		if (t.closest('[data-cookie-settings]')) {
			showBanner();
			focusAccept();
		}
	});

	function hideIfChosen() {
		if (readConsent()) {
			hideBanner();
		}
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', hideIfChosen);
	} else {
		hideIfChosen();
	}
})();
