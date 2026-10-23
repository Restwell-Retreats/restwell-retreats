// Hover and focus contrast audit (23 Oct 2026).
//
// axe-core only checks resting colours, so a dark-gold hover on a teal card
// (1.15:1) and teal focus rings on teal panels (1:1) went unnoticed. This
// forces :hover and :focus-visible on every link and button, then measures:
//   - text colour against what is painted behind it (4.5:1, or 3:1 for large text)
//   - the focus outline against what is just outside the element (3:1)
// Anything over a photo or a gradient is measured from real pixels: the text is made
// transparent, the box is captured (inset past the border) and the worst
// 10% of pixels must still pass.
//
// Needs the site running and headless Chrome with remote debugging:
//   "/Applications/Google Chrome.app/Contents/MacOS/Google Chrome" --headless=new \
//     --remote-debugging-port=9333 --user-data-dir=/tmp/rw-chrome about:blank &
//   node restwell-theme/tools/audit-interaction-contrast.mjs [base-url] [width]
// Exits 1 if anything fails. Calendar cells and link cards draw their focus
// ring on a wrapper, so a missing outline on those is listed, not failed.
// Transitions are switched off (a half-finished focus transition reads as no
// halo), and every layer is made hit-testable (photo layers use
// pointer-events: none, which hides them from elementsFromPoint).
import zlib from 'node:zlib';

const BASE = process.argv[2] || 'http://localhost:9410';
const WIDTH = Number(process.argv[3] || 1440);
const PATHS = ['/', '/the-property/', '/how-it-works/', '/accessibility/', '/who-its-for/', '/our-story/', '/optional-care/', '/funding-and-support/', '/pricing/', '/faq/', '/enquire/', '/whitstable-area-guide/', '/blog/', '/privacy-policy/', '/terms-and-conditions/', '/accessibility-policy/', '/accessible-beaches-coastal-walks-kent/', '/direct-payment-holiday-accommodation/', '/revitalise-alternatives-accessible-holidays/', '/how-to-choose-accessible-self-catering-holiday/', '/how-to-read-holiday-cottage-access-statement/'];
const SELECTOR = 'a[href], button, [role="button"], summary, input[type="submit"]';

const pages = await (await fetch('http://127.0.0.1:9333/json/list')).json();
const ws = new WebSocket(pages.find((t) => t.type === 'page').webSocketDebuggerUrl);
await new Promise((r) => ws.addEventListener('open', r, { once: true }));
let seq = 0;
const pending = new Map();
ws.addEventListener('message', (e) => {
	const m = JSON.parse(e.data);
	if (m.id && pending.has(m.id)) {
		const p = pending.get(m.id);
		pending.delete(m.id);
		if (m.error) {
			p.rej(new Error(m.error.message));
		} else {
			p.res(m.result);
		}
	}
});
const send = (method, params = {}) => new Promise((res, rej) => {
	const i = ++seq;
	pending.set(i, { res, rej });
	ws.send(JSON.stringify({ id: i, method, params }));
});

