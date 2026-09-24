/**
 * Deferred / consent-gated loading for GA4, Metricool, and TikTok Pixel (front-end only).
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
	var tiktokLoaded = false;

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
		if (cfg.tiktokPixelId) {
			loadTiktok(cfg.tiktokPixelId);
		}
		flushTikTokQueue();
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

	var pendingTikTokEvents = window.restwellTikTokPendingEvents;
	if (!Array.isArray(pendingTikTokEvents)) {
		pendingTikTokEvents = [];
		window.restwellTikTokPendingEvents = pendingTikTokEvents;
	}

	var allowedTikTokEvents = {
		ViewContent: true,
		Lead: true
	};

	function tiktokEventId(prefix) {
		return prefix + '_' + Date.now() + '_' + Math.random().toString(16).slice(2, 10);
	}

	function sendTikTokEvent(eventName, params, options) {
		if (!granted || !cfg.tiktokPixelId || !allowedTikTokEvents[eventName]) {
			return false;
		}
		if (!window.ttq || typeof window.ttq.track !== 'function') {
			return false;
		}
		if (options) {
			window.ttq.track(eventName, params || {}, options);
		} else {
			window.ttq.track(eventName, params || {});
		}
		return true;
	}

	function flushTikTokQueue() {
		if (!pendingTikTokEvents.length) {
			return;
		}
		var queued = pendingTikTokEvents.slice();
		pendingTikTokEvents.length = 0;
		var i;
		for (i = 0; i < queued.length; i++) {
			if (!sendTikTokEvent(queued[i][0], queued[i][1], queued[i][2])) {
				pendingTikTokEvents.push(queued[i]);
			}
		}
	}

	window.restwellTikTokTrack = function (eventName, params, options) {
		if (sendTikTokEvent(eventName, params, options)) {
			return;
		}
		if (!allowedTikTokEvents[eventName]) {
			return;
		}
		pendingTikTokEvents.push([eventName, params || {}, options || null]);
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

	function loadTiktok(pixelId) {
		if (tiktokLoaded) {
			return;
		}
		tiktokLoaded = true;

		var methods = [
			'page', 'track', 'identify', 'instances', 'debug', 'on', 'off', 'once',
			'ready', 'alias', 'group', 'enableCookie', 'disableCookie', 'holdConsent',
			'revokeConsent', 'grantConsent'
		];
		var ttq = window.ttq = window.ttq || [];
		window.TiktokAnalyticsObject = 'ttq';
		ttq.methods = ttq.methods || methods;
		ttq.setAndDefer = ttq.setAndDefer || function (queue, method) {
			queue[method] = function () {
				queue.push([method].concat(Array.prototype.slice.call(arguments, 0)));
			};
		};
		for (var i = 0; i < ttq.methods.length; i++) {
			ttq.setAndDefer(ttq, ttq.methods[i]);
		}
		ttq.instance = ttq.instance || function (instanceId) {
			var instance = ttq._i[instanceId] || [];
			for (var j = 0; j < ttq.methods.length; j++) {
				ttq.setAndDefer(instance, ttq.methods[j]);
			}
			return instance;
		};
		ttq.load = ttq.load || function (id, options) {
			var src = 'https://analytics.tiktok.com/i18n/pixel/events.js';
			var script = document.createElement('script');
			ttq._i = ttq._i || {};
			ttq._i[id] = [];
			ttq._i[id]._u = src;
			ttq._t = ttq._t || {};
			ttq._t[id] = +new Date();
			ttq._o = ttq._o || {};
			ttq._o[id] = options || {};
			script.type = 'text/javascript';
			script.async = true;
			script.src = src + '?sdkid=' + encodeURIComponent(id) + '&lib=ttq';
			var firstScript = document.getElementsByTagName('script')[0];
			firstScript.parentNode.insertBefore(script, firstScript);
		};
		ttq.load(pixelId);
		// Do not call identify(); enquiry forms can include health notes.
		ttq.page();
		sendTikTokEvent('ViewContent', {
			contents: [
				{
					content_type: 'product'
				}
			]
		}, {
			event_id: tiktokEventId('view')
		});
		flushTikTokQueue();
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
