import { get } from 'lodash';

/**
 * Callback to sort locations alphabetically first by state, then by city.
 *
 * @param   {Object}   a First comparitor.
 * @param   {Object}   b Second comparitor.
 * @returns {number}     Logic for Array.prototype.sort
 */
export const sortLocations = ( a, b ) => {
	const aState = a.state;
	const bState = b.state;
	const aCity = a.city;
	const bCity = b.city;
	if ( aState === bState ) {
		if ( aCity < bCity ) {
			return -1;
		}
		if ( aCity > bCity ) {
			return 1;
		}
		return 0;
	}
	if ( aState < bState ) {
		return -1;
	}
	return 1;
};

/**
 * Model to format location posts received from the WP API.
 *
 * @param   {Object} post Post object as received from WordPress.
 * @returns {Object}      Post object formatted for our components.
 */
export const mapLocations = post => {
	const city = get( post, 'acf.city' );
	const state = get( post, 'acf.state' );
	const title = get( post, 'title.rendered' );
	const text = `${ city }, ${ state }: ${ title }`;
	return {
		id: get( post, 'id' ),
		value: text,
		text,
		city,
		state,
	};
};
