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
		var months = root.querySelectorAll('[data-availability-month]');
		var prevBtn = root.querySelector('[data-availability-prev]');
		var nextBtn = root.querySelector('[data-availability-next]');
		var live = root.querySelector('[data-availability-live]');
		var enquire = root.querySelector('[data-availability-enquire]');
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
		if (!months.length) return;

		var index = 0;
		var startIso = '';
		var endIso = '';
		var booked = {};
		var twoUp = window.matchMedia('(min-width: 768px)');

		root.querySelectorAll('.availability__day.is-booked[data-iso]').forEach(function (td) {
			booked[td.getAttribute('data-iso')] = true;
		});

		function visibleCount() {
			return twoUp.matches ? 2 : 1;
		}

		function showMonth(nextIndex) {
			var vis = visibleCount();
			var maxStart = Math.max(0, months.length - vis);
			if (nextIndex < 0) nextIndex = 0;
			if (nextIndex > maxStart) nextIndex = maxStart;
			index = nextIndex;
			months.forEach(function (month, i) {
				var on = i >= index && i < index + vis;
				month.classList.toggle('is-active', on);
				month.hidden = !on;
			});
			if (prevBtn) prevBtn.disabled = index === 0;
			if (nextBtn) nextBtn.disabled = index >= maxStart;
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
			var complete = !!(from && to);
			if (stay) stay.classList.toggle('is-empty', !complete);
			if (clearBtn) clearBtn.hidden = !complete;
			if (fromField) fromField.classList.toggle('is-active', !from);
			if (toField) toField.classList.remove('is-active');
			if (fromEl) fromEl.textContent = from ? prettyDay(from) : '—';
			if (toEl) {
				if (!from) {
					toEl.textContent = '—';
				} else {
					var last = to || from;
					toEl.textContent = prettyDay(addDays(last, 1));
				}
			}
			if (!complete) {
				if (quoteBox) quoteBox.hidden = true;
				if (countEl) countEl.textContent = '';
				clearBreakdownRows();
				if (prompt) {
					prompt.hidden = false;
					prompt.textContent = defaultPrompt;
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
					prompt.textContent = 'Tap another night to stay longer.';
				} else {
					prompt.hidden = true;
				}
			}
		}

		function setEnquire(fromNight, toNight) {
			if (!enquire) return;
			if (!fromNight || !toNight) {
				enquire.setAttribute('href', enquireUrl);
				enquire.removeAttribute('aria-label');
				enquire.classList.add('is-disabled');
				enquire.setAttribute('aria-disabled', 'true');
				enquire.setAttribute('tabindex', '-1');
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
				setLive('One night, leaving ' + leave + '. Tap another night to stay longer.');
			} else {
				setLive(nights.length + ' nights, leaving ' + leave + '.');
			}
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
			var oneNight = !!(startIso && endIso && startIso === endIso);
			if (!startIso || !oneNight) {
				applyStay(iso, iso, true);
				return;
			}
			if (iso === startIso) {
				return;
			}
			if (rangeTouchesBooked(startIso, iso)) {
				var blocked = 'Those nights are already held. Try a stretch that doesn’t cross a booking.';
				if (prompt) {
					prompt.hidden = false;
					prompt.textContent = blocked;
				}
				setLive(blocked);
				return;
			}
			var arrival = startIso < iso ? startIso : iso;
			var lastNight = startIso < iso ? iso : startIso;
			applyStay(arrival, lastNight, false);
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
				}
			});
		}

		if (prevBtn) {
			prevBtn.addEventListener('click', function () {
				showMonth(index - 1);
			});
		}
		if (nextBtn) {
			nextBtn.addEventListener('click', function () {
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
