/**
 * House diary: month pager, hoped-for nights, enquire URL, guide total.
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

	function formatIso(date) {
		var y = date.getFullYear();
		var m = String(date.getMonth() + 1);
		var d = String(date.getDate());
		if (m.length === 1) m = '0' + m;
		if (d.length === 1) d = '0' + d;
		return y + '-' + m + '-' + d;
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
			return parseIso(iso).toLocaleDateString('en-GB', {
				weekday: 'short',
				day: 'numeric',
				month: 'short'
			});
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

	function initDiary(root) {
		var monthsHost = root.querySelector('.availability__months');
		var months = Array.prototype.slice.call(root.querySelectorAll('[data-availability-month]'));
		var prevBtn = root.querySelector('[data-availability-prev]');
		var nextBtn = root.querySelector('[data-availability-next]');
		var live = root.querySelector('[data-availability-live]');
		var enquire = root.querySelector('[data-availability-enquire]');
			var enquiryPanel = root.querySelector('[data-availability-enquiry]');
			var enquiryClose = root.querySelector('[data-availability-enquiry-close]');
			var enquiryReturnFocus = null;
			var enquiryFrom = root.querySelector('[data-availability-enquiry-from]');
			var enquiryTo = root.querySelector('[data-availability-enquiry-to]');
		var enquireUrl = root.getAttribute('data-enquire-url') || '';
		var fromEl = root.querySelector('[data-availability-from]');
		var toEl = root.querySelector('[data-availability-to]');
		var fromField = root.querySelector('[data-availability-from-field]');
		var toField = root.querySelector('[data-availability-to-field]');
		var stay = root.querySelector('[data-availability-stay]');
		var clearBtn = root.querySelector('[data-availability-clear]');
		var prompt = root.querySelector('[data-availability-prompt]');
		var defaultPrompt = prompt ? prompt.textContent : '';
		var quoteBox = root.querySelector('[data-availability-quote]');
		var breakdown = root.querySelector('[data-availability-breakdown]');
		var countEl = root.querySelector('[data-availability-count]');
		var totalEl = root.querySelector('[data-availability-total]');
		var weekOff = parseInt(root.getAttribute('data-week-offpeak') || '0', 10);
		var weekPeak = parseInt(root.getAttribute('data-week-peak') || '0', 10);
		var maxMonths = parseInt(root.getAttribute('data-max-months') || '12', 10);
		var todayIso = root.getAttribute('data-today') || formatIso(new Date());
		if (!months.length || !monthsHost) return;

		var index = 0;
		var startIso = '';
		var endIso = '';
		var booked = {};
		var twoUp = window.matchMedia('(min-width: 768px)');
		var pricing = { off_mid: 0, off_wknd: 0, peak_mid: 0, peak_wknd: 0, peaks: [] };
		var weekdayShort = ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'];

		try {
			var bookedList = JSON.parse(root.getAttribute('data-booked') || '[]');
			if (Array.isArray(bookedList)) {
				bookedList.forEach(function (iso) {
					booked[iso] = true;
				});
			}
		} catch (e) { /* keep empty */ }
		root.querySelectorAll('.availability__day.is-booked[data-iso]').forEach(function (td) {
			booked[td.getAttribute('data-iso')] = true;
		});
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
		} catch (e3) { /* defaults */ }

		function isPeakIso(iso) {
			return pricing.peaks.some(function (r) {
				return r && r.s && r.e && iso >= r.s && iso <= r.e;
			});
		}

		function isWeekendIso(iso) {
			var n = parseIso(iso).getDay();
			/* Match PHP restwell_is_weekend_night: Fri + Sat (ISO N >= 5). */
			return n === 5 || n === 6;
		}

		function rateFor(iso) {
			var peak = isPeakIso(iso);
			if (isWeekendIso(iso)) {
				return peak ? pricing.peak_wknd : pricing.off_wknd;
			}
			return peak ? pricing.peak_mid : pricing.off_mid;
		}

		function pad2(n) {
			return n < 10 ? '0' + n : String(n);
		}

		function monthLabel(y, m0) {
			try {
				return new Date(y, m0, 1).toLocaleDateString('en-GB', { month: 'long', year: 'numeric' });
			} catch (e) {
				return y + '-' + pad2(m0 + 1);
			}
		}

		function ensureMonths(neededIndex) {
			while (months.length <= neededIndex && months.length < maxMonths) {
				var base = months[0].querySelector('[data-iso]');
				var seed = base ? base.getAttribute('data-iso') : todayIso;
				var dt = parseIso(seed);
				dt.setDate(1);
				dt.setMonth(dt.getMonth() + months.length);
				var y = dt.getFullYear();
				var m0 = dt.getMonth();
				var daysIn = new Date(y, m0 + 1, 0).getDate();
				var lead = (new Date(y, m0, 1).getDay() + 6) % 7; /* Mon=0 */
				var key = y + '-' + pad2(m0 + 1);
				var id = 'availability-m-' + key;
				var name = monthLabel(y, m0);
				var article = document.createElement('article');
				article.className = 'availability__month';
				article.setAttribute('data-availability-month', '');
				article.setAttribute('aria-labelledby', id);
				article.hidden = true;
				var head = '<h3 id="' + id + '" class="availability__month-title">' + name + '</h3>';
				var thead = '<thead><tr>' + weekdayShort.map(function (w) {
					return '<th scope="col"><abbr title="">' + w + '</abbr></th>';
				}).join('') + '</tr></thead>';
				var cells = '';
				var cell = 0;
				cells += '<tr>';
				for (var p = 0; p < lead; p++) {
					cells += '<td class="availability__day is-pad" aria-hidden="true"></td>';
					cell++;
				}
				for (var day = 1; day <= daysIn; day++) {
					if (cell % 7 === 0 && cell > 0) cells += '</tr><tr>';
					var iso = y + '-' + pad2(m0 + 1) + '-' + pad2(day);
					var classes = ['availability__day'];
					var isBooked = !!booked[iso];
					var isToday = iso === todayIso;
					var isPast = iso < todayIso;
					var isPeak = isPeakIso(iso);
					var isPick = !isBooked && !isPast;
					var rate = rateFor(iso);
					if (isBooked) classes.push('is-booked');
					if (isToday) classes.push('is-today');
					if (isPast) classes.push('is-past');
					if (isPeak) classes.push('is-peak');
					if (isPick) classes.push('is-pick');
					var aria = day + ' ' + name;
					if (rate > 0) aria += ', £' + rate;
					if (isPeak) aria += ', Peak season';
					cells += '<td class="' + classes.join(' ') + '" data-iso="' + iso + '"';
					if (rate > 0) cells += ' data-rate="' + rate + '"';
					if (isPeak) cells += ' data-peak="1"';
					if (isToday) cells += ' aria-current="date"';
					cells += '>';
					if (isPick) {
						cells += '<button type="button" class="availability__num" data-iso="' + iso + '" aria-pressed="false" aria-label="' + aria.replace(/"/g, '&quot;') + '">';
					} else {
						cells += '<span class="availability__num">';
					}
					cells += '<span class="availability__date">' + day + '</span>';
					if (rate > 0) cells += '<span class="availability__price">£' + rate + '</span>';
					cells += isPick ? '</button>' : '</span>';
					if (isBooked) cells += '<span class="sr-only">Booked</span>';
					cells += '</td>';
					cell++;
				}
				while (cell % 7 !== 0) {
					cells += '<td class="availability__day is-pad" aria-hidden="true"></td>';
					cell++;
				}
				cells += '</tr>';
				article.innerHTML = head + '<table class="availability__grid"><caption class="sr-only">' + name + '</caption>' + thead + '<tbody>' + cells + '</tbody></table>';
				monthsHost.appendChild(article);
				months.push(article);
			}
		}

		function visibleCount() {
			return twoUp.matches ? 2 : 1;
		}

		function showMonth(nextIndex) {
			var vis = visibleCount();
			var lastNeeded = Math.min(maxMonths - 1, Math.max(0, nextIndex + vis - 1));
			ensureMonths(lastNeeded);
			months = Array.prototype.slice.call(root.querySelectorAll('[data-availability-month]'));
			var maxStart = Math.max(0, maxMonths - vis);
			maxStart = Math.min(maxStart, Math.max(0, months.length - vis));
			if (nextIndex < 0) nextIndex = 0;
			if (nextIndex > maxStart) nextIndex = maxStart;
			index = nextIndex;
			months.forEach(function (month, i) {
				var on = i >= index && i < index + vis;
				month.classList.toggle('is-active', on);
				month.hidden = !on;
			});
			if (prevBtn) prevBtn.disabled = index === 0;
			/* Keep Next enabled until we have rendered maxMonths (lazy-build on click). */
			if (nextBtn) nextBtn.disabled = index >= maxMonths - vis;
		}

		function rangeTouchesBooked(from, to) {
			return nightsInclusive(from, to).some(function (iso) {
				return !!booked[iso];
			});
		}

		function clearHope() {
			root.querySelectorAll('.availability__day.is-hope, .availability__day.is-hope-start, .availability__day.is-hope-end, .availability__day.is-hope-checkout').forEach(function (td) {
				td.classList.remove('is-hope', 'is-hope-start', 'is-hope-end', 'is-hope-checkout');
			});
			root.querySelectorAll('button[data-iso][aria-pressed]').forEach(function (btn) {
				btn.setAttribute('aria-pressed', 'false');
			});
		}

		function dayCell(iso) {
			return root.querySelector('.availability__day[data-iso="' + iso + '"]');
		}

		function paintArrival(iso) {
			clearHope();
			var td = dayCell(iso);
			if (!td) return;
			td.classList.add('is-hope', 'is-hope-start');
			var btn = td.querySelector('button[data-iso]');
			if (btn) btn.setAttribute('aria-pressed', 'true');
		}

		function paintHope(from, to) {
			clearHope();
			var nights = nightsInclusive(from, to);
			nights.forEach(function (iso, i) {
				var td = dayCell(iso);
				if (!td) return;
				td.classList.add('is-hope');
				if (0 === i) td.classList.add('is-hope-start');
				if (i === nights.length - 1) td.classList.add('is-hope-end');
				var btn = td.querySelector('button[data-iso]');
				if (btn) btn.setAttribute('aria-pressed', 'true');
			});
			var checkoutCell = dayCell(addDays(nights[nights.length - 1], 1));
			if (checkoutCell) checkoutCell.classList.add('is-hope-checkout');
		}

		function isWeekendNight(iso) {
			var day = parseIso(iso).getDay();
			return day === 0 || day >= 5;
		}

		function guideTotal(nights) {
			var sum = 0;
			var peakCount = 0;
			nights.forEach(function (iso) {
				var td = dayCell(iso);
				if (!td) return;
				sum += parseInt(td.getAttribute('data-rate') || '0', 10);
				if (td.getAttribute('data-peak') === '1') peakCount += 1;
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

		function appendBreakdownRow(label, amount) {
			if (!breakdown) return;
			var totalRow = breakdown.querySelector('.availability__total');
			var row = document.createElement('div');
			var dt = document.createElement('dt');
			var dd = document.createElement('dd');
			dt.textContent = label;
			dd.textContent = amount;
			row.appendChild(dt);
			row.appendChild(dd);
			if (totalRow) {
				breakdown.insertBefore(row, totalRow);
			} else {
				breakdown.appendChild(row);
			}
		}

		function clearBreakdownRows() {
			if (!breakdown) return;
			Array.prototype.slice.call(breakdown.children).forEach(function (row) {
				if (!row.classList.contains('availability__total')) {
					row.remove();
				}
			});
		}

		function nightLineLabel(bucket, mixedSeason) {
			var kind = bucket.weekend ? 'weekend' : 'midweek';
			var season = '';
			if (mixedSeason) {
				season = bucket.peak ? 'peak ' : 'off-peak ';
			}
			var noun = bucket.count === 1 ? 'night' : 'nights';
			return bucket.count + ' ' + season + kind + ' ' + noun + ' × ' + formatGbp(bucket.rate);
		}

		function fillBreakdown(nights, quote) {
			clearBreakdownRows();
			if (quote.weekly) {
				var weeks = nights.length / 7;
				appendBreakdownRow(
					weeks === 1 ? 'Published week rate' : weeks + ' × published week rate',
					formatGbp(quote.total)
				);
				return;
			}
			var buckets = {};
			var order = [];
			nights.forEach(function (iso) {
				var td = dayCell(iso);
				if (!td) return;
				var rate = parseInt(td.getAttribute('data-rate') || '0', 10);
				var peak = td.getAttribute('data-peak') === '1';
				var weekend = isWeekendNight(iso);
				var key = (peak ? 'p' : 'o') + (weekend ? 'w' : 'm') + String(rate);
				if (!buckets[key]) {
					buckets[key] = { count: 0, rate: rate, peak: peak, weekend: weekend };
					order.push(key);
				}
				buckets[key].count += 1;
			});
			order.forEach(function (key) {
				var bucket = buckets[key];
				appendBreakdownRow(nightLineLabel(bucket, quote.mixedSeason), formatGbp(bucket.count * bucket.rate));
			});
		}

		function setStay(from, to, extendHint) {
			var awaitingLeave = !!(from && !to);
			var complete = !!(from && to);
			if (stay) stay.classList.toggle('is-empty', !from);
			if (clearBtn) clearBtn.hidden = !from;
			if (fromField) fromField.classList.toggle('is-active', !from);
			if (toField) toField.classList.toggle('is-active', awaitingLeave);
			if (fromEl) fromEl.textContent = from ? prettyDay(from) : '—';
			if (toEl) {
				if (!complete) {
					toEl.textContent = '—';
				} else {
					toEl.textContent = prettyDay(addDays(to, 1));
				}
			}
			if (!complete) {
				if (quoteBox) quoteBox.hidden = true;
				if (countEl) countEl.textContent = '';
				clearBreakdownRows();
				if (prompt) {
					prompt.hidden = false;
					prompt.textContent = awaitingLeave ? 'Tap your leave date.' : defaultPrompt;
				}
				return;
			}
			var nights = nightsInclusive(from, to);
			var quote = guideTotal(nights);
			var count = nights.length;
			if (countEl) {
				var countText = count === 1 ? '1 night' : count + ' nights';
				if (!quote.weekly && quote.peakCount === count && count > 0) {
					countText += ', peak season';
				}
				countEl.textContent = countText;
			}
			fillBreakdown(nights, quote);
			if (totalEl) totalEl.textContent = formatGbp(quote.total);
			if (quoteBox) quoteBox.hidden = false;
			if (prompt) {
				if (extendHint) {
					prompt.hidden = false;
					prompt.textContent = 'Tap another date to start a new stay.';
				} else {
					prompt.hidden = true;
				}
			}
		}

		function setEnquire(fromNight, toNight) {
			if (!enquire) return;
			if (!fromNight || !toNight) {
				enquire.setAttribute('href', '#availability-enquiry');
				enquire.setAttribute('aria-label', 'Enquire without dates');
				enquire.classList.remove('is-disabled');
				enquire.removeAttribute('aria-disabled');
				enquire.removeAttribute('tabindex');
				if (enquiryPanel && enquiryPanel.open) enquiryPanel.close();
				return;
			}
			enquire.classList.remove('is-disabled');
			enquire.removeAttribute('aria-disabled');
			enquire.removeAttribute('tabindex');
			var arrival = fromNight < toNight ? fromNight : toNight;
			var lastNight = fromNight < toNight ? toNight : fromNight;
			var departure = addDays(lastNight, 1);
			var join = enquireUrl.indexOf('?') === -1 ? '?' : '&';
			enquire.setAttribute(
				'href',
				enquireUrl + join + 'enq_date_from=' + encodeURIComponent(arrival) + '&enq_date_to=' + encodeURIComponent(departure)
			);
			if (enquiryFrom) enquiryFrom.value = arrival;
			if (enquiryTo) enquiryTo.value = departure;
			var count = nightsInclusive(arrival, lastNight).length;
			enquire.setAttribute(
				'aria-label',
				count === 1 ? 'Enquire about this night' : 'Enquire about these nights'
			);
		}

		function setLive(text) {
			if (live) live.textContent = text || '';
		}

		function announceStay(arrival, lastNight) {
			var nights = nightsInclusive(arrival, lastNight);
			var leave = prettyDay(addDays(lastNight, 1));
			if (nights.length === 1) {
				setLive('One night, leaving ' + leave + '.');
			} else {
				setLive(nights.length + ' nights, leaving ' + leave + '.');
			}
		}

		function setArrivalOnly(iso) {
			startIso = iso;
			endIso = '';
			paintArrival(iso);
			setEnquire('', '');
			setStay(iso, '', false);
			setLive('Arrive ' + prettyDay(iso) + '. Tap your leave date.');
		}

		function applyStay(arrival, lastNight, extendHint) {
			startIso = arrival;
			endIso = lastNight;
			paintHope(arrival, lastNight);
			setEnquire(arrival, lastNight);
			setStay(arrival, lastNight, extendHint);
			announceStay(arrival, lastNight);
		}

		function clearStay() {
			startIso = '';
			endIso = '';
			clearHope();
			setEnquire('', '');
			setStay('', '');
			setLive('Selection cleared.');
		}

		function onPick(iso) {
			if (booked[iso]) return;

			/* Fresh pick, or restart after a completed stay. */
			if (!startIso || endIso) {
				setArrivalOnly(iso);
				return;
			}

			/* Arrival set; this click is the leave (departure) date. */
			if (iso === startIso) {
				var sameDay = 'Choose a later leave date — stays are overnight.';
				if (prompt) {
					prompt.hidden = false;
					prompt.textContent = sameDay;
				}
				setLive(sameDay);
				return;
			}

			var arrival = startIso < iso ? startIso : iso;
			var departure = startIso < iso ? iso : startIso;
			var lastNight = addDays(departure, -1);

			if (rangeTouchesBooked(arrival, lastNight)) {
				var blocked = 'Those nights are already held. Try a stretch that doesn’t cross a booking.';
				if (prompt) {
					prompt.hidden = false;
					prompt.textContent = blocked;
				}
				setLive(blocked);
				return;
			}

			applyStay(arrival, lastNight, true);
		}

		root.addEventListener('click', function (event) {
			var btn = event.target.closest('button[data-iso]');
			if (!btn || !root.contains(btn)) return;
			if (btn.closest('.is-booked')) return;
			var iso = btn.getAttribute('data-iso');
			if (!iso) return;
			onPick(iso);
		});

		if (clearBtn) {
			clearBtn.addEventListener('click', clearStay);
		}

		if (enquire) {
			enquire.addEventListener('click', function (event) {
				if (enquire.classList.contains('is-disabled')) {
					event.preventDefault();
					return;
				}
				if (enquiryPanel) {
					event.preventDefault();
					enquiryReturnFocus = document.activeElement;
					if (typeof enquiryPanel.showModal === 'function') enquiryPanel.showModal();
					var firstField = enquiryPanel.querySelector('input:not([type="hidden"])');
					if (firstField) firstField.focus({ preventScroll: true });
				}
			});

			if (enquiryClose && enquiryPanel) {
				enquiryClose.addEventListener('click', function () { enquiryPanel.close(); });
			}
			if (enquiryPanel) {
				enquiryPanel.addEventListener('click', function (event) {
					if (event.target === enquiryPanel) enquiryPanel.close();
				});
				enquiryPanel.addEventListener('close', function () {
					if (enquiryReturnFocus && typeof enquiryReturnFocus.focus === 'function') {
						enquiryReturnFocus.focus({ preventScroll: true });
					}
					enquiryReturnFocus = null;
				});
			}
		}

		if (prevBtn) {
			prevBtn.addEventListener('click', function () {
				showMonth(index - 1);
			});
		}
		if (nextBtn) {
			nextBtn.addEventListener('click', function () {
				var vis = visibleCount();
				ensureMonths(Math.min(maxMonths - 1, index + vis));
				showMonth(index + 1);
			});
		}

		if (typeof twoUp.addEventListener === 'function') {
			twoUp.addEventListener('change', function () {
				showMonth(index);
			});
		}

		showMonth(0);
		setEnquire('', '');
		setStay('', '');
	}

	ready(function () {
		document.querySelectorAll('[data-availability]').forEach(initDiary);
	});
})();
