import gulp from 'gulp';
import del from 'del';
import { dist } from '../gulp.settings.babel';

gulp.task( 'cssclean', cb => {
	del( [ `${dist}/css/**/*` ], { force: true } );
	cb();
} );
