import gulp from 'gulp';
import path from 'path';
import requireDir from 'require-dir';
import { assets } from './gulp.settings.babel';

// import livereload from 'gulp-livereload';

requireDir( './gulp-tasks' );

gulp.task( 'copyProcess', gulp.series( 'copy' ) );
gulp.task( 'jsProcess', gulp.series( 'webpack' ) );
gulp.task( 'cssProcess', gulp.series( 'cssclean', 'sass', 'cssnano' ) );
gulp.task( 'imageProcess', gulp.series( 'images' ) );

// Watch for file changes.
gulp.task( 'watch', () => {
	process.env.NODE_ENV = 'development';

	// livereload.listen( { basePath: 'dist' } );
	gulp.watch( `../${path.basename( assets )}/scss/**/*`, gulp.series( 'cssProcess' ) );
	gulp.watch( `../${path.basename( assets )}/js/**/*`, gulp.series( 'jsProcess' ) );
	gulp.watch( `../${path.basename( assets )}/img/**/*`, gulp.series( 'imageProcess' ) );
} );

gulp.task( 'default', gulp.parallel( 'copyProcess', 'cssProcess', gulp.series(
	'webpack',
	'images',
	'watch',
) ) );

gulp.task( 'build', gulp.series( 'set-prod-node-env', 'default' ) );
