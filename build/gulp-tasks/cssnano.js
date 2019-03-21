import gulp from 'gulp';
import cssnano from 'gulp-cssnano';
import rename from 'gulp-rename';
import sourcemaps from 'gulp-sourcemaps';
import pump from 'pump';
import filter from 'gulp-filter';
import config from '../../config';

gulp.task( 'cssnano', cb => {
	const fileDest = `${ config.distPath }/css`,
		fileSrc = [ `${ config.distPath }/css/*.css` ],
		taskOpts = [
			cssnano( {
				autoprefixer: false,
				calc: {
					precision: 8,
				},
				zindex: false,
				convertValues: true,
			} ),
		];

	pump(
		[
			gulp.src( fileSrc ),
			sourcemaps.init( {
				loadMaps: true,
			} ),
			cssnano( taskOpts ),
			rename( path => {
				path.extname = '.min.css';
			} ),
			sourcemaps.write( './' ),
			gulp.dest( fileDest ),
			filter( '**/*.css' ),
		],
		cb,
	);
} );
