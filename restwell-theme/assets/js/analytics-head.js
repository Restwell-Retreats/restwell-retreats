(function () {
	'use strict';

	var config = window.restwellAnalytics || {};
	var measurementId = config.gaId || '';
	var metricoolHash = config.metricoolHash || '';

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
}());
