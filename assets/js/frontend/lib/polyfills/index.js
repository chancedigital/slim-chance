import 'core-js/stable';
import 'regenerator-runtime/runtime';
import initCustomEvent from './custom-event';
import unfetch from './unfetch';

export default () => {
	if ( ! window.fetch ) {
		window.fetch = unfetch;
	}
	initCustomEvent();
};
