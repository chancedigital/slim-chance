import gulp from 'gulp';
import cache from 'gulp-cache';
import imagemin from 'gulp-imagemin';
import notify from 'gulp-notify';
import { assets, dist, successMessage } from '../index';

const task = 'images';

gulp.task( task, () => {
	return gulp
		.src( `${ assets }/img/**/*.{jpg,jpeg,png,gif,svg}` )
		.pipe(
			cache(
				imagemin( [
					imagemin.gifsicle( { interlaced: true } ),
					imagemin.jpegtran( { progressive: true } ),
					imagemin.optipng( { optimizationLevel: 5 } ), // 0-7 low-high.
					imagemin.svgo( {
						plugins: [ { removeViewBox: false }, { cleanupIDs: true } ],
					} ),
				] ),
			),
		)
		.pipe( gulp.dest( `${ dist }/img` ) )
		.pipe( notify( { message: successMessage( task ), onLast: true } ) );
} );