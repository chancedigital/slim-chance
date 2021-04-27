<?php
/**
 * Marketing functions
 *
 * @package slim-chance
 */

namespace ChanceDigital\Slim_Chance\Marketing;

add_action( 'after_setup_theme', __NAMESPACE__ . '\\start' );

/**
 * Add hooks.
 */
function start() {
	add_filter( 'wp_head',       __NAMESPACE__ . '\\fb_domain_verification', 1 );
}

/**
 * Clean up HTML head
 */
function fb_domain_verification() {
	?>
	<meta name="facebook-domain-verification" content="j0iinapvw7hsd9ufctfqcqsjq5atwl" />
	<?php
}
