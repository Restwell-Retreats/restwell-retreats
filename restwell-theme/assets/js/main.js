/**
 * Restwell Retreats - header and nav behaviour (vanilla JS, no dependencies).
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

	function setActiveNavLinks() {
		var path = window.location.pathname.replace(/\/$/, '') || '/';
		var navLinks = document.querySelectorAll('.site-nav a, .mobile-nav a');
		navLinks.forEach(function (link) {
			var href = link.getAttribute('href');
			if (!href || href.indexOf('#') === 0) return;
			var linkPath = href.replace(/^https?:\/\/[^/]+/, '').replace(/\/$/, '') || '/';
			if (linkPath === path) {
				link.classList.add('active');
				link.setAttribute('aria-current', 'page');
			} else {
				link.classList.remove('active');
				link.removeAttribute('aria-current');
			}
		});
	}

	function initStickyHeaderShadow() {
		var header = document.querySelector('.site-header');
		if (!header) return;

		function updateScrolled() {
			if (window.scrollY > 10) {
				header.classList.add('scrolled');
			} else {
				header.classList.remove('scrolled');
			}
		}

		updateScrolled();
		window.addEventListener('scroll', updateScrolled, { passive: true });
	}

	function closeAllNavDropdowns() {
		document.querySelectorAll('.site-nav .site-nav-list li.site-nav__item--has-dropdown.is-open').forEach(function (li) {
			li.classList.remove('is-open');
			var btn = li.querySelector('.site-nav__dropdown-toggle');
			if (btn) {
				btn.setAttribute('aria-expanded', 'false');
			}
			var parentLink = li.querySelector(':scope > a');
			if (parentLink && parentLink.getAttribute('aria-expanded') !== null) {
				parentLink.setAttribute('aria-expanded', 'false');
			}
		});
	}

	/** Parent menu items that only toggle the panel (no navigation). */
	function restwellIsPlaceholderNavHref(href) {
		if (!href) {
			return true;
		}
		var h = String(href).trim();
		if (h === '#' || h === '#0') {
			return true;
		}
		if (/^javascript:/i.test(h)) {
			return true;
		}
		return false;
	}

	/**
	 * Desktop: disclosure-style dropdowns (fallback buttons + WP Primary nested items).
	 */
	function initNavDropdowns() {
		var nav = document.querySelector('.site-nav');
		if (!nav) {
			return;
		}

		var hasFallback = nav.querySelector('[data-nav-dropdown]');
		var hasWpDropdown = nav.querySelector('li.menu-item-has-children > .sub-menu');
		if (!hasFallback && !hasWpDropdown) {
			return;
		}

		var dropdowns = nav.querySelectorAll('[data-nav-dropdown]');
		dropdowns.forEach(function (li) {
			var btn = li.querySelector('.site-nav__dropdown-toggle');
			var menu = li.querySelector('.site-nav__submenu');
			if (!btn || !menu) {
				return;
			}

			btn.addEventListener('click', function (e) {
				e.preventDefault();
				e.stopPropagation();
				dropdowns.forEach(function (other) {
					if (other !== li && other.classList.contains('is-open')) {
						other.classList.remove('is-open');
						var ob = other.querySelector('.site-nav__dropdown-toggle');
						if (ob) {
							ob.setAttribute('aria-expanded', 'false');
						}
					}
				});
				nav.querySelectorAll('li.menu-item-has-children.is-open').forEach(function (other) {
					if (!other.hasAttribute('data-nav-dropdown')) {
						other.classList.remove('is-open');
						var oa = other.querySelector(':scope > a');
						if (oa) {
							oa.setAttribute('aria-expanded', 'false');
						}
					}
				});
				var willOpen = !li.classList.contains('is-open');
				li.classList.toggle('is-open', willOpen);
				btn.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
			});
		});

		nav.querySelectorAll('li.menu-item-has-children').forEach(function (li) {
			if (li.hasAttribute('data-nav-dropdown')) {
				return;
			}
			var sub = li.querySelector(':scope > .sub-menu');
			var parentLink = li.querySelector(':scope > a');
			if (!sub || !parentLink) {
				return;
			}
			parentLink.setAttribute('aria-haspopup', 'true');
			if (parentLink.getAttribute('aria-expanded') === null) {
				parentLink.setAttribute('aria-expanded', 'false');
			}
			parentLink.addEventListener('click', function (e) {
				if (window.matchMedia('(max-width: 1023px)').matches) {
					return;
				}
				if (!restwellIsPlaceholderNavHref(parentLink.getAttribute('href'))) {
					return;
				}
				e.preventDefault();
				e.stopPropagation();
				dropdowns.forEach(function (other) {
					if (other.classList.contains('is-open')) {
						other.classList.remove('is-open');
						var ob = other.querySelector('.site-nav__dropdown-toggle');
						if (ob) {
							ob.setAttribute('aria-expanded', 'false');
						}
					}
				});
				nav.querySelectorAll('li.menu-item-has-children.is-open').forEach(function (other) {
					if (other !== li) {
						other.classList.remove('is-open');
						var oa = other.querySelector(':scope > a');
						if (oa && !other.hasAttribute('data-nav-dropdown')) {
							oa.setAttribute('aria-expanded', 'false');
						}
					}
				});
				var willOpen = !li.classList.contains('is-open');
				li.classList.toggle('is-open', willOpen);
				parentLink.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
			});
		});

		nav.addEventListener('click', function (e) {
			var a = e.target.closest('a');
			if (!a || !a.closest('.site-nav__submenu, .sub-menu')) {
				return;
			}
			closeAllNavDropdowns();
		});

		document.addEventListener('click', function (e) {
			if (!nav.contains(e.target)) {
				closeAllNavDropdowns();
				return;
			}
			if (e.target.closest('.site-nav__dropdown-toggle')) {
				return;
			}
			if (e.target.closest('.site-nav__submenu, .site-nav .sub-menu')) {
				return;
			}
			closeAllNavDropdowns();
		});

		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape') {
				closeAllNavDropdowns();
			}
		});
	}

	function initMobileMenu() {
		var btn = document.querySelector('.mobile-menu-btn');
		var mobileNav = document.getElementById('mobile-nav');
		var siteHeader = document.querySelector('.site-header');

		if (!btn || !mobileNav) return;

		function isOpen() {
			return mobileNav.classList.contains('is-open');
		}

		function syncMobileNavTop() {
			if (!siteHeader) return;
			var h = Math.round(siteHeader.getBoundingClientRect().height);
			if (h > 0) {
				mobileNav.style.setProperty('--restwell-mobile-nav-top', h + 'px');
			}
		}

		function setMenuOpenState(open) {
			var root = document.documentElement;
			if (open) {
				root.classList.add('restwell-menu-open');
				document.body.classList.add('restwell-menu-open');
			} else {
				root.classList.remove('restwell-menu-open');
				document.body.classList.remove('restwell-menu-open');
			}
		}

		function openMenu() {
			syncMobileNavTop();
			mobileNav.classList.add('is-open');
			mobileNav.removeAttribute('aria-hidden');
			btn.setAttribute('aria-expanded', 'true');
			btn.setAttribute('aria-label', 'Close menu');
			setMenuOpenState(true);
			var firstLink = mobileNav.querySelector('a');
			if (firstLink) {
				firstLink.focus();
			}
		}

		function closeMenu() {
			mobileNav.classList.remove('is-open');
			mobileNav.setAttribute('aria-hidden', 'true');
			btn.setAttribute('aria-expanded', 'false');
			btn.setAttribute('aria-label', 'Open menu');
			setMenuOpenState(false);
		}

		window.addEventListener(
			'resize',
			function () {
				if (isOpen()) {
					syncMobileNavTop();
				}
			},
			{ passive: true }
		);

		function toggleMenu() {
			if (isOpen()) {
				closeMenu();
			} else {
				openMenu();
			}
		}

		btn.addEventListener('click', function (e) {
			e.preventDefault();
			toggleMenu();
		});

		// Close when clicking a mobile nav link
		mobileNav.addEventListener('click', function (e) {
			var anchor = e.target.closest('a');
			if (anchor && isOpen()) {
				closeMenu();
			}
		});

		// Close when clicking outside .site-header
		document.addEventListener('click', function (e) {
			if (!isOpen()) return;
			if (siteHeader && siteHeader.contains(e.target)) return;
			closeMenu();
		});

		// Close on Escape
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && isOpen()) {
				closeMenu();
				btn.focus();
			}
		});
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
	 * Homepage FAQ accordion behavior.
	 * Keeps a single FAQ item open at a time.
	 */
	function initHomeFaqAccordion() {
		var items = document.querySelectorAll('#home-faq-accordion .faq-item');
		if (!items.length) return;

		items.forEach(function (item) {
			item.addEventListener('toggle', function () {
				if (!item.open) return;
				if (typeof window.gtag === 'function') {
					window.gtag('event', 'faq_expanded', {
						page_path: window.location.pathname,
						user_type: 'guest',
						faq_category: item.getAttribute('data-category') || 'home',
					});
				}
				items.forEach(function (otherItem) {
					if (otherItem !== item) {
						otherItem.open = false;
					}
				});
			});
		});
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
	 * Multi-step enquiry form.
	 * Manages step visibility, progress indicator state, and per-step validation.
	 */
	function initMultiStepForm() {
		var form = document.querySelector('.restwell-enq-form[data-multistep]');
		if (!form) return;
		var startedTracked = false;

		function trackFormStarted() {
			if (startedTracked || typeof window.gtag !== 'function') {
				return;
			}
			startedTracked = true;
			window.gtag('event', 'enquiry_form_started', {
				page_path: window.location.pathname,
				user_type: 'guest',
			});
		}

		function todayYmd() {
			var d = new Date();
			var y = d.getFullYear();
			var m = String(d.getMonth() + 1);
			var day = String(d.getDate());
			if (m.length === 1) m = '0' + m;
			if (day.length === 1) day = '0' + day;
			return y + '-' + m + '-' + day;
		}

		var dateFrom = form.querySelector('#enq_date_from');
		var dateTo = form.querySelector('#enq_date_to');
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

		var steps       = form.querySelectorAll('.enquire-step');
		var nodes       = form.querySelectorAll('.step-node');
		var lines       = form.querySelectorAll('.step-line');
		var progressBar = form.querySelector('.enq-steps-progress');
		var currentStep = 1;

		function getNodeCircle(node) { return node.querySelector('.step-circle'); }
		function getNodeLabel(node)  { return node.querySelector('.step-label'); }

		function updateProgress(newStep) {
			nodes.forEach(function (node) {
				var n      = parseInt(node.getAttribute('data-step'), 10);
				var circle = getNodeCircle(node);
				var label  = getNodeLabel(node);
				if (!circle || !label) return;

				if (n < newStep) {
					// Complete
					circle.style.backgroundColor = 'var(--deep-teal)';
					circle.style.borderColor     = 'var(--deep-teal)';
					circle.style.color           = '#fff';
					circle.innerHTML             = '<i class="ph-bold ph-check text-xs" aria-hidden="true"></i>';
					label.style.color            = 'var(--deep-teal)';
					label.style.fontWeight       = '500';
				} else if (n === newStep) {
					// Active
					circle.style.backgroundColor = 'var(--deep-teal)';
					circle.style.borderColor     = 'var(--deep-teal)';
					circle.style.color           = '#fff';
					circle.innerHTML             = String(n);
					label.style.color            = 'var(--deep-teal)';
					label.style.fontWeight       = '500';
				} else {
					// Pending - #6B6355 on white = 5.9:1 (WCAG AA pass)
					circle.style.backgroundColor = '#fff';
					circle.style.borderColor     = '#E8DFD0';
					circle.style.color           = '#6B6355';
					circle.innerHTML             = String(n);
					label.style.color            = '#6B6355';
					label.style.fontWeight       = 'normal';
				}
			});

			lines.forEach(function (line, idx) {
				// Line idx connects step (idx+1) to step (idx+2).
				line.style.backgroundColor = (idx + 1 < newStep) ? 'var(--deep-teal)' : '#E8DFD0';
			});

			if (progressBar) {
				progressBar.setAttribute('aria-valuenow', newStep);
			}
		}

		function showStep(n, skipScroll) {
			steps.forEach(function (step) {
				var stepNum = parseInt(step.getAttribute('data-step'), 10);
				step.classList.toggle('hidden', stepNum !== n);
			});
			updateProgress(n);
			currentStep = n;
			// Smooth scroll to top of form when navigating between steps,
			// but not on initial load (skipScroll = true) so the page starts at the top.
			if (!skipScroll) {
				form.scrollIntoView({ behavior: 'smooth', block: 'start' });
			}

			// Announce the new step to screen readers and move focus to the form
			// heading so keyboard users know where they are after the transition.
			// Without this, focus is destroyed when the active step receives display:none.
			var announcement = document.getElementById('enq-step-announcement');
			var stepLabels = { 1: 'Step 1: About you', 2: 'Step 2: Your stay', 3: 'Step 3: Your needs' };
			if (announcement) {
				announcement.textContent = stepLabels[n] || '';
			}
			// Move focus to the form heading only when changing steps (not on first paint):
			// initial showStep(1, true) would otherwise highlight "Tell us about your stay" on load.
			if (!skipScroll) {
				var formHeading = form.querySelector('h2');
				if (formHeading) {
					if (!formHeading.getAttribute('tabindex')) {
						formHeading.setAttribute('tabindex', '-1');
					}
					formHeading.focus({ preventScroll: true });
				}
			}

			// Optional step progression signal for funnel diagnostics.
			if (!skipScroll && typeof window.gtag === 'function') {
				window.gtag('event', 'enquiry_step_changed', {
					page_path: window.location.pathname,
					user_type: 'guest',
					enquiry_step: n,
				});
			}
		}

		function clearErrors(step) {
			step.querySelectorAll('.enq-field-error').forEach(function (el) {
				el.textContent = '';
				el.hidden = true;
			});
			step.querySelectorAll('[data-invalid]').forEach(function (el) {
				el.removeAttribute('data-invalid');
				el.removeAttribute('aria-invalid');
				el.removeAttribute('aria-describedby');
				el.style.borderColor = '';
			});
		}

		function addFieldError(field, message) {
			var errorId = field.id + '-error';
			var errorEl = document.getElementById(errorId);
			if (!errorEl) {
				errorEl = document.createElement('p');
				errorEl.id = errorId;
				errorEl.className = 'enq-field-error';
				errorEl.setAttribute('role', 'alert');
				field.parentNode.insertBefore(errorEl, field.nextSibling);
			}
			errorEl.textContent = message;
			errorEl.hidden = false;

			field.setAttribute('data-invalid', 'true');
			field.setAttribute('aria-invalid', 'true');
			field.setAttribute('aria-describedby', errorId);
			field.style.borderColor = '#b91c1c';
		}

		function getFieldLabel(field) {
			var label = form.querySelector('label[for="' + field.id + '"]');
			if (label) {
				// Strip the (optional) span text to get the plain label name
				return (label.firstChild && label.firstChild.nodeValue)
					? label.firstChild.nodeValue.trim()
					: label.textContent.replace(/\s*\*\s*|\(optional\)/gi, '').trim();
			}
			return 'This field';
		}

		function validateStep(n) {
			var step = form.querySelector('.enquire-step[data-step="' + n + '"]');
			if (!step) return true;
			clearErrors(step);

			var required = step.querySelectorAll('[required]');
			var valid    = true;
			var firstInvalid = null;

			required.forEach(function (field) {
				if (!field.value.trim()) {
					addFieldError(field, getFieldLabel(field) + ' is required.');
					valid = false;
					if (!firstInvalid) firstInvalid = field;
				} else if (field.type === 'tel' && !isPlausiblePhone(field.value)) {
					addFieldError(field, restwellPhoneErrorMessage(field.value));
					valid = false;
					if (!firstInvalid) firstInvalid = field;
				}
			});

			if (n === 2 && dateFrom && dateTo) {
				var fromV = dateFrom.value;
				var toV = dateTo.value;
				if (fromV && fromV < todayStr) {
					addFieldError(dateFrom, 'Start date cannot be in the past.');
					valid = false;
					if (!firstInvalid) firstInvalid = dateFrom;
				}
				if (toV && toV < todayStr) {
					addFieldError(dateTo, 'End date cannot be in the past.');
					valid = false;
					if (!firstInvalid) firstInvalid = dateTo;
				}
				if (fromV && toV && toV < fromV) {
					addFieldError(dateTo, 'End date must be on or after the start date.');
					valid = false;
					if (!firstInvalid) firstInvalid = dateTo;
				}
			}

			if (!valid && firstInvalid) {
				firstInvalid.focus();
			}
			return valid;
		}

		// Delegation: next and back button clicks.
		form.addEventListener('click', function (e) {
			var nextBtn = e.target.closest('.step-next');
			if (nextBtn) {
				var next = parseInt(nextBtn.getAttribute('data-next'), 10);
				if (validateStep(currentStep)) {
					showStep(next);
				}
				return;
			}
			var backBtn = e.target.closest('.step-back');
			if (backBtn) {
				var back = parseInt(backBtn.getAttribute('data-back'), 10);
				showStep(back);
			}
		});

		form.addEventListener(
			'focusin',
			function () {
				trackFormStarted();
			},
			{ passive: true }
		);
		form.addEventListener(
			'input',
			function () {
				trackFormStarted();
			},
			{ passive: true }
		);

		// Final submit: validate every step (novalidate suppresses native checks for multi-step UX).
		form.addEventListener('submit', function (e) {
			var order = [1, 2, 3];
			var ok = true;
			var badStep = 0;
			for (var i = 0; i < order.length; i++) {
				if (!validateStep(order[i])) {
					ok = false;
					badStep = order[i];
					break;
				}
			}
			if (!ok) {
				e.preventDefault();
				if (badStep) {
					showStep(badStep);
				}
			}
		});

		// Clear error on input once user starts correcting the field.
		form.addEventListener('input', function (e) {
			var field = e.target;
			if (!field || !field.required) return;
			var hasValue = field.type === 'checkbox' ? field.checked : !!String(field.value || '').trim();
			if (hasValue && field.getAttribute('aria-invalid') === 'true') {
				if (field.type === 'tel' && !isPlausiblePhone(field.value)) {
					return;
				}
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
		});

		form.querySelectorAll('[type="tel"][required]').forEach(function (field) {
			field.addEventListener('blur', function () {
				if (!field.value.trim()) {
					addFieldError(field, getFieldLabel(field) + ' is required.');
					return;
				}
				if (!isPlausiblePhone(field.value)) {
					addFieldError(field, restwellPhoneErrorMessage(field.value));
					return;
				}
				var errorEl = document.getElementById(field.id + '-error');
				if (errorEl) {
					errorEl.textContent = '';
					errorEl.hidden = true;
				}
				field.removeAttribute('data-invalid');
				field.removeAttribute('aria-invalid');
				field.removeAttribute('aria-describedby');
				field.style.borderColor = '';
			});
		});

		// Initialise at step 1 - skip scroll so the page loads at the top.
		showStep(1, true);
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
	 *   - On a fresh load, restore the draft and show a subtle "we restored
	 *     your details" notice with a Discard control.
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
		var form = document.querySelector('.restwell-enq-form[data-multistep]');
		if (!form) return;

		// Versioned key so we can change the stored shape later without exhuming
		// bad drafts from returning visitors.
		var KEY = 'restwell_enquiry_draft_v1';
		// Drop drafts older than a week — by then the user has clearly moved on
		// and seeing a 12-day-old "Restored your details" banner is jarring.
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

		// True if the page rendered with values already filled in by the server.
		// That happens after a validation failure: the server re-renders the
		// form with the user's submitted values via $enq_f. Their just-typed
		// state is fresher than anything in localStorage, so we leave it alone.
		function isServerPrefilled() {
			for (var i = 0; i < PERSIST_FIELDS.length; i++) {
				var f = getField(PERSIST_FIELDS[i]);
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
				// Empty form means there's nothing worth restoring later. Wipe
				// any stale draft so the next visit doesn't show the notice.
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

		function relativeMinutes(savedAt) {
			var minutes = Math.max(1, Math.round((Date.now() - savedAt) / 60000));
			if (minutes < 60) {
				return minutes + (minutes === 1 ? ' minute ago' : ' minutes ago');
			}
			var hours = Math.round(minutes / 60);
			if (hours < 24) {
				return hours + (hours === 1 ? ' hour ago' : ' hours ago');
			}
			var days = Math.round(hours / 24);
			return days + (days === 1 ? ' day ago' : ' days ago');
		}

		function showRestoredNotice(draft) {
			var notice = document.createElement('div');
			notice.className = 'restwell-enq-draft-notice';
			notice.setAttribute('role', 'status');
			// polite (not assertive) — the user already knows they came back to
			// the form. A jolting screen-reader interrupt is the wrong volume.
			notice.setAttribute('aria-live', 'polite');

			var p = document.createElement('p');
			p.className = 'restwell-enq-draft-notice__text';
			p.appendChild(document.createTextNode('We restored your details from ' + relativeMinutes(draft.savedAt) + '. '));

			var discard = document.createElement('button');
			discard.type = 'button';
			discard.className = 'restwell-enq-draft-notice__discard';
			discard.textContent = 'Discard and start fresh';

			discard.addEventListener('click', function () {
				PERSIST_FIELDS.forEach(function (name) {
					writeField(getField(name), '');
				});
				clearDraft();
				notice.remove();
				// Send the user back to step 1 so the cleared form makes sense
				// in context — they shouldn't be staring at an empty step 3.
				var firstNode = form.querySelector('.step-node[data-step="1"]');
				var visibleStep = form.querySelector('.enquire-step:not(.hidden)');
				if (visibleStep && firstNode && parseInt(visibleStep.getAttribute('data-step'), 10) > 1) {
					var backBtn = form.querySelector('.step-back[data-back="1"]');
					if (backBtn) backBtn.click();
				}
				var name = getField('enq_name');
				if (name) name.focus();
			});

			p.appendChild(discard);
			notice.appendChild(p);

			var heading = form.querySelector('h2');
			if (heading && heading.parentNode) {
				heading.parentNode.insertBefore(notice, heading.nextSibling);
			} else {
				form.insertBefore(notice, form.firstChild);
			}
		}

		// Capture date inputs once so applyDraft() can re-fire the change event.
		var dateFromAfterRestore = form.querySelector('#enq_date_from');
		var dateToAfterRestore   = form.querySelector('#enq_date_to');

		var hasUnsavedInput = false;

		if (isServerPrefilled()) {
			// Server flash carried the user's submitted values. Treat that as
			// "unsaved" so beforeunload still warns them off accidental nav.
			hasUnsavedInput = true;
		} else {
			var draft = loadDraft();
			if (draft) {
				applyDraft(draft);
				showRestoredNotice(draft);
				hasUnsavedInput = true;
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
		// no form to restore into; clearing here also covers the "tab restore
		// after a successful submit" case so users don't see a phantom notice.
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

	/**
	 * Who It's For: highlight jump-nav link for the section nearest the upper viewport.
	 */
	function initWifPersonaNav() {
		var root = document.querySelector('.restwell-wif-page');
		if (!root) {
			return;
		}
		var nav = root.querySelector('.wif-persona-nav');
		if (!nav) {
			return;
		}
		var personaLinks = nav.querySelectorAll('a[data-wif-anchor]');
		var sections = [];
		personaLinks.forEach(function (link) {
			var id = link.getAttribute('data-wif-anchor');
			var el = id ? document.getElementById(id) : null;
			if (el) {
				sections.push({ el: el, link: link });
			}
		});
		if (!sections.length) {
			return;
		}
		function clearActive() {
			nav.querySelectorAll('.wif-persona-nav__link--active').forEach(function (a) {
				a.classList.remove('wif-persona-nav__link--active');
				a.removeAttribute('aria-current');
			});
		}
		function updateActive() {
			var vh = window.innerHeight || document.documentElement.clientHeight;
			var target = 0.32 * vh;
			var best = null;
			var bestDist = Infinity;
			sections.forEach(function (s) {
				var r = s.el.getBoundingClientRect();
				if (r.bottom <= 0 || r.top >= vh) {
					return;
				}
				var mid = (r.top + r.bottom) / 2;
				var dist = Math.abs(mid - target);
				if (dist < bestDist) {
					bestDist = dist;
					best = s;
				}
			});
			if (best && best.link) {
				clearActive();
				best.link.classList.add('wif-persona-nav__link--active');
				best.link.setAttribute('aria-current', 'true');
			} else {
				clearActive();
			}
		}
		var ticking = false;
		function onScrollOrResize() {
			if (ticking) {
				return;
			}
			ticking = true;
			window.requestAnimationFrame(function () {
				updateActive();
				ticking = false;
			});
		}

		var track = nav.querySelector('.wif-persona-nav__track');
		var list = nav.querySelector('.wif-persona-nav__list');
		var hint = document.getElementById('wif-persona-nav-hint');
		function updateScrollAffordance() {
			if (!list || !track) {
				return;
			}
			var mq = window.matchMedia('(min-width: 768px)');
			if (mq.matches) {
				track.classList.remove(
					'wif-persona-nav__track--scrollable',
					'wif-persona-nav__track--at-start',
					'wif-persona-nav__track--at-end'
				);
				if (hint) {
					hint.classList.remove('wif-persona-nav__hint--collapsed');
				}
				return;
			}
			var overflow = list.scrollWidth > list.clientWidth + 2;
			if (hint) {
				if (overflow) {
					hint.classList.remove('wif-persona-nav__hint--collapsed');
				} else {
					hint.classList.add('wif-persona-nav__hint--collapsed');
				}
			}
			if (!overflow) {
				track.classList.remove(
					'wif-persona-nav__track--scrollable',
					'wif-persona-nav__track--at-start',
					'wif-persona-nav__track--at-end'
				);
				return;
			}
			track.classList.add('wif-persona-nav__track--scrollable');
			var maxScroll = list.scrollWidth - list.clientWidth;
			var sl = list.scrollLeft;
			track.classList.toggle('wif-persona-nav__track--at-start', sl <= 3);
			track.classList.toggle('wif-persona-nav__track--at-end', sl >= maxScroll - 3);
		}
		if (list) {
			list.addEventListener(
				'scroll',
				function () {
					updateScrollAffordance();
				},
				{ passive: true }
			);
		}
		window.addEventListener('resize', function () {
			updateScrollAffordance();
		});
		updateScrollAffordance();
		window.requestAnimationFrame(function () {
			updateScrollAffordance();
		});
		setTimeout(updateScrollAffordance, 400);

	// Close all other persona cards smoothly when one opens (exclusive accordion).
	var allCards = root.querySelectorAll('details.wif-persona-card');

	function closeCard(card) {
		var body = card.querySelector('.wif-persona-card__body');
		if (!body) {
			card.open = false;
			return;
		}
		var startHeight = body.offsetHeight;
		var anim = body.animate(
			[{ height: startHeight + 'px', overflow: 'hidden' }, { height: '0px', overflow: 'hidden' }],
			{ duration: 260, easing: 'ease-in-out' }
		);
		anim.onfinish = function () {
			card.open = false;
		};
	}

	allCards.forEach(function (card) {
		card.addEventListener('toggle', function () {
			if (!card.open) {
				return;
			}
			allCards.forEach(function (other) {
				if (other !== card && other.open) {
					closeCard(other);
				}
			});
		});
	});

	// Open the <details> card when a persona nav link is clicked.
	personaLinks.forEach(function (link) {
		link.addEventListener('click', function () {
			var id = link.getAttribute('data-wif-anchor') || (link.hash && link.hash.slice(1));
			if (!id) {
				return;
			}
			var card = document.getElementById(id);
			if (card && card.tagName === 'DETAILS') {
				card.open = true;
			}
		});
	});
	// Open from initial hash or subsequent hash changes.
	function openDetailsFromHash() {
		var hash = location.hash.slice(1);
		if (!hash) {
			return;
		}
		var el = document.getElementById(hash);
		if (el && el.tagName === 'DETAILS') {
			el.open = true;
		}
	}
	openDetailsFromHash();
	window.addEventListener('hashchange', openDetailsFromHash, { passive: true });
	window.addEventListener('scroll', onScrollOrResize, { passive: true });
	window.addEventListener('resize', onScrollOrResize, { passive: true });
	updateActive();
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
		if (path.indexOf('/the-property') !== -1) {
			window.gtag('event', 'property_page_viewed', {
				user_type: 'guest',
				page_path: path,
			});
		}
		if (path.indexOf('/accessibility') !== -1) {
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
					});
				} else if (/^mailto:/i.test(href)) {
					window.gtag('event', 'email_clicked', {
						user_type: 'guest',
						page_path: window.location.pathname,
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
				window.gtag('event', 'restwell_cta_click', {
					cta_id: id,
					cta_text: ctaLabel ? ctaLabel.substring(0, 120) : id,
					page_path: window.location.pathname,
					user_type: 'guest',
				});
			},
			true
		);
	}

	function initHomeComparisonScrollHints() {
		var scrollEl = document.querySelector('[data-home-comparison-scroll]');
		var leftFade = document.querySelector('[data-home-comparison-fade="left"]');
		var rightFade = document.querySelector('[data-home-comparison-fade="right"]');
		if (!scrollEl || !leftFade || !rightFade) {
			return;
		}

		function update() {
			if (window.matchMedia('(min-width: 768px)').matches) {
				leftFade.classList.add('opacity-0');
				rightFade.classList.add('opacity-0');
				return;
			}
			var sw = scrollEl.scrollWidth;
			var cw = scrollEl.clientWidth;
			var sl = scrollEl.scrollLeft;
			var epsilon = 3;
			var scrollable = sw > cw + epsilon;
			if (!scrollable) {
				leftFade.classList.add('opacity-0');
				rightFade.classList.add('opacity-0');
				return;
			}
			var atStart = sl <= epsilon;
			var atEnd = sl + cw >= sw - epsilon;
			leftFade.classList.toggle('opacity-0', atStart);
			leftFade.classList.toggle('opacity-100', !atStart);
			rightFade.classList.toggle('opacity-0', atEnd);
			rightFade.classList.toggle('opacity-100', !atEnd);
		}

		scrollEl.addEventListener('scroll', update, { passive: true });
		window.addEventListener('resize', update, { passive: true });
		update();
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

	function initRestwellGalleryCarousel() {
		var carousels = document.querySelectorAll('[data-restwell-carousel]');
		if (!carousels.length) {
			return;
		}

		carousels.forEach(function (carousel) {
			var track = carousel.querySelector('[data-carousel-track]');
			var slides = track
				? Array.prototype.slice.call(track.querySelectorAll('[data-carousel-slide]'))
				: Array.prototype.slice.call(carousel.querySelectorAll('[data-carousel-slide]'));

			if (!slides.length) {
				return;
			}

			var prevBtn = carousel.querySelector('[data-carousel-prev]');
			var nextBtn = carousel.querySelector('[data-carousel-next]');
			var statusEl = carousel.querySelector('[data-carousel-status]');
			var currentIndex = 0;
			var total = slides.length;

			if (total <= 1) {
				if (prevBtn) {
					prevBtn.disabled = true;
				}
				if (nextBtn) {
					nextBtn.disabled = true;
				}
			}

			function announceSlide(index) {
				if (!statusEl) {
					return;
				}
				var slide = slides[index];
				var captionEl = slide ? slide.querySelector('.restwell-carousel__caption') : null;
				var caption = captionEl ? captionEl.textContent.trim() : '';
				var counter = (index + 1) + ' / ' + total;
				statusEl.textContent = caption !== '' ? (counter + ': ' + caption) : counter;
			}

			function showSlide(index) {
				if (index < 0) {
					index = total - 1;
				}
				if (index >= total) {
					index = 0;
				}
				currentIndex = index;

				slides.forEach(function (slide, slideIndex) {
					var isActive = slideIndex === currentIndex;
					slide.hidden = !isActive;
					slide.setAttribute('aria-hidden', isActive ? 'false' : 'true');
				});

				announceSlide(currentIndex);
			}

			if (prevBtn) {
				prevBtn.addEventListener('click', function () {
					showSlide(currentIndex - 1);
				});
			}
			if (nextBtn) {
				nextBtn.addEventListener('click', function () {
					showSlide(currentIndex + 1);
				});
			}

			carousel.addEventListener('keydown', function (e) {
				if (e.key === 'ArrowLeft') {
					e.preventDefault();
					showSlide(currentIndex - 1);
				} else if (e.key === 'ArrowRight') {
					e.preventDefault();
					showSlide(currentIndex + 1);
				} else if (e.key === 'Home') {
					e.preventDefault();
					showSlide(0);
				} else if (e.key === 'End') {
					e.preventDefault();
					showSlide(total - 1);
				}
			});

			if (!carousel.hasAttribute('tabindex')) {
				carousel.setAttribute('tabindex', '0');
			}

			showSlide(0);

			var rootGallery = carousel.closest('.restwell-gallery--carousel');
			if (rootGallery) {
				rootGallery.classList.add('is-ready');
			}
		});
	}

	function initRestwellGalleryLightbox() {
		var galleries = document.querySelectorAll('[data-restwell-gallery]');
		if (!galleries.length) {
			return;
		}

		var lightboxEl = null;
		var lightboxImage = null;
		var lightboxCaption = null;
		var lightboxStatus = null;
		var lightboxClose = null;
		var lightboxPrev = null;
		var lightboxNext = null;
		var slides = [];
		var currentIndex = 0;
		var lastFocus = null;

		function getFocusable(root) {
			return Array.prototype.slice.call(
				root.querySelectorAll(
					'button:not([disabled]), [href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'
				)
			).filter(function (el) {
				return el.offsetParent !== null || el === document.activeElement;
			});
		}

		function trapFocus(e) {
			if (!lightboxEl || lightboxEl.hasAttribute('hidden')) {
				return;
			}
			if (e.key !== 'Tab') {
				return;
			}
			var focusable = getFocusable(lightboxEl);
			if (!focusable.length) {
				return;
			}
			var first = focusable[0];
			var last = focusable[focusable.length - 1];
			if (e.shiftKey && document.activeElement === first) {
				e.preventDefault();
				last.focus();
			} else if (!e.shiftKey && document.activeElement === last) {
				e.preventDefault();
				first.focus();
			}
		}

		function ensureLightbox() {
			if (lightboxEl) {
				return lightboxEl;
			}
			lightboxEl = document.createElement('div');
			lightboxEl.className = 'restwell-lightbox';
			lightboxEl.setAttribute('hidden', '');
			lightboxEl.setAttribute('role', 'dialog');
			lightboxEl.setAttribute('aria-modal', 'true');
			lightboxEl.setAttribute('aria-label', 'Photo gallery');
			lightboxEl.innerHTML =
				'<div class="restwell-lightbox__dialog">' +
					'<div class="restwell-lightbox__toolbar">' +
						'<button type="button" class="restwell-lightbox__btn restwell-lightbox__btn--close" data-lightbox-close aria-label="Close gallery">' +
							'<i class="ph-bold ph-x" aria-hidden="true"></i>' +
						'</button>' +
						'<button type="button" class="restwell-lightbox__btn restwell-lightbox__btn--prev" data-lightbox-prev aria-label="Previous image">' +
							'<i class="ph-bold ph-caret-left" aria-hidden="true"></i>' +
						'</button>' +
						'<button type="button" class="restwell-lightbox__btn restwell-lightbox__btn--next" data-lightbox-next aria-label="Next image">' +
							'<i class="ph-bold ph-caret-right" aria-hidden="true"></i>' +
						'</button>' +
						'<p class="restwell-lightbox__status" data-lightbox-status aria-live="polite"></p>' +
					'</div>' +
					'<figure class="restwell-lightbox__figure">' +
						'<img class="restwell-lightbox__image" src="" alt="" decoding="async" />' +
					'</figure>' +
					'<figcaption class="restwell-lightbox__caption" data-lightbox-caption></figcaption>' +
				'</div>';
			document.body.appendChild(lightboxEl);

			lightboxImage = lightboxEl.querySelector('.restwell-lightbox__image');
			lightboxCaption = lightboxEl.querySelector('[data-lightbox-caption]');
			lightboxStatus = lightboxEl.querySelector('[data-lightbox-status]');
			lightboxClose = lightboxEl.querySelector('[data-lightbox-close]');
			lightboxPrev = lightboxEl.querySelector('[data-lightbox-prev]');
			lightboxNext = lightboxEl.querySelector('[data-lightbox-next]');

			lightboxClose.addEventListener('click', closeLightbox);
			lightboxPrev.addEventListener('click', function () {
				showSlide(currentIndex - 1);
			});
			lightboxNext.addEventListener('click', function () {
				showSlide(currentIndex + 1);
			});
			lightboxEl.addEventListener('click', function (e) {
				if (e.target === lightboxEl) {
					closeLightbox();
				}
			});
			document.addEventListener('keydown', onLightboxKeydown);
			return lightboxEl;
		}

		function onLightboxKeydown(e) {
			if (!lightboxEl || lightboxEl.hasAttribute('hidden')) {
				return;
			}
			if (e.key === 'Escape') {
				e.preventDefault();
				closeLightbox();
				return;
			}
			if (e.key === 'ArrowLeft') {
				e.preventDefault();
				showSlide(currentIndex - 1);
				return;
			}
			if (e.key === 'ArrowRight') {
				e.preventDefault();
				showSlide(currentIndex + 1);
				return;
			}
			if (e.key === 'Enter' && document.activeElement === lightboxImage) {
				closeLightbox();
				return;
			}
			trapFocus(e);
		}

		function showSlide(index) {
			if (!slides.length) {
				return;
			}
			if (index < 0) {
				index = slides.length - 1;
			}
			if (index >= slides.length) {
				index = 0;
			}
			currentIndex = index;
			var slide = slides[currentIndex];
			lightboxImage.src = slide.url;
			lightboxImage.alt = slide.alt || '';
			if (lightboxCaption) {
				lightboxCaption.textContent = slide.alt || '';
				lightboxCaption.hidden = !slide.alt;
			}
			if (lightboxStatus) {
				lightboxStatus.textContent = (currentIndex + 1) + ' / ' + slides.length;
			}
			if (lightboxPrev) {
				lightboxPrev.disabled = slides.length <= 1;
			}
			if (lightboxNext) {
				lightboxNext.disabled = slides.length <= 1;
			}
		}

		function openLightbox(nextSlides, startIndex) {
			if (!nextSlides.length) {
				return;
			}
			ensureLightbox();
			lastFocus = document.activeElement;
			slides = nextSlides;
			showSlide(startIndex);
			lightboxEl.removeAttribute('hidden');
			document.body.classList.add('restwell-lightbox-open');
			if (lightboxClose) {
				lightboxClose.focus();
			}
		}

		function closeLightbox() {
			if (!lightboxEl) {
				return;
			}
			lightboxEl.setAttribute('hidden', '');
			document.body.classList.remove('restwell-lightbox-open');
			if (lightboxImage) {
				lightboxImage.removeAttribute('src');
			}
			if (lastFocus && typeof lastFocus.focus === 'function') {
				lastFocus.focus();
			}
		}

		galleries.forEach(function (gallery) {
			var dataEl = gallery.querySelector('.restwell-gallery__data');
			if (!dataEl) {
				return;
			}
			var parsed = [];
			try {
				parsed = JSON.parse(dataEl.textContent || '[]');
			} catch (err) {
				parsed = [];
			}
			if (!parsed.length) {
				return;
			}

			gallery.addEventListener('click', function (e) {
				var link = e.target.closest('[data-restwell-gallery-open]');
				if (!link) {
					return;
				}
				e.preventDefault();
				var index = parseInt(link.getAttribute('data-gallery-index'), 10);
				if (isNaN(index)) {
					index = 0;
				}
				openLightbox(parsed, index);
			});

			gallery.addEventListener('keydown', function (e) {
				if (e.key !== 'Enter' && e.key !== ' ') {
					return;
				}
				var trigger = e.target.closest('[data-restwell-gallery-open]');
				if (!trigger || trigger.tagName !== 'BUTTON') {
					return;
				}
				e.preventDefault();
				var index = parseInt(trigger.getAttribute('data-gallery-index'), 10);
				if (isNaN(index)) {
					index = 0;
				}
				openLightbox(parsed, index);
			});
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
		initRestwellFormOpenedAt();
		setActiveNavLinks();
		initStickyHeaderShadow();
		initNavDropdowns();
		initMobileMenu();
		initExploreFilter();
		initFaqTabs();
		initFaqToggleA11y();
		initHomeFaqAccordion();
		initMultiStepForm();
		initFaqQuestionFormValidation();
		// Must run AFTER initMultiStepForm() so the multi-step controller has
		// already wired up showStep() and date-range constraints; the draft
		// restore can then dispatch a 'change' event safely without racing.
		initEnquiryDraftPersistence();
		initWifPersonaNav();
		initHomeComparisonScrollHints();
		initRestwellGalleryCarousel();
		initRestwellGalleryLightbox();

		// Non-critical analytics and reveal effects run after the initial paint window.
		runWhenIdle(function () {
			initRestwellGa4SecondaryEvents();
			initEnquirySuccessScroll();
			initRestwellCtaAnalytics();
			initScrollDepthTracking();
			initRevealAnimations();
		});
	});
})();
