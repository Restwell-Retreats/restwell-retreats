(function () {
	'use strict';

	var config = window.restwellAnalytics || {};
	var measurementId = config.gaId || '';
	var metricoolHash = config.metricoolHash || '';
	var tiktokPixelId = config.tiktokPixelId || '';

	function appendScript(src, onload) {
		var script = document.createElement('script');
		script.async = true;
		script.src = src;
		if (onload) {
			script.onload = onload;
		}
		document.head.appendChild(script);
	}

	if (measurementId) {
		window.dataLayer = window.dataLayer || [];
		window.gtag = window.gtag || function () {
			window.dataLayer.push(arguments);
		};
		window.gtag('js', new Date());
		window.gtag('config', measurementId);
		appendScript('https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(measurementId));
	}

	if (metricoolHash) {
		appendScript('https://tracker.metricool.com/resources/be.js', function () {
			if (window.beTracker && typeof window.beTracker.t === 'function') {
				window.beTracker.t({ hash: metricoolHash });
			}
		});
	}

	if (tiktokPixelId) {
		window.TiktokAnalyticsObject = 'ttq';
		window.ttq = window.ttq || [];
		window.ttq.load = window.ttq.load || function (pixelId) {
			var script = document.createElement('script');
			script.async = true;
			script.src = 'https://analytics.tiktok.com/i18n/pixel/events.js?sdkid=' + encodeURIComponent(pixelId) + '&lib=ttq';
			document.getElementsByTagName('script')[0].parentNode.insertBefore(script, document.getElementsByTagName('script')[0]);
		};
		window.ttq.page = window.ttq.page || function () {
			window.ttq.push(['page']);
		};
		window.ttq.load(tiktokPixelId);
		window.ttq.page();
	}
}());
