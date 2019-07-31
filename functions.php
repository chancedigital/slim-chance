<?php
/**
 * WP Theme constants and setup functions
 *
 * @package slim-chance
 */

namespace ChanceDigital\SlimChance;

// Composer classes.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

// Constants
require_once __DIR__ . '/inc/constants.php';

// Require function files.
foreach ( [
	'util',
	'autoload',
	'core',
	'cleanup',
	'icons',
	'template',
	'images',
	'ajax',
	'rest-api',
] as $inc ) {
	$filename = SLIM_CHANCE_INC . "$inc/$inc.php";
	if ( file_exists( $filename ) ) {
		require_once $filename;
	}
}

// Run the setup functions.
Core\setup();
