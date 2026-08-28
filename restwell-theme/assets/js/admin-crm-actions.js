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
		err.style.cssText = 'display:block;color:#d63638;font-size:0.8em;margin-top:2px;';
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
		var currentStatus = wrapper.querySelector( '.rw-status-pill' )
			? wrapper.querySelector( '.rw-status-pill' ).textContent.trim()
			: '';

		wrapper.addEventListener( 'click', function ( e ) {
			// Only activate when clicking the pill itself, not during a select interaction.
			if ( e.target.tagName === 'SELECT' || e.target.tagName === 'OPTION' ) {
				return;
			}

			// Skip if a select is already open.
			if ( wrapper.querySelector( '.rw-status-inline-select' ) ) {
				return;
			}

			// Derive the current status key from the data attribute if available,
			// otherwise fall back to the first matching key by label.
			var statusKey = '';
			Object.keys( rwCrmActions.statuses ).forEach( function ( key ) {
				if (
					rwCrmActions.statuses[ key ].label &&
					rwCrmActions.statuses[ key ].label === currentStatus
				) {
					statusKey = key;
				}
			} );

			var select = buildSelect( statusKey );

			// Replace badge content with the select.
			wrapper.innerHTML = '';
			wrapper.appendChild( select );
			select.focus();

			select.addEventListener( 'change', function () {
				var newStatus = select.value;
				if ( newStatus === statusKey ) {
					// No change — restore original.
					wrapper.innerHTML = originalHTML;
					return;
				}

				// Disable the select while the request is in flight.
				select.disabled = true;

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
						if ( data.success && data.data && data.data.updated_status_html ) {
							// Update original HTML reference so subsequent clicks see new state.
							originalHTML = data.data.updated_status_html;
							currentStatus = data.data.updated_status || newStatus;
							wrapper.innerHTML = data.data.updated_status_html;
						} else {
							wrapper.innerHTML = originalHTML;
							showInlineError(
								wrapper,
								( data.data && data.data.message ) || 'Update failed.'
							);
						}
					} )
					.catch( function () {
						wrapper.innerHTML = originalHTML;
						showInlineError( wrapper, 'Network error. Please try again.' );
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

	document.addEventListener( 'DOMContentLoaded', function () {
		initBulkSelectAll();

		if ( typeof rwCrmActions === 'undefined' ) {
			return;
		}

		var badges = document.querySelectorAll( '.rw-status-badge[data-enquiry-id]' );
		badges.forEach( function ( badge ) {
			initBadge( badge );
			// Give a visual hint that the badge is interactive.
			badge.style.cursor = 'pointer';
			badge.setAttribute( 'title', 'Click to change status' );
		} );
	} );
} )();
