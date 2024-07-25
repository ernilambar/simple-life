( function( $ ) {
	'use strict';

	$( document ).ready( function() {
		$( '.widget' ).find( 'ul' ).addClass( 'list-unstyled' );
		$( '.widget' ).find( 'ol' ).addClass( 'list-unstyled' );

		$( '#site-navigation' ).meanmenu( {
			meanScreenWidth: '640',
			meanMenuOpen:
				'<span /><span /><span /><span class="screen-reader-text">' +
				simpleLifeScreenReaderText.expand +
				'</span>',
			meanMenuClose:
				'X<span class="screen-reader-text">' +
				simpleLifeScreenReaderText.collapse +
				'</span>',
		} );

		// Implement go to top.
		if ( $( '#btn-scrollup' ).length > 0 ) {
			$( window ).on( 'scroll', function() {
				if ( $( this ).scrollTop() > 100 ) {
					$( '#btn-scrollup' ).fadeIn();
				} else {
					$( '#btn-scrollup' ).fadeOut();
				}
			} );

			$( '#btn-scrollup' ).on( 'click', function() {
				$( 'html, body' ).animate( { scrollTop: 0 }, 600 );
				return false;
			} );
		}
	} );
}( jQuery ) );
