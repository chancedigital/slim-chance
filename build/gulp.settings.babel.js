import path from 'path';

const baseDir      = path.resolve( __dirname, '../' );
const nodeModules  = path.resolve( __dirname, '../node_modules' );
const assets       = path.resolve( __dirname, '../assets' );
const dist         = path.resolve( __dirname, '../dist' );
const themeName    = 'slim-chance';
const publicPath   = `/wp-content/themes/${themeName}/${path.basename( dist )}/`;

module.exports = {
	themeName,
	baseDir,
	nodeModules,
	assets,
	dist,
	publicPath,
	packagePaths: [
		'**/*',
		'!**/node_modules/**',
		'!**/packaged/**',
		'!**/assets/**',
		'!**/build/**',
		'!**/.git',
		'!**/.gitignore',
		'!**/.editorconfig',
		'!**/.stylelintrc',
		'!**/.babelrc',
		'!**/.eslintrc.js',
		'!**/.phpcs.xml',
		'!**/composer.json',
		'!**/composer.lock',
		'!**/gulpfile.babel.js',
		'!**/package.json',
		'!**/package-lock.json',
		'!**/yarn-lock.json',
	],
	successMessage: task => `TASK: "${task}" Completed! 💯`,
	jsFiles: [
		'admin',
		'editor',
		'frontend',
		'shared',
	],
	scssFiles: [
		'admin',
		'editor',
		'frontend',
		'shared',
	],
	mode: process.env.NODE_ENV || 'production',
};
