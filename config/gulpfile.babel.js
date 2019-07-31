import gulp from 'gulp';
import path from 'path';
import requireDir from 'require-dir';
import { assets } from './index';

requireDir( './gulp-tasks' );

gulp.task( 'copyProcess', gulp.series( 'copy' ) );
gulp.task( 'jsProcess', gulp.series( 'jsclean', 'webpack' ) );
gulp.task( 'cssProcess', gulp.series( 'cssclean', 'sass' ) );
gulp.task( 'imageProcess', gulp.series( 'images' ) );

// Watch for file changes.
gulp.task( 'watch', () => {
	gulp.watch(
		[
			`../${ path.basename( assets ) }/scss/**/*`,
			`!../${ path.basename( assets ) }/scss/docs/**/*`,
		],
		gulp.series( 'cssProcess' ),
	);
	gulp.watch(
		[
			`../${ path.basename( assets ) }/js/**/*.js`,
			`!../${ path.basename( assets ) }/js/docs/**/*`,
		],
		gulp.series( 'webpack' ),
	);
	gulp.watch(
		[
			`../${ path.basename( assets ) }/img/**/*.{jpg,jpeg,png,gif,svg}`,
			`!../${ path.basename( assets ) }/img/docs/**/*`,
		],
		gulp.series( 'imageProcess' ),
	);
	// gulp.watch( `../**/*.php`, gulp.series( 'php' ) );
} );

gulp.task(
	'default',
	gulp.parallel(
		// 'php',
		'copyProcess',
		'cssProcess',
		gulp.series( 'jsProcess', 'images' ),
	),
);

gulp.task( 'dev', gulp.series( 'env', 'default', 'watch' ) );
gulp.task( 'build', gulp.series( 'default' ) );
