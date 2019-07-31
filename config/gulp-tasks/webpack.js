import gulp from 'gulp';
import pump from 'pump';
import webpack from 'webpack';
import webpackStream from 'webpack-stream';
import notify from 'gulp-notify';
import { assets, dist, successMessage } from '../index';

const task = 'webpack';

gulp.task( task, cb => {
	const src = `${ assets }/js/**/*.js`;
	const config = '../webpack.config.babel.js';
	const dest = `${ dist }/js/`;
	pump(
		[
			gulp.src( src ),
			webpackStream( require( config ), webpack ),
			gulp.dest( dest ),
			notify( { message: successMessage( task ), onLast: true } ),
		],
		cb,
	);
} );
