import initHamburger from '../components/hamburger';
import initButton from '../components/button';
import loadMore from '../components/load-more';
import initCheckboxes from '../components/checkboxes';
import initMasthead from '../layout/header/masthead';
import { MediaQuery } from '../lib/class-media-query';
import '@fancyapps/fancybox';

export default {
	init() {
		const mq = new MediaQuery();
		window.addEventListener( 'resize', mq.listener );
	}, // End init.

	finalize() {
		initButton();
		initHamburger();
		initMasthead();
		initCheckboxes();
		loadMore.init();
	}, // End finalize.
};
