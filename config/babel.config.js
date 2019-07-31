module.exports = {
	presets: [ '@babel/preset-env', '@babel/preset-react' ],
	plugins: [
		'@babel/plugin-transform-runtime',
		'@babel/plugin-proposal-class-properties',
		'@babel/plugin-transform-react-jsx',
		'@babel/plugin-proposal-object-rest-spread',
		'lodash',
	],
};
