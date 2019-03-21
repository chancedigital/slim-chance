import gulp from 'gulp';
import del from 'del';
import config from '../../config';

gulp.task( 'cssclean', cb => {
	del( [ `${ config.distPath }/css/**/*` ], { force: true } );
	cb();
} );
