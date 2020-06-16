<?php
/**
 * WP Theme constants and setup functions
 *
 * @package slim-chance
 */

namespace ChanceDigital\Slim_Chance;

// Constants
require_once __DIR__ . '/inc/constants.php';

// Composer classes.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
} else {
	/**
	 * Custom autoloader function for theme classes.
	 *
	 * @access private
	 *
	 * @param  string $class_name Class name to load.
	 * @return bool               True if the class was loaded, false otherwise.
	 */
	function _slim_chance_autoload( $class_name ) {
		if ( strpos( $class_name, SLIM_CHANCE_NAMESPACE . '\\' ) !== 0 ) {
			return false;
		}
		$parts = explode( '\\', substr( $class_name, strlen( SLIM_CHANCE_NAMESPACE . '\\' ) ) );
		$path = untrailingslashit( SLIM_CHANCE_INC );
		foreach ( $parts as $part ) {
			$path .= '/' . $part;
		}
		$path .= '.php';
		if ( file_exists( $path ) ) {
			require_once $path;
			return true;
		}
		return false;
	}
	spl_autoload_register( '_slim_chance_autoload' );
}

// Load environment variables
$dotenv = \Dotenv\Dotenv::create( get_template_directory(), '.env.' . SLIM_CHANCE_ENV );
$dotenv->load();

// Require function files.
foreach ( [
	'util',
	'wp-shims',
	'core',
	'cleanup',
	'icons',
	'template',
	'images',
	'ajax',
	'rest-api',
] as $inc ) {
	$filename = SLIM_CHANCE_INC . "functions-$inc.php";
	if ( file_exists( $filename ) ) {
		require_once $filename;
	}
}

// Run the setup functions.
Core\setup();
