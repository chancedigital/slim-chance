<?php
/**
 * REST API-related functions
 *
 * @package slim-chance
 */

namespace ChanceDigital\SlimChance\Rest_Api;

use ChanceDigital\SlimChance\Rest_Api\Routes\Mail;

add_action( 'rest_api_init', __NAMESPACE__ . '\\register_routes', 10, 0 );
add_filter(
	'wp_mail_content_type', function( $content_type ) {
		return 'text/html';
	}
);

function register_routes() {
	$mail_routes = new Mail();
	$mail_routes->register_routes();
}
