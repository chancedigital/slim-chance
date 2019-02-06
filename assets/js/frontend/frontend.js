// Import external dependencies.
import 'what-input';

// Import local dependencies.
import Router from '../_util/Router';

// Import route for each page.
import common from './routes/common';
import home from './routes/home';

// Populate Router instance with DOM routes.
const routes = new Router( {
	common, // All pages
	home, // Home page
} );

// Load route events.
jQuery( document ).ready( () => routes.loadEvents() );
