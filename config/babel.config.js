module.exports = {
	presets: [ '@babel/preset-env', '@babel/preset-react' ],
	plugins: [
		'@babel/plugin-transform-runtime',
		'@babel/plugin-proposal-class-properties',
		'@babel/plugin-proposal-decorators',
		'@babel/plugin-proposal-dynamic-import',
		'@babel/plugin-proposal-nullish-coalescing-operator',
		'@babel/plugin-proposal-object-rest-spread',
		'@babel/plugin-proposal-optional-chaining',
		'@babel/plugin-transform-react-jsx',
		'lodash',
	],
};
