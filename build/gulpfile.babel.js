import gulp from 'gulp';
import path from 'path';
import requireDir from 'require-dir';
import config from '../config';

// Require all gulp tasks at once.
requireDir( './gulp-tasks' );

gulp.task( 'copyProcess', gulp.series( 'copy' ) );
gulp.task( 'jsProcess', gulp.series( 'webpack' ) );
gulp.task( 'cssProcess', gulp.series( 'cssclean', 'sass', 'cssnano' ) );
gulp.task( 'imageProcess', gulp.series( 'images' ) );

// Watch for file changes.
gulp.task( 'watch', cb => {
	gulp.watch(
		`../${ path.basename( config.assetsPath ) }/scss/**/*`,
		gulp.series( 'cssProcess' ),
	);
	gulp.watch(
		`../${ path.basename( config.assetsPath ) }/js/**/*`,
		gulp.series( 'jsProcess' ),
	);
	gulp.watch(
		`../${ path.basename( config.assetsPath ) }/img/**/*`,
		gulp.series( 'imageProcess' ),
	);
} );

gulp.task(
	'default',
	gulp.parallel(
		'copyProcess',
		'cssProcess',
		gulp.series( 'webpack', 'images' ),
	),
);

gulp.task( 'dev', gulp.series( 'default', 'watch' ) );
gulp.task( 'build', gulp.series( 'default' ) );
