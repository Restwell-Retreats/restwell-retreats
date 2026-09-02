/**
 * Restwell Retreats — in-page nav (vanilla JS, no bundler).
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
	 * Back-to-top button. Shows once the visitor has scrolled past one
	 * viewport height and returns them to the top on click or Enter/Space.
	 * Long pages (Accessibility, Pricing) benefit most on mobile, where
	 * re-scrolling to the nav or enquiry link is slow and error-prone.
	 */
	function initScrollToTop() {
		var btn = document.querySelector('[data-scroll-top]');
		if (!btn) {
			return;
		}
		btn.hidden = false;
		btn.setAttribute('aria-hidden', 'true');
		btn.tabIndex = -1;
		var visible = false;
		var ticking = false;
		function update() {
			ticking = false;
			var shouldShow = (window.pageYOffset || document.documentElement.scrollTop || 0) > window.innerHeight;
			if (shouldShow === visible) {
				return;
			}
			visible = shouldShow;
			btn.classList.toggle('is-visible', visible);
			btn.setAttribute('aria-hidden', visible ? 'false' : 'true');
			btn.tabIndex = visible ? 0 : -1;
		}
		window.addEventListener(
			'scroll',
			function () {
				if (!ticking) {
					ticking = true;
					window.requestAnimationFrame(update);
				}
			},
			{ passive: true }
		);
		update();
		btn.addEventListener('click', function () {
			var prefersReducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
			window.scrollTo({ top: 0, behavior: prefersReducedMotion ? 'auto' : 'smooth' });
		});
	}
	/**
	 * Sticky section jump-nav: scroll-spy active-link highlight + horizontal
	 * scroll affordance for the nav track. Shared by the "Who It's For" persona
	 * nav and the property page section nav — behaviour is identical, only the
	 * selectors and BEM class prefix differ.
	 *
	 * @param {Object} config
	 * @param {string} config.rootSelector Page wrapper selector.
	 * @param {string} config.navSelector  Nav element selector, scoped to root.
	 * @param {string} config.anchorAttr   Link data-attribute holding the target section id.
	 * @param {string} config.classPrefix  BEM block name for the nav (e.g. 'prop-page-nav').
	 * @param {string} [config.hintId]     Id of the "scroll for more" hint element, if any.
	 * @return {{root: Element, nav: Element, links: NodeList, sections: Array}|null}
	 *   Null when the nav isn't present on this page; otherwise the resolved
	 *   elements so callers can layer extra behaviour (e.g. accordion cards)
	 *   on top of the shared scroll-spy.
	 */
	function initSectionJumpNav(config) {
		var root = document.querySelector(config.rootSelector);
		if (!root) {
			return null;
		}
		var nav = root.querySelector(config.navSelector);
		if (!nav) {
			return null;
		}
		var links = nav.querySelectorAll('a[' + config.anchorAttr + ']');
		var sections = [];
		links.forEach(function (link) {
			var id = link.getAttribute(config.anchorAttr);
			var el = id ? document.getElementById(id) : null;
			if (el) {
				sections.push({ el: el, link: link });
			}
		});
		if (!sections.length) {
			return null;
		}

		var prefix = config.classPrefix;
		var activeClass = prefix + '__link--active';

		function clearActive() {
			nav.querySelectorAll('.' + activeClass).forEach(function (a) {
				a.classList.remove(activeClass);
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
				best.link.classList.add(activeClass);
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

		var track = nav.querySelector('.' + prefix + '__track');
		var list = nav.querySelector('.' + prefix + '__list');
		var hint = config.hintId ? document.getElementById(config.hintId) : null;
		function updateScrollAffordance() {
			if (!list || !track) {
				return;
			}
			var mq = window.matchMedia('(min-width: 768px)');
			if (mq.matches) {
				track.classList.remove(
					prefix + '__track--scrollable',
					prefix + '__track--at-start',
					prefix + '__track--at-end'
				);
				if (hint) {
					hint.classList.remove(prefix + '__hint--collapsed');
				}
				return;
			}
			var overflow = list.scrollWidth > list.clientWidth + 2;
			if (hint) {
				if (overflow) {
					hint.classList.remove(prefix + '__hint--collapsed');
				} else {
					hint.classList.add(prefix + '__hint--collapsed');
				}
			}
			if (!overflow) {
				track.classList.remove(
					prefix + '__track--scrollable',
					prefix + '__track--at-start',
					prefix + '__track--at-end'
				);
				return;
			}
			track.classList.add(prefix + '__track--scrollable');
			var maxScroll = list.scrollWidth - list.clientWidth;
			var sl = list.scrollLeft;
			track.classList.toggle(prefix + '__track--at-start', sl <= 3);
			track.classList.toggle(prefix + '__track--at-end', sl >= maxScroll - 3);
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

		window.addEventListener('scroll', onScrollOrResize, { passive: true });
		window.addEventListener('resize', onScrollOrResize, { passive: true });
		updateActive();

		return { root: root, nav: nav, links: links, sections: sections };
	}
	/**
	 * Who It's For: highlight jump-nav link for the section nearest the upper
	 * viewport, plus exclusive-accordion persona cards and hash deep-linking.
	 */
	function initWifPersonaNav() {
		var navState = initSectionJumpNav({
			rootSelector: '.restwell-wif-page',
			navSelector: '.wif-persona-nav',
			anchorAttr: 'data-wif-anchor',
			classPrefix: 'wif-persona-nav',
			hintId: 'wif-persona-nav-hint'
		});
		if (!navState) {
			return;
		}
		var root = navState.root;
		var personaLinks = navState.links;

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
	}
	/**
	 * Property page: sticky section jump nav (same interaction model as Who It's For).
	 */
	function initPropPageNav() {
		initSectionJumpNav({
			rootSelector: '.prop-page',
			navSelector: '.prop-page-nav',
			anchorAttr: 'data-prop-anchor',
			classPrefix: 'prop-page-nav',
			hintId: 'prop-page-nav-hint'
		});
	}
	/**
	 * Pricing page: highlight current section in the resources-style TOC
	 * (mobile pills + desktop rail). Progressive enhancement only.
	 */
	function initPricingPageNav() {
		var root = document.querySelector('.restwell-pricing-page');
		if (!root) {
			return;
		}
		var links = root.querySelectorAll('a[data-pricing-anchor]');
		if (!links.length) {
			return;
		}
		var sections = [];
		var seen = {};
		links.forEach(function (link) {
			var id = link.getAttribute('data-pricing-anchor');
			if (!id || seen[id]) {
				return;
			}
			var el = document.getElementById(id);
			if (el) {
				seen[id] = true;
				sections.push({ id: id, el: el });
			}
		});
		if (!sections.length) {
			return;
		}

		function clearActive() {
			links.forEach(function (a) {
				a.removeAttribute('aria-current');
			});
		}

		function setActive(id) {
			clearActive();
			if (!id) {
				return;
			}
			links.forEach(function (a) {
				if (a.getAttribute('data-pricing-anchor') === id) {
					a.setAttribute('aria-current', 'true');
				}
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
			setActive(best ? best.id : null);
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

		window.addEventListener('scroll', onScrollOrResize, { passive: true });
		window.addEventListener('resize', onScrollOrResize, { passive: true });
		updateActive();
	}

	ready(function () {
		safeInit('initScrollToTop', initScrollToTop);
		safeInit('initSectionJumpNav', initSectionJumpNav);
		safeInit('initWifPersonaNav', initWifPersonaNav);
		safeInit('initPropPageNav', initPropPageNav);
		safeInit('initPricingPageNav', initPricingPageNav);
	});
})();
