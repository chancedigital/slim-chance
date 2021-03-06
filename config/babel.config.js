module.exports = {
	presets: [ '@babel/preset-env', '@babel/preset-react' ],
	plugins: [
		'@babel/plugin-transform-runtime',
		'@babel/plugin-transform-react-jsx',
		'@babel/plugin-proposal-class-properties',
		'@babel/plugin-proposal-nullish-coalescing-operator',
		'@babel/plugin-proposal-object-rest-spread',
		'@babel/plugin-proposal-optional-chaining',
		'lodash',
	],
};
