/**
 * Comprehensive WP theme port audit: SEO + UI across pages and breakpoints.
 * Run: node restwell-theme/tools/_audit_wp_port.mjs
 */
import { chromium } from 'playwright';
import { writeFileSync } from 'fs';
import { fileURLToPath } from 'url';
import { dirname, join } from 'path';

const BASE = process.env.AUDIT_BASE || 'http://127.0.0.1:9401';
const BREAKPOINTS = [
  { name: '375', width: 375, height: 812 },
  { name: '768', width: 768, height: 1024 },
  { name: '1024', width: 1024, height: 800 },
  { name: '1280', width: 1280, height: 800 },
];

const PAGES = [
  { id: 'home', path: '/' },
  { id: 'our-story', path: '/our-story/' },
  { id: 'the-property', path: '/the-property/' },
  { id: 'accessibility', path: '/accessibility/' },
  { id: 'pricing', path: '/pricing/' },
  { id: 'how-it-works', path: '/how-it-works/' },
  { id: 'who-its-for', path: '/who-its-for/' },
  { id: 'whitstable', path: '/whitstable-area-guide/' },
  { id: 'resources', path: '/resources/' },
  { id: 'optional-care', path: '/optional-care/' },
  { id: 'faq', path: '/faq/' },
  { id: 'enquire', path: '/enquire/' },
  { id: 'blog', path: '/blog/' },
  { id: 'privacy', path: '/privacy-policy/' },
  { id: 'terms', path: '/terms-and-conditions/' },
  { id: 'a11y-policy', path: '/accessibility-policy/' },
  { id: '404', path: '/this-page-does-not-exist-audit-404/' },
  { id: 'guest-guide', path: '/guest-guide/' },
  { id: 'sample-page', path: '/sample-page/' },
];

const BANNED = [/fully[\s-]?accessible/gi];
const ALLOWED_RESPITE = /respite/i;

function severityFromIssues(issues) {
  if (issues.some((i) => i.sev === 'fail')) return 'fail';
  if (issues.some((i) => i.sev === 'warn')) return 'warn';
  return 'pass';
}