// In-page measurement. Returns colours, the background under the element
// (including sibling overlays), the ring and whether a photo is involved.
const MEASURE = `function () {
	const el = this;
	const parse = (c) => {
		let m = c && c.match(/rgba?\\(([^)]+)\\)/);
		if (m) { const p = m[1].split(/[ ,\\/]+/).filter(Boolean).map(Number); return { r: p[0], g: p[1], b: p[2], a: p.length > 3 ? p[3] : 1 }; }
		m = c && c.match(/color\\(srgb ([^)]+)\\)/);
		if (m) { const p = m[1].split(/[ \\/]+/).filter(Boolean).map(Number); return { r: p[0] * 255, g: p[1] * 255, b: p[2] * 255, a: p.length > 3 ? p[3] : 1 }; }
		return null;
	};
	const blend = (t, b) => ({ r: t.r * t.a + b.r * (1 - t.a), g: t.g * t.a + b.g * (1 - t.a), b: t.b * t.a + b.b * (1 - t.a), a: 1 });
	const lum = (c) => { const f = (v) => { v /= 255; return v <= 0.03928 ? v / 12.92 : Math.pow((v + 0.055) / 1.055, 2.4); }; return 0.2126 * f(c.r) + 0.7152 * f(c.g) + 0.0722 * f(c.b); };
	const ratio = (a, b) => { const x = lum(a), y = lum(b); return (Math.max(x, y) + 0.05) / (Math.min(x, y) + 0.05); };
	const photo = (n, s) => n.tagName === 'IMG' || n.tagName === 'VIDEO' || n.tagName === 'PICTURE' || s.backgroundImage !== 'none';
	const under = (x, y, skipSelf) => {
		const layers = []; let img = false;
		for (const n of document.elementsFromPoint(x, y)) {
			if (skipSelf && (n === el || el.contains(n))) continue;
			const s = getComputedStyle(n);
			if (s.visibility === 'hidden' || parseFloat(s.opacity) === 0) continue;
			if (photo(n, s)) { img = true; break; }
			const c = parse(s.backgroundColor);
			if (c && c.a > 0) { layers.push(c); if (c.a >= 1) break; }
		}
		let bg = { r: 255, g: 255, b: 255, a: 1 };
		for (let i = layers.length - 1; i >= 0; i--) bg = blend(layers[i], bg);
		return { bg, img };
	};
	const cs = getComputedStyle(el);
	if (cs.display === 'none' || cs.visibility === 'hidden' || el.closest('[hidden], .sr-only')) return null;
	const text = (el.innerText || el.value || '').trim().replace(/\\s+/g, ' ');
	if (!text) return null;
	if (!el.closest('.site-header')) el.scrollIntoView({ block: 'center' });
	const r = el.getBoundingClientRect();
	if (r.width < 2 || r.height < 2) return null;
	const cx = Math.min(Math.max(r.left + r.width / 2, 1), innerWidth - 2), cy = Math.min(Math.max(r.top + r.height / 2, 1), innerHeight - 2);
	let bg, img = false;
	const own = parse(cs.backgroundColor);
	if (photo(el, cs)) { img = true; bg = { r: 255, g: 255, b: 255, a: 1 }; }
	else if (own && own.a >= 1) bg = own;
	else { const u = under(cx, cy, true); bg = own && own.a > 0 ? blend(own, u.bg) : u.bg; img = u.img; }
	if (!img && el.querySelector('img, picture, video')) img = true;
	const lines = [];
	const walker = document.createTreeWalker(el, NodeFilter.SHOW_TEXT);
	for (let t = walker.nextNode(); t && lines.length < 8; t = walker.nextNode()) {
		if (!t.textContent.trim() || t.parentElement.closest('.sr-only')) continue;
		const range = document.createRange(); range.selectNodeContents(t);
		for (const b of range.getClientRects()) if (b.width > 3 && b.height > 3) lines.push([b.left + scrollX, b.top + scrollY, b.width, b.height, getComputedStyle(t.parentElement).color]);
	}
	const fg0 = parse(cs.color); if (!fg0) return null;
	const fg = fg0.a < 1 ? blend(fg0, bg) : fg0;
	const size = parseFloat(cs.fontSize), weight = parseInt(cs.fontWeight, 10);
	let ring = null;
	const ow = parseFloat(cs.outlineWidth) || 0;
	if (cs.outlineStyle !== 'none' && ow > 0) {
		const off = parseFloat(cs.outlineOffset) || 0;
		const u = under(Math.max(1, r.left - off - ow / 2), cy, true);
		const oc = parse(cs.outlineColor);
		const halo = /\\b0px 0px 0px [3-9]/.test(cs.boxShadow);
		if (oc) ring = { ratio: ratio(oc.a < 1 ? blend(oc, u.bg) : oc, u.bg), img: u.img, halo };
	} else if (cs.boxShadow !== 'none') ring = { shadow: true };
	return {
		text: text.slice(0, 50), cls: (el.className && el.className.toString ? el.className.toString() : '').slice(0, 50),
		color: cs.color, ratio: ratio(fg, bg), need: size >= 24 || (size >= 18.66 && weight >= 700) ? 3 : 4.5, img,
		lines, ring,
	};
}`;

// Minimal PNG decoder (8-bit RGB/RGBA, non-interlaced: what Chrome produces).
function decodePng(buf) {
	let pos = 8, width = 0, height = 0, type = 0;
	const idat = [];
	while (pos < buf.length) {
		const len = buf.readUInt32BE(pos);
		const name = buf.toString('ascii', pos + 4, pos + 8);
		const data = buf.subarray(pos + 8, pos + 8 + len);
		if (name === 'IHDR') { width = data.readUInt32BE(0); height = data.readUInt32BE(4); type = data[9]; }
		if (name === 'IDAT') idat.push(data);
		pos += 12 + len;
	}
	const bpp = type === 6 ? 4 : 3;
	const raw = zlib.inflateSync(Buffer.concat(idat));
	const stride = width * bpp;
	const out = Buffer.alloc(height * stride);
	for (let y = 0; y < height; y++) {
		const f = raw[y * (stride + 1)];
		for (let x = 0; x < stride; x++) {
			const v = raw[y * (stride + 1) + 1 + x];
			const a = x >= bpp ? out[y * stride + x - bpp] : 0;
			const b = y > 0 ? out[(y - 1) * stride + x] : 0;
			const c = x >= bpp && y > 0 ? out[(y - 1) * stride + x - bpp] : 0;
			let p = v;
			if (f === 1) p = v + a;
			else if (f === 2) p = v + b;
			else if (f === 3) p = v + ((a + b) >> 1);
			else if (f === 4) { const pa = Math.abs(b - c), pb = Math.abs(a - c), pc = Math.abs(a + b - 2 * c); p = v + (pa <= pb && pa <= pc ? a : pb <= pc ? b : c); }
			out[y * stride + x] = p & 255;
		}
	}
	return { width, height, bpp, px: out };
}
const lum = (r, g, b) => { const f = (v) => { v /= 255; return v <= 0.03928 ? v / 12.92 : Math.pow((v + 0.055) / 1.055, 2.4); }; return 0.2126 * f(r) + 0.7152 * f(g) + 0.0722 * f(b); };

