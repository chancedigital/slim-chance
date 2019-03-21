import gulp from 'gulp';
import notify from 'gulp-notify';
import pump from 'pump';
import config from '../../config';

gulp.task( 'copy', cb => {
	pump(
		[
			gulp.src( `${ config.assetsPath }/fonts/**/*` ),
			gulp.dest( `${ config.distPath }/fonts` ),
			notify( {
				message: config.getSuccessMessage( 'copy' ),
				onLast: true,
			} ),
		],
		cb,
	);
} );
