/**
 * Restwell CRM — inline status-change UI for the enquiries list.
 *
 * Clicking a `.rw-status-badge[data-enquiry-id]` element replaces it with an
 * inline <select> populated from `rwCrmActions.statuses`. On change the new
 * status is sent to the `restwell_lead_action` AJAX endpoint and the badge is
 * updated with the HTML returned by the server.
 *
 * No jQuery. Vanilla fetch() + FormData only.
 */
/* global rwCrmActions */

( function () {
	'use strict';

	/**
	 * Build a <select> element pre-populated with all CRM statuses.
	 *
	 * @param {string} currentStatus - The enquiry's current status key.
	 * @returns {HTMLSelectElement}
	 */
	function buildSelect( currentStatus ) {
		var select = document.createElement( 'select' );
		select.className = 'rw-status-inline-select';
		select.setAttribute( 'aria-label', 'Change status' );

		Object.keys( rwCrmActions.statuses ).forEach( function ( key ) {
			var option = document.createElement( 'option' );
			option.value = key;
			option.textContent = rwCrmActions.statuses[ key ].label || key;
			if ( key === currentStatus ) {
				option.selected = true;
			}
			select.appendChild( option );
		} );

		return select;
	}

	/**
	 * Announce status changes to the list summary live region (mobile).
	 *
	 * @param {string} message - Status text for screen readers.
	 */
	function announceStatusChange( message ) {
		var live = document.querySelector( '.rw-enquiries-summary' );
		if ( ! live || ! message ) {
			return;
		}
		live.textContent = message;
	}

	/**
	 * Toggle saving state on the badge wrapper.
	 *
	 * @param {HTMLElement} wrapper - The `.rw-status-badge` wrapper element.
	 * @param {boolean}     saving  - Whether a save is in flight.
	 */
	function setSavingState( wrapper, saving ) {
		wrapper.classList.toggle( 'rw-status-badge--loading', saving );
		wrapper.setAttribute( 'aria-busy', saving ? 'true' : 'false' );
	}

	/**
	 * Re-append the mobile status hint after AJAX badge refresh.
	 *
	 * @param {HTMLElement} wrapper - The `.rw-status-badge` wrapper element.
	 */
	function restoreMobileStatusHint( wrapper ) {
		if ( ! wrapper.closest( '.rw-enquiry-card' ) ) {
			return;
		}
		if ( wrapper.querySelector( '.rw-status-hint' ) ) {
			return;
		}
		var hint = document.createElement( 'span' );
		hint.className = 'rw-status-hint';
		hint.textContent =
			( rwCrmActions.i18n && rwCrmActions.i18n.statusHint ) || 'Tap to change';
		wrapper.appendChild( hint );
	}

	/**
	 * Show a brief inline error message beside the badge wrapper.
	 *
	 * @param {HTMLElement} wrapper - The `.rw-status-badge` wrapper element.
	 * @param {string}      message - Error text to display.
	 */
	function showInlineError( wrapper, message ) {
		var existing = wrapper.querySelector( '.rw-status-error' );
		if ( existing ) {
			existing.remove();
		}
		var err = document.createElement( 'span' );
		err.className = 'rw-status-error';
		err.textContent = message;
		wrapper.appendChild( err );
		setTimeout( function () {
			err.remove();
		}, 4000 );
	}

	/**
	 * Wire up inline status-change behaviour on a single badge wrapper.
	 *
	 * @param {HTMLElement} wrapper - Element with class `rw-status-badge` and a
	 *                                `data-enquiry-id` attribute.
	 */
	function initBadge( wrapper ) {
		var enquiryId = wrapper.getAttribute( 'data-enquiry-id' );
		if ( ! enquiryId ) {
			return;
		}

		// Store the original badge HTML so we can restore it on error.
		var originalHTML = wrapper.innerHTML;
		var statusKey = wrapper.getAttribute( 'data-status-key' ) || '';

		wrapper.setAttribute( 'role', 'button' );
		wrapper.setAttribute( 'tabindex', '0' );

		function openStatusSelect() {
			// Skip if a select is already open.
			if ( wrapper.querySelector( '.rw-status-inline-select' ) ) {
				return;
			}

			if ( ! statusKey && wrapper.querySelector( '.rw-status-pill' ) ) {
				var currentLabel = wrapper.querySelector( '.rw-status-pill' ).textContent.trim();
				Object.keys( rwCrmActions.statuses ).forEach( function ( key ) {
					if (
						rwCrmActions.statuses[ key ].label &&
						rwCrmActions.statuses[ key ].label === currentLabel
					) {
						statusKey = key;
					}
				} );
			}

			var select = buildSelect( statusKey );

			// Replace badge content with the select.
			wrapper.innerHTML = '';
			wrapper.appendChild( select );
			select.focus();

			select.addEventListener( 'change', function onChange() {
				var newStatus = select.value;
				if ( newStatus === statusKey ) {
					// No change — restore original.
					wrapper.innerHTML = originalHTML;
					return;
				}

				// Disable the select while the request is in flight.
				select.disabled = true;
				setSavingState( wrapper, true );

				var formData = new FormData();
				formData.append( 'action', 'restwell_lead_action' );
				formData.append( 'action_type', 'set_status' );
				formData.append( 'lead_id', enquiryId );
				formData.append( 'new_status', newStatus );
				formData.append( 'nonce', rwCrmActions.nonce );

				fetch( rwCrmActions.ajaxurl, {
					method: 'POST',
					body: formData,
					credentials: 'same-origin',
				} )
					.then( function ( response ) {
						return response.json();
					} )
					.then( function ( data ) {
						setSavingState( wrapper, false );
						if ( data.success && data.data && data.data.updated_status_html ) {
							// Update original HTML reference so subsequent clicks see new state.
							originalHTML = data.data.updated_status_html;
							statusKey = data.data.updated_status || newStatus;
							wrapper.setAttribute( 'data-status-key', statusKey );
							wrapper.innerHTML = data.data.updated_status_html;
							restoreMobileStatusHint( wrapper );
							var label =
								( rwCrmActions.statuses[ statusKey ] &&
									rwCrmActions.statuses[ statusKey ].label ) ||
								statusKey;
							announceStatusChange( 'Status updated to ' + label + '.' );
						} else {
							wrapper.innerHTML = originalHTML;
							showInlineError(
								wrapper,
								( data.data && data.data.message ) || 'Update failed.'
							);
							announceStatusChange(
								( data.data && data.data.message ) || 'Status update failed.'
							);
						}
					} )
					.catch( function () {
						setSavingState( wrapper, false );
						wrapper.innerHTML = originalHTML;
						showInlineError( wrapper, 'Network error. Please try again.' );
						announceStatusChange( 'Status update failed. Network error.' );
					} );
			} );

			// Pressing Escape cancels the interaction (not while saving).
			select.addEventListener( 'keydown', function ( e ) {
				if ( e.key === 'Escape' && ! select.disabled ) {
					wrapper.innerHTML = originalHTML;
				}
			} );

			// Clicking outside cancels — but not while a save request is in flight
			// (select is disabled), otherwise blur races the fetch and resets the UI.
			select.addEventListener( 'blur', function () {
				setTimeout( function () {
					if ( select.disabled ) {
						return;
					}
					if ( wrapper.querySelector( '.rw-status-inline-select' ) ) {
						wrapper.innerHTML = originalHTML;
					}
				}, 200 );
			} );
		}

		wrapper.addEventListener( 'click', function ( e ) {
			if ( e.target.tagName === 'SELECT' || e.target.tagName === 'OPTION' ) {
				return;
			}
			openStatusSelect();
		} );

		wrapper.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Enter' || e.key === ' ' ) {
				e.preventDefault();
				openStatusSelect();
			}
		} );
	}

	/**
	 * Select-all checkbox for the bulk-actions table.
	 */
	function initBulkSelectAll() {
		var selectAll = document.getElementById( 'cb-select-all' );
		if ( ! selectAll ) {
			return;
		}
		selectAll.addEventListener( 'change', function () {
			document.querySelectorAll( '[name="rw_bulk_ids[]"]' ).forEach( function ( cb ) {
				cb.checked = selectAll.checked;
			} );
		} );
	}

	/**
	 * Hide the inactive list layout from assistive tech (both exist in the DOM).
	 */
	function syncListLayoutA11y() {
		var desktop = document.querySelector( '.rw-enquiries-desktop' );
		var cards = document.querySelector( '.rw-enquiries-cards' );
		var mobileNav = document.querySelector( '.rw-enquiries-mobile-nav' );
		if ( ! desktop || ! cards ) {
			return;
		}
		var isDesktop = window.matchMedia( '(min-width: 783px)' ).matches;
		desktop.setAttribute( 'aria-hidden', isDesktop ? 'false' : 'true' );
		cards.setAttribute( 'aria-hidden', isDesktop ? 'true' : 'false' );
		if ( mobileNav ) {
			mobileNav.setAttribute( 'aria-hidden', isDesktop ? 'true' : 'false' );
		}
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		initBulkSelectAll();
		syncListLayoutA11y();
		window.addEventListener( 'resize', syncListLayoutA11y );

		if ( typeof rwCrmActions === 'undefined' ) {
			return;
		}

		var badges = document.querySelectorAll( '.rw-status-badge[data-enquiry-id]' );
		badges.forEach( function ( badge ) {
			initBadge( badge );
			badge.setAttribute( 'title', 'Click to change status' );
			badge.setAttribute( 'aria-label', 'Change enquiry status' );
		} );
	} );
} )();
