import gulp from 'gulp';
import sass from 'gulp-sass';
import sourcemaps from 'gulp-sourcemaps';
import postcss from 'gulp-postcss';
import notify from 'gulp-notify';
import pump from 'pump';
import tildeImporter from 'node-sass-tilde-importer';
import { plugins as postcssPlugins } from '../../config/postcss.config';
import config from '../../config';

const taskName = 'sass';
const fileSrc = config.scssFiles.map(
	file => `${ config.assetsPath }/scss/${ file }/${ file }.scss`,
);
const mapFile = mapFilePath => {
	return mapFilePath.replace( '.css.map', '.min.css.map' );
};

gulp.task( taskName, cb => {
	pump(
		[
			gulp.src( fileSrc ),
			sourcemaps.init( { loadMaps: true } ),
			sass( { importer: tildeImporter } ).on( 'error', sass.logError ),
			postcss( postcssPlugins ),
			sourcemaps.write( './', { mapFile } ),
			gulp.dest( `${ config.distPath }/css` ),
			notify( {
				message: config.getSuccessMessage( taskName ),
				onLast: true,
			} ),
		],
		cb,
	);
} );
