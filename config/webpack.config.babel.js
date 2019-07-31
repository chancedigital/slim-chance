import webpack from 'webpack';
import merge from 'webpack-merge';
import TerserPlugin from 'terser-webpack-plugin';
import WebpackBar from 'webpackbar';
import Dotenv from 'dotenv-webpack';
import path from 'path';
import babelConfig from './babel.config';
import {
	assets,
	baseDir,
	dist,
	isDev,
	isProd,
	jsFiles,
	nodeEnv,
	theme,
} from './index';

const dotEnvFile = `${ baseDir }/${ nodeEnv ? `.env.${ nodeEnv }` : '.env' }`;

const publicPath = `/wp-content/themes/${ theme.slug }/${ path.basename(
	dist,
) }/`;

const optimization = {
	minimizer: [
		new TerserPlugin( {
			cache: true,
			parallel: true,
			sourceMap: false,
			terserOptions: {
				parse: {
					// We want terser to parse ecma 8 code. However, we don't want it
					// to apply any minfication steps that turns valid ecma 5 code
					// into invalid ecma 5 code. This is why the 'compress' and 'output'
					// sections only apply transformations that are ecma 5 safe
					// https://github.com/facebook/create-react-app/pull/4234
					ecma: 8,
				},
				compress: {
					ecma: 5,
					warnings: false,
					// Disabled because of an issue with Uglify breaking seemingly valid code:
					// https://github.com/facebook/create-react-app/issues/2376
					// Pending further investigation:
					// https://github.com/mishoo/UglifyJS2/issues/2011
					comparisons: false,
					// Disabled because of an issue with Terser breaking valid code:
					// https://github.com/facebook/create-react-app/issues/5250
					// Pending futher investigation:
					// https://github.com/terser-js/terser/issues/120
					inline: 2,
				},
				output: {
					ecma: 5,
					comments: false,
				},
				ie8: false,
			},
		} ),
	],
};

const entry = jsFiles.reduce( ( acc, file ) => {
	acc[ file ] = `./js/${ file }/${ file }.js`; // ex: /js/frontend/frontend.js
	return acc;
}, {} );

const config = {
	entry,
	mode: isDev ? 'development' : 'production',
	externals: {
		jquery: 'jQuery',
	},
	output: {
		path: dist,
		publicPath,
		filename: isProd ? '[name].min.js' : '[name].js',
	},
	context: `${ assets }/`,
	cache: true,
	resolve: {
		modules: [ 'node_modules' ],
	},
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
				include: assets,
				use: [
					{
						loader: 'babel-loader',
						options: babelConfig,
					},
				],
			},
		],
	},
	plugins: [
		new webpack.NoEmitOnErrorsPlugin(),
		new Dotenv( {
			path: dotEnvFile,
		} ),
		new WebpackBar(),
	],
	stats: {
		colors: true,
		warnings: false,
	},
};

module.exports = isProd ? merge( config, { optimization } ) : config;
