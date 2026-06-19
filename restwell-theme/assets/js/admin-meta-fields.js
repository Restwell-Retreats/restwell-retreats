/**
 * Admin meta fields – tab switching, localStorage persistence, and media upload.
 *
 * @package Restwell_Retreats
 */
( function () {
	var wrapper = document.querySelector( '.restwell-meta-fields' );
	if ( ! wrapper ) return;

	var tabs    = wrapper.querySelectorAll( '.restwell-nav-tab' );
	var panels  = wrapper.querySelectorAll( '.restwell-tab-panel' );
	var postId  = wrapper.getAttribute( 'data-post-id' ) || '0';
	var storeKey = 'restwell_tab_' + postId;

	/**
	 * Activate a specific tab by its panel ID.
	 *
	 * @param {string} panelId
	 */
	function activateTab( panelId ) {
		tabs.forEach( function ( t ) { t.classList.remove( 'nav-tab-active' ); } );
		panels.forEach( function ( p ) { p.classList.remove( 'active' ); } );

		var matchTab = wrapper.querySelector( '.restwell-nav-tab[data-panel="' + panelId + '"]' );
		var matchPanel = wrapper.querySelector( '#' + panelId );

		if ( matchTab ) matchTab.classList.add( 'nav-tab-active' );
		if ( matchPanel ) matchPanel.classList.add( 'active' );
	}

	// Restore persisted tab on load.
	var saved = '';
	try {
		saved = localStorage.getItem( storeKey ) || '';
	} catch ( e ) { /* private browsing */ }
	if ( saved ) {
		activateTab( saved );
	}

	// Handle tab clicks.
	tabs.forEach( function ( tab ) {
		tab.addEventListener( 'click', function ( e ) {
			e.preventDefault();
			var panelId = tab.getAttribute( 'data-panel' );
			activateTab( panelId );
			try {
				localStorage.setItem( storeKey, panelId );
			} catch ( e ) { /* private browsing */ }
		} );
	} );

	// Media upload buttons.
	function initMediaButtons() {
		if ( typeof wp === 'undefined' || ! wp.media ) return;
		var parsedPostId = postId ? parseInt( postId, 10 ) : null;

		wrapper.querySelectorAll( '.restwell-select-image' ).forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				var upload = this.closest( '.restwell-image-upload' );
				if ( ! upload ) return;

				var allowed    = upload.getAttribute( 'data-allowed-types' ) || 'image';
				var frameOpts  = { multiple: false };
				if ( parsedPostId ) frameOpts.post = parsedPostId;
				if ( allowed !== 'image,video' ) {
					frameOpts.library = { type: 'image' };
				}

				var mediaFrame = wp.media( frameOpts );
				mediaFrame.on( 'select', function () {
					var selection = mediaFrame.state().get( 'selection' );
					if ( ! selection.length ) return;

					var attachment  = selection.first().toJSON();
					var input       = upload.querySelector( 'input[type="hidden"]' );
					var preview     = upload.querySelector( '.restwell-image-preview' );
					var img         = preview ? preview.querySelector( 'img' ) : null;
					var previewText = preview ? preview.querySelector( '.restwell-media-preview-text' ) : null;
					var removeBtn   = upload.querySelector( '.restwell-remove-image' );

					if ( input ) input.value = attachment.id;
					if ( preview ) preview.style.display = 'block';
					if ( removeBtn ) removeBtn.style.display = 'inline-block';

					var isVideo = attachment.type === 'video' ||
						( attachment.mimeType && attachment.mimeType.indexOf( 'video/' ) === 0 );

					if ( isVideo && previewText ) {
						previewText.textContent = 'Video selected';
						previewText.style.display = '';
						if ( img ) img.style.display = 'none';
					} else if ( img ) {
						img.src = ( attachment.sizes && attachment.sizes.medium && attachment.sizes.medium.url )
							? attachment.sizes.medium.url
							: ( attachment.url || '' );
						img.style.display = '';
						if ( previewText ) previewText.style.display = 'none';
					}
				} );
				mediaFrame.open();
			} );
		} );

		wrapper.querySelectorAll( '.restwell-remove-image' ).forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				var upload = this.closest( '.restwell-image-upload' );
				if ( ! upload ) return;

				var input       = upload.querySelector( 'input[type="hidden"]' );
				var preview     = upload.querySelector( '.restwell-image-preview' );
				var img         = preview ? preview.querySelector( 'img' ) : null;
				var previewText = preview ? preview.querySelector( '.restwell-media-preview-text' ) : null;

				if ( input ) input.value = '';
				if ( img ) { img.removeAttribute( 'src' ); img.style.display = ''; }
				if ( previewText ) previewText.style.display = 'none';
				if ( preview ) preview.style.display = 'none';
				this.style.display = 'none';
			} );
		} );
	}

	function initGalleryFields() {
		if ( typeof wp === 'undefined' || ! wp.media ) return;

		wrapper.querySelectorAll( '.restwell-gallery-upload' ).forEach( function ( upload ) {
			var input = upload.querySelector( 'input[type="hidden"]' );
			var list  = upload.querySelector( '.restwell-gallery-preview' );
			var addBtn = upload.querySelector( '.restwell-select-gallery' );
			if ( ! input || ! list || ! addBtn ) return;

			function readIds() {
				var raw = ( input.value || '' ).trim();
				if ( ! raw ) return [];
				return raw.split( /\s*,\s*/ ).map( function ( v ) {
					return parseInt( v, 10 );
				} ).filter( function ( n ) {
					return n > 0;
				} );
			}

			function writeIds( ids ) {
				input.value = ids.join( ',' );
			}

			function renderItem( attachment ) {
				var li = document.createElement( 'li' );
				li.className = 'restwell-gallery-preview__item';
				li.setAttribute( 'data-id', String( attachment.id ) );
				var img = document.createElement( 'img' );
				img.src = ( attachment.sizes && attachment.sizes.thumbnail && attachment.sizes.thumbnail.url )
					? attachment.sizes.thumbnail.url
					: ( attachment.url || '' );
				img.alt = '';
				img.width = 80;
				img.height = 80;
				var remove = document.createElement( 'button' );
				remove.type = 'button';
				remove.className = 'button-link restwell-gallery-remove';
				remove.setAttribute( 'aria-label', 'Remove image' );
				remove.innerHTML = '&times;';
				remove.addEventListener( 'click', function () {
					var ids = readIds().filter( function ( id ) {
						return id !== attachment.id;
					} );
					writeIds( ids );
					li.remove();
				} );
				li.appendChild( img );
				li.appendChild( remove );
				list.appendChild( li );
			}

			addBtn.addEventListener( 'click', function () {
				var frame = wp.media( {
					library: { type: 'image' },
					multiple: true,
				} );
				frame.on( 'select', function () {
					var selection = frame.state().get( 'selection' );
					var ids = readIds();
					selection.each( function ( model ) {
						var attachment = model.toJSON();
						if ( ids.indexOf( attachment.id ) !== -1 ) return;
						ids.push( attachment.id );
						renderItem( attachment );
					} );
					writeIds( ids );
				} );
				frame.open();
			} );

			list.querySelectorAll( '.restwell-gallery-remove' ).forEach( function ( btn ) {
				btn.addEventListener( 'click', function () {
					var item = btn.closest( '.restwell-gallery-preview__item' );
					if ( ! item ) return;
					var id = parseInt( item.getAttribute( 'data-id' ), 10 );
					writeIds( readIds().filter( function ( v ) {
						return v !== id;
					} ) );
					item.remove();
				} );
			} );
		} );
	}

	if ( typeof wp !== 'undefined' && wp.media ) {
		initMediaButtons();
		initGalleryFields();
	} else {
		var attempts = 0;
		function tryInit() {
			if ( typeof wp !== 'undefined' && wp.media ) {
				initMediaButtons();
				initGalleryFields();
			} else if ( attempts < 40 ) {
				attempts++;
				setTimeout( tryInit, 50 );
			}
		}
		window.addEventListener( 'load', tryInit );
	}
} )();
