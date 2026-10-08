/**
 * Availability board: month pager (two months wide, one on phones), stay
 * selection drawn as one continuous band, guide total, and the enquiry dialog.
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

	function parseIso(iso) {
		return new Date(iso + 'T12:00:00');
	}

	function pad2(n) {
		return n < 10 ? '0' + n : String(n);
	}

	function formatIso(date) {
		return date.getFullYear() + '-' + pad2(date.getMonth() + 1) + '-' + pad2(date.getDate());
	}

	function addDays(iso, days) {
		var dt = parseIso(iso);
		dt.setDate(dt.getDate() + days);
		return formatIso(dt);
	}

	function nightsInclusive(from, to) {
		var start = parseIso(from);
		var end = parseIso(to);
		if (start > end) {
			var swap = start;
			start = end;
			end = swap;
		}
		var out = [];
		var cur = new Date(start.getTime());
		while (cur <= end) {
			out.push(formatIso(cur));
			cur.setDate(cur.getDate() + 1);
		}
		return out;
	}

	function prettyDay(iso) {
		try {
			return parseIso(iso).toLocaleDateString('en-GB', { weekday: 'short', day: 'numeric', month: 'short' });
		} catch (e) {
			return iso;
		}
	}

	function formatGbp(amount) {
		var n = Math.round(Number(amount) || 0);
		try {
			return '£' + n.toLocaleString('en-GB');
		} catch (e) {
			return '£' + String(n);
		}
	}

	function escapeAttr(text) {
		return String(text).replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;');
	}

	function initBoard(root) {
		var monthsHost = root.querySelector('[data-availability-months]');
		var months = Array.prototype.slice.call(root.querySelectorAll('[data-availability-month]'));
		var prevBtn = root.querySelector('[data-availability-prev]');
		var nextBtn = root.querySelector('[data-availability-next]');
		var live = root.querySelector('[data-availability-live]');
		var enquire = root.querySelector('[data-availability-enquire]');
		var enquiryPanel = root.querySelector('[data-availability-enquiry]');
		var enquiryClose = root.querySelector('[data-availability-enquiry-close]');
		var enquiryIntro = root.querySelector('[data-availability-enquiry-dates]');
		var enquiryFrom = root.querySelector('[data-availability-enquiry-from]');
		var enquiryTo = root.querySelector('[data-availability-enquiry-to]');
		var enquireUrl = root.getAttribute('data-enquire-url') || '';
		var fromEl = root.querySelector('[data-availability-from]');
		var toEl = root.querySelector('[data-availability-to]');
		var arrowEl = root.querySelector('[data-availability-arrow]');
		var detailEl = root.querySelector('[data-availability-detail]');
		var breakdown = root.querySelector('[data-availability-breakdown]');
		var clearBtn = root.querySelector('[data-availability-clear]');
		var weekOff = parseInt(root.getAttribute('data-week-offpeak') || '0', 10);
		var weekPeak = parseInt(root.getAttribute('data-week-peak') || '0', 10);
		var maxMonths = parseInt(root.getAttribute('data-max-months') || '12', 10);
		var todayIso = root.getAttribute('data-today') || formatIso(new Date());
		if (!months.length || !monthsHost) return;

		var defaultFrom = fromEl ? fromEl.textContent : '';
		var defaultDetail = detailEl ? detailEl.textContent : '';
		var defaultIntro = enquiryIntro ? enquiryIntro.textContent : '';
		var enquireLabel = enquire ? enquire.textContent : 'Enquire';
		var wide = window.matchMedia ? window.matchMedia('(min-width: 1024px)') : null;

		var index = 0;
		var startIso = '';
		var endIso = '';
		var booked = {};
		var pricing = { off_mid: 0, off_wknd: 0, peak_mid: 0, peak_wknd: 0, peaks: [] };
		var weekdayShort = ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'];
		var weekdayLong = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

		try {
			var bookedList = JSON.parse(root.getAttribute('data-booked') || '[]');
			if (Array.isArray(bookedList)) {
				bookedList.forEach(function (iso) {
					booked[iso] = true;
				});
			}
		} catch (e) { /* keep empty */ }
		try {
			var p = JSON.parse(root.getAttribute('data-pricing') || '{}');
			if (p && typeof p === 'object') {
				pricing = {
					off_mid: parseInt(p.off_mid || 0, 10),
					off_wknd: parseInt(p.off_wknd || 0, 10),
					peak_mid: parseInt(p.peak_mid || 0, 10),
					peak_wknd: parseInt(p.peak_wknd || 0, 10),
					peaks: Array.isArray(p.peaks) ? p.peaks : []
				};
			}
		} catch (e2) { /* defaults */ }
		try {
			var wd = JSON.parse(root.getAttribute('data-weekdays') || '[]');
			if (Array.isArray(wd) && wd.length === 7) weekdayShort = wd;
			var wl = JSON.parse(root.getAttribute('data-weekdays-long') || '[]');
			if (Array.isArray(wl) && wl.length === 7) weekdayLong = wl;
		} catch (e3) { /* defaults */ }

		function isPeakIso(iso) {
			return pricing.peaks.some(function (r) {
				return r && r.s && r.e && iso >= r.s && iso <= r.e;
			});
		}

		function isWeekendNight(iso) {
			/* Match PHP restwell_is_weekend_night: Fri–Sun (JS getDay 5, 6, 0). */
			var n = parseIso(iso).getDay();
			return n === 0 || n >= 5;
		}

		function rateFor(iso) {
			var peak = isPeakIso(iso);
			if (isWeekendNight(iso)) {
				return peak ? pricing.peak_wknd : pricing.off_wknd;
			}
			return peak ? pricing.peak_mid : pricing.off_mid;
		}

		function monthLabel(y, m0) {
			try {
				return new Date(y, m0, 1).toLocaleDateString('en-GB', { month: 'long', year: 'numeric' });
			} catch (e) {
				return y + '-' + pad2(m0 + 1);
			}
		}

		function spokenDay(iso) {
			var dt = parseIso(iso);
			var long = weekdayLong[(dt.getDay() + 6) % 7];
			return long + ' ' + dt.getDate() + ' ' + monthLabel(dt.getFullYear(), dt.getMonth());
		}

		/* Build one month in the same markup the template renders. */
		function buildMonth(y, m0) {
			var daysIn = new Date(y, m0 + 1, 0).getDate();
			var lead = (new Date(y, m0, 1).getDay() + 6) % 7; /* Mon = 0 */
			var id = 'availability-m-' + y + '-' + pad2(m0 + 1);
			var name = monthLabel(y, m0);
			var head = '<thead><tr>' + weekdayShort.map(function (w, i) {
				return '<th scope="col"><abbr title="' + escapeAttr(weekdayLong[i]) + '">' + w + '</abbr></th>';
			}).join('') + '</tr></thead>';
			var cells = '<tr>';
			var cell = 0;
			for (var p0 = 0; p0 < lead; p0++) {
				cells += '<td class="availability__day is-pad" aria-hidden="true"></td>';
				cell++;
			}
			for (var day = 1; day <= daysIn; day++) {
				if (cell % 7 === 0 && cell > 0) cells += '</tr><tr>';
				var iso = y + '-' + pad2(m0 + 1) + '-' + pad2(day);
				var isPast = iso < todayIso;
				var isBooked = !isPast && !!booked[iso];
				var isToday = iso === todayIso;
				var isPeak = !isPast && isPeakIso(iso);
				var isPick = !isBooked && !isPast;
				var rate = isPick ? rateFor(iso) : 0;
				var classes = ['availability__day'];
				if (isBooked) classes.push('is-booked');
				if (isToday) classes.push('is-today');
				if (isPast) classes.push('is-past');
				if (isPeak) classes.push('is-peak');
				if (isPick) classes.push('is-pick');
				cells += '<td class="' + classes.join(' ') + '" data-iso="' + iso + '"';
				if (rate > 0) cells += ' data-rate="' + rate + '"';
				if (isPeak) cells += ' data-peak="1"';
				if (isToday) cells += ' aria-current="date"';
				cells += '>';
				if (isPick) {
					var label = spokenDay(iso);
					if (rate > 0) label += ', ' + formatGbp(rate) + ' a night';
					if (isPeak) label += ', peak rate';
					cells += '<button type="button" class="availability__cell" data-iso="' + iso + '" aria-pressed="false" tabindex="-1" aria-label="' + escapeAttr(label) + '">';
					cells += '<span class="availability__date">' + day + '</span>';
					if (rate > 0) cells += '<span class="availability__price">' + formatGbp(rate) + '</span>';
					cells += '</button>';
				} else if (isBooked) {
					cells += '<button type="button" class="availability__cell" data-iso="' + iso + '" data-booked="1" aria-pressed="false" tabindex="-1" aria-label="' + escapeAttr(spokenDay(iso) + ', booked') + '">';
					cells += '<span class="availability__date">' + day + '</span></button>';
				} else {
					cells += '<span class="availability__cell"><span class="availability__date">' + day + '</span></span>';
				}
				cells += '</td>';
				cell++;
			}
			while (cell % 7 !== 0) {
				cells += '<td class="availability__day is-pad" aria-hidden="true"></td>';
				cell++;
			}
			cells += '</tr>';
			var article = document.createElement('article');
			article.className = 'availability__month';
			article.setAttribute('data-availability-month', '');
			article.setAttribute('aria-labelledby', id);
			article.innerHTML = '<h3 id="' + id + '" class="availability__month-title">' + name + '</h3>' +
				'<table class="availability__grid" role="grid" aria-labelledby="' + id + '">' + head + '<tbody>' + cells + '</tbody></table>';
			return article;
		}

		function ensureMonths(lastIndex) {
			var target = Math.min(maxMonths - 1, lastIndex);
			while (months.length <= target) {
				var base = parseIso(todayIso);
				base.setDate(1);
				base.setMonth(base.getMonth() + months.length);
				var article = buildMonth(base.getFullYear(), base.getMonth());
				monthsHost.appendChild(article);
				months.push(article);
				repaint();
			}
		}

		function visibleCount() {
			return wide && wide.matches ? 2 : 1;
		}

		function showMonth(nextIndex, announce) {
			var vis = visibleCount();
			var maxStart = Math.max(0, maxMonths - vis);
			if (nextIndex < 0) nextIndex = 0;
			if (nextIndex > maxStart) nextIndex = maxStart;
			ensureMonths(nextIndex + vis - 1);
			index = nextIndex;
			months.forEach(function (month, i) {
				month.hidden = !(i >= index && i < index + vis);
			});
			if (prevBtn) prevBtn.disabled = index === 0;
			if (nextBtn) nextBtn.disabled = index >= maxStart;
			if (announce) {
				var names = months.slice(index, index + vis).map(function (m) {
					var t = m.querySelector('.availability__month-title');
					return t ? t.textContent : '';
				});
				setLive('Showing ' + names.join(' and ') + '.');
			}
			syncTabStop();
		}

		function monthIndexOf(iso) {
			var t = parseIso(todayIso);
			var d = parseIso(iso);
			return (d.getFullYear() - t.getFullYear()) * 12 + (d.getMonth() - t.getMonth());
		}

		function dayCell(iso) {
			return root.querySelector('.availability__day[data-iso="' + iso + '"]');
		}

		function dayButton(iso) {
			return root.querySelector('button.availability__cell[data-iso="' + iso + '"]');
		}

		function visibleButtons() {
			return Array.prototype.slice.call(root.querySelectorAll('[data-availability-month]:not([hidden]) button.availability__cell:not([data-booked])'));
		}

		/* A booked morning is reachable only as the leaving day of the stay in progress. */
		function isValidLeave(iso) {
			return !!(startIso && !endIso && iso > startIso && !rangeTouchesBooked(startIso, addDays(iso, -1)));
		}

		/* One tab stop inside the board; arrow keys move between nights. */
		function syncTabStop(preferIso) {
			var buttons = visibleButtons();
			var current = root.querySelector('button.availability__cell[tabindex="0"]');
			var target = (preferIso && dayButton(preferIso)) ||
				(current && buttons.indexOf(current) !== -1 ? current : null) ||
				(startIso && buttons.indexOf(dayButton(startIso)) !== -1 ? dayButton(startIso) : null) ||
				buttons[0] || null;
			root.querySelectorAll('button.availability__cell[tabindex="0"]').forEach(function (b) {
				if (b !== target) b.setAttribute('tabindex', '-1');
			});
			if (target) target.setAttribute('tabindex', '0');
			return target;
		}

		function moveFocus(fromIso, step) {
			var iso = fromIso;
			for (var guard = 0; guard < 400; guard++) {
				iso = addDays(iso, step);
				var mi = monthIndexOf(iso);
				if (iso < todayIso || mi < 0 || mi >= maxMonths) return;
				if (booked[iso] && !isValidLeave(iso)) {
					if (startIso && !endIso && iso > startIso) return;
					continue;
				}
				var vis = visibleCount();
				if (mi < index) showMonth(mi, true);
				else if (mi >= index + vis) showMonth(mi - vis + 1, true);
				var btn = dayButton(iso);
				if (btn) {
					syncTabStop(iso);
					btn.focus();
					if (startIso && !endIso) previewLeave(iso);
					return;
				}
			}
		}

		function rangeTouchesBooked(from, to) {
			return nightsInclusive(from, to).some(function (iso) {
				return !!booked[iso];
			});
		}

		function clearHope() {
			root.querySelectorAll('.availability__day.is-hope').forEach(function (td) {
				td.classList.remove('is-hope', 'is-hope-start', 'is-hope-end', 'is-hope-cap-start', 'is-hope-cap-end', 'is-hope-solo');
			});
			root.querySelectorAll('button.availability__cell[aria-pressed="true"]').forEach(function (btn) {
				btn.setAttribute('aria-pressed', 'false');
			});
		}

		/* Round the band wherever it starts, ends, or wraps onto a new week row. */
		function capBand() {
			root.querySelectorAll('.availability__day.is-hope').forEach(function (td) {
				var prev = td.previousElementSibling;
				var next = td.nextElementSibling;
				td.classList.toggle('is-hope-cap-start', !prev || !prev.classList.contains('is-hope'));
				td.classList.toggle('is-hope-cap-end', !next || !next.classList.contains('is-hope'));
			});
		}

		function markHope(iso, extra) {
			var td = dayCell(iso);
			if (!td) return;
			td.classList.add('is-hope');
			if (extra) td.classList.add(extra);
			var btn = td.querySelector('button.availability__cell');
			if (btn) btn.setAttribute('aria-pressed', 'true');
		}

		function paintArrival(iso) {
			clearHope();
			root.classList.remove('is-previewing');
			markHope(iso, 'is-hope-start');
			/* Arrival alone is just the coin: no band until a leaving day exists. */
			var td = dayCell(iso);
			if (td) td.classList.add('is-hope-solo');
		}

		function paintStay(from, lastNight, preview) {
			clearHope();
			root.classList.toggle('is-previewing', !!preview);
			nightsInclusive(from, lastNight).forEach(function (iso, i) {
				markHope(iso, 0 === i ? 'is-hope-start' : '');
			});
			markHope(addDays(lastNight, 1), 'is-hope-end');
			capBand();
		}

		/* Repaint after a lazily built month joins the board. */
		function repaint() {
			if (startIso && endIso) {
				paintStay(startIso, endIso, false);
			} else if (startIso) {
				paintArrival(startIso);
			}
		}

		function guideTotal(nights) {
			var sum = 0;
			var peakCount = 0;
			nights.forEach(function (iso) {
				var td = dayCell(iso);
				var rate = td ? parseInt(td.getAttribute('data-rate') || '0', 10) : 0;
				sum += rate || rateFor(iso);
				if (isPeakIso(iso)) peakCount += 1;
			});
			var n = nights.length;
			var mixedSeason = peakCount > 0 && peakCount < n;
			if (n >= 7 && n % 7 === 0) {
				var weeks = n / 7;
				if (peakCount === n && weekPeak > 0) {
					return { total: weeks * weekPeak, weekly: true, peakCount: peakCount, mixedSeason: mixedSeason };
				}
				if (peakCount === 0 && weekOff > 0) {
					return { total: weeks * weekOff, weekly: true, peakCount: peakCount, mixedSeason: mixedSeason };
				}
			}
			return { total: sum, weekly: false, peakCount: peakCount, mixedSeason: mixedSeason };
		}

		function nightLineLabel(bucket, mixedSeason) {
			var kind = bucket.weekend ? 'weekend' : 'midweek';
			var season = mixedSeason ? (bucket.peak ? 'peak ' : 'off-peak ') : '';
			return bucket.count + ' ' + season + kind + ' ' + (bucket.count === 1 ? 'night' : 'nights');
		}

		/* Breakdown rows only when the stay mixes rates (data-rate per night). */
		function fillBreakdown(nights, quote) {
			if (!breakdown) return;
			breakdown.textContent = '';
			breakdown.hidden = true;
			if (quote.weekly) return;
			var buckets = {};
			var order = [];
			nights.forEach(function (iso) {
				var td = dayCell(iso);
				var rate = td ? parseInt(td.getAttribute('data-rate') || '0', 10) : rateFor(iso);
				var peak = isPeakIso(iso);
				var weekend = isWeekendNight(iso);
				var key = (peak ? 'p' : 'o') + (weekend ? 'w' : 'm') + String(rate);
				if (!buckets[key]) {
					buckets[key] = { count: 0, rate: rate, peak: peak, weekend: weekend };
					order.push(key);
				}
				buckets[key].count += 1;
			});
			if (order.length <= 1) return;
			order.forEach(function (key) {
				var bucket = buckets[key];
				var dt = document.createElement('dt');
				var dd = document.createElement('dd');
				dt.textContent = nightLineLabel(bucket, quote.mixedSeason) + ' × ' + formatGbp(bucket.rate);
				dd.textContent = formatGbp(bucket.count * bucket.rate);
				breakdown.appendChild(dt);
				breakdown.appendChild(dd);
			});
			breakdown.hidden = false;
		}

		function setDetail(text, html, alert) {
			if (!detailEl) return;
			detailEl.classList.toggle('is-alert', !!alert);
			if (html) {
				detailEl.innerHTML = html;
			} else {
				detailEl.textContent = text;
			}
		}

		function setSummary(from, lastNight) {
			var complete = !!(from && lastNight);
			if (clearBtn) clearBtn.hidden = !from;
			if (arrowEl) arrowEl.hidden = !from;
			if (toEl) toEl.classList.toggle('is-pending', !!from && !complete);
			if (!from) {
				if (fromEl) fromEl.textContent = defaultFrom;
				if (toEl) toEl.textContent = '';
				setDetail(defaultDetail);
				fillBreakdown([], { weekly: true });
				return;
			}
			if (fromEl) fromEl.textContent = prettyDay(from);
			if (!complete) {
				if (toEl) toEl.textContent = 'pick your leaving day';
				setDetail('Tap ' + prettyDay(from) + ' again to clear it.');
				fillBreakdown([], { weekly: true });
				return;
			}
			if (toEl) toEl.textContent = prettyDay(addDays(lastNight, 1));
			var nights = nightsInclusive(from, lastNight);
			var quote = guideTotal(nights);
			var count = nights.length;
			var countText = count === 1 ? '1 night' : count + ' nights';
			if (!quote.weekly && quote.peakCount === count) countText += ', peak season';
			setDetail('', countText + ' · guide total <strong>' + formatGbp(quote.total) + '</strong>');
			fillBreakdown(nights, quote);
		}

		function setEnquire(fromNight, lastNight) {
			if (!enquire) return;
			if (!fromNight || !lastNight) {
				enquire.setAttribute('href', '#availability-enquiry');
				enquire.textContent = enquireLabel;
				if (enquiryFrom) enquiryFrom.value = '';
				if (enquiryTo) enquiryTo.value = '';
				if (enquiryIntro) enquiryIntro.textContent = 'Add your details and we will reply within 48 hours.';
				return;
			}
			var departure = addDays(lastNight, 1);
			var join = enquireUrl.indexOf('?') === -1 ? '?' : '&';
			enquire.setAttribute('href', enquireUrl + join + 'enq_date_from=' + encodeURIComponent(fromNight) + '&enq_date_to=' + encodeURIComponent(departure));
			enquire.textContent = 'Enquire about these dates';
			if (enquiryFrom) enquiryFrom.value = fromNight;
			if (enquiryTo) enquiryTo.value = departure;
			if (enquiryIntro) enquiryIntro.textContent = defaultIntro;
		}

		function setLive(text) {
			if (live) live.textContent = text || '';
		}

		function setArrivalOnly(iso) {
			startIso = iso;
			endIso = '';
			paintArrival(iso);
			setEnquire('', '');
			setSummary(iso, '');
			setLive('Arrive ' + prettyDay(iso) + '. Now pick your leaving day.');
		}

		function applyStay(arrival, lastNight) {
			startIso = arrival;
			endIso = lastNight;
			paintStay(arrival, lastNight, false);
			setEnquire(arrival, lastNight);
			setSummary(arrival, lastNight);
			var count = nightsInclusive(arrival, lastNight).length;
			var quote = guideTotal(nightsInclusive(arrival, lastNight));
			setLive((count === 1 ? 'One night' : count + ' nights') + ', leaving ' + prettyDay(addDays(lastNight, 1)) + '. Guide total ' + formatGbp(quote.total) + '.');
		}

		function clearStay() {
			startIso = '';
			endIso = '';
			clearHope();
			root.classList.remove('is-previewing');
			setEnquire('', '');
			setSummary('', '');
			setLive('Dates cleared.');
			syncTabStop();
		}

		function warn(text) {
			setDetail(text, '', true);
			setLive(text);
		}

		function previewLeave(iso) {
			if (!startIso || endIso) return;
			if (iso <= startIso) {
				paintArrival(startIso);
				return;
			}
			var lastNight = addDays(iso, -1);
			if (rangeTouchesBooked(startIso, lastNight)) {
				paintArrival(startIso);
				return;
			}
			paintStay(startIso, lastNight, true);
		}

		/* Tapping a chosen day again undoes it: the leaving day drops back to
		   "pick your leaving day"; the arrival day clears the whole stay. */
		function undoPick(iso) {
			if (startIso && iso === startIso) {
				clearStay();
				return true;
			}
			if (startIso && endIso && iso === addDays(endIso, 1)) {
				setArrivalOnly(startIso);
				setLive('Leaving day removed. Pick a new leaving day.');
				return true;
			}
			return false;
		}

		function onPick(iso) {
			if (undoPick(iso)) return;
			if (!startIso || endIso || iso < startIso) {
				setArrivalOnly(iso);
				return;
			}
			var lastNight = addDays(iso, -1);
			if (rangeTouchesBooked(startIso, lastNight)) {
				warn('Those nights cross a booking. Pick a shorter stay or new arrival night.');
				return;
			}
			applyStay(startIso, lastNight);
		}

		/* A booked morning can still be a leaving day: guests are out by check-out. */
		function onPickLeaveOnBooked(iso) {
			if (undoPick(iso)) return;
			if (!startIso || endIso || iso <= startIso) {
				warn('That night is booked. Pick an open night to arrive.');
				return;
			}
			var lastNight = addDays(iso, -1);
			if (rangeTouchesBooked(startIso, lastNight)) {
				warn('Those nights cross a booking. Pick a shorter stay or new arrival night.');
				return;
			}
			applyStay(startIso, lastNight);
		}

		root.addEventListener('click', function (event) {
			var btn = event.target.closest('button.availability__cell');
			if (!btn || !root.contains(btn)) return;
			var iso = btn.getAttribute('data-iso');
			syncTabStop(iso);
			if (btn.hasAttribute('data-booked')) {
				onPickLeaveOnBooked(iso);
			} else {
				onPick(iso);
			}
		});

		monthsHost.addEventListener('keydown', function (event) {
			var btn = event.target.closest('button.availability__cell');
			if (!btn) return;
			var iso = btn.getAttribute('data-iso');
			var steps = { ArrowLeft: -1, ArrowRight: 1, ArrowUp: -7, ArrowDown: 7 };
			if (steps[event.key]) {
				event.preventDefault();
				moveFocus(iso, steps[event.key]);
			} else if (event.key === 'PageDown' || event.key === 'PageUp') {
				event.preventDefault();
				showMonth(index + (event.key === 'PageDown' ? 1 : -1), true);
				var first = syncTabStop();
				if (first) first.focus();
			}
		});

		if (window.matchMedia && window.matchMedia('(hover: hover)').matches) {
			monthsHost.addEventListener('pointerover', function (event) {
				var target = event.target.closest('button.availability__cell');
				if (!target || !monthsHost.contains(target)) return;
				var iso = target.getAttribute('data-iso');
				if (iso) previewLeave(iso);
			});
			monthsHost.addEventListener('pointerleave', function () {
				if (startIso && !endIso) paintArrival(startIso);
			});
		}

		if (clearBtn) clearBtn.addEventListener('click', clearStay);
		if (prevBtn) prevBtn.addEventListener('click', function () { showMonth(index - 1, true); });
		if (nextBtn) nextBtn.addEventListener('click', function () { showMonth(index + 1, true); });
		if (wide && typeof wide.addEventListener === 'function') {
			wide.addEventListener('change', function () { showMonth(index, false); });
		}

		if (enquire && enquiryPanel) {
			enquire.addEventListener('click', function (event) {
				if (typeof enquiryPanel.showModal !== 'function') return;
				event.preventDefault();
				enquiryPanel.showModal();
				var firstField = enquiryPanel.querySelector('input:not([type="hidden"])');
				if (firstField) firstField.focus({ preventScroll: true });
			});
			if (enquiryClose) {
				enquiryClose.addEventListener('click', function () { enquiryPanel.close(); });
			}
			enquiryPanel.addEventListener('click', function (event) {
				if (event.target === enquiryPanel) enquiryPanel.close();
			});
			enquiryPanel.addEventListener('close', function () {
				enquire.focus({ preventScroll: true });
			});
		}

		/* Lets CSS park the back-to-top button while the booking bar is on screen. */
		if ('IntersectionObserver' in window) {
			new IntersectionObserver(function (entries) {
				document.body.classList.toggle('availability-in-view', entries[0].isIntersecting);
			}).observe(root);
		}

		showMonth(0, false);
		setEnquire('', '');
		setSummary('', '');
	}

	ready(function () {
		document.querySelectorAll('[data-availability]').forEach(initBoard);
	});
})();
