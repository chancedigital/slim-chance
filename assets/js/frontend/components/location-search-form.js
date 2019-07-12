import loadGoogleMapsApi from 'load-google-maps-api';
const { __slimChanceAjax__ } = window;

function getQueryParams() {
	const search = window.location.search.substring( 1 );
	if ( search ) {
		return JSON.parse(
			'{"' + search.replace( /&/g, '","' ).replace( /=/g, '":"' ) + '"}',
			( key, value ) => ( key === '' ? value : decodeURIComponent( value ) ),
		);
	}
	return {};
}

export default {
	/**
	 * Initialize the component.
	 */
	init() {
		this.initAutocomplete = this.initAutocomplete.bind( this );
		this.geoLocate = this.geoLocate.bind( this );
		this.form = document.getElementById( 'js-location-search-form' );
		this.address = document.getElementById( 'js-location-search-address' );
		this.lat = document.getElementById( 'js-location-search-lat' );
		this.lng = document.getElementById( 'js-location-search-lng' );
		this.initAutocomplete();
	},

	// Check geo-location first
	// If enabled, trigger a search automatically based on coordinates.
	geoLocate() {
		const qs = getQueryParams();
		const options = {
			enableHighAccuracy: true,
			timeout: 5000,
			maximumAge: 0,
		};
		const onSuccess = position => {
			const { coords } = position;
			this.lat.value = coords.latitude;
			this.lng.value = coords.longitude;
			this.form.submit();
		};
		const onError = error => {
			console.warn( `Error ${ error.code }: ${ error.message }` );
		};
		if ( navigator.geolocation && ! ( qs.lat && qs.lng ) ) {
			navigator.geolocation.getCurrentPosition( onSuccess, onError, options );
		}
	},

	initAutocomplete() {
		const key = __slimChanceAjax__.gMapsApi;
		loadGoogleMapsApi( { key } )
			.then( googleMaps => {
				console.log( googleMaps );
				const searchBox = new googleMaps.places.SearchBox( this.address );
				this.geoLocate();

				searchBox.addListener( 'places_changed', () => {
					const place = searchBox.getPlaces()[ 0 ];
					const lat = place.geometry.location.lat();
					const lng = place.geometry.location.lng();
					this.lat.value = lat;
					this.lng.value = lng;
				} );
			} )
			.catch( console.error );
	},
};
