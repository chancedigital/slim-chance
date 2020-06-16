import fetch from 'isomorphic-unfetch';
import { WP_API_BASE_URL } from '../../lib/constants';

export default class WP_API {
	static async fetchLocations() {
		const res = await fetch( `${ WP_API_BASE_URL }/wp/v2/location` );
		return await res.json();
	}

	static async mailSubmit( query ) {
		const res = await fetch( `${ WP_API_BASE_URL }/mail/v1/send?${ query }`, {
			method: 'POST',
		} );
		return await res.json();
	}
}
