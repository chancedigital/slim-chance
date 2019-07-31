<?php
/**
 * Define global constants.
 *
 * @package slim-chance
 */

// This should be defined in wp-config
// Defining here as a fallback
if ( ! defined( 'SLIM_CHANCE_ENV' ) ) {
	define( 'SLIM_CHANCE_ENV', 'development' );
}

// Load environment variables
$dotenv = \Dotenv\Dotenv::create( get_template_directory(), '.env.' . SLIM_CHANCE_ENV );
$dotenv->load();

// Useful global constants.
define( 'SLIM_CHANCE_VERSION', '2.1.1' );
define( 'SLIM_CHANCE_URL', get_stylesheet_directory_uri() );
define( 'SLIM_CHANCE_TEMPLATE_URL', get_template_directory_uri() );
define( 'SLIM_CHANCE_PATH', trailingslashit( get_template_directory() ) );
define( 'SLIM_CHANCE_INC', SLIM_CHANCE_PATH . 'inc/' );
define( 'SLIM_CHANCE_IMG_PATH', SLIM_CHANCE_PATH . 'dist/img/' );
define( 'SLIM_CHANCE_IMG_URL', SLIM_CHANCE_TEMPLATE_URL . '/dist/img' );
define( 'SLIM_CHANCE_NAMESPACE', 'ChanceDigital\\SlimChance' );
