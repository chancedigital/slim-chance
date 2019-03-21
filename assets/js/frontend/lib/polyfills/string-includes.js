// https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/includes#Polyfill
export default () => {
	if ( ! String.prototype.includes ) {
		String.prototype.includes = function( search, start ) {
			if ( typeof start !== 'number' ) {
				start = 0;
			}

			if ( start + search.length > this.length ) {
				return false;
			}
			return this.indexOf( search, start ) !== -1;
		};
	}
};
