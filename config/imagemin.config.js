import imagemin from 'gulp-imagemin';
export const options = [
	imagemin.gifsicle( { interlaced: true } ),
	imagemin.jpegtran( { progressive: true } ),
	imagemin.optipng( { optimizationLevel: 5 } ), // 0-7 low-high.
	imagemin.svgo( {
		plugins: [ { removeViewBox: true }, { cleanupIDs: false } ],
	} ),
];
