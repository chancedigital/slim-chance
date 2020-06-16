export default () => {
	const $hamburger = $( '.hamburger' );

	$hamburger.click( function() {
		$( this ).toggleClass( 'hamburger--active' );
	} );
};
