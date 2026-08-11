/**
 * Shared mockup behaviours: mobile nav, desktop nav dropdowns, FAQ accordion,
 * gallery lightbox, interior/home header solidify.
 */
(function () {
  'use strict';

  /* ---------- Gallery lightbox ---------- */
  var gallery = document.querySelector('[data-gallery]');
  var lightbox = document.getElementById('gallery-lightbox');
  if (gallery && lightbox) {
    var imageEl = lightbox.querySelector('[data-lightbox-image]');
    var captionEl = lightbox.querySelector('[data-lightbox-caption]');
    var statusEl = lightbox.querySelector('[data-lightbox-status]');
    var closeBtn = lightbox.querySelector('[data-lightbox-close]');
    var prevBtn = lightbox.querySelector('[data-lightbox-prev]');
    var nextBtn = lightbox.querySelector('[data-lightbox-next]');
    var slides = Array.prototype.map.call(
      gallery.querySelectorAll('.gallery__open img'),
      function (img) {
        return {
          url: img.currentSrc || img.src,
          alt: img.alt || ''
        };
      }
    );
    var index = 0;
    var lastFocus = null;

    function showSlide(nextIndex) {
      if (!slides.length) return;
      index = (nextIndex + slides.length) % slides.length;
      var slide = slides[index];
      imageEl.src = slide.url;
      imageEl.alt = slide.alt;
      captionEl.textContent = slide.alt;
      captionEl.hidden = !slide.alt;
      statusEl.textContent = (index + 1) + ' / ' + slides.length;
    }

    function openLightbox(startIndex) {
      lastFocus = document.activeElement;
      showSlide(typeof startIndex === 'number' ? startIndex : 0);
      lightbox.removeAttribute('hidden');
      document.documentElement.classList.add('lightbox-open');
      document.body.classList.add('lightbox-open');
      closeBtn.focus();
    }

    function closeLightbox() {
      lightbox.setAttribute('hidden', '');
      document.documentElement.classList.remove('lightbox-open');
      document.body.classList.remove('lightbox-open');
      imageEl.removeAttribute('src');
      if (lastFocus && typeof lastFocus.focus === 'function') {
        lastFocus.focus();
      }
    }

    gallery.addEventListener('click', function (event) {
      var trigger = event.target.closest('[data-gallery-open]');
      if (!trigger || !gallery.contains(trigger)) return;
      var start = parseInt(trigger.getAttribute('data-gallery-index'), 10);
      openLightbox(isNaN(start) ? 0 : start);
    });

    closeBtn.addEventListener('click', closeLightbox);
    function onNavActivate(button, delta) {
      showSlide(index + delta);
      window.setTimeout(function () { button.blur(); }, 0);
    }
    prevBtn.addEventListener('click', function () { onNavActivate(prevBtn, -1); });
    nextBtn.addEventListener('click', function () { onNavActivate(nextBtn, 1); });
    lightbox.addEventListener('click', function (event) {
      if (event.target === lightbox) closeLightbox();
    });

    document.addEventListener('keydown', function (event) {
      if (lightbox.hasAttribute('hidden')) return;
      if (event.key === 'Escape') {
        event.preventDefault();
        closeLightbox();
      } else if (event.key === 'ArrowLeft') {
        event.preventDefault();
        showSlide(index - 1);
      } else if (event.key === 'ArrowRight') {
        event.preventDefault();
        showSlide(index + 1);
      }
    });
  }

  /* ---------- FAQ accordion ---------- */
  var faqRoot = document.querySelector('[data-faq-accordion]');
  if (faqRoot) {
    faqRoot.addEventListener('click', function (event) {
      var trigger = event.target.closest('.faq-item__trigger');
      if (!trigger || !faqRoot.contains(trigger)) return;

      var item = trigger.closest('.faq-item');
      var willOpen = !item.classList.contains('is-open');

      faqRoot.querySelectorAll('.faq-item').forEach(function (other) {
        var otherTrigger = other.querySelector('.faq-item__trigger');
        var otherPanel = other.querySelector('.faq-item__panel');
        var isTarget = other === item && willOpen;
        other.classList.toggle('is-open', isTarget);
        if (otherTrigger) {
          otherTrigger.setAttribute('aria-expanded', isTarget ? 'true' : 'false');
        }
        if (otherPanel) {
          if (isTarget) otherPanel.removeAttribute('hidden');
          else otherPanel.setAttribute('hidden', '');
        }
      });
    });
  }

  /* ---------- FAQ category pills ---------- */
  var pillRoot = document.querySelector('[data-faq-filters]');
  if (pillRoot && faqRoot) {
    pillRoot.addEventListener('click', function (event) {
      var btn = event.target.closest('button[data-filter]');
      if (!btn) return;
      var filter = btn.getAttribute('data-filter') || 'all';
      pillRoot.querySelectorAll('button').forEach(function (b) {
        var on = b === btn;
        b.classList.toggle('is-active', on);
        b.setAttribute('aria-selected', on ? 'true' : 'false');
      });
      faqRoot.querySelectorAll('.faq-item').forEach(function (item) {
        var cat = item.getAttribute('data-cat') || 'all';
        var show = filter === 'all' || cat === filter;
        item.hidden = !show;
      });
    });
  }

  /* ---------- Desktop dropdowns (The Bungalow, Plan your trip) ---------- */
  var dropdownItems = Array.prototype.slice.call(
    document.querySelectorAll('.nav__item--has-dropdown')
  );

  function closeDropdown(item) {
    if (!item) return;
    var trigger = item.querySelector('.nav__trigger');
    item.classList.remove('is-open');
    if (trigger) trigger.setAttribute('aria-expanded', 'false');
  }

  function closeAllDropdowns(except) {
    dropdownItems.forEach(function (item) {
      if (item !== except) closeDropdown(item);
    });
  }

  function openDropdown(item) {
    if (!item) return;
    var trigger = item.querySelector('.nav__trigger');
    closeAllDropdowns(item);
    item.classList.add('is-open');
    if (trigger) trigger.setAttribute('aria-expanded', 'true');
  }

  dropdownItems.forEach(function (item) {
    var trigger = item.querySelector('.nav__trigger');
    var menu = item.querySelector('.nav__dropdown');
    if (!trigger || !menu) return;

    trigger.addEventListener('click', function (event) {
      event.preventDefault();
      if (item.classList.contains('is-open')) closeDropdown(item);
      else openDropdown(item);
    });
  });

  if (dropdownItems.length) {
    document.addEventListener('click', function (event) {
      var inside = dropdownItems.some(function (item) {
        return item.contains(event.target);
      });
      if (!inside) closeAllDropdowns();
    });

    document.addEventListener('keydown', function (event) {
      if (event.key !== 'Escape') return;
      var openItem = dropdownItems.find(function (item) {
        return item.classList.contains('is-open');
      });
      if (!openItem) return;
      var openTrigger = openItem.querySelector('.nav__trigger');
      closeDropdown(openItem);
      if (openTrigger) openTrigger.focus();
    });
  }

  /* ---------- Mobile nav + header solidify ---------- */
  var toggle = document.querySelector('.nav-toggle');
  var panel = document.getElementById('mobile-nav');
  var header = document.querySelector('.site-header');
  var hero = document.querySelector('.hero');
  var isInterior = document.body.classList.contains('page--interior');

  if (toggle && panel && header) {
    function closeMenu() {
      panel.classList.remove('is-open');
      header.classList.remove('is-menu-open');
      document.body.classList.remove('nav-open');
      toggle.setAttribute('aria-expanded', 'false');
      toggle.setAttribute('aria-label', 'Open menu');
    }

    function openMenu() {
      panel.classList.add('is-open');
      header.classList.add('is-menu-open');
      document.body.classList.add('nav-open');
      toggle.setAttribute('aria-expanded', 'true');
      toggle.setAttribute('aria-label', 'Close menu');
    }

    function updateSolidHeader() {
      if (isInterior) {
        header.classList.add('is-solid');
        return;
      }
      /*
       * Solidify when hero copy is about to pass under the fixed header —
       * same probe on mobile and desktop. Use the visible copy, not
       * .hero__content (its padding-top sits under the header at rest).
       */
      var probe = hero
        ? (hero.querySelector('.hero__text') || hero.querySelector('.hero__content'))
        : null;
      if (probe) {
        var headerBottom = header.getBoundingClientRect().bottom;
        var probeTop = probe.getBoundingClientRect().top;
        header.classList.toggle('is-solid', probeTop <= headerBottom + 16);
        return;
      }
      header.classList.toggle('is-solid', window.scrollY > 48);
    }

    toggle.addEventListener('click', function () {
      if (panel.classList.contains('is-open')) closeMenu();
      else openMenu();
    });

    panel.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', closeMenu);
    });

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape' && panel.classList.contains('is-open')) {
        closeMenu();
        toggle.focus();
      }
    });

    document.addEventListener('click', function (event) {
      if (
        panel.classList.contains('is-open') &&
        !panel.contains(event.target) &&
        !toggle.contains(event.target)
      ) {
        closeMenu();
      }
    });

    window.addEventListener('scroll', updateSolidHeader, { passive: true });
    window.addEventListener('resize', updateSolidHeader);
    updateSolidHeader();
  }

  /* ---------- Soft scroll reveal ---------- */
  var revealNodes = document.querySelectorAll('[data-reveal]');
  if (revealNodes.length) {
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduceMotion || !('IntersectionObserver' in window)) {
      revealNodes.forEach(function (node) {
        node.classList.add('is-inview');
      });
    } else {
      var revealObserver = new IntersectionObserver(
        function (entries) {
          entries.forEach(function (entry) {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('is-inview');
            revealObserver.unobserve(entry.target);
          });
        },
        { rootMargin: '0px 0px -8% 0px', threshold: 0.15 }
      );
      revealNodes.forEach(function (node) {
        revealObserver.observe(node);
      });
    }
  }

  /* ---------- Sticky TOC scroll-spy ---------- */
  var tocRoot = document.querySelector('[data-toc]');
  if (tocRoot) {
    var tocLinks = Array.prototype.slice.call(tocRoot.querySelectorAll('a[href^="#"]'));
    var tocSections = tocLinks
      .map(function (link) {
        var id = link.getAttribute('href').slice(1);
        return id ? document.getElementById(id) : null;
      })
      .filter(Boolean);

    function setActiveToc(id) {
      tocLinks.forEach(function (link) {
        var match = link.getAttribute('href') === '#' + id;
        link.classList.toggle('is-active', match);
        if (match) {
          link.setAttribute('aria-current', 'location');
        } else {
          link.removeAttribute('aria-current');
        }
      });
    }

    if (tocSections.length) {
      var tocPinnedUntil = 0;

      function tocMarkerY() {
        var header = document.querySelector('.site-header');
        var headerH = header ? header.offsetHeight : 0;
        var subnavH = tocRoot.offsetHeight || 0;
        /*
         * Reading line ~1/3 down the viewport (never above sticky chrome).
         * Activates the section you're looking at, not only once its top
         * kisses the header — short bands were losing to the previous item.
         */
        return Math.max(headerH + subnavH + 8, window.innerHeight * 0.33);
      }

      function syncActiveToc() {
        if (Date.now() < tocPinnedUntil) return;
        var marker = tocMarkerY();
        var current = tocSections[0].id;
        tocSections.forEach(function (section) {
          if (section.getBoundingClientRect().top <= marker) {
            current = section.id;
          }
        });
        setActiveToc(current);
      }

      /*
       * The subnav has no bounded containing block (its tab sections are
       * plain <main> siblings alongside whatever follows, e.g. a mid-cta),
       * so native sticky release never happens. Hide it once the last
       * tracked section has scrolled fully past, so it can't overlap
       * unrelated content below.
       */
      function syncSubnavVisibility() {
        var header = document.querySelector('.site-header');
        var headerH = header ? header.offsetHeight : 0;
        var subnavH = tocRoot.offsetHeight || 0;
        var lastSection = tocSections[tocSections.length - 1];
        var pastEnd = lastSection.getBoundingClientRect().bottom <= headerH + subnavH;
        tocRoot.classList.toggle('is-past-content', pastEnd);
      }

      var tocTicking = false;
      function requestTocSync() {
        if (tocTicking) return;
        tocTicking = true;
        window.requestAnimationFrame(function () {
          syncActiveToc();
          syncSubnavVisibility();
          tocTicking = false;
        });
      }

      window.addEventListener('scroll', requestTocSync, { passive: true });
      window.addEventListener('resize', requestTocSync);
      window.addEventListener('hashchange', requestTocSync);
      tocLinks.forEach(function (link) {
        link.addEventListener('click', function () {
          var id = (link.getAttribute('href') || '').slice(1);
          if (!id) return;
          setActiveToc(id);
          tocPinnedUntil = Date.now() + 500;
          window.setTimeout(requestTocSync, 520);
        });
      });
      syncActiveToc();
      syncSubnavVisibility();
    }
  }

})();
