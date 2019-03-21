import gulp from 'gulp';
import cache from 'gulp-cache';
import imagemin from 'gulp-imagemin';
import notify from 'gulp-notify';
import pump from 'pump';
import config from '../../config';
import { options as imageminOptions } from '../../config/imagemin.config';

gulp.task( 'images', cb => {
	pump(
		[
			gulp.src( `${ config.assetsPath }/img/**/*` ),
			cache( imagemin( imageminOptions ) ),
			gulp.dest( `${ config.distPath }/img` ),
			notify( {
				message: config.getSuccessMessage( 'images' ),
				onLast: true,
			} ),
		],
		cb,
	);
} );
