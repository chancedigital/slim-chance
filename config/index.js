import path from 'path';

export const theme = {
	/** @type {string} Theme base directory. */
	name: 'Slim Chance',
	slug: 'slim-chance',
	url: 'https://slimandhuskys.com',
	version: '3.0.0',
	description: 'Custom WordPress theme for the Slim + Huskys website.',
	author: {
		name: 'Chance Strickland',
		url: 'https://chancedigital.io',
	},
	domainPath: '/languages',

	/** @type {string[]} Theme tags */
	tags: [],
};

export const settings = {
	theme,
	liveReload: false,
	devUrl: process.env.LOCAL_DEV_URL || 'https://slim.test',
	proxyUrl: process.env.LOCAL_DEV_PROXY || 'slim.test',
	port: process.env.LOCAL_DEV_PORT || '4000',
};

/** @type {string} Theme base directory. */
export const baseDir = path.resolve( __dirname, '../' );

/** @type {string} Theme assets directory. */
export const assets = path.resolve( baseDir, 'assets' );

/** @type {string} Node modules directory. */
export const nodeModules = path.resolve( baseDir, 'node_modules' );

/** @type {string} Theme directory for public compiled assets. */
export const dist = path.resolve( baseDir, 'dist' );

/** @type {string} Node environment */
export const nodeEnv = process.env.NODE_ENV;

/** @type {boolean} Whether or not we are in a dev environment. */
export const isDev = nodeEnv === 'development';

/** @type {boolean} Whether or not we are in a production environment. */
export const isProd = nodeEnv === 'production';

/** @type {boolean} Whether or not we are in a staging environment. */
export const isStaging = nodeEnv === 'staging';

/** @type {string[]} JavaScript filenames to be processed by Webpack. */
export const jsFiles = [ 'admin', 'editor', 'frontend', 'shared' ];

/** @type {string[]} Sass filenames to be processed by gulp-sass. */
export const scssFiles = [ 'admin', 'editor', 'frontend', 'shared' ];

/** @type {Array.<string>} Sass filenames to be processed by gulp-sass. */
export const successMessage = task => `TASK: "${ task }" Completed! 🍻`;

export default {
	...settings,
	baseDir,
	nodeModules,
	assets,
	dist,
	nodeEnv,
	isDev,
	isProd,
	isStaging,
	successMessage,
	jsFiles,
	scssFiles,
};
