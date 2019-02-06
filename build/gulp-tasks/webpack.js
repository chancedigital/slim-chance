import gulp from 'gulp';
import pump from 'pump';
import webpack from 'webpack';
import webpackStream from 'webpack-stream';
import notify from 'gulp-notify';
import { assets, dist, successMessage } from '../gulp.settings.babel';

// import livereload from 'gulp-livereload';

gulp.task( 'webpack', cb => {
	const src  = `${assets}/js/**/*.js`;
	const conf = '../webpack.config.babel.js';
	const dest = `${dist}/js/`;
	pump( [
		gulp.src( src ),
		webpackStream( require( conf ), webpack ),
		gulp.dest( dest ),

		// livereload(),
		notify( { message: successMessage( 'webpack' ), onLast: true } ),
	], cb );
} );
