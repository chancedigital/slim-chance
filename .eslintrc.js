// Are you using ES6+?
const ES6 = true;

// Are you using JSX?
const JSX = false;

const EXTEND_LIST = [
	'eslint:recommended',
	'wordpress',
];

/**
 * JSX packages not included by default.
 * If you are using JSX, be sure to install these plugins in your project.
 */
if ( JSX ) {
	EXTEND_LIST.concat( [
		'plugin:react/recommended',
		'plugin:jsx-a11y/recommended',
		'plugin:jest/recommended',
	] );
}

const config = {
	root: true,
	env: {
		node: true,
		es6: ES6,
		amd: true,
		browser: true,
		jquery: true
	},
	plugins: ES6 ? [ 'import' ] : [],

	/**
	 * Make sure you have eslint-config-wordpress installed.
	 *
	 * Install using:
	 * npm install -g eslint-config-wordpress
	 */
	extends: EXTEND_LIST,

	/**
	 * Default globals.
	 *
	 * These will get ignored automatically.
	 */
	globals: {
		// '_': false,
		// 'Backbone': false,
		'Foundation': false,
		'jQuery': false,
		'ssiAjax': false,
		// 'JSON': false,
		// 'wp': false,
	},

	/**
	 * WordPress Coding Standards for JavaScript.
	 *
	 * @see https://make.wordpress.org/core/handbook/best-practices/coding-standards/javascript/
	 */
	rules: {

		/**
		 * Enforce spacing inside array brackets.
		 *
		 * @see https://make.wordpress.org/core/handbook/best-practices/coding-standards/javascript/#spacing
		 */
		'no-console': 'production' === process.env.NODE_ENV ? 'warn' : 0,

		/**
		 * Enforce spacing inside array brackets.
		 *
		 * @see https://make.wordpress.org/core/handbook/best-practices/coding-standards/javascript/#spacing
		 */
		'array-bracket-spacing': [ 'error', 'always' ],

		/**
		 * Enforce one true brace style.
		 *
		 * @see https://make.wordpress.org/core/handbook/best-practices/coding-standards/javascript/#blocks-and-curly-braces
		 */
		'brace-style': 'error',

		/**
		 * Require camel case names.
		 *
		 * @see https://make.wordpress.org/core/handbook/best-practices/coding-standards/javascript/#naming-conventions
		 */
		'camelcase': [ 'error', {
			properties: 'always'
		} ],

		/**
		 * Enforce trailing commas.
		 */
		'comma-dangle': [ 'error', {
			'arrays': 'always-multiline',
			'objects': 'always-multiline',
			'imports': 'always-multiline',
			'exports': 'always-multiline',
			'functions': 'ignore'
		} ],

		/**
		 * Enforce spacing before and after comma.
		 *
		 * @see https://make.wordpress.org/core/handbook/best-practices/coding-standards/javascript/#objects
		 */
		'comma-spacing': 'error',

		/**
		 * Enforce one true comma style.
		 */
		'comma-style': [ 'error', 'last' ],

		/**
		 * Encourages use of dot notation whenever possible.
		 *
		 * @see https://make.wordpress.org/core/handbook/best-practices/coding-standards/javascript/#objects
		 */
		'dot-notation': [ 'error', {
			allowKeywords: true,
			allowPattern: '^[a-z]+(_[a-z]+)+$'
		} ],

		/**
		 * Enforce newline at the end of file, with no multiple empty lines.
		 */
		'eol-last': 'warn',

		/**
		 * Require == and !== where necessary.
		 *
		 * @see https://make.wordpress.org/core/handbook/best-practices/coding-standards/javascript/#equality
		 */
		'eqeqeq': 'warn',

		/**
		 * Require or disallow spacing between function identifiers and their invocations.
		 *
		 * @see https://make.wordpress.org/core/handbook/best-practices/coding-standards/javascript/#spacing
		 */
		'func-call-spacing': 'error',


		'indent': [ 'error', 'tab', {
			'SwitchCase': 1
		} ],

		/**
		 * Enforces spacing between keys and values in object literal properties.
		 *
		 * @see https://make.wordpress.org/core/handbook/best-practices/coding-standards/javascript/#spacing
		 */
		'key-spacing': [ 'error', {
			beforeColon: false,
			afterColon: true
		} ],

		/**
		 * Enforce spacing before and after keywords.
		 *
		 * @see https://make.wordpress.org/core/handbook/best-practices/coding-standards/javascript/#spacing
		 */
		'keyword-spacing': 'error',

		/**
		 * Disallow mixed "LF" and "CRLF" as linebreaks.
		 */
		'linebreak-style': [ 'error', 'unix' ],

		/**
		 * Enforces empty lines around comments.
		 */
		'lines-around-comment': [ 'warn', {
			beforeLineComment: true
		} ],

		/**
		 * Deal with duplicate import statements.
		 */
		'no-duplicate-imports': ES6 ? 'error' : 0,

		/**
		 * Discourage mixed operators.
		 */
		'no-mixed-operators': 'warn',

		/**
		 * Disallow mixed spaces and tabs for indentation.
		 *
		 * @see https://make.wordpress.org/core/handbook/best-practices/coding-standards/javascript/#spacing
		 */
		'no-mixed-spaces-and-tabs': 'warn',

		/**
		 * Disallow multiple empty lines.
		 */
		'no-multiple-empty-lines': 'warn',

		/**
		 * Enforce operators to be placed before or after line breaks.
		 */
		'operator-linebreak': [ 'error', 'after' ],

		/**
		 * Require or disallow use of semicolons instead of ASI.
		 *
		 * @see https://make.wordpress.org/core/handbook/best-practices/coding-standards/javascript/#semicolons
		 */
		'semi': [ 'error', 'always' ],

		/**
		 * Always show a warning when a variable is created that is never used.
		 */
		'no-unused-vars': 'warn',

		/**
		 * Require that braces be used.
		 */
		'curly': 'error',

		/**
		 * Require spacing inside of object curly braces.
		 */
		'object-curly-spacing': [ 'error', 'always' ],

		/**
		 * Prefer const to let.
		 */
		'prefer-const': ES6 ? 'error' : 0,

		/**
		 * Allow or disallow var declarations.
		 */
		'no-var': ES6 ? 'warn' : 0,

		/**
		 * Require or disallow space before blocks.
		 *
		 * @see https://make.wordpress.org/core/handbook/best-practices/coding-standards/javascript/#spacing
		 */
		'space-before-blocks': [ 'error', 'always' ],

		/**
		 * Require or disallow space before function opening parenthesis.
		 *
		 * @see https://make.wordpress.org/core/handbook/best-practices/coding-standards/javascript/#spacing
		 */
		'space-before-function-paren': [ 'error', 'never' ],

		/**
		 * Require or disallow space in parens.
		 *
		 * @see https://make.wordpress.org/core/handbook/best-practices/coding-standards/javascript/#spacing
		 */
		'space-in-parens': [ 'error', 'always' ],

		/**
		 * Require spaces around operators.
		 *
		 * @see https://make.wordpress.org/core/handbook/best-practices/coding-standards/javascript/#spacing
		 */
		'space-infix-ops': [ 'error', {
			'int32Hint': false
		} ],

		/**
		 * Require or disallow spaces before/after unary operators (words on by default, nonwords),
		 */
		'space-unary-ops': [ 'error', {
			'overrides': {
				'!': true
			}
		} ]
	}
};

if ( ES6 ) {
	config.parserOptions = {
		'ecmaFeatures': {
			'globalReturn': true,
			'objectLiteralDuplicateProperties': false,
		},
		'ecmaVersion': 2018,
		'sourceType': 'module',
	};
	config.settings = {
		'import/core-modules': [],
		'import/ignore': [ 'node_modules', '\\.(coffee|scss|css|less|hbs|svg|json)$' ],
	};
}

module.exports = config;