async function collectPage(page, meta) {
  const url = BASE + meta.path;
  const issues = [];
  let response;
  try {
    response = await page.goto(url, { waitUntil: 'domcontentloaded', timeout: 45000 });
  } catch (e) {
    return {
      id: meta.id,
      path: meta.path,
      status: 0,
      error: String(e.message || e),
      issues: [{ sev: 'fail', area: 'load', msg: String(e.message || e) }],
      overall: 'fail',
      breakpoints: {},
      seo: {},
    };
  }

  const status = response ? response.status() : 0;
  const finalUrl = page.url();

  const seo = await page.evaluate(() => {
    const q = (s) => document.querySelector(s);
    const qa = (s) => [...document.querySelectorAll(s)];
    const metaContent = (name) => {
      const el =
        q(`meta[name="${name}"]`) ||
        q(`meta[property="${name}"]`);
      return el ? (el.getAttribute('content') || '').trim() : '';
    };
    const title = document.title || '';
    const desc = metaContent('description');
    const robots = metaContent('robots');
    const canonical = q('link[rel="canonical"]')?.href || '';
    const ogTitle = metaContent('og:title');
    const ogDesc = metaContent('og:description');
    const ogImage = metaContent('og:image');
    const twitterCard = metaContent('twitter:card');
    const h1s = qa('h1').map((h) => (h.textContent || '').trim());
    const schemas = qa('script[type="application/ld+json"]').map((s) => {
      try {
        return JSON.parse(s.textContent || '');
      } catch {
        return { _parseError: true, raw: (s.textContent || '').slice(0, 120) };
      }
    });
    const bodyText = document.body?.innerText || '';
    const html = document.documentElement.outerHTML;
    const styles = [...document.styleSheets]
      .map((s) => s.href)
      .filter(Boolean);
    const hasShared = styles.some((h) => h.includes('shared.css'));
    const hasSharedWp = styles.some((h) => h.includes('shared-wp.css'));
    const hasTailwind = styles.some((h) => /tailwind/i.test(h));
    const bodyClass = document.body?.className || '';
    const skip = !!q('a.skip-link, a[href="#main-content"]');
    const main = !!q('#main-content, main');
    const logoFilter = q('.site-header .logo img')
      ? getComputedStyle(q('.site-header .logo img')).filter
      : '';
    const heroMedia = q('.hero__media');
    const heroBg = heroMedia ? getComputedStyle(heroMedia).backgroundImage : '';
    const imgs = qa('img').map((img) => ({
      src: img.currentSrc || img.src,
      alt: img.alt,
      w: img.naturalWidth,
      complete: img.complete,
    }));
    const brokenImgs = imgs.filter((i) => i.complete && i.w === 0 && i.src && !i.src.startsWith('data:'));
    const pendingImgs = imgs.filter((i) => !i.complete);
    return {
      title,
      titleLen: title.length,
      desc,
      descLen: desc.length,
      robots,
      canonical,
      ogTitle,
      ogDesc,
      ogImage,
      twitterCard,
      h1s,
      h1Count: h1s.length,
      schemaCount: schemas.length,
      schemaTypes: schemas.map((s) => {
        if (!s || s._parseError) return 'PARSE_ERROR';
        if (Array.isArray(s)) return s.map((x) => x['@type']).join(',');
        if (s['@graph']) return s['@graph'].map((x) => x['@type']).join(',');
        return s['@type'] || 'unknown';
      }),
      schemas,
      hasShared,
      hasSharedWp,
      hasTailwind,
      bodyClass,
      skip,
      main,
      logoFilter,
      heroBg,
      imgCount: imgs.length,
      brokenImgs: brokenImgs.map((i) => i.src),
      pendingImgs: pendingImgs.length,
      bodyTextSample: bodyText.slice(0, 500),
      htmlLen: html.length,
      fullyAccessibleHits: (html.match(/fully[\s-]?accessible/gi) || []).length,
      respiteHits: (bodyText.match(/respite/gi) || []).length,
    };
  });

  // SEO rules
  if (meta.id === '404') {
    if (![404, 200].includes(status)) {
      issues.push({ sev: 'warn', area: 'seo', msg: `Unexpected status ${status} for 404 path` });
    }
  } else if (meta.id === 'guest-guide') {
    // OTP gate may redirect/login — soft
  } else if (status >= 400) {
    issues.push({ sev: 'fail', area: 'seo', msg: `HTTP ${status}` });
  }

  if (!seo.title) issues.push({ sev: 'fail', area: 'seo', msg: 'Missing <title>' });
  else if (seo.titleLen > 65) issues.push({ sev: 'warn', area: 'seo', msg: `Title long (${seo.titleLen} chars)` });
  else if (seo.titleLen < 15) issues.push({ sev: 'warn', area: 'seo', msg: `Title short (${seo.titleLen} chars)` });

  if (!seo.desc && meta.id !== '404' && meta.id !== 'guest-guide') {
    issues.push({ sev: 'fail', area: 'seo', msg: 'Missing meta description' });
  } else if (seo.desc && (seo.descLen < 50 || seo.descLen > 160)) {
    issues.push({ sev: 'warn', area: 'seo', msg: `Meta description length ${seo.descLen} (target 50–160)` });
  }

  if (seo.h1Count === 0 && meta.id !== 'guest-guide') {
    issues.push({ sev: 'fail', area: 'seo', msg: 'No H1' });
  } else if (seo.h1Count > 1) {
    issues.push({ sev: 'warn', area: 'seo', msg: `Multiple H1s (${seo.h1Count})` });
  }

  if (meta.id !== '404' && meta.id !== 'guest-guide' && !seo.canonical) {
    issues.push({ sev: 'warn', area: 'seo', msg: 'Missing canonical' });
  }
  if (meta.id !== '404' && meta.id !== 'guest-guide' && !seo.ogTitle) {
    issues.push({ sev: 'warn', area: 'seo', msg: 'Missing og:title' });
  }
  if (meta.id !== '404' && meta.id !== 'guest-guide' && seo.schemaCount === 0) {
    issues.push({ sev: 'warn', area: 'seo', msg: 'No JSON-LD schema' });
  }
  if (seo.fullyAccessibleHits > 0) {
    issues.push({
      sev: 'fail',
      area: 'copy',
      msg: `Banned phrase "fully accessible" ×${seo.fullyAccessibleHits}`,
    });
  }
  if (seo.schemaTypes.includes('PARSE_ERROR')) {
    issues.push({ sev: 'fail', area: 'seo', msg: 'JSON-LD parse error' });
  }

  // Concept chrome expectations
  const expectConcept = !['guest-guide'].includes(meta.id);
  if (expectConcept && !seo.hasShared) {
    issues.push({ sev: 'fail', area: 'ui', msg: 'shared.css not loaded' });
  }
  if (expectConcept && seo.hasTailwind && !seo.bodyClass.includes('restwell-concept')) {
    issues.push({ sev: 'warn', area: 'ui', msg: 'Tailwind present without restwell-concept body class' });
  }
  if (expectConcept && seo.hasTailwind && seo.bodyClass.includes('restwell-concept')) {
    issues.push({ sev: 'fail', area: 'ui', msg: 'Tailwind still loaded on concept surface' });
  }
  if (!seo.skip) issues.push({ sev: 'warn', area: 'a11y', msg: 'Missing skip link' });
  if (!seo.main) issues.push({ sev: 'fail', area: 'a11y', msg: 'Missing main / #main-content' });
  if (seo.brokenImgs.length) {
    issues.push({
      sev: 'fail',
      area: 'ui',
      msg: `Broken images (${seo.brokenImgs.length}): ${seo.brokenImgs.slice(0, 3).join(', ')}`,
    });
  }
  if (meta.id === 'home' && seo.heroBg && seo.heroBg.includes('assets/assets/')) {
    issues.push({ sev: 'fail', area: 'ui', msg: 'Hero CSS path doubled assets/assets' });
  }
  if (meta.id === 'home' && seo.heroBg && (seo.heroBg === 'none' || !seo.heroBg.includes('url('))) {
    issues.push({ sev: 'fail', area: 'ui', msg: 'Home hero media has no background image' });
  }
  if (seo.logoFilter && !seo.logoFilter.includes('invert')) {
    issues.push({ sev: 'warn', area: 'ui', msg: 'Header logo not filtered to white' });
  }

  const breakpoints = {};
  for (const bp of BREAKPOINTS) {
    await page.setViewportSize({ width: bp.width, height: bp.height });
    await page.waitForTimeout(250);
    const layout = await page.evaluate((bpName) => {
      const doc = document.documentElement;
      const body = document.body;
      const scrollW = Math.max(doc.scrollWidth, body.scrollWidth);
      const clientW = doc.clientWidth;
      const overflowX = scrollW > clientW + 1;
      const header = document.querySelector('.site-header');
      const headerH = header ? header.getBoundingClientRect().height : 0;
      const nav = document.querySelector('.nav');
      const navDisplay = nav ? getComputedStyle(nav).display : 'none';
      const toggle = document.querySelector('.nav-toggle');
      const toggleDisplay = toggle ? getComputedStyle(toggle).display : 'none';
      const mobileNav = document.querySelector('.mobile-nav');
      const enquire = document.querySelector('.site-header .btn-gold');
      const enquireVisible = enquire ? getComputedStyle(enquire).display !== 'none' : false;
      // Focusable without size
      const tinyTargets = [...document.querySelectorAll('a, button')].filter((el) => {
        const r = el.getBoundingClientRect();
        if (r.width === 0 || r.height === 0) return false;
        return r.width < 24 || r.height < 24;
      }).length;
      // Elements overflowing viewport
      const overflowEls = [...document.querySelectorAll('section, .container, img, table')].filter((el) => {
        const r = el.getBoundingClientRect();
        return r.right > clientW + 2;
      }).length;
      return {
        bp: bpName,
        clientW,
        scrollW,
        overflowX,
        headerH,
        navDisplay,
        toggleDisplay,
        mobileNavExists: !!mobileNav,
        enquireVisible,
        tinyTargets,
        overflowEls,
      };
    }, bp.name);

    const bpIssues = [];
    if (layout.overflowX) {
      bpIssues.push({ sev: 'fail', area: 'ui', msg: `Horizontal overflow at ${bp.name} (scroll ${layout.scrollW} > ${layout.clientW})` });
    }
    if (bp.width < 1024 && layout.navDisplay !== 'none') {
      bpIssues.push({ sev: 'warn', area: 'ui', msg: `Desktop nav visible below 1024 at ${bp.name}` });
    }
    if (bp.width >= 1024 && layout.navDisplay === 'none' && expectConcept) {
      bpIssues.push({ sev: 'fail', area: 'ui', msg: `Desktop nav hidden at ${bp.name}` });
    }
    if (bp.width < 1024 && layout.toggleDisplay === 'none' && expectConcept) {
      bpIssues.push({ sev: 'fail', area: 'ui', msg: `Hamburger hidden at ${bp.name}` });
    }
    if (layout.tinyTargets > 8) {
      bpIssues.push({ sev: 'warn', area: 'a11y', msg: `${layout.tinyTargets} controls under 24px at ${bp.name}` });
    }
    breakpoints[bp.name] = { ...layout, issues: bpIssues };
    for (const i of bpIssues) issues.push(i);
  }

  // Reset viewport
  await page.setViewportSize({ width: 1280, height: 800 });

  return {
    id: meta.id,
    path: meta.path,
    status,
    finalUrl,
    seo: {
      title: seo.title,
      titleLen: seo.titleLen,
      desc: seo.desc,
      descLen: seo.descLen,
      robots: seo.robots,
      canonical: seo.canonical,
      ogTitle: seo.ogTitle,
      ogImage: !!seo.ogImage,
      twitterCard: seo.twitterCard,
      h1s: seo.h1s,
      h1Count: seo.h1Count,
      schemaCount: seo.schemaCount,
      schemaTypes: seo.schemaTypes,
      hasShared: seo.hasShared,
      hasSharedWp: seo.hasSharedWp,
      hasTailwind: seo.hasTailwind,
      bodyClass: seo.bodyClass,
      skip: seo.skip,
      main: seo.main,
      logoFilter: seo.logoFilter,
      heroOk: seo.heroBg.includes('url(') && !seo.heroBg.includes('assets/assets/'),
      brokenImgCount: seo.brokenImgs.length,
      brokenImgs: seo.brokenImgs.slice(0, 5),
      fullyAccessibleHits: seo.fullyAccessibleHits,
      respiteHits: seo.respiteHits,
    },
    breakpoints,
    issues,
    overall: severityFromIssues(issues),
  };
}

