( function( $ ) {

	'use strict';

	$( document ).ready( function( $ ) {

		$( '.widget' ).find( 'ul' ).addClass( 'list-unstyled' );

		$( '#site-navigation' ).meanmenu( {
			meanScreenWidth: '640',
			meanMenuOpen: '<span /><span /><span /><span class="screen-reader-text">Expand Menu</span>',
			meanMenuClose: 'X<span class="screen-reader-text">Collapse Menu</span>'
		});

		// Implement go to top.
		if ( $( '#btn-scrollup' ).length > 0 ) {

			$( window ).scroll( function() {
				if ( $( this ).scrollTop() > 100 ) {
					$( '#btn-scrollup' ).fadeIn();
				} else {
					$( '#btn-scrollup' ).fadeOut();
				}
			});

			$( '#btn-scrollup' ).click( function() {
				$( 'html, body' ).animate( { scrollTop: 0 }, 600 );
				return false;
			});

		}

	});

} )( jQuery );
