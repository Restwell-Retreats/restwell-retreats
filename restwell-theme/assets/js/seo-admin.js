/**
 * Restwell SEO Admin - meta box JavaScript
 *
 * Handles:
 *  - Character counters (title + description)  with traffic-light colouring
 *  - Live SERP preview update
 *  - Social card tab switching and live preview sync
 *  - OG image picker via wp.media
 */
/* global rwSeoAdmin, wp */
(function () {
  'use strict';

  /* ── Helpers ──────────────────────────────────────────────────────────── */
  function byId(id) {
    return document.getElementById(id);
  }

  function clamp(str, max) {
    return str.length > max ? str.substring(0, max) + '…' : str;
  }

  /* ── Counter ──────────────────────────────────────────────────────────── */
  /**
   * @param {HTMLElement} input      The text input / textarea
   * @param {HTMLElement} counterEl  The <p> counter element
   * @param {number}      max        Max ideal length
   * @param {{ min?: number, max?: number }} ideal
   */
  function initCounter(input, counterEl, max, ideal) {
    if (!input || !counterEl) return;

    var valEl = counterEl.querySelector('.rw-seo__counter-val');

    function update() {
      var len = input.value.length;
      valEl.textContent = len;

      counterEl.classList.remove('rw-seo__counter--ok', 'rw-seo__counter--warn', 'rw-seo__counter--bad');

      if (ideal && len >= ideal.min && len <= ideal.max) {
        counterEl.classList.add('rw-seo__counter--ok');
      } else if (ideal && len >= ideal.min - 10) {
        counterEl.classList.add('rw-seo__counter--warn');
      } else {
        counterEl.classList.add('rw-seo__counter--bad');
      }
    }

    input.addEventListener('input', update);
    update();
  }

  /* ── SERP + social sync ───────────────────────────────────────────────── */
  function initPreviews() {
    var titleInput = byId('rw_meta_title');
    var descInput  = byId('rw_meta_description');

    if (!titleInput || !descInput) return;

    var serpTitle = byId('rw-serp-title');
    var serpDesc  = byId('rw-serp-desc');
    var fbTitle   = byId('rw-social-fb-title');
    var fbDesc    = byId('rw-social-fb-desc');
    var twTitle   = byId('rw-social-tw-title');
    var twDesc    = byId('rw-social-tw-desc');

    // Fallback: read the placeholder (which is the raw post title).
    var postTitle = titleInput.getAttribute('placeholder') || '';

    function updatePreviews() {
      var title = titleInput.value || postTitle;
      var desc  = descInput.value;

      if (serpTitle) serpTitle.textContent = clamp(title, 60);
      if (serpDesc)  serpDesc.textContent  = clamp(desc, 160);
      if (fbTitle)   fbTitle.textContent   = clamp(title, 60);
      if (fbDesc)    fbDesc.textContent    = clamp(desc, 160);
      if (twTitle)   twTitle.textContent   = clamp(title, 60);
      if (twDesc)    twDesc.textContent    = clamp(desc, 120);
    }

    titleInput.addEventListener('input', updatePreviews);
    descInput.addEventListener('input', updatePreviews);
    updatePreviews();
  }

  /* ── Social tabs ──────────────────────────────────────────────────────── */
  function initSocialTabs() {
    var tabs = document.querySelectorAll('.rw-seo__tab');
    if (!tabs.length) return;

    var fbPanel = byId('rw-social-fb');
    var twPanel = byId('rw-social-tw');

    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        tabs.forEach(function (t) { t.classList.remove('rw-seo__tab--active'); });
        tab.classList.add('rw-seo__tab--active');

        var target = tab.getAttribute('data-tab');
        if (fbPanel) fbPanel.style.display = (target === 'facebook') ? '' : 'none';
        if (twPanel) twPanel.style.display = (target === 'twitter')  ? '' : 'none';
      });
    });
  }

  /* ── OG image picker ──────────────────────────────────────────────────── */
  function initOgImage() {
    var chooseBtn = byId('rw-og-choose');
    var removeBtn = byId('rw-og-remove');
    var hiddenId  = byId('rw_og_image_id');
    var thumbEl   = byId('rw-og-thumb');
    var fbImgEl   = byId('rw-social-fb-img');
    var twImgEl   = byId('rw-social-tw-img');

    if (!chooseBtn || !hiddenId) return;

    var frame;

    /**
     * Build a preview <img> element. DOM APIs instead of innerHTML string
     * concatenation so the URL can never be interpreted as markup.
     *
     * @param {string} url - Attachment image URL.
     * @param {string} alt - Alt text for the preview.
     * @returns {HTMLImageElement}
     */
    function buildPreviewImg(url, alt) {
      var img = document.createElement('img');
      img.src = url;
      img.alt = alt;
      return img;
    }

    function setImage(id, url) {
      if (!hiddenId) return;
      hiddenId.value = id;

      // Thumb.
      if (thumbEl) {
        thumbEl.replaceChildren(buildPreviewImg(url, 'Selected social image'));
      }

      // Social previews.
      [fbImgEl, twImgEl].forEach(function (el) {
        if (el) el.replaceChildren(buildPreviewImg(url, 'Social image preview'));
      });

      // Show / update remove button.
      if (!removeBtn) {
        var actionsEl = chooseBtn.parentElement;
        if (actionsEl) {
          var btn = document.createElement('button');
          btn.type = 'button';
          btn.id = 'rw-og-remove';
          btn.className = 'button-link rw-seo__remove-btn';
          btn.textContent = rwSeoAdmin && rwSeoAdmin.removeImage ? rwSeoAdmin.removeImage : 'Remove';
          actionsEl.appendChild(btn);
          btn.addEventListener('click', removeImage);
        }
      }
    }

    function removeImage() {
      if (!hiddenId) return;
      hiddenId.value = '0';
      if (thumbEl) thumbEl.innerHTML = '';
      [fbImgEl, twImgEl].forEach(function (el) {
        if (el) el.innerHTML = '<span class="rw-seo__social-placeholder">No image set</span>';
      });
      var rb = byId('rw-og-remove');
      if (rb) rb.remove();
    }

    chooseBtn.addEventListener('click', function () {
      if (frame) {
        frame.open();
        return;
      }

      frame = wp.media({
        title:    rwSeoAdmin ? rwSeoAdmin.chooseImage : 'Choose image',
        button:   { text: rwSeoAdmin ? rwSeoAdmin.useImage : 'Use image' },
        multiple: false,
      });

      frame.on('select', function () {
        var attachment = frame.state().get('selection').first().toJSON();
        var url = (attachment.sizes && attachment.sizes.large)
          ? attachment.sizes.large.url
          : attachment.url;
        setImage(attachment.id, url);
      });

      frame.open();
    });

    if (removeBtn) {
      removeBtn.addEventListener('click', removeImage);
    }
  }

  /* ── Live analysis (client-side re-run as the editor types) ─────────── */
  /**
   * Re-run the SEO analysis on the server while the fields change.
   *
   * The rules live in PHP only (restwell_seo_admin_run_checks), shared with the
   * SEO table, so the editor and the table can never disagree again.
   */
  function initLiveAnalysis() {
    var checksEl = byId('rw-seo-checks');
    var rootEl   = byId('rw-seo-root');
    if (!checksEl || !rootEl || !window.ajaxurl || !window.fetch) return;

    var titleInput = byId('rw_meta_title');
    var descInput  = byId('rw_meta_description');
    var kpInput    = byId('rw_focus_keyphrase');
    if (!titleInput || !descInput || !kpInput) return;

    var timer = null;
    var latest = 0;

    function recheck() {
      var ticket = ++latest;
      var data = new FormData();
      data.append('action', 'restwell_seo_live_checks');
      data.append('post_id', rootEl.getAttribute('data-post-id') || '');
      data.append('nonce', rootEl.getAttribute('data-checks-nonce') || '');
      data.append('focus_keyphrase', kpInput.value);
      data.append('meta_title', titleInput.value);
      data.append('meta_description', descInput.value);
      fetch(window.ajaxurl, { method: 'POST', body: data, credentials: 'same-origin' })
        .then(function (r) { return r.json(); })
        .then(function (res) {
          // Ignore answers to older keystrokes.
          if (ticket === latest && res && res.success && res.data && typeof res.data.html === 'string') {
            checksEl.innerHTML = res.data.html;
          }
        })
        .catch(function () { /* Keep the last result; saving re-runs the checks. */ });
    }

    function queue() {
      window.clearTimeout(timer);
      timer = window.setTimeout(recheck, 400);
    }

    titleInput.addEventListener('input', queue);
    descInput.addEventListener('input', queue);
    kpInput.addEventListener('input', queue);
  }

  /**
   * List the schema types the live page actually outputs, read from its JSON-LD.
   */
  function initSchemaPanel() {
    var listEl = byId('rw-seo-schema');
    var rootEl = byId('rw-seo-root');
    var url = rootEl ? rootEl.getAttribute('data-page-url') : '';
    if (!listEl || !url || !window.fetch || !window.DOMParser) return;

    function show(items) {
      listEl.innerHTML = '';
      items.forEach(function (text) {
        var li = document.createElement('li');
        li.className = 'rw-seo__schema-item rw-seo__schema-item--on';
        li.textContent = text;
        listEl.appendChild(li);
      });
    }

    function collect(node, out) {
      if (!node || typeof node !== 'object') return;
      if (Array.isArray(node)) { node.forEach(function (n) { collect(n, out); }); return; }
      var type = node['@type'];
      (Array.isArray(type) ? type : [type]).forEach(function (t) {
        if (t && out.indexOf(t) < 0) out.push(t);
      });
      if (node['@graph']) collect(node['@graph'], out);
    }

    fetch(url, { credentials: 'same-origin' })
      .then(function (r) { return r.text(); })
      .then(function (html) {
        var doc = new DOMParser().parseFromString(html, 'text/html');
        var types = [];
        doc.querySelectorAll('script[type="application/ld+json"]').forEach(function (el) {
          try { collect(JSON.parse(el.textContent), types); } catch (e) { /* Skip a broken block. */ }
        });
        show(types.length ? types : ['No structured data found on the live page']);
      })
      .catch(function () { show(['Could not read the live page']); });
  }

  /* ── Init ─────────────────────────────────────────────────────────────── */
  function init() {
    var titleInput   = byId('rw_meta_title');
    var descInput    = byId('rw_meta_description');
    var titleCounter = byId('rw-title-counter');
    var descCounter  = byId('rw-desc-counter');

    // Same ranges as the PHP checks: title 30–60, description 120–160.
    initCounter(titleInput, titleCounter, 60, { min: 30, max: 60 });
    initCounter(descInput,  descCounter,  160, { min: 120, max: 160 });
    initPreviews();
    initSocialTabs();
    initOgImage();
    initLiveAnalysis();
    initSchemaPanel();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
}());
