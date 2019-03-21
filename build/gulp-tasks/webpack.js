import gulp from 'gulp';
import pump from 'pump';
import webpack from 'webpack';
import webpackStream from 'webpack-stream';
import notify from 'gulp-notify';
import config from '../../config';

gulp.task( 'webpack', cb => {
	const src = `${ config.assetsPath }/js/**/*.js`;
	const conf = '../webpack.config.babel.js';
	const dest = `${ config.distPath }/js/`;
	pump(
		[
			gulp.src( src ),
			webpackStream( require( conf ), webpack ),
			gulp.dest( dest ),
			notify( {
				message: config.getSuccessMessage( 'webpack' ),
				onLast: true,
			} ),
		],
		cb,
	);
} );
