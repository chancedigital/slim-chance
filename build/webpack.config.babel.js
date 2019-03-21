import webpack from 'webpack';
import WebpackBar from 'webpackbar';
import path from 'path';
import babelConfig from '../config/babel.config';
import cfg from '../config';
import Dotenv from 'dotenv-webpack';

const { assetsPath, basePath, distPath, jsFiles, getThemeName, isDev } = cfg;

const nodeEnv = process.env.NODE_ENV;

const dotEnvFile = `${ basePath }/.env${ nodeEnv ? `.${ nodeEnv }` : '' }`;

const entry = {};
jsFiles.forEach( fileName => {
	entry[ fileName ] = `./js/${ fileName }/${ fileName }.js`;
} );

const publicPath = `/wp-content/themes/${ getThemeName() }/${ path.basename(
	distPath,
) }/`;

const config = {
	entry,
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
				enforce: 'pre',
				use: [ 'eslint-loader' ],
			},
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
