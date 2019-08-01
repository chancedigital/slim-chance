<?php
/**
 * Ajax functions.
 *
 * @package pyapc
 */

namespace ChanceDigital\SlimChance\Ajax;

use function ChanceDigital\SlimChance\Util\is_whole_number;

add_action( 'wp_ajax_nopriv_load_more_posts', __NAMESPACE__ . '\\load_more_posts' );
add_action( 'wp_ajax_load_more_posts',        __NAMESPACE__ . '\\load_more_posts' );

// phpcs:disable WordPress.Security

/**
 * Utility to format parsed JSON data and reformat the variables needed for `query_posts`.
 *
 * TODO: Should probably revisit this approach and use the REST API for the entire `load more` piece.
 *
 * @param  array $arr Query params to test.
 * @return array      Updated query params.
 */
function prepare_query_params_from_json( $arr = [] ) {
	$new_arr = [];
	foreach ( $arr as $key => $value ) {
		$new_val = $value;
		if ( $value === '' ) {
			continue;
		} elseif ( is_array( $value ) ) {
			$new_val = call_user_func( __FUNCTION__, $value );
		} elseif ( $value === 'true' ) {
			$new_val = true;
		} elseif ( $value === 'false' ) {
			$new_val = false;
		} elseif ( is_whole_number( $value ) ) {
			$new_val = intval( $new_val );
		}
		$new_arr[ $key ] = $new_val;
	}
	return $new_arr;
}

/**
 * Load more functionality.
 *
 * @return void
 */
function load_more_posts() {

	// Check that the nonce is set.
	if ( ! isset( $_POST['nonce'] ) ) {
		wp_die( 'Please try again. No nonce.' );
	}

	// Verify the nonce.
	if ( ! wp_verify_nonce( $_POST['nonce'], 'load_posts_nonce' ) ) {
		wp_die( '' );
	}

	// Prepare our arguments for the query
	$params = isset( $_POST['query'] ) ? $_POST['query'] : [];

	// Remove params we won't use that may cause conflicts.
	$params['cat']               = '';
	$params['category_name']     = '';
	$params['comments_per_page'] = '';

	$params                = prepare_query_params_from_json( $params );
	$params['post_status'] = 'publish';
	$params['paged']       = isset( $_POST['page'] )
		? ( (int) wp_unslash( $_POST['page'] ) ) + 1
		: 1;

	// Get wrapper data if it exists
	$wrapper     = isset( $_POST['wrapper'] ) ? $_POST['wrapper'] : [];
	$ok_wrappers = [ 'div', 'span', 'li' ];

	query_posts( $params ); // phpcs:ignore
	if ( have_posts() ) {
		ob_start();
		while ( have_posts() ) {
			the_post();

			// Check for wrapper data from the request
			if ( ! empty( $wrapper ) && isset( $wrapper['element'] ) && in_array( $wrapper['element'], $ok_wrappers, true ) ) {
				$el        = $wrapper['element'];
				$class_att = isset( $wrapper['className'] ) ? ' class="' . esc_attr( $wrapper['className'] ) . '"' : '';
				echo "\n<{$el}{$class_att}>\n\t";
				get_template_part( 'templates/parts/layout/blocks/post-preview' );
				echo "\n</{$el}>";
			} else {
				echo "\n";
				get_template_part( 'templates/parts/layout/blocks/post-preview' );
			}
		}
		$out = ob_get_contents();
		ob_end_clean();
	}

	// Output content and kill the function.
	wp_die( $out );
}
