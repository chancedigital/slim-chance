<?php
/**
 * Shims for core WordPress functions
 *
 * Do not use a namespace for this file since these are shims for global functions.
 *
 * @package lee-co
 */

// phpcs:disable ChanceDigital.Functions.NamespacedFunctions

/**
 * Backwards compatibility for `wp_body_open`
 */
if ( ! function_exists( 'wp_body_open' ) ) {
	/**
	 * Run the wp_body_open action.
	 *
	 * @return void
	 */
	function wp_body_open() : void {
		do_action( 'wp_body_open' );
	}
}
