/**
 * Restwell Retreats — FAQ filters, explore pills, CTA analytics (vanilla JS).
 */
(function () {
	'use strict';

	document.documentElement.classList.remove('no-js');
	document.documentElement.classList.add('js');

	function ready(fn) {
		if (document.readyState !== 'loading') {
			fn();
		} else {
			document.addEventListener('DOMContentLoaded', fn);
		}
	}


	function initExploreFilter() {
		var container = document.querySelector('.explore-whitstable-filter');
		var list = document.getElementById('explore-whitstable-list');
		var status = document.getElementById('explore-filter-status');
		var emptyState = document.getElementById('explore-empty-state');
		if (!container || !list) return;

		var pills = container.querySelectorAll('.explore-filter-pill');
		var cards = list.querySelectorAll('.explore-card');

		function setActivePill(activePill) {
			pills.forEach(function (p) {
				p.setAttribute('aria-pressed', p === activePill ? 'true' : 'false');
			});
		}

		function filterCards(value) {
			var visible = 0;
			cards.forEach(function (card) {
				var filterAttr = card.getAttribute('data-filter') || '';
				var filters = filterAttr.trim().split(/\s+/);
				var show = value === 'all' || filters.indexOf(value) !== -1;
				card.style.display = show ? '' : 'none';
				if (show) visible++;
			});
			if (status) {
				var msg = '';
				if (value !== 'all') {
					if (visible === 0) {
						msg = 'No places match this filter. Try another or show all.';
					} else {
						msg =
							'Showing ' +
							visible +
							' ' +
							(visible === 1 ? 'place' : 'places') +
							'.';
					}
				}
				status.textContent = msg;
			}
			if (emptyState) {
				emptyState.style.display = visible === 0 ? 'block' : 'none';
				emptyState.setAttribute('aria-hidden', visible === 0 ? 'false' : 'true');
			}
			list.style.display = visible === 0 ? 'none' : '';
		}

		pills.forEach(function (pill) {
			pill.addEventListener('click', function () {
				var value = pill.getAttribute('data-filter') || 'all';
				setActivePill(pill);
				filterCards(value);
			});
		});

		var showAllBtn = document.querySelector('.explore-filter-show-all');
		if (showAllBtn && pills.length) {
			showAllBtn.addEventListener('click', function () {
				setActivePill(pills[0]);
				filterCards('all');
				pills[0].focus();
			});
		}
	}

	/**
	 * FAQ category filter tabs.
	 * Reads data-category on .faq-item <details> elements and toggles visibility
	 * based on the active .faq-filter-pill[data-filter] button.
	 */
	function initFaqTabs() {
		var filterGroup = document.querySelector('.faq-filter');
		if (!filterGroup) return;

		var pills  = filterGroup.querySelectorAll('.faq-filter-pill');
		var items  = document.querySelectorAll('.faq-list .faq-item[data-category]');
		var status = document.getElementById('faq-filter-status');
		var empty  = document.getElementById('faq-empty-state');

		if (!pills.length || !items.length) return;

		function setActivePill(activePill) {
			pills.forEach(function (p) {
				p.setAttribute('aria-pressed', p === activePill ? 'true' : 'false');
			});
		}

		function filterItems(category) {
			var visible = 0;
			items.forEach(function (item) {
				var cat = item.getAttribute('data-category') || 'about';
				var show = category === 'all' || cat === category;
				item.hidden = !show;
				if (show) visible++;
			});
			if (empty) {
				empty.hidden = visible > 0;
				empty.setAttribute('aria-hidden', visible > 0 ? 'true' : 'false');
			}
			if (status) {
				status.textContent = visible + ' question' + (visible === 1 ? '' : 's') + ' shown';
			}
		}

		pills.forEach(function (pill) {
			pill.addEventListener('click', function () {
				var value = pill.getAttribute('data-filter') || 'all';
				setActivePill(pill);
				filterItems(value);
			});
		});

		// Initialise: "all" active.
		setActivePill(pills[0]);
		filterItems('all');

		// Track FAQ expansions on FAQ template lists.
		if (typeof window.gtag === 'function') {
			items.forEach(function (item) {
				item.addEventListener('toggle', function () {
					if (!item.open) return;
					window.gtag('event', 'faq_expanded', {
						page_path: window.location.pathname,
						user_type: 'guest',
						faq_category: item.getAttribute('data-category') || 'unknown',
					});
				});
			});
		}
	}

	/**
	 * Keep aria-expanded in sync on FAQ <details> summaries for assistive tech.
	 */
	function initFaqToggleA11y() {
		var items = document.querySelectorAll('.faq-item');
		if (!items.length) {
			return;
		}
		items.forEach(function (item) {
			var summary = item.querySelector('summary');
			if (!summary) {
				return;
			}
			summary.setAttribute('aria-expanded', item.open ? 'true' : 'false');
			item.addEventListener('toggle', function () {
				summary.setAttribute('aria-expanded', item.open ? 'true' : 'false');
			});
		});
	}


	/**
	 * Shared phone validation (mirrors restwell_validate_submission_phone()).
	 */
	function isPlausiblePhone(value) {
		var v = String(value || '').trim();
		if (!v) {
			return false;
		}
		if (!/^[\d\s+\-().]+$/.test(v)) {
			return false;
		}
		return v.replace(/\D/g, '').length >= 7;
	}

	function restwellPhoneErrorMessage(value) {
		var v = String(value || '').trim();
		if (!v) {
			return 'Please add your phone number so we can call you back.';
		}
		if (!/^[\d\s+\-().]+$/.test(v)) {
			return 'Please enter a valid phone number (digits, spaces, +, -, and brackets only).';
		}
		return 'Please enter a valid phone number with at least seven digits.';
	}


	/**
	 * FAQ "Ask a question" form: inline validation on blur and submit.
	 */
	function initFaqQuestionFormValidation() {
		var form = document.querySelector('.restwell-faq-question-form');
		if (!form) return;

		function getFieldLabel(field) {
			var label = form.querySelector('label[for="' + field.id + '"]');
			if (label) {
				return (label.firstChild && label.firstChild.nodeValue)
					? label.firstChild.nodeValue.trim()
					: label.textContent.replace(/\s*\*\s*|\(optional\)/gi, '').trim();
			}
			return 'This field';
		}

		function clearFieldError(field) {
			var errorEl = field.id ? document.getElementById(field.id + '-error') : null;
			if (errorEl) {
				errorEl.textContent = '';
				errorEl.hidden = true;
			}
			field.removeAttribute('data-invalid');
			field.removeAttribute('aria-invalid');
			field.removeAttribute('aria-describedby');
			field.style.borderColor = '';
		}

		function showFieldError(field, message) {
			var errorId = field.id + '-error';
			var errorEl = document.getElementById(errorId);
			if (!errorEl) return;
			errorEl.textContent = message;
			errorEl.hidden = false;
			field.setAttribute('data-invalid', 'true');
			field.setAttribute('aria-invalid', 'true');
			field.setAttribute('aria-describedby', errorId);
			field.style.borderColor = '#b91c1c';
		}

		function validateField(field) {
			clearFieldError(field);
			var value = String(field.value || '').trim();

			if (field.required && !value) {
				showFieldError(field, getFieldLabel(field) + ' is required.');
				return false;
			}
			if (field.type === 'email' && value && !field.checkValidity()) {
				showFieldError(field, 'Please add a valid email address.');
				return false;
			}
			if (field.type === 'tel' && field.required) {
				if (!isPlausiblePhone(field.value)) {
					showFieldError(field, restwellPhoneErrorMessage(field.value));
					return false;
				}
			}
			return true;
		}

		form.querySelectorAll('[required]').forEach(function (field) {
			field.addEventListener('blur', function () {
				validateField(field);
			});
		});

		form.addEventListener('input', function (e) {
			var field = e.target;
			if (!field || !field.required) return;
			if (field.getAttribute('aria-invalid') === 'true') {
				validateField(field);
			}
		});

		form.addEventListener('submit', function (e) {
			var ok = true;
			var firstInvalid = null;
			form.querySelectorAll('[required]').forEach(function (field) {
				if (!validateField(field)) {
					ok = false;
					if (!firstInvalid) firstInvalid = field;
				}
			});
			if (!ok) {
				e.preventDefault();
				if (firstInvalid) firstInvalid.focus();
			}
		});
	}



	/**
	 * Scroll-depth tracking for content engagement.
	 * Fires once each at 25%, 50%, 75%, and 90%.
	 */
	function initScrollDepthTracking() {
		if (typeof window.gtag !== 'function') {
			return;
		}
		var fired = { 25: false, 50: false, 75: false, 90: false };
		function maxScrollTop() {
			var doc = document.documentElement;
			var body = document.body;
			var scrollHeight = Math.max(
				body ? body.scrollHeight : 0,
				doc ? doc.scrollHeight : 0,
				body ? body.offsetHeight : 0,
				doc ? doc.offsetHeight : 0
			);
			var inner = window.innerHeight || (doc ? doc.clientHeight : 0) || 0;
			return Math.max(1, scrollHeight - inner);
		}
		function checkDepth() {
			var top = window.pageYOffset || document.documentElement.scrollTop || 0;
			var pct = Math.round((top / maxScrollTop()) * 100);
			[25, 50, 75, 90].forEach(function (threshold) {
				if (!fired[threshold] && pct >= threshold) {
					fired[threshold] = true;
					window.gtag('event', 'scroll_depth', {
						page_path: window.location.pathname,
						user_type: 'guest',
						scroll_percent: threshold,
					});
				}
			});
		}
		window.addEventListener('scroll', checkDepth, { passive: true });
		checkDepth();
	}






	/**
	 * GA4: secondary page-view-style events (property, accessibility spec).
	 * Micro-conversions: tel / mailto (no PII in parameters).
	 */
	function initRestwellGa4SecondaryEvents() {
		if (typeof window.gtag !== 'function') {
			return;
		}
		var path = window.location.pathname || '';
		var pathNorm = path.replace(/\/+$/, '') || '/';
		if (pathNorm === '/the-property' || pathNorm.indexOf('/the-property/') === 0) {
			window.gtag('event', 'property_page_viewed', {
				user_type: 'guest',
				page_path: path,
			});
		}
		// Access statement only — not /accessibility-policy/.
		if (pathNorm === '/accessibility') {
			window.gtag('event', 'accessibility_spec_viewed', {
				user_type: 'guest',
				page_path: path,
			});
		}

		document.addEventListener(
			'click',
			function (e) {
				var a = e.target && e.target.closest ? e.target.closest('a[href]') : null;
				if (!a || typeof window.gtag !== 'function') {
					return;
				}
				var href = a.getAttribute('href') || '';
				if (/^tel:/i.test(href)) {
					window.gtag('event', 'phone_number_clicked', {
						user_type: 'guest',
						page_path: window.location.pathname,
						phone_number: href.replace(/^tel:/i, '').substring(0, 32),
					});
				} else if (/^mailto:/i.test(href)) {
					window.gtag('event', 'email_clicked', {
						user_type: 'guest',
						page_path: window.location.pathname,
						email_address: href.replace(/^mailto:/i, '').split('?')[0].substring(0, 120),
					});
				}
			},
			true
		);
	}

	/**
	 * GA4: log CTA clicks when gtag is present (measurement ID from theme SEO settings).
	 * Event name: restwell_cta_click. Parameter: cta_id (from data-cta).
	 */
	function initRestwellCtaAnalytics() {
		document.addEventListener(
			'click',
			function (e) {
				var el = e.target && e.target.closest ? e.target.closest('[data-cta]') : null;
				if (!el) {
					return;
				}
				var id = el.getAttribute('data-cta');
				if (!id || typeof window.gtag !== 'function') {
					return;
				}
				var ctaLabel = el.getAttribute('data-cta-label');
				if (!ctaLabel) {
					ctaLabel = (el.innerText || el.textContent || '').replace(/\s+/g, ' ').trim();
				}
				var location = el.getAttribute('data-cta-location') || '';
				if (!location) {
					var section = el.closest('section[id], [id]');
					location = section && section.id ? section.id : 'page';
				}
				var target = el.getAttribute('href') || el.getAttribute('data-cta-target') || '';
				var label = ctaLabel ? ctaLabel.substring(0, 120) : id;
				window.gtag('event', 'restwell_cta_click', {
					cta_id: id,
					cta_location: String(location).substring(0, 80),
					cta_label: label,
					cta_text: label,
					target_url: String(target).substring(0, 200),
					page_path: window.location.pathname,
					user_type: 'guest',
				});
			},
			true
		);
	}

	function initRevealAnimations() {
		var els = document.querySelectorAll('.rw-reveal');
		if (!els.length) {
			return;
		}
		if (!window.IntersectionObserver) {
			els.forEach(function (el) {
				el.classList.add('rw-reveal--visible');
			});
			return;
		}
		if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
			els.forEach(function (el) {
				el.classList.add('rw-reveal--visible');
			});
			return;
		}
		var io = new IntersectionObserver(
			function (entries, observer) {
				entries.forEach(function (entry) {
					if (entry.isIntersecting) {
						entry.target.classList.add('rw-reveal--visible');
						observer.unobserve(entry.target);
					}
				});
			},
			{ rootMargin: '0px 0px -8% 0px', threshold: 0.12 }
		);
		els.forEach(function (el) {
			io.observe(el);
		});
	}



	function runWhenIdle(task) {
		if (typeof window.requestIdleCallback === 'function') {
			window.requestIdleCallback(task, { timeout: 1200 });
			return;
		}
		window.setTimeout(task, 300);
	}

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

		// Chrome (header solidify, dropdowns, mobile sheet, mockup FAQ, mockup lightbox)
		// lives in shared.js. Do not re-bind here — dual handlers fight the concept markup.
		safeInit('initExploreFilter', initExploreFilter);
		// Legacy FAQ markup (details / .faq-filter-pill) until every template is concept-ported.
		safeInit('initFaqTabs', initFaqTabs);
		safeInit('initFaqToggleA11y', initFaqToggleA11y);
		safeInit('initFaqQuestionFormValidation', initFaqQuestionFormValidation);

		// Non-critical analytics and reveal effects run after the initial paint window.
		runWhenIdle(function () {
			safeInit('initRestwellGa4SecondaryEvents', initRestwellGa4SecondaryEvents);
			safeInit('initRestwellCtaAnalytics', initRestwellCtaAnalytics);
			safeInit('initScrollDepthTracking', initScrollDepthTracking);
			safeInit('initRevealAnimations', initRevealAnimations);
		});
	});
})();