async function main() {
  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext();
  const page = await context.newPage();
  // Warm auto-login
  await page.goto(BASE + '/', { waitUntil: 'domcontentloaded', timeout: 60000 }).catch(() => {});

  const results = [];
  for (const meta of PAGES) {
    process.stderr.write(`Auditing ${meta.id}…\n`);
    results.push(await collectPage(page, meta));
  }

  await browser.close();

  const summary = {
    generatedAt: new Date().toISOString(),
    base: BASE,
    breakpoints: BREAKPOINTS.map((b) => b.name),
    totals: {
      pages: results.length,
      pass: results.filter((r) => r.overall === 'pass').length,
      warn: results.filter((r) => r.overall === 'warn').length,
      fail: results.filter((r) => r.overall === 'fail').length,
      issueCount: results.reduce((n, r) => n + r.issues.length, 0),
    },
    pages: results,
  };

  const out = join(dirname(fileURLToPath(import.meta.url)), '_audit_wp_port_results.json');
  writeFileSync(out, JSON.stringify(summary, null, 2));
  process.stderr.write(`Wrote ${out}\n`);
  console.log(JSON.stringify({ totals: summary.totals, fails: results.filter((r) => r.overall === 'fail').map((r) => ({ id: r.id, issues: r.issues })) }, null, 2));
}

main().catch((e) => {
  console.error(e);
  process.exit(1);
});
