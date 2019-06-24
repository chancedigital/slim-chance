import webpack from 'webpack';
import WebpackBar from 'webpackbar';
import path from 'path';
import TerserPlugin from 'terser-webpack-plugin';
import babelConfig from '../config/babel.config';
import cfg from '../config';
import Dotenv from 'dotenv-webpack';

const { assetsPath, basePath, distPath, jsFiles, getThemeName, isDev } = cfg;

const nodeEnv = process.env.NODE_ENV;

const dotEnvFile = `${ basePath }/.env${ nodeEnv ? `.${ nodeEnv }` : '' }`;

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

const entry = {};
jsFiles.forEach( fileName => {
	entry[ fileName ] = `./js/${ fileName }/${ fileName }.js`;
} );

const publicPath = `/wp-content/themes/${ getThemeName() }/${ path.basename(
	distPath,
) }/`;

const config = {
	entry,
	optimization,
	mode: isDev ? 'development' : 'production',
	externals: {
		jquery: 'jQuery',
	},
	output: {
		path: distPath,
		publicPath,
		filename: '[name].min.js',
	},
	context: assetsPath + '/',
	cache: true,
	resolve: {
		modules: [ 'node_modules' ],
	},
	devtool: 'source-map',
	module: {
		rules: [
			{
				test: /\.js$/,
				include: assetsPath,
				use: [
					{
						loader: 'babel-loader',
						options: {
							...babelConfig,
						},
					},
				],
			},
		],
	},
	plugins: [
		new webpack.NoEmitOnErrorsPlugin(),
		new WebpackBar(),
		new Dotenv( {
			path: dotEnvFile,
		} ),
	],
	stats: {
		colors: true,
		warnings: false,
	},
};

module.exports = config;
