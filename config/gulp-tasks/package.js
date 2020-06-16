/* function archive() {
	var time = dateFormat( new Date(), 'yyyy-mm-dd_HH-MM' );
	var pkg = JSON.parse( fs.readFileSync( './package.json' ) );
	var title = pkg.name + '_' + time + '.zip';

	return gulp
		.src( PATHS.package )
		.pipe( $.zip( title ) )
		.pipe( gulp.dest( 'packaged' ) );
}
 */
