<?php
/**
 * REST API-related functions
 *
 * @package slim-chance
 */

namespace ChanceDigital\Slim_Chance\Rest_API;

use ChanceDigital\Slim_Chance\Rest_API\Routes\Mail;

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
