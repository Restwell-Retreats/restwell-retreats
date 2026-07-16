/**
 * Restwell Media Library — video compressor UI.
 *
 * Handles the "Compress for web" button that appears on MP4 attachment detail
 * panels. Sends an AJAX request to compress the video via server-side FFmpeg,
 * then displays the result inline.
 *
 * Enqueued only on the Media Library (upload.php) screen.
 * No jQuery dependency. No third-party libraries.
 */
/* global rwVideoCompressor */

( function () {
	'use strict';

	/**
	 * Find the status container that belongs to a given button.
	 *
	 * The button ID is `restwell-compress-video-btn-{id}` and the status div
	 * is `restwell-compress-video-status-{id}`.
	 *
	 * @param {HTMLButtonElement} btn
	 * @returns {HTMLElement|null}
	 */
	function getStatusEl( btn ) {
		var attachmentId = btn.dataset.attachmentId;
		return document.getElementById( 'restwell-compress-video-status-' + attachmentId );
	}

	/**
	 * Show a message in the status element below the button.
	 *
	 * @param {HTMLElement} statusEl  The status container.
	 * @param {string}      message   Text to display.
	 * @param {boolean}     isError   When true, renders the message in red.
	 */
	function showStatus( statusEl, message, isError ) {
		if ( ! statusEl ) {
			return;
		}
		statusEl.textContent = message;
		statusEl.style.color = isError ? '#d63638' : '#1d2327';
	}

	/**
	 * Handle a click on any "Compress for web" button.
	 *
	 * @param {MouseEvent} e
	 */
	function handleClick( e ) {
		var btn = e.target.closest( '[data-attachment-id][data-nonce]' );

		// Ignore clicks that aren't on (or inside) a compressor button.
		if ( ! btn || ! btn.id || btn.id.indexOf( 'restwell-compress-video-btn-' ) !== 0 ) {
			return;
		}

		var attachmentId = btn.dataset.attachmentId;
		var nonce        = btn.dataset.nonce;
		var statusEl     = getStatusEl( btn );
		var confirmMsg   = btn.dataset.confirm || '';

		if ( confirmMsg && ! window.confirm( confirmMsg ) ) {
			return;
		}

		// Disable button and show working state.
		btn.disabled     = true;
		btn.textContent  = rwVideoCompressor.labelWorking;
		showStatus( statusEl, '', false );

		var body = new FormData();
		body.append( 'action', rwVideoCompressor.action );
		body.append( 'attachment_id', attachmentId );
		body.append( 'nonce', nonce );

		fetch( rwVideoCompressor.ajaxurl, {
			method:      'POST',
			credentials: 'same-origin',
			body:        body,
		} )
			.then( function ( response ) {
				return response.json().then( function ( data ) {
					return { ok: response.ok, data: data };
				} );
			} )
			.then( function ( result ) {
				var data = result.data || {};
				if ( result.ok && data.success ) {
					var msg = rwVideoCompressor.successPrefix
						+ data.mp4_size_mb
						+ rwVideoCompressor.successMid
						+ data.webm_size_mb
						+ rwVideoCompressor.successSuffix;
					showStatus( statusEl, msg, false );
					return;
				}
				var errMsg = ( data.message && data.message.length )
					? data.message
					: rwVideoCompressor.errorFallback;
				showStatus( statusEl, errMsg, true );
			} )
			.catch( function () {
				showStatus( statusEl, rwVideoCompressor.errorFallback, true );
			} )
			.finally( function () {
				btn.disabled    = false;
				btn.textContent = rwVideoCompressor.labelDefault;
			} );
	}

	// Use event delegation so the handler survives attachment panel re-renders
	// when the user clicks between items in the Media Library grid.
	document.addEventListener( 'click', handleClick );
}() );
