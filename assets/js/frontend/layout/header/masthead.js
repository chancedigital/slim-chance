import { throttle } from 'lodash';
import { breakpoints } from '../../lib/class-media-query';

export default () => {
	const els = {
		$masthead: $( '#js-masthead' ),
		$topNavWrapper: $( '#js-masthead-nav-wrapper' ),
		$toggle: $( '#js-masthead-menu-toggle' ),
	};
	const { $masthead, $toggle, $topNavWrapper } = els;
	const mastheadHeight = $masthead.outerHeight();

	// Sticky header class.
	const stickyFlag = 'sticky';
	const navOpenFlag = 'nav-open';
	const mastheadStickyClass = `masthead--${ stickyFlag }`;

	const handleMasthead = throttle(
		function( e ) {
			// Set current top position.
			const currentTop = $( window ).scrollTop();

			if ( mastheadHeight / 2 < e.currentTarget.scrollY ) {
				$masthead.addClass( mastheadStickyClass );
			} else {
				$masthead.removeClass( mastheadStickyClass );
			}

			// Set previous top position to starting current position.
			this.previousTop = currentTop;
		},
		150,
	);

	if ( window.matchMedia( `(min-width: ${ breakpoints.medium }px)` ).matches ) {
		$( window ).load( handleMasthead );
		$( window ).scroll( { previousTop: 0 }, handleMasthead );
	}

	$( window ).on( 'mqChanged', function( e ) {
		const { newSize, oldSize } = e.detail;
		if ( 'small' === newSize ) {
			$masthead.removeClass( mastheadStickyClass );
			$( window ).unbind( 'scroll' );
		} else if ( 'medium' === newSize && 'small' === oldSize ) {
			$( window ).scroll( { previousTop: 0 }, handleMasthead );
		}
	} );

	$toggle.click( function() {
		$topNavWrapper.toggleClass( `masthead__nav-wrapper--${ navOpenFlag }` );
		$( 'body' ).toggleClass( navOpenFlag );
		$( this ).toggleClass( `masthead__hamburger--${ navOpenFlag }` );
	} );
};
