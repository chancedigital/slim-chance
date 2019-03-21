import gulp from 'gulp';
import path from 'path';
import browserSync from 'browser-sync';
import requireDir from 'require-dir';
import config from '../config';

// Require all gulp tasks at once.
requireDir( './gulp-tasks' );

// Create a BrowserSync instance.
const bs = browserSync.create();
const proxy = config.devUrl;

gulp.task( 'bs-reload-css', cb => {
	bs.reload( '*.css' );
	cb();
} );

gulp.task( 'bs-reload', cb => {
	bs.reload();
	cb();
} );

gulp.task( 'copyProcess', gulp.series( 'copy' ) );
gulp.task( 'jsProcess', gulp.series( 'webpack' ) );
gulp.task( 'cssProcess', gulp.series( 'cssclean', 'sass', 'cssnano' ) );
gulp.task( 'imageProcess', gulp.series( 'images' ) );

// Watch for file changes.
gulp.task( 'watch', cb => {
	if ( config.isDev ) {
		if ( proxy ) {
			// https://browsersync.io/docs/options
			bs.init( {
				proxy,
				snippetOptions: {
					whitelist: [ '/wp-admin/admin-ajax.php' ],
					blacklist: [ '/wp-admin/**' ],
				},
			} );
		}

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
	} else {
		cb();
	}
} );

gulp.task(
	'default',
	gulp.parallel(
		'copyProcess',
		'cssProcess',
		gulp.series( 'webpack', 'images', 'watch' ),
	),
);

gulp.task( 'build', gulp.series( 'default' ) );
