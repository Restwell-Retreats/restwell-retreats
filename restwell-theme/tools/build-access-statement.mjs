#!/usr/bin/env node
// Build assets/downloads/restwell-access-statement.pdf from the print view of
// the accessibility page (/accessibility/?access-statement=1, served by
// inc/access-statement.php from the same equipment data as the live page).
//
// Chrome writes a tagged PDF (real headings, tables, reading order) with a
// document outline, which is what makes it usable with a screen reader. Rerun
// this after editing inc/accessibility-equipment.php or the access statement
// copy, then commit the new PDF.
//
// Needs Google Chrome and the site running (default http://localhost:9410).
// Usage: node restwell-theme/tools/build-access-statement.mjs [base-url]
import { spawn } from 'node:child_process';
import { mkdirSync, writeFileSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';

const THEME = join(dirname(fileURLToPath(import.meta.url)), '..');
const OUT = join(THEME, 'assets/downloads/restwell-access-statement.pdf');
const BASE = (process.argv[2] || 'http://localhost:9410').replace(/\/$/, '');
const CHROME = process.env.CHROME || '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';

const port = 9500 + Math.floor(Math.random() * 400);
const chrome = spawn(CHROME, ['--headless=new', `--remote-debugging-port=${port}`, '--no-first-run',
	`--user-data-dir=/tmp/rw-statement-${port}`, 'about:blank'], { stdio: 'ignore' });
const sleep = (ms) => new Promise((r) => setTimeout(r, ms));
let ws;
const done = (code) => { try { ws && ws.close(); } catch { /* ignore */ } chrome.kill(); process.exit(code); };

try {
	for (let i = 0; i < 50; i++) { try { await fetch(`http://127.0.0.1:${port}/json/version`); break; } catch { await sleep(200); } }
	const target = (await (await fetch(`http://127.0.0.1:${port}/json/list`)).json()).find((t) => t.type === 'page');
	ws = new WebSocket(target.webSocketDebuggerUrl);
	await new Promise((r) => { ws.onopen = r; });
	let seq = 0; const pending = new Map(); const events = [];
	ws.onmessage = (m) => { const d = JSON.parse(m.data); if (d.id && pending.has(d.id)) { pending.get(d.id)(d); pending.delete(d.id); } else events.push(d); };
	const send = (method, params = {}) => new Promise((r) => { const i = ++seq; pending.set(i, r); ws.send(JSON.stringify({ id: i, method, params })); });

	await send('Page.enable'); await send('Runtime.enable'); await send('Network.enable');
	// Logged-out view (Playground auto-logs-in without this cookie).
	await send('Network.setCookie', { name: 'playground_auto_login_already_happened', value: '1', url: BASE });
	await send('Page.navigate', { url: `${BASE}/accessibility/?access-statement=1` });
	for (let i = 0; i < 100 && !events.some((e) => e.method === 'Page.loadEventFired'); i++) await sleep(200);
	await send('Runtime.evaluate', { expression: 'document.fonts.ready.then(() => true)', awaitPromise: true });
	const probe = await send('Runtime.evaluate', { expression: 'JSON.stringify({ items: document.querySelectorAll(".as-item").length, h1: document.querySelectorAll("h1").length })', returnByValue: true });
	const seen = JSON.parse(probe.result.result.value);
	if (seen.h1 !== 1 || seen.items < 5) throw new Error(`print view looks wrong: ${JSON.stringify(seen)}`);

	const footer = `<div style="width:100%;font-family:Inter,Arial,sans-serif;font-size:8.5pt;color:#3f545c;padding:0 15mm;display:flex;justify-content:space-between">`
		+ `<span>Restwell Retreats access statement · 01622 809881 · hello@restwellretreats.co.uk</span><span>Page <span class="pageNumber"></span> of <span class="totalPages"></span></span></div>`;
	const pdf = await send('Page.printToPDF', {
		printBackground: true,
		preferCSSPageSize: true,
		generateTaggedPDF: true,
		generateDocumentOutline: true,
		displayHeaderFooter: true,
		headerTemplate: '<span></span>',
		footerTemplate: footer,
	});
	if (!pdf.result || !pdf.result.data) throw new Error(`printToPDF failed: ${JSON.stringify(pdf.error || pdf)}`);
	mkdirSync(dirname(OUT), { recursive: true });
	writeFileSync(OUT, Buffer.from(pdf.result.data, 'base64'));
	console.log(`access statement: ${seen.items} items → ${OUT}`);
	done(0);
} catch (e) {
	console.error(e.message || e);
	done(1);
}
