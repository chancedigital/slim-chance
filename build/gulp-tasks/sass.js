import gulp from 'gulp';
import sass from 'gulp-sass';
import sourcemaps from 'gulp-sourcemaps';
import postcss from 'gulp-postcss';
import notify from 'gulp-notify';
import pump from 'pump';
import tildeImporter from 'node-sass-tilde-importer';
import { assets, dist, successMessage } from '../gulp.settings.babel';

const task = 'sass';

gulp.task( task, cb => {
	const fileSrc = [ 'admin', 'editor', 'frontend', 'shared' ].map(
		file => `${assets}/scss/${file}/${file}.scss`
	);

	pump( [
		gulp.src( fileSrc ),
		sourcemaps.init( { loadMaps: true } ),
		sass( { importer: tildeImporter } )
			.on( 'error', sass.logError ),
		/*
		eslint-disable
		phpcs( {
			bin: `${baseDir}/vendor/bin/phpcs`,
			standard: 'wp-coding-standards',
			warningSeverity: 0,
		} ),
		phpcs.reporter( 'log' ),
		eslint-enable
		*/
		postcss( [
			require( 'postcss-preset-env' )( {
				stage: 3,
			} ),
		] ),
		gulp.dest( `${dist}/css` ),
		sourcemaps.write( './', {
			mapFile: function( mapFilePath ) {
				return mapFilePath.replace( '.css.map', '.min.css.map' );
			},
		} ),
		notify( { message: successMessage( task ), onLast: true } ),
	], cb );
} );
