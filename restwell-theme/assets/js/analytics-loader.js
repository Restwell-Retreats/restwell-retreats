/**
 * Deferred / consent-gated loading for GA4 and Metricool (front-end only).
 *
 * Theme first-party cookie `restwell_cookie_consent` = JSON `{ "v": 1, "analytics": true|false }`
 * is the only consent source when loadMode is consent_gated.
 *
 * @package Restwell_Retreats
 */
(function () {
	'use strict';

	var cfg = typeof restwellAnalytics !== 'undefined' ? restwellAnalytics : {};
	var granted = false;
	var gaLoaded = false;
	var metricoolLoaded = false;

	/**
	 * @return {boolean|null} true/false when set, null when absent or unreadable.
	 */
	function restwellFirstPartyAnalyticsConsent() {
		try {
			if (!document.cookie) {
				return null;
			}
			var prefix = 'restwell_cookie_consent=';
			var parts = document.cookie.split(';');
			var i;
			var p;
			var raw;
			var data;
			for (i = 0; i < parts.length; i++) {
				p = parts[i].trim();
				if (p.indexOf(prefix) !== 0) {
					continue;
				}
				raw = p.substring(prefix.length);
				data = JSON.parse(decodeURIComponent(raw));
				if (typeof data.analytics === 'boolean') {
					return data.analytics;
				}
				return null;
			}
		} catch (e) {}
		return null;
	}

	function ensureGtag() {
		window.dataLayer = window.dataLayer || [];
		window.gtag =
			window.gtag ||
			function () {
				window.dataLayer.push(arguments);
			};
	}

	window.restwellGrantAnalyticsConsent = function () {
		if (granted) {
			return;
		}
		granted = true;
		ensureGtag();

		if (cfg.gaId) {
			loadGa(cfg.gaId, !!cfg.consentGated);
		}
		if (cfg.metricoolHash) {
			loadMetricool(cfg.metricoolHash);
		}
	};

	window.restwellRevokeAnalyticsConsent = function () {
		granted = false;
		ensureGtag();
		window.gtag('consent', 'update', {
			analytics_storage: 'denied',
			ad_storage: 'denied',
			ad_user_data: 'denied',
			ad_personalization: 'denied'
		});
	};

	function loadGa(mid, useConsentUpdate) {
		if (gaLoaded) {
			if (useConsentUpdate) {
				window.gtag('consent', 'update', {
					analytics_storage: 'granted'
				});
			}
			return;
		}
		gaLoaded = true;
		var s = document.createElement('script');
		s.async = true;
		s.src =
			'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(mid);
		s.onload = function () {
			window.gtag('js', new Date());
			if (useConsentUpdate) {
				window.gtag('consent', 'update', {
					analytics_storage: 'granted'
				});
			}
			window.gtag('config', mid);
		};
		document.head.appendChild(s);
	}

	function loadMetricool(hash) {
		if (metricoolLoaded) {
			return;
		}
		metricoolLoaded = true;
		function inject() {
			if (typeof window.beTracker !== 'undefined' && window.beTracker.t) {
				window.beTracker.t({ hash: hash });
				return;
			}
			var b = document.getElementsByTagName('head')[0];
			var c = document.createElement('script');
			c.async = true;
			c.src = 'https://tracker.metricool.com/resources/be.js';
			c.onload = function () {
				if (typeof window.beTracker !== 'undefined' && window.beTracker.t) {
					window.beTracker.t({ hash: hash });
				}
			};
			b.appendChild(c);
		}
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', inject);
		} else {
			inject();
		}
	}

	var mode = cfg.loadMode || '';

	if (mode === 'footer_deferred') {
		window.restwellGrantAnalyticsConsent();
		return;
	}

	if (mode === 'consent_gated') {
		document.addEventListener('restwell-analytics-allow', function () {
			window.restwellGrantAnalyticsConsent();
		});
		document.addEventListener('restwell-analytics-deny', function () {
			window.restwellRevokeAnalyticsConsent();
		});

		if (restwellFirstPartyAnalyticsConsent() === true) {
			window.restwellGrantAnalyticsConsent();
		}
	}
})();
