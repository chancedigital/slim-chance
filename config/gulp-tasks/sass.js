import sass from '@chancestrickland/gulp-sass';
import cssnano from 'cssnano';
import gulp from 'gulp';
import notify from 'gulp-notify';
import postcss from 'gulp-postcss';
import tildeImporter from 'node-sass-tilde-importer';
import postcssPresetEnv from 'postcss-preset-env';
import rename from 'gulp-rename';
import sourcemaps from 'gulp-sourcemaps';
import pump from 'pump';
import { scssFiles, assets, dist, isProd, successMessage } from '../index';

const task = 'sass';

const postcssPlugins = [
	postcssPresetEnv( {
		stage: 3,
		autoprefixer: {
			grid: true,
		},
	} ),
];

if ( isProd ) {
	postcssPlugins.push(
		cssnano( {
			autoprefixer: false,
			calc: {
				precision: 8,
			},
			colormin: true,
			convertValues: true,
			cssDeclarationSorter: true,
			discardComments: true,
			discardEmpty: true,
			discardOverridden: true,
			mergeLonghand: true,
			mergeRules: true,
			minifyFontValues: true,
			minifyGradients: true,
			minifyParams: true,
			minifySelectors: true,
			normalizeCharset: true,
			normalizePositions: true,
			normalizeRepeatStyle: true,
			normalizeString: true,
			normalizeTimingFunctions: true,
			normalizeUnicode: true,
			normalizeUrl: true,
			normalizeWhitespace: true,
			orderedValues: true,
			reduceTransforms: true,
			svgo: true,
			uniqueSelectors: true,
			zindex: false,
		} ),
	);
}

gulp.task( task, cb => {
	const fileSrc = scssFiles.map(
		file => `${ assets }/scss/${ file }/${ file }.scss`,
	);

	pump(
		[
			gulp.src( fileSrc ),
			sourcemaps.init( { loadMaps: true } ),
			sass( { importer: tildeImporter } ).on( 'error', sass.logError ),
			postcss( postcssPlugins ),
			rename( { suffix: isProd ? '.min' : '' } ),
			sourcemaps.write( './' ),
			gulp.dest( `${ dist }/css` ),
			notify( { message: successMessage( task ), onLast: true } ),
		],
		cb,
	);
} );
