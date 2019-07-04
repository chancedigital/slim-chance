// Localized global variables from inc/scripts.php.
const { __slimChanceAjax__ } = window;
const { ajaxUrl, loadButton = {}, nonce } = __slimChanceAjax__ || {};

export default {
	/**
	 * Initialize the component.
	 */
	init() {
		const _self = this;
		this.getClickListener = this.getClickListener.bind( this );

		// Placeholder for section containers.
		this.sections = [];

		// Find all of the load more buttons.
		// ID must always start with `js-load-more`
		this.$buttons = $( '[id^=js-load-more]' );

		// Iterate through each button to cache elements/variables for each section
		// So long as each section has a unique ID, multiple `load more` sections
		// can coexist on the same page.
		this.$buttons.each( function( index ) {
			const $button = $( this );
			const sectionId = $button.data( 'section-id' );
			const $sectionWrapper = $( `#${ sectionId }` );
			const $moreWrapper = $sectionWrapper.find( '[id^=js-posts-container]' );
			const section = {
				$button,
				$moreWrapper,
				$sectionWrapper,
				currentPage: parseInt( $button.data( 'current-page' ) ),
				index,
				maxPages: parseInt( $button.data( 'max-pages' ) ),
				offset: parseInt( $button.data( 'offset' ) ),
				query: $button.data( 'query' ),
				sectionId,
				wrapperClass: $button.data( 'wrapper-class' ),
				wrapperEl: $button.data( 'wrapper-element' ),
			};
			const clickListener = _self.getClickListener( section );
			section.clickListener = clickListener;
			_self.sections[ index ] = section;
			clickListener();
		} );
	},

	getClickListener( section ) {
		const {
			$button,
			$moreWrapper,
			index,
			maxPages,
			query,
			wrapperClass,
			wrapperEl,
		} = section;
		const _self = this;
		return function() {
			$button.click( function() {
				if ( $moreWrapper ) {
					const $clicked = $( this );
					const originalLabel = $clicked.html();
					const wrapper = { element: wrapperEl, className: wrapperClass };
					const offset = _self.sections[ index ].offset;
					const currentPage = _self.sections[ index ].currentPage;

					$.ajax( {
						url: ajaxUrl,
						data: {
							action: 'load_more_posts',
							query,
							page: currentPage,
							offset,
							nonce,
							wrapper,
						},
						type: 'POST',
						beforeSend() {
							// Change the button text.
							$clicked.html( loadButton.loading );
						},
						success( data ) {
							if ( data ) {
								const $data = $( data );
								$clicked.html( originalLabel );
								$data
									.hide()
									.appendTo( $moreWrapper )
									.fadeIn( 1000 );
								_self.sections[ index ].currentPage++;
								_self.sections[ index ].offset += parseInt( query.posts_per_page || 0 );

								if ( currentPage === maxPages ) {
									// If you're on the last page, remove the button.
									$clicked.remove();
								}
							} else {
								// If no data, update the button text and then disable it.
								$clicked.html( loadButton.noPosts );
								$clicked.attr( 'disabled', true );
							}
						},
						error( e, t ) {
							console.error( e, t );
						},
					} );
				}
			} );
		};
	},
};
