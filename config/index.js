import path from 'path';
import notify from 'gulp-notify';

/** Theme config. */
class Config {
	/** @type {string} Development URL for BrowserSync. */
	devUrl = 'http://slim.local';

	/** @type {string} Theme base directory. */
	basePath = path.resolve( __dirname, '../' );

	/** @type {string} Theme assets directory. */
	assetsPath = path.resolve( __dirname, '../assets' );

	/** @type {string} Theme directory for public compiled assets. */
	distPath = path.resolve( __dirname, '../dist' );

	/** @type {Array.<string>} JavaScript filenames to be processed by Webpack. */
	jsFiles = [ 'admin', 'editor', 'frontend', 'shared' ];

	/** @type {Array.<string>} Sass filenames to be processed by gulp-sass. */
	scssFiles = [ 'admin', 'editor', 'frontend', 'shared' ];

	/** @type {boolean} Whether or not we are in a dev environment. */
	isDev = process.env.NODE_ENV === 'development';

	/** @type {boolean} Whether or not we are in a staging environment. */
	isStaging = process.env.NODE_ENV === 'staging';

	/** @type {boolean} Whether or not we are in a production environment. */
	isProd = process.env.NODE_ENV === 'production';

	/**
	 * Get the theme name from the base directory.
	 *
	 * @returns {string} - Theme name slug.
	 * @memberof Config
	 */
	getThemeName = () => {
		return path.basename( this.basePath );
	};

	/**
	 * Get a success message for Gulp task completion.
	 *
	 * @type {Function}
	 * @param {string} task - Name of the task.
	 * @returns {string} - Task completion message.
	 * @memberof Config
	 */
	getSuccessMessage = task => {
		return `Gulp task "${ task }" completed! 🍻`;
	};

	/**
	 * Get an error message when Gulp tasks fail.
	 *
	 * @type {Function}
	 * @param {string} task - Name of the task.
	 * @returns {string} - Task error message.
	 * @memberof Config
	 */
	getErrorMessage = task => {
		return `Gulp task "${ task }" failed 🤦‍`;
	};

	/**
	 * Generate a error handler for pump to display our error message via notify.
	 *
	 * @todo Add to gulp tasks for clearer output when terminal isn't focused.
	 * @param {string} task - Name of our task.
	 * @param {Function} cb - Callback function to fire on completion.
	 * @returns {Function} - Error handler.
	 * @memberof Config
	 */
	getErrorCallback = ( task, cb ) => err => {
		if ( err ) {
			notify( {
				message: this.getErrorMessage( task ),
				onLast: true,
			} );
		}
		cb();
	};
}

export default new Config();
