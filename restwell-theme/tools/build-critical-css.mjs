#!/usr/bin/env node
// Extract the above-the-fold subset of assets/css/site.min.css, one file per
// template family, into assets/css/critical/<key>.min.css. inc/enqueue.php
// inlines the file for the current request's key (restwell_critical_css_key)
// and loads the full bundle without blocking first paint. A page whose key has
// no file keeps the normal blocking stylesheet.
//
// For each page × viewport it keeps every rule whose selector (minus
// interaction pseudo-classes and pseudo-elements) matches an element in the
// first screen, plus the outermost element of anything not rendered
// (display:none menus, dialogs) so hidden UI never flashes. :root tokens and @keyframes are always kept;
// @font-face is left to the bundle. Rules stay in source order inside their @media wrappers.
//
// Each file's first line copies site.min.css's source hash; tests/CssBundleTest
// fails when they differ, so rerun this after tools/build-css.sh.
//
// Needs Google Chrome and the site running (default http://localhost:9410).
// Usage: node restwell-theme/tools/build-critical-css.mjs [base-url]
import { spawn } from 'node:child_process';
import { mkdirSync, readdirSync, readFileSync, rmSync, writeFileSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';

const THEME = join(dirname(fileURLToPath(import.meta.url)), '..');
const BUNDLE = join(THEME, 'assets/css/site.min.css');
const OUT_DIR = join(THEME, 'assets/css/critical');
const BASE = (process.argv[2] || 'http://localhost:9410').replace(/\/$/, '');
const CHROME = process.env.CHROME || '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';

// One page per template family.
const PATHS = [
	'/', '/the-property/', '/accessibility/', '/how-it-works/', '/who-its-for/',
	'/whitstable-area-guide/', '/funding-and-support/', '/optional-care/', '/faq/',
	'/enquire/', '/our-story/', '/blog/', '/accessible-beaches-coastal-walks-kent/',
	'/terms-and-conditions/', '/privacy-policy/', '/accessibility-policy/',
	'/carers-respite-holiday-guide/', '/category/care-funding-respite/', '/no-such-page/', '/?s=hoist',
];
const VIEWPORTS = [[360, 780], [390, 844], [768, 1024], [1280, 900], [1440, 900]];

const bundleHead = readFileSync(BUNDLE, 'utf8').split('\n', 1)[0];
const hash = (bundleHead.match(/[0-9a-f]{40}/) || [''])[0];
if (!hash) throw new Error('site.min.css has no source hash on line 1; run tools/build-css.sh first.');

const port = 9500 + Math.floor(Math.random() * 400);
const chrome = spawn(CHROME, ['--headless=new', `--remote-debugging-port=${port}`, '--no-first-run',
	`--user-data-dir=/tmp/rw-critical-${port}`, '--hide-scrollbars', 'about:blank'], { stdio: 'ignore' });
const sleep = (ms) => new Promise((r) => setTimeout(r, ms));
for (let i = 0; i < 50; i++) { try { await fetch(`http://127.0.0.1:${port}/json/version`); break; } catch { await sleep(200); } }
const target = (await (await fetch(`http://127.0.0.1:${port}/json/list`)).json()).find((t) => t.type === 'page');
const ws = new WebSocket(target.webSocketDebuggerUrl);
await new Promise((r) => { ws.onopen = r; });
let seq = 0; const pending = new Map(); const events = [];
ws.onmessage = (m) => { const d = JSON.parse(m.data); if (d.id && pending.has(d.id)) { pending.get(d.id)(d); pending.delete(d.id); } else events.push(d); };
const send = (method, params = {}) => new Promise((r) => { const i = ++seq; pending.set(i, r); ws.send(JSON.stringify({ id: i, method, params })); });
await send('Page.enable'); await send('Runtime.enable'); await send('Network.enable');
// Logged-out view (Playground auto-logs-in without this cookie).
await send('Network.setCookie', { name: 'playground_auto_login_already_happened', value: '1', url: BASE });

// Runs in the page: flatten the bundle's rules and mark the ones the first screen uses.
const PROBE = `(() => {
	const sheet = [...document.styleSheets].find((s) => s.href && s.href.includes('site.min.css'));
	if (!sheet) return { error: 'site.min.css not found on page' };
	const cls = document.body.classList;
	let key = 'utility';
	if (cls.contains('home')) key = 'front';
	else if (cls.contains('single-post')) key = 'post';
	else if (cls.contains('page')) { const t = [...cls].find((c) => /^page-template-.+-php$/.test(c)); key = t ? t.replace(/^page-template-/, '').replace(/-php$/, '') : 'page'; }
	else if (cls.contains('blog') || cls.contains('archive')) key = 'blog';
	const H = innerHeight;
	const seen = new Set([document.documentElement, document.body]);
	for (const el of document.body.querySelectorAll('*')) {
		const r = el.getBoundingClientRect();
		const hidden = r.width === 0 && r.height === 0;
		// Unrendered UI: only its outermost element needs the rule that hides it.
		const hiddenRoot = hidden && el.parentElement && (() => { const pr = el.parentElement.getBoundingClientRect(); return pr.width > 0 || pr.height > 0; })();
		if (hiddenRoot || (!hidden && r.top < H)) {
			for (let n = el; n && !seen.has(n); n = n.parentElement) seen.add(n);
		}
	}
	// Siblings below the fold still shape the visible layout (flex/grid order,
	// placement), so direct children of a visible container count too.
	for (const el of [...seen]) for (const child of el.children) seen.add(child);
	const strip = (sel) => sel
		.replace(/::?(before|after|marker|placeholder|selection|backdrop|-webkit-[a-z-]+|-moz-[a-z-]+)/g, '')
		.replace(/:(hover|focus-visible|focus-within|focus|active|visited|target|checked|disabled|invalid|valid|placeholder-shown|user-invalid|autofill)(?![-\\w])/g, '')
		.replace(/:is\\(\\s*\\)|:where\\(\\s*\\)/g, '')
		.trim() || '*';
	const used = (selectorText) => selectorText.split(/,(?![^(]*\\))/).some((part) => {
		let s = strip(part);
		if (/^(\\*|html|body|:root)$/.test(s)) return true;
		try { for (const el of document.querySelectorAll(s)) if (seen.has(el)) return true; } catch (e) { return false; }
		return false;
	});
	const out = [];
	const walk = (rules, path, media) => {
		[...rules].forEach((rule, i) => {
			const p = path.concat(i);
			if (rule instanceof CSSMediaRule) { walk(rule.cssRules, p, rule.conditionText || rule.media.mediaText); return; }
			let keep = false;
			// @font-face stays in the bundle: inlined, it starts ~190 KB of fonts at
			// once and starves the hero image (lab LCP got worse).
			if (rule instanceof CSSKeyframesRule) keep = true;
			else if (rule instanceof CSSStyleRule) keep = used(rule.selectorText);
			out.push({ key: p.join('.'), media, keep, css: rule.cssText });
		});
	};
	walk(sheet.cssRules, [], null);
	return { key, rules: out };
})()`;

const byKey = new Map();
for (const [w, h] of VIEWPORTS) {
	await send('Emulation.setDeviceMetricsOverride', { width: w, height: h, deviceScaleFactor: 1, mobile: w < 768 });
	for (const path of PATHS) {
		events.length = 0;
		await send('Page.navigate', { url: BASE + path });
		for (let i = 0; i < 150 && !events.some((e) => e.method === 'Page.loadEventFired'); i++) await sleep(100);
		await sleep(400);
		const res = await send('Runtime.evaluate', { expression: PROBE, returnByValue: true });
		const val = res.result.result.value;
		if (!val || val.error) throw new Error(`${path} @${w}: ${val ? val.error : JSON.stringify(res.result.exceptionDetails)}`);
		if (!byKey.has(val.key)) byKey.set(val.key, new Map());
		const merged = byKey.get(val.key);
		for (const r of val.rules) {
			const prev = merged.get(r.key);
			if (prev) prev.keep = prev.keep || r.keep; else merged.set(r.key, r);
		}
	}
}
chrome.kill();

// Rebuild each key's file in source order, regrouping consecutive rules that
// share a @media block.
const order = (a, b) => { const pa = a.key.split('.').map(Number), pb = b.key.split('.').map(Number); for (let i = 0; i < Math.max(pa.length, pb.length); i++) { const d = (pa[i] ?? -1) - (pb[i] ?? -1); if (d) return d; } return 0; };
rmSync(OUT_DIR, { recursive: true, force: true });
mkdirSync(OUT_DIR, { recursive: true });
for (const [key, merged] of [...byKey.entries()].sort()) {
	const ordered = [...merged.values()].filter((r) => r.keep).sort(order);
	let css = ''; let openMedia = null; let openTop = null;
	for (const r of ordered) {
		const top = r.key.split('.')[0];
		if (r.media !== openMedia || (r.media && top !== openTop)) {
			if (openMedia) css += '}';
			if (r.media) css += `@media ${r.media}{`;
			openMedia = r.media; openTop = top;
		}
		css += r.css;
	}
	if (openMedia) css += '}';
	css = css.replace(/\s*\n\s*/g, ' ').replace(/\s*([{};])\s*/g, '$1').replace(/;}/g, '}');
	writeFileSync(join(OUT_DIR, `${key}.min.css`), `/* critical: source ${hash} (tools/build-critical-css.mjs) */\n${css}\n`);
	console.log(`${key}: ${ordered.length} of ${merged.size} rules, ${(css.length / 1024).toFixed(1)} KB`);
}
process.exit(0);
