/**
 * Deferred / consent-gated loading for GA4 and Metricool (front-end only).
 *
 * @package Restwell_Retreats
 */
(function () {
	'use strict';

	var cfg = typeof restwellAnalytics !== 'undefined' ? restwellAnalytics : {};
	var granted = false;

	/**
	 * CookieAdmin (cookieadmin.net), free tier: consent is stored in cookie `cookieadmin_consent`
	 * as JSON — e.g. accept all `{ "accept": "true" }`, or per-category `{ "analytics": "true" }`.
	 * Pro is not required; GCM defaults/update for GA4 come from the theme (PHP loader + this script).
	 * The plugin does not dispatch an “after consent” event; we read the cookie (see plugin consent.js).
	 *
	 * @return {boolean} Whether analytical / analytics cookies are allowed.
	 */
	function restwellCookieadminConsentAllowsAnalytics() {
		try {
			if (!document.cookie) {
				return false;
			}
			var prefix = 'cookieadmin_consent=';
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
				if (data.accept === 'true') {
					return true;
				}
				if (data.reject === 'true') {
					return false;
				}
				if (data.analytics === 'true') {
					return true;
				}
				return false;
			}
		} catch (e) {}
		return false;
	}

	window.restwellGrantAnalyticsConsent = function () {
		if (granted) {
			return;
		}
		granted = true;

		window.dataLayer = window.dataLayer || [];
		window.gtag =
			window.gtag ||
			function () {
				window.dataLayer.push(arguments);
			};

		if (cfg.gaId) {
			loadGa(cfg.gaId, !!cfg.consentGated);
		}
		if (cfg.metricoolHash) {
			loadMetricool(cfg.metricoolHash);
		}
	};

	function loadGa(mid, useConsentUpdate) {
		var s = document.createElement('script');
		s.async = true;
		s.src =
			'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(mid);
		s.onload = function () {
			window.gtag('js', new Date());
			if (useConsentUpdate) {
				window.gtag('consent', 'update', {
					analytics_storage: 'granted',
				});
			}
			window.gtag('config', mid);
		};
		document.head.appendChild(s);
	}

	function loadMetricool(hash) {
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
		function restwellTryCookieadminConsent() {
			if (restwellCookieadminConsentAllowsAnalytics()) {
				window.restwellGrantAnalyticsConsent();
				return true;
			}
			return false;
		}

		// CookieAdmin: returning visitors + accept without full page reload (poll; cheap stop once granted).
		restwellTryCookieadminConsent();
		var cookieadminPolls = 0;
		var cookieadminPollMax = 150;
		var cookieadminIv = setInterval(function () {
			cookieadminPolls++;
			if (granted || restwellTryCookieadminConsent() || cookieadminPolls >= cookieadminPollMax) {
				clearInterval(cookieadminIv);
			}
		}, 400);

		document.addEventListener('restwell-analytics-allow', function () {
			window.restwellGrantAnalyticsConsent();
		});

		window.addEventListener('CookiebotOnAccept', function () {
			try {
				if (
					window.Cookiebot &&
					window.Cookiebot.consent &&
					window.Cookiebot.consent.statistics
				) {
					window.restwellGrantAnalyticsConsent();
				}
			} catch (e) {}
		});

		document.addEventListener('cookieyes_consent_update', function (ev) {
			try {
				var raw = ev.detail;
				var data =
					typeof raw === 'object' && raw !== null
						? raw
						: JSON.parse(raw || '{}');
				if (
					data.accepted &&
					data.accepted.indexOf &&
					data.accepted.indexOf('analytics') !== -1
				) {
					window.restwellGrantAnalyticsConsent();
					return;
				}
				if (data.categories && data.categories.analytics === true) {
					window.restwellGrantAnalyticsConsent();
				}
			} catch (e) {}
		});

		document.addEventListener('cmplz_fire_categories', function () {
			try {
				if (document.cookie.indexOf('cmplz_statistics=allow') !== -1) {
					window.restwellGrantAnalyticsConsent();
				}
			} catch (e) {}
		});

		return;
	}
})();
