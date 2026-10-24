/**
 * Restwell Media Import — send the release media zip in pieces.
 *
 * Hosts often cap a single upload below the media zip's size, so the zip goes
 * up in small pieces (rwMediaImport.chunk bytes each), in order, and the last
 * piece unpacks it. Without fetch/Blob support the form posts in one piece.
 *
 * Enqueued only on Media → Restwell Media Import.
 * No jQuery dependency. No third-party libraries.
 */
/* global rwMediaImport */

( function () {
	'use strict';

	var form = document.getElementById( 'restwell-media-zip-form' );
	if ( ! form || ! window.fetch || ! window.FormData || ! window.crypto || ! Blob.prototype.slice ) {
		return;
	}

	// wp_localize_script passes numbers as strings.
	var pieceBytes = parseInt( rwMediaImport.chunk, 10 ) || 4194304;
	var input = form.querySelector( 'input[type="file"]' );
	var button = form.querySelector( '[type="submit"]' );
	var status = form.querySelector( '.restwell-media-zip__status' );

	/**
	 * Random upload id, so two uploads never share a file on the server.
	 *
	 * @returns {string}
	 */
	function uploadId() {
		var bytes = window.crypto.getRandomValues( new Uint8Array( 16 ) );
		return Array.prototype.map.call( bytes, function ( b ) {
			return ( '0' + b.toString( 16 ) ).slice( -2 );
		} ).join( '' );
	}

	/**
	 * Send piece `index` and, once it lands, the next one.
	 *
	 * @param {File}   file
	 * @param {string} id
	 * @param {number} index
	 * @param {number} total
	 * @returns {Promise<Object>} The server's result after the last piece.
	 */
	function sendPiece( file, id, index, total ) {
		var size = pieceBytes;
		var data = new FormData();
		data.append( 'action', 'restwell_media_zip_chunk' );
		data.append( 'nonce', rwMediaImport.nonce );
		data.append( 'upload_id', id );
		data.append( 'index', String( index ) );
		data.append( 'total', String( total ) );
		data.append( 'offset', String( index * size ) );
		data.append( 'chunk', file.slice( index * size, Math.min( file.size, ( index + 1 ) * size ) ), 'chunk.bin' );

		status.textContent = index === total - 1
			? rwMediaImport.unpacking
			: rwMediaImport.uploading.replace( '%1$d', String( index + 1 ) ).replace( '%2$d', String( total ) );

		return fetch( rwMediaImport.ajaxurl, { method: 'POST', body: data, credentials: 'same-origin' } )
			.then( function ( response ) {
				return response.json().catch( function () {
					return null;
				} );
			} )
			.then( function ( result ) {
				if ( ! result || ! result.success ) {
					throw new Error( result && result.data && result.data.message ? result.data.message : rwMediaImport.failed );
				}
				return index + 1 < total ? sendPiece( file, id, index + 1, total ) : result.data;
			} );
	}

	form.addEventListener( 'submit', function ( event ) {
		var file = input.files && input.files[ 0 ];
		if ( ! file ) {
			return;
		}
		event.preventDefault();
		button.disabled = true;

		var total = Math.max( 1, Math.ceil( file.size / pieceBytes ) );
		sendPiece( file, uploadId(), 0, total )
			.then( function ( result ) {
				status.textContent = result.message;
				input.value = '';
			} )
			.catch( function ( error ) {
				status.textContent = error.message || rwMediaImport.failed;
			} )
			.then( function () {
				button.disabled = false;
			} );
	} );
}() );
