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

    function setLightboxBackgroundInert(isInert) {
      Array.prototype.forEach.call(document.body.children, function (el) {
        if (el === lightbox || el.id === 'wpadminbar') return;
        if (isInert) el.setAttribute('inert', '');
        else el.removeAttribute('inert');
      });
    }

    function openLightbox(startIndex) {
      lastFocus = document.activeElement;
      showSlide(typeof startIndex === 'number' ? startIndex : 0);
      lightbox.removeAttribute('hidden');
      document.documentElement.classList.add('lightbox-open');
      document.body.classList.add('lightbox-open');
      setLightboxBackgroundInert(true);
      closeBtn.focus();
    }

    function closeLightbox() {
      lightbox.setAttribute('hidden', '');
      document.documentElement.classList.remove('lightbox-open');
      document.body.classList.remove('lightbox-open');
      setLightboxBackgroundInert(false);
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

  /* ---------- FAQ accordion ----------
   * Instant open/close (no height animation). Mid-animation cancels were
   * leaving panels stuck closed/open on the FAQ page; class + hidden is enough.
   * Bind every [data-faq-accordion] root — pages can have more than one.
   */
  function setFaqItemOpen(item, isOpen) {
    if (!item) return;
    var trigger = item.querySelector('.faq-item__trigger');
    var panel = item.querySelector('.faq-item__panel');
    item.classList.toggle('is-open', !!isOpen);
    if (trigger) {
      trigger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    }
    if (panel) {
      if (isOpen) {
        panel.removeAttribute('hidden');
      } else {
        panel.setAttribute('hidden', '');
      }
      /* Clear any leftover inline styles from the previous animated version. */
      panel.style.height = '';
      panel.style.opacity = '';
      panel.style.overflow = '';
    }
  }

  function bindFaqAccordion(faqRoot) {
    if (!faqRoot || faqRoot.__faqBound) return;
    faqRoot.__faqBound = true;

    faqRoot.addEventListener('click', function (event) {
      var trigger = event.target.closest('.faq-item__trigger');
      if (!trigger || !faqRoot.contains(trigger)) return;

      event.preventDefault();
      var item = trigger.closest('.faq-item');
      if (!item || item.hidden) return;
      var willOpen = !item.classList.contains('is-open');

      faqRoot.querySelectorAll('.faq-item').forEach(function (other) {
        setFaqItemOpen(other, other === item && willOpen);
      });
    });
  }

  document.querySelectorAll('[data-faq-accordion]').forEach(bindFaqAccordion);

  /* ---------- FAQ category pills ---------- */
  var pillRoot = document.querySelector('[data-faq-filters]');
  var faqRootForFilters = pillRoot
    ? (pillRoot.closest('section') || document).querySelector('[data-faq-accordion]')
    : null;
  if (pillRoot && faqRootForFilters) {
    var faqCols = faqRootForFilters.querySelectorAll('.faq-list__col');
    pillRoot.addEventListener('click', function (event) {
      var btn = event.target.closest('button[data-filter]');
      if (!btn) return;
      var filter = btn.getAttribute('data-filter') || 'all';
      pillRoot.querySelectorAll('button[data-filter]').forEach(function (b) {
        var on = b === btn;
        b.classList.toggle('is-active', on);
        b.setAttribute('aria-pressed', on ? 'true' : 'false');
      });
      var visible = [];
      faqRootForFilters.querySelectorAll('.faq-item').forEach(function (item) {
        var cat = item.getAttribute('data-cat') || 'all';
        var show = filter === 'all' || cat === filter;
        item.hidden = !show;
        if (show) visible.push(item);
        setFaqItemOpen(item, false);
      });
      /* Two static columns in markup — rebalance visible items so one column
         does not go blank while the other keeps every match. */
      if (faqCols.length === 2) {
        var mid = Math.ceil(visible.length / 2);
        visible.forEach(function (item, i) {
          faqCols[i < mid ? 0 : 1].appendChild(item);
        });
      }
      /* Open the first visible item so a filtered view isn't a wall of +. */
      if (visible.length) {
        setFaqItemOpen(visible[0], true);
      }
    });
  }

  /* ---------- Wheelchair-width fit-check ---------- */
  var fitCheck = document.querySelector('[data-fit-check]');
  if (fitCheck) {
    var fitInput = fitCheck.querySelector('[data-fit-input]');
    var fitNumber = fitCheck.querySelector('[data-fit-number]');
    var fitSummary = fitCheck.querySelector('[data-fit-summary]');
    var fitGauges = fitCheck.querySelectorAll('[data-fit-gauge]');
    var fitUnitBtns = fitCheck.querySelectorAll('[data-fit-unit]');
    var fitMinLabel = fitCheck.querySelector('[data-fit-min-label]');
    var fitMaxLabel = fitCheck.querySelector('[data-fit-max-label]');
    var FIT_MIN = parseInt(fitInput.min, 10) || 500;
    var FIT_MAX = parseInt(fitInput.max, 10) || 1050;
    var MM_PER_IN = 25.4;
    var fitUnit = 'mm';

    var formatLength = function (mm) {
      if (fitUnit === 'in') {
        return (mm / MM_PER_IN).toFixed(1) + 'in';
      }
      return Math.round(mm) + 'mm';
    };

    var displayNumber = function (mm) {
      if (fitUnit === 'in') {
        return (mm / MM_PER_IN).toFixed(1);
      }
      return String(Math.round(mm));
    };

    var joinList = function (items) {
      if (items.length === 1) return items[0];
      return items.slice(0, -1).join(', ') + ' and ' + items[items.length - 1];
    };

    var syncNumberBounds = function () {
      if (!fitNumber) return;
      if (fitUnit === 'in') {
        fitNumber.min = (FIT_MIN / MM_PER_IN).toFixed(1);
        fitNumber.max = (FIT_MAX / MM_PER_IN).toFixed(1);
        fitNumber.step = '0.1';
      } else {
        fitNumber.min = String(FIT_MIN);
        fitNumber.max = String(FIT_MAX);
        fitNumber.step = '1';
      }
    };

    var renderFit = function (opts) {
      var skipNumber = opts && opts.skipNumber;
      var chairWidth = parseInt(fitInput.value, 10);
      var sliderPct = ((chairWidth - FIT_MIN) / (FIT_MAX - FIT_MIN)) * 100;
      fitInput.style.setProperty('--fit-slider-pct', sliderPct + '%');
      fitInput.setAttribute('aria-valuetext', formatLength(chairWidth));

      if (fitNumber && !skipNumber) {
        fitNumber.value = displayNumber(chairWidth);
      }
      if (fitMinLabel) fitMinLabel.textContent = formatLength(FIT_MIN);
      if (fitMaxLabel) fitMaxLabel.textContent = formatLength(FIT_MAX);

      var totalDoors = fitGauges.length;
      var failing = [];
      var tightOnes = [];

      fitGauges.forEach(function (gauge) {
        var doorWidth = parseInt(gauge.getAttribute('data-door-width'), 10);
        var fill = gauge.querySelector('[data-fit-fill]');
        var spec = gauge.querySelector('[data-fit-spec]');
        var result = gauge.querySelector('[data-fit-result]');
        var name = gauge.getAttribute('data-fit-name');

        var fillPct = Math.min((chairWidth / doorWidth) * 100, 100);
        fill.style.width = fillPct + '%';
        if (spec) spec.textContent = formatLength(doorWidth);

        var clearance = doorWidth - chairWidth;
        var fits = clearance >= 0;
        var tight = fits && clearance < 50;
        gauge.classList.toggle('fit-bar--tight', tight);
        gauge.classList.toggle('fit-bar--no', !fits);
        if (!fits) {
          result.textContent = 'Short by ' + formatLength(Math.abs(clearance)) + '.';
          failing.push(name);
        } else if (tight) {
          result.textContent = 'Tight: ' + formatLength(clearance) + ' clearance.';
          tightOnes.push(name);
        } else {
          result.textContent = formatLength(clearance) + ' clearance.';
        }
      });

      var summaryState = 'ok';
      var summaryText = 'Comfortable clearance at both doors.';
      if (failing.length) {
        summaryState = 'no';
        summaryText = failing.length === totalDoors
          ? 'This width is wider than both doorways.'
          : 'This width is wider than ' + joinList(failing) + '.';
      } else if (tightOnes.length) {
        summaryState = 'tight';
        summaryText = tightOnes.length === totalDoors
          ? 'Tight clearance at both doors.'
          : 'Tight clearance at ' + joinList(tightOnes) + '.';
      }
      fitSummary.textContent = summaryText;
      fitSummary.classList.toggle('fit-check__summary--tight', summaryState === 'tight');
      fitSummary.classList.toggle('fit-check__summary--no', summaryState === 'no');
    };

    var commitNumber = function () {
      if (!fitNumber) return;
      var raw = parseFloat(fitNumber.value);
      if (isNaN(raw)) {
        renderFit();
        return;
      }
      var mm = fitUnit === 'in' ? raw * MM_PER_IN : raw;
      mm = Math.round(Math.min(FIT_MAX, Math.max(FIT_MIN, mm)));
      fitInput.value = String(mm);
      renderFit();
    };

    fitInput.addEventListener('input', function () {
      renderFit();
    });

    if (fitNumber) {
      fitNumber.addEventListener('input', function () {
        var raw = parseFloat(fitNumber.value);
        if (isNaN(raw)) return;
        var mm = fitUnit === 'in' ? raw * MM_PER_IN : raw;
        mm = Math.round(Math.min(FIT_MAX, Math.max(FIT_MIN, mm)));
        fitInput.value = String(mm);
        renderFit({ skipNumber: true });
      });
      fitNumber.addEventListener('change', commitNumber);
    }

    fitUnitBtns.forEach(function (btn) {
      btn.addEventListener('click', function () {
        if (btn.getAttribute('data-fit-unit') === fitUnit) return;
        fitUnit = btn.getAttribute('data-fit-unit');
        fitUnitBtns.forEach(function (b) {
          b.setAttribute('aria-pressed', b === btn ? 'true' : 'false');
        });
        syncNumberBounds();
        renderFit();
      });
    });

    syncNumberBounds();
    renderFit();

    var fitSection = fitCheck.closest('#fit-check') || document;
    fitSection.querySelectorAll('[data-fit-preset]').forEach(function (presetBtn) {
      presetBtn.addEventListener('click', function () {
        var mm = parseInt(presetBtn.getAttribute('data-fit-preset'), 10);
        if (isNaN(mm)) return;
        fitInput.value = String(Math.min(FIT_MAX, Math.max(FIT_MIN, mm)));
        renderFit();
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
  var isInterior = document.body.classList.contains('page--interior')
    && !document.body.classList.contains('has-photo-hero');

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
      /* threshold requires that fraction of the ELEMENT's own height to be
         visible, not the viewport's — a tall mobile-stacked section (e.g. a
         3-card grid) can sit visibly on screen yet never reach 15% of its
         own height, leaving it permanently opacity:0. threshold:0 fires on
         any overlap instead, so height no longer matters. */
      var revealObserver = new IntersectionObserver(
        function (entries) {
          entries.forEach(function (entry) {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('is-inview');
            revealObserver.unobserve(entry.target);
          });
        },
        { rootMargin: '0px 0px -8% 0px', threshold: 0 }
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

  /* ---------- OTP code inputs (guest guide) ---------- */
  var otpGroups = document.querySelectorAll('[data-otp-group]');
  if (otpGroups.length) {
    otpGroups.forEach(function (group) {
      var otpInputs = Array.prototype.slice.call(group.querySelectorAll('input'));
      if (!otpInputs.length) return;
      var form = group.closest('form');
      var hidden = form ? form.querySelector('[data-otp-value]') : null;

      function syncHidden() {
        if (!hidden) return;
        hidden.value = otpInputs.map(function (i) { return i.value || ''; }).join('');
        hidden.disabled = false;
      }

      if (form) {
        form.addEventListener('submit', syncHidden);
      }

      otpInputs.forEach(function (input, index) {
        input.addEventListener('input', function () {
          input.value = input.value.replace(/[^0-9]/g, '').slice(0, 1);
          syncHidden();
          if (!input.value) return;
          var next = otpInputs[index + 1];
          if (next) {
            next.focus();
          } else if (form && otpInputs.every(function (i) { return i.value; })) {
            syncHidden();
            if (form.requestSubmit) form.requestSubmit();
            else form.submit();
          }
        });

        input.addEventListener('keydown', function (event) {
          if (event.key === 'Backspace' && !input.value && index > 0) {
            otpInputs[index - 1].focus();
          }
        });

        input.addEventListener('paste', function (event) {
          var pasted = (event.clipboardData || window.clipboardData).getData('text');
          var digits = (pasted || '').replace(/[^0-9]/g, '').split('');
          if (!digits.length) return;
          event.preventDefault();
          otpInputs.forEach(function (i) { i.value = ''; });
          digits.slice(0, otpInputs.length).forEach(function (digit, i) {
            otpInputs[i].value = digit;
          });
          syncHidden();
          var lastFilled = Math.min(digits.length, otpInputs.length) - 1;
          if (lastFilled === otpInputs.length - 1) {
            if (form) {
              if (form.requestSubmit) form.requestSubmit();
              else form.submit();
            }
          } else if (lastFilled >= 0) {
            otpInputs[lastFilled + 1].focus();
          }
        });
      });
    });
  }

  /* ---------- Guest guide keysafe reveal + print ---------- */
  var keysafeBtn = document.getElementById('gg-keysafe-reveal');
  var keysafeVal = document.getElementById('gg-keysafe-value');
  if (keysafeBtn && keysafeVal) {
    keysafeBtn.addEventListener('click', function () {
      var revealed = keysafeBtn.getAttribute('aria-expanded') === 'true';
      if (revealed) {
        keysafeVal.classList.add('is-blurred');
        keysafeBtn.setAttribute('aria-expanded', 'false');
        keysafeBtn.textContent = keysafeBtn.getAttribute('data-label-reveal') || 'Tap to reveal';
      } else {
        keysafeVal.classList.remove('is-blurred');
        keysafeBtn.setAttribute('aria-expanded', 'true');
        keysafeBtn.textContent = keysafeBtn.getAttribute('data-label-hide') || 'Hide';
      }
    });
  }
  document.querySelectorAll('[data-gg-print]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      window.print();
    });
  });

  /* ---------- Multi-step enquiry form ---------- */
  var multistep = document.querySelector('[data-multistep]');
  if (multistep) {
    var msForm = multistep.querySelector('[data-multistep-form]');
    var msPanels = Array.prototype.slice.call(multistep.querySelectorAll('.form-step'));
    var msIndicatorItems = Array.prototype.slice.call(multistep.querySelectorAll('[data-step-item]'));
    var msConnectors = Array.prototype.slice.call(multistep.querySelectorAll('.step-indicator__connector'));
    var msSuccess = multistep.querySelector('[data-step-success]');
    var msCurrent = 1;

    function msPanelFor(step) {
      return msPanels.filter(function (panel) {
        return Number(panel.getAttribute('data-step-panel')) === step;
      })[0];
    }

    /*
     * Marks every failing [required] field in the panel — red border/outline
     * plus its paired .field-error (via aria-describedby) un-hidden — rather
     * than relying only on the browser's reportValidity() bubble, which is
     * inconsistent across browsers and easy to miss on a checkbox.
     * Returns the first invalid field, or null if the panel is clean.
     */
    function msValidatePanel(panel) {
      if (!panel) return null;
      var fields = Array.prototype.slice.call(panel.querySelectorAll('[required]'));
      var firstInvalid = null;
      fields.forEach(function (input) {
        var wrapper = input.closest('.field');
        var ok = input.checkValidity();
        if (wrapper) wrapper.classList.toggle('is-invalid', !ok);
        input.setAttribute('aria-invalid', ok ? 'false' : 'true');
        var errorId = input.getAttribute('aria-describedby');
        var errorEl = errorId ? document.getElementById(errorId) : null;
        if (errorEl) errorEl.hidden = ok;
        if (!ok && !firstInvalid) firstInvalid = input;
      });
      return firstInvalid;
    }

    multistep.addEventListener('input', msClearFieldError);
    multistep.addEventListener('change', msClearFieldError);
    function msClearFieldError(event) {
      var input = event.target;
      var wrapper = input.closest ? input.closest('.field') : null;
      if (!wrapper || !wrapper.classList.contains('is-invalid') || !input.checkValidity()) return;
      wrapper.classList.remove('is-invalid');
      input.setAttribute('aria-invalid', 'false');
      var errorId = input.getAttribute('aria-describedby');
      var errorEl = errorId ? document.getElementById(errorId) : null;
      if (errorEl) errorEl.hidden = true;
    }

    function msGoToStep(step) {
      msCurrent = step;
      msPanels.forEach(function (panel) {
        panel.hidden = Number(panel.getAttribute('data-step-panel')) !== step;
      });
      msIndicatorItems.forEach(function (item) {
        var n = Number(item.getAttribute('data-step-item'));
        item.classList.toggle('is-current', n === step);
        item.classList.toggle('is-complete', n < step);
        if (n === step) item.setAttribute('aria-current', 'step');
        else item.removeAttribute('aria-current');
      });
      msConnectors.forEach(function (connector, i) {
        connector.classList.toggle('is-complete', i < step - 1);
      });
      var panel = msPanelFor(step);
      var firstField = panel ? panel.querySelector('input, select, textarea') : null;
      if (firstField) window.setTimeout(function () { firstField.focus(); }, 10);
      multistep.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    multistep.addEventListener('click', function (event) {
      var next = event.target.closest('[data-step-next]');
      var prev = event.target.closest('[data-step-prev]');
      if (next) {
        var invalid = msValidatePanel(msPanelFor(msCurrent));
        if (invalid) {
          invalid.focus();
          return;
        }
        msGoToStep(msCurrent + 1);
      } else if (prev) {
        msGoToStep(msCurrent - 1);
      }
    });

    if (msForm) {
      msForm.addEventListener('submit', function (event) {
        var invalid = msValidatePanel(msPanelFor(msCurrent));
        if (invalid) {
          event.preventDefault();
          invalid.focus();
          return;
        }
        // Live WordPress enquire form: allow native POST after validation.
        if (msForm.getAttribute('data-live-submit') === '1') {
          return;
        }
        event.preventDefault();
        msIndicatorItems.forEach(function (item) {
          item.classList.add('is-complete');
          item.classList.remove('is-current');
          item.removeAttribute('aria-current');
        });
        msConnectors.forEach(function (connector) { connector.classList.add('is-complete'); });
        msForm.hidden = true;
        if (msSuccess) {
          msSuccess.hidden = false;
          msSuccess.scrollIntoView({ behavior: 'smooth', block: 'start' });
          msSuccess.focus();
        }
      });
    }

    var msRestart = msSuccess ? msSuccess.querySelector('[data-step-restart]') : null;
    if (msRestart) {
      msRestart.addEventListener('click', function () {
        if (msForm) {
          msForm.reset();
          msForm.hidden = false;
        }
        msSuccess.hidden = true;
        msGoToStep(1);
      });
    }
  }

  /* Keep focused chips in view inside horizontally scrolling subnav / FAQ filters. */
  document.addEventListener('focusin', function (event) {
    var el = event.target;
    if (!el || !el.closest) return;
    var scroller = el.closest('.subnav__list, .pill-tabs');
    if (!scroller) return;
    if (typeof el.scrollIntoView === 'function') {
      el.scrollIntoView({ inline: 'nearest', block: 'nearest' });
    }
  });

})();
