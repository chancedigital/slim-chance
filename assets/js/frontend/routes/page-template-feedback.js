import React from 'react';
import ReactDOM from 'react-dom';
import App from '../components/feedback-survey';

export default {
	init() {
		const appWrapper = document.getElementById( 'js-feedback-app' );
		if ( appWrapper ) {
			ReactDOM.render( <App />, appWrapper );
		}
	},

	finalize() {}, // End finalize.
};
