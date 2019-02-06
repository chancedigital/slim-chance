import gulp from 'gulp';
import { assets, dist, successMessage } from '../gulp.settings.babel';
import cache from 'gulp-cache';
import imagemin from 'gulp-imagemin';
import notify from 'gulp-notify';

gulp.task( 'images', function() {
	return gulp
		.src( `${assets}/img/**/*` )
		.pipe(
			cache(
				imagemin( [
					imagemin.gifsicle( { interlaced: true } ),
					imagemin.jpegtran( { progressive: true } ),
					imagemin.optipng( { optimizationLevel: 5 } ), // 0-7 low-high.
					imagemin.svgo( {
						plugins: [ { removeViewBox: true }, { cleanupIDs: false } ],
					} ),
				] )
			)
		)
		.pipe( gulp.dest( `${dist}/img` ) )
		.pipe( notify( { message: successMessage( 'images' ), onLast: true } ) );
} );
