/**
 * Restwell Retreats — gallery (vanilla JS, no bundler).
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

	var ICON_CARET_LEFT = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><polyline points="15 18 9 12 15 6"></polyline></svg>';
	var ICON_CARET_RIGHT = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><polyline points="9 18 15 12 9 6"></polyline></svg>';
	var ICON_CLOSE = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';

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
		var lightboxNav = null;
		var lightboxStrip = null;
		var lightboxClose = null;
		var lightboxPrev = null;
		var lightboxNext = null;
		var slides = [];
		var currentIndex = 0;
		var lastFocus = null;
		var lockedScrollY = 0;

		function lockPageScroll() {
			lockedScrollY = window.scrollY || window.pageYOffset || 0;
			document.documentElement.classList.add('restwell-lightbox-open');
			document.body.classList.add('restwell-lightbox-open');
			document.body.style.top = '-' + lockedScrollY + 'px';
		}

		function unlockPageScroll() {
			document.documentElement.classList.remove('restwell-lightbox-open');
			document.body.classList.remove('restwell-lightbox-open');
			document.body.style.top = '';
			window.scrollTo(0, lockedScrollY);
		}

		function preventBackgroundTouchMove(e) {
			if (!lightboxEl || lightboxEl.hasAttribute('hidden')) {
				return;
			}
			if (lightboxEl.contains(e.target)) {
				return;
			}
			e.preventDefault();
		}

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
						'<p class="restwell-lightbox__counter" data-lightbox-counter aria-live="polite"></p>' +
						'<div class="restwell-lightbox__nav" data-lightbox-nav>' +
							'<button type="button" class="restwell-lightbox__btn" data-lightbox-prev aria-label="Previous image">' +
								ICON_CARET_LEFT +
							'</button>' +
							'<button type="button" class="restwell-lightbox__btn" data-lightbox-next aria-label="Next image">' +
								ICON_CARET_RIGHT +
							'</button>' +
						'</div>' +
						'<button type="button" class="restwell-lightbox__btn" data-lightbox-close aria-label="Close gallery">' +
							ICON_CLOSE +
						'</button>' +
					'</div>' +
					'<figure class="restwell-lightbox__figure">' +
						'<img class="restwell-lightbox__image" src="" alt="" decoding="async" />' +
						'<figcaption class="restwell-lightbox__caption" data-lightbox-caption></figcaption>' +
					'</figure>' +
					'<div class="restwell-lightbox__strip" data-lightbox-strip></div>' +
				'</div>';
			document.body.appendChild(lightboxEl);

			lightboxImage = lightboxEl.querySelector('.restwell-lightbox__image');
			lightboxCaption = lightboxEl.querySelector('[data-lightbox-caption]');
			lightboxStatus = lightboxEl.querySelector('[data-lightbox-counter]');
			lightboxNav = lightboxEl.querySelector('[data-lightbox-nav]');
			lightboxStrip = lightboxEl.querySelector('[data-lightbox-strip]');
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
			var touchStartX = 0;
			var touchStartY = 0;
			lightboxEl.addEventListener('touchstart', function (e) {
				if (e.touches.length !== 1) {
					return;
				}
				touchStartX = e.touches[0].clientX;
				touchStartY = e.touches[0].clientY;
			}, { passive: true });
			lightboxEl.addEventListener('touchend', function (e) {
				if (e.changedTouches.length !== 1) {
					return;
				}
				var dx = e.changedTouches[0].clientX - touchStartX;
				var dy = e.changedTouches[0].clientY - touchStartY;
				if (Math.abs(dx) > 48 && Math.abs(dx) > Math.abs(dy) * 1.5) {
					showSlide(currentIndex + (dx < 0 ? 1 : -1));
				}
			}, { passive: true });
			lightboxEl.addEventListener('click', function (e) {
				if (e.target === lightboxEl) {
					closeLightbox();
				}
			});
			document.addEventListener('keydown', onLightboxKeydown);
			document.addEventListener('touchmove', preventBackgroundTouchMove, { passive: false });
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

		function preloadAdjacentSlides() {
			if (slides.length <= 1) {
				return;
			}
			var prevIndex = (currentIndex - 1 + slides.length) % slides.length;
			var nextIndex = (currentIndex + 1) % slides.length;
			[slides[prevIndex], slides[nextIndex]].forEach(function (adjacent) {
				if (!adjacent || !adjacent.url) {
					return;
				}
				var preload = new Image();
				preload.decoding = 'async';
				preload.src = adjacent.url;
			});
		}

		function updateNavButtons() {
			if (!lightboxNav) {
				return;
			}
			/* Hide the whole prev/next cluster for single-image galleries. */
			lightboxNav.hidden = slides.length <= 1;
		}

		function renderStrip() {
			if (!lightboxStrip) {
				return;
			}
			lightboxStrip.replaceChildren();
			if (slides.length <= 1) {
				lightboxStrip.hidden = true;
				return;
			}
			lightboxStrip.hidden = false;
			slides.forEach(function (slide, index) {
				var thumb = document.createElement('button');
				thumb.type = 'button';
				thumb.className = 'restwell-lightbox__thumb';
				thumb.setAttribute('aria-label', 'Show image ' + (index + 1) + ' of ' + slides.length);
				var img = document.createElement('img');
				img.src = slide.url;
				img.alt = '';
				img.loading = 'lazy';
				img.decoding = 'async';
				thumb.appendChild(img);
				thumb.addEventListener('click', function () {
					showSlide(index);
				});
				lightboxStrip.appendChild(thumb);
			});
		}

		function syncStrip() {
			if (!lightboxStrip || lightboxStrip.hidden) {
				return;
			}
			var thumbs = lightboxStrip.children;
			for (var i = 0; i < thumbs.length; i++) {
				var isActive = i === currentIndex;
				thumbs[i].classList.toggle('is-active', isActive);
				thumbs[i].setAttribute('aria-current', isActive ? 'true' : 'false');
				if (isActive) {
					thumbs[i].scrollIntoView({ block: 'nearest', inline: 'nearest' });
				}
			}
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

			lightboxImage.classList.add('is-loading');
			lightboxImage.onload = function () {
				lightboxImage.classList.remove('is-loading');
			};
			lightboxImage.onerror = function () {
				lightboxImage.classList.remove('is-loading');
			};
			lightboxImage.src = slide.url;
			lightboxImage.alt = slide.alt || '';
			if (lightboxImage.complete) {
				lightboxImage.classList.remove('is-loading');
			}

			if (lightboxCaption) {
				lightboxCaption.textContent = slide.alt || '';
				lightboxCaption.hidden = !slide.alt;
			}
			if (lightboxStatus) {
				lightboxStatus.textContent = (currentIndex + 1) + ' / ' + slides.length;
			}
			updateNavButtons();
			syncStrip();
			preloadAdjacentSlides();
		}

		function openLightbox(nextSlides, startIndex) {
			if (!nextSlides.length) {
				return;
			}
			ensureLightbox();
			lastFocus = document.activeElement;
			slides = nextSlides;
			renderStrip();
			lightboxEl.removeAttribute('hidden');
			lockPageScroll();
			showSlide(startIndex);
			if (lightboxClose) {
				lightboxClose.focus();
			}
		}

		function closeLightbox() {
			if (!lightboxEl) {
				return;
			}
			lightboxEl.setAttribute('hidden', '');
			unlockPageScroll();
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
				if (!link || !gallery.contains(link)) {
					return;
				}
				e.preventDefault();
				e.stopPropagation();
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
				if (!trigger || trigger.tagName !== 'BUTTON' || !gallery.contains(trigger)) {
					return;
				}
				e.preventDefault();
				e.stopPropagation();
				var index = parseInt(trigger.getAttribute('data-gallery-index'), 10);
				if (isNaN(index)) {
					index = 0;
				}
				openLightbox(parsed, index);
			});
		});
	}

	ready(function () {
		safeInit('initRestwellGalleryCarousel', initRestwellGalleryCarousel);
		safeInit('initRestwellGalleryLightbox', initRestwellGalleryLightbox);
	});
})();
