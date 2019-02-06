import webpack from 'webpack';
import { assets, dist, jsFiles, publicPath, mode } from './gulp.settings.babel';

const entry = jsFiles.reduce( ( acc, file ) => {
	acc[file] = `./js/${file}/${file}.js`; // ex: /js/frontend/frontend.js
	return acc;
}, {} );

const config = {
	entry,
	mode,
	externals: {
		jquery: 'jQuery',
	},
	output: {
		path: dist,
		publicPath,
		filename: '[name].min.js',
	},
	context: assets + '/',
	cache: true,
	resolve: { modules: [ 'node_modules' ] },
	devtool: 'source-map',
	module: {
		rules: [
			{
				test: /\.js$/,
				enforce: 'pre',
				include: assets,
				loader: 'eslint-loader',
			},
			{
				test: /\.js$/,
				exclude: [ '/node_modules/' ],
				use: [ { loader: 'babel-loader' } ],
			},
		],
	},
	plugins: [
		new webpack.NoEmitOnErrorsPlugin(),
	],
	stats: {
		colors: true,
		warnings: false,
	},
};

module.exports = config;