for (const d of ['Page', 'DOM', 'CSS', 'Runtime']) await send(d + '.enable');
await send('Emulation.setDeviceMetricsOverride', { width: WIDTH, height: 900, deviceScaleFactor: 1, mobile: WIDTH < 768 });

const fails = [];
const wrapperRings = new Set();
for (const path of PATHS) {
	await send('Page.navigate', { url: BASE + path });
	await new Promise((r) => setTimeout(r, 3500));
	await send('Runtime.evaluate', { expression: "document.getElementById('wpadminbar')?.remove(); document.querySelector('.cookie-banner')?.remove(); document.documentElement.style.scrollBehavior = 'auto'; document.querySelectorAll('[data-reveal]').forEach((e) => e.classList.add('is-visible', 'is-revealed')); const s = document.createElement('style'); s.textContent = '*, *::before, *::after { transition: none !important; animation: none !important; pointer-events: auto !important; } [data-rw-hide], [data-rw-hide] * { color: transparent !important; -webkit-text-fill-color: transparent !important; text-shadow: none !important; text-decoration-color: transparent !important; }'; document.head.appendChild(s); true" });
	const { root } = await send('DOM.getDocument', { depth: -1 });
	const { nodeIds } = await send('DOM.querySelectorAll', { nodeId: root.nodeId, selector: SELECTOR });
	for (const nodeId of nodeIds) {
		for (const state of [['hover'], ['focus', 'focus-visible']]) {
			let v;
			let objectId;
			try {
				await send('CSS.forcePseudoState', { nodeId, forcedPseudoClasses: state });
				({ object: { objectId } } = await send('DOM.resolveNode', { nodeId }));
				({ result: { value: v } } = await send('Runtime.callFunctionOn', { objectId, functionDeclaration: MEASURE, returnByValue: true }));
			} catch {
				continue;
			}
			if (v && v.img) {
				// Over a photo or gradient: measure the real pixels behind each line of
				// text (text made transparent) and keep the worst line.
				await send('Runtime.callFunctionOn', { objectId, functionDeclaration: "function(){ this.setAttribute('data-rw-hide', ''); }" });
				await new Promise((r) => setTimeout(r, 120));
				let worst = Infinity;
				for (const [x, y, w, h, color] of v.lines) {
					const shot = await send('Page.captureScreenshot', { format: 'png', clip: { x, y, width: w, height: h, scale: 1 } });
					const png = decodePng(Buffer.from(shot.data, 'base64'));
					const m = color.match(/[\d.]+/g).map(Number);
					const lf = lum(m[0], m[1], m[2]);
					const ratios = [];
					for (let i = 0; i < png.px.length; i += png.bpp) {
						const lb = lum(png.px[i], png.px[i + 1], png.px[i + 2]);
						ratios.push((Math.max(lf, lb) + 0.05) / (Math.min(lf, lb) + 0.05));
					}
					ratios.sort((a, b) => a - b);
					worst = Math.min(worst, ratios[Math.floor(ratios.length / 10)]);
				}
				if (worst !== Infinity) {
					v.ratio = worst;
					v.pixel = true;
				}
				await send('Runtime.callFunctionOn', { objectId, functionDeclaration: "function(){ this.removeAttribute('data-rw-hide'); }" });
			}
			await send('CSS.forcePseudoState', { nodeId, forcedPseudoClasses: [] });
			if (!v) continue;
			const where = `${state.join('+')} ${path} .${v.cls || '(no class)'} "${v.text}"`;
			if (v.ratio < v.need) fails.push(`text ${v.ratio.toFixed(2)}:1 (needs ${v.need})${v.pixel ? ' [pixels]' : ''}  ${where}`);
			if (state[0] === 'focus') {
				if (!v.ring) wrapperRings.add(`.${v.cls || '(no class)'} on ${path}`);
				else if (v.ring.ratio !== undefined && !v.ring.img && !v.ring.halo && v.ring.ratio < 3) fails.push(`ring ${v.ring.ratio.toFixed(2)}:1 (needs 3)  ${where}`);
			}
		}
	}
	process.stderr.write(`${path} checked\n`);
}
ws.close();

const unique = [...new Set(fails)];
console.log(unique.length ? unique.join('\n') : `No hover or focus contrast failures at ${WIDTH}px.`);
if (wrapperRings.size) {
	console.log(`\nNo outline on the element itself (fine if a wrapper draws the ring; check these by tabbing):\n  ${[...wrapperRings].slice(0, 12).join('\n  ')}${wrapperRings.size > 12 ? `\n  …and ${wrapperRings.size - 12} more` : ''}`);
}
process.exit(unique.length ? 1 : 0);
